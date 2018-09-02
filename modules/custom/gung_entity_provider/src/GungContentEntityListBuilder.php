<?php

namespace Drupal\gung_entity_provider;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Gung content entity entities.
 *
 * @ingroup gung_entity_provider
 */
class GungContentEntityListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Gung content entity ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\gung_entity_provider\Entity\GungContentEntity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.gung_content_entity.edit_form',
      ['gung_content_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
