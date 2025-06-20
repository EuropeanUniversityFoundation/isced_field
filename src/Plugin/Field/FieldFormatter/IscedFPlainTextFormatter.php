<?php

declare(strict_types=1);

namespace Drupal\isced_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'ISCED-F plain text' formatter.
 */
#[FieldFormatter(
  id: 'isced_f_plain',
  label: new TranslatableMarkup('ISCED-F plain text'),
  field_types: [
    'isced_f',
  ],
)]
final class IscedFPlainTextFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];
    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#markup' => $item->value,
      ];
    }
    return $element;
  }

}
