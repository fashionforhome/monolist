<?php

namespace Monolist\Bundle\WatcherBundle\Model\Collector\Metrics\SingleMetric;

/**
 * Class CollectEntityHandlerInterface
 *
 * @package Monolist\Bundle\WatcherBundle\Model\Collector
 */
interface CollectEntityHandlerInterface {

	/**
	 * @param CollectorAccessInterface $collectorAccessInterface
	 * @return mixed
	 */
	public function saveCollectedData(CollectorAccessInterface $collectorAccessInterface);

} 