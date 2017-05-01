<?php

namespace Drupal\limograde_vehicle\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Vehicle entity.
 *
 * @ingroup limograde_vehicle
 *
 * @ContentEntityType(
 *   id = "vehicle",
 *   label = @Translation("Vehicle"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\limograde_vehicle\VehicleListBuilder",
 *     "views_data" = "Drupal\limograde_vehicle\Entity\VehicleViewsData",
 *     "form" = {
 *       "default" = "Drupal\limograde_vehicle\Form\VehicleForm",
 *       "add" = "Drupal\limograde_vehicle\Form\VehicleForm",
 *       "edit" = "Drupal\limograde_vehicle\Form\VehicleForm",
 *       "delete" = "Drupal\limograde_vehicle\Form\VehicleDeleteForm",
 *     },
 *     "inline_form" = "Drupal\limograde_vehicle\Form\VehicleInlineForm",
 *     "access" = "Drupal\limograde_vehicle\VehicleAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\limograde_vehicle\VehicleHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "vehicle",
 *   admin_permission = "administer vehicle entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "field_vehicle_type",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/vehicle/{vehicle}",
 *     "add-form" = "/vehicle/add",
 *     "edit-form" = "/vehicle/{vehicle}/edit",
 *     "delete-form" = "/vehicle/{vehicle}/delete",
 *     "collection" = "/vehicle",
 *   },
 *   field_ui_base_route = "vehicle.settings"
 * )
 */
class Vehicle extends ContentEntityBase implements VehicleInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the vehicle fleet.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the vehicle fleet is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the vehicle fleet was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the vehicle fleet was last edited.'));

    return $fields;
  }

}
