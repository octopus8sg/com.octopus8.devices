<?php

use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Healthmonitor_Form_DeviceFilter extends CRM_Core_Form {
    public function buildQuickForm() {

        // add device type filter
        $types = CRM_Core_OptionGroup::values('health_monitor_device_type');
        $this->add('select', 'device_device_type_id',
            E::ts('Device Type'),
            $types,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type','placeholder' => ts('- Select Device Type -'),
                'select' => ['minimumInputLength' => 0]]);
        $this->assign('suppressForm', FALSE);
    }

}
