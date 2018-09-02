<?php

namespace Drupal\gung_entity_provider\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\gung_entity_provider\Entity\GungContentEntityInterface;

/**
 * Class GungContentEntityController.
 *
 *  Returns responses for Gung content entity routes.
 */
class GungContentEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Gung content entity  revision.
   *
   * @param int $gung_content_entity_revision
   *   The Gung content entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($gung_content_entity_revision) {
    $gung_content_entity = $this->entityManager()->getStorage('gung_content_entity')->loadRevision($gung_content_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('gung_content_entity');

    return $view_builder->view($gung_content_entity);
  }

  /**
   * Page title callback for a Gung content entity  revision.
   *
   * @param int $gung_content_entity_revision
   *   The Gung content entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($gung_content_entity_revision) {
    $gung_content_entity = $this->entityManager()->getStorage('gung_content_entity')->loadRevision($gung_content_entity_revision);
    return $this->t('Revision of %title from %date', ['%title' => $gung_content_entity->label(), '%date' => format_date($gung_content_entity->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Gung content entity .
   *
   * @param \Drupal\gung_entity_provider\Entity\GungContentEntityInterface $gung_content_entity
   *   A Gung content entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(GungContentEntityInterface $gung_content_entity) {
    $account = $this->currentUser();
    $langcode = $gung_content_entity->language()->getId();
    $langname = $gung_content_entity->language()->getName();
    $languages = $gung_content_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $gung_content_entity_storage = $this->entityManager()->getStorage('gung_content_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $gung_content_entity->label()]) : $this->t('Revisions for %title', ['%title' => $gung_content_entity->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all gung content entity revisions") || $account->hasPermission('administer gung content entity entities')));
    $delete_permission = (($account->hasPermission("delete all gung content entity revisions") || $account->hasPermission('administer gung content entity entities')));

    $rows = [];

    $vids = $gung_content_entity_storage->revisionIds($gung_content_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\gung_entity_provider\GungContentEntityInterface $revision */
      $revision = $gung_content_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $gung_content_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.gung_content_entity.revision', ['gung_content_entity' => $gung_content_entity->id(), 'gung_content_entity_revision' => $vid]));
        }
        else {
          $link = $gung_content_entity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.gung_content_entity.translation_revert', ['gung_content_entity' => $gung_content_entity->id(), 'gung_content_entity_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.gung_content_entity.revision_revert', ['gung_content_entity' => $gung_content_entity->id(), 'gung_content_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.gung_content_entity.revision_delete', ['gung_content_entity' => $gung_content_entity->id(), 'gung_content_entity_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['gung_content_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
