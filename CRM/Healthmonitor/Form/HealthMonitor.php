<?php

use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Healthmonitor_Form_HealthMonitor extends CRM_Core_Form
{
    protected $_id;

    protected $contact_id;

    protected $_healthmonitor;

    public function getDefaultEntity()
    {
        return 'HealthMonitor';
    }

    public function getDefaultEntityTable()
    {
        return 'civicrm_health_monitor';
    }

    public function getEntityId()
    {
        return $this->_id;
    }

    public function preProcess()
    {
        parent::preProcess();

        $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);
        $this->assign('action', $this->_action);

        $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, FALSE);
        $contact_id = CRM_Utils_Request::retrieve('cid', 'Positive', $this, FALSE);
        $this->contact_id = $contact_id;
        CRM_Utils_System::setTitle('Add Device Data Value');
        $session = CRM_Core_Session::singleton();
        $url = CRM_Utils_System::url('civicrm/healthmonitor/search', 'reset=1');
        if ($this->_id) {
            CRM_Utils_System::setTitle('Edit Device Data Value');
            $entities = civicrm_api4('HealthMonitor', 'get', ['where' => [['id', '=', $this->_id]], 'limit' => 1]);
            $this->_healthmonitor = false;
            if (!empty($entities)) {
                $this->_healthmonitor = $entities[0];
            }
            $this->assign('healthmonitor', $this->_healthmonitor);

            $session->replaceUserContext(CRM_Utils_System::url('civicrm/healthmonitor/form', ['id' => $this->getEntityId(), 'action' => 'update']));
            $session->pushUserContext($url);
        }
        $session->pushUserContext($url);
    }

    public function buildQuickForm()
    {
        $contact_id = $this->contact_id;
        $this->assign('id', $this->getEntityId());
        $this->add('hidden', 'id');
        if ($this->_action != CRM_Core_Action::DELETE) {
            if (!$contact_id) {
                $this->addEntityRef('contact_id', E::ts('Contact'), [], TRUE);
            }
            $this->add('date', 'date', E::ts('Date'), CRM_Core_SelectValues::date(NULL, 'Y-m-d H:i:s'), TRUE);
            if (!$contact_id) {
                $types = CRM_Core_OptionGroup::values('health_monitor_device_type');
                $this->add('select', 'device_type_id',
                    E::ts('Device Type'),
                    $types,
                    TRUE, ['class' => 'huge crm-select2',
                        'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type']);
            }
            $sensors = CRM_Core_OptionGroup::values('health_monitor_sensor');
            $this->add('select', 'sensor_id',
                E::ts('Sensor'),
                $sensors,
                TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor']);

            if ($contact_id) {
                $this->addEntityRef('device_id', E::ts('Device'), [
                    'entity' => 'device',
                    'placeholder' => ts('- Select Device -'),
                    'select' => ['minimumInputLength' => 0],
                    'api' => [
                        'params' => ['contact_id' => $contact_id],
                    ]
                ], TRUE);
            } else {
                $this->addEntityRef('device_id', E::ts('Device'), [
                    'entity' => 'device',
                    'placeholder' => ts('- Select Device -'),
                    'select' => ['minimumInputLength' => 0],
                ], TRUE);
            }
            $this->add('text', 'sensor_value', E::ts('Value'), null, TRUE);

            $this->addButtons([
                [
                    'type' => 'done',
                    'name' => E::ts('Submit'),
                    'isDefault' => TRUE,
                ],
            ]);
        } else {
            $this->addButtons([
                ['type' => 'submit', 'name' => E::ts('Delete'), 'isDefault' => TRUE],
                ['type' => 'cancel', 'name' => E::ts('Cancel')]
            ]);
        }
        parent::buildQuickForm();
    }

    public
    function setDefaultValues()
    {
        if ($this->_healthmonitor) {
            $defaults = $this->_healthmonitor;
        }
        if (empty($defaults['device_type_id'])) {
            $defaults['device_type_id'] = CRM_Core_OptionGroup::getDefaultValue('health_monitor_device_type');
        }
        if (empty($defaults['sensor_id'])) {
            $defaults['sensor_id'] = CRM_Core_OptionGroup::getDefaultValue('health_monitor_sensor');
        }
        return $defaults;
    }

    public
    function postProcess()
    {
        if ($this->_action == CRM_Core_Action::DELETE) {
            civicrm_api4('HealthMonitor', 'delete', ['where' => [['id', '=', $this->_id]]]);
            CRM_Core_Session::setStatus(E::ts('Removed Device Data Value'), E::ts('Health Monitor'), 'success');
        } else {
            $values = $this->controller->exportValues();
//            CRM_Core_Error::debug_var('values', $values);
            $action = 'create';
            if ($this->getEntityId()) {
                $params['id'] = $this->getEntityId();
                $action = 'update';
            }

            $params['device_id'] = $values['device_id'];
            $params['sensor_value'] = $values['sensor_value'];
            if (isset($values['device_type_id'])) {
                $params['device_type_id'] = $values['device_type_id'];
            }
            $params['sensor_id'] = $values['sensor_id'];
            $date = $values['date'];
            $strdate = implode("-", $date);
            $valdate = CRM_Utils_Date::format($date);
//            CRM_Core_Error::debug_var('strdate', $strdate);
//            CRM_Core_Error::debug_var('valdate', $valdate);
//            CRM_Core_Error::debug_var('dvaldate', date($valdate));
            $params['date'] = $valdate;
//            CRM_Core_Error::debug_var('params', $params);
            if (isset($values['contact_id'])) {
                $params['contact_id'] = $values['contact_id'];
            }
            civicrm_api4('HealthMonitor', $action, ['values' => $params]);
        }
        $session = CRM_Core_Session::singleton();
        $url = CRM_Utils_System::url('civicrm/healthmonitor/search', 'reset=1');
        $session->pushUserContext($url);

        parent::postProcess();
    }

}
