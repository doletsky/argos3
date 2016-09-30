<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//setting section
//***********************************
?>
<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
<?echo bitrix_sessid_post();?>
<div class="title"><?echo GetMessage("subscr_title_settings")?></div>
<div class="sub_info">
	<p><?echo GetMessage("subscr_settings_note1")?></p>
	<p><?echo GetMessage("subscr_settings_note2")?></p>
</div>
<p>
	<div class="title_req"><?echo GetMessage("subscr_email")?><span class="starrequired">*</span></div>
	<input class="input_style" type="text" name="EMAIL" value="<?=$arResult["SUBSCRIPTION"]["EMAIL"]!=""?$arResult["SUBSCRIPTION"]["EMAIL"]:$arResult["REQUEST"]["EMAIL"];?>" size="30" maxlength="255" />
</p>
<p>
	<div class="title_req"><?echo GetMessage("subscr_rub")?><span class="starrequired">*</span></div>
	<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
		<label><input type="checkbox" name="RUB_ID[]" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> /><?=$itemValue["NAME"]?></label><br />
	<?endforeach;?>
</p>
<p>
	<div class="title_req"><?echo GetMessage("subscr_fmt")?></div>
	<label><input type="radio" name="FORMAT" value="text"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "text") echo " checked"?> /><?echo GetMessage("subscr_text")?></label>&nbsp;/&nbsp;<label><input type="radio" name="FORMAT" value="html"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "html") echo " checked"?> />HTML</label>
</p>
<?foreach ($arResult["USER_PROPERTIES"] as $FIELD_NAME => $arUserField):?>
	<?if($arUserField['MANDATORY']=='Y'){
		$req=true;	
	}else{
		$req=false;
	}
	?>
	<div class="title_req">
		<?echo $arUserField["EDIT_FORM_LABEL"]?>:<?echo $req ? '<span class="starrequired">*</span>' : ''?>
	</div>
	<div>
		<?$APPLICATION->IncludeComponent( 
		"bitrix:system.field.edit", 
		$arUserField["USER_TYPE"]["USER_TYPE_ID"], 
		array(
			"bVarsFromForm" => false,
			"arUserField" => $arUserField
		),
		null,
		array("HIDE_ICONS"=>"Y"));?>
	</div>
<?endforeach;?>
<input class="submit_style" type="submit" name="Save" value="<?echo ($arResult["ID"] > 0? GetMessage("subscr_upd"):GetMessage("subscr_add"))?>" />
<input class="submit_style" type="reset" value="<?echo GetMessage("subscr_reset")?>" name="reset" />
	
<?/*
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="data-table">
<thead><tr><td colspan="2"><span class="bold"><?echo GetMessage("subscr_title_settings")?></span></td></tr></thead>
<tr valign="top">
	<td width="40%">
		<p><?echo GetMessage("subscr_email")?><span class="starrequired">*</span><br />
		<input class="input_style" type="text" name="EMAIL" value="<?=$arResult["SUBSCRIPTION"]["EMAIL"]!=""?$arResult["SUBSCRIPTION"]["EMAIL"]:$arResult["REQUEST"]["EMAIL"];?>" size="30" maxlength="255" /></p>
		<p><?echo GetMessage("subscr_rub")?><span class="starrequired">*</span><br />
		<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
			<label><input type="checkbox" name="RUB_ID[]" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> /><?=$itemValue["NAME"]?></label><br />
		<?endforeach;?></p>
		<p><?echo GetMessage("subscr_fmt")?><br />
		<label><input type="radio" name="FORMAT" value="text"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "text") echo " checked"?> /><?echo GetMessage("subscr_text")?></label>&nbsp;/&nbsp;<label><input type="radio" name="FORMAT" value="html"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "html") echo " checked"?> />HTML</label></p>
		<?foreach ($arResult["USER_PROPERTIES"] as $FIELD_NAME => $arUserField):?>
		<p><?echo $arUserField["EDIT_FORM_LABEL"]?>:</p>
		<p>
		<?$APPLICATION->IncludeComponent( 
		"bitrix:system.field.edit", 
		$arUserField["USER_TYPE"]["USER_TYPE_ID"], 
		array(
			"bVarsFromForm" => false,
			"arUserField" => $arUserField
		),
		null,
		array("HIDE_ICONS"=>"Y"));?>
		</p>
		<?endforeach;?> 
	</td>
	<td width="60%">
		<p><?echo GetMessage("subscr_settings_note1")?></p>
		<p><?echo GetMessage("subscr_settings_note2")?></p>
	</td>
</tr>
<tfoot><tr><td colspan="2">
	<input type="submit" name="Save" value="<?echo ($arResult["ID"] > 0? GetMessage("subscr_upd"):GetMessage("subscr_add"))?>" />
	<input type="reset" value="<?echo GetMessage("subscr_reset")?>" name="reset" />
</td></tr></tfoot>
</table>
*/?>

<input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
<?if($_REQUEST["register"] == "YES"):?>
	<input type="hidden" name="register" value="YES" />
<?endif;?>
<?if($_REQUEST["authorize"]=="YES"):?>
	<input type="hidden" name="authorize" value="YES" />
<?endif;?>
</form>
<br />
