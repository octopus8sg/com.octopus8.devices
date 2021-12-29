<?php

use CRM_Devices_ExtensionUtil as E;

/**
 * Alarm.create API specification (optional).
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_alarm_create_spec(&$spec)
{
    // $spec['some_parameter']['api.required'] = 1;
}

/**
 * Alarm.create API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_alarm_create($params)
{
//    $title = "Device Alarm: " . $siteurl;
//    $message = "Alarm for: " . $addressee_name . "\n";
//    $message .= "Message: " . $alertrule['message'] . "\n";
//    $message .= "Site: " . $siteurl . "\n";
//    $message .= "Device Code: " . $device_code . "\n";
//    $message .= "Contact ID: " . $contact_id . "\n";
//    $message .= "Contact Name: " . $contact_name . "\n";
//    $message .= "Device Type: " . $device_type . "\n";
//    $message .= "Sensor Type: " . $sensor_type . "\n";
//    $message .= "Sensor Value: " . $sensor_value . "\n";
//    $message .= "Rule Name: " . $rule_name . "\n";
//    $message .= "Date: " . $date . "\n";

    $newparams = _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params, 'Alarm');
    $alarm_id = $newparams['id'];
//    CRM_Core_Error::debug_var('params', $params);
    $alarm_rule_id = $params['alarm_rule_id'];
    $device_data_id = $params['device_data_id'];
    $rules = CRM_Core_OptionGroup::values('o8_device_rule_type', FALSE, FALSE, FALSE, null, 'name');
//    CRM_Core_Error::debug_var('alertrules', $alertrules);

    $alertrulesv = civicrm_api3('AlertRule', 'get', [
        'rule_id' => $alarm_rule_id,
    ]);
    $alertrules = $alertrulesv['values'];
    CRM_Core_Error::debug_var('alertrules', $alertrules);

    $siteurl = CRM_Utils_System::absoluteURL('');

    $device_datasv = civicrm_api3('DeviceData', 'get', [
        'id' => $device_data_id,
        'options' => ['limit' => 1],
    ]);

    $device_datas = $device_datasv['values'];

    if (!empty($device_datas)) {
        $device_data = $device_datas[$device_data_id];
    } else {
        return $newparams;
    }

//        $device_id = $device_data->device_id;
    $device_id = $device_data['device_id'];
    $devicesv = civicrm_api3('Device', 'get', [
        'id' => $device_id,
        'options' => ['limit' => 1],
    ]);
    $devices = $devicesv['values'];

    if (!empty($devices)) {
        $device = $devices[$device_id];
    } else {
        return $newparams;
    }
    $device_code = $device['code'];
    $device_type_id = $device['device_type_id'];
    $device_type =
        CRM_Core_PseudoConstant::getLabel("CRM_Devices_BAO_Device", "device_type_id", $device_type_id);
    $contact_id = $params['contact_id'];
    $contact_name = CRM_Contact_BAO_Contact::displayName($contact_id);
    $sensor_id = $device_data['sensor_id'];
    $sensor_type = CRM_Core_PseudoConstant::getLabel("CRM_Devices_BAO_AlarmRule",
        "sensor_id", $sensor_id);
    $sensor_value = $device_data['sensor_value'];
    $date = $device_data['date'];
    foreach ($alertrules as $alertrule) {
//        CRM_Core_Error::debug_var('alertrule', $alertrule);
//            CRM_Core_Error::debug_var('device_data', $device_data);
        $alert_rule_id = $alertrule['id'];
        $rule_id = $alertrule['rule_id'];

        $alarmrulesv = civicrm_api3('AlarmRule', 'get', [
            'id' => $rule_id,
        ]);
        $alarmrules = $alarmrulesv['values'];
        if (!empty($alarmrules)) {
            $alarmrule = $alarmrules[$rule_id];
//            CRM_Core_Error::debug_var('alarmrule', $alarmrule);
            $rule = $rules[$alarmrule['rule_id']];
            $rule_name = strtoupper($rule) . ' ' . $alarmrule['sensor_value'];
            $addressee_name = CRM_Contact_BAO_Contact::displayName($alertrule['addressee_id']);
            $title = "Device Alarm: " . $siteurl;
            $message = "Alarm for: " . $addressee_name . "\n";
            $message .= "Message: " . $alertrule['message'] . "\n";
            $message .= "Site: " . $siteurl . "\n";
            $message .= "Device Code: " . $device_code . "\n";
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
//            CRM_Core_Error::debug_var('message', $message);
//            CRM_Core_Error::debug_var('addressee', $alertrule['addressee_id']);
//            CRM_Core_Error::debug_var('title', $title);
            if (boolval($alertrule['civicrm']) === TRUE) {
                $entity_id = $alertrule['addressee_id'];
                $noteparams = [
                    'entity_id' => $entity_id,
                    'note' => $message,
                    'subject' => $title,
                ];
//                CRM_Core_Error::debug_var('noteparams', $noteparams);

                $resultn = civicrm_api3('Note', 'create', $noteparams);
                if ($resultn) {
                    $civicrm_date = date("Y-m-d H:i:s");
                }
//                CRM_Core_Error::debug_var('resultn', $resultn);
            }

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
                if (CRM_Utils_Mail::send($mailParams)) {
                    $email_date = date("Y-m-d H:i:s");
                }
            }

            $resulta = civicrm_api3('Alert', 'create', [
                'contact_id' => $contact_id,
                'alarm_id' => $alarm_id,
                'alert_rule_id' => $alert_rule_id,
                'civicrm' => $civicrm_date,
                'email' => $email_date,
            ]);
//            CRM_Core_Error::debug_var('result2', $resulta);

        }
    }
//    check and create health alert
    return $newparams;
}

/**
 * Alarm.delete API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_alarm_delete($params)
{
    return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * Alarm.get API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_alarm_get($params)
{
    return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params, TRUE, 'Alarm');
}
