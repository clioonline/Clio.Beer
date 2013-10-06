<?php
namespace Clio\Beer\Command;

use Clio\Beer\Domain\Model\Brewery;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Cli\CommandController;

/**
 * Class BeerCommandController
 *
 * @package Clio\Beer\Command
 */
class BeerCommandController extends CommandController {

	/**
	 * @var \Clio\Beer\Domain\Repository\BreweryRepository
	 * @Flow\Inject
	 */
	protected $breweryRepository;

	/**
	 * Create a new brewery
	 *
	 * @param string $name
	 * @return void
	 */
	public function createBreweryCommand($name) {
		$this->outputLine('Creating new brewery ' . $name);
		$brewery = new Brewery();
		$brewery->setName($name);
		$this->breweryRepository->add($brewery);
	}

}
