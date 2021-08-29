<?php

use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Healthmonitor_Form_AlertRule extends CRM_Core_Form
{

    protected $_id;

    protected $contact_id;

    protected $_alert_rule;

    public function getDefaultEntity()
    {
        return 'HealthAlertRule';
    }

    public function getDefaultEntityTable()
    {
        return 'civicrm_health_alert_rule';
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
        CRM_Utils_System::setTitle('Add Alert Rule');
        if ($this->_id) {
            CRM_Utils_System::setTitle('Edit Alert Rule');
            $entities = civicrm_api4('HealthAlertRule', 'get', ['where' => [['id', '=', $this->_id]], 'limit' => 1]);
            if (!empty($entities)) {
                $this->_alert_rule = $entities[0];
            }
            $this->assign('alert_rule', $this->_alert_rule);

            $session->replaceUserContext(CRM_Utils_System::url('civicrm/alert_rule/form', ['id' => $this->getEntityId(), 'action' => 'update']));
            $url = CRM_Utils_System::url('civicrm/health_alert_rule/search', 'reset=1');
            $session->pushUserContext($url);
        }
        $url = CRM_Utils_System::url('civicrm/health_alert_rule/search', 'reset=1');
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
                $this->addEntityRef('contact_id', E::ts('Device User'), [], TRUE);
            }
            $this->addEntityRef('addressee_id', E::ts('Addressee'), [], TRUE);
            if (!$contact_id) {
                $this->addEntityRef('rule_id', E::ts('Alarm Rule'), [
                    'entity' => 'HealthAlarmRule',
                    'placeholder' => ts('- Select Alarm -'),
                    'select' => ['minimumInputLength' => 0],
                    'api' => ['search_field' => 'code',
                        'label_field' => 'code']
                ], TRUE);
            } else {
                $this->addEntityRef('rule_id', E::ts('Alarm Rule'), [
                    'entity' => 'HealthAlarmRule',
                    'placeholder' => ts('- Select Alarm -'),
                    'select' => ['minimumInputLength' => 0],
                    'api' => ['search_field' => 'code',
                        'label_field' => 'code',
                        'params' => ['contact_id' => $contact_id],
                    ]
                ], TRUE);
            }
            $this->add('text', 'title', E::ts('Alert Title'), ['size' => 60, 'maxlength' => 100], FALSE);
            $this->add('textarea', 'message', E::ts('Alert Message'), [
                'cols' => '58',
                'rows' => '1',
            ], FALSE);
            $this->add('checkbox', 'civicrm', E::ts('Send CiviCRM Note?'), null, FALSE);
            $this->add('checkbox', 'email', E::ts('Send Email?'), null, FALSE);

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
        if ($this->_alert_rule) {
            $defaults = $this->_alert_rule;
        }
//        if (empty($defaults['default_client'])) {
//            $defaults['default_client'] = true;
//        }
//        if($this->_device['default_client'] === FALSE){
//            $defaults['default_client'] = false;
//        }
        return $defaults;
    }

    public function postProcess()
    {
        $session = CRM_Core_Session::singleton();

        if ($this->_action == CRM_Core_Action::DELETE) {
            civicrm_api4('HealthAlertRule', 'delete', ['where' => [['id', '=', $this->_id]]]);
            CRM_Core_Session::setStatus(E::ts('Removed Health AlertRule'), E::ts('Health AlertRule'), 'success');
        } else {
            $values = $this->controller->exportValues();
//            CRM_Core_Error::debug_var('alert_rules_form_values', $values);
            $action = 'create';
            if ($this->getEntityId()) {
                $params['id'] = $this->getEntityId();
                $action = 'update';
            }
            $contact_id = $this->contact_id;
            if (!$contact_id) {
                $contact_id = $values['contact_id'];
            }
            $addressee_id = $values['addressee_id'];
            $title = $values['title'];
            $message = $values['message'];
            $civicrm = $values['civicrm'];
            $email = $values['email'];
            $addressee_name = CRM_Contact_BAO_Contact::displayName($addressee_id);
            $rule_id = $values['rule_id'];
            $rule_name = CRM_Healthmonitor_DAO_HealthAlarmRule::findById($rule_id)->code;
            if (!$values['code']) {
                $params['code'] = $addressee_name . '_' . $rule_name . '_' . rand(10000, 99999);
            }
            $params['contact_id'] = $contact_id;
            $params['addressee_id'] = $addressee_id;
            $params['rule_id'] = $rule_id;
            $params['title'] = $title;
            $params['message'] = $message;
            $params['civicrm'] = $civicrm;
            $params['email'] = $email;
            civicrm_api4('HealthAlertRule', $action, ['values' => $params]);
        }
        $url = CRM_Utils_System::url('civicrm/health_alert_rule/search', 'reset=1');
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
