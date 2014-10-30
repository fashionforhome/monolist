<?php

namespace Monolist\Bundle\WatcherBundle\Model\Collector;

use Monolist\Bundle\WatcherBundle\Model\Requestor\RequestorInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class SingleValueCollector
 *
 * @package Monolist\Bundle\WatcherBundle\Model\Collector
 */
class SingleValueCollector implements CollectorAccessInterface
{
	/**
	 * @var CollectEntityHandlerInterface
	 */
	protected $dbEntity;

	/**
	 * @var array
	 */
	protected $collectConfig;

	/**
	 * @var RequestorInterface
	 */
	protected $valueRequestor;

	/**
	 * @var int
	 */
	protected $collectValue;

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

		$this->setValueRequestor($data['valueRequestor']);
		$this->setCollectConfig($data['collectConfig']);
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
		$requestValue = $valueRequestor->requestValue();
		$this->setCollectValue($requestValue);
		$this->setTimestamp(time());
	}

	/**
	 * @return array
	 */
	public function  getCollect()
	{
		$collect = array();
		$collectConfig = $this->getCollectConfig();

		$collect['identifier'] = $collectConfig['identifier'];
		$collect['timestamp'] = $this->getTimestamp();
		$collect['value'] = $this->getCollectValue();

		return $collect;
	}

	//#############################################################
	/**
	 * ------------------------------
	 * Setter & Getter area
	 * ------------------------------
	 */
	//#############################################################

	/**
	 * @param CollectEntityHandlerInterface $dbEntity
	 */
	public function setDbEntity(CollectEntityHandlerInterface $dbEntity)
	{
		$this->dbEntity = $dbEntity;
	}

	/**
	 * @return CollectEntityHandlerInterface
	 */
	public function getDbEntity()
	{
		return $this->dbEntity;
	}

	/**
	 * @param array $config
	 */
	public function setCollectConfig(array $config)
	{
		$this->collectConfig = $config;
	}

	/**
	 * @return array
	 */
	public function getCollectConfig()
	{
		return $this->collectConfig;
	}

	/**
	 * @param int $value
	 */
	public function setCollectValue($value)
	{
		$this->collectValue = $value;
	}

	/**
	 * @return int
	 */
	public function getCollectValue()
	{
		return $this->collectValue;
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