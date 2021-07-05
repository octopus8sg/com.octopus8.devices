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

    protected $_healthmonitor;

    public function getDefaultEntity() {
        return 'HealthMonitor';
    }

    public function getDefaultEntityTable() {
        return 'civicrm_health_monitor';
    }

    public function getEntityId() {
        return $this->_id;
    }

    public function preProcess() {
        parent::preProcess();

        $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);
        $this->assign('action', $this->_action);

        $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, FALSE);
        CRM_Utils_System::setTitle('Add Health Monitor Value');
        if ($this->_id) {
            CRM_Utils_System::setTitle('Edit Health Monitor Value');
            $entities = civicrm_api4('HealthMonitor', 'get', ['where' => [['id', '=', $this->_id]], 'limit' => 1]);
            $this->_healthmonitor = reset($entities);
            $this->assign('healthmonitor', $this->_healthmonitor);

            $session = CRM_Core_Session::singleton();
            $session->replaceUserContext(CRM_Utils_System::url('civicrm/healthmonitor/form', ['id' => $this->getEntityId(), 'action' => 'update']));
        }
    }

    public function buildQuickForm() {
        $this->assign('id', $this->getEntityId());
        $this->add('hidden', 'id');
        if ($this->_action != CRM_Core_Action::DELETE) {
            $this->addEntityRef('contact_id', E::ts('Contact'), [], TRUE);
            $this->add('timestamp', 'date', E::ts('Date'), null, FALSE);
            $this->add('text', 'device_id', E::ts('Device ID'), null, FALSE);
            $this->add('text', 'health_value', E::ts('Value'), null, FALSE);

            $this->addButtons([
                [
                    'type' => 'upload',
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

    public function setDefaultValues() {
        if ($this->_healthmonitor) {
            $defaults = $this->_healthmonitor;
        }
        return $defaults;
    }

    public function postProcess() {
        if ($this->_action == CRM_Core_Action::DELETE) {
            civicrm_api4('HealthMonitor', 'delete', ['where' => [['id', '=', $this->_id]]]);
            CRM_Core_Session::setStatus(E::ts('Removed Health Monitor Value'), E::ts('Health Monitor'), 'success');
        } else {
            $values = $this->controller->exportValues();
            $action = 'create';
            if ($this->getEntityId()) {
                $params['id'] = $this->getEntityId();
                $action = 'update';
            }
            $params['title'] = $values['title'];
            $params['contact_id'] = $values['contact_id'];
            civicrm_api4('HealthMonitor', $action, ['values' => $params]);
        }
        parent::postProcess();
    }

}
