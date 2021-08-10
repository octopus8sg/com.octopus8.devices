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
      $this->add('text', 'device_name', E::ts('Device Name'), array('class' => 'huge'));
      $types = CRM_Core_OptionGroup::values('health_monitor_device_type');
      $this->add('select', 'device_type_id',
          E::ts('Device Type'),
          $types,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type','placeholder' => ts('- Select Device Type -'),
              'select' => ['minimumInputLength' => 0]]);
      $sensors = CRM_Core_OptionGroup::values('health_monitor_sensor');
      $this->add('select', 'sensor_id',
          E::ts('Sensor'),
          $sensors,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
              'select' => ['minimumInputLength' => 0]]);
      $this->addEntityRef('contact_id', E::ts('Contact'), ['create' => false, 'multiple' => true], false, array('class' => 'huge'));
      $this->addEntityRef('device_id', E::ts('Device'), [
          'entity' => 'device',
          'placeholder' => ts('- Select Device -'),
          'select' => ['minimumInputLength' => 0],
      ], false);

      $this->addDateRange('dateselect', '_from', '_to', 'From:', 'yyyy-mm-dd');

      $this->assign('suppressForm', TRUE);
  }



}
