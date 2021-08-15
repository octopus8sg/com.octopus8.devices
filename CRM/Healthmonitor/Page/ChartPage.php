<?php

use CRM_Healthmonitor_ExtensionUtil as E;

class CRM_Healthmonitor_Page_ChartPage extends CRM_Core_Page
{

    public function run()
    {
      $time = strtotime("-367 days");
      $logged_user_id = CRM_Core_Session::singleton()->getLoggedInContactID();
//      for($i=0;$i<364;$i++){
//          $time = strtotime("+1 day", $time);
//          $date = date("Y-m-d H:i:s", $time);
//          $sensor_value = random_int(56,65);
//          $device_name = "H1SmartWatch";
//          $sensor_id = "heart_rate";
//          $result = civicrm_api3('HealthMonitor', 'create', [
//              'date' => $date,
//              'sensor_value' => $sensor_value,
//              'device_code' => $device_name,
//              'contact_id' => $logged_user_id,
//              'sensor_id' => $sensor_id,
//          ]);
//          $sensor_value = 0.1 * random_int(355,370);
//          $device_name = "H1SmartWatch";
//          $sensor_id = "body_temperature";
//          $result = civicrm_api3('HealthMonitor', 'create', [
//              'date' => $date,
//              'sensor_value' => $sensor_value,
//              'device_code' => $device_name,
//              'contact_id' => $logged_user_id,
//              'sensor_id' => $sensor_id,
//          ]);
//      }

        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('ChartPage'));
        Civi::resources()->addScriptFile('com.octopus8.healthmonitor', 'js/Chart.bundle.min.js', 1);
        Civi::resources()->addScriptFile('com.octopus8.healthmonitor', 'js/chart.js', 2);
        $ajaxUrl = [];
        $ajaxUrl[] = CRM_Utils_System::url('civicrm/healthmonitor/chart_ajax');
        $ajaxUrl[] = $logged_user_id;
        CRM_Core_Resources::singleton()->addVars('ajax_url', $ajaxUrl);

//add form for filter
        $controller = new CRM_Core_Controller_Simple(
            'CRM_Healthmonitor_Form_HealthMonitorFilter',
            ts('Health Monitor Filter'),
            NULL,
            FALSE, FALSE, TRUE
        );
        $controller->set('contactId', $logged_user_id);
        $controller->setEmbedded(TRUE);
        $controller->run();


        parent::run();
    }

    public function getAjax()
    {
        CRM_Core_Error::debug_var('request_get', 'get');
        CRM_Core_Error::debug_var('request', $_REQUEST);
        CRM_Core_Error::debug_var('post', $_POST);

        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');
//        CRM_Core_Error::debug_var('contact', $contactId);


        $device_type_id = CRM_Utils_Request::retrieveValue('device_type_id', 'Positive', null);
//        CRM_Core_Error::debug_var('device_type_id', $device_type_id);

        $sensor_id = CRM_Utils_Request::retrieveValue('sensor_id', 'Positive', null);
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
        Civi::resources()->addScriptFile('com.octopus8.healthmonitor', 'js/Chart.bundle.min.js', 1);
        Civi::resources()->addScriptFile('com.octopus8.healthmonitor', 'js/chart.js', 2);
        // Example: Assign a variable for use in a template
        $sensors = CRM_Core_OptionGroup::values('health_monitor_sensor');

        $sql = "SELECT 
      `hmh`.`date` as `label`,
      `hmh`.`sensor_value`,
      `hmh`.`sensor_id`
    FROM `civicrm_health_monitor` `hmh` 
    WHERE 1";

        if (isset($contactId)) {
            $sql .= " AND `hmh`.`contact_id` = " . $contactId . " ";
        }

        if (isset($device_type_id)) {
            if ($device_type_id > 0) {
                $sql .= " AND `hmh`.`device_type_id` = " . $device_type_id . " ";
            }
        }

        if (isset($sensor_id)) {
            if ($sensor_id > 0) {
                $sql .= " AND `hmh`.`sensor_id` = " . $sensor_id . " ";
            }
        }


        if (isset($dateselect_from)) {
            if ($dateselect_from != null) {
                if ($dateselect_from != '') {
                    $sql .= " AND `hmh`.`date` >= '" . $dateselect_from . "' ";
                }
            }
        }

        if (isset($dateselect_to)) {
            if ($dateselect_to != null) {
                if ($dateselect_to != '') {
                    $sql .= " AND `hmh`.`date` <= '" . $dateselect_to . "' ";
                }
            }
        }

        $sql = $sql . ' ORDER BY `hmh`.`date` ASC';
        $dao = CRM_Core_DAO::executeQuery($sql);

        $labels = [];
        $datasets = [];
        foreach ($sensors as $key => $val){
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
        $ajaxUrl = CRM_Utils_System::url('civicrm/healthmonitor/chart_ajax');
        $hmdatas = [];
        $hmdatas['labels'] = $labels;
        foreach ($datasets as $key => $val){
        $hmdatas['datasets'][] = $val;
        }
//        CRM_Core_Resources::singleton()->addVars('labels', $labels);
//        CRM_Core_Resources::singleton()->addVars('heart_rate', $heart_rate);
//        CRM_Core_Resources::singleton()->addVars('temperature', $body_temperature);
//        CRM_Core_Resources::singleton()->addVars('ajaxUrl', $ajaxUrl);
// http://localhost:3306/wp-admin/admin.php?page=CiviCRM&q=civicrm%2Fhealthmonitor%2Fchart_ajax
        CRM_Utils_JSON::output($hmdatas);

    }

}
