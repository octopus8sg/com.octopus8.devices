<?php

use CRM_Healthmonitor_ExtensionUtil as E;

class CRM_Healthmonitor_Page_ChartPage extends CRM_Civisualize_Page_Main
{
    protected $pageId = false;

    protected $offset = 0;

    protected $limit = false;

    public $count = 0;

    public $rows = [];

    public function browse()
    {
        $this->assign('admin', FALSE);
        $this->assign('context', 'healthmonitor');

        // also create the form element for the activity filter box
        $controller = new CRM_Core_Controller_Simple(
            'CRM_Healthmonitor_Form_HealthMonitorFilter',
            ts('Health Monitor Filter'),
            NULL,
            FALSE, FALSE, TRUE
        );
        $controller->set('contactId', $this->_contactId);
        $controller->setEmbedded(TRUE);
        $controller->run();
//        $this->ajaxResponse['tabCount'] = CRM_Contact_BAO_Contact::getCountComponent('healthmonitor', $this->_contactId);
    }

    function getTemplateFileName()
    {
        $request = CRM_Utils_System::currentPath();
        if (false !== strpos($request, '..')) {
            die ("SECURITY FATAL: the url can't contain '..'. Please report the issue on the forum at civicrm.org");
        }

        $request = explode('/', $request);
        $tplfile = NULL;
        $smarty = CRM_Core_Smarty::singleton();
        $smarty->assign("options", array());
        if (CRM_Utils_Array::value(2, $request)) {
            $tplfile = _civicrm_api_get_camel_name($request[3]);
            $tplfile = explode('?', $tplfile);
            $tpl = 'CRM/Healthmonitor/Dataviz/' . $tplfile[0] . '.tpl';
        }
        if (CRM_Utils_Array::value(3, $request)) {
            $r3 = _civicrm_api_get_camel_name($request[3]);
            $smarty->assign("id", $r3);
        }
        if (CRM_Utils_Array::value(4, $request)) {
            $r3 = CRM_Utils_String::munge($request[4]);
            $smarty->assign("id2", $r3);
        }
        if (!$tplfile) {
            $tpl = "CRM/Civisualize/Page/Main.tpl";
        }
        if (!$smarty->template_exists($tpl)) {
            header("Status: 404 Not Found");
            die ("Can't find the requested template file templates/$tpl");
        }
        return $tpl;
    }

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml

        CRM_Utils_System::setTitle(E::ts('HM Data Entries'));
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
        $this->assign('contactId', $contactId);

        $this->assign('useAjax', true);
        $urlQry['snippet'] = 4;
        $urlQry['cid'] = $contactId;
        $this->assign('sourceUrl', CRM_Utils_System::url('civicrm/healthmonitor/ajax', $urlQry, FALSE, NULL, FALSE));


        $healthMonitors = \Civi\Api4\HealthMonitor::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();
        $devices = \Civi\Api4\Device::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();

//        CRM_Core_Error::debug_var('tabrows', $healthMonitors->rowCount);


        $this->assign('dataCount', $healthMonitors->rowCount);
        $this->assign('deviceCount', $devices->rowCount);

        $this->assign('data_sourceUrl', CRM_Utils_System::url('civicrm/healthmonitor/data_ajax', $urlQry, FALSE, NULL, FALSE));
        $this->assign('devices_sourceUrl', CRM_Utils_System::url('civicrm/healthmonitor/device_ajax', $urlQry, FALSE, NULL, FALSE));
//        $this->assign('alert_sourceUrl', CRM_Utils_System::url('civicrm/healthmonitor/alert_ajax', $urlQry, FALSE, NULL, FALSE));

//        CRM_Core_Error::debug_var('tabrows', $rows);

        // Set the user context
        $session = CRM_Core_Session::singleton();
        $userContext = CRM_Utils_System::url('civicrm/contact/view', 'cid=' . $contactId . '&selectedChild=contact_health_monitor&reset=1');
        $session->pushUserContext($userContext);
        $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this);

        $this->browse();
        // Example: Assign a variable for use in a template
        $this->assign('currentTime', date('Y-m-d H:i:s'));

        parent::run();
    }

}
