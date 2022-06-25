<?php

use CRM_Devices_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Devices_Form_Device extends CRM_Core_Form
{
    protected $_id;

    protected $_device;

    protected $contact_id;

    public function getDefaultEntity()
    {
        return 'Device';
    }

    public function getDefaultEntityTable()
    {
        return 'civicrm_o8_device_device';
    }

    public function getEntityId()
    {
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
    public function preProcess()
    {
        parent::preProcess();

        $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);
        $this->assign('action', $this->_action);
        $session = CRM_Core_Session::singleton();

        $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, FALSE);

        $this->contact_id = CRM_Utils_Request::retrieve('cid', 'Positive', $this, FALSE);
        CRM_Utils_System::setTitle('Add Device');
        if ($this->_id) {
            CRM_Utils_System::setTitle('Edit Device');
            $entities = civicrm_api4('Device',
                'get',
                [
                    'checkPermissions' => FALSE,
                    'where' => [['id', '=', $this->_id]],
                    'limit' => 1
                ]);
            if (!empty($entities)) {
                $this->_device = $entities[0];
            }
            $this->assign('device', $this->_device);

            $session->replaceUserContext(CRM_Utils_System::url('civicrm/devices/device', ['id' => $this->getEntityId(), 'action' => 'update']));
            $url = CRM_Utils_System::url('civicrm/devices/search', 'reset=1');
            $session->pushUserContext($url);
        }
        $url = CRM_Utils_System::url('civicrm/devices/search', 'reset=1');
        $session->pushUserContext($url);
    }


    public function buildQuickForm()
    {
        $this->registerRule('deviceExists',
            'callback',
            'deviceExists', 'CRM_Utils_Rule');
        $this->assign('id', $this->getEntityId());
        $this->add('hidden', 'id');
        $contact_id = $this->contact_id;
        if ($this->_action != CRM_Core_Action::DELETE) {
            if (!$contact_id) {
                $this->addEntityRef('contact_id',
                    E::ts('Contact'),
                    [],
                    TRUE);
            }
            $this->add('text',
                'code',
                E::ts('Device Code'),
                ['class' => 'huge'], TRUE);
            $this->addRule('code', ts('Device Code already exists in Database.'),
                'objectExists', [
                    'CRM_Devices_DAO_Device',
                    $this->_id,
                    'code',
                    CRM_Core_Config::domainID(),
                ]);
            $this->addRule('code',
                ts('Device Code should consist of numbers and letters'),
                'alphanumeric', null, 'client');
            $types = CRM_Core_OptionGroup::values('o8_device_type');
            $this->add('select', 'device_type_id',
                E::ts('Device Type'),
                $types,
                TRUE, ['class' => 'huge crm-select2',
                    'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type']);

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
        if ($this->_device) {
            $defaults = $this->_device;
        }
        return $defaults;
    }

    public function postProcess()
    {
        $session = CRM_Core_Session::singleton();

        if ($this->_action == CRM_Core_Action::DELETE) {
            civicrm_api4('Device', 'delete',
                [
                    'checkPermissions' => FALSE,
                    'where' => [['id', '=', $this->_id]]
                ]);
            CRM_Core_Session::setStatus(E::ts('Removed Device'), E::ts('Device'), 'success');
        } else {
            $values = $this->controller->exportValues();
            $action = 'create';
            if ($this->getEntityId()) {
                $params['id'] = $this->getEntityId();
                $action = 'update';
            }
            $params['code'] = $values['code'];
//            $params['default_client'] = boolval($values['default_client']);
            $contact_id = $this->contact_id;
            if ($contact_id) {
                $params['contact_id'] = $contact_id;
            } else {
                $params['contact_id'] = $values['contact_id'];

            }
            $params['device_type_id'] = $values['device_type_id'];
            // todo many-to-many device-client
            civicrm_api4('Device', $action,
                [
                    'checkPermissions' => FALSE,
                    'values' => $params]);
        }
        $url = CRM_Utils_System::url('civicrm/devices/search', 'reset=1');
        $session->pushUserContext($url);
        parent::postProcess();
    }

}
