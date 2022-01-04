<?php
use CRM_Devices_ExtensionUtil as E;

class CRM_Devices_Page_SearchAlert extends CRM_Core_Page {

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('Search Alerts'));

        // link for datatables
        $urlQry['snippet'] = 4;
        $alerts_source_url = CRM_Utils_System::url('civicrm/devices/alert_ajax', $urlQry, FALSE, NULL, FALSE);
//        $alerts_source_url = "";
        $sourceUrl['alerts_source_url'] = $alerts_source_url;
        $this->assign('useAjax', true);
        CRM_Core_Resources::singleton()->addVars('source_url', $sourceUrl);

        // controller form for ajax search
        $controller_data = new CRM_Core_Controller_Simple(
            'CRM_Devices_Form_CommonFilter',
            ts('Devices Filter'),
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
        //cid = contact for tabset
//        CRM_Core_Error::debug_var('cid', $cid);

        $contactId = CRM_Utils_Request::retrieve('contact_id', 'CommaSeparatedIntegers');
//        CRM_Core_Error::debug_var('contact', $contactId);

        $alert_id = CRM_Utils_Request::retrieveValue('alert_id', 'Positive', null);
//        CRM_Core_Error::debug_var('alert_id', $alert_id);

        $offset = CRM_Utils_Request::retrieveValue('iDisplayStart', 'Positive', 0);
//        CRM_Core_Error::debug_var('offset', $offset);

        $limit = CRM_Utils_Request::retrieveValue('iDisplayLength', 'Positive', 10);
//        CRM_Core_Error::debug_var('limit', $limit);

        $sensor_id = CRM_Utils_Request::retrieveValue('sensor_id', 'CommaSeparatedIntegers', null);
//        CRM_Core_Error::debug_var('sensor_id', $sensor_id);

        $alert_rule_type = CRM_Utils_Request::retrieveValue('alert_rule_type', 'CommaSeparatedIntegers', null);
//        CRM_Core_Error::debug_var('alert_rule_type', $alert_rule_type);
        $alert_rule_types = [];
        if (!empty($alert_rule_type)) {
            if (strpos($alert_rule_type, ',')) {
                $alert_rule_types = explode(',', $alert_rule_type);
            } else {
                $alert_rule_types = [$alert_rule_type];
            }
        }else{
            if(strlen('alert_rule_type') > 0){
                $alert_rule_types[] = $alert_rule_type;
            };
        }
//        CRM_Core_Error::debug_var('alert_rule_types', strval($alert_rule_types));

        $civicrm = boolval(in_array('0', $alert_rule_types));
//        CRM_Core_Error::debug_var('civicrm', strval($civicrm));

        $email = boolval(in_array('1', $alert_rule_types));
//        CRM_Core_Error::debug_var('email', $email);

        $sms = boolval(in_array('2', $alert_rule_types));
//        CRM_Core_Error::debug_var('sms', $sms);

        $telegram = boolval(in_array('3', $alert_rule_types));
//        CRM_Core_Error::debug_var('telegram', $telegram);

        $api = boolval(in_array('4', $alert_rule_types));
//        CRM_Core_Error::debug_var('api', $api);

        $addressee_id = CRM_Utils_Request::retrieveValue('addressee_id', 'CommaSeparatedIntegers', null);
//        CRM_Core_Error::debug_var('addressee_id', $addressee_id);

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
                2 => 'addressee_sort_name',
                3 => 'device_data',
                4 => 'civicrm',
                5 => 'email'
            ];
        }else{
            $sortMapper = [
                0 => 'id',
                1 => 'date',
                2 => 'contact_sort_name',
                3 => 'addressee_sort_name',
                4 => 'device_data',
                5 => 'civicrm',
                6 => 'email'
            ];

        }

        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';

//
        $sql = "SELECT SQL_CALC_FOUND_ROWS
                           ha.id,
                           d.date,
                           t.contact_id,
                           t.addressee_id,
                           CONCAT(s.label, ': ', d.sensor_value) device_data,
                           s.label,
                           ha.civicrm,
                           ha.email,
                           c.sort_name contact_sort_name,
                           ad.sort_name addressee_sort_name
FROM civicrm_o8_device_alert ha
         INNER JOIN civicrm_contact c on ha.contact_id = c.id
         INNER JOIN civicrm_o8_device_alarm a on ha.alarm_id = a.id
         INNER JOIN civicrm_o8_device_data d on a.device_data_id = d.id
         INNER JOIN civicrm_o8_device_alert_rule t on ha.alert_rule_id = t.id
         INNER JOIN civicrm_contact ad on t.addressee_id = ad.id
         INNER JOIN civicrm_o8_device_alarm_rule tr on a.alarm_rule_id = tr.id
         INNER JOIN civicrm_option_value s on tr.sensor_id = s.value
         INNER JOIN civicrm_option_group gs on s.option_group_id = gs.id and gs.name = 'o8_device_sensor'
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


        if (isset($sensor_id)) {
            if ($sensor_id != "") {
                $sql .= " AND tr.sensor_id in (" . $sensor_id . ") ";
            }
        }

        if (isset($addressee_id)) {
            if ($addressee_id != "") {
                $sql .= " AND t.addressee_id in (" . $addressee_id . ") ";
            }

        }

        if (isset($sensor_id)) {
            if (strval($sensor_id) != "") {
                if (is_numeric($sensor_id)) {
                    $sql .= " AND tr.`sensor_id` = " . $sensor_id . " ";
                } else {
                    $sql .= " AND tr.`sensor_id` in (" . $sensor_id . ") ";
                }
            }
        }

        if ($civicrm) {
            $sql .= " AND t.civicrm = " . strval($civicrm);
        }

        if ($email) {
            $sql .= " AND t.email = " . strval($email);
        }

        if ($sms) {
            $sql .= " AND t.sms = " . strval($sms);
        }

        if ($telegram) {
            $sql .= " AND t.telegram = " . strval($telegram);
        }

        if ($api) {
            $sql .= " AND t.api = " . strval($api);
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
//            CRM_Core_Error::debug_var('dao', $dao);
            $r_delete = CRM_Utils_System::url('civicrm/devices/alert',
                ['action' => 'delete', 'id' => $dao->id]);
            $delete = '<a class="delete-alert action-item crm-hover-button" target="_blank" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $addressee = "";
            if (!empty($dao->addressee_id)) {
                $addressee = '<a href="' . CRM_Utils_System::url('civicrm/contact/view',
                        ['reset' => 1, 'cid' => $dao->addressee_id]) . '">' .
                    CRM_Contact_BAO_Contact::displayName($dao->addressee_id) . '</a>';
            }
            $contact = 'Eee?';
            if ($dao->contact_id) {
                $contact = '<a href="' . CRM_Utils_System::url('civicrm/contact/view',
                        ['reset' => 1, 'cid' => $dao->contact_id]) . '">' .
                    CRM_Contact_BAO_Contact::displayName($dao->contact_id) . '</a>';
            }

            $action = "<span>$delete</span>";
            if($cid){
            $rows[$count][] = $dao->id;
            $rows[$count][] = $dao->date;
            $rows[$count][] = $addressee;
            $rows[$count][] = $dao->device_data;
            $rows[$count][] = $dao->civicrm;
            $rows[$count][] = $dao->email;
            $rows[$count][] = $action;
            }else{
                $rows[$count][] = $dao->id;
                $rows[$count][] = $dao->date;
                $rows[$count][] = $contact;
                $rows[$count][] = $addressee;
                $rows[$count][] = $dao->device_data;
                $rows[$count][] = $dao->civicrm;
                $rows[$count][] = $dao->email;
                $rows[$count][] = $action;
            }
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
