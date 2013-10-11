<?php
namespace Clio\Beer\Validation\Validator;

use TYPO3\Flow\Annotations as Flow;

/**
 * Class Unique brewer
 *
 * @package Clio\Beer
 * @Flow\Scope("singleton")
 */
class UniqueBrewerValidator extends \TYPO3\Flow\Validation\Validator\AbstractValidator {

	/**
	 * @Flow\Inject
	 * @var \Clio\Beer\Domain\Repository\BrewerRepository
	 */
	protected $brewerRepository;

	/**
	 * Returns TRUE, if the given property ($value) is a valid array consistent of two equal passwords and their length
	 * is between 'minimum' (defaults to 0 if not specified) and 'maximum' (defaults to infinite if not specified)
	 * to be specified in the validation options.
	 *
	 * If at least one error occurred, the result is FALSE.
	 *
	 * @param mixed $value The value that should be validated
	 * @return void
	 * @throws \TYPO3\Flow\Validation\Exception\InvalidSubjectException
	 */
	protected function isValid($value) {
		if (!is_string($value)) {
			throw new \TYPO3\Flow\Validation\Exception\InvalidSubjectException('The given value was not a string.', 1325155784);
		}
		$brewer = $this->brewerRepository->findOneByName($value);

		if ($brewer !== NULL) {
			$this->addError('The brewername is already in use.', 1325156008);
		}
	}
}