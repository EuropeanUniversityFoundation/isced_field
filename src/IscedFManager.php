<?php

declare(strict_types=1);

namespace Drupal\isced_field;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * @todo Add class description.
 */
final class IscedFManager implements IscedFManagerInterface {

  /**
   * Constructs an IscedFManager object.
   */
  public function __construct(
    private readonly ConfigFactoryInterface $configFactory,
  ) {}

  /**
   * {@inheritdoc}
   */
  public function doSomething(): void {
    // @todo Place your code here.
  }

}
