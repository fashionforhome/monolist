<?php

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

class OverviewController extends Controller
{
	/**
	 * @Route("/", name="_overview")
	 * @Template()
	 */
	public function indexAction()
	{
		//app/config/config.yml::parameters.aws
		$awsConfig = $this->container->getParameter('aws');
		//var_dump($awsConfig['user_id']);die;
		//aws stuff
		$client = CloudWatchClient::factory(array(
			'key'    => $awsConfig['access_key'],           //'YOUR_AWS_ACCESS_KEY_ID',
			'secret' => $awsConfig['secret_key'],           //'YOUR_AWS_SECRET_ACCESS_KEY',
			'region'  => 'eu-west-1',
		));
		$result = $client->listMetrics(array(
			'Namespace' => 'AWS/ELB',
			'MetricName' => 'UnHealthyHostCount',
//			'Dimensions' => array(
//				array(
//					// Name is required
//					'Name' => 'string',
//					'Value' => 'string',
//				),
//				// ... repeated
//			),
//			'NextToken' => 'string',
		));
//		var_dump($result);die;
//		$iterator = $client->getIterator('ListMetrics', array(
//			'Namespace' => 'AWS/ELB'
//		));
//		foreach ($iterator as $metric) {
//			echo $metric['MetricName'];
//			echo '<br />';
//			echo '<br />';
//			var_dump($metric);
//			echo '<br />';
//			echo '<br />';
//		} die;


		//app/config/
		$collectsConfig = $this->container->getParameter('collects');
		$first = array_pop( $collectsConfig );
		var_dump(new $first['requestor_class']); die;

		return $this->render('MonolistWatcherBundle:Default:index.html.twig', array('name' => $this->container->getParameter('aws') . ' overview!'));
	}

	/**
	 * @Route("/hello/{name}", name="_overview_hello")
	 * @Template()
	 */
	public function helloAction($name)
	{

		$cloudWatchService = new CloudWatch( array('container' => $this->container) );
		$cloudWatchService->collectAndSaveSingleMetrics();

		var_dump('All is save');

		die;

		return $this->render('MonolistWatcherBundle:Default:index.html.twig', array('name' => $name));
	}
}
