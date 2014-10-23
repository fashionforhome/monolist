<?php
// src/Monolist/Bundle/WatcherBundle/Entity/WatcherUser.php
namespace Monolist\Bundle\WatcherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="T_watcher_user")
 */
class WatcherUser
{
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string", length=255, unique=true)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=255)
	 */
	protected $password_hash;

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
	 * Set name
	 *
	 * @param string $name
	 * @return WatcherUser
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set password_hash
	 *
	 * @param string $passwordHash
	 * @return WatcherUser
	 */
	public function setPasswordHash($passwordHash)
	{
		$this->password_hash = $passwordHash;

		return $this;
	}

	/**
	 * Get password_hash
	 *
	 * @return string
	 */
	public function getPasswordHash()
	{
		return $this->password_hash;
	}
}
