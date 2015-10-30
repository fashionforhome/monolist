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
 * Date: 21.10.2014
 * Time: 22:04
 */
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
