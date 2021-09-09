<?php

require_once 'healthmonitor.civix.php';

// phpcs:disable
use CRM_Healthmonitor_ExtensionUtil as E;

// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function healthmonitor_civicrm_config(&$config)
{
    _healthmonitor_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function healthmonitor_civicrm_xmlMenu(&$files)
{
    _healthmonitor_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function healthmonitor_civicrm_install()
{
    _healthmonitor_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function healthmonitor_civicrm_postInstall()
{
    _healthmonitor_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function healthmonitor_civicrm_uninstall()
{
    _healthmonitor_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function healthmonitor_civicrm_enable()
{
    _healthmonitor_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function healthmonitor_civicrm_disable()
{
    _healthmonitor_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function healthmonitor_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL)
{
    return _healthmonitor_civix_civicrm_upgrade($op, $queue);
}

function healthmonitor_civicrm_pre($op, $objectName, $id, &$params)
{
    return _healthmonitor_civicrm_pre($op, $objectName, $id, $params);
}

function healthmonitor_civicrm_post($op, $objectName, $id, &$params)
{
    // function for catching health monitor and alarm posts
//    return _healthmonitor_civicrm_post($op, $objectName, $id, $params);
//    CRM_Core_Error::debug_var('op', $op);
//    CRM_Core_Error::debug_var('objectName', $objectName);
//    CRM_Core_Error::debug_var('post_id', $id);
    $sensors = CRM_Core_OptionGroup::values('health_monitor_sensor', FALSE, FALSE, FALSE, null, 'name');
    $rules = CRM_Core_OptionGroup::values('health_alarm_rule_type', FALSE, FALSE, FALSE, null, 'name');
//    CRM_Core_Error::debug_var('sensors', $sensors);
//    CRM_Core_Error::debug_var('rules', $rules);

    if ($op === 'create' AND $objectName === 'HealthMonitor') {
        $healtmonitor_id = $id;
        $contact_id = $params->contact_id;
        $sensor_id = $params->sensor_id;
        $sensor = $sensors[$sensor_id];
        $alarmrules = \Civi\Api4\HealthAlarmRule::get()
            ->setWhere([['sensor_id', '=', $sensor_id],
                ['contact_id', '=', $contact_id]])->setOrderBy(['id' => 'DESC'])
            ->execute()->jsonSerialize();

//        CRM_Core_Error::debug_var('alarmrules', $alarmrules);
        $break = false;
        foreach ($alarmrules as $alarmrule) {
            $result = [];
            $rule = $rules[$alarmrule['rule_id']];
            switch ($rule) {
                case 'eq':
                    if ($alarmrule['sensor_value'] == $params->sensor_value) {
                        $result = civicrm_api3('HealthAlarm', 'create', [
                            'contact_id' => $contact_id,
                            'health_monitor_id' => $healtmonitor_id,
                            'alarm_rule_id' => $alarmrule['id'],
                        ]);
                        $break = true;
                    }
                    break;

                case 'ne':
                    if ($params->sensor_value <> $alarmrule['sensor_value']) {
                        $result = civicrm_api3('HealthAlarm', 'create', [
                            'contact_id' => $contact_id,
                            'health_monitor_id' => $healtmonitor_id,
                            'alarm_rule_id' => $alarmrule['id'],
                        ]);
                        $break = true;
                    }
                    break;

                case 'le':
                    if ($params->sensor_value <= $alarmrule['sensor_value']) {
                        $result = civicrm_api3('HealthAlarm', 'create', [
                            'contact_id' => $contact_id,
                            'health_monitor_id' => $healtmonitor_id,
                            'alarm_rule_id' => $alarmrule['id'],
                        ]);
                        $break = true;
                    }
                    break;

                case 'lt':
                    if ($params->sensor_value < $alarmrule['sensor_value']) {
                        $result = civicrm_api3('HealthAlarm', 'create', [
                            'contact_id' => $contact_id,
                            'health_monitor_id' => $healtmonitor_id,
                            'alarm_rule_id' => $alarmrule['id'],
                        ]);
                        $break = true;
                    }
                    break;
                case 'ge':
                    if ($params->sensor_value >= $alarmrule['sensor_value']) {
                        $result = civicrm_api3('HealthAlarm', 'create', [
                            'contact_id' => $contact_id,
                            'health_monitor_id' => $healtmonitor_id,
                            'alarm_rule_id' => $alarmrule['id'],
                        ]);
                        $break = true;
                    }
                    break;
                case 'gt':
                    if ($params->sensor_value > $alarmrule['sensor_value']) {
                        $result = civicrm_api3('HealthAlarm', 'create', [
                            'contact_id' => $contact_id,
                            'health_monitor_id' => $healtmonitor_id,
                            'alarm_rule_id' => $alarmrule['id'],
                        ]);
                        $break = true;
                    }
                    break;
            }
//            CRM_Core_Error::debug_var('result', $result);
            if ($break == true) return;
        }
        //    check and create health monitor
        // check for rule - contact, sensor_id
        // check rule case
        // create / return

    }
    if ($op === 'create' AND $objectName === 'HealthAlarm') {
//        CRM_Core_Error::debug_var('ha_post_params', $params);
        $alarm_id = $params->id;
        $alarm_rule_id = $params->alarm_rule_id;
        $health_monitor_id = $params->health_monitor_id;
//        $alertrules = \Civi\Api4\HealthAlertRule::get()
//            ->setWhere([['rule_id', '=', $alarm_rule_id]])->setOrderBy(['id' => 'DESC'])
//            ->execute()->jsonSerialize();
        $alertrules = civicrm_api4('HealthAlertRule', 'get', ['where' => [['rule_id', '=', $alarm_rule_id]]]);
        $siteurl = CRM_Utils_System::absoluteURL('');
        $healtmonitors = civicrm_api4('HealthMonitor', 'get', ['where' => [['id', '=', $health_monitor_id]], 'limit' => 1]);
        if (!empty($healtmonitors)) {
            $healtmonitor = $healtmonitors[0];
        }
//        CRM_Core_Error::debug_var('healtmonitor', $healtmonitor);

//        $device_id = $healtmonitor->device_id;
        $device_id = $healtmonitor['device_id'];
        $devices = civicrm_api4('Device', 'get', ['where' => [['id', '=', $device_id]], 'limit' => 1]);
        if (!empty($devices)) {
            $device = $devices[0];
        }
        $device_name = $device['name'];
        $device_type_id = $device['device_type_id'];
        $device_type = CRM_Core_PseudoConstant::getLabel("CRM_Healthmonitor_BAO_Device", "device_type_id", $device_type_id);
        $contact_id = $params->contact_id;
        $contact_name = CRM_Contact_BAO_Contact::displayName($contact_id);
        $sensor_id = $healtmonitor['sensor_id'];
        $sensor_type = CRM_Core_PseudoConstant::getLabel("CRM_Healthmonitor_BAO_HealthAlarmRule", "sensor_id", $sensor_id);
        $sensor_value = $healtmonitor['sensor_value'];
        $date = $healtmonitor['date'];
//        CRM_Core_Error::debug_var('alertrules', $alertrules);
        foreach ($alertrules as $alertrule) {
//            CRM_Core_Error::debug_var('healtmonitor', $healtmonitor);
            $alert_rule_id = $alertrule['id'];
            $rule_id = $alertrule['rule_id'];
            $alarmrules = \Civi\Api4\HealthAlarmRule::get()
                ->setWhere([['id', '=', $rule_id]])
                ->execute()->jsonSerialize();
            if (!empty($alarmrules)) {
                $alarmrule = $alarmrules[0];
            }
//            CRM_Core_Error::debug_var('alarmrule', $alarmrule);
            $rule = $rules[$alarmrule['rule_id']];
            $rule_name = strtoupper($rule) . ' ' . $alarmrule['sensor_value'];
            $addressee_name = CRM_Contact_BAO_Contact::displayName($alertrule['addressee_id']);
            $title = "Device Alarm: " . $siteurl;
            $message = "Alarm for: " . $addressee_name . "\n";
            $message .= "Message: " . $alertrule['message'] . "\n";
            $message .= "Site: " . $siteurl . "\n";
            $message .= "Device Code: " . $device_name . "\n";
            $message .= "Contact ID: " . $contact_id . "\n";
            $message .= "Contact Name: " . $contact_name . "\n";
            $message .= "Device Type: " . $device_type . "\n";
            $message .= "Sensor Type: " . $sensor_type . "\n";
            $message .= "Sensor Value: " . $sensor_value . "\n";
            $message .= "Rule Name: " . $rule_name . "\n";
            $message .= "Date: " . $date . "\n";
            $civicrm_date = null;
            $email_date = null;
            $messagehtml = nl2br($message);
//            CRM_Core_Error::debug_var('alertrule', $alertrule);
            if ($alertrule['civicrm'] === TRUE) {
                $result = civicrm_api3('Note', 'create', [
                    'entity_id' => $alertrule['addressee_id'],
                    'note' => $message,
                    'subject' => $title,
                ]);
                if ($result) {
                    $civicrm_date = date("Y-m-d H:i:s");
                }
            }
//            CRM_Core_Error::debug_var('result', $result);
            if ($alertrule['email'] === TRUE) {
//            if (TRUE === TRUE) {

                $mailParams = [
                    'groupName' => 'Activity Email Sender',
                    'from' => CRM_Contact_BAO_Contact::getPrimaryEmail($alertrule['contact_id']),
                    'toName' => $addressee_name,
                    'toEmail' => CRM_Contact_BAO_Contact::getPrimaryEmail($alertrule['addressee_id']),
                    'subject' => $title,
                    'text' => $message,
                    'html' => $messagehtml,
                    'attachments' => null,
                ];
//                CRM_Core_Error::debug_var('mailparams', $mailParams);
                if (!CRM_Utils_Mail::send($mailParams)) {
                    return FALSE;
                } else {
                    $email_date = date("Y-m-d H:i:s");
                }
            }

            $result = civicrm_api3('HealthAlert', 'create', [
                'contact_id' => $contact_id,
                'health_alarm_id' => $alarm_id,
                'alert_rule_id' => $alert_rule_id,
                'civicrm' => $civicrm_date,
                'email' => $email_date,
            ]);
        }
//    check and create health alert
        return;
    }
    return;
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function healthmonitor_civicrm_managed(&$entities)
{
    _healthmonitor_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function healthmonitor_civicrm_caseTypes(&$caseTypes)
{
    _healthmonitor_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function healthmonitor_civicrm_angularModules(&$angularModules)
{
    _healthmonitor_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function healthmonitor_civicrm_alterSettingsFolders(&$metaDataFolders = NULL)
{
    _healthmonitor_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function healthmonitor_civicrm_entityTypes(&$entityTypes)
{
    _healthmonitor_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function healthmonitor_civicrm_themes(&$themes)
{
    _healthmonitor_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function healthmonitor_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function healthmonitor_civicrm_navigationMenu(&$menu)
{
    _healthmonitor_civix_insert_navigation_menu($menu, '', array(
        'label' => E::ts('Devices'),
        'name' => 'health_monitor',
        'icon' => 'crm-i fa-heartbeat',
        'url' => 'civicrm/healthmonitor/search',
        'permission' => 'access CiviCRM',
        'navID' => 10,
        'operator' => 'OR',
        'separator' => 0,
    ));
    _healthmonitor_civix_insert_navigation_menu($menu, 'health_monitor', array(
        'label' => E::ts('Dashboard'),
        'name' => 'search_devices',
        'url' => 'civicrm/devices/dashboard',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _healthmonitor_civix_navigationMenu($menu);
    _healthmonitor_civix_insert_navigation_menu($menu, 'health_monitor', array(
        'label' => E::ts('Find Devices'),
        'name' => 'search_devices',
        'url' => 'civicrm/device/search',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _healthmonitor_civix_navigationMenu($menu);
    _healthmonitor_civix_insert_navigation_menu($menu, 'health_monitor', array(
        'label' => E::ts('Add Device'),
        'name' => 'add_device',
        'url' => 'civicrm/device/form?reset=1&action=add',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _healthmonitor_civix_navigationMenu($menu);
    _healthmonitor_civix_insert_navigation_menu($menu, 'health_monitor', array(
        'label' => E::ts('Find Data'),
        'name' => 'search_health_monitor',
        'url' => 'civicrm/healthmonitor/search',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _healthmonitor_civix_navigationMenu($menu);
    _healthmonitor_civix_insert_navigation_menu($menu, 'health_monitor', array(
        'label' => E::ts('Add Data'),
        'name' => 'search_health_monitor',
        'url' => 'civicrm/healthmonitor/form?reset=1&action=add',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _healthmonitor_civix_navigationMenu($menu);
    _healthmonitor_civix_insert_navigation_menu($menu, 'health_monitor', array(
        'label' => E::ts('Search Alerts'),
        'name' => 'search_alert',
        'url' => 'civicrm/alert/search',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _healthmonitor_civix_navigationMenu($menu);
    _healthmonitor_civix_insert_navigation_menu($menu, 'health_monitor', array(
        'label' => E::ts('Device Reports'),
        'name' => 'search_devices',
        'url' => CRM_Utils_System::url('civicrm/report/list', ['grp' => 'devices', 'reset' => 1]),
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 2,
    ));
    _healthmonitor_civix_navigationMenu($menu);
}

/**
 * Implementation of hook_civicrm_tabset
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_tabset
 */
function healthmonitor_civicrm_tabset($path, &$tabs, $context)
{
    if ($path === 'civicrm/contact/view') {
        // add a tab to the contact summary screen
        $contactId = $context['contact_id'];
        $url = CRM_Utils_System::url('civicrm/devices/contacttab', ['cid' => $contactId]);

        $myEntities = \Civi\Api4\Device::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();

        $tabs[] = array(
            'id' => 'contact_healthmonitor',
            'url' => $url,
            'count' => $myEntities->count(),
            'title' => E::ts('Devices'),
            'weight' => 310,
            'icon' => 'crm-i fa-heartbeat',
            'rows' => [
                ['id' => 1],
                ['id' => 2]]
        );

//        $url = CRM_Utils_System::url('civicrm/healthmonitor/dashboardtab', ['cid' => $contactId]);
//
//        $myEntities = \Civi\Api4\Device::get()
//            ->selectRowCount()
//            ->addWhere('contact_id', '=', $contactId)
//            ->execute();
//
//        $tabs[] = array(
//            'id' => 'contact_hm_dashboard',
//            'url' => $url,
//            'count' => $myEntities->count(),
//            'title' => E::ts('Devices'),
//            'weight' => 310,
//            'icon' => 'crm-i fa-heartbeat',
//            'rows' => [
//                ['id' => 1],
//                ['id' => 2]]
//        );
    }

}

function healthmonitor_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors)
{
    /*    CRM_Core_Error::debug_var('formName', $formName);*/
//    CRM_Core_Error::debug_var('fields', $fields);
//    CRM_Core_Error::debug_var('errors', $errors);
//    CRM_Core_Error::debug_var('contact_id', $form->getContactId());

    if ($formName == 'CRM_Healthmonitor_Form_AlarmRule') {
        $contact_id = $form->getContactId();
        $sensor_id = $fields['sensor_id'];
        $rule_id = $fields['rule_id'];
        $sensor_value = $fields['sensor_value'];
        $alarmrules = civicrm_api4('HealthAlarmRule', 'get',
            ['where' => [
                ['contact_id', '=', $contact_id],
                ['sensor_id', '=', $sensor_id],
                ['rule_id', '=', $rule_id],
                ['sensor_value', '=', $sensor_value],
            ]])->jsonSerialize();
        if (sizeof($alarmrules) > 0) {
            CRM_Core_Error::debug_var('alarmrules', $alarmrules);
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

function _healthmonitor_civicrm_pre($op, $objectName, $id, &$params)
{
//    CRM_Core_Error::debug_var('op', $op);
//    CRM_Core_Error::debug_var('objectName', $objectName);
//    CRM_Core_Error::debug_var('id', $id);
//    CRM_Core_Error::debug_var('params', $params);
    if ($op == 'create' && $objectName == 'HealthMonitor') {
        $contact_id = 0;
        if (isset($params['contact_id'])) {
            $contact_id = $params['contact_id'];
        }
        if (!isset($params['device_id']) and isset($params['device_code'])) {
            $devices = civicrm_api4('Device', 'get', [
                'select' => [
                    'id',
                ],
                'where' => [
                    ['name', '=', $params['device_code']],
                ],
                'limit' => 2,
            ]);
            if (!empty($devices)) {
                $device_id = $devices[0]['id'];
                $params['device_id'] = $device_id;
            }
        }
        if (!isset($params['device_id'])) {
            return "The field device_code and/or device_id is mandatory";
        }
        if ((!isset($params['contact_id']) or !isset($params['device_type_id'])) and isset($params['device_id'])) {
            $devices = civicrm_api4('Device', 'get', [
                'select' => [
                    'contact_id',
                    'device_type_id',
                ],
                'where' => [
                    ['id', '=', $params['device_id']],
                ],
                'limit' => 2,
            ]);
            if (!empty($devices)) {
                if (!isset($params['contact_id'])) {
                    $contact_id = $devices[0]['contact_id'];
                }
                if (!isset($params['device_type_id'])) {
                    $device_type_id = $devices[0]['device_type_id'];
                }
            }
            $params['contact_id'] = $contact_id;
            $params['device_type_id'] = $device_type_id;
        } else {
            return "The field device_code and/or device_id and/or contact_id is mandatory";
        }
    }
}

