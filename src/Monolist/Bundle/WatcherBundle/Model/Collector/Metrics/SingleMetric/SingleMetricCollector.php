<?php

namespace Monolist\Bundle\WatcherBundle\Model\Collector\Metrics\SingleMetric;

use Monolist\Bundle\WatcherBundle\Model\Requestor\Metrics\SingleMetric\RequestorInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class SingleMetricCollector
 *
 * @package Monolist\Bundle\WatcherBundle\Model\Collector
 */
class SingleMetricCollector implements CollectorAccessInterface
{
	/**
	 * @var MetricEntityHandlerInterface
	 */
	protected $dbEntity;

	/**
	 * @var array
	 */
	protected $metricIdentifier;

	/**
	 * @var RequestorInterface
	 */
	protected $valueRequestor;

	/**
	 * @var int
	 */
	protected $metricValue;

	/**
	 * @var int
	 */
	protected $timestamp;

	/**
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		//TODO: isset and instanceof check for $data array, maybe in setter, maybe build a collectorConfig object including a validate function
		if (empty($data)) {
			return;
		}

		$this->setValueRequestor($data['requestor']);
		$this->setMetricIdentifier($data['identifier']);
		$this->setDbEntity($data['dbEntity']);
	}


	/**
	 * @return void
	 */
	public function save()
	{
		$timestamp = $this->getTimestamp();
		if (empty($timestamp) === true) {
			throw new Exception('You need to collect data before try to save.');
		}

		$dbEntity = $this->getDbEntity();
		$dbEntity->saveCollectedData($this);
	}

	/**
	 * Collects data depending on the config and the requestor.
	 */
	public function collectData()
	{
		$valueRequestor = $this->getValueRequestor();
		$requestValue = $valueRequestor->requestValue($this);
		$this->setMetricValue($requestValue);
		$this->setTimestamp(time());
	}

	/**
	 * @return array
	 */
	public function  getMetric()
	{
		$metric = array();

		$metric['identifier'] = $this->getMetricIdentifier();
		$metric['timestamp'] = $this->getTimestamp();
		$metric['value'] = $this->getMetricValue();

		return $metric;
	}

	//#############################################################
	/**
	 * ------------------------------
	 * Setter & Getter area
	 * ------------------------------
	 */
	//#############################################################

	/**
	 * @param MetricEntityHandlerInterface $dbEntity
	 */
	public function setDbEntity(MetricEntityHandlerInterface $dbEntity)
	{
		$this->dbEntity = $dbEntity;
	}

	/**
	 * @return MetricEntityHandlerInterface
	 */
	public function getDbEntity()
	{
		return $this->dbEntity;
	}

	/**
	 * @param string $identifier
	 */
	public function setMetricIdentifier($identifier)
	{
		$this->metricIdentifier = $identifier;
	}

	/**
	 * @return array
	 */
	public function getMetricIdentifier()
	{
		return $this->metricIdentifier;
	}

	/**
	 * @param int $value
	 */
	public function setMetricValue($value)
	{
		$this->metricValue = $value;
	}

	/**
	 * @return int
	 */
	public function getMetricValue()
	{
		return $this->metricValue;
	}

	/**
	 * @param RequestorInterface $requestor
	 */
	public function setValueRequestor(RequestorInterface $requestor)
	{
		$this->valueRequestor = $requestor;
	}

	/**
	 * @return RequestorInterface
	 */
	public function getValueRequestor()
	{
		return $this->valueRequestor;
	}

	/**
	 * @param int $timestamp
	 */
	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}

	/**
	 * @return int
	 */
	public function  getTimestamp()
	{
		return $this->timestamp;
	}
}