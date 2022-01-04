<?php

use CRM_Devices_ExtensionUtil as E;

class CRM_Devices_Page_SearchCharts extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('SearchCharts'));

        // Example: Assign a variable for use in a template
        $this->assign('currentTime', date('Y-m-d H:i:s'));

        parent::run();
    }

    public function getAjax()
    {
//        CRM_Core_Error::debug_var('request_get', 'get');
//        CRM_Core_Error::debug_var('request', $_REQUEST);
//        CRM_Core_Error::debug_var('post', $_POST);

        $cid = CRM_Utils_Request::retrieve('cid', 'Positive');
        //cid = contact for tabset
//        CRM_Core_Error::debug_var('cid', $cid);

        $contactId = CRM_Utils_Request::retrieve('contact_id', 'CommaSeparatedIntegers');
        if(is_array($contactId)){
            $contactId = implode(",", $contactId);
        }
//        CRM_Core_Error::debug_var('device_type_id', $device_type_id);

        $device_type_id = CRM_Utils_Request::retrieveValue('device_type_id', 'CommaSeparatedIntegers', null);
//        CRM_Core_Error::debug_var('device_type_id', $device_type_id);
        if(is_array($device_type_id)){
            $device_type_id = implode(",", $device_type_id);
        }

        $sensor_id = CRM_Utils_Request::retrieveValue('sensor_id', 'CommaSeparatedIntegers', null);
        if(is_array($sensor_id)){
            $sensor_id = implode(",", $sensor_id);
        }
//        CRM_Core_Error::debug_var('sensor_id', $sensor_id);

        $dateselect_to = CRM_Utils_Request::retrieveValue('dateselect_to', 'String', null);
        try {
            //just check if is a date
            $dateselectto = new DateTime($dateselect_to);
        } catch (Exception $e) {
            $dateselect_to = null;
        }
//        CRM_Core_Error::debug_var('dateselect_to', $dateselect_to);

        $dateselect_from = CRM_Utils_Request::retrieveValue('dateselect_from', 'String', null);
        try {
            //just check if is a date
            $dateselectfrom = new DateTime($dateselect_from);
        } catch (Exception $e) {
            $dateselect_from = null;
        }

        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('ChartPage'));
        Civi::resources()->addScriptFile('com.octopus8.devices', 'js/Chart.bundle.min.js', 1);
        Civi::resources()->addScriptFile('com.octopus8.devices', 'js/chart.js', 2);
        // Example: Assign a variable for use in a template
        $sensors = CRM_Core_OptionGroup::values('o8_device_sensor');

        $sql = "SELECT 
      `hmh`.`date` as `label`,
      `hmh`.`sensor_value`,
      `hmh`.`sensor_id`
    FROM `civicrm_o8_device_data` `hmh` 
    INNER JOIN civicrm_o8_device_device hmd on hmh.device_id = hmd.id
    WHERE 1";

        $user_id = CRM_Core_Session::singleton()->getLoggedInContactID();
        if (isset($contactId)) {
            $sql .= " AND `hmh`.`contact_id` in (" . $contactId . ") ";
        } else {
            $sql .= " AND `hmh`.`contact_id` = " . $user_id . " ";

        }

        if (isset($device_type_id)) {
            if (strval($device_type_id) != "") {
                $sql .= " AND `hmd`.`device_type_id` in (" . $device_type_id . ") ";
            }
        }

        if (isset($sensor_id)) {
            if (strval($sensor_id) != "") {
                $sql .= " AND `hmh`.`sensor_id` in ( " . $sensor_id . ") ";
            } else {
                $sql .= " AND `hmh`.`sensor_id` in (1) ";
            }
        } else {
            $sql .= " AND `hmh`.`sensor_id` in (2) ";
        }

        $month_ago = strtotime("-1 month", time());
        $date_month_ago = date("Y-m-d H:i:s", $month_ago);

        $today = strtotime("-1 minute", time());
        $date_today = date("Y-m-d H:i:s", $today);

        if (isset($dateselect_from)) {
            if ($dateselect_from != null) {
                if ($dateselect_from != '') {
                    $sql .= " AND `hmh`.`date` >= '" . $dateselect_from . "' ";
                } else {
                    $sql .= " AND `hmh`.`date` >= '" . $date_month_ago . "' ";
                }

            } else {
                $sql .= " AND `hmh`.`date` >= '" . $date_month_ago . "' ";
            }
        } else {
            $sql .= " AND `hmh`.`date` >= '" . $date_month_ago . "' ";
        }

        if (isset($dateselect_to)) {
            if ($dateselect_to != null) {
                if ($dateselect_to != '') {
                    $sql .= " AND `hmh`.`date` <= '" . $dateselect_to . "' ";
                } else {
                    $sql .= " AND `hmh`.`date` <= '" . $date_today . "' ";
                }
            } else {
                $sql .= " AND `hmh`.`date` <= '" . $date_today . "' ";
            }
        } else {
            $sql .= " AND `hmh`.`date` <= '" . $date_today . "' ";
        }

        $sql = $sql . ' ORDER BY `hmh`.`date` ASC';

//        CRM_Core_Error::debug_var('chart_sql', $sql);

        $dao = CRM_Core_DAO::executeQuery($sql);

        $labels = [];
        $datasets = [];
        foreach ($sensors as $key => $val) {
            $datasets[$key]['label'] = $val;
            $datasets[$key]['data'] = [];
        }
        $count = 0;
        while ($dao->fetch()) {
            $sensor_id = $dao->sensor_id;
//            print_r($dao->toArray());
            $labels[$count] = $dao->label;
            $datasets[$sensor_id]['data'][] = [
                'x' => $dao->label,
                'y' => $dao->sensor_value
            ];
            $count++;
        }

        $hmdatas = [];
        $hmdatas['labels'] = $labels;
        foreach ($datasets as $key => $val) {
            $hmdatas['datasets'][] = $val;
        }

        CRM_Utils_JSON::output($hmdatas);

    }


}
