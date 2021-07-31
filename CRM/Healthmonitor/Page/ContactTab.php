<?php

use CRM_Healthmonitor_ExtensionUtil as E;

class CRM_Healthmonitor_Page_ContactTab extends CRM_Core_Page
{

    public function run()
    {
        // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
        CRM_Utils_System::setTitle(E::ts('Health Monitor'));
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);
        $healthMonitors = \Civi\Api4\HealthMonitor::get()
//            ->selectRowCount()
            // caused error - no rows returned
            ->addWhere('contact_id', '=', $contactId)
            ->execute();
        $rows = array();
        foreach ($healthMonitors as $healthMonitor) {
            $row = $healthMonitor;
            if (!empty($row['contact_id'])) {
                $row['contact'] = '<a href="' . CRM_Utils_System::url('civicrm/contact/view', ['reset' => 1, 'cid' => $row['contact_id']]) . '">' . CRM_Contact_BAO_Contact::displayName($row['contact_id']) . '</a>';

            }
            $rows[] = $row;
        }
        $this->assign('contactId', $contactId);
        $this->assign('rows', $rows);
//        CRM_Core_Error::debug_var('tabrows', $rows);

        // Set the user context
        $session = CRM_Core_Session::singleton();
        $userContext = CRM_Utils_System::url('civicrm/contact/view', 'cid=' . $contactId . '&selectedChild=contact_health_monitor&reset=1');
        $session->pushUserContext($userContext);

        parent::run();
    }

}
