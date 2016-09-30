<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if ($arParams["CONFIRM_UNSUBSCIBE"]=="Y" && $arResult["ERROR"]==""):?>

	<?= GetMessage("ASD_SUCCESS_UNSUBSCRIBE_L")?>

<?elseif ($arResult["ERROR"] != ""):?>

	<?ShowError($arResult["ERROR"]);?>

<?else:?>

	<p><?= GetMessage("ASD_CONFIRM_TEXT", array("#EMAIL#" => $arResult["EMAIL"], "#CONFIRM_URL#" => $arParams["CONFIRMED_URL"]))?></p>
	<p><?= GetMessage("ASD_EDIT_TEXT", array("#EMAIL#" => $arResult["EMAIL"], "#EDIT_URL#" => $arParams["EDIT_URL"]))?></p>

<?endif?>