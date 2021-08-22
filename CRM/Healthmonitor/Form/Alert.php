<?php

use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Healthmonitor_Form_Alert extends CRM_Core_Form {

    protected $_id;

    protected $_alert;

    public function getDefaultEntity() {
        return 'HealthAlert';
    }

    public function getDefaultEntityTable() {
        return 'civicrm_health_alert';
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
        CRM_Utils_System::setTitle('Add Alert');
        if ($this->_id) {
            CRM_Utils_System::setTitle('Edit Alert');
            $entities = civicrm_api4('HealthAlert', 'get', ['where' => [['id', '=', $this->_id]], 'limit' => 1]);
            if(!empty($entities)){
                $this->_alert = $entities[0];
            }
            $this->assign('alert', $this->_alert);

            $session->replaceUserContext(CRM_Utils_System::url('civicrm/alert/form', ['id' => $this->getEntityId(), 'action' => 'update']));
            $url = CRM_Utils_System::url('civicrm/healthalert/search', 'reset=1');
            $session->pushUserContext($url);
        }
        $url = CRM_Utils_System::url('civicrm/healthalert/search', 'reset=1');
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
            $healthAlertRules = civicrm_api4('HealthAlertRule', 'get', [
                'select' => [
                    'id',
                    'code',
                ]]);
            foreach ($healthAlertRules as $healthAlertRule){
                $rules[$healthAlertRule['id']] = $healthAlertRule['code'];
            }
            $this->add('select', 'alert_rule_id',
                E::ts('Rules'),
                $rules,
                TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/device/search']);

            $healthMonitors = civicrm_api4('HealthMonitor', 'get', [
                'select' => [
                    'id',
                    'contact_id',
                    'sensor_id:label',
                    'sensor_value',
                    'date',
                ]]);

            foreach ($healthMonitors as $healthMonitor){
                $datas[$healthMonitor['id']] = $healthMonitor['contact_id']
                    . "_" . $healthMonitor['sensor_id:label']
                    . "_" . $healthMonitor['sensor_value']
                    . "_" . $healthMonitor['date'];
            }
            $this->add('select', 'health_monitor_id',
                E::ts('Data'),
                $datas,
                TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/healthmonitor/search']);

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
        if ($this->_alert) {
            $defaults = $this->_alert;
        }
//        if (empty($defaults['default_client'])) {
//            $defaults['default_client'] = true;
//        }
//        if($this->_device['default_client'] === FALSE){
//            $defaults['default_client'] = false;
//        }
        return $defaults;
    }

    public function postProcess() {
        $session = CRM_Core_Session::singleton();

        if ($this->_action == CRM_Core_Action::DELETE) {
            civicrm_api4('HealthAlert', 'delete', ['where' => [['id', '=', $this->_id]]]);
            CRM_Core_Session::setStatus(E::ts('Removed Health Alert'), E::ts('Health Alert'), 'success');
        } else {
            $values = $this->controller->exportValues();
            $action = 'create';
            if ($this->getEntityId()) {
                $params['id'] = $this->getEntityId();
                $action = 'update';
            }

            $params['contact_id'] = $values['contact_id'];
            $params['alert_rule_id'] = $values['alert_rule_id'];
            $params['health_monitor_id'] = $values['health_monitor_id'];
            // todo many-to-many device-client
            civicrm_api4('HealthAlert', $action, ['values' => $params]);
        }
        $url = CRM_Utils_System::url('civicrm/healthalert/search', 'reset=1');
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
