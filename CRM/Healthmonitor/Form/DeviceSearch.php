<?php

use CRM_Healthmonitor_ExtensionUtil as E;


/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Healthmonitor_Form_DeviceSearch extends CRM_Core_Form
{
    protected $formValues;

    protected $pageId = false;

    protected $offset = 0;

    protected $limit = false;

    public $count = 0;

    public $rows = [];


    public function preProcess()
    {
        $this->formValues = $this->getSubmitValues();
//        CRM_Core_Error::debug_var('formvalues1', $this->formValues);

        parent::preProcess();


        $this->formValues = $this->getSubmitValues();
//        CRM_Core_Error::debug_var('formvalues2', $this->formValues);
        $this->setTitle(E::ts('Search Devices'));

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

        $this->add('text', 'device_name', E::ts('Device Unique Code'), array('class' => 'huge'));
        $this->addEntityRef('contact_id',
            E::ts('Contact'),
            ['create' => false, 'multiple' => true],
            false, array('class' => 'huge'));
        $types = CRM_Core_OptionGroup::values('health_monitor_device_type');
        $this->add('select', 'device_type_id',
            E::ts('Device Type'),
            $types,
            FALSE, ['class' => 'huge crm-select2',
                'data-option-edit-path' => 'civicrm/admin/options/health_monitor_device_type', 'placeholder' => ts('- Select Device Type -'),
                'select' => ['minimumInputLength' => 0]]);


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


    public function getAjax()
    {

//        CRM_Core_Error::debug_var('device_request', $_REQUEST);
//        CRM_Core_Error::debug_var('device_post', $_POST);

        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive');
//        CRM_Core_Error::debug_var('contact', $contactId);


        $offset = CRM_Utils_Request::retrieveValue('iDisplayStart', 'Positive', 0);
//        CRM_Core_Error::debug_var('offset', $offset);

        $limit = CRM_Utils_Request::retrieveValue('iDisplayLength', 'Positive', 10);
//        CRM_Core_Error::debug_var('limit', $limit);

        $device_type_id = CRM_Utils_Request::retrieveValue('device_type_id', 'Positive', null);
//        CRM_Core_Error::debug_var('device_type_id', $device_type_id);


        $sortMapper = [
            0 => 'id',
            1 => 'name',
            2 => 'device_type',
        ];

        $sort = isset($_REQUEST['iSortCol_0']) ? CRM_Utils_Array::value(CRM_Utils_Type::escape($_REQUEST['iSortCol_0'], 'Integer'), $sortMapper) : NULL;
        $sortOrder = isset($_REQUEST['sSortDir_0']) ? CRM_Utils_Type::escape($_REQUEST['sSortDir_0'], 'String') : 'asc';


//        $searchParams = self::getSearchOptionsFromRequest();
        $queryParams = [];

        $join = '';
        $where = [];

//        $isOrQuery = self::isOrQuery();

        $nextParamKey = 3;
        $sql = "
    SELECT SQL_CALC_FOUND_ROWS
      t.id,
      t.name,
      dt.label device_type
    FROM civicrm_device t 
    INNER JOIN civicrm_option_value dt on t.device_type_id = dt.weight
    INNER JOIN civicrm_option_group gdt on dt.option_group_id = gdt.id and gdt.name = 'health_monitor_device_type'    
    WHERE 1";

        if (isset($contactId)) {
            $sql .= " AND t.`contact_id` = " . $contactId . " ";
        }

        if (isset($device_type_id)) {
            if ($device_type_id > 0) {
                $sql .= " AND t.`device_type_id` = " . $device_type_id . " ";
            }
        }


        if ($sort !== NULL) {
            $sql .= " ORDER BY {$sort} {$sortOrder}";
        }

        if ($limit !== false) {
            if ($limit !== NULL) {
                if ($offset !== false) {
                    if ($offset !== NULL) {
                        $sql .= " LIMIT {$offset}, {$limit}";
                    }
                }
            }
        }


//        CRM_Core_Error::debug_var('device_sql', $sql);

        $dao = CRM_Core_DAO::executeQuery($sql);
        $iFilteredTotal = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $rows = array();
        $count = 0;
        while ($dao->fetch()) {
            $r_update = CRM_Utils_System::url('civicrm/device/form',
                ['action' => 'update', 'id' => $dao->id]);
            $r_delete = CRM_Utils_System::url('civicrm/device/form',
                ['action' => 'delete', 'id' => $dao->id]);
            $update = '<a class="action-item crm-hover-button" target="_blank" href="' . $r_update . '"><i class="crm-i fa-pencil"></i>&nbsp;Edit</a>';
            $delete = '<a class="action-item crm-hover-button" target="_blank" href="' . $r_delete . '"><i class="crm-i fa-trash"></i>&nbsp;Delete</a>';
            $action = "<span>$update $delete</span>";
            $rows[$count][] = $dao->id;
            $rows[$count][] = $dao->name;
            $rows[$count][] = $dao->device_type;
            $rows[$count][] = $action;
            $count++;
        }

        $searchRows = $rows;
        $iTotal = 0;
        if (is_countable($searchRows)) {
            $iTotal = sizeof($searchRows);
        }
        $hmdatas = [
            'data' => $searchRows,
            'recordsTotal' => $iTotal,
            'recordsFiltered' => $iFilteredTotal,
        ];
        if (!empty($_REQUEST['is_unit_test'])) {
            return $hmdatas;
        }
        CRM_Utils_JSON::output($hmdatas);
    }

    /**
     * Runs the query
     *
     * @throws \CRM_Core_Exception
     */
    protected function query()
    {
//        CRM_Core_Error::debug_var('formvalues', $this->formValues);
// SQL_CALC_FOUND_ROWS
        $sql = "
    SELECT  SQL_CALC_FOUND_ROWS
      t.`id`,
      t.`name`,
      t.`device_type_id`,
      t.`contact_id`
    FROM t
    WHERE 1";
        if (isset($this->formValues['device_name']) && !empty($this->formValues['device_name'])) {
            $sql .= " AND t.`name` LIKE '%" . $this->formValues['device_name'] . "%'";
        }
        if (isset($this->formValues['contact_id']) && !empty($this->formValues['contact_id'])) {
            $sql .= " AND t.`contact_id` IN (" . $this->formValues['contact_id'] . ")";
        }
        if (isset($this->formValues['device_type_id']) && !empty($this->formValues['device_type_id'])) {
            $sql .= " AND t.`device_type_id` = " . $this->formValues['device_type_id'] . " ";
        }

        if ($this->limit !== false) {
            $sql .= " LIMIT {$this->offset}, {$this->limit}";
        }
        $dao = CRM_Core_DAO::executeQuery($sql);
        $this->count = CRM_Core_DAO::singleValueQuery("SELECT FOUND_ROWS()");
        $this->rows = array();
        while ($dao->fetch()) {
            $row = [
                'id' => $dao->id,
                'device_type_id' => $dao->device_type_id,
                'contact_id' => $dao->contact_id,
                'name' => $dao->name
            ];
            $row['device_type'] = CRM_Core_OptionGroup::getLabel('health_monitor_device_type', $dao->device_type_id);
            if (!empty($row['contact_id'])) {
                $row['contact'] = '<a href="' . CRM_Utils_System::url('civicrm/contact/view',
                        ['reset' => 1, 'cid' => $dao->contact_id]) . '">' .
                    CRM_Contact_BAO_Contact::displayName($dao->contact_id) . '</a>';
            }
            $this->rows[] = $row;

        }


    }


}
