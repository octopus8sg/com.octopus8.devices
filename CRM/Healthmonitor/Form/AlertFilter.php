<?php

use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Healthmonitor_Form_HealthAlertFilter extends CRM_Core_Form
{
    public function buildQuickForm()
    {

        // add hm data search filters

        $sensors = CRM_Core_OptionGroup::values('health_monitor_sensor');

        //for alert rule filter
        $this->add('select', 'alert_sensor_id',
            E::ts('Sensor'),
            $sensors,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor', 'placeholder' => ts('- Select Sensor -'),
                'select' => ['minimumInputLength' => 1]]);

        // contact - for data and adressee filters
        $this->addEntityRef('alert_contact_id', E::ts('Contact'), ['create' => false, 'multiple' => true], false, array('class' => 'huge'));

        $this->addEntityRef('alert_addressee_id', E::ts('Addressee'), ['create' => false, 'multiple' => true], false, array('class' => 'huge'));

        $this->addDatePickerRange('alert_dateselect',
            'Select Date',
            FALSE,
            FALSE,
            'From: ',
            'To: ',
            null,
            '_to',
            '_from');


        $this->add('checkbox', 'alert_civicrm', ts('CiviCRM'))->setChecked(true);
        $this->add('checkbox', 'alert_email', ts('Email'));
        $this->add('checkbox', 'alert_telegram', ts('Telegram'));
        $this->add('checkbox', 'alert_api', ts('API'));

        $this->assign('suppressForm', FALSE);
    }

}
