<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 10/30/14
 * Time: 2:04 PM
 */

namespace Monolist\Bundle\WatcherBundle\Model\Services;


abstract class ServiceAbstract {

	/**
	 * Relative path to the single metric config folder
	 */
	const SINGLE_METRICS_CONFIG_PATH = '/Metrics/SingleMetric/config';

	/**
	 * Relative path to the service config
	 */
	const CONFIG_FILE_PATH = '/config/config.yml';

	/**
	 * Config for the Service
	 *
	 * @var array
	 */
	protected $config;

	/**
	 * @return string
	 */
	public function getDir()
	{
		return __DIR__;
	}

	/**
	 * Returns the path to the configuration folder of single metrics.
	 *
	 * @return string
	 */
	public function getSingleMetricsConfigPath()
	{
		return $this->getDir() . self::SINGLE_METRICS_CONFIG_PATH;
	}

	/**
	 * @return bool
	 */
	public static function isEnabled()
	{
		return true;    //todo
	}
}