<?php
namespace Clio\Beer\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Clio.Beer".             *
 *                                                                        *
 *                                                                        */

use Doctrine\Common\Collections\ArrayCollection;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A brewery
 *
 * @Flow\Entity
 */
class Brewery {

	/**
	 * Beers brewed by this brewery
	 *
	 * @var \Doctrine\Common\Collections\ArrayCollection<\Clio\Beer\Domain\Model\Beer>
	 * @ORM\OneToMany(mappedBy="brewery")
	 */
	protected $beers;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 *
	 */
	public function __construct() {
		$this->beers = new ArrayCollection();
	}

	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection $beers
	 * @return void
	 */
	public function setBeers($beers) {
		$this->beers = $beers;
	}

	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getBeers() {
		return $this->beers;
	}

	/**
	 * @param Beer $beer
	 * @return void
	 */
	public function addBeer(Beer $beer) {
		$this->beers->add($beer);
	}

	/**
	 * @param mixed $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getName() {
		return $this->name;
	}

}