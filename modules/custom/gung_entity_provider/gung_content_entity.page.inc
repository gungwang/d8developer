<?php

/**
 * @file
 * Contains gung_content_entity.page.inc.
 *
 * Page callback for Gung content entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Gung content entity templates.
 *
 * Default template: gung_content_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_gung_content_entity(array &$variables) {
  // Fetch GungContentEntity Entity Object.
  $gung_content_entity = $variables['elements']['#gung_content_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
