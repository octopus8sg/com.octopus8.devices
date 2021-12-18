<?php
use CRM_Devices_ExtensionUtil as E;

class CRM_Devices_BAO_AlertRule extends CRM_Devices_DAO_AlertRule {

  /**
   * Create a new AlertRule based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Devices_DAO_AlertRule|NULL
   *
  public static function create($params) {
    $className = 'CRM_Devices_DAO_AlertRule';
    $entityName = 'AlertRule';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

}
