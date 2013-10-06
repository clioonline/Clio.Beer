<?php
namespace Clio\Beer\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Clio.Beer".             *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Beer {

	/**
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $name;

	/**
	 * @var float
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $alcoholByVolume;

	/**
	 * @var \Clio\Beer\Domain\Model\Brewery
	 * @ORM\ManyToOne(inversedBy="beers")
	 */
	protected $brewery;

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

	/**
	 * @param \Clio\Beer\Domain\Model\Brewery $brewery
	 * @return void
	 */
	public function setBrewery($brewery) {
		$this->brewery = $brewery;
	}

	/**
	 * @return \Clio\Beer\Domain\Model\Brewery
	 */
	public function getBrewery() {
		return $this->brewery;
	}

}