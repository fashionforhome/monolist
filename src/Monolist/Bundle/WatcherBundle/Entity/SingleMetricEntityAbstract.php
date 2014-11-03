<?php
namespace Monolist\Bundle\WatcherBundle\Entity;

//use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use Monolist\Bundle\WatcherBundle\MonolistWatcherBundle;
use Monolist\Bundle\WatcherBundle\Model\Collector\Metrics\SingleMetric\CollectorAccessInterface;
use Monolist\Bundle\WatcherBundle\Model\Collector\Metrics\SingleMetric\MetricEntityHandlerInterface;

/**
 * Class SingleMetricEntityAbstract
 *
 * @package Monolist\Bundle\WatcherBundle\Entity
 */
abstract class SingleMetricEntityAbstract implements MetricEntityHandlerInterface
{
	/**
	 * Meta container
	 * @var
	 */
	protected $container;

	/**
	 * overwrite in child
	 */
	protected $identifier;

	/**
	 * overwrite in child
	 */
	protected $timestamp;

	/**
	 * overwrite in child
	 */
	protected $value;

	/**
	 * Set identifier
	 *
	 * @param string $identifier
	 * @return string
	 */
	public function setIdentifier($identifier)
	{
		$this->identifier = $identifier;

		return $this;
	}

	/**
	 * Get identifier
	 *
	 * @return string
	 */
	public function getIdentifier()
	{
		return $this->identifier;
	}

	/**
	 * Set timestamp
	 *
	 * @param integer $timestamp
	 * @return $this
	 */
	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;

		return $this;
	}

	/**
	 * Get timestamp
	 *
	 * @return integer
	 */
	public function getTimestamp()
	{
		return $this->timestamp;
	}

	/**
	 * Set value
	 *
	 * @param integer $value
	 * @return DefaultCollect
	 */
	public function setValue($value)
	{
		$this->value = $value;

		return $this;
	}

	/**
	 * Get value
	 *
	 * @return integer
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param $container
	 */
	public function setContainer($container)
	{
		if (empty($container)) {
			throw new InvalidArgumentException('No container was passed.');
		}
		$this->container = $container;
	}

	/**
	 * @return mixed
	 */
	public function getContainer()
	{
		return $this->container;
	}

	/**
	 * Save collected data into db.
	 *
	 * @param CollectorAccessInterface $collectorAccessInterface
	 * @return mixed
	 */
	public function saveCollectedData(CollectorAccessInterface $collectorAccessInterface)
	{
		$metric = $collectorAccessInterface->getMetric();

		$this->setIdentifier($metric['identifier']);
		$this->setTimestamp($metric['timestamp']);
		$this->setValue($metric['value']);

		$this->save();
	}

	/**
	 * Save the entity to db
	 *
	 * @return void
	 */
	public function save()
	{
		$container = MonolistWatcherBundle::getContainer();
		/** @var \Doctrine\Bundle\DoctrineBundle\Registry $doct */
		$doct = $container->get('doctrine');
		$em = $doct->getManager();
		$em->persist($this);
		$em->flush();
	}
}