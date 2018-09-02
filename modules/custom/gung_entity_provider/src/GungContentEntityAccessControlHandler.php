<?php

namespace Drupal\gung_entity_provider;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Gung content entity entity.
 *
 * @see \Drupal\gung_entity_provider\Entity\GungContentEntity.
 */
class GungContentEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\gung_entity_provider\Entity\GungContentEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished gung content entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published gung content entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit gung content entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete gung content entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add gung content entity entities');
  }

}
