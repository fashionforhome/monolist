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
namespace Monolist\Bundle\WatcherBundle\Model\Services\CloudWatch\Metrics\SingleMetric\Requestor;

//Interfaces
use Monolist\Bundle\WatcherBundle\Model\Collector\Metrics\SingleMetric\CollectorAccessInterface;
use Monolist\Bundle\WatcherBundle\Model\Requestor\Metrics\SingleMetric\RequestorInterface;

//Components
use Aws\CloudWatch\CloudWatchClient;
use Monolist\Bundle\WatcherBundle\MonolistWatcherBundle;

class UnHealthyHostCountRequestor implements RequestorInterface {

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
			'MetricName' => 'UnHealthyHostCount', //UnHealthyHostCount //Latency
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