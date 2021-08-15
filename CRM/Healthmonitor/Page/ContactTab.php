<?php

use CRM_Healthmonitor_ExtensionUtil as E;


class CRM_Healthmonitor_Page_ContactTab extends CRM_Core_Page
{

    protected $pageId = false;

    protected $offset = 0;

    protected $limit = false;

    public $count = 0;


    public $rows = [];

//    public function makeTable() {
//        $config = CRM_Core_Config::singleton();
//        $chartType = 'bvg';
//        $selectedYear = date('Y');
//        $p = [];
//        $p['By Month'][1] = 19;
//        $p['By Month'][2] = 19;
//        $p['By Month'][3] = 19;
//        $p['By Month'][4] = 19;
//        $p['By Month'][5] = 19;
//        $p['By Month'][6] = 19;
//        $p['By Month'][7] = 19;
//        $p['By Month'][8] = 19;
//        $p['By Month'][9] = 19;
//        $p['By Month'][10] = 19;
//        $p['By Month'][11] = 19;
//        $p['By Month'][12] = 19;
//
//        $chartInfoMonthly = $p;
//
//        $chartData = $abbrMonthNames = [];
//        if (is_array($chartInfoMonthly)) {
//            for ($i = 1; $i <= 12; $i++) {
//                $abbrMonthNames[$i] = strftime('%b', mktime(0, 0, 0, $i, 10, 1970));
//            }
//
//            foreach ($abbrMonthNames as $monthKey => $monthName) {
//                $val = CRM_Utils_Array::value($monthKey, $chartInfoMonthly['By Month'], 0);
//
//                // don't include zero value month.
//                if (!$val && ($chartType != 'bvg')) {
//                    continue;
//                }
//
//                //build the params for chart.
//                $chartData['by_month']['values'][$monthName] = $val;
//            }
//            $chartData['by_month']['legend'] = 'By Month' . ' - ' . $selectedYear;
//
//            // handle onclick event.
//            $chartData['by_month']['on_click_fun_name'] = 'byMonthOnClick';
//            $chartData['by_month']['yname'] = ts('Contribution');
//        }
//
//        //take contribution information by yearly
////        $chartInfoYearly = CRM_Contribute_BAO_Contribution_Utils::contributionChartYearly();
//        $p = [];
//        $p['By Year'][2001] = 21;
//        $p['By Year'][2002] = 21;
//        $p['By Year'][2003] = 21;
//        $p['By Year'][2004] = 21;
//        $p['By Year'][2005] = 21;
//        $p['By Year'][2006] = 21;
//        $p['By Year'][2007] = 21;
//        $p['By Year'][2008] = 21;
//        $p['By Year'][2009] = 21;
//        $p['By Year'][2010] = 21;
//        $p['By Year'][2011] = 21;
//        $p['By Year'][2012] = 21;
//
//        $chartInfoYearly = $p;
//        //get the years.
//        $this->_years = $chartInfoYearly['By Year'];
//        $hasContributions = FALSE;
//        if (is_array($chartInfoYearly)) {
//            $hasContributions = TRUE;
//            $chartData['by_year']['legend'] = 'By Year';
//            $chartData['by_year']['values'] = $chartInfoYearly['By Year'];
//
//            // handle onclick event.
//            $chartData['by_year']['on_click_fun_name'] = 'byYearOnClick';
//            $chartData['by_year']['yname'] = ts('Total Amount');
//        }
//        $this->assign('hasContributions', $hasContributions);
//
//        // process the data.
//        $chartCnt = 1;
//
//        $monthlyChart = $yearlyChart = FALSE;
//
//        foreach ($chartData as $chartKey => & $values) {
//            $chartValues = $values['values'] ?? NULL;
//
//            if (!is_array($chartValues) || empty($chartValues)) {
//                continue;
//            }
//            if ($chartKey == 'by_year') {
//                $yearlyChart = TRUE;
//                if (!empty($config->fiscalYearStart) && ($config->fiscalYearStart['M'] !== 1 || $config->fiscalYearStart['d'] !== 1)) {
//                    $values['xLabelAngle'] = 45;
//                }
//                else {
//                    $values['xLabelAngle'] = 0;
//                }
//            }
//            if ($chartKey == 'by_month') {
//                $monthlyChart = TRUE;
//            }
//
//            $values['divName'] = "chart_{$chartKey}";
//            $funName = ($chartType == 'bvg') ? 'barChart' : 'pieChart';
//
//            // build the chart objects.
//            $values['object'] = CRM_Utils_Chart::$funName($values);
//
//            //build the urls.
//            $urlCnt = 0;
//            foreach ($chartValues as $index => $val) {
//                $urlParams = NULL;
//                if ($chartKey == 'by_month') {
//                    $monthPosition = array_search($index, $abbrMonthNames);
//                    $startDate = CRM_Utils_Date::format(['Y' => $selectedYear, 'M' => $monthPosition]);
//                    $endDate = date('Ymd', mktime(0, 0, 0, $monthPosition + 1, 0, $selectedYear));
//                    $urlParams = "reset=1&force=1&status=1&start={$startDate}&end={$endDate}&test=0";
//                }
//                elseif ($chartKey == 'by_year') {
//                    if (!empty($config->fiscalYearStart) && ($config->fiscalYearStart['M'] != 1 || $config->fiscalYearStart['d'] != 1)) {
//                        $startDate = date('Ymd', mktime(0, 0, 0, $config->fiscalYearStart['M'], $config->fiscalYearStart['d'], substr($index, 0, 4)));
//                        $endDate = date('Ymd', mktime(0, 0, 0, $config->fiscalYearStart['M'], $config->fiscalYearStart['d'], (substr($index, 0, 4)) + 1));
//                    }
//                    else {
//                        $startDate = CRM_Utils_Date::format(['Y' => substr($index, 0, 4)]);
//                        $endDate = date('Ymd', mktime(0, 0, 0, 13, 0, substr($index, 0, 4)));
//                    }
//                    $urlParams = "reset=1&force=1&status=1&start={$startDate}&end={$endDate}&test=0";
//                }
//                if ($urlParams) {
//                    $values['on_click_urls']["url_" . $urlCnt++] = CRM_Utils_System::url('civicrm/contribute/search',
//                        $urlParams, TRUE, FALSE, FALSE
//                    );
//                }
//            }
//
//            // calculate chart size.
//            $xSize = 400;
//            $ySize = 300;
//            if ($chartType == 'bvg') {
//                $ySize = 250;
//                $xSize = 60 * count($chartValues);
//
//                // reduce x size by 100 for by_month
//                if ($chartKey == 'by_month') {
//                    $xSize -= 100;
//                }
//
//                //hack to show tooltip.
//                if ($xSize < 150) {
//                    $xSize = 150;
//                }
//            }
//            $values['size'] = ['xSize' => $xSize, 'ySize' => $ySize];
//        }
//
//        // finally assign this chart data to template.
//        $this->assign('hasYearlyChart', $yearlyChart);
//        $this->assign('hasByMonthChart', $monthlyChart);
//        $this->assign('hasChart', !empty($chartData));
//        $this->assign('chartData', json_encode($chartData ?? []));
//    }

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
//        Civi::resources()->addScriptUrl('https://cdn.jsdelivr.net/npm/chart.js', -1, 'html-header');
        Civi::resources()->addScriptFile('com.octopus8.healthmonitor', 'js/Chart.bundle.min.js', 1);
        Civi::resources()->addScriptFile('com.octopus8.healthmonitor', 'js/chart.js', 2);
        $ajaxUrl = [];
        $ajaxUrl[] = CRM_Utils_System::url('civicrm/healthmonitor/chart_ajax');


        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('HM Data Entries'));
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
        $this->assign('contactId', $contactId);
        $ajaxUrl[] = $contactId;
        CRM_Core_Resources::singleton()->addVars('ajax_url', $ajaxUrl);
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
//        $this->makeTable();
        parent::run();
    }

}
