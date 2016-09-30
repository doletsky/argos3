<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="search-form">
<form action="<?=$arResult["FORM_ACTION"]?>">
	<?if($arParams["USE_SUGGEST"] === "Y"):?>
		<?$APPLICATION->IncludeComponent(
				"bitrix:search.suggest.input",
				"",
				array(
					"NAME" => "q",
					"VALUE" => "",
					"INPUT_SIZE" => 15,
					"DROPDOWN_SIZE" => 10,
				),
				$component, array("HIDE_ICONS" => "Y")
		);?>
	<?else:?>
		<input name="q" id="title-search-input" type="text" value="" placeholder="<?=GetMessage("SEARCH_NEWS")?>">
	<?endif;?>
	<input name="s" type="submit" id="search_sub" value="">
	<div class="clear"></div>
</form>
</div>