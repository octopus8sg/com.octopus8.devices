<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
return [
  [
    'name' => 'CRM_Healthmonitor_Form_Report_ContactDeviceSummary',
    'entity' => 'ReportTemplate',
    'params' => [
      'version' => 3,
      'label' => 'Contact Device Summary',
      'description' => 'Contact Device Summary (com.octopus8.healthmonitor)',
      'class_name' => 'CRM_Healthmonitor_Form_Report_ContactDeviceSummary',
      'report_url' => 'com.octopus8.healthmonitor/contactdevicesummary',
      'component' => '',
      'grouping' => 'Devices',
    ],
  ],
];
