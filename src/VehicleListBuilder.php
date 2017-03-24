<?php

namespace Drupal\limograde_vehicle;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Vehicle entities.
 *
 * @ingroup limograde_vehicle
 */
class VehicleListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Vehicle ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\limograde_vehicle\Entity\Vehicle */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.vehicle.edit_form', array(
          'vehicle' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
