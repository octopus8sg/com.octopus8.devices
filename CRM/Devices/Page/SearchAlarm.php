<?php
use CRM_Devices_ExtensionUtil as E;

class CRM_Devices_Page_SearchAlarm extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('SearchAlarm'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));

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

        $alarm_id = CRM_Utils_Request::retrieveValue('alarm_id', 'Positive', null);

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

        $sortMapper = [
            0 => 'id',
            1 => 'date',
            2 => 'sensor_name',
            3 => 'data_value',
            4 => 'code',
        ];

        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';

//
        $sql = "SELECT SQL_CALC_FOUND_ROWS
                           a.id,
                           d.date,
                           s.label        sensor_name,
                           d.sensor_value data_value,
                           t.code
FROM civicrm_o8_device_alarm a
         INNER JOIN civicrm_o8_device_data d on a.device_data_id = d.id
         INNER JOIN civicrm_o8_device_alarm_rule t on a.alarm_rule_id = t.id
         INNER JOIN civicrm_option_value s on t.sensor_id = s.value
         INNER JOIN civicrm_option_group gs on s.option_group_id = gs.id and gs.name = 'o8_device_sensor'
      WHERE 1";

        if (isset($alarm_id)) {
            if (is_numeric($alarm_id)) {
                if ($alarm_id > 0) {
                    $sql .= " AND a.`id` = " . intval($alarm_id) . " ";
                }
            }
        }
        if (isset($cid)) {
            if (is_numeric($cid)) {
                if (intval($cid) > 0) {
                    $sql .= " AND a.`contact_id` = " . $cid . " ";
                }
            }
        } elseif (isset($contactId)) {
            if (strval($contactId) != "") {
                $sql .= " AND t.`contact_id` in (" . $contactId . ") ";
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
                    $sql .= " AND d.date >= '" . $dateselect_from . " 00:00:00' ";
                }
            }
        }


        if (isset($dateselect_to)) {
            if ($dateselect_to != null) {
                if ($dateselect_to != '') {
                    $sql .= " AND date <= '" . $dateselect_to . " 23:59:59' ";
                } else {
                    $sql .= " AND date <= '" . $date_today . "' ";
                }
            } else {
                $sql .= " AND date <= '" . $date_today . "' ";
            }
        } else {
            $sql .= " AND date <= '" . $date_today . "' ";
        }


//        CRM_Core_Error::debug_var('alarm_sql', $sql);


        if ($sort !== NULL) {
            $sql .= " ORDER BY {$sort} {$sortOrder}";
        } else {
            $sql = $sql . ' ORDER BY d.id ASC, t.id ASC';
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


//        CRM_Core_Error::debug_var('sql', $sql);

        $dao = CRM_Core_DAO::executeQuery($sql);
        $iFilteredTotal = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $rows = array();
        $count = 0;
        while ($dao->fetch()) {
            $r_update = CRM_Utils_System::url('civicrm/alarmrule/form',
                ['action' => 'update', 'id' => $dao->id]);
            $r_delete = CRM_Utils_System::url('civicrm/alarmrule/form',
                ['action' => 'delete', 'id' => $dao->id]);
            $delete = '<a class="delete-alarm action-item crm-hover-button" target="_blank" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $action = "<span>$delete</span>";
            $rows[$count][] = $dao->id;
            $rows[$count][] = $dao->date;
            $rows[$count][] = $dao->sensor_name;
            $rows[$count][] = $dao->data_value;
            $rows[$count][] = $dao->code;
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
