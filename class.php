<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Application,
	Bitrix\Main\Localization\Loc;

class FlxMDAuthorizationUser extends CBitrixComponent
{

	private $arRequest = [];

	private $bCheckFields = false;
	private $isRegisterUser = false;

	private $arResponse = [];

	public function executeComponent()
	{
		Loc::loadMessages(__FILE__);

		$this->arResult["PARAMS_HASH"] = md5(serialize($this->arParams).$this->GetTemplateName());

		$this->arRequest = Application::getInstance()->getContext()->getRequest();

		if (
			$this->arRequest->isAjaxRequest() &&
			$this->arRequest->getPost('FLXMD_AJAX') === 'Y' &&
			$this->arRequest->getPost('PARAMS_HASH') === $this->arResult["PARAMS_HASH"]
		) {
			$this->checkFields();

			if ($this->bCheckFields)
				$this->isRegisterUser();

			if ($this->isRegisterUser)
				$this->doAuthorization();

			$this->sendResponseAjax();

		} else {

			$this->IncludeComponentTemplate();

		}
	}

	public function checkFields()
	{
		if (
			$this->arRequest->getPost('PARAMS_HASH') === $this->arResult["PARAMS_HASH"] &&
			empty($this->arRequest->getPost('CHECK_EMPTY')) &&
			!empty($this->arRequest->getPost('auth-email')) &&
			check_email($this->arRequest->getPost('auth-email')) &&
			!empty($this->arRequest->getPost('auth-password')) &&
			check_bitrix_sessid()
		) {

			$this->bCheckFields = true;

		} else {

			$this->arResponse = ['STATUS' => 'ERROR', 'MESSAGE' => Loc::getMessage("FLXMD_AUTHORIZATION_USER_FIELDS_ERROR")];
			$this->bCheckFields = false;

		}
	}

	public function isRegisterUser()
	{
		$this->arSearchUser = \Bitrix\Main\UserTable::GetList(array(
			'select' => array('ID', 'ACTIVE', 'LOGIN', 'PASSWORD', 'EMAIL'),
			'filter' => array('LOGIN' => htmlspecialchars($this->arRequest->getPost('auth-email')))
		));

		if ( $this->arUser = $this->arSearchUser->fetch() ) {
			if ($this->arUser["ACTIVE"] == 'Y') {
				$this->isRegisterUser = true;
			} else {
				$this->arResponse = ['STATUS' => 'ERROR', 'MESSAGE' => Loc::getMessage("FLXMD_AUTHORIZATION_USER_IS_REGISTER_WITHOUT_ACTIVE")];
			}
		} else {
			$this->arResponse = ['STATUS' => 'ERROR', 'MESSAGE' => Loc::getMessage("FLXMD_AUTHORIZATION_USER_IS_NOT_REGISTER")];
		}
	}

	public function doAuthorization()
	{
		$this->user = new CUser;
		$this->arAuthResult = $this->user->Login(htmlspecialchars($this->arRequest->getPost('auth-email')), htmlspecialchars($this->arRequest->getPost('auth-password')),"Y");

		if ($this->arAuthResult['TYPE'] == 'ERROR') {
			$this->arResponse = ['STATUS' => 'ERROR', 'MESSAGE' => Loc::getMessage("FLXMD_AUTHORIZATION_USER_ERROR")];
		} else {
			$this->arResponse = ['STATUS' => 'SUCCESS'];
		}
	}


	public function sendResponseAjax() {

		global $APPLICATION;

		$APPLICATION->RestartBuffer();

		echo json_encode($this->arResponse);

		die();

	}

}
