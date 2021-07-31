<?php

use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Healthmonitor_Form_Search extends CRM_Core_Form {

    protected $formValues;

    protected $pageId = false;

    protected $offset = 0;

    protected $limit = false;

    public $count = 0;

    public $rows = [];


    public function preProcess() {
        parent::preProcess();


        $this->formValues = $this->getSubmitValues();
        $this->setTitle(E::ts('Search Health Monitoring'));

        $this->limit = CRM_Utils_Request::retrieveValue('crmRowCount', 'Positive', 50);
        $this->pageId = CRM_Utils_Request::retrieveValue('crmPID', 'Positive', 1);
        if ($this->limit !== false) {
            $this->offset = ($this->pageId - 1) * $this->limit;
        }
        $this->query();
        $this->assign('entities', $this->rows);

        $pagerParams = [];
        $pagerParams['total'] = 0;
        $pagerParams['status'] =E::ts('%%StatusMessage%%');
        $pagerParams['csvString'] = NULL;
        $pagerParams['rowCount'] =  50;
        $pagerParams['buttonTop'] = 'PagerTopButton';
        $pagerParams['buttonBottom'] = 'PagerBottomButton';
        $pagerParams['total'] = $this->count;
        $pagerParams['pageID'] = $this->pageId;
        $this->pager = new CRM_Utils_Pager($pagerParams);
        $this->assign('pager', $this->pager);
    }


    public function buildQuickForm() {
        parent::buildQuickForm();

        $this->add('text', 'device_id', E::ts('Device ID'), array('class' => 'huge'));
        $this->addEntityRef('contact_id', E::ts('Contact'), ['create' => false, 'multiple' => true], false, array('class' => 'huge'));

        $this->addButtons(array(
            array(
                'type' => 'refresh',
                'name' => E::ts('Search'),
                'isDefault' => TRUE,
            ),
        ));
    }

    public function postProcess() {
        parent::postProcess();
    }

    /**
     * Runs the query
     *
     * @throws \CRM_Core_Exception
     */
    protected function query() {
        $sql = "
    SELECT SQL_CALC_FOUND_ROWS
      `civicrm_health_monitor`.`id`,
      `civicrm_health_monitor`.`device_id`,
      `civicrm_health_monitor`.`device_type_id`,
      `civicrm_health_monitor`.`device_id`,
      `civicrm_health_monitor`.`contact_id`,
      `civicrm_health_monitor`.`sensor_id`,
      `civicrm_health_monitor`.`date`,
      `civicrm_health_monitor`.`sensor_value`
    FROM `civicrm_health_monitor`
    WHERE 1";
        if (isset($this->formValues['device_id']) && !empty($this->formValues['device_id'])) {
            $sql .= " AND `civicrm_health_monitor`.`device_id` LIKE '%".$this->formValues['device_id']."%'";
        }
        if (isset($this->formValues['contact_id']) && is_array($this->formValues['contact_id']) && count($this->formValues['contact_id'])) {
            $sql  .= " AND `civicrm_health_monitor`.`contact_id` IN (".implode(", ", $this->formValues['contact_id']).")";
        }

        if ($this->limit !== false) {
            $sql .= " LIMIT {$this->offset}, {$this->limit}";
        }
        $dao = CRM_Core_DAO::executeQuery($sql);
        $this->count = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $this->rows = array();
        while($dao->fetch()) {
            $row = [
                'id' => $dao->id,
//                'device_type_id' => $dao->device_type_id,

                'contact_id' => $dao->contact_id,
                'device_id' => $dao->device_id,
//                'sensor_id' => $dao->sensor_id,
                'date' => $dao->date,
                'sensor_value' => $dao->sensor_value,
            ];
                $row['device_type_id'] = CRM_Core_OptionGroup::getLabel('health_monitor_device_type', $dao->device_type_id);
                $row['sensor_id'] = CRM_Core_OptionGroup::getLabel('health_monitor_sensor', $dao->sensor_id);
            if (!empty($row['contact_id'])) {
                $row['contact'] = '<a href="'.CRM_Utils_System::url('civicrm/contact/view',
                        ['reset' => 1, 'cid' => $dao->contact_id]).'">'.
                    CRM_Contact_BAO_Contact::displayName($dao->contact_id).'</a>';
            }
            $this->rows[] = $row;

        }
//        CRM_Core_Error::debug_var('tabrows', $this->rows);

    }
}