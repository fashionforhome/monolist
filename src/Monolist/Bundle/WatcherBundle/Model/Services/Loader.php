<?php

namespace Monolist\Bundle\WatcherBundle\Model\Services;

//services
use Monolist\Bundle\WatcherBundle\Model\Services\CloudWatch\CloudWatch;

//for config load
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Finder\Finder;

/**
 * Class Loader
 *
 * @package Monolist\Bundle\WatcherBundle\Model\Service
 */
class Loader {

	/**
	 * Relative path to the single metric config folder
	 */
	const REPORT_GROUP_CONFIG_PATH = '/config/groups.yml';

	/**
	 * @var ServiceAbstract[]
	 */
	protected $services = array();

	/**
	 * @param array $arguments
	 */
	public function __construct($arguments = array())
	{
		$this->init($arguments);
	}

	/**
	 * @param array $arguments
	 */
	public function init($arguments = array())
	{
		//here is the place to register new services
		$this->registerService(new CloudWatch($arguments));
	}

	/**
	 * @return string
	 */
	public function getDir()
	{
		return __DIR__;
	}

	/**
	 * @return string
	 */
	public function getReportGroupConfigDir()
	{
		return $this->getDir() . self::REPORT_GROUP_CONFIG_PATH;
	}

	/**
	 * Returns the config for report groups
	 */
	public function getReportGroupConfig()
	{
		$reportGroupConfig = array();

		$yamlParser = new Parser();
		$reportGroupConfigPath = $this->getReportGroupConfigDir();

		if (file_exists($reportGroupConfigPath) === false) {
			return $reportGroupConfig;
		}

		$reportGroupConfig = $yamlParser->parse(file_get_contents($reportGroupConfigPath));
		return $reportGroupConfig;
	}

	/**
	 * Adds a service to the loader.
	 *
	 * @param ServiceAbstract $service
	 */
	public function registerService(ServiceAbstract $service)
	{
		$this->services[] = $service;
	}

	/**
	 * Returns an array with all registered services
	 *
	 * @return ServiceAbstract[]
	 */
	public function getServices()
	{
		return $this->services;
	}

	public function getServiceNames()
	{
		$serviceNames = array();
		foreach ($this->getServices() as $service) {
			$serviceNames[] = $service->getName();
		}

		return $serviceNames;
	}
} 