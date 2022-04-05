<?php

use CRM_Devices_ExtensionUtil as E;

class CRM_Devices_BAO_Device extends CRM_Devices_DAO_Device
{

    /**
     * Create a new Device based on array-data
     *
     * @param array $params key-value pairs
     * @return CRM_Devices_DAO_Device|NULL
     *
     * public static function create($params) {
     * $className = 'CRM_Devices_DAO_Device';
     * $entityName = 'Device';
     * $hook = empty($params['id']) ? 'create' : 'edit';
     *
     * CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
     * $instance = new $className();
     * $instance->copyValues($params);
     * $instance->save();
     * CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);
     *
     * return $instance;
     * } */

    /**
     * @param $request
     * @return mixed
     */
    public static function getListWithSeveralSearchFields(&$request)
    {
        if ($request['input']) {
            if ($request['search_fields']) {
                $search_fields = $request['search_fields'];
                if (sizeof($search_fields) > 0) {
                    $params = [];
                    foreach ($search_fields as $search_field) {
                        $searchString = ['LIKE' => ($request['add_wildcard'] ? '%' : '') . $request['input'] . '%'];
                        if ($search_field != 'id' ) {
                            $params[$search_field] = $searchString;
                        }
                    }
                    if (isset($request['search_field'])) {
                        $searchField = $request['search_field'];
                        $search_fields = self::addSearchFieldToSearchFields($searchField, $search_fields);
                    }
                    $request['params']['options']['or'] = [$search_fields];
                    unset($request['params']['']);
                    unset($request['search_fields']);
                    $request['params'] += $params;

                }
            }
        }
        _civicrm_api3_generic_getlist_params($request);
        return $request;
    }

    /**
     * @param $searchField
     * @param $search_fields
     * @return array
     */
    public static function addSearchFieldToSearchFields($searchField, $search_fields): array
    {
        if (!in_array($searchField, $search_fields)) {
            $search_fields[] = $searchField;
        };
        return $search_fields;
    }
}
