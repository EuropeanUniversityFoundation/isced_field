<?php

declare(strict_types=1);

namespace Drupal\isced_field\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Provides a Valid ISCED-F constraint.
 *
 * @Constraint(
 *   id = "ValidIscedF",
 *   label = @Translation("Valid ISCED-F", context = "Validation"),
 * )
 */
final class ValidIscedFConstraint extends Constraint {

  public string $message = '%value is not a valid ISCED-F field of study.';

}
