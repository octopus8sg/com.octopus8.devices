<?php
use CRM_Healthmonitor_ExtensionUtil as E;

class CRM_Healthmonitor_Page_Templates extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('Templates'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));
    $templates = new CRM_Report_Page_TemplateList();
    $templates->run();
    $instances = new CRM_Report_Page_TemplateList();
    $instances->run();
    parent::run();
  }

}
