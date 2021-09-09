<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
return [
    [
        'name' => 'CRM_Healthmonitor_Form_Report_DeviceAlarmDetail',
        'entity' => 'ReportTemplate',
        'params' => [
            'version' => 3,
            'label' => 'Device Alarm Details',
            'description' => 'Device Alarm Details (com.octopus8.devices)',
            'class_name' => 'CRM_Healthmonitor_Form_Report_DeviceAlarmDetail',
            'report_url' => 'com.octopus8.devices/devicealarmdetail',
            'component' => '',
            'grouping' => 'Devices',
        ],
    ],
];
