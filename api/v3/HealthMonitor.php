<?php

use CRM_Healthmonitor_ExtensionUtil as E;


/**
 * HealthMonitor.create API specification (optional).
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_health_monitor_create_spec(&$spec)
{
//    CRM_Core_Error::debug_var('spec', $spec);
    $spec['device_code']['api.required'] = 1;
    unset($spec['sensor_id']);
    $spec['sensor_id'] = ['api.required' => 1];
    $spec['sensor_value']['api.required'] = 1;
    $spec['date']['api.required'] = 1;
}


/**
 * HealthMonitor.create API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */

/**
 * Hack to ensure inherited membership got created/deleted on
 * relationship add/delete respectively.
 *
 * @param array $params
 *   Array per getfields metadata.
 *
 * @return array
 * @throws API_Exception
 */


function civicrm_api3_health_monitor_create($params)
{

    $types = CRM_Core_OptionGroup::values('health_monitor_device_type');
//    CRM_Core_Error::debug_var('anyway times', $params);

    $sensors = CRM_Core_OptionGroup::values('health_monitor_sensor');

    $value = $params['sensor_id'];
    $options = $sensors;
    $sensor_ok = FALSE;
    if (array_key_exists($value, $options) || !$options) {
        $sensor_ok = TRUE;
    }

    // Translate value into key
    // Cast $value to string to avoid a bug in array_search
    $newValue = array_search((string)$value, $options);
    if ($newValue !== FALSE) {
        $params['sensor_id'] = $newValue;
        $sensor_ok = TRUE;
    }
    // Case-insensitive matching
    $newValue = strtolower($value);
    $options = array_map("strtolower", $options);
    $newValue = array_search($newValue, $options);
    if ($newValue !== FALSE) {
        $params['sensor_id'] = $newValue;
        $sensor_ok = TRUE;
    }
    $newValue = strtolower($value);
    $newValue = str_replace('_', ' ', $newValue);
    $options = array_map("strtolower", $options);
    $newValue = array_search($newValue, $options);
    if ($newValue !== FALSE) {
        $params['sensor_id'] = $newValue;
        $sensor_ok = TRUE;
    }
    if ($sensor_ok === FALSE) {
        throw new API_Exception("sensor_code is not valid");
    }
    //    hide contact_id in api3 return
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
        throw new API_Exception('device_code is not valid');
    }
    if (empty($params['device_id'])) {
        throw new API_Exception('device_code is not valid');
    }
    $newparams = _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params, 'HealthMonitor');
    $id = $newparams['id'];
    unset($newparams['values'][$id]['contact_id']);
//    CRM_Core_Error::debug_var('paramsnew', $newparams);
    return $newparams;
}

/**
 * HealthMonitor.delete API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_health_monitor_delete($params)
{
    return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * HealthMonitor.get API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_health_monitor_get($params)
{
    return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params, TRUE, 'HealthMonitor');
}
