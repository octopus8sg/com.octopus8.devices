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
//    return _healthmonitor_civicrm_post($op, $objectName, $id, $params);
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
        'url' => 'civicrm/healthmonitor/search',
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
        'label' => E::ts('Device Reports'),
        'name' => 'search_devices',
        'url' => 'civicrm/device/search',
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
        $url = CRM_Utils_System::url('civicrm/healthmonitor/contacttab', ['cid' => $contactId]);

        $myEntities = \Civi\Api4\HealthMonitor::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();

        $tabs[] = array(
            'id' => 'contact_healthmonitor',
            'url' => $url,
            'count' => $myEntities->count(),
            'title' => E::ts('HM Data Entries'),
            'weight' => 310,
            'icon' => 'crm-i fa-heartbeat',
            'rows' => [
                ['id' => 1],
                ['id' => 2]]
        );

        $url = CRM_Utils_System::url('civicrm/healthmonitor/dashboardtab', ['cid' => $contactId]);

        $myEntities = \Civi\Api4\Device::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();

        $tabs[] = array(
            'id' => 'contact_hm_dashboard',
            'url' => $url,
            'count' => $myEntities->count(),
            'title' => E::ts('Devices'),
            'weight' => 310,
            'icon' => 'crm-i fa-heartbeat',
            'rows' => [
                ['id' => 1],
                ['id' => 2]]
        );
    }

}

function _healthmonitor_civicrm_pre($op, $objectName, $id, &$params)
{
//    CRM_Core_Error::debug_var('op', $op);
//    CRM_Core_Error::debug_var('objectName', $objectName);
//    CRM_Core_Error::debug_var('id', $id);
//    CRM_Core_Error::debug_var('params', $params);
    if ($op == 'create' && $objectName == 'HealthMonitor') {
        if (!isset($params['contact_id']) or !isset($params['device_type_id'])) {
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
                    $client_id = $devices[0]['contact_id'];
                }
                if (!isset($params['device_type_id'])) {
                    $device_type_id = $devices[0]['device_type_id'];
                }
            }
//            CRM_Core_Error::debug_var('results', $devices);
//            CRM_Core_Error::debug_var('results0', $devices[0]);
//            CRM_Core_Error::debug_var('client_id', $client_id);
            $params['contact_id'] = $client_id;
            $params['device_type_id'] = $device_type_id;
//            CRM_Core_Error::debug_var('params2', $params);

        }
    }
}

