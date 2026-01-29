<?php

namespace Drupal\isced_field\Drush\Commands;

use Drupal\isced_field\TranslationMergeInterface;
use Drush\Commands\AutowireTrait;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Drush command to merge ISCED-F translations.
 */
#[AsCommand(
  name: self::NAME,
  description: 'Merges ISCED-F translations.',
  aliases: ['isced-merge'],
)]
final class MergeCommand extends Command {

  use AutowireTrait;

  const NAME = 'isced_field:merge';

  /**
   * Constructs a MergeCommand object.
   */
  public function __construct(
    private readonly TranslationMergeInterface $iscedFieldMerge,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public function execute(InputInterface $input, OutputInterface $output): int {
    $this->iscedFieldMerge->mergeTranslations();
    return self::SUCCESS;
  }

}
