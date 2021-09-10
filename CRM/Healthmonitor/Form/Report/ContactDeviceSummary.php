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
class CRM_Healthmonitor_Form_Report_ContactDeviceSummary extends CRM_Report_Form
{

    public $_summary = NULL;

    protected $_emailField = FALSE;

    protected $_phoneField = FALSE;

    protected $_customGroupExtends = array(
        'Contact',
        'Individual',
        'Household',
        'Organization',
    );

    public $_drilldownReport = array('contact/detail' => 'Link to Detail Report');

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
     * Class constructor.
     */
    public function __construct()
    {
        $this->_autoIncludeIndexedFieldsAsOrderBys = 1;
        $this->_columns = array(
                'civicrm_contact' => array(
                    'dao' => 'CRM_Contact_DAO_Contact',
                    'fields' => array_merge(
                        $this->getBasicContactFields(),
                        array(
                            'modified_date' => array(
                                'title' => ts('Modified Date'),
                                'default' => FALSE,
                            ),
                        )
                    ),
                    'filters' => $this->getBasicContactFilters(),
                    'grouping' => 'contact-fields',
                    'order_bys' => array(
                        'sort_name' => array(
                            'title' => ts('Last Name, First Name'),
                            'default' => '1',
                            'default_weight' => '0',
                            'default_order' => 'ASC',
                        ),
                        'first_name' => array(
                            'name' => 'first_name',
                            'title' => ts('First Name'),
                        ),
                        'gender_id' => array(
                            'name' => 'gender_id',
                            'title' => ts('Gender'),
                        ),
                        'birth_date' => array(
                            'name' => 'birth_date',
                            'title' => ts('Birth Date'),
                        ),
                        'contact_type' => array(
                            'title' => ts('Contact Type'),
                        ),
                        'contact_sub_type' => array(
                            'title' => ts('Contact Subtype'),
                        ),
                    ),
                ),
                'civicrm_device' => [
                    'dao' => 'CRM_Healthmonitor_DAO_Device',
                    'fields' => [
                        'device_count' => [
                            'name' => 'id',
                            'title' => ts('Devices'),
                            'default' => TRUE,
//                            'required' => TRUE,
                            'statistics' => TRUE,
                        ],
                    ],
                    'filters' => [
                        'device_type_id' => [
                            'title' => ts('Device Type'),
                            'type' => CRM_Utils_Type::T_STRING,
                            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
                            'options' => CRM_Core_PseudoConstant::get("CRM_Healthmonitor_BAO_Device", "device_type_id"),
                        ],
                    ],
                    'grouping' => 'device-fields',
                ],
                'civicrm_health_monitor' => [
                    'dao' => 'CRM_Healthmonitor_DAO_HealthMonitor',
                    'fields' => [
                        'data_count' => [
                            'name' => 'id',
                            'title' => ts('Device Data'),
                            'default' => TRUE,
//                            'required' => TRUE,
                            'statistics' => TRUE,
                        ],
                    ],
                    'filters' => [
                        'data_sensor_id' => [
                            'name' => 'sensor_id',
                            'title' => ts('Data Sensor'),
                            'type' => CRM_Utils_Type::T_STRING,
                            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
                            'options' => CRM_Core_PseudoConstant::get("CRM_Healthmonitor_BAO_HealthMonitor", "sensor_id"),
                        ],
//                        $sensor_name = CRM_Core_PseudoConstant::getLabel("CRM_Healthmonitor_BAO_HealthAlarmRule", "sensor_id");
                    ],
                    'grouping' => 'device-fields',
                ],
                'civicrm_health_alarm_rule' => [
                    'dao' => 'CRM_Healthmonitor_DAO_HealthAlarmRule',
                    'fields' => [
                        'alarm_rules' => [
                            'name' => 'id',
                            'title' => ts('Alarm Rules'),
                            'default' => TRUE,
//                            'required' => TRUE,
                            'statistics' => TRUE,
                        ],
                    ],
                    'filters' => [
                        'rule_sensor_id' => [
                            'name' => 'sensor_id',
                            'title' => ts('Alarm Rule Sensor'),
                            'type' => CRM_Utils_Type::T_STRING,
                            'operatorType' => CRM_Report_Form::OP_MULTISELECT,
                            'options' => CRM_Core_PseudoConstant::get("CRM_Healthmonitor_BAO_HealthAlarmRule", "sensor_id"),
                        ],
//                        $sensor_name = CRM_Core_PseudoConstant::getLabel("CRM_Healthmonitor_BAO_HealthAlarmRule", "sensor_id");
                    ],
                    'grouping' => 'device-fields',
                ],
                'civicrm_health_alarm' => [
                    'dao' => 'CRM_Healthmonitor_DAO_HealthAlarm',
                    'fields' => [
                        'alarms' => [
                            'name' => 'id',
                            'title' => ts('Alarms'),
                            'default' => TRUE,
//                            'required' => TRUE,
                            'statistics' => TRUE,
                        ],
                    ],
                    'filters' => [
                    ],
                    'grouping' => 'device-fields',
                ],
                'civicrm_health_alert_rule' => [
                    'dao' => 'CRM_Healthmonitor_DAO_HealthAlertRule',
                    'fields' => [
                        'alert_rules' => [
                            'name' => 'id',
                            'title' => ts('Alert Rules'),
                            'default' => TRUE,
//                            'required' => TRUE,
                            'statistics' => TRUE,
                        ],
                    ],
                    'filters' => [
                    ],
                    'grouping' => 'device-fields',
                ],
                'civicrm_health_alert' => [
                    'dao' => 'CRM_Healthmonitor_DAO_HealthAlert',
                    'fields' => [
                        'alerts' => [
                            'name' => 'id',
                            'title' => ts('Alerts'),
                            'default' => TRUE,
//                            'required' => TRUE,
                            'statistics' => TRUE,
                        ],
                    ],
                    'filters' => [
                    ],
                    'grouping' => 'device-fields',
                ],
            )
        ;

        $this->_groupFilter = TRUE;
        $this->_tagFilter = TRUE;
        parent::__construct();
    }

    public function preProcess()
    {
        parent::preProcess();
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
        $errors = $grouping = [];
        return $errors;
    }

    /**
     * manipulate the select function to query count functions.
     */
    public function select()
    {

        // Define a list of columns that should be counted with the DISTINCT
        // keyword. For example, civicrm_mailing_event_opened.unique_open_count
        // should display the number of unique records, whereas something like
        // civicrm_mailing_event_opened.open_count should display the total number.
        // Each string here is in the form $tableName.$fieldName, where $tableName
        // is the key in $this->_columns, and $fieldName is the key in that array's
        // ['fields'] array.
        // Reference: CRM-20660

        $select = [];
        $this->_columnHeaders = [];
        foreach ($this->_columns as $tableName => $table) {
//        CRM_Core_Error::debug_var('tableName', $tableName);
//        CRM_Core_Error::debug_var('table', $table);
            if (array_key_exists('fields', $table)) {
                foreach ($table['fields'] as $fieldName => $field) {
                    if (!empty($field['required']) || !empty($this->_params['fields'][$fieldName])) {
//                        CRM_Core_Error::debug_var('fieldName', $fieldName);
//                        CRM_Core_Error::debug_var('dbAlias', $field['dbAlias']);
                        if (!empty($field['statistics'])) {
                            # for statistics
                            $distinct = 'DISTINCT';
                            $select[] = "count($distinct {$field['dbAlias']}) as {$tableName}_{$fieldName}";
                        } else {
                            $select[] = "{$field['dbAlias']} as {$tableName}_{$fieldName}";
                        }

                        $this->_columnHeaders["{$tableName}_{$fieldName}"]['type'] = $field['type'] ?? NULL;
                        $this->_columnHeaders["{$tableName}_{$fieldName}"]['title'] = $field['title'];
                    }
                }
            }
        }

        $this->_selectClauses = $select;
        $this->_select = "SELECT " . implode(', ', $select) . " ";
//        CRM_Core_Error::debug_var('select', $this->_select);

//        print_r($this->_select);
    }

    public function from()
    {
        $this->_from = "
        FROM 
        civicrm_contact {$this->_aliases['civicrm_contact']}
        {$this->_aclFrom} 
        INNER JOIN
        civicrm_device {$this->_aliases['civicrm_device']}      
        ON 
        ({$this->_aliases['civicrm_contact']}.id =
                          {$this->_aliases['civicrm_device']}.contact_id 
                          )
        LEFT JOIN
        civicrm_health_monitor {$this->_aliases['civicrm_health_monitor']} 
        ON 
        ({$this->_aliases['civicrm_contact']}.id =
                          {$this->_aliases['civicrm_health_monitor']}.contact_id 
        and {$this->_aliases['civicrm_device']}.id =
                          {$this->_aliases['civicrm_health_monitor']}.device_id
                          )
        LEFT JOIN
        civicrm_health_alarm_rule {$this->_aliases['civicrm_health_alarm_rule']}
        ON
        ({$this->_aliases['civicrm_contact']}.id =
                          {$this->_aliases['civicrm_health_alarm_rule']}.contact_id )                          
        LEFT JOIN
        civicrm_health_alarm {$this->_aliases['civicrm_health_alarm']}
        ON
        ({$this->_aliases['civicrm_contact']}.id =
                          {$this->_aliases['civicrm_health_alarm']}.contact_id 
        and {$this->_aliases['civicrm_health_alarm_rule']}.id =
                          {$this->_aliases['civicrm_health_alarm']}.alarm_rule_id
             and {$this->_aliases['civicrm_health_monitor']}.id = 
             {$this->_aliases['civicrm_health_alarm']}.health_monitor_id 
                          )
        LEFT JOIN
        civicrm_health_alert_rule {$this->_aliases['civicrm_health_alert_rule']}
        ON
        ({$this->_aliases['civicrm_contact']}.id =
                          {$this->_aliases['civicrm_health_alert_rule']}.contact_id 
        and {$this->_aliases['civicrm_health_alarm_rule']}.id = 
                          {$this->_aliases['civicrm_health_alert_rule']}.rule_id      
                          )
        LEFT JOIN
        civicrm_health_alert {$this->_aliases['civicrm_health_alert']}
        ON
        ({$this->_aliases['civicrm_contact']}.id =
                          {$this->_aliases['civicrm_health_alert']}.contact_id 
                          and {$this->_aliases['civicrm_health_alert_rule']}.id = 
                          {$this->_aliases['civicrm_health_alert']}.alert_rule_id
             and {$this->_aliases['civicrm_health_alarm']}.id 
             = {$this->_aliases['civicrm_health_alert']}.health_alarm_id
                          )                          
        ";

//        $this->joinAddressFromContact();
//        $this->joinPhoneFromContact();
//        $this->joinEmailFromContact();
//        $this->joinCountryFromAddress();
    }

    public function groupBy()
    {
        $this->_groupBy = "";
        $append = FALSE;

        if (is_array($this->_params['group_bys']) &&
            !empty($this->_params['group_bys'])
        ) {
            foreach ($this->_columns as $tableName => $table) {
                if (array_key_exists('group_bys', $table)) {
                    foreach ($table['group_bys'] as $fieldName => $field) {
                        if (!empty($this->_params['group_bys'][$fieldName])) {
                            if (!empty($field['chart'])) {
                                $this->assign('chartSupported', TRUE);
                            }

                            if (!empty($table['group_bys'][$fieldName]['frequency']) &&
                                !empty($this->_params['group_bys_freq'][$fieldName])
                            ) {

                                $append = "YEAR({$field['dbAlias']}),";
                                if (in_array(strtolower($this->_params['group_bys_freq'][$fieldName]),
                                    ['year']
                                )) {
                                    $append = '';
                                }
                                $this->_groupByArray[] = "$append {$this->_params['group_bys_freq'][$fieldName]}({$field['dbAlias']})";
                                $append = TRUE;
                            } else {
                                $this->_groupByArray[] = $field['dbAlias'];
                            }
                        }
                    }
                }
            }

            if (!empty($this->_statFields) &&
                (($append && count($this->_groupByArray) <= 1) || (!$append)) &&
                !$this->_having
            ) {
                $this->_rollup = " WITH ROLLUP";
            }
            $groupBy = $this->_groupByArray;
            $this->_groupBy = "GROUP BY " . implode(', ', $this->_groupByArray);
        } else {
            $groupBy = "{$this->_aliases['civicrm_contact']}.id";
            $this->_groupBy = "GROUP BY {$groupBy}";
        }
        $this->_select = CRM_Contact_BAO_Query::appendAnyValueToSelect($this->_selectClauses, $groupBy);
        $this->_groupBy .= " {$this->_rollup}";
    }

    /**
     * @param $rows
     *
     * @return array
     */

    public function statistics(&$rows)
    {
        $statistics = parent::statistics($rows);

        if (!$this->_having) {
            $select = "
            SELECT COUNT({$this->_aliases['civicrm_device']}.id )       as count,
                   SUM({$this->_aliases['civicrm_device']}.id )         as amount,
                   ROUND(AVG({$this->_aliases['civicrm_device']}.id), 2) as avg
            ";

            $sql = "{$select} {$this->_from} {$this->_where}";

            $dao = CRM_Core_DAO::executeQuery($sql);

            if ($dao->fetch()) {
                $statistics['count']['amount'] = [
                    'value' => $dao->amount,
                    'title' => ts('Total Pledged'),
                ];
                $statistics['count']['count '] = [
                    'value' => $dao->count,
                    'title' => ts('Total No Pledges'),
                ];
                $statistics['count']['avg   '] = [
                    'value' => $dao->avg,
                    'title' => ts('Average'),
                    'type' => CRM_Utils_Type::T_INT,
                ];
            }
        }
        return $statistics;
    }

    public function postProcess()
    {
        $this->beginPostProcess();
        $sql = $this->buildQuery(TRUE);
//        CRM_Core_Error::debug_var('sql', $sql);
        $rows = [];
        $this->buildRows($sql, $rows);
        $this->formatDisplay($rows);
        $this->doTemplateAssignment($rows);
        $this->endPostProcess($rows);
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
            // convert sort name to links
            if (array_key_exists('civicrm_contact_sort_name', $row) &&
                array_key_exists('civicrm_contact_id', $row)
            ) {
                $url = CRM_Report_Utils_Report::getNextUrl('contact/detail',
                    'reset=1&force=1&id_op=eq&id_value=' . $row['civicrm_contact_id'],
                    $this->_absoluteUrl, $this->_id, $this->_drilldownReport
                );
                $rows[$rowNum]['civicrm_contact_sort_name_link'] = $url;
                $rows[$rowNum]['civicrm_contact_sort_name_hover'] = ts('View Contact Detail Report for this contact');
                $entryFound = TRUE;
            }

            // Handle ID to label conversion for contact fields
            $entryFound = $this->alterDisplayContactFields($row, $rows, $rowNum, 'contact/summary', 'View Contact Summary') ? TRUE : $entryFound;

            // skip looking further in rows, if first row itself doesn't
            // have the column we need
            if (!$entryFound) {
                break;
            }
        }
    }

}
