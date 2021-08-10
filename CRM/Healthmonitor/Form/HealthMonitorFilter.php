<?php

use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Healthmonitor_Form_HealthMonitorFilter extends CRM_Core_Form {
  public function buildQuickForm() {

      // add activity search filter
      $activityOptions = CRM_Core_PseudoConstant::activityType(TRUE, TRUE, FALSE, 'label', TRUE);
      asort($activityOptions);

      $this->add('select', 'activity_type_filter_id', ts('Include'), $activityOptions, FALSE, ['class' => 'crm-select2', 'multiple' => TRUE, 'placeholder' => ts('- all activity type(s) -')]);
      $this->add('select', 'activity_type_exclude_filter_id', ts('Exclude'), $activityOptions, FALSE, ['class' => 'crm-select2', 'multiple' => TRUE, 'placeholder' => ts('- no types excluded -')]);
      $this->addDatePickerRange('activity_date_time', ts('Date'));
      $this->addSelect('status_id',
          ['entity' => 'activity', 'multiple' => 'multiple', 'option_url' => NULL, 'placeholder' => ts('- any -')]
      );

      $this->assign('suppressForm', TRUE);
  }



}
