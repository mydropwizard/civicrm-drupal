<?php

namespace Drupal\civicrm_member_roles\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CivicrmMemberRoleRuleForm.
 */
class CivicrmMemberRoleRuleForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $civicrm_member_role_rule = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $civicrm_member_role_rule->label(),
      '#description' => $this->t("Label for the Civicrm member role rule."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $civicrm_member_role_rule->id(),
      '#machine_name' => [
        'exists' => '\Drupal\civicrm_member_roles\Entity\CivicrmMemberRoleRule::load',
      ],
      '#disabled' => !$civicrm_member_role_rule->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $civicrm_member_role_rule = $this->entity;
    $status = $civicrm_member_role_rule->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Civicrm member role rule.', [
          '%label' => $civicrm_member_role_rule->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Civicrm member role rule.', [
          '%label' => $civicrm_member_role_rule->label(),
        ]));
    }
    $form_state->setRedirectUrl($civicrm_member_role_rule->toUrl('collection'));
  }

}
