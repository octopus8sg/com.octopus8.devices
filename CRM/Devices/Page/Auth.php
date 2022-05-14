<?php

use CRM_Devices_Utils_Request as Request;
// @todo Request
use CRM_Devices_Utils_JsonResponse as JsonResponse;
// @todo Response


use CRM_Devices_ExtensionUtil as E;

class CRM_Devices_Page_Auth extends CRM_Core_Page {

  /**
   * Email or Username sent in request
   *
   * @var string
   */
  public $emailOrUsername;

  /**
   * Password sent in request
   *
   * @var string
   */
  public $password;

  /**
   * Drupal Id which related to email and password
   *
   * @var int
   */
  public $cmsContactId;

  /**
   * CiviCrm contact assigns to drupal contact
   *
   * @var \CRM_Contact_BAO_Contact
   */
  public $civiContact;

  /**
   * CRM_CiviMobileAPI_Page_Auth constructor.
   */
  public function __construct() {
// civimobileapi_secret_validation();
// adds hook

    $this->emailOrUsername = $this->getEmailOrUsername();
// Step 1
    $this->password = $this->getPassword();

    $this->cmsContactId = CRM_Devices_Utils_AuthenticationHelper::getCmsUserIdByMailAndPassword($this->emailOrUsername, $this->password);

    if ($this->isBlocked()) {
      JsonResponse::sendErrorResponse('User is blocked', 'email', 'cms_user_is_blocked');
    }

    $this->civiContact = CRM_Devices_Utils_AuthenticationHelper::getCiviContact($this->cmsContactId);

    if (CRM_Devices_Utils_Contact::isBlockedApp($this->civiContact->id) == 1) {
        //Not understandable
      JsonResponse::sendErrorResponse('App is blocked for this user.', 'email', 'application_access_is_blocked');
    }
    parent::__construct();
  }

  /**
   * Gets email from request
   *
   * @return string|null
   */
  private function getEmailOrUsername() {
      //done
    $emailOrUsername = Request::getInstance()->post('email', 'String');
    if (!$emailOrUsername) {
      JsonResponse::sendErrorResponse(E::ts('Required field'), 'email');
    }

    return $emailOrUsername;
  }

  /**
   * Gets password from request
   *
   * @return string|null
   */
  private function getPassword() {
      //done
    $password = Request::getInstance()->post('password', 'String');
    if (!$password) {
      JsonResponse::sendErrorResponse(E::ts('Required field'), 'password');
    }

    return $password;
  }

  /**
   * Checks have user blocked status
   *
   * @return bool
   */
  private function isBlocked() {
    $user = CRM_Devices_Utils_CmsUser::getInstance()->searchAccount($this->emailOrUsername);
//todo
    $currentCMS = CRM_Devices_Utils_CmsUser::getInstance()->getSystem();
    $isBlocked = FALSE;

    switch ($currentCMS) {
      case CRM_Devices_Utils_CmsUser::CMS_JOOMLA:
        if ($user->block == 1) {
          $isBlocked = TRUE;
        }
        break;
      case CRM_Devices_Utils_CmsUser::CMS_DRUPAL6:
      case CRM_Devices_Utils_CmsUser::CMS_DRUPAL7:
        if ($user->status == 0) {
          $isBlocked = TRUE;
        }
        break;
      case CRM_Devices_Utils_CmsUser::CMS_DRUPAL8:
        $isBlocked = $user->isBlocked();
        break;
    }

    return $isBlocked;
  }

  /**
   * Checks If request is valid and launch preparing user data
   */
  public function run() {
    if (CRM_Devices_Utils_AuthenticationHelper::isRequestValid()) {
      (new CRM_Devices_Utils_Login($this))->run();
    }
  }

}
