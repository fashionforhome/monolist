<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 10/30/14
 * Time: 2:04 PM
 */

namespace Monolist\Bundle\WatcherBundle\Model\Services;

//for config load
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Finder\Finder;

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
	 * Class constructor
	 */
	public function __construct()
	{
		$this->init();
	}

	/**
	 * This init is called by construction.
	 */
	public function init()
	{
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
}