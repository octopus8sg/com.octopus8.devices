<?php

use CRM_Healthmonitor_ExtensionUtil as E;

class CRM_Healthmonitor_Page_DashBoard extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('Devices Dashboard'));

        // Alarm Rules
        $alarmRulesSql = "SELECT COUNT(d.id)
                           from civicrm_health_alarm_rule d";
        $alarmRulesCount = CRM_Core_DAO::singleValueQuery($alarmRulesSql);
        $this->assign('alarmRuleCount', $alarmRulesCount);

        // Alert Rules
        $alertRulesSql = "SELECT COUNT(d.id)
                           from civicrm_health_alert_rule d";
        $alertRulesCount = CRM_Core_DAO::singleValueQuery($alertRulesSql);
        $this->assign('alertRuleCount', $alertRulesCount);
//        CRM_Core_Error::debug_var('dashboard_sql', $sql);

        //devices
        $device_sql = "SELECT COUNT(d.id)
                           from civicrm_device d";
        $deviceCount = CRM_Core_DAO::singleValueQuery($device_sql);
        $this->assign('deviceCount', $deviceCount);
//        CRM_Core_Error::debug_var('deviceCount', $deviceCount);

        //device users
        $device_user_sql = "SELECT COUNT(DISTINCT d.contact_id)
                           from civicrm_device d";
        $deviceUserCount = CRM_Core_DAO::singleValueQuery($device_user_sql);
        $this->assign('deviceUserCount', $deviceUserCount);
//        CRM_Core_Error::debug_var('deviceUserCount', $deviceUserCount);

        $sensors_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_option_value s
        INNER JOIN civicrm_option_group gs
                   ON s.option_group_id = gs.id
                       AND gs.name = 'health_monitor_sensor' 
    where s.is_active = TRUE";
        $sensorsCount = CRM_Core_DAO::singleValueQuery($sensors_sql);
        $this->assign('sensorsCount', $sensorsCount);
//        CRM_Core_Error::debug_var('sensorsCount', $sensorsCount);

        $last_year_datas_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_health_monitor s
    WHERE YEAR(s.date) = (YEAR(CURDATE()) - 1)";
        $last_year_datas_Count = CRM_Core_DAO::singleValueQuery($last_year_datas_sql);
        $this->assign('last_year_datas_Count', $last_year_datas_Count);
//        CRM_Core_Error::debug_var('last_year_datas_Count', $last_year_datas_Count);

        $this_year_datas_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_health_monitor s
    WHERE YEAR(s.date) = YEAR(CURDATE())";
        $this_year_datas_Count = CRM_Core_DAO::singleValueQuery($this_year_datas_sql);
        $this->assign('this_year_datas_Count', $this_year_datas_Count);
//        CRM_Core_Error::debug_var('this_year_datas_Count', $this_year_datas_Count);

        $last_year_alarms_sql = "SELECT COUNT(DISTINCT a.id) FROM
                                 civicrm_health_alarm a INNER JOIN
        civicrm_health_monitor s
        ON a.health_monitor_id = s.id
        WHERE YEAR(s.date) = (YEAR(CURDATE()) - 1)";
        $last_year_alarms_Count = CRM_Core_DAO::singleValueQuery($last_year_alarms_sql);
        $this->assign('last_year_alarms_Count', $last_year_alarms_Count);
//        CRM_Core_Error::debug_var('last_year_alarms_Count', $last_year_alarms_Count);

        $this_year_alarms_sql = "SELECT COUNT(DISTINCT a.id) from
                                 civicrm_health_alarm a INNER JOIN
        civicrm_health_monitor s
        ON a.health_monitor_id = s.id
    WHERE YEAR(s.date) = YEAR(CURDATE())";
        $this_year_alarms_Count = CRM_Core_DAO::singleValueQuery($this_year_alarms_sql);
        $this->assign('this_year_alarms_Count', $this_year_alarms_Count);
//        CRM_Core_Error::debug_var('this_year_alarms_Count', $this_year_alarms_Count);

        $last_year_alerts_sql = "
    SELECT COUNT(DISTINCT t.id) from
    civicrm_health_alert t INNER JOIN
    civicrm_health_alarm a ON t.health_alarm_id = a.id
    INNER JOIN civicrm_health_monitor s
    ON a.health_monitor_id = s.id
    WHERE YEAR(s.date) = (YEAR(CURDATE()) - 1)
    ";
        $last_year_alerts_Count = CRM_Core_DAO::singleValueQuery($last_year_alerts_sql);
        $this->assign('last_year_alerts_Count', $last_year_alerts_Count);
//        CRM_Core_Error::debug_var('last_year_alerts_Count', $last_year_alerts_Count);

        $this_year_alerts_sql = "
    SELECT COUNT(DISTINCT t.id) from
    civicrm_health_alert t INNER JOIN
    civicrm_health_alarm a ON t.health_alarm_id = a.id
    INNER JOIN civicrm_health_monitor s
    ON a.health_monitor_id = s.id
    WHERE YEAR(s.date) = YEAR(CURDATE())
";
        $this_year_alerts_Count = CRM_Core_DAO::singleValueQuery($this_year_alerts_sql);
        $this->assign('this_year_alerts_Count', $this_year_alerts_Count);
//        CRM_Core_Error::debug_var('this_year_alerts_Count', $this_year_alerts_Count);

        $last_month_datas_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_health_monitor s
    WHERE MONTH(s.date) = MONTH(CURDATE() - INTERVAL 1 MONTH)";
        $last_month_datas_Count = CRM_Core_DAO::singleValueQuery($last_month_datas_sql);
        $this->assign('last_month_datas_Count', $last_month_datas_Count);
//        CRM_Core_Error::debug_var('last_month_datas_Count', $last_month_datas_Count);

        $this_month_datas_sql = "SELECT COUNT(DISTINCT s.id) from
    civicrm_health_monitor s
    WHERE MONTH(s.date) = MONTH(CURDATE())";
        $this_month_datas_Count = CRM_Core_DAO::singleValueQuery($this_month_datas_sql);
        $this->assign('this_month_datas_Count', $this_month_datas_Count);
//        CRM_Core_Error::debug_var('this_month_datas_Count', $this_month_datas_Count);

        $last_month_alarms_sql = "SELECT COUNT(DISTINCT a.id) FROM
                                 civicrm_health_alarm a INNER JOIN
        civicrm_health_monitor s
        ON a.health_monitor_id = s.id
        WHERE MONTH(s.date) = MONTH(CURDATE() - INTERVAL 1 MONTH)";
        $last_month_alarms_Count = CRM_Core_DAO::singleValueQuery($last_month_alarms_sql);
        $this->assign('last_month_alarms_Count', $last_month_alarms_Count);
//        CRM_Core_Error::debug_var('last_month_alarms_Count', $last_month_alarms_Count);

        $this_month_alarms_sql = "SELECT COUNT(DISTINCT a.id) from
                                 civicrm_health_alarm a INNER JOIN
        civicrm_health_monitor s
        ON a.health_monitor_id = s.id
    WHERE MONTH(s.date) = MONTH(CURDATE())";
        $this_month_alarms_Count = CRM_Core_DAO::singleValueQuery($this_month_alarms_sql);
        $this->assign('this_month_alarms_Count', $this_month_alarms_Count);
//        CRM_Core_Error::debug_var('this_month_alarms_Count', $this_month_alarms_Count);

        $last_month_alerts_sql = "
    SELECT COUNT(DISTINCT t.id) from
    civicrm_health_alert t INNER JOIN
    civicrm_health_alarm a ON t.health_alarm_id = a.id
    INNER JOIN civicrm_health_monitor s
    ON a.health_monitor_id = s.id
    WHERE MONTH(s.date) = MONTH(CURDATE() - INTERVAL 1 MONTH)
    ";
        $last_month_alerts_Count = CRM_Core_DAO::singleValueQuery($last_month_alerts_sql);
        $this->assign('last_month_alerts_Count', $last_month_alerts_Count);
//        CRM_Core_Error::debug_var('last_month_alerts_Count', $last_month_alerts_Count);

        $this_month_alerts_sql = "
    SELECT COUNT(DISTINCT t.id) from
    civicrm_health_alert t INNER JOIN
    civicrm_health_alarm a ON t.health_alarm_id = a.id
    INNER JOIN civicrm_health_monitor s
    ON a.health_monitor_id = s.id
    WHERE MONTH(s.date) = MONTH(CURDATE())
";
        $this_month_alerts_Count = CRM_Core_DAO::singleValueQuery($this_month_alerts_sql);
        $this->assign('this_month_alerts_Count', $this_month_alerts_Count);
//        CRM_Core_Error::debug_var('this_month_alerts_Count', $this_month_alerts_Count);

        parent::run();
    }

}
