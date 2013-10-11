<?php
namespace Clio\Beer\Controller;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Message;

/**
 * Class AuthenticationController
 *
 * @Flow\Scope("singleton")
 */
class AuthenticationController extends \TYPO3\Flow\Security\Authentication\Controller\AbstractAuthenticationController {

	/**
	 * Override the loginAction of the abstract controller in order to add the account to the view.
	 *
	 * @return void
	 */
	public function loginAction() {
		$this->view->assign('account', $this->securityContext->getAccount());
	}

	/**
	 * Is called if authentication was successful. If there has been an
	 * intercepted request due to security restrictions, you might want to use
	 * something like the following code to restart the originally intercepted
	 * request:
	 *
	 * if ($originalRequest !== NULL) {
	 *     $this->redirectToRequest($originalRequest);
	 * }
	 * $this->redirect('someDefaultActionAfterLogin');
	 *
	 * @param \TYPO3\Flow\Mvc\ActionRequest $originalRequest The request that was intercepted by the security framework, NULL if there was none
	 * @return string
	 */
	protected function onAuthenticationSuccess(\TYPO3\Flow\Mvc\ActionRequest $originalRequest = NULL) {
		if ($originalRequest !== NULL) {
			$this->redirectToRequest($originalRequest);
		}
		$this->redirect('index', 'Beer');
	}

	/**
	 * Logs all active tokens out. Override this, if you want to
	 * have some custom action here. You can always call the parent
	 * method to do the actual logout.
	 *
	 * @return void
	 */
	public function logoutAction() {
		parent::logoutAction();
		$this->flashMessageContainer->addMessage(
			new Message('You have logged out succesfully')
		);
		$this->redirect('login');
	}
}