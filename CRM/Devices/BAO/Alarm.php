<?php
use CRM_Devices_ExtensionUtil as E;

class CRM_Devices_BAO_Alarm extends CRM_Devices_DAO_Alarm {

  /**
   * Create a new Alarm based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Devices_DAO_Alarm|NULL
   *
  public static function create($params) {
    $className = 'CRM_Devices_DAO_Alarm';
    $entityName = 'Alarm';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

}
