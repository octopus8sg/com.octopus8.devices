<?php

use CRM_Healthmonitor_ExtensionUtil as E;

class CRM_Healthmonitor_Page_AlarmRuleSearch extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('AlarmRuleSearch'));

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

        $sensor_id = CRM_Utils_Request::retrieveValue('alarm_rule_sensor_id', 'Positive', null);
//        CRM_Core_Error::debug_var('sensor_id', $sensor_id);


        $sortMapper = [
            0 => 'id',
            1 => 'code',
            2 => 'sensor_name',
            3 => 'rule_name',
            4 => 'sensor_value'
        ];

        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';

//     SQL_CALC_FOUND_ROWS
        $sql = " SELECT  SQL_CALC_FOUND_ROWS
      t.id,
       t.code,
       s.label sensor_name,
       r.label rule_name,
       t.sensor_value
FROM civicrm_health_alarm_rule t
    INNER JOIN civicrm_option_value r on  t.rule_id = r.value
    INNER JOIN civicrm_option_group gr on r.option_group_id = gr.id and gr.name = 'health_alarm_rule_type'
    INNER JOIN civicrm_option_value s on  t.sensor_id = s.value
    INNER JOIN civicrm_option_group gs on s.option_group_id = gs.id and gs.name = 'health_monitor_sensor'
      WHERE 1";

        if (isset($contactId)) {
            $sql .= " AND t.contact_id = " . $contactId . " ";
        }


        if (isset($sensor_id)) {
            if ($sensor_id > 0) {
                $sql .= " AND t.sensor_id = " . $sensor_id . " ";
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


//        CRM_Core_Error::debug_var('alarm_rule_sql', $sql);

        $dao = CRM_Core_DAO::executeQuery($sql);
        $iFilteredTotal = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $rows = array();
        $count = 0;
        while ($dao->fetch()) {
            $r_update = CRM_Utils_System::url('civicrm/alarmrule/form',
                ['action' => 'update', 'id' => $dao->id]);
            $r_delete = CRM_Utils_System::url('civicrm/alarmrule/form',
                ['action' => 'delete', 'id' => $dao->id]);
            $update = '<a class="action-item crm-hover-button" target="_blank" href="' . $r_update . '"><i class="crm-i fa-pencil"></i>&nbsp;Edit</a>';
            $delete = '<a class="action-item crm-hover-button" target="_blank" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $action = "<span>$update $delete</span>";
            $rows[$count][] = $dao->id;
            $rows[$count][] = $dao->code;
            $rows[$count][] = $dao->sensor_name;
            $rows[$count][] = $dao->rule_name;
            $rows[$count][] = $dao->sensor_value;
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
