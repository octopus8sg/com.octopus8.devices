<?php

use CRM_Devices_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Devices_Form_DeviceData extends CRM_Core_Form
{
    protected $_id;

    protected $contact_id;

    protected $_devicedata;

    public function getDefaultEntity()
    {
        return 'DeviceData';
    }

    public function getDefaultEntityTable()
    {
        return 'civicrm_o8_device_data';
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
        CRM_Utils_System::setTitle('Add Device Data');
        $session = CRM_Core_Session::singleton();
        $url = CRM_Utils_System::url('civicrm/devices/searchdevicedata', 'reset=1');
        if ($this->_id) {
            CRM_Utils_System::setTitle('Edit Device Data');
            $entities = civicrm_api4('DeviceData',
                'get',
                [
                    'checkPermissions' => FALSE,
                    'where' => [
                        ['id', '=', $this->_id]],
                    'limit' => 1
                ]);
            $this->_devicedata = false;
            if (!empty($entities)) {
                $this->_devicedata = $entities[0];
            }
            $this->assign('devicedata', $this->_devicedata);

            $session->replaceUserContext(CRM_Utils_System::url('civicrm/devices/devicedata', ['id' => $this->getEntityId(), 'action' => 'update']));
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
//            if (!$contact_id) {
//                $this->addEntityRef('contact_id', E::ts('Contact'), [], TRUE);
//            }
            $this->add('date', 'date', E::ts('Date'), CRM_Core_SelectValues::date(NULL, 'Y-m-d H:i:s'), TRUE);
            $sensors = CRM_Core_OptionGroup::values('o8_device_sensor');
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
                        'extra' => ['device_id.device_type_id.title', 'contact_id.sort_name'],
                        'search_field' => 'code',
                        'label_field' => 'code',
                        'params' => ['contact_id' => $contact_id],
                    ]
                ], TRUE);
                $this->addEntityRef('contact_id', E::ts('Contact'), [], TRUE)->freeze();
            } else {
//                $this->addEntityRef('device_id', E::ts('Device'), [
//                    'entity' => 'device',
//                    'placeholder' => ts('- Select Device -'),
//                    'select' => ['minimumInputLength' => 0],
//                    'api' => [
//                        'extra' => ['device_id.device_type_id.title', 'contact_id.sort_name'],
//                        'search_field' => 'code',
//                        'label_field' => 'code',
//                    ]
//                ], TRUE);
                $this->addEntityRef('device_id', E::ts('Device'), [
                    'api' => [
                        'search_fields' => ['code', 'device_type_id.label', 'contact_id.sort_name'],
                        'label_field' => "code",
                        'description_field' => [
                            'id',
                            'device_type_id.label',
                            'contact_id.sort_name',
                        ]
                    ],
                    'entity' => 'device',
                    'select' => ['minimumInputLength' => 0],
                    'class' => 'huge',
                    'placeholder' => ts('- Select Device -'),
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

    public function setDefaultValues()
    {
        if ($this->_devicedata) {
            $defaults = $this->_devicedata;
        }
        if (empty($defaults['sensor_id'])) {
            $defaults['sensor_id'] =
                CRM_Core_OptionGroup::getDefaultValue('o8_device_sensor');
        }
        return $defaults;
    }

    public
    function postProcess()
    {
        if ($this->_action == CRM_Core_Action::DELETE) {
            civicrm_api4('DeviceData',
                'delete',
                [
                    'checkPermissions' => FALSE,
                    'where' => [['id', '=', $this->_id]]
                ]);
            CRM_Core_Session::setStatus(E::ts('Removed Device Data Value'), E::ts('Device Data'), 'success');
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
            } else {
                $devices = civicrm_api4('Device', 'get', [
                    'checkPermissions' => FALSE,
                    'select' => [
                        'contact_id',
                    ],
                    'where' => [
                        ['id', '=', $params['device_id']],
                    ],
                    'limit' => 2,
                ]);
                if (!empty($devices)) {
                    $contact_id = $devices[0]['contact_id'];
                    $params['contact_id'] = $contact_id;
                }
            }
            civicrm_api4('DeviceData', $action, ['checkPermissions' => FALSE,
                'values' => $params]);
        }
        $session = CRM_Core_Session::singleton();
        $url = CRM_Utils_System::url('civicrm/devices/searchdevicedata', 'reset=1');
        $session->pushUserContext($url);

        parent::postProcess();
    }

}
