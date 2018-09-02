<?php

namespace Drupal\gung_entity_provider;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface GungContentEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Gung content entity revision IDs for a specific Gung content entity.
   *
   * @param \Drupal\gung_entity_provider\Entity\GungContentEntityInterface $entity
   *   The Gung content entity entity.
   *
   * @return int[]
   *   Gung content entity revision IDs (in ascending order).
   */
  public function revisionIds(GungContentEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Gung content entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Gung content entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\gung_entity_provider\Entity\GungContentEntityInterface $entity
   *   The Gung content entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(GungContentEntityInterface $entity);

  /**
   * Unsets the language for all Gung content entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
