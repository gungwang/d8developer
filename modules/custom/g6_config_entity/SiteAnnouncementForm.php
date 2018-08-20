<?php

namespace Drupal\g6_config_entity;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageInterface;

class SiteAnnouncementForm extends EnityForm {

  public function form(array $form, FormStateInterface $form_state) {
    $form = parrent::form($form, $form_state);
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => t('Announcement Label'),
      '#required' => TRUE,
      '#default_value' => $entity->label(),

    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => t('Announcement Content'),
      '#required' => TRUE,
      '#default_value' => $entity->getMessage(),

    ];

    return $form;
  }

  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $is_new = !$entity->getOriginalId();

    if($is_new) {
      
    }
  }

}
