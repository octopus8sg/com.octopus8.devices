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
function devices_civicrm_config(&$config) {
  _devices_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function devices_civicrm_xmlMenu(&$files) {
  _devices_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function devices_civicrm_install() {
  _devices_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function devices_civicrm_postInstall() {
  _devices_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function devices_civicrm_uninstall() {
  _devices_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function devices_civicrm_enable() {
  _devices_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function devices_civicrm_disable() {
  _devices_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function devices_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
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
function devices_civicrm_managed(&$entities) {
  _devices_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Add CiviCase types provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function devices_civicrm_caseTypes(&$caseTypes) {
  _devices_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Add Angular modules provided by this extension.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function devices_civicrm_angularModules(&$angularModules) {
  // Auto-add module files from ./ang/*.ang.php
  _devices_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function devices_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _devices_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function devices_civicrm_entityTypes(&$entityTypes) {
  _devices_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function devices_civicrm_themes(&$themes) {
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
function devices_civicrm_navigationMenu(&$menu) {
    _devices_civix_insert_navigation_menu($menu, '', array(
        'label' => E::ts('Devices'),
        'name' => 'o8_device_devices',
        'icon' => 'crm-i fa-heartbeat',
        'url' => 'civicrm/devices/dashboard',
        'permission' => 'access CiviCRM',
        'navID' => 10,
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_insert_navigation_menu($menu, 'o8_device_devices', array(
        'label' => E::ts('Dashboard'),
        'name' => 'search_devices',
        'url' => 'civicrm/devices/dashboard',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_navigationMenu($menu);
    _devices_civix_insert_navigation_menu($menu, 'o8_device_devices', array(
        'label' => E::ts('Find Devices'),
        'name' => 'search_devices',
        'url' => 'civicrm/devices/search',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_navigationMenu($menu);
    _devices_civix_insert_navigation_menu($menu, 'o8_device_devices', array(
        'label' => E::ts('Add Device'),
        'name' => 'add_device',
        'url' => 'civicrm/devices/form?reset=1&action=add',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_navigationMenu($menu);
    _devices_civix_insert_navigation_menu($menu, 'o8_device_devices', array(
        'label' => E::ts('Find Data'),
        'name' => 'search_o8_device_devices',
        'url' => 'civicrm/devices/data/search',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_navigationMenu($menu);
    _devices_civix_insert_navigation_menu($menu, 'o8_device_devices', array(
        'label' => E::ts('Add Data'),
        'name' => 'search_o8_device_devices',
        'url' => 'civicrm/devices/data/form?reset=1&action=add',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_navigationMenu($menu);
    _devices_civix_insert_navigation_menu($menu, 'o8_device_devices', array(
        'label' => E::ts('Search Alerts'),
        'name' => 'search_alert',
        'url' => 'civicrm/alert/search',
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 0,
    ));
    _devices_civix_navigationMenu($menu);
    _devices_civix_insert_navigation_menu($menu, 'o8_device_devices', array(
        'label' => E::ts('Device Reports'),
        'name' => 'search_devices',
        'url' => CRM_Utils_System::url('civicrm/report/list', ['grp' => 'devices', 'reset' => 1]),
        'permission' => 'access CiviCRM',
        'operator' => 'OR',
        'separator' => 2,
    ));
    _devices_civix_navigationMenu($menu);    
}


/**
 * Implementation of hook_civicrm_tabset
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_tabset
 */
function devices_civicrm_tabset($path, &$tabs, $context)
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
            'id' => 'contact_devices',
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

