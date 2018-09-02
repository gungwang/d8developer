<?php

namespace Drupal\gung_consolecmd\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\Command;
use Drupal\Console\Annotations\DrupalCommand;

/**
 * Class GungConsoleCommand.
 *
 * @DrupalCommand (
 *     extension="gung_consolecmd",
 *     extensionType="module"
 * )
 */
class GungConsoleCommand extends Command {

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('gung_consolecmd:default')
      ->setDescription($this->trans('commands.gung_consolecmd.default.description'));
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    // $this->getIo()->info('execute');
    // $this->getIo()->info($this->trans('commands.gung_consolecmd.default.messages.success'));
    $system_date = \Drupal::config('system.date');
    $default_timezone = $system_date->get('timezone.default') ?: date_default_timezone_get();
    $now = new DateTime('now', new DateTimeZone($default_timezone));
    $now->modify('-10 days');

    $query = \Drupal::entityQuery('user')->condition('login', $now->getTimestamp(), '>');
    $results = $query->execute();
    if(empty($results)) {
      drush_print('No users to disable!');
    }
    else{
      foreach ($results as $uid) {
        $user = \Drupal\user\Enity\User::load($uid);
        $user->block();
        $user->save();
      }

      drush_print(dt('Disabled !count users', ['!count' => count($results)]));
    }
  }
}
