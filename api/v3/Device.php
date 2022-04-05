<?php
use CRM_Devices_ExtensionUtil as E;

/**
 * Device.create API specification (optional).
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_device_create_spec(&$spec) {
  // $spec['some_parameter']['api.required'] = 1;
}

/**
 * Device.create API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_device_create($params) {
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params, 'Device');
}

/**
 * Device.delete API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_device_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * Device.get API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_device_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params, TRUE, 'Device');
}

/**
 * Get list parameters.
 *
 * @param array $request
 * @see _civicrm_api3_generic_getlist_params
 *
 */
function _civicrm_api3_device_getlist_params(&$request)
{
//    CRM_Core_Error::debug_var('request3', $request);
    $request = CRM_Devices_BAO_Device::getListWithSeveralSearchFields($request);
}
