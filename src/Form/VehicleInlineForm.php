<?php

namespace Drupal\limograde_vehicle\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\inline_entity_form\Form\EntityInlineForm;

/**
 * Media inline form handler.
 */
class VehicleInlineForm extends EntityInlineForm {

  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function getTableFields($bundles) {
    $fields = parent::getTableFields($bundles);

    $fields['field_qty'] = [
      'type' => 'field',
      'label' => $this->t('Qty'),
      'weight' => 1,
    ];

    $fields['field_seats'] = [
      'type' => 'field',
      'label' => $this->t('Seats'),
      'weight' => 1,
    ];

    $fields['field_hour'] = [
      'type' => 'field',
      'label' => $this->t('Hour'),
      'weight' => 1,
    ];

    $fields['field_day'] = [
      'type' => 'field',
      'label' => $this->t('Day'),
      'weight' => 1,
    ];

    $fields['field_mile'] = [
      'type' => 'field',
      'label' => $this->t('Mile'),
      'weight' => 1,
    ];

    $fields['field_year'] = [
      'type' => 'field',
      'label' => $this->t('Year'),
      'weight' => 1,
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function entityFormSubmit(array &$entity_form, FormStateInterface $form_state) {
    parent::entityFormSubmit($entity_form, $form_state);
  }

}
