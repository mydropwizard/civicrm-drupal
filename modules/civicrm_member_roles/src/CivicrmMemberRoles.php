<?php

namespace Drupal\civicrm_member_roles;

use Drupal\civicrm\Civicrm;

/**
 * Class CivicrmMemberRoles.
 */
class CivicrmMemberRoles {

  /**
   * CiviCRM service.
   *
   * @var \Drupal\civicrm\Civicrm
   */
  protected $civicrm;

  /**
   * CivicrmMemberRoles constructor.
   *
   * @param \Drupal\civicrm\Civicrm $civicrm
   *   CiviCRM service.
   */
  public function __construct(Civicrm $civicrm) {
    $this->civicrm = $civicrm;
  }

  /**
   * Gets membership statuses.
   *
   * @return array
   *   Membership statuses, keyed by ID.
   */
  public function getStatuses() {
    $statuses = [];

    $result = civicrm_api3('MembershipStatus', 'get');
    if (empty($result['values'])) {
      return $statuses;
    }

    foreach ($result['values'] as $value) {
      $statuses[$value['id']] = $value['name'];
    }
    
    return $statuses;
  }

  /**
   * Gets membership types.
   *
   * @return array
   *   Membership types, keyed by ID.
   */
  public function getTypes() {
    $types = [];

    $result = civicrm_api3('MembershipType', 'get');
    if (empty($result['values'])) {
      return $types;
    }

    foreach ($result['values'] as $value) {
      $types[$value['id']] = $value['name'];
    }

    return $types;
  }

  /**
   * @return bool
   */
  public function sync() {
    // TODO: build this.
  }

}
