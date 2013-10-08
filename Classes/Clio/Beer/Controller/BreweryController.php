<?php
namespace Clio\Beer\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Clio.Beer".             *
 *                                                                        *
 *                                                                        */

use Clio\Beer\Domain\Model\Brewery;
use TYPO3\Flow\Annotations as Flow;

class BreweryController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @var \Clio\Beer\Domain\Repository\BreweryRepository
	 * @Flow\Inject
	 */
	protected $breweryRepository;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('breweries', $this->breweryRepository->findAll());
	}

	/**
	 * @param \Clio\Beer\Domain\Model\Brewery $brewery
	 */
	public function showAction(Brewery $brewery) {
		$this->view->assign('brewery', $brewery);
	}

}

?>