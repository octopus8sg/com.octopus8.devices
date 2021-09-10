<?php

use CRM_Healthmonitor_ExtensionUtil as E;

class CRM_Healthmonitor_Page_Tab extends CRM_Core_Page
{
    public function browse()
    {
        $this->assign('admin', FALSE);
        $this->assign('context', 'devices');

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
//        CRM_Utils_System::setTitle(E::ts('Tab'));

        // Example: Assign a variable for use in a template
        $this->assign('currentTime', date('Y-m-d H:i:s'));
        $context = CRM_Utils_Request::retrieve('context', 'Alphanumeric', $this);
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this);
        $action = CRM_Utils_Request::retrieve('action', 'String', $this);
        $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this);
        $this->browse();
        // Do check for view/edit operation.
//        if ($this->_id &&
//            in_array($action, [CRM_Core_Action::UPDATE, CRM_Core_Action::VIEW])
//        ) {
//            if (!CRM_Activity_BAO_Activity::checkPermission($this->_id, $action)) {
//                CRM_Core_Error::statusBounce(ts('You are not authorized to access this page.'));
//            }
//        }
//
//        if ($context == 'standalone' || (!$contactId && ($action != CRM_Core_Action::DELETE) && !$this->_id)) {
//            $this->_action = CRM_Core_Action::ADD;
//            $this->assign('action', $this->_action);
//        }
//        else {
//            // we should call contact view, preprocess only for activity in contact summary
//            $this->preProcess();
//        }
//
//        // route behaviour of contact/view/activity based on action defined
//        if ($this->_action & (CRM_Core_Action::UPDATE | CRM_Core_Action::ADD | CRM_Core_Action::VIEW)
//        ) {
////            $this->edit();
//            $this->browse();
//            $activityTypeId = CRM_Utils_Request::retrieve('atype', 'Positive', $this);
//
//            // Email and Create Letter activities use a different form class
//            $emailTypeValue = CRM_Core_PseudoConstant::getKey('CRM_Activity_BAO_Activity',
//                'activity_type_id',
//                'Email'
//            );
//
//            $letterTypeValue = CRM_Core_PseudoConstant::getKey('CRM_Activity_BAO_Activity',
//                'activity_type_id',
//                'Print PDF Letter'
//            );
//
//            if (in_array($activityTypeId, [
//                $emailTypeValue,
//                $letterTypeValue,
//            ])) {
//                return;
//            }
//        }
//        elseif ($this->_action & (CRM_Core_Action::DELETE | CRM_Core_Action::DETACH)) {
////            $this->delete();
//            $this->browse();
//        }
//        else {
        $this->browse();
//        }
        parent::run();
    }

}
