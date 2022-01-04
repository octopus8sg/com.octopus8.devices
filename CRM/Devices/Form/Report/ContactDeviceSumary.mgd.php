<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
return [
    [
        'name' => 'CRM_Devices_Form_Report_ContactDeviceSumary',
        'entity' => 'ReportTemplate',
        'params' => [
            'version' => 3,
            'label' => 'Contact Device Sumary',
            'description' => 'Contact Device Sumary (com.octopus8.devices)',
            'class_name' => 'CRM_Devices_Form_Report_ContactDeviceSumary',
            'report_url' => 'com.octopus8.devices/contactdevicesumary',
            'component' => '',
            'grouping' => 'Devices',
        ],
    ],
];
