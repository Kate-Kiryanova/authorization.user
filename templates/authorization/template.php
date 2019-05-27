<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
?>

<form class="form entry__form login js-validate" id="login-form" action="<?=POST_FORM_ACTION_URI;?>" method="post" autocomplete="off" data-no-success="1">

	<?=bitrix_sessid_post();?>

	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>" />
	<input type="hidden" name="FLXMD_AJAX" value="Y" />
	<input type="hidden" name="CHECK_EMPTY" value="" />

	<div class="form__message js-error-container"></div>

	<div class="form__row">
		<div class="form__item" id="login-email-item">
			<label class="form__label" for="login-email">
				<?= Loc::getMessage('AUTHORIZATION_FORM_EMAIL'); ?>
			</label>
			<input
				class="input"
				id="login-email"
				type="email"
				name="auth-email"
				required
				placeholder="<?= Loc::getMessage('AUTHORIZATION_FORM_EMAIL_PLACEHOLDER'); ?>"
				data-required-message="<?= Loc::getMessage('AUTHORIZATION_FORM_REQUIRED_FIELD'); ?>"
				data-error-message="<?= Loc::getMessage('AUTHORIZATION_FORM_EMAIL_ERROR'); ?>"
				data-error-target="#login-email-item"
			>
		</div>
	</div>

	<div class="form__row">
		<div class="form__item form__item--short-error" id="login-password-item">
			<label class="form__label" for="login-password">
				<?= Loc::getMessage('AUTHORIZATION_FORM_PASSWORD'); ?>
			</label>
			<input
				class="input"
				id="login-password"
				type="password"
				name="auth-password"
				required
				placeholder="<?= Loc::getMessage('AUTHORIZATION_FORM_PASSWORD_PLACEHOLDER'); ?>"
				data-required-message="<?= Loc::getMessage('AUTHORIZATION_FORM_REQUIRED_FIELD'); ?>"
				data-error-message="<?= Loc::getMessage('AUTHORIZATION_FORM_PASSWORD_ERROR'); ?>"
				data-error-target="#login-password-item"
			>
		</div>
	</div>

	<div class="form__row">
		<button
			class="login__forget-btn js-entry-button"
			type="button"
			data-slide="2"
			data-type="forgot-pass"
		>
			<?= Loc::getMessage('AUTHORIZATION_FORM_PASSWORD_FORGOT'); ?>
		</button>
	</div>

	<div class="form__footer">
		<button class="btn btn--big login__btn" type="submit">
			<?= Loc::getMessage('AUTHORIZATION_FORM_SEND'); ?>
		</button>
	</div>

</form>
