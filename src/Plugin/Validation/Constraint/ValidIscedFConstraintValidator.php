<?php

declare(strict_types=1);

namespace Drupal\isced_field\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Isced\IscedFieldsOfStudy;

/**
 * Validates the Valid ISCED-F constraint.
 */
final class ValidIscedFConstraintValidator extends ConstraintValidator {

  /**
   * ISCED-F fields of study.
   *
   * @var \Isced\IscedFieldsOfStudy
   */
  protected $iscedF;

  /**
   * Constructs the object.
   */
  public function __construct() {
    $this->iscedF = new IscedFieldsOfStudy();
  }

  /**
   * {@inheritdoc}
   */
  public function validate(mixed $value, Constraint $constraint): void {
    if (!$this->iscedF->exists($value)) {
      $this->context->addViolation($constraint->message, ['%value' => $value]);
    }
  }

}
