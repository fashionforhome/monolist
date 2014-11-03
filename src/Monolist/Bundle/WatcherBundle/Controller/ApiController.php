<?php

namespace Monolist\Bundle\WatcherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Monolist\Bundle\WatcherBundle\Model\Services\Loader;

class ApiController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MonolistWatcherBundle:Default:index.html.twig', array('name' => $name));
    }

	/**
	 * @Route("/metric/single/{metricName}", name="_metric_single")
	 * @Template()
	 */
	public function getMetricSingleAction($metricName)
	{
		$serviceLoader = new Loader();
		$services = $serviceLoader->getServices();

		$currentService = null;
		$singleMetricName = '';
		foreach ($services as $service) {
			if (strpos($metricName, $service->getName()) !== false) {
				$singleMetricName = str_replace($service->getName(), '', $metricName);
				$currentService = $service;
			}
		}

		$serviceConfig = $currentService->getSingleMetricMergedConfigs();
		$metricConfig = $serviceConfig[$singleMetricName];

		/** @var \Doctrine\DBAL\Connection $conn */
		$conn = $this->get('database_connection');

		$finalResult = array();
		foreach($metricConfig['identifier'] as $identifier) {
			$sql = 'SELECT * FROM ' . $metricName .' WHERE identifier = ? AND timestamp > UNIX_TIMESTAMP(DATE(NOW()-INTERVAL 3 DAY))'; //UNIX_TIMESTAMP(DATE(NOW()-INTERVAL 3 DAY))
			$statement = $conn->prepare($sql);;
			$statement->bindValue(1, $identifier);

			$statement->execute();
			$dbResult = $statement->fetchAll();

			$overWork = array();
			foreach ($dbResult as $result) {
				$time = $result['timestamp'];
				$overWork[] = array($time, $result['value']);
			}

			$finalResult[] = array('data' => $overWork, 'label' => $identifier);
		}

		return new JsonResponse($finalResult);
	}
}
