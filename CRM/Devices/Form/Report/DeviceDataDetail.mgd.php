<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
return [
    [
        'name' => 'CRM_Devices_Form_Report_DeviceDataDetail',
        'entity' => 'ReportTemplate',
        'params' => [
            'version' => 3,
            'label' => 'Device Data Details',
            'description' => 'Device Data Details (com.octopus8.devices)',
            'class_name' => 'CRM_Devices_Form_Report_DeviceDataDetail',
            'report_url' => 'com.octopus8.devices/devicedatadetail',
            'component' => '',
            'grouping' => 'Devices',
        ],
    ],
];
