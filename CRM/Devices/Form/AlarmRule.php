<?php

use CRM_Devices_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Devices_Form_AlarmRule extends CRM_Core_Form
{
    protected $_id;

    protected $contact_id;

    protected $_alarm_rule;

    public function getDefaultEntity()
    {
        return 'AlarmRule';
    }

    public function getDefaultEntityTable()
    {
        return 'civicrm_o8_device_alarm_rule';
    }

    public function getEntityId()
    {
        return $this->_id;
    }

    public function getContactId()
    {
        return $this->contact_id;
    }


    /**
     * Preprocess form.
     *
     * This is called before buildForm. Any pre-processing that
     * needs to be done for buildForm should be done here.
     *
     * This is a virtual function and should be redefined if needed.
     */
    public function preProcess()
    {
        parent::preProcess();

        $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);
        $this->assign('action', $this->_action);
        $session = CRM_Core_Session::singleton();

        $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, FALSE);

        $this->contact_id = CRM_Utils_Request::retrieve('cid', 'Positive', $this, FALSE);

        CRM_Utils_System::setTitle('Add Alarm Rule');
        if ($this->_id) {
            CRM_Utils_System::setTitle('Edit Alarm Rule');
            $entities = civicrm_api4('AlarmRule', 'get', ['where' => [['id', '=', $this->_id]], 'limit' => 1]);
            if (!empty($entities)) {
                $this->_alarm_rule = $entities[0];
            }
            $this->assign('alarm_rule', $this->_alarm_rule);

            $session->replaceUserContext(CRM_Utils_System::url('civicrm/devices/alarmrule', ['id' => $this->getEntityId(), 'action' => 'update']));
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
    public function buildQuickForm()
    {
        $this->assign('id', $this->getEntityId());
        $this->add('hidden', 'id');
        if ($this->_action != CRM_Core_Action::DELETE) {
            $contact_id = $this->contact_id;
            if (!$contact_id) {
                $this->addEntityRef('contact_id', E::ts('Contact'), [], TRUE);
            }
            $sensors = CRM_Core_OptionGroup::values('o8_device_sensor');
            $this->add('select', 'sensor_id',
                E::ts('Sensor'),
                $sensors,
                TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor']);

            $rules = CRM_Core_OptionGroup::values('o8_device_rule_type');
            $this->add('select', 'rule_id',
                E::ts('Rule Type'),
                $rules,
                TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/health_alarm_rule_type']);
            $this->add('text', 'sensor_value', E::ts('Value'), ['size' => 60, 'maxlength' => 100], TRUE);
            $this->add('text', 'code', E::ts('Alarm Rule Code'), ['size' => 60, 'maxlength' => 100, 'disabled' => TRUE], FALSE);
            $this->addRule('code', ts('Device Code already exists in Database.'), 'objectExists', [
                'CRM_Devices_DAO_AlarmRule',
                $this->_id,
                'code',
                CRM_Core_Config::domainID(),
            ]);


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
    public function setDefaultValues()
    {
        if ($this->_alarm_rule) {
            $defaults = $this->_alarm_rule;
        }
        return $defaults;
    }

    public function postProcess()
    {
        $session = CRM_Core_Session::singleton();

        if ($this->_action == CRM_Core_Action::DELETE) {
            civicrm_api4('AlarmRule', 'delete', ['where' => [['id', '=', $this->_id]]]);
            CRM_Core_Session::setStatus(E::ts('Removed Alarm Rule'), E::ts('Alarm Rule'), 'success');
        } else {
            $values = $this->controller->exportValues();
            $action = 'create';
            if ($this->getEntityId()) {
                $params['id'] = $this->getEntityId();
                $action = 'update';
            }
            $contact_id = $this->contact_id;
            if (!$contact_id) {
                $contact_id = $values['contact_id'];
            }
            $contact_name = CRM_Contact_BAO_Contact::displayName($contact_id);
            $sensor_id = $values['sensor_id'];
            $sensor_name = CRM_Core_PseudoConstant::getLabel("CRM_Devices_BAO_AlarmRule", "sensor_id", $sensor_id);
            $sensor_value = $values['sensor_value'];
            $rule_id = $values['rule_id'];
            $rule_name = CRM_Core_PseudoConstant::getLabel("CRM_Devices_BAO_AlarmRule", "rule_id", $rule_id);
            if (!$values['code']) {
                $params['code'] = $contact_name . '_' . $sensor_name . '_' . $rule_name . '_' . $sensor_value;
            }
            $params['contact_id'] = $contact_id;
            $params['sensor_id'] = $sensor_id;
            $params['sensor_value'] = $sensor_value;
            $params['rule_id'] = $rule_id;
            civicrm_api4('AlarmRule', $action, ['values' => $params]);
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
    public function getRenderableElementNames()
    {
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
