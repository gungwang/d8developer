<?php

namespace Drupal\gung_entity_provider\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Gung content entity entities.
 */
class GungContentEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
