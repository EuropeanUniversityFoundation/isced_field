<?php

namespace Drupal\isced_field\TypedData;

use Drupal\Core\TypedData\TypedData;
use Isced\IscedFieldsOfStudy;

/**
 * A computed property containing the broad field of an ISCED-F code.
 */
class IscedFBroadField extends TypedData {

  /**
   * {@inheritdoc}
   */
  public function getValue() {
    $value = $this->getParent()->get('value')->getValue();
    $iscedF = new IscedFieldsOfStudy();
    return $iscedF->getBroad($value);
  }

}
