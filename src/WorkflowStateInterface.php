<?php

/**
 * @file
 * Contains Drupal\workflow\WorkflowStateInterface.
 */

namespace Drupal\workflow;

/**
 * Provides an interface defining a workflow state.
 */
interface WorkflowStateInterface {

  /**
   * Returns the state id.
   *
   * @return string
   *   The state id.
   */
  public function getId();

  /**
   * Sets the state id.
   *
   * @param string $id
   *   The state id.
   *
   * @return $this
   */
  public function setId($id);

  /**
   * Returns the state label.
   *
   * @return string
   *   The state label.
   */
  public function getLabel();

  /**
   * Sets the state label.
   *
   * @param string $label
   *   The state label.
   *
   * @return $this
   */
  public function setLabel($label);

  /**
   * Returns the state weight.
   *
   * @return string
   *   The state weight.
   */
  public function getWeight();

  /**
   * Sets the state weight.
   *
   * @param int $weight
   *   The state weight.
   *
   * @return $this
   */
  public function setWeight($weight);

  /**
   * Returns an array of state values.
   *
   * @return array
   *   An array of state values (id, label, weight).
   */
  public function toArray();

}
