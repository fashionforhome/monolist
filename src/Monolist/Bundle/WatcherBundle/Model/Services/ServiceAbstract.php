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

namespace Monolist\Bundle\WatcherBundle\Model\Services;

//for config load
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Finder\Finder;

use Monolist\Bundle\WatcherBundle\Model\Collector\Metrics\SingleMetric\SingleMetricCollector;

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
	 * Meta container
	 * @var
	 */
	protected $container;

	/**
	 * Class constructor
	 *
	 * @param array $arguments
	 */
	public function __construct($arguments = array())
	{
		$this->init($arguments);
	}

	/**
	 * This init is called by construction.
	 *
	 * @param $arguments
	 */
	public function init($arguments = array())
	{
		if (empty($arguments) === false) {
			$this->setContainer($arguments['container']);
		}

		$this->loadConfig();
	}

	/**
	 * Load and set the config for the service.
	 *
	 * @return void
	 */
	protected function loadConfig()
	{
		$defaultConfig = array();

		$yamlParser = new Parser();
		$configPath = $this->getConfigPath();

		if (file_exists($configPath) === false) {
			$this->setConfig($defaultConfig);
			return;
		}

		$config = $yamlParser->parse(file_get_contents($configPath));

		$this->setConfig((is_array($config)) ? $config : $defaultConfig);
	}

	/**
	 * @return string
	 */
	public function getConfigPath()
	{
		return $this->getDir() . self::CONFIG_FILE_PATH;
	}

	/**
	 * @return string
	 */
	public abstract  function getDir();

	/**
	 * Returns the name of the service.
	 *
	 * @return string
	 */
	public function getName()
	{
		$reflection = new \ReflectionClass($this);
		return $reflection->getShortName(); //also nice but slower solution is "basename(get_class($object));"
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
	 * Return is the service enabled.
	 *
	 * Per default it's false.
	 *
	 * Can be activated in the service config.yml
	 * e.g. Services/CloudWatch/config/config.yml
	 * enabled: true
	 *
	 * @return bool
	 */
	public function isEnabled()
	{
		$isEnabled = false;
		$config = $this->getConfig();

		if (isset($config['enabled'])) {
			$isEnabled = filter_var($config['enabled'], FILTER_VALIDATE_BOOLEAN);
		}

		return $isEnabled;
	}

	/**
	 * Returns all single metric collectors
	 *
	 * @return array
	 */
	public function getSingleMetricCollectors()
	{
		$singleMetricMergedConfigs = $this->getSingleMetricMergedConfigs();
		$singleMetricCollectors = array();

		foreach($singleMetricMergedConfigs as $singleMetricConfig) {
			foreach ($singleMetricConfig['identifier'] as $singleIdentifier) {
				$collectorConfig = array();

				//set the requestor
				$requestorNamespace = __NAMESPACE__ . $singleMetricConfig['requestor_class'];
				$collectorConfig['requestor'] = new $requestorNamespace;

				//set metric identifier
				$collectorConfig['identifier'] = $singleIdentifier;

				//set dbEntity
				$dbEntityNamespace = $singleMetricConfig['entity_class'];
				/** @var \Monolist\Bundle\WatcherBundle\Entity\SingleMetricEntityAbstract $dbEntity */
				$dbEntity = new $dbEntityNamespace;
				$collectorConfig['dbEntity'] = $dbEntity;

				$singleMetricCollectors[] = new SingleMetricCollector($collectorConfig);
			}

		}

		return $singleMetricCollectors;
	}

	/**
	 * Returns the merged config of all config files.
	 *
	 * @return array
	 */
	public function getSingleMetricMergedConfigs()
	{
		$singleMetricsConfigPath = $this->getSingleMetricsConfigPath();
		$yamlParser = new Parser();
		$finder = new Finder();
		$singleMetricsMergedConfig = array();

		$finder->files()->in($singleMetricsConfigPath);
		/** @var \Symfony\Component\Finder\SplFileInfo $file */
		foreach ($finder as $file) {
			$singleConfig = $yamlParser->parse(file_get_contents($file->getRealpath()));

			$singleMetricsMergedConfig = array_merge($singleMetricsMergedConfig, $singleConfig);
		}

		return $singleMetricsMergedConfig;
	}

	public function collectAndSaveSingleMetrics()
	{
		$singleMetricCollectors = $this->getSingleMetricCollectors();
		/** @var \Monolist\Bundle\WatcherBundle\Model\Collector\Metrics\SingleMetric\SingleMetricCollector $collector */
		foreach ($singleMetricCollectors as $collector) {
			$collector->collectData();
			$collector->save();
		}
	}

	/**
	 * #####################
	 * Setter/Getter area
	 * #####################
	 */

	/**
	 * @param array $config
	 */
	public function setConfig(array $config)
	{
		$this->config = $config;
	}

	/**
	 * @return array
	 */
	public function getConfig()
	{
		return $this->config;
	}

	/**
	 * @param $container
	 */
	public function setContainer($container)
	{
		$this->container = $container;
	}

	/**
	 * @return mixed
	 */
	public function getContainer()
	{
		return $this->container;
	}
}