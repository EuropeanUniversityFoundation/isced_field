<?php

namespace Drupal\isced_field\TypedData;

use Drupal\Core\TypedData\TypedData;
use Isced\IscedFieldsOfStudy;

/**
 * A computed property containing the broad field of an ISCED-F code.
 */
class IscedFBroadField extends TypedData {

  /**
   * The value.
   *
   * @var mixed
   */
  protected $value;

  /**
   * {@inheritdoc}
   */
  public function getValue() {
    $field_item = $this->getParent();
    /** @var \Drupal\Core\Field\FieldItemInterface $field_item */
    $field_value = $field_item->get('value')->getValue();
    $iscedF = new IscedFieldsOfStudy();
    return $iscedF->getBroad($field_value);
  }

}
