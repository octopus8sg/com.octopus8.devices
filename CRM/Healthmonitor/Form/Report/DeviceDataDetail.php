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
class CRM_Healthmonitor_Form_Report_DeviceDataDetail extends CRM_Report_Form
{

    protected $_summary = NULL;

    protected $_softFrom = NULL;

    protected $noDisplayContributionOrSoftColumn = FALSE;

    protected $_customGroupExtends = [
        'Contact',
        'Individual',
//    'Contribution',
    ];

    protected $groupConcatTested = TRUE;

    protected $isTempTableBuilt = FALSE;

    /**
     * Query mode.
     *
     * This can be 'Main' or 'SoftCredit' to denote which query we are building.
     *
     * @var string
     */
    protected $queryMode = 'Main';

    /**
     * Is this report being run on contributions as the base entity.
     *
     * The report structure is generally designed around a base entity but
     * depending on input it can be run in a sort of hybrid way that causes a lot
     * of complexity.
     *
     * If it is in isContributionsOnlyMode we can simplify.
     *
     * (arguably there should be 2 separate report templates, not one doing double duty.)
     *
     * @var bool
     */
//  protected $isContributionBaseMode = FALSE;

    /**
     * This report has been optimised for group filtering.
     *
     * @var bool
     * @see https://issues.civicrm.org/jira/browse/CRM-19170
     */
    protected $groupFilterNotOptimised = FALSE;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->_autoIncludeIndexedFieldsAsOrderBys = 1;
        $this->_columns = array_merge(
            $this->getColumns('Contact', [
                'order_bys_defaults' => ['sort_name' => 'ASC '],
                'fields_defaults' => ['sort_name'],
                'fields_excluded' => ['id'],
                'fields_required' => ['id'],
                'filters_defaults' => ['is_deleted' => 0],
                'no_field_disambiguation' => TRUE,
            ]),
            [
                'civicrm_email' => [
                    'dao' => 'CRM_Core_DAO_Email',
                    'fields' => [
                        'email' => [
                            'title' => ts('Contact Email'),
                            'default' => TRUE,
                        ],
                    ],
                    'grouping' => 'contact-fields',
                ],
//        'civicrm_line_item' => [
//          'dao' => 'CRM_Price_DAO_LineItem',
//        ],
                'civicrm_phone' => [
                    'dao' => 'CRM_Core_DAO_Phone',
                    'fields' => [
                        'phone' => [
                            'title' => ts('Contact Phone'),
                            'default' => TRUE,
                            'no_repeat' => TRUE,
                        ],
                    ],
                    'grouping' => 'contact-fields',
                ],
                'civicrm_health_monitor' => [
                    'dao' => 'CRM_Healthmonitor_DAO_HealthMonitor',
                    'fields' => [
                        'health_monitor_id' => [
                            'name' => 'id',
                            'no_display' => TRUE,
                            'required' => TRUE,
                        ],
                        'date' => ['type' => CRM_Utils_Type::T_INT,
//                            'required' => TRUE,
                            'default' => TRUE,
                        ],
                        'device_id' => [
                            'title' => ts('Device'),
//                            'required' => TRUE,
                            'default' => TRUE,
                        ],
                        'sensor_id' => [
                            'title' => ts('Sensor'),
//                            'required' => TRUE,
                            'default' => TRUE,
                        ],
                        'sensor_value' => [
                            'title' => ts('Value'),
//                            'required' => TRUE,
                            'default' => TRUE,
                        ],
                    ],
                    'filters' => [
                        'date' => ['operatorType' => CRM_Report_Form::OP_DATE],
                    ],
                    'order_bys' => [
                        'date' => ['title' => ts('Date')],
                        'sensor_id' => ['title' => ts('Sensor')],
                        'device_id' => ['title' => ts('Device')],
                    ],
                    'group_bys' => [
//                    'health_monitor_id' => [
//                      'name' => 'id',
//                      'required' => TRUE,
//                      'default' => TRUE,
//                      'title' => ts('Device Data'),
//                    ],
//                    'health_monitor_date' => [
//                      'name' => 'date',
//                      'required' => TRUE,
//                      'default' => TRUE,
//                      'title' => ts('Date'),
//                    ],
                    ],
                    'grouping' => 'contact-fields',
                ],
//        'civicrm_contribution' => [
//          'dao' => 'CRM_Contribute_DAO_Contribution',
//          'fields' => [
//            'contribution_id' => [
//              'name' => 'id',
//              'no_display' => TRUE,
//              'required' => TRUE,
//            ],
//            'list_contri_id' => [
//              'name' => 'id',
//              'title' => ts('Contribution ID'),
//            ],
//            'financial_type_id' => [
//              'title' => ts('Financial Type'),
//              'default' => TRUE,
//            ],
//            'contribution_status_id' => [
//              'title' => ts('Contribution Status'),
//            ],
//            'contribution_page_id' => [
//              'title' => ts('Contribution Page'),
//            ],
//            'source' => [
//              'title' => ts('Source'),
//            ],
//            'payment_instrument_id' => [
//              'title' => ts('Payment Type'),
//            ],
//            'check_number' => [
//              'title' => ts('Check Number'),
//            ],
//            'currency' => [
//              'required' => TRUE,
//              'no_display' => TRUE,
//            ],
//            'trxn_id' => NULL,
//            'receive_date' => ['default' => TRUE],
//            'receipt_date' => NULL,
//            'thankyou_date' => NULL,
//            'total_amount' => [
//              'title' => ts('Amount'),
//              'required' => TRUE,
//            ],
//            'non_deductible_amount' => [
//              'title' => ts('Non-deductible Amount'),
//            ],
//            'fee_amount' => NULL,
//            'net_amount' => NULL,
//            'contribution_or_soft' => [
//              'title' => ts('Contribution OR Soft Credit?'),
//              'dbAlias' => "'Contribution'",
//            ],
//            'soft_credits' => [
//              'title' => ts('Soft Credits'),
//              'dbAlias' => "NULL",
//            ],
//            'soft_credit_for' => [
//              'title' => ts('Soft Credit For'),
//              'dbAlias' => "NULL",
//            ],
//            'cancel_date' => [
//              'title' => ts('Cancelled / Refunded Date'),
//              'name' => 'contribution_cancel_date',
//            ],
//            'cancel_reason' => [
//              'title' => ts('Cancellation / Refund Reason'),
//            ],
//          ],
//          'filters' => [
//            'contribution_or_soft' => [
//              'title' => ts('Contribution OR Soft Credit?'),
//              'clause' => "(1)",
//              'operatorType' => CRM_Report_Form::OP_SELECT,
//              'type' => CRM_Utils_Type::T_STRING,
//              'options' => [
//                'contributions_only' => ts('Contributions Only'),
//                'soft_credits_only' => ts('Soft Credits Only'),
//                'both' => ts('Both'),
//              ],
//              'default' => 'contributions_only',
//            ],
//            'receive_date' => ['operatorType' => CRM_Report_Form::OP_DATE],
//            'receipt_date' => ['operatorType' => CRM_Report_Form::OP_DATE],
//            'thankyou_date' => ['operatorType' => CRM_Report_Form::OP_DATE],
//            'contribution_source' => [
//              'title' => ts('Source'),
//              'name' => 'source',
//              'type' => CRM_Utils_Type::T_STRING,
//            ],
//            'currency' => [
//              'title' => ts('Currency'),
//              'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//              'options' => CRM_Core_OptionGroup::values('currencies_enabled'),
//              'default' => NULL,
//              'type' => CRM_Utils_Type::T_STRING,
//            ],
//            'non_deductible_amount' => [
//              'title' => ts('Non-deductible Amount'),
//            ],
//            'financial_type_id' => [
//              'title' => ts('Financial Type'),
//              'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//              'options' => CRM_Contribute_BAO_Contribution::buildOptions('financial_type_id', 'search'),
//              'type' => CRM_Utils_Type::T_INT,
//            ],
//            'contribution_page_id' => [
//              'title' => ts('Contribution Page'),
//              'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//              'options' => CRM_Contribute_PseudoConstant::contributionPage(),
//              'type' => CRM_Utils_Type::T_INT,
//            ],
//            'payment_instrument_id' => [
//              'title' => ts('Payment Type'),
//              'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//              'options' => CRM_Contribute_PseudoConstant::paymentInstrument(),
//              'type' => CRM_Utils_Type::T_INT,
//            ],
//            'contribution_status_id' => [
//              'title' => ts('Contribution Status'),
//              'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//              'options' => CRM_Contribute_BAO_Contribution::buildOptions('contribution_status_id', 'search'),
//              'default' => [1],
//              'type' => CRM_Utils_Type::T_INT,
//            ],
//            'total_amount' => ['title' => ts('Contribution Amount')],
//            'cancel_date' => [
//              'title' => ts('Cancelled / Refunded Date'),
//              'operatorType' => CRM_Report_Form::OP_DATE,
//              'name' => 'contribution_cancel_date',
//            ],
//            'cancel_reason' => [
//              'title' => ts('Cancellation / Refund Reason'),
//            ],
//          ],
//          'order_bys' => [
//            'financial_type_id' => ['title' => ts('Financial Type')],
//            'contribution_status_id' => ['title' => ts('Contribution Status')],
//            'payment_instrument_id' => ['title' => ts('Payment Method')],
//            'receive_date' => ['title' => ts('Date Received')],
//            'receipt_date' => ['title' => ts('Receipt Date')],
//            'thankyou_date' => ['title' => ts('Thank-you Date')],
//          ],
//          'group_bys' => [
//            'contribution_id' => [
//              'name' => 'id',
//              'required' => TRUE,
//              'default' => TRUE,
//              'title' => ts('Contribution'),
//            ],
//          ],
//          'grouping' => 'contri-fields',
//        ],
//        'civicrm_contribution_soft' => [
//          'dao' => 'CRM_Contribute_DAO_ContributionSoft',
//          'fields' => [
//            'soft_credit_type_id' => ['title' => ts('Soft Credit Type')],
//            'soft_credit_amount' => ['title' => ts('Soft Credit amount'), 'name' => 'amount', 'type' => CRM_Utils_Type::T_MONEY],
//          ],
//          'filters' => [
//            'soft_credit_type_id' => [
//              'title' => ts('Soft Credit Type'),
//              'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//              'options' => CRM_Core_OptionGroup::values('soft_credit_type'),
//              'default' => NULL,
//              'type' => CRM_Utils_Type::T_STRING,
//            ],
//          ],
//          'group_bys' => [
//            'soft_credit_id' => [
//              'name' => 'id',
//              'title' => ts('Soft Credit'),
//            ],
//          ],
//        ],
//        'civicrm_financial_trxn' => [
//          'dao' => 'CRM_Financial_DAO_FinancialTrxn',
//          'fields' => [
//            'card_type_id' => [
//              'title' => ts('Credit Card Type'),
//            ],
//          ],
//          'filters' => [
//            'card_type_id' => [
//              'title' => ts('Credit Card Type'),
//              'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//              'options' => CRM_Financial_DAO_FinancialTrxn::buildOptions('card_type_id'),
//              'default' => NULL,
//              'type' => CRM_Utils_Type::T_STRING,
//            ],
//          ],
//        ],
//        'civicrm_batch' => [
//          'dao' => 'CRM_Batch_DAO_EntityBatch',
//          'grouping' => 'contri-fields',
//          'fields' => [
//            'batch_id' => [
//              'name' => 'batch_id',
//              'title' => ts('Batch Name'),
//            ],
//          ],
//          'filters' => [
//            'bid' => [
//              'title' => ts('Batch Name'),
//              'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//              'options' => CRM_Batch_BAO_Batch::getBatches(),
//              'type' => CRM_Utils_Type::T_INT,
//              'dbAlias' => 'batch_civireport.batch_id',
//            ],
//          ],
//        ],
//        'civicrm_contribution_ordinality' => [
//          'dao' => 'CRM_Contribute_DAO_Contribution',
//          'alias' => 'cordinality',
//          'filters' => [
//            'ordinality' => [
//              'title' => ts('Contribution Ordinality'),
//              'operatorType' => CRM_Report_Form::OP_MULTISELECT,
//              'options' => [
//                0 => ts('First by Contributor'),
//                1 => ts('Second or Later by Contributor'),
//              ],
//              'type' => CRM_Utils_Type::T_INT,
//            ],
//          ],
//        ],
//        'civicrm_note' => [
//          'dao' => 'CRM_Core_DAO_Note',
//          'fields' => [
//            'contribution_note' => [
//              'name' => 'note',
//              'title' => ts('Contribution Note'),
//            ],
//          ],
//          'filters' => [
//            'note' => [
//              'name' => 'note',
//              'title' => ts('Contribution Note'),
//              'operator' => 'like',
//              'type' => CRM_Utils_Type::T_STRING,
//            ],
//          ],
//        ],
//        'civicrm_pledge_payment' => [
//          'dao' => 'CRM_Pledge_DAO_PledgePayment',
//          'fields' => [
//            'pledge_id' => [
//              'title' => ts('Pledge ID'),
//            ],
//          ],
//          'filters' => [
//            'pledge_id' => [
//              'title' => ts('Pledge ID'),
//              'type' => CRM_Utils_Type::T_INT,
//            ],
//          ],
//        ],
            ],
//      $this->getColumns('Address')
        );
        // The tests test for this variation of the sort_name field. Don't argue with the tests :-).
        $this->_columns['civicrm_contact']['fields']['sort_name']['title'] = ts('Contact Name');
        $this->_groupFilter = TRUE;
        $this->_tagFilter = TRUE;
        // If we have campaigns enabled, add those elements to both the fields, filters and sorting
//    $this->addCampaignFields('civicrm_contribution', FALSE, TRUE);
//
//    $this->_currencyColumn = 'civicrm_contribution_currency';
        parent::__construct();
    }

    /**
     * Validate incompatible report settings.
     *
     * @return bool
     *   true if no error found
     */
//  public function validate() {
//    // If you're displaying Contributions Only, you can't group by soft credit.
//    $contributionOrSoftVal = $this->getElementValue('contribution_or_soft_value');
//    if ($contributionOrSoftVal[0] == 'contributions_only') {
//      $groupBySoft = $this->getElementValue('group_bys');
//      if (!empty($groupBySoft['soft_credit_id'])) {
//        $this->setElementError('group_bys', ts('You cannot group by soft credit when displaying contributions only.  Please uncheck "Soft Credit" in the Grouping tab.'));
//      }
//    }
//
//    return parent::validate();
//  }

    /**
     * Set the FROM clause for the report.
     */
    public function from()
    {
        $this->setFromBase('civicrm_contact');
        $this->_from .= "
      INNER JOIN civicrm_health_monitor {$this->_aliases['civicrm_health_monitor']}
        ON {$this->_aliases['civicrm_contact']}.id = {$this->_aliases['civicrm_health_monitor']}.contact_id
        ";

        $this->appendAdditionalFromJoins();
    }

    /**
     * @param $rows
     *
     * @return array
     * @throws \CRM_Core_Exception
     */
    public function statistics(&$rows)
    {
        $statistics = parent::statistics($rows);

        return $statistics;
    }

    /**
     * Build the report query.
     *
     * @param bool $applyLimit
     *
     * @return string
     */
    public function buildQuery($applyLimit = TRUE)
    {
        return parent::buildQuery($applyLimit);
    }

    /**
     * Shared function for preliminary processing.
     *
     * This is called by the api / unit tests and the form layer and is
     * the right place to do 'initial analysis of input'.
     */
    public function beginPostProcessCommon()
    {

        // 1. use main contribution query to build temp table 1
        $sql = $this->buildQuery();
        $this->createTemporaryTable('civireport_contribution_detail_temp1', $sql);
        $this->limit();
        $this->setPager();
    }

    /**
     * Store group bys into array - so we can check elsewhere what is grouped.
     *
     * If we are generating a table of soft credits we need to group by them.
     */
//  protected function storeGroupByArray() {
//    if ($this->queryMode === 'SoftCredit') {
//      $this->_groupByArray = [$this->_aliases['civicrm_health_monitor_soft'] . '.id'];
//    }
//    else {
//      parent::storeGroupByArray();
//    }
//  }

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
        $display_flag = $prev_cid = $cid = 0;
        foreach ($rows as $rowNum => $row) {
//            CRM_Core_Error::debug_var('rows', $rows);
//            CRM_Core_Error::debug_var('rowNum', $rowNum);
//            CRM_Core_Error::debug_var('row', $row);

            if (!empty($this->_noRepeats) && $this->_outputMode != 'csv') {
                // don't repeat contact details if its same as the previous row
                if (array_key_exists('civicrm_contact_id', $row)) {
                    if ($cid = $row['civicrm_contact_id']) {
                        if ($rowNum == 0) {
                            $prev_cid = $cid;
                        } else {
                            if ($prev_cid == $cid) {
                                $display_flag = 1;
                                $prev_cid = $cid;
                            } else {
                                $display_flag = 0;
                                $prev_cid = $cid;
                            }
                        }

                        if ($display_flag) {
                            foreach ($row as $colName => $colVal) {
                                // Hide repeats in no-repeat columns, but not if the field's a section header
                                if (in_array($colName, $this->_noRepeats) &&
                                    !array_key_exists($colName, $this->_sections)
                                ) {
                                    unset($rows[$rowNum][$colName]);
                                }
                            }
                        }
                        $entryFound = TRUE;
                    }
                }
            }

            // convert donor sort name to link
            if (array_key_exists('civicrm_contact_sort_name', $row) &&
                !empty($rows[$rowNum]['civicrm_contact_sort_name']) &&
                array_key_exists('civicrm_contact_id', $row)
            ) {
                $url = CRM_Utils_System::url("civicrm/contact/view",
                    'reset=1&cid=' . $row['civicrm_contact_id'],
                    $this->_absoluteUrl
                );
                $rows[$rowNum]['civicrm_contact_sort_name_link'] = $url;
                $rows[$rowNum]['civicrm_contact_sort_name_hover'] = ts("View Contact Summary for this Contact.");
            }

            if ($val = CRM_Utils_Array::value('civicrm_health_monitor_sensor_id', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);
                $val = intval($val);
                $rows[$rowNum]['civicrm_health_monitor_sensor_id']
                    = CRM_Core_PseudoConstant::getLabel("CRM_Healthmonitor_BAO_HealthAlarmRule", "sensor_id", $val);
            }
            if ($val = CRM_Utils_Array::value('civicrm_health_monitor_date', $row)) {
//                            CRM_Core_Error::debug_var('val', $val);
                $rows[$rowNum]['civicrm_health_monitor_date']
                    = $val;
            }
            if ($val = CRM_Utils_Array::value('civicrm_health_monitor_device_id', $row)) {
                $val = intval($val);
//                            CRM_Core_Error::debug_var('val', $val);
                $device_sql = "SELECT civicrm_device.name
                           from civicrm_device where civicrm_device.id = {$val}";
                $device_code = CRM_Core_DAO::singleValueQuery($device_sql);
                $rows[$rowNum]['civicrm_health_monitor_device_id']
                    = $device_code;
            }
            $lastKey = $rowNum;
        }
    }

    public function sectionTotals()
    {

        // Reports using order_bys with sections must populate $this->_selectAliases in select() method.
        if (empty($this->_selectAliases)) {
            return;
        }

        if (!empty($this->_sections)) {
            // build the query with no LIMIT clause
            $select = str_ireplace('SELECT SQL_CALC_FOUND_ROWS ', 'SELECT ', $this->_select);
            $sql = "{$select} {$this->_from} {$this->_where} {$this->_groupBy} {$this->_having} {$this->_orderBy}";

            // pull section aliases out of $this->_sections
            $sectionAliases = array_keys($this->_sections);

            $ifnulls = [];
            foreach (array_merge($sectionAliases, $this->_selectAliases) as $alias) {
                $ifnulls[] = "ifnull($alias, '') as $alias";
            }
            $this->_select = "SELECT " . implode(", ", $ifnulls);
            $this->_select = CRM_Contact_BAO_Query::appendAnyValueToSelect($ifnulls, $sectionAliases);

            /* Group (un-limited) report by all aliases and get counts. This might
             * be done more efficiently when the contents of $sql are known, ie. by
             * overriding this method in the report class.
             */

            $addtotals = '';

            if (array_search("civicrm_health_monitor_total_amount", $this->_selectAliases) !==
                FALSE
            ) {
                $addtotals = ", sum(civicrm_health_monitor_total_amount) as sumcontribs";
                $showsumcontribs = TRUE;
            }

            $query = $this->_select .
                "$addtotals, count(*) as ct from {$this->temporaryTables['civireport_contribution_detail_temp1']['name']} group by " .
                implode(", ", $sectionAliases);
            // initialize array of total counts
            $sumcontribs = $totals = [];
            $dao = CRM_Core_DAO::executeQuery($query);
            $this->addToDeveloperTab($query);
            while ($dao->fetch()) {

                // let $this->_alterDisplay translate any integer ids to human-readable values.
                $rows[0] = $dao->toArray();
                $this->alterDisplay($rows);
                $row = $rows[0];

                // add totals for all permutations of section values
                $values = [];
                $i = 1;
                $aliasCount = count($sectionAliases);
                foreach ($sectionAliases as $alias) {
                    $values[] = $row[$alias];
                    $key = implode(CRM_Core_DAO::VALUE_SEPARATOR, $values);
                    if ($i == $aliasCount) {
                        // the last alias is the lowest-level section header; use count as-is
                        $totals[$key] = $dao->ct;
                        if ($showsumcontribs) {
                            $sumcontribs[$key] = $dao->sumcontribs;
                        }
                    } else {
                        // other aliases are higher level; roll count into their total
                        $totals[$key] = (array_key_exists($key, $totals)) ? $totals[$key] + $dao->ct : $dao->ct;
                        if ($showsumcontribs) {
                            $sumcontribs[$key] = array_key_exists($key, $sumcontribs) ? $sumcontribs[$key] + $dao->sumcontribs : $dao->sumcontribs;
                        }
                    }
                }
            }
            if ($showsumcontribs) {
                $totalandsum = [];
                // ts exception to avoid having ts("%1 %2: %3")
                $title = '%1 contributions / soft-credits: %2';

                if (CRM_Utils_Array::value('contribution_or_soft_value', $this->_params) ==
                    'contributions_only'
                ) {
                    $title = '%1 contributions: %2';
                } elseif (CRM_Utils_Array::value('contribution_or_soft_value', $this->_params) ==
                    'soft_credits_only'
                ) {
                    $title = '%1 soft-credits: %2';
                }
                foreach ($totals as $key => $total) {
                    $totalandsum[$key] = ts($title, [
                        1 => $total,
                        2 => CRM_Utils_Money::format($sumcontribs[$key]),
                    ]);
                }
                $this->assign('sectionTotals', $totalandsum);
            } else {
                $this->assign('sectionTotals', $totals);
            }
        }
    }

    /**
     * Generate the from clause as it relates to the soft credits.
     */
    public function softCreditFrom()
    {

        $this->appendAdditionalFromJoins();
    }

    /**
     * Append the joins that are required regardless of context.
     */
    public function appendAdditionalFromJoins()
    {
        $this->joinPhoneFromContact();
        $this->joinAddressFromContact();
        $this->joinEmailFromContact();

    }


}
