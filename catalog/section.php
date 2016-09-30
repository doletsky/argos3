<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<div class="whole_page" id="content">
<?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb", 
	"eshop_adapt", 
	array(
		"START_FROM" => "0",
		"PATH" => "/",
		"SITE_ID" => "s1"
	),
	false
); ?>
 
<?
/*
$arSECTION_CODE = array(
		0 => 'moduli',
		1 => 'seriya_seoul',
		2 => 'seriya_epistar',
		3 => 'promyshlenno_ulichnye_moduli',
);
if(!in_array($arResult["VARIABLES"]["SECTION_CODE"],$arSECTION_CODE ) ){
	$arParams2["IBLOCK_TYPE"] = 'offers';
	$arParams2["IBLOCK_ID"] = 4;
	//$arResult["URL_TEMPLATES"]["element"] = $arResult["VARIABLES"]["SECTION_CODE"].'/#ELEMENT_CODE#/';
	//$arResult["VARIABLES"]["SECTION_CODE"] = $_REQUEST['SECTION_CODE'];
}
$arFilter = array(
		"IBLOCK_TYPE" => $arParams2["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams2["IBLOCK_ID"],
		"CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		//"PROPERTY_MODEL" => '1059',

);*/

?>
    <div class="title">
        <h1><?=$arResult['NAME'] ?></h1>
    </div>
	<div class="workarea grid2x1">
        <div class="bx_sidebar">
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"catalog_left_menu", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
		"COUNT_ELEMENTS" => "N",
		"TOP_DEPTH" => "3",
		"SECTION_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SECTION_URL" => "/catalog/",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"VIEW_MODE" => "LIST",
		"SHOW_PARENT_NAME" => "N",
		"HIDE_SECTION_NAME" => "Y"
	),
	false
);?>

<?
	$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter", 
	"visual_vertical", 
	array(
		"IBLOCK_TYPE" => "offers",
		"IBLOCK_ID" => "4",
		"SAVE_IN_SESSION" => "N",
		"FILTER_VIEW_MODE" => "VERTICAL",
		"XML_EXPORT" => "N",
		"SECTION_TITLE" => "NAME",
		"SECTION_DESCRIPTION" => "DESCRIPTION",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"INSTANT_RELOAD" => "N",
		"PRICE_CODE" => array(
		)
	),
	false
);?>
		</div>
<div class="bx_content_section">

<? /*if (!empty($arCurSection['PARENT_SECTION'])): ?>
    <h2><?= $arCurSection['NAME'] ?></h2>
<? endif */?>

<?//echo "<pre>",print_r($arResult["VARIABLES"]["SECTION_CODE"]),"</pre>";?>

<?
if(!in_array($arResult["VARIABLES"]["SECTION_CODE"],$arSECTION_CODE ) ){
	//$arParams["IBLOCK_TYPE"] = 'offers';
	//$arParams["IBLOCK_ID"] = 4;

	//$arResult["URL_TEMPLATES"]["element"] = $arResult["VARIABLES"]["SECTION_CODE"].'/#ELEMENT_CODE#/';
	//$arResult["VARIABLES"]["SECTION_CODE"] = $_REQUEST['SECTION_CODE'];
	
/* 	$arParams['FILTER_OFFERS_FIELD_CODE'] = array(
		0 => 'ID',
		1 => 'PREVIEW_PICTURE',
		2 => 'DETAIL_PICTURE',
	); */

	//echo "<pre>",print_r($arFilter),"</pre>";
	//unset($arResult["VARIABLES"]["SECTION_CODE"]);
}

$APPLICATION->IncludeComponent(
	"new:catalog.section", 
	".default", 
	array(
		"IBLOCK_TYPE" => "offers",
		"IBLOCK_ID" => "4",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => $_REQUEST["SECTION_CODE"],
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arrFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "N",
		"HIDE_NOT_AVAILABLE" => "N",
		"PAGE_ELEMENT_COUNT" => "30",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "5",
		"TEMPLATE_THEME" => "blue",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_BTN_COMPARE" => "Сравнить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"BROWSER_TITLE" => "-",
		"SET_META_KEYWORDS" => "Y",
		"META_KEYWORDS" => "-",
		"SET_META_DESCRIPTION" => "Y",
		"META_DESCRIPTION" => "-",
		"ADD_SECTIONS_CHAIN" => "N",
		"SET_STATUS_404" => "N",
		"CACHE_FILTER" => "N",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRICE_CODE" => array(
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"ADD_TO_BASKET_ACTION" => "ADD",
		"DISPLAY_COMPARE" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity"
	),
	false
);?>

    <?$APPLICATION->IncludeComponent(
	"bitrix:sale.bestsellers", 
	".default", 
	array(
		"PAGE_ELEMENT_COUNT" => "5",
		"SHOW_NAME" => "Y",
		"SHOW_IMAGE" => "Y",
		"LINE_ELEMENT_COUNT" => "5",
		"BY" => "AMOUNT",
		"PERIOD" => "",
		"FILTER" => array(
			0 => "CANCELED",
			1 => "ALLOW_DELIVERY",
			2 => "PAYED",
			3 => "DEDUCTED",
			4 => "N",
			5 => "P",
			6 => "F",
		),
		"HIDE_NOT_AVAILABLE" => "Y",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"PRODUCT_SUBSCRIPTION" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"TEMPLATE_THEME" => "blue",
		"DETAIL_URL" => "catalog/#SECTION_CODE#/#ELEMENT_CODE#",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "86400",
		"SHOW_OLD_PRICE" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"SHOW_PRODUCTS_2" => "N",
		"SHOW_PRODUCTS_10" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"DISPLAY_COMPARE" => "N",
		"PROPERTY_CODE_2" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_2" => array(
			0 => "",
			1 => "",
		),
		"ADDITIONAL_PICT_PROP_2" => "FILE_3D",
		"LABEL_PROP_2" => "-",
		"PROPERTY_CODE_4" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_4" => array(
			0 => "",
			1 => "",
		),
		"ADDITIONAL_PICT_PROP_4" => "FILE_3D",
		"OFFER_TREE_PROPS_4" => array(
			0 => "-",
		),
		"PROPERTY_CODE_10" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_10" => array(
			0 => "",
			1 => "",
		),
		"ADDITIONAL_PICT_PROP_10" => "FILE_3D",
		"LABEL_PROP_10" => "-",
		"PROPERTY_CODE_11" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_11" => array(
			0 => "",
			1 => "",
		),
		"ADDITIONAL_PICT_PROP_11" => "FILE_3D",
		"OFFER_TREE_PROPS_11" => array(
			0 => "-",
		)
	),
	false
);?>

        </div>
	<div style="clear: both;"></div>
</div>

</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>