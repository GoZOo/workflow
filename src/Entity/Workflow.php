<?php

/**
 * @file
 * Contains Drupal\workflow\Entity\Workflow.
 */

namespace Drupal\workflow\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Config\Entity\ThirdPartySettingsTrait;
use Drupal\workflow\WorkflowInterface;
use Drupal\workflow\WorkflowState;

/**
 * Defines the workflow entity.
 *
 * @ConfigEntityType(
 *   id = "workflow",
 *   label = @Translation("Workflow"),
 *   handlers = {
 *     "list_builder" = "Drupal\workflow\Controller\WorkflowListBuilder",
 *     "form" = {
 *       "add" = "Drupal\workflow\Form\WorkflowForm",
 *       "edit" = "Drupal\workflow\Form\WorkflowForm",
 *       "delete" = "Drupal\workflow\Form\WorkflowDeleteForm"
 *     }
 *   },
 *   config_prefix = "workflow",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "edit-form" = "entity.workflow.edit_form",
 *     "delete-form" = "entity.workflow.delete_form"
 *   }
 * )
 */
class Workflow extends ConfigEntityBase implements WorkflowInterface {

  use ThirdPartySettingsTrait;

  /**
   * The workflow id.
   *
   * @var string
   */
  protected $id;

  /**
   * The workflow label.
   *
   * @var string
   */
  protected $label;

  /**
   * The workflow group id.
   *
   * @var string
   */
  protected $group;

  /**
   * The workflow states.
   *
   * @var array
   */
  protected $states = array();

  /**
   * Overrides ConfigEntityBase::__construct().
   */
  public function __construct(array $values, $entity_type) {
    // Allow the state objects to be populated from an array.
    // @todo Remove once #2399999 lands.
    if (!empty($values['states']) && is_array($values['states'])) {
      $values['states'] = $this->populateStates($values['states']);
    }

    parent::__construct($values, $entity_type);
  }

  /**
   * {@inheritdoc}
   */
  public function getGroupEntity() {
    return WorkflowGroup::load($this->group);
  }

  /**
   * {@inheritdoc}
   */
  public function getGroup() {
    return $this->group;
  }

  /**
   * {@inheritdoc}
   */
  public function setGroup($group) {
    $this->group = $group;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getStates() {
    return $this->states;
  }

  /**
   * {@inheritdoc}
   */
  public function setStates(array $states) {
    // Allow the state objects to be populated from an array. Used by forms,
    // config storage, entity_create().
    $first_state = reset($states);
    if (!empty($states) && !is_object($first_state)) {
      $states = $this->populateStates($states);
    }

    $this->states = $states;
    return $this;
  }

  /**
   * Overrides ConfigEntityBase::set().
   */
  public function set($property_name, $value) {
    // @todo Remove once #2399965 lands.
    if ($property_name == 'states') {
      return $this->setStates($value);
    }
    else {
      return parent::set($property_name, $value);
    }
  }

  /**
   * Overrides ConfigEntityBase::toArray().
   */
  public function toArray() {
    $properties = parent::toArray();
    // Convert each state to its array form as well.
    foreach ($properties['states'] as $index => $state) {
      $properties['states'][$index] = $state->toArray();
    }

    return $properties;
  }

  /**
   * Populates an array of WorkflowState objects from the provided values.
   *
   * @param array $values
   *   An array of state definitions.
   *
   * @return array
   *   An array of WorkflowState objects.
   */
  protected function populateStates(array $values) {
    if (is_object($values[0])) {
      // The states have already been populated, or the definition is in an
      // unknown format.
      return $values;
    }

    $states = array();
    foreach ($values as $index => $state_definition) {
      if (empty($state_definition['id']) || empty($state_definition['label'])) {
        // Ignore malformed definitions.
        continue;
      }

      $weight = isset($state_definition['weight']) ? $state_definition['weight'] : 0;
      $states[] = new WorkflowState($state_definition['id'], $state_definition['label'], $weight);
    }

    return $states;
  }

}
