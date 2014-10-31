<?php

namespace Monolist\Bundle\WatcherBundle\Model\Collector\Metrics\SingleMetric;

/**
 * Class CollectEntityHandlerInterface
 *
 * @package Monolist\Bundle\WatcherBundle\Model\Collector
 */
interface MetricEntityHandlerInterface {

	/**
	 * @param CollectorAccessInterface $collectorAccessInterface
	 * @return mixed
	 */
	public function saveCollectedData(CollectorAccessInterface $collectorAccessInterface);

} 