<?php

namespace Monolist\Bundle\WatcherBundle\Model\Services\CloudWatch\Metrics\SingleMetric\Requestor;

//Interfaces
use Monolist\Bundle\WatcherBundle\Model\Collector\Metrics\SingleMetric\CollectorAccessInterface;
use Monolist\Bundle\WatcherBundle\Model\Requestor\Metrics\SingleMetric\RequestorInterface;

//Components
use Aws\CloudWatch\CloudWatchClient;
use Monolist\Bundle\WatcherBundle\MonolistWatcherBundle;

/**
 * Class AwsUnHealthyHostCount
 *
 * @package Monolist\Bundle\WatcherBundle\Model\Service\CloudWatch\Metrics\SingleMetric\Requestor
 */
class LatencyRequestor implements RequestorInterface {

	/**
	 * @param CollectorAccessInterface $collector
	 * @return int
	 */
	public function requestValue(CollectorAccessInterface $collector)
	{
		$metric = $collector->getMetric();
		$identifier = isset($metric['identifier']) ? $metric['identifier'] : null;

		$container = MonolistWatcherBundle::getContainer();
		$awsConfig = $container->getParameter('aws');

		if($awsConfig['enabled'] == false) {
			return null; //TODO write to log or handle it on another way
		}

		$client = CloudWatchClient::factory(array(
			'key'    => $awsConfig['access_key'],           //'YOUR_AWS_ACCESS_KEY_ID',
			'secret' => $awsConfig['secret_key'],           //'YOUR_AWS_SECRET_ACCESS_KEY',
			'region'  => 'eu-west-1',
		));

		$result = $client->getMetricStatistics(array(
			'Namespace'  => 'AWS/ELB',
			'MetricName' => 'Latency', //UnHealthyHostCount //Latency
			'Dimensions' => array(
				array(
				// Name is required
					'Name' => 'LoadBalancerName', //LoadBalancerName
					'Value' => $identifier,		//'Value' => 't',
				),
			),
			'StartTime'  => strtotime('-2 min'),
			'EndTime'    => strtotime('now'),
			'Period'     => 60,
			'Statistics' => array('Maximum', 'Minimum'),
		));

		$resultArray = $result->get('Datapoints');

		$lastResult = empty($resultArray) ? null : array_pop($resultArray
		);

		return intval($lastResult['Maximum']);
	}
}