<?php

use CRM_Devices_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Devices_Form_Alarm extends CRM_Core_Form {

    protected $_id;

    protected $_alarm;

    public function getDefaultEntity() {
        return 'Alarm';
    }

    public function getDefaultEntityTable() {
        return 'civicrm_o8_device_alarm';
    }

    public function getEntityId() {
        return $this->_id;
    }


    /**
     * Preprocess form.
     *
     * This is called before buildForm. Any pre-processing that
     * needs to be done for buildForm should be done here.
     *
     * This is a virtual function and should be redefined if needed.
     */
    public function preProcess() {
        parent::preProcess();

        $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);
        $this->assign('action', $this->_action);
        $session = CRM_Core_Session::singleton();

        $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, FALSE);
        CRM_Utils_System::setTitle('Add Alarm');
        if ($this->_id) {
            CRM_Utils_System::setTitle('Edit Alarm');
            $entities = civicrm_api4('Alarm', 'get', ['where' => [['id', '=', $this->_id]], 'limit' => 1]);
            if(!empty($entities)){
                $this->_alarm = $entities[0];
            }
            $this->assign('alarm', $this->_alarm);

            $session->replaceUserContext(CRM_Utils_System::url('civicrm/devices/alarm', ['id' => $this->getEntityId(), 'action' => 'update']));
            $url = CRM_Utils_System::url('civicrm/devices/dashboard', 'reset=1');
            $session->pushUserContext($url);
        }
        $url = CRM_Utils_System::url('civicrm/devices/dashboard', 'reset=1');
        $session->pushUserContext($url);
        $this->assign('elementNames', $this->getRenderableElementNames());
    }


    /**
     * @throws CRM_Core_Exception
     */
    public function buildQuickForm() {
        $this->assign('id', $this->getEntityId());
        $this->add('hidden', 'id');
        if ($this->_action != CRM_Core_Action::DELETE) {
            $this->addEntityRef('contact_id', E::ts('Contact'), [], TRUE);
            $rules = [];
            $AlarmRules = civicrm_api4('AlarmRule', 'get', [
                'select' => [
                    'id',
                    'code',
                ]]);
            foreach ($AlarmRules as $AlarmRule){
                $rules[$AlarmRule['id']] = $AlarmRule['code'];
            }
            $this->add('select', 'alarm_rule_id',
                E::ts('Rules'),
                $rules,
                TRUE, ['class' => 'huge crm-select2']);

            $device_datas = civicrm_api4('DeviceData', 'get', [
                'select' => [
                    'id',
                    'contact_id',
                    'sensor_id:label',
                    'sensor_value',
                    'date',
                ]]);

            foreach ($device_datas as $device_data){
                $datas[$device_data['id']] = $device_data['contact_id']
                    . "_" . $device_data['sensor_id:label']
                    . "_" . $device_data['sensor_value']
                    . "_" . $device_data['date'];
            }
            $this->add('select', 'device_data_id',
                E::ts('Data'),
                $datas,
                TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/devices/search']);

            $this->addButtons([
                [
                    'type' => 'done',
                    'name' => E::ts('Submit'),
                    'isDefault' => TRUE,
                ],
            ]);
        } else {
            $this->addButtons([
                ['type' => 'done', 'name' => E::ts('Delete'), 'isDefault' => TRUE],
                ['type' => 'cancel', 'name' => E::ts('Cancel')]
            ]);
        }
        parent::buildQuickForm();
    }


    /**
     * This virtual function is used to set the default values of various form
     * elements.
     *
     * @return array|NULL
     *   reference to the array of default values
     */
    public function setDefaultValues() {
        if ($this->_alarm) {
            $defaults = $this->_alarm;
        }
        return $defaults;
    }

    public function postProcess() {
        $session = CRM_Core_Session::singleton();

        if ($this->_action == CRM_Core_Action::DELETE) {
            civicrm_api4('Alarm', 'delete', ['where' => [['id', '=', $this->_id]]]);
            CRM_Core_Session::setStatus(E::ts('Removed Device Alarm'), E::ts('Health Alarm'), 'success');
        } else {
            $values = $this->controller->exportValues();
            $action = 'create';
            if ($this->getEntityId()) {
                $params['id'] = $this->getEntityId();
                $action = 'update';
            }

            $params['contact_id'] = $values['contact_id'];
            $params['alarm_rule_id'] = $values['alarm_rule_id'];
            $params['device_data_id'] = $values['device_data_id'];
            civicrm_api4('Alarm', $action, ['values' => $params]);
        }
        $url = CRM_Utils_System::url('civicrm/devices/dashboard', 'reset=1');
        $session->pushUserContext($url);
        parent::postProcess();
    }

    /**
     * Get the fields/elements defined in this form.
     *
     * @return array (string)
     */
    public function getRenderableElementNames() {
        // The _elements list includes some items which should not be
        // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
        // items don't have labels.  We'll identify renderable by filtering on
        // the 'label'.
        $elementNames = array();
        foreach ($this->_elements as $element) {
            /** @var HTML_QuickForm_Element $element */
            $label = $element->getLabel();
            if (!empty($label)) {
                $elementNames[] = $element->getName();
            }
        }
        return $elementNames;
    }


}
