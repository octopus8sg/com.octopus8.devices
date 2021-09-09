<?php
/*
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC. All rights reserved.                        |
 |                                                                    |
 | This work is published under the GNU AGPLv3 license with some      |
 | permitted exceptions and without any warranty. For full license    |
 | and copyright information, see https://civicrm.org/licensing       |
 +--------------------------------------------------------------------+
 */

/**
 *
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 */
class CRM_Healthmonitor_Form_Report_ContactDeviceDetail extends CRM_Report_Form
{

    protected $_summary = NULL;

    protected $_customGroupExtends = [
        'Contact',
        'Individual',
        'Household',
        'Organization',
    ];

    /**
     * This report has not been optimised for group filtering.
     *
     * The functionality for group filtering has been improved but not
     * all reports have been adjusted to take care of it. This report has not
     * and will run an inefficient query until fixed.
     *
     * @var bool
     * @see https://issues.civicrm.org/jira/browse/CRM-19170
     */
    protected $groupFilterNotOptimised = TRUE;

    /**
     * Store the joins for civicrm_activity_contact
     *
     * Activities are retrieved by a union of four queries in order to catch
     * activities where the contact is the source, target, assignee, or case
     * contact.
     *
     * @var array
     */
    protected $activityContactJoin = [];

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->_autoIncludeIndexedFieldsAsOrderBys = 1;
        $this->_columns = [
            'civicrm_contact' => [
                'dao' => 'CRM_Contact_DAO_Contact',
                'fields' => [
                    'sort_name' => [
                        'title' => ts('Contact Name'),
                        'required' => TRUE,
                        'no_repeat' => TRUE,
                    ],
                    'first_name' => [
                        'title' => ts('First Name'),
                    ],
                    'middle_name' => [
                        'title' => ts('Middle Name'),
                    ],
                    'last_name' => [
                        'title' => ts('Last Name'),
                    ],
                    'id' => [
                        'no_display' => TRUE,
                        'required' => TRUE,
                    ],
                    'gender_id' => [
                        'title' => ts('Gender'),
                    ],
                    'birth_date' => [
                        'title' => ts('Birth Date'),
                    ],
                    'age' => [
                        'title' => ts('Age'),
                        'dbAlias' => 'TIMESTAMPDIFF(YEAR, contact_civireport.birth_date, CURDATE())',
                    ],
                    'contact_type' => [
                        'title' => ts('Contact Type'),
                    ],
                    'contact_sub_type' => [
                        'title' => ts('Contact Subtype'),
                    ],
                ],
                'filters' => $this->getBasicContactFilters(),
                'grouping' => 'contact-fields',
                'order_bys' => [
                    'sort_name' => [
                        'title' => ts('Last Name, First Name'),
                        'default' => '1',
                        'default_weight' => '0',
                        'default_order' => 'ASC',
                    ],
                    'first_name' => [
                        'title' => ts('First Name'),
                    ],
                    'gender_id' => [
                        'name' => 'gender_id',
                        'title' => ts('Gender'),
                    ],
                    'birth_date' => [
                        'name' => 'birth_date',
                        'title' => ts('Birth Date'),
                    ],
                    'contact_type' => [
                        'title' => ts('Contact Type'),
                    ],
                    'contact_sub_type' => [
                        'title' => ts('Contact Subtype'),
                    ],
                ],
            ],
            'civicrm_device' => [
                'dao' => 'CRM_Healthmonitor_DAO_Device',
                'fields' => [
                    'contact_id' => [
                        'no_display' => TRUE,
                        'required' => TRUE,
                    ],
//                    'device_id' => [
//                        'name' => 'id',
//                        'default' => TRUE,
//                        'no_display' => TRUE,
//                    ],
                    'name' => [
                        'title' => ts('Device Code'),
                        'default' => TRUE,
                    ],
                    'device_type_id' => [
                        'title' => ts('Device Type'),
                        'default' => TRUE,
                    ],
                ],
                'filters' => [
//                    'device_type_id' => [
//                        'title' => ts('Device Type'),
//                        'type' => CRM_Utils_Type::T_STRING,
//                        'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//                        'options' => CRM_Core_PseudoConstant::get("CRM_Healthmonitor_BAO_Device", "device_type_id"),
//                    ],
                ],
                'grouping' => 'device-fields',
            ],
            'civicrm_health_alarm_rule' => [
                'dao' => 'CRM_Healthmonitor_DAO_HealthAlarmRule',
                'title' => ts('Alarm Rules'),
                'fields' => [
                    'contact_id' => [
                        'no_display' => TRUE,
                        'required' => TRUE,
                    ],
//                    'alarm_rule_id' => [
//                        'name' => 'id',
//                        'no_display' => TRUE,
//                        'required' => TRUE,
//                    ],
                    'alarm_rule_code' => [
                        'name' => 'code',
                        'title' => ts('Alarm Rule Code'),
                        'default' => TRUE,
                    ],
                    'alarm_rule_rule_id' => [
                        'name' => 'rule_id',
                        'title' => ts('Alarm Rule'),
                        'default' => TRUE,
                    ],
                    'alarm_rule_sensor_id' => [
                        'name' => 'sensor_id',
                        'title' => ts('Sensor'),
                        'default' => TRUE,
                    ],
                    'alarm_rule_sensor_value' => [
                        'name' => 'sensor_value',
                        'title' => ts('Alarm Rule Value'),
                        'default' => TRUE,
                    ],
                ],
                'filters' => [
//                    'alarm_rule_sensor_id' => [
//                        'name' => 'sensor_id',
//                        'title' => ts('Alarm Rule Sensor'),
//                        'type' => CRM_Utils_Type::T_STRING,
//                        'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//                        'options' => CRM_Core_PseudoConstant::get("CRM_Healthmonitor_BAO_HealthAlarmRule", "sensor_id"),
//                    ],
//                        $sensor_name = CRM_Core_PseudoConstant::getLabel("CRM_Healthmonitor_BAO_HealthAlarmRule", "sensor_id");
                ],
                'grouping' => 'device-fields',
            ],
            'civicrm_health_alert_rule' => [
                'dao' => 'CRM_Healthmonitor_DAO_HealthAlertRule',
                'fields' => [
                        'contact_id' => [
                            'no_display' => TRUE,
                            'required' => TRUE,
                        ],
//                        'alert_rule_id' => [
//                            'name' => 'id',
//                            'no_display' => TRUE,
//                            'required' => TRUE,
//                        ],
                        'alert_rule_code' => [
                            'name' => 'code',
                            'title' => ts('Alert Rule Name'),
                            'default' => TRUE,
                        ],
                        'alert_rule_title' => [
                            'name' => 'title',
                            'title' => ts('Alert Rule'),
                            'default' => TRUE,
                        ],
                        'alert_rule_addressee_id' => [
                            'name' => 'addressee_id',
                            'title' => ts('Alert Contact'),
                            'default' => TRUE,
                        ],
                        'alert_rule_rule_id' => [
                            'name' => 'rule_id',
                            'title' => ts('Alarm Rule'),
                            'default' => TRUE,
                        ],
                        'alert_rule_civicrm' => [
                            'name' => 'civicrm',
                            'title' => ts('Civicrm Note'),
                            'default' => TRUE,
                        ],
                        'alert_rule_email' => [
                            'name' => 'email',
                            'title' => ts('Email'),
                            'default' => TRUE,
                        ],
                ],
                'filters' => [
                ],
                'grouping' => 'device-fields',
            ],
            'civicrm_phone' => [
                'dao' => 'CRM_Core_DAO_Phone',
                'fields' => [
                    'phone' => NULL,
                    'phone_ext' => [
                        'title' => ts('Phone Extension'),
                    ],
                ],
                'grouping' => 'contact-fields',
            ],
        ];
        $this->_groupFilter = TRUE;
        $this->_tagFilter = TRUE;
        parent::__construct();
        $this->setRowCount(10);
    }

    public function preProcess()
    {
        $this->_csvSupported = TRUE;
        parent::preProcess();
    }

    public function select()
    {
        $select = [];
        $this->_columnHeaders = [];
        $this->_component = [
            $this->_aliases['civicrm_device'],
            $this->_aliases['civicrm_health_alarm_rule'],
            $this->_aliases['civicrm_health_alert_rule'],
        ];
        foreach ($this->_columns as $tableName => $table) {
            CRM_Core_Error::debug_var('tablename', $tableName);
            CRM_Core_Error::debug_var('table', $table);
            if (array_key_exists('fields', $table)) {
                foreach ($table['fields'] as $fieldName => $field) {
                    if (!empty($field['required']) ||
                        !empty($this->_params['fields'][$fieldName])
                    ) {
                        //isolate the select clause component wise
                        if (in_array($table['alias'], $this->_component)) {
                            $select[$table['alias']][] = "{$field['dbAlias']} as {$tableName}_{$fieldName}";
                            $this->_columnHeadersComponent[$table['alias']]["{$tableName}_{$fieldName}"]['type'] = $field['type'] ?? NULL;
                            $this->_columnHeadersComponent[$table['alias']]["{$tableName}_{$fieldName}"]['title'] = $field['title'] ?? NULL;
                        }
                        else {
                            $select[] = "{$field['dbAlias']} as {$tableName}_{$fieldName}";
                            $this->_columnHeaders["{$tableName}_{$fieldName}"]['type'] = $field['type'] ?? NULL;
                            $this->_columnHeaders["{$tableName}_{$fieldName}"]['title'] = $field['title'];
                        }
                    }
                }
            }
        }

        foreach ($this->_component as $val) {
            if (!empty($select[$val])) {
                $this->_selectComponent[$val] = "SELECT " . implode(', ', $select[$val]) . " ";
                unset($select[$val]);
            }
        }

        $this->_select = "SELECT " . implode(', ', $select) . " ";
    }

    /**
     * @param $fields
     * @param $files
     * @param $self
     *
     * @return array
     */
    public static function formRule($fields, $files, $self)
    {
        $errors = [];
        return $errors;
    }

    public function from()
    {


        $civicrm_contact = $this->_aliases['civicrm_contact'];
        $civicrm_device = $this->_aliases['civicrm_device'];
        $civicrm_health_alarm_rule = $this->_aliases['civicrm_health_alarm_rule'];
        $civicrm_health_alert_rule = $this->_aliases['civicrm_health_alert_rule'];
        // only include tables that are in from clause
        $componentTables = array_intersect($this->_aliases, $this->_component);
        $componentTables = array_flip($componentTables);
        $this->_selectedTables = array_diff($this->_selectedTables, $componentTables);
        $this->_from = "
      FROM civicrm_contact {$this->_aliases['civicrm_contact']} {$this->_aclFrom}
          ";
        // SELECT ONLY CONTACT WITH DEVICES

        if (!empty($this->_selectComponent[$civicrm_device])) {
            $this->_formComponent[$civicrm_device] = <<<HERESQL
        FROM
        civicrm_contact {$civicrm_contact}
        INNER JOIN civicrm_device {$civicrm_device}
          ON {$civicrm_contact}.id = {$civicrm_device}.contact_id
HERESQL;
        }
        if (!empty($this->_selectComponent[$civicrm_health_alarm_rule])) {
            $this->_formComponent[$civicrm_health_alarm_rule] = <<<HERESQL
        FROM
        civicrm_contact {$civicrm_contact}
        INNER JOIN civicrm_health_alarm_rule {$civicrm_health_alarm_rule}
          ON {$civicrm_contact}.id = {$civicrm_health_alarm_rule}.contact_id
HERESQL;
        }
        if (!empty($this->_selectComponent[$civicrm_health_alert_rule])) {
            $this->_formComponent[$civicrm_health_alert_rule] = <<<HERESQL
        FROM
        civicrm_contact {$civicrm_contact}
        INNER JOIN civicrm_health_alert_rule {$civicrm_health_alert_rule}
          ON {$civicrm_contact}.id = {$civicrm_health_alert_rule}.contact_id
HERESQL;
        }
//        CRM_Core_Error::debug_var('_from', $this->_from);
//        CRM_Core_Error::debug_var('_selectComponent', $this->_selectComponent);
//        CRM_Core_Error::debug_var('_formComponent', $this->_formComponent);
    }

    public function where()
    {
        $clauses = [];

        foreach ($this->_columns as $tableName => $table) {
            if (array_key_exists('filters', $table)) {
                foreach ($table['filters'] as $fieldName => $field) {
                    $clause = NULL;
                    if (CRM_Utils_Array::value('operatorType', $field) & CRM_Report_Form::OP_DATE
                    ) {
                        $relative = $this->_params["{$fieldName}_relative"] ?? NULL;
                        $from = $this->_params["{$fieldName}_from"] ?? NULL;
                        $to = $this->_params["{$fieldName}_to"] ?? NULL;

                        $clause = $this->dateClause($field['dbAlias'], $relative, $from, $to);
                    } else {
                        $op = $this->_params["{$fieldName}_op"] ?? NULL;
                        $clause = $this->whereClause($field,
                            $op,
                            CRM_Utils_Array::value("{$fieldName}_value", $this->_params),
                            CRM_Utils_Array::value("{$fieldName}_min", $this->_params),
                            CRM_Utils_Array::value("{$fieldName}_max", $this->_params)
                        );
                    }
                    if (!empty($clause)) {
                        $clauses[] = $clause;
                    }
                }
            }
        }
        $civicrm_contact = $this->_aliases['civicrm_contact'];
        $civicrm_device = 'civicrm_device';

        if (empty($clauses)) {
            $this->_where = "
            WHERE {$civicrm_contact}.id IN (SELECT {$civicrm_device}.contact_id from {$civicrm_device})";
        } else {
            $this->_where = "WHERE " . implode(' AND ', $clauses) . "
            AND {$civicrm_contact}.id IN (SELECT {$civicrm_device}.contact_id from {$civicrm_device})";
        }

        if ($this->_aclWhere) {
            $this->_where .= " AND {$this->_aclWhere} ";
        }
//        CRM_Core_Error::debug_var('where', $this->_where);
    }

    /**
     * @return array
     */
    public function clauseComponent()
    {
        $selectedContacts = implode(',', $this->_contactSelected);
        $eligibleResult = $rows = $tempArray = [];
        foreach ($this->_component as $val) {
//            CRM_Core_Error::debug_var('val', $val);
            if (!empty($this->_selectComponent[$val]) &&
                ($val != 'activity_civireport' && $val != 'relationship_civireport')
            ) {
                $sql = <<<HERESQL
        {$this->_selectComponent[$val]} {$this->_formComponent[$val]}
        WHERE {$this->_aliases['civicrm_contact']}.id IN ( $selectedContacts )
HERESQL;
//                CRM_Core_Error::debug_var('exec_sql', $sql);

                $dao = CRM_Core_DAO::executeQuery($sql);
                while ($dao->fetch()) {
                    $countRecord = 0;
                    $eligibleResult[$val] = $val;
                    $CC = 'civicrm_' . substr_replace($val, '', -11, 11) . '_contact_id';
                    $row = [];
                    foreach ($this->_columnHeadersComponent[$val] as $key => $value) {
                        $countRecord++;
                        $row[$key] = $dao->$key;
                    }

                    //if record exist for component(except contact_id)
                    //since contact_id is selected for every component
                    if ($countRecord >= 1) {
                        $rows[$dao->$CC][$val][] = $row;
//                        CRM_Core_Error::debug_var('$row', $row);
                    }
                    $tempArray[$dao->$CC] = $dao->$CC;
                }
            }
        }

        return $rows;
    }

    /**
     * @param $rows
     *
     * @return array
     */
    public function statistics(&$rows)
    {
        $statistics = [];

        $count = count($rows);
        if ($this->_rollup && ($this->_rollup != '')) {
            $count++;
        }

        $this->countStat($statistics, $count);
        $this->filterStat($statistics);

        return $statistics;
    }

    /**
     * Override to set limit is 10
     * @param int|null $rowCount
     */
    public function limit($rowCount = NULL)
    {
        $rowCount = $rowCount ?? $this->getRowCount();
        parent::limit($rowCount);
    }

    /**
     * Override to set pager with limit is 10
     * @param int|null $rowCount
     */
    public function setPager($rowCount = NULL)
    {
        $rowCount = $rowCount ?? $this->getRowCount();
        parent::setPager($rowCount);
    }

    public function postProcess()
    {
        $this->beginPostProcess();
        $sql = $this->buildQuery(TRUE);

        $rows = $this->_contactSelected = [];
        $this->buildRows($sql, $rows);
        foreach ($rows as $key => $val) {
            $rows[$key]['contactID'] = $val['civicrm_contact_id'];
            $this->_contactSelected[] = $val['civicrm_contact_id'];
        }

        $this->formatDisplay($rows);

        if (!empty($this->_contactSelected)) {
            $componentRows = $this->clauseComponent();
            $this->alterComponentDisplay($componentRows);

            //unset Conmponent id and contact id from display
//            CRM_Core_Error::debug_var('_columnHeadersComponent', $this->_columnHeadersComponent);
            foreach ($this->_columnHeadersComponent as $componentTitle => $headers) {
//                CRM_Core_Error::debug_var('componentTitle', $componentTitle);
//                CRM_Core_Error::debug_var('headers', $headers);
                $id_header = 'civicrm_' . substr_replace($componentTitle, '', -11, 11) . '_' .
                    substr_replace($componentTitle, '', -11, 11) . '_id';
                $contact_header = 'civicrm_' . substr_replace($componentTitle, '', -11, 11) .
                    '_contact_id';
                if ($componentTitle == 'activity_civireport') {
                    $id_header = 'civicrm_' . substr_replace($componentTitle, '', -11, 11) . '_id';
                }

                unset($this->_columnHeadersComponent[$componentTitle][$id_header]);
                unset($this->_columnHeadersComponent[$componentTitle][$contact_header]);
            }

            $this->assign_by_ref('columnHeadersComponent', $this->_columnHeadersComponent);
            $this->assign_by_ref('componentRows', $componentRows);
        }

        $this->doTemplateAssignment($rows);
        $this->endPostProcess();
    }

    /**
     * Alter display of rows.
     *
     * Iterate through the rows retrieved via SQL and make changes for display purposes,
     * such as rendering contacts as links.
     *
     * @param array $rows
     *   Rows generated by SQL, with an array for each row.
     */
    public function alterDisplay(&$rows)
    {

        $entryFound = FALSE;

        foreach ($rows as $rowNum => $row) {
            // make count columns point to detail report

            // change contact name with link
            if (array_key_exists('civicrm_contact_sort_name', $row) &&
                array_key_exists('civicrm_contact_id', $row)
            ) {

                $url = CRM_Utils_System::url('civicrm/contact/view',
                    'reset=1&cid=' . $row['civicrm_contact_id'],
                    $this->_absoluteUrl
                );
                $rows[$rowNum]['civicrm_contact_sort_name_link'] = $url;
                $rows[$rowNum]['civicrm_contact_sort_name_hover'] = ts('View Contact Record');
                $entryFound = TRUE;
            }

            // Handle ID to label conversion for contact fields
            $entryFound = $this->alterDisplayContactFields($row, $rows, $rowNum, NULL, NULL) ? TRUE : $entryFound;

            $entryFound = $this->alterDisplayAddressFields($row, $rows, $rowNum, NULL, NULL) ? TRUE : $entryFound;

            // skip looking further in rows, if first row itself doesn't
            // have the column we need
            if (!$entryFound) {
                break;
            }
        }
    }

    /**
     * @param $componentRows
     */
    public function alterComponentDisplay(&$componentRows)
    {
        // custom code to alter rows

        $entryFound = FALSE;
        foreach ($componentRows as $contactID => $components) {
//        CRM_Core_Error::debug_var('components', $components);
            foreach ($components as $component => $rows) {
//                CRM_Core_Error::debug_var('component', $component);
//                CRM_Core_Error::debug_var('row', $rows);
                foreach ($rows as $rowNum => $row) {
//                    CRM_Core_Error::debug_var('rows', $rows);
//                    CRM_Core_Error::debug_var('rowNum', $rowNum);
//                    CRM_Core_Error::debug_var('row', $row);
//        CRM_Core_Error::debug_var('_from', $this->_from);
//                    // handle contribution
//
                    if ($component == 'device_civireport') {

                        if ($val = CRM_Utils_Array::value('civicrm_device_device_type_id', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);
                            $componentRows[$contactID][$component][$rowNum]['civicrm_device_device_type_id'] = CRM_Core_PseudoConstant::getLabel("CRM_Healthmonitor_BAO_Device", "device_type_id", $val);
                        }
                    }

                    if ($component == 'health_alarm_rule_civireport') {

                        if ($val = CRM_Utils_Array::value('civicrm_health_alarm_rule_alarm_rule_rule_id', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);
                            $componentRows[$contactID][$component][$rowNum]['civicrm_health_alarm_rule_alarm_rule_rule_id']
                                = CRM_Core_PseudoConstant::getLabel("CRM_Healthmonitor_BAO_HealthAlarmRule", "rule_id", $val);
                        }
                        if ($val = CRM_Utils_Array::value('civicrm_health_alarm_rule_alarm_rule_sensor_id', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);
                            $componentRows[$contactID][$component][$rowNum]['civicrm_health_alarm_rule_alarm_rule_sensor_id']
                                = CRM_Core_PseudoConstant::getLabel("CRM_Healthmonitor_BAO_HealthAlarmRule", "sensor_id", $val);
                        }
                    }
                    if ($component == 'health_alert_rule_civireport') {

                        if ($val = CRM_Utils_Array::value('civicrm_health_alert_rule_alert_rule_rule_id', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);
                            $rule_sql = "SELECT civicrm_health_alarm_rule.code
                           from civicrm_health_alarm_rule where civicrm_health_alarm_rule.id = {$val}";
                            $rule_code = CRM_Core_DAO::singleValueQuery($rule_sql);
                            $componentRows[$contactID][$component][$rowNum]['civicrm_health_alert_rule_alert_rule_rule_id']
                                = $rule_code;
                        }
                        if ($val = CRM_Utils_Array::value('civicrm_health_alert_rule_alert_rule_addressee_id', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);
                            $addressee = '<a href="' . CRM_Utils_System::url('civicrm/contact/view',
                                    ['reset' => 1, 'cid' => $val]) . '">' .
                                CRM_Contact_BAO_Contact::displayName($val) . '</a>';
                            $componentRows[$contactID][$component][$rowNum]['civicrm_health_alert_rule_alert_rule_addressee_id']
                                = $addressee;
                        }
                        if (boolval(CRM_Utils_Array::value('civicrm_health_alert_rule_alert_rule_civicrm', $row)) === True) {
                            $componentRows[$contactID][$component][$rowNum]['civicrm_health_alert_rule_alert_rule_civicrm']
                                = '+';}else{
                            $componentRows[$contactID][$component][$rowNum]['civicrm_health_alert_rule_alert_rule_civicrm']
                                = '-';
                        }
                        if (boolval(CRM_Utils_Array::value('civicrm_health_alert_rule_alert_rule_email', $row)) === True) {
                            $componentRows[$contactID][$component][$rowNum]['civicrm_health_alert_rule_alert_rule_email']
                                = '+';}else{
                                $componentRows[$contactID][$component][$rowNum]['civicrm_health_alert_rule_alert_rule_email']
                                    = '-';
                            }




                    }

                }
            }
        }
    }

}
