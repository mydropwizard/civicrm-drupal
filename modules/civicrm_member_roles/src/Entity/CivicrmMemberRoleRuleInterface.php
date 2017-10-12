<?php

namespace Drupal\civicrm_member_roles\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Civicrm member role rule entities.
 */
interface CivicrmMemberRoleRuleInterface extends ConfigEntityInterface {

  /**
   * Gets the role.
   *
   * @return string
   *   The role.
   */
  public function getRole();

  /**
   * Sets the role.
   *
   * @param string $role
   *   The role.
   *
   * @return $this
   */
  public function setRole($role);

  /**
   * Gets the membership type.
   *
   * @return string
   *   The membership type.
   */
  public function getType();

  /**
   * Sets the membership type.
   *
   * @param string $type
   *   The membership type.
   *
   * @return $this
   */
  public function setType($type);

  /**
   * Gets the "current" statuses.
   *
   * @return array
   *   The "current" statuses.
   */
  public function getCurrentStatuses();

  /**
   * Sets the "current" statuses.
   *
   * @param array $current
   *   The "current" statuses.
   *
   * @return $this
   */
  public function setCurrentStatuses(array $current);

  /**
   * Gets the "expired" statuses.
   *
   * @return array
   *   The "expired" statuses.
   */
  public function getExpiredStatuses();

  /**
   * Sets the "expired" statuses.
   *
   * @param array $expired
   *   The "expired" statuses.
   *
   * @return $this
   */
  public function setExpiredStatuses(array $expired);

}
