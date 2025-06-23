<?php

declare(strict_types=1);

namespace Drupal\isced_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Isced\IscedFieldsOfStudy;

/**
 * Plugin implementation of the 'ISCED-F default' formatter.
 */
#[FieldFormatter(
  id: 'isced_f_default',
  label: new TranslatableMarkup('ISCED-F default'),
  field_types: [
    'isced_f',
  ],
)]
final class IscedFDefaultFormatter extends FormatterBase {

  const SEPARATOR = ' ';

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings(): array {
    $setting = ['prefix' => TRUE];
    return $setting + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state): array {
    $elements['prefix'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Prefix the study field label with its ISCED-F code'),
      '#default_value' => $this->getSetting('prefix'),
    ];
    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary(): array {
    return [
      $this->t('Prefix the study field label with its ISCED-F code: @bool', [
        '@bool' => $this->getSetting('prefix')
          ? $this->t('Yes')
          : $this->t('No'),
      ]),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $element = [];
    $iscedF = new IscedFieldsOfStudy();
    $labeled_list = $iscedF->getLabeledList();

    foreach ($items as $delta => $item) {
      $code = $item->value;
      $element[$delta] = [
        '#markup' => ($this->getSetting('prefix'))
          ? implode(self::SEPARATOR, [$code, $labeled_list[$code]])
          : $labeled_list[$code],
      ];
    }
    return $element;
  }

}
