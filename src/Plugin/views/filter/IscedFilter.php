<?php

namespace Drupal\isced_field\Plugin\views\filter;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\views\Attribute\ViewsFilter;
use Drupal\views\Plugin\views\filter\InOperator;
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
   * The entity field manager service.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

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

}
