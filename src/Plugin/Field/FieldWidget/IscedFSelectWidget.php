<?php

declare(strict_types=1);

namespace Drupal\isced_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Isced\IscedFieldsOfStudy;

/**
 * Defines the 'isced_f_select' field widget.
 */
#[FieldWidget(
  id: 'isced_f_select',
  label: new TranslatableMarkup('Select list'),
  field_types: ['isced_f'],
)]
final class IscedFSelectWidget extends WidgetBase {

  const SEPARATOR = ' ';

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings(): array {
    $setting = ['allow_all_levels' => TRUE];
    return $setting + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state): array {
    $element['allow_all_levels'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Allow all levels of selection'),
      '#default_value' => $this->getSetting('allow_all_levels'),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary(): array {
    return [
      $this->t('Allow all levels of selection: @bool', [
        '@bool' => $this->getSetting('allow_all_levels')
          ? $this->t('Yes')
          : $this->t('No'),
      ]),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $options = [];
    $iscedF = new IscedFieldsOfStudy();
    $labeled_list = $iscedF->getLabeledList();

    if (!$this->getSetting('allow_all_levels')) {
      $tree = $iscedF->getTree();

      foreach ($tree as $broad => $subtree) {
        $broad_label = implode(self::SEPARATOR, [
          $broad,
          $labeled_list[$broad],
        ]);

        $options[$broad_label] = [];

        foreach ($subtree as $narrow => $subsubtree) {
          $narrow_label = implode(self::SEPARATOR, [
            $narrow,
            $labeled_list[$narrow],
          ]);

          $options[$narrow_label] = [];

          foreach ($subsubtree as $detailed => $value) {
            $detailed_label = implode(self::SEPARATOR, [
              $detailed,
              $labeled_list[$detailed],
            ]);

            $options[$narrow_label][$detailed] = $detailed_label;
          }
        }
      }
    }
    else {
      foreach ($labeled_list as $key => $value) {
        $options[$key] = implode(self::SEPARATOR, [$key, $value]);
      }
    }

    $element['value'] = $element + [
      '#type' => 'select',
      '#options' => $options,
      '#empty_value' => '',
      '#default_value' => $items[$delta]->value ?? '',
    ];
    return $element;
  }

}
