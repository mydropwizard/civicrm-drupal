<?php

namespace Drupal\civicrm_member_roles\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Civicrm member role rule entity.
 *
 * @ConfigEntityType(
 *   id = "civicrm_member_role_rule",
 *   label = @Translation("Association Rule"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\civicrm_member_roles\CivicrmMemberRoleRuleListBuilder",
 *     "form" = {
 *       "add" = "Drupal\civicrm_member_roles\Form\CivicrmMemberRoleRuleForm",
 *       "edit" = "Drupal\civicrm_member_roles\Form\CivicrmMemberRoleRuleForm",
 *       "delete" = "Drupal\civicrm_member_roles\Form\CivicrmMemberRoleRuleDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\civicrm_member_roles\CivicrmMemberRoleRuleHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "civicrm_member_role_rule",
 *   admin_permission = "access civicrm member role setting",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/config/civicrm/civicrm-member-roles/rule/{civicrm_member_role_rule}",
 *     "add-form" = "/admin/config/civicrm/civicrm-member-roles/rule/add",
 *     "edit-form" = "/admin/config/civicrm/civicrm-member-roles/rule/{civicrm_member_role_rule}/edit",
 *     "delete-form" = "/admin/config/civicrm/civicrm-member-roles/rule/{civicrm_member_role_rule}/delete",
 *     "collection" = "/admin/config/civicrm/civicrm-member-roles"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "role",
 *     "type",
 *     "current",
 *     "expired",
 *   }
 * )
 */
class CivicrmMemberRoleRule extends ConfigEntityBase implements CivicrmMemberRoleRuleInterface {

  /**
   * The association rule ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The association rule label.
   *
   * @var string
   */
  protected $label;

  /**
   * The association rule role.
   *
   * @var string
   */
  protected $role;

  /**
   * The association rule membership type.
   *
   * @var string
   */
  protected $type;

  /**
   * The association rule add statuses.
   *
   * @var array
   */
  protected $current = [];

  /**
   * The association rule remove statuses.
   *
   * @var array
   */
  protected $expired = [];

  /**
   * {@inheritdoc}
   */
  public function getRole() {
    return $this->role;
  }

  /**
   * {@inheritdoc}
   */
  public function setRole($role) {
    $this->role = $role;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return $this->type;
  }

  /**
   * {@inheritdoc}
   */
  public function setType($type) {
    $this->type = $type;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCurrentStatuses() {
    return $this->current;
  }

  /**
   * {@inheritdoc}
   */
  public function setCurrentStatuses(array $current) {
    $this->current = $current;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getExpiredStatuses() {
    return $this->expired;
  }

  /**
   * {@inheritdoc}
   */
  public function setExpiredStatuses(array $expired) {
    $this->expired = $expired;
    return $this;
  }

}
