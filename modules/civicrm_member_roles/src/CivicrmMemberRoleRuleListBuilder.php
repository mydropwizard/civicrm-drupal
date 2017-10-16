<?php

namespace Drupal\civicrm_member_roles;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\Entity\Role;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a listing of Civicrm member role rule entities.
 */
class CivicrmMemberRoleRuleListBuilder extends ConfigEntityListBuilder {

  /**
   * CiviCRM member roles service.
   *
   * @var \Drupal\civicrm_member_roles\CivicrmMemberRoles
   */
  protected $memberRoles;

  /**
   * User role storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $roleStorage;

  /**
   * CivicrmMemberRoleRuleListBuilder constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Entity\EntityStorageInterface $roleStorage
   *   The use role storage class.
   * @param \Drupal\civicrm_member_roles\CivicrmMemberRoles $memberRoles
   *   CiviCRM member roles service.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, EntityStorageInterface $roleStorage, CivicrmMemberRoles $memberRoles) {
    parent::__construct($entity_type, $storage);
    $this->roleStorage = $roleStorage;
    $this->memberRoles = $memberRoles;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.manager')->getStorage($entity_type->id()),
      $container->get('entity_type.manager')->getStorage('user_role'),
      $container->get('civicrm_member_roles')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Association rule');
    $header['id'] = $this->t('Machine name');
    $header['membership_type'] = $this->t('CiviMember Membership Type');
    $header['role'] = $this->t('Drupal Role');
    $header['current'] = $this->t('Add When Status Is');
    $header['expired'] = $this->t('Remove When Status Is');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\civicrm_member_roles\Entity\CivicrmMemberRoleRuleInterface $entity */
    $row['label'] = $entity->label();
    $row['id'] = $entity->id();
    $row['membership_type'] = $this->getMembershipTypeName($entity->getType());
    $row['role'] = $this->getRoleName($entity->getRole());
    $row['current'] = $this->getStatuses($entity->getCurrentStatuses());
    $row['expired'] = $this->getStatuses($entity->getExpiredStatuses());
    return $row + parent::buildRow($entity);
  }

  /**
   * Gets the name for a specified role.
   *
   * @param string $rid
   *   The role ID.
   *
   * @return string
   *   The role name, or the ID if not found.
   */
  protected function getRoleName($rid) {
    if (!$role = Role::load($rid)) {
      return $rid;
    }
    return $role->label();
  }

  /**
   * Gets the name for a specified membership type.
   *
   * @param int $typeId
   *   The membership type ID.
   *
   * @return string
   *   The membership type name, or the ID if not found.
   */
  protected function getMembershipTypeName($typeId) {
    if (!$type = $this->memberRoles->getType($typeId)) {
      return $typeId;
    }
    return $type['name'];
  }

  /**
   * Gets the labels for the status.
   *
   * @param array $statuses
   *   Array of status IDs.
   *
   * @return string
   *   The status names as a single, comma-separated string.
   */
  protected function getStatuses(array $statuses) {
    $names = [];

    $statusData = $this->memberRoles->getStatuses();

    foreach ($statuses as $status) {
      if (array_key_exists($status, $statusData)) {
        $names[] = $statusData[$status];
      }
      else {
        $names[] = $status;
      }
    }

    return implode(', ', $names);
  }

}
