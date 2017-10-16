<?php

namespace Drupal\civicrm_member_roles\Form;

use Drupal\civicrm_member_roles\CivicrmMemberRoles;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CivicrmMemberRoleRuleForm.
 */
class CivicrmMemberRoleRuleForm extends EntityForm {

  /**
   * CiviCRM member roles service.
   *
   * @var \Drupal\civicrm_member_roles\CivicrmMemberRoles
   */
  protected $memberRoles;

  /**
   * CivicrmMemberRoleRuleForm constructor.
   *
   * @param \Drupal\civicrm_member_roles\CivicrmMemberRoles $memberRoles
   *   CiviCRM member roles service.
   */
  public function __construct(CivicrmMemberRoles $memberRoles) {
    $this->memberRoles = $memberRoles;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('civicrm_member_roles'));
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    /** @var \Drupal\civicrm_member_roles\Entity\CivicrmMemberRoleRuleInterface $rule */
    $rule = $this->entity;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $rule->label(),
      '#description' => $this->t('Label for the association rule.'),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $rule->id(),
      '#machine_name' => [
        'exists' => '\Drupal\civicrm_member_roles\Entity\CivicrmMemberRoleRule::load',
      ],
      '#disabled' => !$rule->isNew(),
    ];

    $membership_options = $this->memberRoles->getTypes();
    $status_options = $this->memberRoles->getStatuses();
    $roles = user_roles(TRUE);

    $form['add_rule'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Association Rule'),
      '#description' => $this->t('Choose a CiviMember Membership Type and a Drupal Role below. This will associate that Membership with the Role. If you would like the have the same Membership be associated with more than one role, you will need to add a second association rule after you have completed this one.'),
    ];

    $form['add_rule']['membership_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Select a CiviMember Membership Type'),
      '#options' => $membership_options,
      '#required' => TRUE,
      '#default_value' => $this->entity->getType(),
    ];

    $form['add_rule']['role'] = [
      '#type' => 'select',
      '#title' => $this->t('Select a Drupal Role'),
      '#options' => [],
      '#required' => TRUE,
      '#default_value' => $this->entity->getRole(),
    ];
    foreach ($roles as $role) {
      if ($role->id() != 'authenticated') {
        $form['add_rule']['role']['#options'][$role->id()] = $role->label();
      }
    }

    $form['status_code'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('CiviMember Status Rules'),
      '#description' => $this->t('Select which CiviMember Statuses will be used to add or remove from the Drupal Role. An "Add" status rule will add the above role to a user account. A "Removal" status rule will remove the above role from a user account.'),
    ];

    $form['status_code']['current'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Add Statuses'),
      '#description' => $this->t("Select all CiviMember Status Rule(s) that represent an 'add' status."),
      '#options' => $status_options,
      '#required' => TRUE,
      '#default_value' => $this->entity->getCurrentStatuses(),
    ];

    $form['status_code']['expired'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Removal Statuses'),
      '#description' => $this->t("Select all CiviMember Status Rule(s) that represent a 'removal' status."),
      '#options' => $status_options,
      '#required' => TRUE,
      '#default_value' => $this->entity->getExpiredStatuses(),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\civicrm_member_roles\Entity\CivicrmMemberRoleRuleInterface $rule */
    $rule = $this->entity;

    $rule->setType($form_state->getValue('membership_type'))
      ->setRole($form_state->getValue('role'))
      ->setCurrentStatuses(array_filter($form_state->getValue('current')))
      ->setExpiredStatuses(array_filter($form_state->getValue('expired')));

    $status = $rule->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label rule.', [
          '%label' => $rule->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label rule.', [
          '%label' => $rule->label(),
        ]));
    }
    $form_state->setRedirectUrl($rule->toUrl('collection'));
  }

}
