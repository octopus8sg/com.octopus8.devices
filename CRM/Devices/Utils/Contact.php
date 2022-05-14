<?php

use CRM_Devices_ExtensionUtil as E;

/**
 * Class provide extension version helper methods
 * copy of CRM_CiviMobileAPI_Utils_Contact
 * push notifications and avatar removed
 */
class CRM_Devices_Utils_Contact {

    /**
     * @param int $contactId
     *
     * @throws \CiviCRM_API3_Exception
     */
    public static function logoutFromMobile($contactId) {
        civicrm_api3('Contact', 'create', [
            'id' => $contactId,
            'api_key' => '',
        ]);

      CRM_Core_Session::setStatus(E::ts('Your Api key has removed and all device disconnected from account.'));

        CRM_Utils_System::redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * Gets Contact's list of emails
     *
     * @param int $contactId
     *
     * @return array
     */
    public static function getEmails($contactId) {
        $emailList = [];

        if (empty($contactId)) {
            return $emailList;
        }

        try {
            $result = civicrm_api3('Email', 'get', [
                'sequential' => 1,
                'return' => ['email'],
                'contact_id' => $contactId,
                'options' => ['limit' => 0],
            ]);
        } catch (CiviCRM_API3_Exception $e) {
            return $emailList;
        }

        if (empty($result)) {
            return $emailList;
        }

        foreach ($result['values'] as $email) {
            $emailList[] = $email['email'];
        }

        return $emailList;
    }

    /**
     * Gets display_name by Contact id
     *
     * @param int $contactId
     *
     * @return string
     */
    public static function getDisplayName($contactId) {
        if (empty($contactId)) {
            return '';
        }

        try {
            $displayName = civicrm_api3('Contact', 'getvalue', [
                'return' => 'display_name',
                'contact_id' => $contactId
            ]);
        } catch (CiviCRM_API3_Exception $e) {
            return '';
        }

        return $displayName;
    }

    /**
     * Gets current Contact id
     *
     * @return null|string
     */
    public static function getCurrentContactId() {
        $session = CRM_Core_Session::singleton();
        if (CRM_Contact_BAO_Contact_Utils::isContactId($session->get('userID'))) {
            return  $session->get('userID');
        }

        return false;
    }

    /**
     * Is contact has 'api_key'
     *
     * @param int $contactId
     *
     * @return bool
     */
    public static function isContactHasApiKey($contactId) {
        if (empty($contactId)) {
            return FALSE;
        }

        $apiKey = CRM_Core_DAO::getFieldValue('CRM_Contact_DAO_Contact', (int) $contactId, 'api_key');

        return !empty($apiKey);
    }

    /**
     * Checks is blocked application for user
     *
     * @param $contactId
     * @return int
     */
    public static function isBlockedApp($contactId) {
        return 0;
    }

}
