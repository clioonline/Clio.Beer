<?php
namespace Clio\Beer\Validation\Validator;

use TYPO3\Flow\Annotations as Flow;

/**
 * Class AccountExistsValidator
 *
 * @package Clio\Beer
 * @Flow\Scope("singleton")
 */
class UniqueAccountValidator extends \TYPO3\Flow\Validation\Validator\AbstractValidator {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * Validate taht this is account is unique. Unique means uniquq combination of username and provider
	 *
	 * @param mixed $value The value that should be validated
	 * @return void
	 * @throws \TYPO3\Flow\Validation\Exception\InvalidSubjectException
	 */
	protected function isValid($value) {
		if (!is_string($value)) {
			throw new \TYPO3\Flow\Validation\Exception\InvalidSubjectException('The given value was not a string.', 1325155784);
		}

		$authenticationProviderName = isset($this->options['authenticationProviderName']) ? $this->options['authenticationProviderName'] : 'DefaultProvider';
		$account = $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName($value, $authenticationProviderName);

		if ($account !== NULL) {
			$this->addError('The username is already in use.', 1325156008);
		}
	}
}