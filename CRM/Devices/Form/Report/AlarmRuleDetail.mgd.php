<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
return [
  [
    'name' => 'CRM_Devices_Form_Report_AlarmRuleDetail',
    'entity' => 'ReportTemplate',
    'params' => [
      'version' => 3,
      'label' => 'AlarmRuleDetail',
      'description' => 'AlarmRuleDetail (com.octopus8.devices)',
      'class_name' => 'CRM_Devices_Form_Report_AlarmRuleDetail',
      'report_url' => 'com.octopus8.devices/alarmruledetail',
      'component' => '',
    ],
  ],
];
