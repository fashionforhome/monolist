<?php
namespace Monolist\Bundle\WatcherBundle\Entity\CloudWatch;

use Doctrine\ORM\Mapping as ORM;

use Monolist\Bundle\WatcherBundle\Entity\SingleMetricEntityAbstract;

/**
 * @ORM\Entity
 */
class CloudWatchUnHealthyHostCount extends SingleMetricEntityAbstract
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $identifier;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $timestamp;

	/**
	 * @ORM\Column(type="integer")
	 */
	protected $value;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set identifier
     *
     * @param string $identifier
     * @return $this
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
     * @return this
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
}
