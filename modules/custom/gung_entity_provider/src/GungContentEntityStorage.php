<?php

namespace Drupal\gung_entity_provider;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\gung_entity_provider\Entity\GungContentEntityInterface;

/**
 * Defines the storage handler class for Gung content entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Gung content entity entities.
 *
 * @ingroup gung_entity_provider
 */
class GungContentEntityStorage extends SqlContentEntityStorage implements GungContentEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(GungContentEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {gung_content_entity_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {gung_content_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(GungContentEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {gung_content_entity_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('gung_content_entity_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
