<?php

namespace Monolist\Bundle\WatcherBundle\Model\Service\CloudWatch\Metrics\SingleMetric\Requestor;

//Interfaces
use Monolist\Bundle\WatcherBundle\Model\Requestor\Metrics\SingleMetric\RequestorInterface;

//Components
use Aws\CloudWatch\CloudWatchClient;

/**
 * Class AwsUnHealthyHostCount
 *
 * @package Monolist\Bundle\WatcherBundle\Model\Service\CloudWatch\Metrics\SingleMetric\Requestor
 */
class AwsUnHealthyHostCount implements RequestorInterface {

	/**
	 * @return int
	 */
	public function requestValue()
	{
		// TODO: Implement requestValue() method.
		return 0; #standard dummy value
	}
}