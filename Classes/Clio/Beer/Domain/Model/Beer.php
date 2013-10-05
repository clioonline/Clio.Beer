<?php
namespace Clio\Beer\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Clio.Beer".             *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use TYPO3\Flow\Session\SessionInterface;
use TYPO3\Flow\Tests\Object\Fixture\SomeInterface;

/**
 * @Flow\Entity
 */
class Beer {

	/**
	 * @var string
	 */
	protected $name;

	/*
	 * @var float
	 */
	protected $alcoholByVolume;

	/**
	 * @param float $alcoholByVolume
	 * @return void
	 */
	public function setAlcoholByVolume($alcoholByVolume) {
		$this->alcoholByVolume = $alcoholByVolume;
	}

	/**
	 * @return float
	 */
	public function getAlcoholByVolume() {
		return $this->alcoholByVolume;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

}