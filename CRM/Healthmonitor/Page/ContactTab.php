<?php

use CRM_Healthmonitor_ExtensionUtil as E;


class CRM_Healthmonitor_Page_ContactTab extends CRM_Core_Page
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

//        CRM_Core_Error::debug_var('tabrows', $healthMonitors->rowCount);


        $this->assign('dataCount', $healthMonitors->rowCount);

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
        parent::run();
    }

}
