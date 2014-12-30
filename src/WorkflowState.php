<?php

/**
 * @file
 * Contains Drupal\workflow\WorkflowState.
 */

namespace Drupal\workflow;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Config\Entity\ThirdPartySettingsTrait;
use Drupal\workflow\WorkflowInterface;

class WorkflowState implements WorkflowStateInterface {

  /**
   * The state id.
   *
   * @var string
   */
  protected $id;

  /**
   * The state label.
   *
   * @var string
   */
  protected $label;

  /**
   * The state weight.
   *
   * @var int
   */
  protected $weight = 0;

  /**
   * Constructs a WorkflowState object.
   *
   * @param string $id
   *   The state id.
   * @param string $label
   *   The state label.
   * @param int $weight
   *   The state weight.
   */
  public function __construct($id, $label, $weight = 0) {
    $this->id = $id;
    $this->label = $label;
    $this->weight = $weight;
  }

  /**
   * {@inheritdoc}
   */
  public function getId() {
    return $this->id;
  }

  /**
   * {@inheritdoc}
   */
  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * {@inheritdoc}
   */
  public function setLabel($label) {
    $this->label = $label;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getWeight() {
    return $this->label;
  }

  /**
   * {@inheritdoc}
   */
  public function setWeight($weight) {
    $this->weight = $weight;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function toArray() {
    return array(
      'id' => $this->id,
      'label' => $this->label,
      'weight' => $this->weight,
    );
  }

}
