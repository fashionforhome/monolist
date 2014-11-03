<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 10/29/14
 * Time: 2:24 PM
 */

namespace Monolist\Bundle\WatcherBundle\Model\Requestor\Metrics\SingleMetric;

use Monolist\Bundle\WatcherBundle\Model\Collector\Metrics\SingleMetric\CollectorAccessInterface;

interface RequestorInterface {

	/**
	 * @return int
	 */
	public function requestValue(CollectorAccessInterface $collector);
} 