<?php

require_once 'devices.civix.php';

// phpcs:disable
use CRM_Devices_ExtensionUtil as E;

// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function devices_civicrm_config(&$config)
{
    _devices_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function devices_civicrm_xmlMenu(&$files)
{
    _devices_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function devices_civicrm_install()
{
    _devices_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function devices_civicrm_postInstall()
{
    _devices_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function devices_civicrm_uninstall()
{
    _devices_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function devices_civicrm_enable()
{
    _devices_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function devices_civicrm_disable()
{
    _devices_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function devices_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL)
{
    return _devices_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function devices_civicrm_managed(&$entities)
{
    _devices_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Add CiviCase types provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function devices_civicrm_caseTypes(&$caseTypes)
{
    _devices_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Add Angular modules provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function devices_civicrm_angularModules(&$angularModules)
{
    // Auto-add module files from ./ang/*.ang.php
    _devices_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function devices_civicrm_alterSettingsFolders(&$metaDataFolders = NULL)
{
    _devices_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function devices_civicrm_entityTypes(&$entityTypes)
{
    _devices_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function devices_civicrm_themes(&$themes)
{
    _devices_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function devices_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function devices_civicrm_navigationMenu(&$menu)
{
    _devices_civix_insert_navigation_menu($menu, '', array(
        'label' => E::ts('Devices'),
        'name' => 'o8_devices',
        'icon' => 'crm-i fa-heartbeat',
        'url' => 'civicrm/devices/dashboard',
        'permission' => 'access CiviCRM',
        'navID' => 10,
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_insert_navigation_menu($menu, 'o8_devices', array(
        'label' => E::ts('Dashboard'),
        'name' => 'o8_devices_dashboard',
        'url' => 'civicrm/devices/dashboard',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_navigationMenu($menu);
    _devices_civix_insert_navigation_menu($menu, 'o8_devices', array(
        'label' => E::ts('Search Devices'),
        'name' => 'o8_devices_devicessearch',
        'url' => 'civicrm/devices/search',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_navigationMenu($menu);
    _devices_civix_insert_navigation_menu($menu, 'o8_devices', array(
        'label' => E::ts('Add Device'),
        'name' => 'o8_devices_add_device',
        'url' => 'civicrm/devices/device?reset=1&action=add',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_navigationMenu($menu);
    _devices_civix_insert_navigation_menu($menu, 'o8_devices', array(
        'label' => E::ts('Search Data'),
        'name' => 'o8_devices_devicedatasearch',
        'url' => 'civicrm/devices/searchdevicedata',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_navigationMenu($menu);
    _devices_civix_insert_navigation_menu($menu, 'o8_devices', array(
        'label' => E::ts('Add Data'),
        'name' => 'o8_devices_devicedata_add',
        'url' => 'civicrm/devices/devicedata?reset=1&action=add',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_navigationMenu($menu);
    _devices_civix_insert_navigation_menu($menu, 'o8_devices', array(
        'label' => E::ts('Search Alerts'),
        'name' => 'o8_devices_searchalert',
        'url' => 'civicrm/devices/searchalert',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_navigationMenu($menu);
    _devices_civix_insert_navigation_menu($menu, 'o8_devices', array(
        'label' => E::ts('Device Reports'),
        'name' => 'o8_devices_report_devices',
        'url' => CRM_Utils_System::url('civicrm/report/list', ['grp' => 'devices', 'reset' => 1]),
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 2,
    ));
    _devices_civix_navigationMenu($menu);
}


/**
 * @param $path
 * @param $tabs
 * @param $context
 * @throws CiviCRM_API3_Exception
 */

function devices_civicrm_tabset($path, &$tabs, $context)
{
    if ($path === 'civicrm/contact/view') {
        $devices_count = 0;
        // add a tab to the contact summary screen
        $contactId = $context['contact_id'];
        $url = CRM_Utils_System::url('civicrm/devices/contacttab', ['cid' => $contactId]);
        try {
            $myEntities = civicrm_api3('Device', 'get', [
                'contact_id' => $contactId,
                'sequential' => 1,
            ]);
            $devices_count = $myEntities['count'];
        } catch (CRM_Core_Exception $e) {
            CRM_Core_Error::debug_var('some_error_in_devices_tab', $e->getMessage());
            return;
        }
        $tabs[] = array(
            'id' => 'contact_devices',
            'url' => $url,
            'count' => $devices_count,
            'title' => E::ts('Devices'),
            'weight' => 310,
            'icon' => 'crm-i fa-heartbeat',
            'rows' => [
                ['id' => 1],
                ['id' => 2]]
        );
    }

}

/** function before saving device data, the same with API
 * @param $op
 * @param $objectName
 * @param $id
 * @param $params
 * @return string
 * @throws API_Exception
 * @throws \Civi\API\Exception\NotImplementedException
 */
function devices_civicrm_pre($op, $objectName, $id, &$params)
{
    return _devices_civicrm_pre($op, $objectName, $id, $params);
}


/** Validation of a rule - no need to have two rules for the same thing
 * @param $formName
 * @param $fields
 * @param $files
 * @param $form
 * @param $errors
 * @throws API_Exception
 * @throws \Civi\API\Exception\NotImplementedException
 */

function devices_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors)
{
    /*    CRM_Core_Error::debug_var('formName', $formName);*/
//    CRM_Core_Error::debug_var('fields', $fields);
//    CRM_Core_Error::debug_var('errors', $errors);
//    CRM_Core_Error::debug_var('contact_id', $form->getContactId());

    if ($formName == 'CRM_Devices_Form_AlarmRule') {
        $contact_id = $form->getContactId();
        $sensor_id = $fields['sensor_id'];
        $rule_id = $fields['rule_id'];
        $sensor_value = $fields['sensor_value'];
        $alarmrules = civicrm_api4('AlarmRule', 'get',
            [
                'checkPermissions' => FALSE,
                'where' => [
                    ['contact_id', '=', $contact_id],
                    ['sensor_id', '=', $sensor_id],
                    ['rule_id', '=', $rule_id],
                    ['sensor_value', '=', $sensor_value],
                ]])->jsonSerialize();
        if (sizeof($alarmrules) > 0) {
//            CRM_Core_Error::debug_var('alarmrules', $alarmrules);
            $message = "Rule already exists";
            $title = "Error: Rule already Exists";
            $type = 'error';
            $options = [];
            CRM_Core_Session::setStatus($message, $title, $type, $options);
//            CRM_Core_Session::setStatus($title . $message, '', 'no-popup');
            $form->assign('error', $message);
            $errors['error'] = $message;
            return;
        }
    }

}


/**
 * This function checks for device id or device code or device owner
 * @param $op
 * @param $objectName
 * @param $id
 * @param $params
 * @return string
 * @throws API_Exception
 * @throws \Civi\API\Exception\NotImplementedException
 */
function _devices_civicrm_pre($op, $objectName, $id, &$params)
{
//    CRM_Core_Error::debug_var('op', $op);
//    CRM_Core_Error::debug_var('objectName', $objectName);
//    CRM_Core_Error::debug_var('id', $id);
//    CRM_Core_Error::debug_var('params', $params);
//    if ($op == 'create' && $objectName == 'DeviceData') {
//        $contact_id = 0;
//        if (isset($params['contact_id'])) {
//            $contact_id = $params['contact_id'];
//        }
//        if (!isset($params['device_id']) and isset($params['device_code'])) {
//            $devices = civicrm_api4('Device', 'get', [
//                'select' => [
//                    'id',
//                ],
//                'where' => [
//                    ['code', '=', $params['device_code']],
//                ],
//                'limit' => 2,
//            ]);
//            if (!empty($devices)) {
//                $device_id = $devices[0]['id'];
//                $params['device_id'] = $device_id;
//            }
//        }
//        if (!isset($params['device_id'])) {
//            return "The field device_code and/or device_id is mandatory";
//        }
//        if ((!isset($params['contact_id']) or !isset($params['device_type_id'])) and isset($params['device_id'])) {
//            $devices = civicrm_api4('Device', 'get', [
//                'select' => [
//                    'contact_id',
//                    'device_type_id',
//                ],
//                'where' => [
//                    ['id', '=', $params['device_id']],
//                ],
//                'limit' => 2,
//            ]);
//            if (!empty($devices)) {
//                if (!isset($params['contact_id'])) {
//                    $contact_id = $devices[0]['contact_id'];
//                }
//                if (!isset($params['device_type_id'])) {
//                    $device_type_id = $devices[0]['device_type_id'];
//                }
//            }
//            $params['contact_id'] = $contact_id;
//            $params['device_type_id'] = $device_type_id;
//        } else {
//            return "The field device_code and/or device_id and/or contact_id is mandatory";
//        }
//    }
}

/*
 * We hook here to disable permission checks
 */
function devices_civicrm_alterAPIPermissions($entity, $action, &$params, &$permissions)
{
//    CRM_Core_Error::debug_var('APIPermission_entity',$entity);
//    CRM_Core_Error::debug_var('APIPermission_action',$action);
//    CRM_Core_Error::debug_var('APIPermission_params',$params);
//    CRM_Core_Error::debug_var('APIPermission_permissions',$permissions);
    $params = disableCheckPermissionsCreateDeviceData($entity, $action, $params);
}

/**
 * @param $entity
 * @param $action
 * @param $params
 * @return mixed
 */
function disableCheckPermissionsCreateDeviceData($entity, $action, &$params)
{
    if ($entity == "device_data" and $action == 'create') {
        $params['check_permissions'] = false;
    }
    return $params;
}
