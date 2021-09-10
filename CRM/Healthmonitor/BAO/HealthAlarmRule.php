<?php
use CRM_Healthmonitor_ExtensionUtil as E;

class CRM_Healthmonitor_BAO_HealthAlarmRule extends CRM_Healthmonitor_DAO_HealthAlarmRule {

  /**
   * Create a new HealthAlarmRule based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Healthmonitor_DAO_HealthAlarmRule|NULL
   *
  public static function create($params) {
    $className = 'CRM_Healthmonitor_DAO_HealthAlarmRule';
    $entityName = 'HealthAlarmRule';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

}
