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
 *   }
 * )
 */
class CivicrmMemberRoleRule extends ConfigEntityBase implements CivicrmMemberRoleRuleInterface {

  /**
   * The Civicrm member role rule ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Civicrm member role rule label.
   *
   * @var string
   */
  protected $label;

}
