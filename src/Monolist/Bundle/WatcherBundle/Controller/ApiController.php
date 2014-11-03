<?php

namespace Monolist\Bundle\WatcherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

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
		/** @var \Doctrine\DBAL\Connection $conn */
		$conn = $this->get('database_connection');

		$sql = 'SELECT * FROM ' . $metricName .' WHERE identifier = ?';
		$identifier = 't';
		$statement = $conn->prepare($sql);;
		$statement->bindValue('1', $identifier);

		$statement->execute();
		$dbResult = $statement->fetchAll();

		$overWork = array();
		foreach ($dbResult as $result) {
			$overWork[] = array($result['timestamp'], $result['value']);
		}

		return new JsonResponse($overWork);
//		return new JsonResponse(array('metricName' => $metricName));
	}
}
