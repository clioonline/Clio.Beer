<?php
namespace Clio\Beer\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Clio.Beer".             *
 *                                                                        *
 *                                                                        */

use Clio\Beer\Domain\Model\Brewery;
use Clio\Beer\Domain\Repository\BeerRepository;
use TYPO3\Flow\Annotations as Flow;
use Clio\Beer\Domain\Model\Beer;
use TYPO3\Flow\Persistence\Doctrine\PersistenceManager;

class BeerController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @var \Clio\Beer\Domain\Repository\BeerRepository
	 * @Flow\Inject
	 */
	protected $beerRepository;

	/**
	 * @var \Clio\Beer\Domain\Repository\BreweryRepository
	 * @Flow\Inject
	 */
	protected $breweryRepository;

	/**
	 * @var \TYPO3\Flow\Persistence\Doctrine\PersistenceManager
	 * @Flow\Inject
	 */
	protected $persistenceManager;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('beers', $this->beerRepository->findAll());
		$brew = new Brewery();
		$brew->setName('Heineken');
		foreach ($this->beerRepository->findAll() as $beer) {
			$beer->setBrewery($brew);
		}

		$this->persistenceManager->persistAll();
	}

	/**
	 * @param \Clio\Beer\Domain\Model\Beer $beer
	 */
	public function newAction(Beer $beer = NULL) {
		$this->view->assignMultiple(array(
			'beer' => $beer,
			'breweries' => $this->breweryRepository->findAll())
		);

	}

	/**
	 * @param \Clio\Beer\Domain\Model\Beer $beer
	 * @return void
	 */
	public function createAction(Beer $beer) {
		$this->beerRepository->add($beer);
		$this->addFlashMessage('Beer created', 'OK', \TYPO3\Flow\Error\Message::SEVERITY_OK);
		$this->redirect('index');
	}
	
}

?>