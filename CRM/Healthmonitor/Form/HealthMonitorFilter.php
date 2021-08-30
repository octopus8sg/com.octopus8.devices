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

      $device_types = CRM_Core_OptionGroup::values('health_monitor_device_type');
      // for data filter
      $this->add('select', 'data_device_type_id',
          E::ts('Device Type'),
          $device_types,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type','placeholder' => ts('- Select Device Type -'),
              'select' => ['minimumInputLength' => 0]]);

      // for device filter
      $this->add('select', 'device_device_type_id',
          E::ts('Device Type'),
          $device_types,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type','placeholder' => ts('- Select Device Type -'),
              'select' => ['minimumInputLength' => 0]]);

      //for chart filter
      $this->add('select', 'chart_device_type_id',
          E::ts('Device Type'),
          $device_types,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type','placeholder' => ts('- Select Device Type -'),
              'select' => ['minimumInputLength' => 0, 'multiple' => true]]);


      $sensors = CRM_Core_OptionGroup::values('health_monitor_sensor');

      //for data filter
      $this->add('select', 'data_sensor_id',
          E::ts('Sensor'),
          $sensors,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
              'select' => ['minimumInputLength' => 1]]);

      //for chart filter
      $this->add('select', 'chart_sensor_id',
          E::ts('Sensor'),
          $sensors,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
              'select' => ['minimumInputLength' => 1]]);

      //for alarm rule filter
      $this->add('select', 'alarm_rule_sensor_id',
          E::ts('Sensor'),
          $sensors,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
              'select' => ['minimumInputLength' => 1]]);

      //for alarm filter
      $this->add('select', 'alarm_sensor_id',
          E::ts('Sensor'),
          $sensors,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
              'select' => ['minimumInputLength' => 1]]);

      //for alert rule filter
      $this->add('select', 'alert_rule_sensor_id',
          E::ts('Sensor'),
          $sensors,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
              'select' => ['minimumInputLength' => 1]]);

      //for alert rule filter
      $this->add('select', 'alert_sensor_id',
          E::ts('Sensor'),
          $sensors,
          FALSE, ['class' => 'huge crm-select2',
              'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
              'select' => ['minimumInputLength' => 1]]);

      // contact - for data and adressee filters
      $this->addEntityRef('data_contact_id', E::ts('Contact'), ['create' => false, 'multiple' => true], false, array('class' => 'huge'));

      $this->addEntityRef('alert_contact_id', E::ts('Device Owner'), ['create' => false, 'multiple' => true], false, array('class' => 'huge'));

      $this->addEntityRef('alert_rule_addressee_id', E::ts('Addressee'), ['create' => false, 'multiple' => true], false, array('class' => 'huge'));

      $this->addEntityRef('alert_addressee_id', E::ts('Addressee'), ['create' => false, 'multiple' => true], false, array('class' => 'huge'));


      $this->addEntityRef('data_device_id', E::ts('Device'), [
          'entity' => 'device',
          'placeholder' => ts('- Select Device -'),
          'select' => ['minimumInputLength' => 0],
      ], false);

      $this->addEntityRef('chart_device_id', E::ts('Device'), [
          'entity' => 'device',
          'placeholder' => ts('- Select Device -'),
          'select' => ['minimumInputLength' => 0], 'multiple' => true
      ], false);


      $this->addDatePickerRange('data_dateselect',
          'Select Date',
          FALSE,
          FALSE,
          'From: ',
          'To: ',
          null,
          '_to',
          '_from');
      $this->addDatePickerRange('chart_dateselect',
          'Select Date',
          FALSE,
          FALSE,
          'From: ',
          'To: ',
          null,
          '_to',
          '_from');
      $this->addDatePickerRange('alarm_dateselect',
          'Select Date',
          FALSE,
          FALSE,
          'From: ',
          'To: ',
          null,
          '_to',
          '_from');
      $this->addDatePickerRange('alert_dateselect',
          'Select Date',
          FALSE,
          FALSE,
          'From: ',
          'To: ',
          null,
          '_to',
          '_from');


      $this->add('checkbox', 'alert_rule_civicrm', ts('CiviCRM'))->setChecked(true);
      $this->add('checkbox', 'alert_rule_email', ts('Email'));
      $this->add('checkbox', 'alert_rule_telegram', ts('Telegram'));
      $this->add('checkbox', 'alert_rule_api', ts('API'));

      $this->add('checkbox', 'alert_civicrm', ts('CiviCRM'))->setChecked(true);
      $this->add('checkbox', 'alert_email', ts('Email'));
      $this->add('checkbox', 'alert_telegram', ts('Telegram'));
      $this->add('checkbox', 'alert_api', ts('API'));

      $this->assign('suppressForm', FALSE);
  }



}
