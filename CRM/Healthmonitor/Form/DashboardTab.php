<?php

use CRM_Healthmonitor_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Healthmonitor_Form_DashboardTab extends CRM_Core_Form {

    protected $formValues;

    protected $contact_id;

    protected $pageId = false;

    protected $offset = 0;

    protected $limit = false;

    public $count = 0;

    public $rows = [];


    public function preProcess()
    {
        parent::preProcess();

        $this->contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE);

        $this->formValues = $this->getSubmitValues();
        $this->setTitle(E::ts('Search Device Data'));

        $this->limit = CRM_Utils_Request::retrieveValue('crmRowCount', 'Positive', 50);
        $this->pageId = CRM_Utils_Request::retrieveValue('crmPID', 'Positive', 1);
        if ($this->limit !== false) {
            $this->offset = ($this->pageId - 1) * $this->limit;
        }
        $this->query();
        $this->assign('entities', $this->rows);

        $pagerParams = [];
        $pagerParams['total'] = 0;
        $pagerParams['status'] = E::ts('%%StatusMessage%%');
        $pagerParams['csvString'] = NULL;
        $pagerParams['rowCount'] = 50;
        $pagerParams['buttonTop'] = 'PagerTopButton';
        $pagerParams['buttonBottom'] = 'PagerBottomButton';
        $pagerParams['total'] = $this->count;
        $pagerParams['pageID'] = $this->pageId;
        $this->pager = new CRM_Utils_Pager($pagerParams);
        $this->assign('pager', $this->pager);
    }


    public function buildQuickForm()
    {
        parent::buildQuickForm();

        $types = CRM_Core_OptionGroup::values('health_monitor_device_type');
        $this->add('select', 'device_type_id',
            E::ts('Device Type'),
            $types,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type','placeholder' => ts('- Select Device Type -'),
                'select' => ['minimumInputLength' => 0]]);
        $sensors = CRM_Core_OptionGroup::values('health_monitor_sensor');
        $this->add('select', 'sensor_id',
            E::ts('Sensor'),
            $sensors,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_sensor','placeholder' => ts('- Select Sensor -'),
                'select' => ['minimumInputLength' => 0]]);
        $this->addEntityRef('device_id', E::ts('Device'), [
            'entity' => 'device',
            'placeholder' => ts('- Select Device -'),
            'select' => ['minimumInputLength' => 0],
        ], false);

        $this->addDateRange('dateselect', '_from', '_to', 'From:', 'yyyy-mm-dd');

        $this->addButtons(array(
            array(
                'type' => 'refresh',
                'name' => E::ts('Search'),
                'isDefault' => TRUE,
            ),
        ));
    }

    public function postProcess()
    {
        parent::postProcess();
    }

    /**
     * Runs the query
     *
     * @throws \CRM_Core_Exception
     */
    protected function query()
    {
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
//        CRM_Core_Error::debug_var('formValues', $this->formValues);

        if (isset($this->formValues['device_type_id']) && !empty($this->formValues['device_type_id'])) {
            $sql .= " AND `civicrm_health_monitor`.`device_type_id` =" . $this->formValues['device_type_id'] . " ";
        }

        if (isset($this->formValues['sensor_id']) && !empty($this->formValues['sensor_id'])) {
            $sql .= " AND `civicrm_health_monitor`.`sensor_id` = " . $this->formValues['sensor_id'] . " ";
        }

        if (isset($this->contact_id)) {
            $sql .= " AND `civicrm_health_monitor`.`contact_id` = " . $this->contact_id . " ";
        }

        if (isset($this->formValues['dateselect_from']) && !empty($this->formValues['dateselect_from'])) {
            $sql .= " AND `civicrm_health_monitor`.`date` >= '" . $this->formValues['dateselect_from'] . "'";
        }

        if (isset($this->formValues['dateselect_to']) && !empty($this->formValues['dateselect_to'])) {
            $sql .= " AND `civicrm_health_monitor`.`date` <= '" . $this->formValues['dateselect_to'] . "'";
        }

        if ($this->limit !== false) {
            $sql .= " LIMIT {$this->offset}, {$this->limit}";
        }

//        CRM_Core_Error::debug_var('sql', $sql);

        $dao = CRM_Core_DAO::executeQuery($sql);
        $this->count = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $this->rows = array();
        while ($dao->fetch()) {
            $row = [
                'id' => $dao->id,
//                'device_type_id' => $dao->device_type_id,

                'device_id' => $dao->device_id,
//                'sensor_id' => $dao->sensor_id,
                'date' => $dao->date,
                'sensor_value' => $dao->sensor_value,
            ];
            $row['device_type_id'] = CRM_Core_OptionGroup::getLabel('health_monitor_device_type', $dao->device_type_id);
            $row['sensor_id'] = CRM_Core_OptionGroup::getLabel('health_monitor_sensor', $dao->sensor_id);
            if (!empty($row['device_id'])) {
                $row['device'] = '<a  class="edit-device" href="' . CRM_Utils_System::url('civicrm/devices/form',
                        ['reset' => 1, 'id' => $dao->device_id]) . '">' .
                    CRM_Healthmonitor_DAO_Device::getFieldValue('CRM_Healthmonitor_DAO_Device', $dao->device_id) . '</a>';
            }
            $this->rows[] = $row;

        }
//        CRM_Core_Error::debug_var('tabrows', $this->rows);

    }
}