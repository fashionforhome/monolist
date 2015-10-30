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

namespace Monolist\Bundle\WatcherBundle\Model\Requestor\Metrics\SingleMetric;

use Monolist\Bundle\WatcherBundle\Model\Collector\Metrics\SingleMetric\CollectorAccessInterface;

interface RequestorInterface {

	/**
	 * @return int
	 */
	public function requestValue(CollectorAccessInterface $collector);
} 