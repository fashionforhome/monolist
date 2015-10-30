<?php
/**
 * This is the ..... [Description]
 *
 * @category Monolist
 * @package WatcherBundle
 *
 * @author Tino Stöckel <tino.stoeckel@fashionforhome.de>
 *
 * @copyright (c) 2014 by fashion4home GmbH <www.fashionforhome.de>
 * @license GPL-3.0
 * @license http://opensource.org/licenses/GPL-3.0 GNU GENERAL PUBLIC LICENSE
 *
 * @version 1.0.0
 *
 * Date: 23.10.2014
 * Time: 22:04
 */
namespace Monolist\Bundle\WatcherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

//for config load
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Finder\Finder;
use Aws\CloudWatch\CloudWatchClient;

use Monolist\Bundle\WatcherBundle\Model\Services\CloudWatch\CloudWatch;
use Monolist\Bundle\WatcherBundle\Entity\CloudWatch\CloudWatchUnHealthyHostCount as TestEntity;
use Monolist\Bundle\WatcherBundle\Model\Services\CloudWatch\Metrics\SingleMetric\Requestor\UnHealthyHostCountRequestor;
use Monolist\Bundle\WatcherBundle\Model\Collector\Metrics\SingleMetric\SingleMetricCollector;

//finally
use Monolist\Bundle\WatcherBundle\Model\Services\Loader;

class OverviewController extends Controller
{
	/**
	 * @Route("/", name="_overview")
	 * @Template()
	 */
	public function indexAction()
	{
		$arguments = array('container' => $this->container);
		$serviceLoader = new Loader($arguments);
		$services = $serviceLoader->getServices();
		$reports = array();
		$singleReports = array();
		$groupReports = array();

		$singleReports = array();
		foreach($services as $service) {
			$metricConfigs = $service->getSingleMetricMergedConfigs();
			$metricNames = array_keys($metricConfigs);
			$serviceName = $service->getName();
			$fullMetricNames = array_map(function($metricNam) use($serviceName) { return $serviceName . $metricNam;} , $metricNames);
			$singleReports = array_merge($singleReports, $fullMetricNames);
		}

		$groupReportConfig = $serviceLoader->getReportGroupConfig();
		$groupReports = array_keys($groupReportConfig);

		$reports['single'] = $singleReports;
		$reports['groups'] = $groupReports;

//		var_dump($reports);die;

		return $this->render('MonolistWatcherBundle:Default:overview.html.php', array('name' => 'Overview', 'reports' => $reports));
	}

	/**
	 * @Route("/hello/{name}", name="_overview_hello")
	 * @Template()
	 */
	public function helloAction($name)
	{
		/** @var \Doctrine\DBAL\Connection $conn */
		$conn = $this->get('database_connection');

		$statement = $conn->prepare('SELECT * FROM CloudWatchUnHealthyHostCount');
		$statement->execute();

//		$sql = 'SELECT * FROM ? WHERE identifier = ?';
//		$sql = 'SELECT * FROM  CloudWatchUnHealthyHostCount WHERE identifier = ?';
//		$sql = 'SELECT * FROM  :table WHERE identifier = :identifier';
//		$sql = "SELECT * FROM  CloudWatchUnHealthyHostCount WHERE identifier = 't'";
		$replacement = array('CloudWatchUnHealthyHostCount', 't');
		$table = 'CloudWatchUnHealthyHostCount';
		$sql = 'SELECT * FROM ' . $table .' WHERE identifier = ?';
		$identifier = 't';
		$statement = $conn->prepare($sql);;
		$statement->bindValue('1', $identifier);

		$statement->execute();
		$dbResult = $statement->fetchAll();
		var_dump($dbResult);
		die;


		$coll = new SingleMetricCollector(array());
		$req = new UnHealthyHostCountRequestor;
//		var_dump(array('now' => strtotime('now'), '10Back'=> strtotime('-10 min')));
		var_dump( $req->requestValue($coll) );
		die;

		$cloudWatchService = new CloudWatch( array('container' => $this->container) );
		$cloudWatchService->collectAndSaveSingleMetrics();

		var_dump('All is save');

		die;

		return $this->render('MonolistWatcherBundle:Default:index.html.twig', array('name' => $name));
	}
}
