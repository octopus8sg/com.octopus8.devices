<?php
use CRM_Devices_ExtensionUtil as E;

/**
 * DeviceData.create API specification (optional).
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_device_data_create_spec(&$spec) {
  // $spec['some_parameter']['api.required'] = 1;
    $spec['device_code']['api.required'] = 1;
    unset($spec['sensor_id']);
    $spec['sensor_id'] = ['api.required' => 1];
    $spec['sensor_value']['api.required'] = 1;
    $spec['date']['api.required'] = 0;
//    $spec['time']['api.required'] = 0;

}

/**
 * DeviceData.create API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_device_data_create($params)

{

    //check for sensors

    $types = CRM_Core_OptionGroup::values('o8_device_type');
//    CRM_Core_Error::debug_var('anyway times', $params);

    $sensors = CRM_Core_OptionGroup::values('o8_device_sensor');

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
            'checkPermissions' => FALSE,
            'select' => [
                'id',
            ],
            'where' => [
                ['code', '=', $params['device_code']],
            ],
            'limit' => 2,
        ]);
        if (!empty($devices)) {
            $device_id = $devices[0]['id'];
            $params['device_id'] = $device_id;
        }
    }
    if (!isset($params['contact_id']) and isset($params['device_id'])) {
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
    if (!isset($params['device_id'])) {
        throw new API_Exception('device_code is not valid');
    }
    if (empty($params['device_id'])) {
        throw new API_Exception('device_code is not valid');
    }
//    if (empty($params['date'])) {
        $params['date'] = date('Y-m-d H:i:s');
//    }
    $newparams = _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params, 'DeviceData');
    $id = $newparams['id'];
    $contact_id = $newparams['values'][$id]['contact_id'];
    unset($newparams['values'][$id]['contact_id']);
    $device_data_id = $id;
    $sensor_id = $newparams['values'][$id]['sensor_id'];
//    CRM_Core_Error::debug_var('params', $params);
    $sensor = $sensors[$sensor_id];
//    CRM_Core_Error::debug_var('sensor', $sensor);

    $alarmrules = civicrm_api3('AlarmRule', 'get', [
        'contact_id' => $contact_id,
        'sensor_id' => $sensor_id,
        'options' => ['sort' => "id desc"],
    ]);
//        \Civi\Api4\AlarmRule::get()
//            ->setWhere([])->setOrderBy(['id' => 'DESC'])
//            ->execute()->jsonSerialize();

//    CRM_Core_Error::debug_var('alarmrules', $alarmrules);
    $break = false;
    $rules = CRM_Core_OptionGroup::values('o8_device_rule_type', FALSE, FALSE, FALSE, null, 'name');
//    CRM_Core_Error::debug_var('rules', $rules);

    foreach ($alarmrules['values'] as $alarmrule) {
//        CRM_Core_Error::debug_var('alarmrule', $alarmrule);
        $rule = $rules[$alarmrule['rule_id']];
        $result = 'All OK! ' . $params['sensor_value']  . ' === ' . $rule . ' === ' .  $alarmrule['sensor_value'] ;
        switch ($rule) {
            case 'eq':
                if ($alarmrule['sensor_value'] == $params['sensor_value']) {
                    $result = civicrm_api3('Alarm', 'create', [
                        'contact_id' => $contact_id,
                        'device_data_id' => $device_data_id,
                        'alarm_rule_id' => $alarmrule['id'],
                    ]);
                    $break = true;
                }
                break;

            case 'ne':
                if ($params['sensor_value'] <> $alarmrule['sensor_value']) {
                    $result = civicrm_api3('Alarm', 'create', [
                        'contact_id' => $contact_id,
                        'device_data_id' => $device_data_id,
                        'alarm_rule_id' => $alarmrule['id'],
                    ]);
                    $break = true;
                }
                break;

            case 'le':
                if ($params['sensor_value'] <= $alarmrule['sensor_value']) {
                    $result = civicrm_api3('Alarm', 'create', [
                        'contact_id' => $contact_id,
                        'device_data_id' => $device_data_id,
                        'alarm_rule_id' => $alarmrule['id'],
                    ]);
                    $break = true;
                }
                break;

            case 'lt':
                if ($params['sensor_value'] < $alarmrule['sensor_value']) {
                    $result = civicrm_api3('Alarm', 'create', [
                        'contact_id' => $contact_id,
                        'device_data_id' => $device_data_id,
                        'alarm_rule_id' => $alarmrule['id'],
                    ]);
                    $break = true;
                }
                break;
            case 'ge':
                if ($params['sensor_value'] >= $alarmrule['sensor_value']) {
                    $result = civicrm_api3('Alarm', 'create', [
                        'contact_id' => $contact_id,
                        'device_data_id' => $device_data_id,
                        'alarm_rule_id' => $alarmrule['id'],
                    ]);
                    $break = true;
                }
                break;
            case 'gt':
                if ($params['sensor_value'] > $alarmrule['sensor_value']) {
                    $result = civicrm_api3('Alarm', 'create', [
                        'contact_id' => $contact_id,
                        'device_data_id' => $device_data_id,
                        'alarm_rule_id' => $alarmrule['id'],
                    ]);
                    $break = true;
                }
                break;
        }
//        CRM_Core_Error::debug_var('result', $result);
        if ($break == true) return $newparams;
    }
    //    check and create health monitor
    // check for rule - contact, sensor_id
    // check rule case
    // create / return

    return $newparams;
}

/**
 * DeviceData.delete API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_device_data_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * DeviceData.get API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_device_data_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params, TRUE, 'DeviceData');
}
