<?php

namespace Monolist\Bundle\WatcherBundle\Model\Services\CloudWatch;

use Monolist\Bundle\WatcherBundle\Model\Services\ServiceAbstract;

/**
 * Class CloudWatch
 *
 * @package Monolist\Bundle\WatcherBundle\Model\Service\CloudWatch
 */
class CloudWatch extends ServiceAbstract
{


	/**
	 * @return string
	 */
	public function getDir()
	{
		return __DIR__;
	}

}