<?php

namespace Drupal\gung_entity_provider\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Gung content entity entities.
 *
 * @ingroup gung_entity_provider
 */
interface GungContentEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Gung content entity name.
   *
   * @return string
   *   Name of the Gung content entity.
   */
  public function getName();

  /**
   * Sets the Gung content entity name.
   *
   * @param string $name
   *   The Gung content entity name.
   *
   * @return \Drupal\gung_entity_provider\Entity\GungContentEntityInterface
   *   The called Gung content entity entity.
   */
  public function setName($name);

  /**
   * Gets the Gung content entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Gung content entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Gung content entity creation timestamp.
   *
   * @param int $timestamp
   *   The Gung content entity creation timestamp.
   *
   * @return \Drupal\gung_entity_provider\Entity\GungContentEntityInterface
   *   The called Gung content entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Gung content entity published status indicator.
   *
   * Unpublished Gung content entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Gung content entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Gung content entity.
   *
   * @param bool $published
   *   TRUE to set this Gung content entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\gung_entity_provider\Entity\GungContentEntityInterface
   *   The called Gung content entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Gung content entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Gung content entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\gung_entity_provider\Entity\GungContentEntityInterface
   *   The called Gung content entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Gung content entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Gung content entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\gung_entity_provider\Entity\GungContentEntityInterface
   *   The called Gung content entity entity.
   */
  public function setRevisionUserId($uid);

}
