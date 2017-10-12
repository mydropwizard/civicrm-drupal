<?php

namespace Drupal\civicrm_member_roles\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['civicrm_member_roles.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'civicrm_member_roles_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('civicrm_member_roles.settings');

    $form['settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Settings'),
    ];

    $form['settings']['sync_method'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Automatic Synchronization Method'),
      '#description' => $this->t('Select which method CiviMember Roles Sync will use to automatically synchronize Memberships and Roles. If you choose user login/logout, you will have to run an initial "Manual Synchronization" after you create a new rule for it to be applied to all users and contacts. If you do not select an option, automatic synchronization will be disabled. You will have to use the "Manually Synchronize" form to synchronize memberships and roles yourself. Leave the default setting if you are unsure which method to use.'),
      '#default_value' => $config->get('sync_method'),
      '#options' => [
        'login' => $this->t('Synchronize whenever a user logs in or logs out. This action is performed only on the user logging in or out.'),
        'cron' => $this->t('Synchronize when Drupal cron is ran. This action will be performed on all users and contacts.'),
        'update' => $this->t('Synchronize when membership is updated.'),
      ],
    ];

    $form['settings']['cron_limit'] = [
      '#type' => 'number',
      '#title' => t('Memberships Synchronized on Cron'),
      '#description' => t('Enter how many Memberships and Roles you would like to synchronize per cron run. Synchronization will be performed randomly. This prevents the operation from timing out when too many items are processed at once. If this is empty, all Memberships and Roles will be processed.'),
      '#default_value' => $config->get('cron_limit'),
      '#min' => 0,
      '#step' => 1,
      '#size' => 15,
      '#maxlength' => 4,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('civicrm_member_roles.settings');

    $config->set('sync_method', $form_state->getValue('sync_method'));
    $config->set('cron_limit', $form_state->getValue('cron_limit'));
    $config->save();

    parent::submitForm($form, $form_state);
  }

}
