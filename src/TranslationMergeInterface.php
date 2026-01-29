<?php

declare(strict_types=1);

namespace Drupal\isced_field;

/**
 * Defines an interface for a translation merge service.
 */
interface TranslationMergeInterface {

  /**
   * Merges translation files.
   *
   * Extracts translation files from the euf/isced library and
   * merges them with the translation files provided by this module.
   */
  public function mergeTranslations(): void;

}
