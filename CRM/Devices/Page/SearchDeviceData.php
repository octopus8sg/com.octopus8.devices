<?php

use CRM_Devices_ExtensionUtil as E;

class CRM_Devices_Page_SearchDeviceData extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('Search Device Data'));

        // link for datatables
        $urlQry['snippet'] = 4;
        $devicedata_source_url = CRM_Utils_System::url('civicrm/devices/devicedata_ajax', $urlQry, FALSE, NULL, FALSE);
//        $devices_source_url = "";
        $sourceUrl['devicedata_source_url'] = $devicedata_source_url;
        $this->assign('useAjax', true);
        CRM_Core_Resources::singleton()->addVars('source_url', $sourceUrl);

        // controller form for ajax search
        $controller_data = new CRM_Core_Controller_Simple(
            'CRM_Devices_Form_CommonFilter',
            ts('Device Data Filter'),
            NULL,
            FALSE, FALSE, TRUE
        );
        $controller_data->setEmbedded(TRUE);
        $controller_data->run();

        parent::run();
    }


    public function getAjax()
    {

//        CRM_Core_Error::debug_var('request', $_REQUEST);
//        CRM_Core_Error::debug_var('post', $_POST);

        $cid = CRM_Utils_Request::retrieve('cid', 'Positive');

        $contactId = CRM_Utils_Request::retrieve('contact_id', 'String');
//        CRM_Core_Error::debug_var('contact', $contactId);


        $offset = CRM_Utils_Request::retrieveValue('iDisplayStart', 'Positive', 0);
//        CRM_Core_Error::debug_var('offset', $offset);

        $limit = CRM_Utils_Request::retrieveValue('iDisplayLength', 'Positive', 10);
//        CRM_Core_Error::debug_var('limit', $limit);

        $device_data_id = CRM_Utils_Request::retrieveValue('device_data_id', 'String', null);
//        CRM_Core_Error::debug_var('device_type_id', $device_type_id);

        $device_id = CRM_Utils_Request::retrieveValue('device_id', 'String', null);
//        CRM_Core_Error::debug_var('device_type_id', $device_type_id);

        $device_type_id = CRM_Utils_Request::retrieveValue('device_type_id', 'String', null);
//        CRM_Core_Error::debug_var('device_type_id', $device_type_id);

        $sensor_id = CRM_Utils_Request::retrieveValue('sensor_id', 'String', null);
//        CRM_Core_Error::debug_var('sensor_id', $sensor_id);

        $dateselect_to = CRM_Utils_Request::retrieveValue('dateselect_to', 'String', null);
        try {
            $dateselectto = new DateTime($dateselect_to);
        } catch (Exception $e) {
            $dateselect_to = null;
        }
//        CRM_Core_Error::debug_var('dateselect_to', $dateselect_to);

        $dateselect_from = CRM_Utils_Request::retrieveValue('dateselect_from', 'String', null);
        try {
            $dateselectto = new DateTime($dateselect_from);
        } catch (Exception $e) {
            $dateselect_from = null;
        }
//        CRM_Core_Error::debug_var('dateselect_from', $dateselect_from);
        if ($cid) {
            $sortMapper = [
                0 => 'id',
                1 => 'date',
                2 => 'device_type',
                3 => 'code',
                4 => 'sensor_name',
                5 => 'sensor_value',
            ];
        } else {
            $sortMapper = [
                0 => 'id',
                1 => 'sort_name',
                2 => 'date',
                3 => 'device_type',
                4 => 'code',
                5 => 'sensor_name',
                6 => 'sensor_value',
            ];
        }

        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';

// SQL_CALC_FOUND_ROWS
        $sql = "
    SELECT  SQL_CALC_FOUND_ROWS
      t.id,
      t.date,
      t.contact_id,
      c.sort_name,
      d.code,
      dt.label device_type,
      t.device_id,
      s.label sensor_name,
      t.sensor_value
    FROM civicrm_o8_device_data t
    INNER JOIN civicrm_contact c on  t.contact_id = c.id
    INNER JOIN civicrm_o8_device_device d on  t.device_id = d.id
    INNER JOIN civicrm_option_value s on  t.sensor_id = s.value
    INNER JOIN civicrm_option_group gs on s.option_group_id = gs.id 
                                              and gs.name = 'o8_device_sensor'    
    INNER JOIN civicrm_option_value dt on d.device_type_id = dt.value
    INNER JOIN civicrm_option_group gdt on dt.option_group_id = gdt.id 
                                               and gdt.name = 'o8_device_type'    
    WHERE 1";

        if (isset($cid)) {
            if (is_numeric($cid)) {
                if (intval($cid) > 0) {
                    $sql .= " AND t.`contact_id` = " . $cid . " ";
                }
            }
        } elseif (isset($contactId)) {
            if (strval($contactId) != "") {
                $sql .= " AND t.`contact_id` in (" . $contactId . ") ";
            }
        }

        if (isset($device_id)) {
            if (strval($device_id) != "") {
                $sql .= " AND d.`code` like '%" . strval($device_id) . "%' ";
                if (is_numeric($device_id)) {
                    $sql .= " OR d.`id` = " . intval($device_id) . " ";
                }
            }
        }
        if (isset($device_data_id)) {
            if (is_numeric($device_data_id)) {
                if (intval($device_data_id) > 0) {
                    $sql .= " AND t.`id` = " . intval($device_data_id) . " ";
                }
            }
        }

        if (isset($device_type_id)) {
            if (strval($device_type_id) != "") {
                if (is_numeric($device_type_id)) {
                    $sql .= " AND d.`device_type_id` = " . $device_type_id . " ";
                } else {
                    $sql .= " AND d.`device_type_id` in (" . $device_type_id . ") ";
                }
            }
        }

        if (isset($sensor_id)) {
            if (strval($sensor_id) != "") {
                if (is_numeric($sensor_id)) {
                    $sql .= " AND t.`sensor_id` = " . $sensor_id . " ";
                } else {
                    $sql .= " AND t.`sensor_id` in (" . $sensor_id . ") ";
                }
            }
        }

        $month_ago = strtotime("-1 month", time());
        $date_month_ago = date("Y-m-d H:i:s", $month_ago);

        $today = strtotime("+1 day", time());
        $date_today = date("Y-m-d H:i:s", $today);

        if (isset($dateselect_from)) {
            if ($dateselect_from != null) {
                if ($dateselect_from != '') {
                    $sql .= " AND t.`date` >= '" . $dateselect_from . "' ";
                }
            }
        }


        if (isset($dateselect_to)) {
            if ($dateselect_to != null) {
                if ($dateselect_to != '') {
                    $sql .= " AND t.`date` <= '" . $dateselect_to . "' ";
                } else {
                    $sql .= " AND t.`date` <= '" . $date_today . "' ";
                }
            } else {
                $sql .= " AND t.`date` <= '" . $date_today . "' ";
            }
        } else {
            $sql .= " AND t.`date` <= '" . $date_today . "' ";
        }


//        CRM_Core_Error::debug_var('search_sql', $sql);


        if ($sort !== NULL) {
            $sql .= " ORDER BY {$sort} {$sortOrder}";
        } else {
            $sql = $sql . ' ORDER BY t.`date` ASC';
        }

        if ($limit !== false) {
            if ($limit !== NULL) {
                if ($offset !== false) {
                    if ($offset !== NULL) {
                        $sql .= " LIMIT {$offset}, {$limit}";
                    }
                }
            }
        }


        CRM_Core_Error::debug_var('sql', $sql);

        $dao = CRM_Core_DAO::executeQuery($sql);
        $iFilteredTotal = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $rows = array();
        $count = 0;
        while ($dao->fetch()) {
            if (!empty($dao->contact_id)) {
                $contact = '<a href="' . CRM_Utils_System::url('civicrm/contact/view',
                        ['reset' => 1, 'cid' => $dao->contact_id]) . '">' .
                    CRM_Contact_BAO_Contact::displayName($dao->contact_id) . '</a>';
            }

            $r_update = CRM_Utils_System::url('civicrm/devices/devicedata',
                ['action' => 'update', 'id' => $dao->id]);
            $r_delete = CRM_Utils_System::url('civicrm/devices/devicedata',
                ['action' => 'delete', 'id' => $dao->id]);
            $update = '<a target="_blank" class="edit-devicedata action-item crm-hover-button" href="' . $r_update . '"><i class="crm-i fa-pencil"></i>&nbsp;Edit</a>';
            $delete = '<a target="_blank" class="delete-devicedata action-item crm-hover-button" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $action = "<span>$update $delete</span>";
            $rows[$count][] = $dao->id;
            if (!$cid) {
                $rows[$count][] = $contact;
            }
            $rows[$count][] = $dao->date;
            $rows[$count][] = $dao->device_type;
            $rows[$count][] = $dao->code;
            $rows[$count][] = $dao->sensor_name;
            $rows[$count][] = floatval($dao->sensor_value);
            $rows[$count][] = $action;
            $count++;
        }

        $searchRows = $rows;
        $iTotal = 0;
        if (is_countable($searchRows)) {
            $iTotal = sizeof($searchRows);
        }
        $hmdatas = [
            'data' => $searchRows,
            'recordsTotal' => $iTotal,
            'recordsFiltered' => $iFilteredTotal,
        ];
        if (!empty($_REQUEST['is_unit_test'])) {
            return $hmdatas;
        }
        CRM_Utils_JSON::output($hmdatas);
    }


}
