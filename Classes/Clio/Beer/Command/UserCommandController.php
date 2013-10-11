<?php
namespace Clio\Beer\Command;

use Clio\Beer\Domain\Model\Brewer;
use TYPO3\Flow\Annotations as Flow;

class UserCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * @var \TYPO3\Flow\Validation\ValidatorResolver
	 * @Flow\Inject
	 */
	protected $validatorResolver;

	/**
	 * @var \TYPO3\Flow\Persistence\Doctrine\PersistenceManager
	 * @Flow\Inject
	 */
	protected $persistenceManager;

	/**
	 * @Flow\Inject
	 * @var \Clio\Beer\Domain\Repository\BrewerRepository
	 */
	protected $brewerRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountFactory
	 */
	protected $accountFactory;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\Cryptography\HashService
	 */
	protected $hashService;

	/**
	 * Create a new user
	 *
	 * This command creates a new user which has access to the backend user interface.
	 * It is recommended to use the email address as a username.
	 *
	 * Notice that accounts must be linked to a brewer. So please use the createBrewer command to create brewer
	 * records first.
	 *
	 * @param string $username The username of the user to be created.
	 * @param string $password Password of the user to be created
	 * @param string $brewerName The name of the brewer to link this account to.
	 * @param string $roles A comma separated list of roles to assign Examples are Clio.Beer:Administrator og Clio.Beer:Brewer
	 * @param string $authenticationProvider The name of the authentication provider to use (Default is 'DefaultProvider)
	 * @return void
	 */
	public function createAccountCommand($username, $password, $brewerName, $roles, $authenticationProvider = 'DefaultProvider') {
		$validator = $this->validatorResolver->createValidator('Clio.Beer:UniqueAccount');
		$result = $validator->validate($username);
		if ($result->hasErrors()) {
			foreach ($result->getErrors() as $error) {
				$this->outputLine($error->getMessage());
			}
			$this->sendAndExit(2);
		}

		$brewer = $this->brewerRepository->findOneByName($brewerName);
		if ($brewer === NULL) {
			$this->outputLine('Unable to find brewer with name ' . $name);
			$this->sendAndExit(1);
		}
		$account = $this->accountFactory->createAccountWithPassword($username, $password, explode(',', $roles), $authenticationProvider);
		$account->setParty($brewer);
		$this->accountRepository->add($account);
		$this->outputLine('Created account "%s".', array($username));
		$this->persistenceManager->persistAll();
	}

	/**
	 * Create a new entry in the Brewer command
	 *
	 * @param string $name
	 * @Flow\Validate(argumentName="username", type="NotEmpty")
	 * @return void
	 */
	public function createBrewerCommand($name) {
		$validator = $this->validatorResolver->createValidator('Clio.Beer:UniqueBrewer');
		$result = $validator->validate($name);
		if ($result->hasErrors()) {
			foreach ($result->getErrors() as $error) {
				$this->outputLine($error->getMessage());
			}
			$this->sendAndExit(2);
		}
		$brewer = new Brewer();
		$brewer->setName($name);
		$this->brewerRepository->add($brewer);
		$this->outputLine('Create new brewer with name ' . $name);
		$this->persistenceManager->persistAll();

	}

	/**
	 * Set a new password for the given user
	 *
	 * This allows for setting a new password for an existing user account.
	 *
	 * @param string $username Username of the account to modify
	 * @param string $password The new password
	 * @param string $authenticationProvider The name of the authentication provider to use
	 *
	 * @return void
	 */
	public function setPasswordCommand($username, $password, $authenticationProvider = 'DefaultProvider') {
		$account = $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName($username, $authenticationProvider);
		if (!$account instanceof \TYPO3\Flow\Security\Account) {
			$this->outputLine('User "%s" does not exist.', array($username));
			$this->quit(1);
		}
		$account->setCredentialsSource($this->hashService->hashPassword($password, 'default'));
		$this->accountRepository->update($account);

		$this->outputLine('The new password for user "%s" was set.', array($username));
	}

	/**
	 * Add a role to a user
	 *
	 * This command allows for adding a specific role to an existing user.
	 * Currently supported roles: "Editor", "Administrator"
	 *
	 * @param string $username The username
	 * @param string $role Role ot be added to the user
	 * @param string $authenticationProvider The name of the authentication provider to use
	 *
	 * @return void
	 */
	public function addRoleCommand($username, $role, $authenticationProvider = 'DefaultProvider') {
		$account = $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName($username, $authenticationProvider);
		if (!$account instanceof \TYPO3\Flow\Security\Account) {
			$this->outputLine('User "%s" does not exist.', array($username));
			$this->quit(1);
		}

		$role = new \TYPO3\Flow\Security\Policy\Role($role);

		if ($account->hasRole($role)) {
			$this->outputLine('User "%s" already has the role "%s" assigned.', array($username, $role));
			$this->quit(1);
		}

		$account->addRole($role);
		$this->accountRepository->update($account);
		$this->outputLine('Added role "%s" to user "%s".', array($role, $username));
	}

	/**
	 * Remove a role from a user
	 *
	 * @param string $username Email address of the user
	 * @param string $role Role ot be removed from the user
	 * @param string $authenticationProvider The name of the authentication provider to use
	 * @return void
	 */
	public function removeRoleCommand($username, $role, $authenticationProvider = 'DefaultProvider') {
		$account = $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName($username, $authenticationProvider);
		if (!$account instanceof \TYPO3\Flow\Security\Account) {
			$this->outputLine('User "%s" does not exist.', array($username));
			$this->quit(1);
		}

		$role = new \TYPO3\Flow\Security\Policy\Role($role);

		if (!$account->hasRole($role)) {
			$this->outputLine('User "%s" does not have the role "%s" assigned.', array($username, $role));
			$this->quit(1);
		}

		$account->removeRole($role);
		$this->accountRepository->update($account);
		$this->outputLine('Removed role "%s" from user "%s".', array($role, $username));
	}

}