<?php

declare(strict_types=1);

namespace Drupal\isced_field\Plugin\Validation\Constraint;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Validation\Attribute\Constraint;
use Symfony\Component\Validator\Constraint as SymfonyConstraint;

/**
 * Provides a Valid ISCED-F constraint.
 */
#[Constraint(
  id: 'ValidIscedF',
  label: new TranslatableMarkup('Valid ISCED-F', [], ['context' => 'Validation'])
)]
final class ValidIscedFConstraint extends SymfonyConstraint {

  /**
   * The error message if the value is not a valid ISCED-F field of study.
   *
   * @var string
   */
  public string $message = '%value is not a valid ISCED-F field of study.';

}
