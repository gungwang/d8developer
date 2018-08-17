<?php

namespace Drupal\g4plugin\Plugin\Block;

use Drupal\Core\Block\BlockBase;


/**
* @Block(
*   id = "copyright_block",
*   admin_label = @Translation("Copyright"),
*   category = @Translation("Custom")
* )
*/
class Copyright extends BlockBase {
  public function build() {
    $date = new \DateTime();
    return [
      '#markup' => t('Copyright @year&copy; Gung Test Company', [
        '@year' => $date->format('Y'),
      ])
    ];
  }
}
