<?php

use CRM_Devices_ExtensionUtil as E;

class CRM_Devices_Page_ContactTab extends CRM_Core_Page
{

    public function browse()
    {
        $this->assign('admin', FALSE);
        $this->assign('context', 'devices');

        // also create the form element for the filter box
        // have to put all filters in one filter form
        $controller_data = new CRM_Core_Controller_Simple(
            'CRM_Devices_Form_CommonFilter',
            ts('Device Data Filter'),
            NULL,
            FALSE, FALSE, TRUE
        );
        $controller_data->set('contactId', $this->_contactId);
        $controller_data->set('cid', $this->_contactId);
        $controller_data->setEmbedded(TRUE);
        $controller_data->run();

    }

    public function run()
    {
        //  common variables and js

        CRM_Utils_System::setTitle(E::ts('Device Data'));
//        $cId = CRM_Utils_Request::retrieve('cid');
//        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
        $this->assign('contactId', $contactId);
//        CRM_Core_Error::debug_var('contactId', $contactId);
//
//        // datatables style and js (for export etc)
//
//
//        // data datatable js and variables
        // data datatable js and variables
        $this->assign('useAjax', true);
        $sourceUrl = [];
        $ajaxUrl = [];
        $urlQry['snippet'] = 4;
        $urlQry['cid'] = $contactId;
        $this->assign('sourceUrl', "");
        $datas = \Civi\Api4\DeviceData::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();
        $this->assign('dataCount', $datas->rowCount);
        $data_sourceUrl = CRM_Utils_System::url('civicrm/devices/devicedata_ajax', $urlQry, FALSE, NULL, FALSE);
        $sourceUrl['data_sourceUrl'] = $data_sourceUrl;
        $this->assign('devicedata_sourceUrl', $data_sourceUrl);

        // devices datatable js and variables
        $devices = \Civi\Api4\Device::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();
        $this->assign('deviceCount', $devices->rowCount);
        $device_sourceUrl = CRM_Utils_System::url('civicrm/devices/device_ajax', $urlQry, FALSE, NULL, FALSE);
        $sourceUrl['device_sourceUrl'] = $device_sourceUrl;
        $this->assign('device_sourceUrl', $device_sourceUrl);

        // alarm rules datatable js and variables
        $alarmRules = \Civi\Api4\AlarmRule::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();
        $this->assign('alarmRuleCount', $alarmRules->rowCount);
        $alarmRules_sourceUrl = CRM_Utils_System::url('civicrm/devices/alarmrule_ajax', $urlQry, FALSE, NULL, FALSE);
        $sourceUrl['alarmrules_sourceUrl'] = $alarmRules_sourceUrl;
        $this->assign('alarmrules_sourceUrl', $alarmRules_sourceUrl);

        // alert rules datatable js and variables
//        Civi::resources()->addScriptFile('com.octopus8.healthmonitor', 'js/alertrules.js', 2);
        $alertRules = \Civi\Api4\AlertRule::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();
        $this->assign('alertRuleCount', $alertRules->rowCount);
        $alertRules_sourceUrl = CRM_Utils_System::url('civicrm/devices/alertrule_ajax', $urlQry, FALSE, NULL, FALSE);
        $sourceUrl['alertrules_sourceUrl'] = $alertRules_sourceUrl;
        $this->assign('alertrules_sourceUrl', $alertRules_sourceUrl);

        // alarm datatable js and variables
//        Civi::resources()->addScriptFile('com.octopus8.healthmonitor', 'js/alarm.js', 2);
        $alarms = \Civi\Api4\Alarm::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();
        $this->assign('alarmCount', $alarms->rowCount);
        $alarm_sourceUrl = CRM_Utils_System::url('civicrm/devices/alarm_ajax', $urlQry, FALSE, NULL, FALSE);
        $sourceUrl['alarm_sourceUrl'] = $alarm_sourceUrl;
        $this->assign('alarm_sourceUrl', $alarm_sourceUrl);

        // alert rules datatable js and variables
        $alerts = \Civi\Api4\Alert::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();
        $this->assign('alertCount', $alerts->rowCount);
        $alert_sourceUrl = CRM_Utils_System::url('civicrm/devices/alert_ajax', $urlQry, FALSE, NULL, FALSE);
        $sourceUrl['alert_sourceUrl'] = $alert_sourceUrl;
        $this->assign('alert_sourceUrl', $alert_sourceUrl);

        // chart js and variables
        $ajaxUrl[] = CRM_Utils_System::url('civicrm/devices/chart_ajax');
        $ajaxUrl[] = $contactId;


        CRM_Core_Resources::singleton()->addVars('ajax_url', $ajaxUrl);
        CRM_Core_Resources::singleton()->addVars('source_url', $sourceUrl);

        // Set the user context
        $session = CRM_Core_Session::singleton();
        $userContext = CRM_Utils_System::url('civicrm/contact/view', 'cid=' . $contactId . '&selectedChild=contact_devices&reset=1');
        $session->pushUserContext($userContext);
        // run controllers for tabs
        $this->browse();
        parent::run();
    }

}
