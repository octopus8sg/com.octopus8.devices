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
//        CRM_Core_Error::debug_var('request', $_REQUEST);
//        CRM_Core_Error::debug_var('post', $_POST);

        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');
//        CRM_Core_Error::debug_var('contact', $contactId);


        $offset = CRM_Utils_Request::retrieveValue('iDisplayStart', 'Positive', 0);
//        CRM_Core_Error::debug_var('offset', $offset);

        $limit = CRM_Utils_Request::retrieveValue('iDisplayLength', 'Positive', 10);
//        CRM_Core_Error::debug_var('limit', $limit);

        $sensor_id = CRM_Utils_Request::retrieveValue('alert_rule_sensor_id', 'Positive', null);
//        CRM_Core_Error::debug_var('sensor_id', $sensor_id);

        $civicrm = CRM_Utils_Request::retrieveValue('alert_rule_civicrm', 'Boolean', null);
//        CRM_Core_Error::debug_var('civicrm', strval($civicrm));

        $email = CRM_Utils_Request::retrieveValue('alert_rule_email', 'Boolean', null);
//        CRM_Core_Error::debug_var('email', $email);

        $telegram = CRM_Utils_Request::retrieveValue('alert_rule_telegram', 'Boolean', null);
//        CRM_Core_Error::debug_var('telegram', $telegram);

        $api = CRM_Utils_Request::retrieveValue('alert_rule_api', 'Boolean', null);
//        CRM_Core_Error::debug_var('api', $api);


        $addressee_id = CRM_Utils_Request::retrieveValue('alert_rule_addressee_id', 'String', null);
//        CRM_Core_Error::debug_var('addressee_id', $addressee_id);


        $sortMapper = [
            0 => 'id',
            1 => 'code',
            2 => 'title',
            3 => 'sensor_name',
            4 => 'addressee_id',
            5 => 'civicrm',
            6 => 'email',
            7 => 'telegram',
            8 => 'api',
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
       t.telegram,
       t.api
FROM civicrm_health_alert_rule t
    INNER JOIN civicrm_health_alarm_rule r on  t.rule_id = r.id
    INNER JOIN civicrm_option_value s on  r.sensor_id = s.value
    INNER JOIN civicrm_option_group gs on s.option_group_id = gs.id and gs.name = 'health_monitor_sensor'
      WHERE 1";

        if (isset($contactId)) {
            $sql .= " AND t.contact_id = " . $contactId . " ";
        }

        if (isset($addressee_id)) {
            if ($addressee_id != "") {
                $sql .= " AND t.addressee_id in (" . $addressee_id . ") ";
            }
        }


        if (isset($sensor_id)) {
            if ($sensor_id > 0) {
                $sql .= " AND r.sensor_id = " . $sensor_id . " ";
            }
        }

        if (!(strval($civicrm) === strval($email)
            and strval($civicrm) === strval($telegram)
            and strval($civicrm) === strval($api)
            and strval($civicrm) === 'false')) {
            if (isset($civicrm)) {
                $sql .= " AND t.civicrm = " . strval($civicrm);
            }

            if (isset($email)) {
                $sql .= " AND t.email = " . strval($email);
            }

            if (isset($telegram)) {
                $sql .= " AND t.telegram = " . strval($telegram);
            }

            if (isset($api)) {
                $sql .= " AND t.api = " . strval($api);
            }
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
            $r_update = CRM_Utils_System::url('civicrm/alertrule/form',
                ['action' => 'update', 'id' => $dao->id]);
            $r_delete = CRM_Utils_System::url('civicrm/alertrule/form',
                ['action' => 'delete', 'id' => $dao->id]);
            $update = '<a target="_blank" class="action-item crm-hover-button" href="' . $r_update . '"><i class="crm-i fa-pencil"></i>&nbsp;Edit</a>';
            $delete = '<a target="_blank" class="action-item crm-hover-button" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
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
