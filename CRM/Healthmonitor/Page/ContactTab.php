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
        $controller_data = new CRM_Core_Controller_Simple(
            'CRM_Healthmonitor_Form_HealthMonitorFilter',
            ts('Health Monitor Filter'),
            NULL,
            FALSE, FALSE, TRUE
        );
        $controller_data->set('contactId', $this->_contactId);
        $controller_data->setEmbedded(TRUE);
        $controller_data->run();
        // have to put all forms in one form

//        $controller_device = new CRM_Core_Controller_Simple(
//            'CRM_Healthmonitor_Form_DeviceFilter',
//            ts('Health Monitor Device Filter'),
//            NULL,
//            FALSE, FALSE, TRUE
//        );
//        $controller_device->set('contactId', $this->_contactId);
//        $controller_device->setEmbedded(TRUE);
//        $controller_device->run();
//
//        $controller_chart = new CRM_Core_Controller_Simple(
//            'CRM_Healthmonitor_Form_ChartFilter',
//            ts('Health Monitor Chart Filter'),
//            NULL,
//            FALSE, FALSE, TRUE
//        );
//        $controller_chart->set('contactId', $this->_contactId);
//        $controller_chart->setEmbedded(TRUE);
//        $controller_chart->run();
//        $this->ajaxResponse['tabCount'] = CRM_Contact_BAO_Contact::getCountComponent('healthmonitor', $this->_contactId);
    }

    public function run()
    {
    //  common variables and js

        CRM_Utils_System::setTitle(E::ts('HM Data Entries'));
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
        $this->assign('contactId', $contactId);

        // datatables style and js (for export etc)

//        Civi::resources()->addStyleUrl('https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-html5-1.7.1/b-print-1.7.1/r-2.2.9/datatables.min.css', -1, "page-header");
//
//        Civi::resources()->addScriptUrl('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js', -1, "page-header");
//        Civi::resources()->addScriptUrl('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js', -1, "page-header");
//        Civi::resources()->addScriptUrl('https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.25/b-1.7.1/b-html5-1.7.1/b-print-1.7.1/r-2.2.9/datatables.min.js', [
//            'weight' => -1,
//            'region' => 'html-header'
//        ]);

        // data datatable js and variables
        Civi::resources()->addScriptFile('com.octopus8.healthmonitor', 'js/data.js', 2);
        $this->assign('useAjax', true);
        $urlQry['snippet'] = 4;
        $urlQry['cid'] = $contactId;
        $this->assign('sourceUrl', CRM_Utils_System::url('civicrm/healthmonitor/ajax', $urlQry, FALSE, NULL, FALSE));
        $datas = \Civi\Api4\HealthMonitor::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();
        $this->assign('dataCount', $datas->rowCount);
        $sourceUrl = [];
        $data_sourceUrl = CRM_Utils_System::url('civicrm/healthmonitor/data_ajax', $urlQry, FALSE, NULL, FALSE);
        $sourceUrl['data_sourceUrl'] = $data_sourceUrl;
        $this->assign('data_sourceUrl', $data_sourceUrl);

        // devices datatable js and variables
        Civi::resources()->addScriptFile('com.octopus8.healthmonitor', 'js/devices.js', 2);
        $devices = \Civi\Api4\Device::get()
            ->selectRowCount()
            ->addWhere('contact_id', '=', $contactId)
            ->execute();
        $this->assign('deviceCount', $devices->rowCount);
        $device_sourceUrl = CRM_Utils_System::url('civicrm/healthmonitor/device_ajax', $urlQry, FALSE, NULL, FALSE);
        $sourceUrl['device_sourceUrl'] = $device_sourceUrl;
        $this->assign('device_sourceUrl', $device_sourceUrl);


        CRM_Core_Resources::singleton()->addVars('sourceUrl', $sourceUrl);

        // chart js and variables
        Civi::resources()->addScriptFile('com.octopus8.healthmonitor', 'js/Chart.bundle.min.js', 1);
        Civi::resources()->addScriptFile('com.octopus8.healthmonitor', 'js/chart.js', 2);
        $ajaxUrl = [];
        $ajaxUrl[] = CRM_Utils_System::url('civicrm/healthmonitor/chart_ajax');
        $ajaxUrl[] = $contactId;
        CRM_Core_Resources::singleton()->addVars('ajax_url', $ajaxUrl);



//        CRM_Core_Error::debug_var('tabrows', $healthMonitors->rowCount);



//        $this->assign('alert_sourceUrl', CRM_Utils_System::url('civicrm/healthmonitor/alert_ajax', $urlQry, FALSE, NULL, FALSE));

//        CRM_Core_Error::debug_var('tabrows', $rows);

        // Set the user context
        $session = CRM_Core_Session::singleton();
        $userContext = CRM_Utils_System::url('civicrm/contact/view', 'cid=' . $contactId . '&selectedChild=contact_health_monitor&reset=1');
        $session->pushUserContext($userContext);
        $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this);

        // run controllers for tabs
        $this->browse();
//        $this->makeTable();
        parent::run();
    }

}
