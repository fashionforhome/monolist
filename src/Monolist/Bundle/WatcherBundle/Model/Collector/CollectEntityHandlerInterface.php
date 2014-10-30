<?php

namespace Monolist\Bundle\WatcherBundle\Model\Collector;

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