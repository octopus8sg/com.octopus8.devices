<?php

use CRM_Devices_ExtensionUtil as E;

class CRM_Devices_Page_SearchAlertRule extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('SearchAlertRule'));

        // Example: Assign a variable for use in a template
        $this->assign('currentTime', date('Y-m-d H:i:s'));

        parent::run();
    }

    public function getAjax()
    {
//
        CRM_Core_Error::debug_var('request', $_REQUEST);
        CRM_Core_Error::debug_var('post', $_POST);

        $cid = CRM_Utils_Request::retrieve('cid', 'Positive');
        $contactId = CRM_Utils_Request::retrieve('contact_id', 'CommaSeparatedIntegers');
//        CRM_Core_Error::debug_var('contact', $contactId);


        $offset = CRM_Utils_Request::retrieveValue('iDisplayStart', 'Positive', 0);
//        CRM_Core_Error::debug_var('offset', $offset);

        $limit = CRM_Utils_Request::retrieveValue('iDisplayLength', 'Positive', 10);
//        CRM_Core_Error::debug_var('limit', $limit);

        $sensor_id = CRM_Utils_Request::retrieveValue('sensor_id', 'CommaSeparatedIntegers', null);
//        CRM_Core_Error::debug_var('sensor_id', $sensor_id);

        $alert_rule_id = CRM_Utils_Request::retrieveValue('alert_rule_id', 'String', null);
        CRM_Core_Error::debug_var('alert_rule_id', $alert_rule_id);

        $alert_rule_type = CRM_Utils_Request::retrieveValue('alert_rule_type', 'CommaSeparatedIntegers', null);
        CRM_Core_Error::debug_var('alert_rule_type', $alert_rule_type);
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
        CRM_Core_Error::debug_var('alert_rule_types', strval($alert_rule_types));

        $civicrm = boolval(in_array('0', $alert_rule_types));
        CRM_Core_Error::debug_var('civicrm', strval($civicrm));

        $email = boolval(in_array('1', $alert_rule_types));
        CRM_Core_Error::debug_var('email', $email);

        $sms = boolval(in_array('2', $alert_rule_types));
        CRM_Core_Error::debug_var('sms', $sms);

        $telegram = boolval(in_array('3', $alert_rule_types));
        CRM_Core_Error::debug_var('telegram', $telegram);

        $api = boolval(in_array('4', $alert_rule_types));
        CRM_Core_Error::debug_var('api', $api);


        $addressee_id = CRM_Utils_Request::retrieveValue('alert_rule_addressee_id', 'CommaSeparatedIntegers', null);
//        CRM_Core_Error::debug_var('addressee_id', $addressee_id);


        $sortMapper = [
            0 => 'id',
            1 => 'code',
            2 => 'title',
            3 => 'sensor_name',
            4 => 'addressee_id',
            5 => 'civicrm',
            6 => 'email',
            7 => 'sms',
            8 => 'telegram',
            9 => 'api',
        ];

        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';


        $sql = "
    SELECT SQL_CALC_FOUND_ROWS
      t.id,
       t.code,
       t.title,
       s.label sensor_name,
       t.addressee_id,
       t.civicrm,
       t.email,
       t.sms,
       t.telegram,
       t.api
    FROM civicrm_o8_device_alert_rule t
    INNER JOIN civicrm_o8_device_alarm_rule r on  t.rule_id = r.id
    INNER JOIN civicrm_option_value s on  r.sensor_id = s.value
    INNER JOIN civicrm_option_group gs on s.option_group_id = gs.id and gs.name = 'o8_device_sensor'
      WHERE 1";

        if (isset($alert_rule_id)) {
            if (strval($alert_rule_id) != "") {
                $sql .= " AND (t.`code` like '%" . strval($alert_rule_id) . "%' OR t.`title` like '%" . strval($alert_rule_id) . "%') ";
                if (is_numeric($alert_rule_id)) {
                    $sql .= " OR t.`id` = " . intval($alert_rule_id) . " ";
                }
            }
        }

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

        if (isset($addressee_id)) {
            if (strval($addressee_id) != "") {
                $sql .= " AND t.`adressee_id` in (" . $addressee_id . ") ";
            }
        }

        if (isset($sensor_id)) {
            if (strval($sensor_id) != "") {
                if (is_numeric($sensor_id)) {
                    $sql .= " AND r.`sensor_id` = " . $sensor_id . " ";
                } else {
                    $sql .= " AND r.`sensor_id` in (" . $sensor_id . ") ";
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

        if ($sort !== NULL) {
            $sql .= " ORDER BY {$sort} {$sortOrder}";
        } else {
            $sql = $sql . ' ORDER BY t.id ASC';
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


//        CRM_Core_Error::debug_var('alert_rule_sql', $sql);

        $dao = CRM_Core_DAO::executeQuery($sql);
        $iFilteredTotal = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $rows = array();
        $count = 0;
        while ($dao->fetch()) {
            $r_update = CRM_Utils_System::url('civicrm/devices/alertrule',
                ['action' => 'update', 'id' => $dao->id]);
            $r_delete = CRM_Utils_System::url('civicrm/devices/alertrule',
                ['action' => 'delete', 'id' => $dao->id]);
            $update = '<a target="_blank" class="update-alert-rule action-item crm-hover-button" href="' . $r_update . '"><i class="crm-i fa-pencil"></i>&nbsp;Edit</a>';
            $delete = '<a target="_blank" class="delete-alert-rule action-item crm-hover-button" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $civicrm = '';
            $addressee = "";
            if (!empty($dao->addressee_id)) {
                $addressee = '<a href="' . CRM_Utils_System::url('civicrm/contact/view',
                        ['reset' => 1, 'cid' => $dao->addressee_id]) . '">' .
                    CRM_Contact_BAO_Contact::displayName($dao->addressee_id) . '</a>';
            }

            if ($dao->civicrm) $civicrm = '&#10004;';
            $email = '';
            if ($dao->email) $email = '&#10004;';
            $sms = '';
            if ($dao->sms) $sms = '&#10004;';
            $telegram = '';
            if ($dao->telegram) $telegram = '&#10004;';
            $api = '';
            if ($dao->api) $api = '&#10004;';
            $action = "<span>$update $delete</span>";
            $rows[$count][] = $dao->id;
            $rows[$count][] = $dao->code;
            $rows[$count][] = $dao->title;
            $rows[$count][] = $dao->sensor_name;
            $rows[$count][] = $addressee;
            $rows[$count][] = $civicrm;
            $rows[$count][] = $email;
            $rows[$count][] = $sms;
            $rows[$count][] = $telegram;
            $rows[$count][] = $api;
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
