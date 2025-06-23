<?php

declare(strict_types=1);

namespace Drupal\isced_field\Plugin\Field\FieldType;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;
use Isced\IscedFieldsOfStudy;

/**
 * Defines the 'isced_f' field type.
 */
#[FieldType(
  id: "isced_f",
  module: "isced_field",
  label: new TranslatableMarkup("ISCED-F field of study"),
  description: [
    new TranslatableMarkup("Stores an ISCED-F field of study as a string."),
    new TranslatableMarkup("Calculates broad, narrow and detailed fields."),
  ],
  category: "selection_list",
  default_widget: "isced_f_select",
  default_formatter: "isced_f_default",
)]
final class IscedFItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public function isEmpty(): bool {
    return match ($this->get('value')->getValue()) {
      NULL, '' => TRUE,
      default => FALSE,
    };
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('ISCED-F code'))
      ->setRequired(TRUE)
      ->addConstraint('ValidIscedF');

    $properties['broad'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Broad field'))
      ->setComputed(TRUE)
      ->setClass('\Drupal\isced_field\TypedData\IscedFBroadField');

    $properties['narrow'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Narrow field'))
      ->setComputed(TRUE)
      ->setClass('\Drupal\isced_field\TypedData\IscedFNarrowField');

    $properties['detailed'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Detailed field'))
      ->setComputed(TRUE)
      ->setClass('\Drupal\isced_field\TypedData\IscedFDetailedField');

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints(): array {
    $constraints = parent::getConstraints();

    $constraint_manager = $this->getTypedDataManager()
      ->getValidationConstraintManager();

    $options['value']['Regex']['pattern'] = '/^\d{2,4}$/';
    $options['value']['ValidIscedF'] = [];

    $constraints[] = $constraint_manager->create('ComplexData', $options);
    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {

    $columns = [
      'value' => [
        'type' => 'varchar',
        'not null' => TRUE,
        'description' => 'ISCED-F code.',
        'length' => 4,
      ],
      'broad' => [
        'type' => 'varchar',
        'not null' => FALSE,
        'description' => 'Broad field.',
        'length' => 2,
      ],
      'narrow' => [
        'type' => 'varchar',
        'not null' => FALSE,
        'description' => 'Narrow field.',
        'length' => 3,
      ],
      'detailed' => [
        'type' => 'varchar',
        'not null' => FALSE,
        'description' => 'Detailed field.',
        'length' => 4,
      ],
    ];

    $schema = [
      'columns' => $columns,
      'indexes' => ['value' => ['value']],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition): array {
    $values['value'] = array_rand(IscedFieldsOfStudy::list(), 1);
    return $values;
  }

}
