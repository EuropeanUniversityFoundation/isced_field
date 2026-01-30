<?php

namespace Drupal\isced_field\Plugin\views\filter;

use Drupal\Core\Database\Query\Condition;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\views\Attribute\ViewsFilter;
use Drupal\views\Plugin\views\filter\InOperator;
use Drupal\views\Plugin\views\query\Sql;
use Isced\IscedFieldsOfStudy;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides filtering for ISCED-F.
 *
 * @ingroup views_filter_handlers
 */
#[ViewsFilter("isced")]
class IscedFilter extends InOperator implements ContainerFactoryPluginInterface {

  /**
   * The ISCED-F service.
   *
   * @var \Isced\IscedFieldsOfStudy
   */
  protected $isced;

  /**
   * Constructs a new IscedFilter instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    $configuration,
    $plugin_id,
    $plugin_definition,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->isced = new IscedFieldsOfStudy();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getValueOptions() {
    $labeled_list = $this->isced->getLabeledList();
    $options = [];

    foreach ($labeled_list as $key => $value) {
      // phpcs:ignore Drupal.Semantics.FunctionT.NotLiteralString
      $options[$key] = implode(' ', [$key, $this->t($value)]);
    }

    $this->valueOptions = $options;

    return $this->valueOptions;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    if (!$this->query instanceof Sql) {
      return;
    }

    $this->ensureMyTable();
    if (empty(array_filter((array) $this->value))) {
      return;
    }

    $grouped = $this->getGroupedValues();

    $or_group = new Condition('OR');

    foreach ($grouped as $level => $values) {
      if (!empty($values)) {
        $column = implode('_', [$this->configuration['field_name'], $level]);
        $operator = (count($values) === 1) ? '=' : 'IN';
        $or_group->condition("$this->tableAlias.$column", $values, $operator);
      }
    }

    if ($or_group->count() > 0) {
      $this->query->addWhere($this->options['group'], $or_group);
    }
  }

  /**
   * Returns the input values grouped by broad, narrow and detailed.
   */
  protected function getGroupedValues(): array {
    $broad = [];
    $narrow = [];
    $detailed = [];

    foreach ($this->value as $value) {
      if ($this->isced->exists($value)) {
        if ($this->isced->isBroad($value)) {
          $broad[] = $value;
        }
        if ($this->isced->isNarrow($value)) {
          $narrow[] = $value;
        }
        if ($this->isced->isDetailed($value)) {
          $detailed[] = $value;
        }
      }
    }

    $values = ['broad' => array_unique(array_filter($broad))];

    $values['narrow'] = [];

    foreach (array_unique(array_filter($narrow)) as $narrow_item) {
      $broad_item = $this->isced->getBroad($narrow_item);
      if (!in_array($broad_item, $values['broad'])) {
        $values['narrow'][] = $narrow_item;
      }
    }

    foreach (array_unique(array_filter($detailed)) as $detailed_item) {
      $broad_item = $this->isced->getBroad($detailed_item);
      $narrow_item = $this->isced->getNarrow($detailed_item);
      if (
        !in_array($broad_item, $values['broad'])
        && !in_array($narrow_item, $values['narrow'])
      ) {
        $values['detailed'][] = $detailed_item;
      }
    }

    return $values;
  }

}
