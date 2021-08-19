<?php

use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Healthmonitor_Form_HealthMonitorFilter extends CRM_Core_Form {
  public function buildQuickForm() {

      // add hm data search filters
      $this->add('text', 'device_name', E::ts('Device Name'), array('class' => 'huge'));
      $types = CRM_Core_OptionGroup::values('health_monitor_device_type');
      $this->add('select', 'data_device_type_id',
          E::ts('Device Type'),
          $types,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type','placeholder' => ts('- Select Device Type -'),
              'select' => ['minimumInputLength' => 0]]);
      $sensors = CRM_Core_OptionGroup::values('health_monitor_sensor');
      $this->add('select', 'data_sensor_id',
          E::ts('Sensor'),
          $sensors,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
              'select' => ['minimumInputLength' => 1]]);
      $this->addEntityRef('data_contact_id', E::ts('Contact'), ['create' => false, 'multiple' => true], false, array('class' => 'huge'));
      $this->addEntityRef('data_device_id', E::ts('Device'), [
          'entity' => 'device',
          'placeholder' => ts('- Select Device -'),
          'select' => ['minimumInputLength' => 0],
      ], false);

      $this->addDateRange('data_dateselect', '_from', '_to', 'From:', 'yyyy-mm-dd');

      // add device filter
      $types = CRM_Core_OptionGroup::values('health_monitor_device_type');
      $this->add('select', 'device_device_type_id',
          E::ts('Device Type'),
          $types,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type','placeholder' => ts('- Select Device Type -'),
              'select' => ['minimumInputLength' => 0]]);

      //add chart filter
      $types = CRM_Core_OptionGroup::values('health_monitor_device_type');
      $this->add('select', 'chart_device_type_id',
          E::ts('Device Type'),
          $types,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type','placeholder' => ts('- Select Device Type -'),
              'select' => ['minimumInputLength' => 0, 'multiple' => true]]);
      $sensors = CRM_Core_OptionGroup::values('health_monitor_sensor');
      $this->add('select', 'chart_sensor_id',
          E::ts('Sensor'),
          $sensors,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
              'select' => ['minimumInputLength' => 1]]);
      $this->addEntityRef('chart_device_id', E::ts('Device'), [
          'entity' => 'device',
          'placeholder' => ts('- Select Device -'),
          'select' => ['minimumInputLength' => 0], 'multiple' => true
      ], false);

      $this->addDateRange('chart_dateselect', '_from', '_to', 'From:', 'yyyy-mm-dd');

      $this->assign('suppressForm', FALSE);
  }



}
