<?php

namespace Drupal\isced_field\TypedData;

use Drupal\Core\TypedData\TypedData;
use Isced\IscedFieldsOfStudy;

/**
 * A computed property containing the narrow field of an ISCED-F code.
 */
class IscedFNarrowField extends TypedData {

  /**
   * {@inheritdoc}
   */
  public function getValue() {
    $value = $this->getParent()->get('value')->getValue();
    $iscedF = new IscedFieldsOfStudy();
    return $iscedF->getNarrow($value);
  }

}
