<?php

namespace Monolist\Bundle\WatcherBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MonolistWatcherBundle extends Bundle
{

	private static $containerInstance = null;

	public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
	{
		parent::setContainer($container);
		self::$containerInstance = $container;
	}

	/**
	 * @return \Symfony\Component\DependencyInjection\ContainerInterface
	 */
	public static function getContainer()
	{
		return self::$containerInstance;
	}

}
