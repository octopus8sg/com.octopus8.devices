<?php

use CRM_Devices_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Devices_Form_CommonFilter extends CRM_Core_Form
{
    protected $_device_types;
    protected $_sensors;
    protected $_cid; // cid is contact for contact tab. if it's present, contact is freezed

    public function preProcess()
    {
        parent::preProcess();
        $cid = CRM_Utils_Request::retrieve('cid', 'Positive', $this, FALSE);
        $this->_cid = $cid;
    }
    // Devices
    // Device Data
    // Alarm Rules
    // Alarms
    // Alert Rules
    // Alerts
    // Chart

    // ID or Code
    // Contact (Device Owner)
    // Contact (Alert Addressee)
    // Device Types
    // Sensor Types
    // Data Dates
    // Alarm Dates
    // Alert Dates
    // Device Data Values
    // Alert Messages

    //// Devices
    // ID or Code
    // Contact (Owner)
    // Device Type

    //// Device Data
    // Contact (Owner)
    // Device ID or Code
    // Device Type
    // Sensor
    // Data Dates


    public function buildQuickForm()
    {

        // add device type filter
        $device_types = CRM_Core_OptionGroup::values('o8_device_type');
        $sensors = CRM_Core_OptionGroup::values('o8_device_sensor');
        $this->_device_types = $device_types;
        $this->_sensors = $sensors;
        $this->_cid = CRM_Utils_Request::retrieve('cid', 'Positive');
        //
        $this->device_filter();
        $this->device_data_filter();
        $this->alert_filter();
        if ($this->_cid) {
            $this->alarm_rule_filter();
            $this->alarm_filter();
            $this->alert_rule_filter();
            $this->chart_filter();
        }
        $this->assign('suppressForm', FALSE);
        parent::buildQuickForm();
    }

    function device_filter()
    {
        // ID or Code
        // Contact (Owner)
        // Device Type

        $this->add(
            'text',
            'device_device_id',
            ts('Device ID or Code'),
            ['size' => 28, 'maxlength' => 128]);

//        CRM_Core_Error::debug_var('cid', $this->_cid);

        if ($this->_cid) {
            $this->addEntityRef('device_contact_id', E::ts('Device Owner'),
                false)->freeze();
        } else {
            $this->addEntityRef('device_contact_id', E::ts('Device Owner'),
                ['create' => false, 'multiple' => true, 'class' => 'huge'],
                false);
        }

        $this->add('select', 'device_device_type_id',
            E::ts('Device Type'),
            $this->_device_types,
            FALSE,
            ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_device_type',
                'multiple' => TRUE,
                'placeholder' => ts('- Select Device Type -'),
                'select' => ['minimumInputLength' => 0]
            ]);

    }

    function device_data_filter()
    {
        /*
         *             aoData.push({ "name": "device_data_id",
                "value": $('#device_data_id').val() });
            aoData.push({ "name": "device_type_id",
                "value": $('#device_data_device_type_id').val() });
            aoData.push({ "name": "device_id",
                "value": $('#device_data_device_id').val() });
            aoData.push({ "name": "contact_id",
                "value": $('#device_data_contact_id').val() });
            aoData.push({ "name": "sensor_id",
                "value": $('#device_data_sensor_id').val() });
            aoData.push({ "name": "dateselect_from",
                "value": $('#device_data_dateselect_from').val() });
            aoData.push({ "name": "dateselect_to",
                "value": $('#device_data_dateselect_to').val() });
         */
        // ID or Code
        // Contact (Owner)
        // Device Type

        $this->add(
            'text',
            'device_data_id',
            ts('Device Data ID'),
            ['size' => 28, 'maxlength' => 128]);

        $this->add(
            'text',
            'device_data_device_id',
            ts('Device ID or Code'),
            ['size' => 28, 'maxlength' => 128]);
        if ($this->_cid) {
            $this->addEntityRef('device_data_contact_id', E::ts('Device Owner'),
                false)->freeze();
        } else {
            $this->addEntityRef('device_data_contact_id', E::ts('Device Owner'),
                ['create' => false, 'multiple' => true, 'class' => 'huge'],
                false);
        }

        $this->add('select', 'device_data_device_type_id',
            E::ts('Device Type'),
            $this->_device_types,
            FALSE,
            ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_device_type',
                'multiple' => TRUE,
                'placeholder' => ts('- Select Device Type -'),
                'select' => ['minimumInputLength' => 0]
            ]);

        $this->add('select', 'device_data_sensor_id',
            E::ts('Sensor'),
            $this->_sensors,
            FALSE,
            ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_device_sensor',
                'multiple' => TRUE,
                'placeholder' => ts('- Select Sensor -'),
                'select' => ['minimumInputLength' => 0]
            ]);

        $this->addDatePickerRange('device_data_dateselect',
            'Select Date',
            FALSE,
            NULL,
            "From: ",
            "To: ",
            [],
            '_to',
            '_from'
        );

    }


    function chart_filter()
    {
        /*
*/
        // Contact (Owner)
        // Device Type
        // Sensor


        if ($this->_cid) {
            $this->addEntityRef('chart_contact_id', E::ts('Device Owner'),
                false)->freeze();
        } else {
            $this->addEntityRef('chart_contact_id', E::ts('Device Owner'),
                ['create' => false, 'multiple' => true, 'class' => 'huge'],
                false);
        }

        $this->add('select', 'chart_device_type_id',
            E::ts('Device Type'),
            $this->_device_types,
            FALSE,
            ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_device_type',
                'multiple' => TRUE,
                'placeholder' => ts('- Select Device Type -'),
                'select' => ['minimumInputLength' => 0]
            ]);

        $this->add('select', 'chart_sensor_id',
            E::ts('Sensor'),
            $this->_sensors,
            FALSE,
            ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_device_sensor',
                'multiple' => TRUE,
                'placeholder' => ts('- Select Sensor -'),
                'select' => ['minimumInputLength' => 0]
            ]);

        $this->addDatePickerRange('chart_dateselect',
            'Select Date',
            FALSE,
            NULL,
            "From: ",
            "To: ",
            [],
            '_to',
            '_from'
        );

    }

    function alarm_rule_filter()
    {
        /*
            aoData.push({ "name": "alarm_rule_id",
                "value": $('#alarm_rule_id').val() });
            aoData.push({ "name": "contact_id",
                "value": $('#alarm_rule_contact_id').val() });
            aoData.push({ "name": "sensor_id",
                "value": $('#alarm_rule_sensor_id').val() });
         */
        // ID or Code
        // Contact (Owner)
        // SensorID

        $this->add(
            'text',
            'alarm_rule_id',
            ts('Alarm Rule ID or Code'),
            ['size' => 28, 'maxlength' => 128]);

        if ($this->_cid) {
            $this->addEntityRef('alarm_rule_contact_id', E::ts('Device Owner'),
                false)->freeze();
        } else {
            $this->addEntityRef('alarm_rule_contact_id', E::ts('Device Owner'),
                ['create' => false, 'multiple' => true, 'class' => 'huge'],
                false);
        }


        $this->add('select', 'alarm_rule_sensor_id',
            E::ts('Sensor'),
            $this->_sensors,
            FALSE,
            ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_device_sensor',
                'multiple' => TRUE,
                'placeholder' => ts('- Select Sensor -'),
                'select' => ['minimumInputLength' => 0]
            ]);

    }

    function alert_rule_filter()
    {
        /*
            aoData.push({ "name": "alert_rule_id",
                "value": $('#alert_rule_id').val() });
            aoData.push({ "name": "contact_id",
                "value": $('#alert_rule_contact_id').val() });
            aoData.push({ "name": "sensor_id",
                "value": $('#alert_rule_sensor_id').val() });
            aoData.push({ "name": "alert_rule_addressee_id",
                "value": $('#alert_rule_addressee_id').val() });
            aoData.push({ "name": "alert_rule_type",
                "value": $('#alert_rule_type').val() });
         */
        // ID or Code
        // Contact (Owner)
        // SensorID

        $this->add(
            'text',
            'alert_rule_id',
            ts('Alert Rule ID, Code or Title'),
            ['size' => 28, 'maxlength' => 128]);

        if ($this->_cid) {
            $this->addEntityRef('alert_rule_contact_id', E::ts('Device Owner'),
                false)->freeze();
        } else {
            $this->addEntityRef('alert_rule_contact_id', E::ts('Device Owner'),
                ['create' => false, 'multiple' => true, 'class' => 'huge'],
                false);
        }

        $this->addEntityRef('alert_rule_addressee_id', E::ts('Alert Addressee'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'],
            false);

        $this->add('select', 'alert_rule_sensor_id',
            E::ts('Sensor'),
            $this->_sensors,
            FALSE,
            ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_device_sensor',
                'multiple' => TRUE,
                'placeholder' => ts('- Select Sensor -'),
                'select' => ['minimumInputLength' => 0]
            ]);
        $alert_rule_types = [
            0 => 'CiviCRM',
            1 => 'Email',
            2 => 'SMS',
            3 => 'Telegram',
            4 => 'API'
        ];
        $this->add('select', 'alert_rule_type',
            E::ts('Alert Type'),
            $alert_rule_types,
            FALSE,
            ['class' => 'huge crm-select2',
//                'data-option-edit-path' => 'civicrm/admin/options/o8_device_sensor',
                'multiple' => TRUE,
                'placeholder' => ts('- Select Alert Type -'),
                'select' => ['minimumInputLength' => 0]
            ]);


    }

    function alert_filter()
    {
        /*
            aoData.push({ "name": "alert_id",
                "value": $('#alert_id').val() });
            aoData.push({ "name": "contact_id",
                "value": $('#contact_id').val() });
            aoData.push({ "name": "alert_sensor_id",
                "value": $('#alert_sensor_id').val() });
            aoData.push({ "name": "alert_addressee_id",
                "value": $('#alert_addressee_id').val() });
            aoData.push({ "name": "alert_rule_type",
                "value": $('#alert_rule_type').val() });
            aoData.push({ "name": "dateselect_from",
                "value": $('#alert_dateselect_from').val() });
            aoData.push({ "name": "dateselect_to",
                "value": $('#alert_dateselect_to').val() });
         */
        // ID or Code
        // Contact (Owner)
        // SensorID

        $this->add(
            'text',
            'alert_id',
            ts('Alert ID'),
            ['size' => 28, 'maxlength' => 128]);

        if ($this->_cid) {
            $this->addEntityRef('alert_contact_id', E::ts('Device Owner'),
                false)->freeze();
        } else {
            $this->addEntityRef('alert_contact_id', E::ts('Device Owner'),
                ['create' => false, 'multiple' => true, 'class' => 'huge'],
                false);
        }

        $this->addEntityRef('alert_addressee_id', E::ts('Alert Addressee'),
            ['create' => false, 'multiple' => true, 'class' => 'huge'],
            false);

        $this->add('select', 'alert_sensor_id',
            E::ts('Sensor'),
            $this->_sensors,
            FALSE,
            ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_device_sensor',
                'multiple' => TRUE,
                'placeholder' => ts('- Select Sensor -'),
                'select' => ['minimumInputLength' => 0]
            ]);
        $alert_rule_types = [
            0 => 'CiviCRM',
            1 => 'Email',
            2 => 'SMS',
            3 => 'Telegram',
            4 => 'API'
        ];
//        $this->add('select', 'alert_rule_type',
//            E::ts('Alert Type'),
//            $alert_rule_types,
//            FALSE,
//            ['class' => 'huge crm-select2',
////                'data-option-edit-path' => 'civicrm/admin/options/o8_device_sensor',
//                'multiple' => TRUE,
//                'placeholder' => ts('- Select Alert Type -'),
//                'select' => ['minimumInputLength' => 0]
//            ]);

        $this->add('select', 'alert_alert_rule_type',
            E::ts('Alert Type'),
            $alert_rule_types,
            FALSE,
            ['class' => 'huge crm-select2',
//                'data-option-edit-path' => 'civicrm/admin/options/o8_device_sensor',
                'multiple' => TRUE,
                'placeholder' => ts('- Select Alert Type -'),
                'select' => ['minimumInputLength' => 0]
            ]);

        $this->addDatePickerRange('alert_dateselect',
            'Select Date',
            FALSE,
            NULL,
            "From: ",
            "To: ",
            [],
            '_to',
            '_from'
        );
    }

    function alarm_filter()
    {
        /*
            aoData.push({ "name": "alarm_id",
                "value": $('#alarm_id').val() });
            aoData.push({ "name": "contact_id",
                "value": $('#alarm_contact_id').val() });
            aoData.push({ "name": "sensor_id",
                "value": $('#alarm_sensor_id').val() });
            aoData.push({ "name": "dateselect_from",
                "value": $('#alarm_dateselect_from').val() });
            aoData.push({ "name": "dateselect_to",
                "value": $('#alarm_dateselect_to').val() });
         */
        // ID or Code
        // Contact (Owner)
        // SensorID

        $this->add(
            'text',
            'alarm_id',
            ts('Alarm ID'),
            ['size' => 28, 'maxlength' => 128]);

        if ($this->_cid) {
            $this->addEntityRef('alarm_contact_id', E::ts('Device Owner'),
                false)->freeze();
        } else {
            $this->addEntityRef('alarm_contact_id', E::ts('Device Owner'),
                ['create' => false, 'multiple' => true, 'class' => 'huge'],
                false);
        }


        $this->add('select', 'alarm_sensor_id',
            E::ts('Sensor'),
            $this->_sensors,
            FALSE,
            ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_device_sensor',
                'multiple' => TRUE,
                'placeholder' => ts('- Select Sensor -'),
                'select' => ['minimumInputLength' => 0]
            ]);


        $this->add('select', 'alarm_sensor_id',
            E::ts('Sensor'),
            $this->_sensors,
            FALSE,
            ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/o8_device_sensor',
                'multiple' => TRUE,
                'placeholder' => ts('- Select Sensor -'),
                'select' => ['minimumInputLength' => 0]
            ]);

        $this->addDatePickerRange('alarm_dateselect',
            'Select Date'
            ,
            FALSE,
            NULL,
            "From: ",
            "To: ",
            [],
            '_to',
            '_from'
        );


    }

    public function setDefaultValues()
    {
        if ($this->_cid) {
            $defaults['device_contact_id'] =
                $this->_cid;
            $defaults['device_data_contact_id'] =
                $this->_cid;
            $defaults['alarm_rule_contact_id'] =
                $this->_cid;
            $defaults['alarm_contact_id'] =
                $this->_cid;
            $defaults['alert_rule_contact_id'] =
                $this->_cid;
            $defaults['alert_contact_id'] =
                $this->_cid;
            $defaults['chart_contact_id'] =
                $this->_cid;
        }
        return $defaults;
    }
}
