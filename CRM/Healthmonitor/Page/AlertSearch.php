<?php

use CRM_Healthmonitor_ExtensionUtil as E;

class CRM_Healthmonitor_Page_AlertSearch extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('AlertSearch'));

        // Example: Assign a variable for use in a template
        $this->assign('currentTime', date('Y-m-d H:i:s'));

        parent::run();
    }

    public function getAjax()
    {

//        CRM_Core_Error::debug_var('request', $_REQUEST);
//        CRM_Core_Error::debug_var('post', $_POST);

        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');
//        CRM_Core_Error::debug_var('contact', $contactId);


        $offset = CRM_Utils_Request::retrieveValue('iDisplayStart', 'Positive', 0);
//        CRM_Core_Error::debug_var('offset', $offset);

        $limit = CRM_Utils_Request::retrieveValue('iDisplayLength', 'Positive', 10);
//        CRM_Core_Error::debug_var('limit', $limit);

        $sensor_id = CRM_Utils_Request::retrieveValue('alert_sensor_id', 'Positive', null);
//        CRM_Core_Error::debug_var('sensor_id', $sensor_id);

        $civicrm = CRM_Utils_Request::retrieveValue('alert_civicrm', 'Boolean', null);
//        CRM_Core_Error::debug_var('civicrm', $civicrm);

        $email = CRM_Utils_Request::retrieveValue('alert_email', 'Boolean', null);
//        CRM_Core_Error::debug_var('email', $email);

        $addressee_id = CRM_Utils_Request::retrieveValue('alert_addressee_id', 'String', null);
//        CRM_Core_Error::debug_var('addressee_id', $addressee_id);

        $dateselect_to = CRM_Utils_Request::retrieveValue('alert_dateselect_to', 'String', null);
        try {
            $dateselectto = new DateTime($dateselect_to);
        } catch (Exception $e) {
            $dateselect_to = null;
        }
//        CRM_Core_Error::debug_var('dateselect_to', $dateselect_to);

        $dateselect_from = CRM_Utils_Request::retrieveValue('alert_dateselect_from', 'String', null);
        try {
            $dateselectto = new DateTime($dateselect_from);
        } catch (Exception $e) {
            $dateselect_from = null;
        }
//        CRM_Core_Error::debug_var('dateselect_from', $dateselect_from);

        $sortMapper = [
            0 => 'id',
            1 => 'date',
            2 => 'addressee_id',
            3 => 'device_data',
            5 => 'civicrm',
            6 => 'email'
        ];

        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';

//
        $sql = "SELECT SQL_CALC_FOUND_ROWS
                           ha.id,
                           d.date,
                           t.addressee_id,
                           CONCAT(s.label, ': ', d.sensor_value) device_data,
                           ha.civicrm,
                           ha.email
FROM civicrm_health_alert ha
         INNER JOIN civicrm_health_alarm a on ha.health_alarm_id = a.id
         INNER JOIN civicrm_health_monitor d on a.health_monitor_id = d.id
         INNER JOIN civicrm_health_alert_rule t on ha.alert_rule_id = t.id
         INNER JOIN civicrm_health_alarm_rule tr on a.alarm_rule_id = tr.id
         INNER JOIN civicrm_option_value s on tr.sensor_id = s.value
         INNER JOIN civicrm_option_group gs on s.option_group_id = gs.id and gs.name = 'health_monitor_sensor'
      WHERE 1";

        if (isset($contactId)) {
            $sql .= " AND a.contact_id = " . $contactId . " ";
        }


        if (isset($sensor_id)) {
            if ($sensor_id > 0) {
                $sql .= " AND tr.sensor_id = " . $sensor_id . " ";
            }
        }

        if (isset($addressee_id)) {
            if ($addressee_id != "") {
                $sql .= " AND t.addressee_id in (" . $addressee_id . ")";
            }

        }

        if (!(strval($civicrm) === strval($email)
            and strval($civicrm) === 'false')) {
            if ($email) {
                if (strval($email) == 'true') $sql .= " AND ha.email IS NOT NULL ";
                if (strval($email) == 'false') $sql .= " AND ha.email IS NULL ";
            }

            if ($civicrm) {
                if (strval($civicrm) == 'true') $sql .= " AND ha.civicrm IS NOT NULL ";
                if (strval($civicrm) == 'false') $sql .= " AND ha.civicrm IS NULL ";
            }
        }

        $month_ago = strtotime("-1 month", time());
        $date_month_ago = date("Y-m-d H:i:s", $month_ago);

        $today = strtotime("+1 day", time());
        $date_today = date("Y-m-d H:i:s", $today);

        if (isset($dateselect_from)) {
            if ($dateselect_from != null) {
                if ($dateselect_from != '') {
                    $sql .= " AND d.date >= '" . $dateselect_from . "' ";
                }
            }
        }


        if (isset($dateselect_to)) {
            if ($dateselect_to != null) {
                if ($dateselect_to != '') {
                    $sql .= " AND date <= '" . $dateselect_to . "' ";
                } else {
                    $sql .= " AND date <= '" . $date_today . "' ";
                }
            } else {
                $sql .= " AND date <= '" . $date_today . "' ";
            }
        } else {
            $sql .= " AND date <= '" . $date_today . "' ";
        }


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


//        CRM_Core_Error::debug_var('alert_sql', $sql);

        $dao = CRM_Core_DAO::executeQuery($sql);
        $iFilteredTotal = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $rows = array();
        $count = 0;
        while ($dao->fetch()) {
            $r_delete = CRM_Utils_System::url('civicrm/alert/form',
                ['action' => 'delete', 'id' => $dao->id]);
            $delete = '<a class="action-item crm-hover-button" target="_blank" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $addressee = "";
            if (!empty($dao->addressee_id)) {
                $addressee = '<a href="' . CRM_Utils_System::url('civicrm/contact/view',
                        ['reset' => 1, 'cid' => $dao->addressee_id]) . '">' .
                    CRM_Contact_BAO_Contact::displayName($dao->addressee_id) . '</a>';
            }

            $action = "<span>$delete</span>";
            $rows[$count][] = $dao->id;
            $rows[$count][] = $dao->date;
            $rows[$count][] = $addressee;
            $rows[$count][] = $dao->device_data;
            $rows[$count][] = $dao->civicrm;
            $rows[$count][] = $dao->email;
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
