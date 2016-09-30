<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);

if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
$verticalGrid = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
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
if ($arParams['USE_FILTER'] == 'Y')
{

	if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
	{
		$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
	}
	elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
	{
		$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
	}

	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
	{
		$arCurSection = $obCache->GetVars();
	}
	elseif ($obCache->StartDataCache())
	{
		$arCurSection = array();
		if (Loader::includeModule("iblock"))
		{
			$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID", "NAME", "IBLOCK_SECTION_ID"));

			if(defined("BX_COMP_MANAGED_CACHE"))
			{
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache("/iblock/catalog");

				if ($arCurSection = $dbRes->Fetch())
				{
                    if ($arCurSection['IBLOCK_SECTION_ID'] > 0) {
                        $arCurSection['PARENT_SECTION'] = CIBlockSection::GetById($arCurSection['IBLOCK_SECTION_ID'])->fetch();
                    }
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
				}
				$CACHE_MANAGER->EndTagCache();
			}
			else
			{
				if(!$arCurSection = $dbRes->Fetch())
					$arCurSection = array();
			}
		}
		$obCache->EndDataCache($arCurSection);
	}
	if (!isset($arCurSection))
	{
		$arCurSection = array();
	}?>
<?global $USER_FIELD_MANAGER;
 
$aSection   = CIBlockSection::GetList( array(), array(
    'IBLOCK_ID'   => $arResult['IBLOCK_ID'],
    'CODE'          => $arResult['VARIABLES']['SECTION_CODE'],
) )->Fetch();
 

$aUserField = $USER_FIELD_MANAGER->GetUserFields(
   'IBLOCK_2_SECTION',
    $aSection['ID']
  ); // array
  
if ($aUserField[UF_NAME][VALUE]) {
$arCurSection['NAME']=$aUserField[UF_NAME][VALUE];    
}
	//print_r ($aUserField['UF_CATALOG_TITLE']['VALUE']);
if ($aUserField['UF_CATALOG_TITLE']['VALUE']) {
$APPLICATION->SetPageProperty("title", $aUserField['UF_CATALOG_TITLE']['VALUE']);
	//$APPLICATION->SetTitle($aUserField['UF_CATALOG_TITLE']['VALUE']);


}



?>


    <div class="title">
		<h1><?//= (!empty($arCurSection['PARENT_SECTION'])) ? $arCurSection['PARENT_SECTION']['NAME'] . ': ' . $arCurSection['NAME'] : $arCurSection['NAME'] ?>
        <?=$arCurSection['NAME']?>
        </h1>
    </div>
    <?if ($verticalGrid)
	{
		?><div class="workarea grid2x1">
        <div class="bx_sidebar"><?
	}
	?>

    <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"catalog_left_menu",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => '',//$arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => '',//$arResult["VARIABLES"]["SECTION_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"VIEW_MODE" => $arParams["SECTIONS_V IEW_MODE"],
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
	    "CURRENT_SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
        "CURRENT_SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
    ),
	$component,
	array("HIDE_ICONS" => "Y")
);?>

	<?
	$arSECTION_CODE = array(
			0 => 'moduli',
			1 => 'seriya_seoul',
			2 => 'seriya_epistar',
			3 => 'promyshlenno_ulichnye_moduli',
	);
	
if(!in_array($arResult["VARIABLES"]["SECTION_CODE"],$arSECTION_CODE ) ){
	$arParams2["IBLOCK_TYPE"] = 'offers';
	$arParams2["IBLOCK_ID"] = 4;
	//$arParams["IBLOCK_ID"] = 4; - проверить, чтобы левые каталоги не открывались.
	//$arCurSection2['ID'] = '';
}else{
	$arParams2["IBLOCK_TYPE"] = $arParams["IBLOCK_TYPE"];
	$arParams2["IBLOCK_ID"] = $arParams["IBLOCK_ID"];
}
if($arResult["VARIABLES"]["SECTION_CODE"] == 'draivery') {
	$arParams2["IBLOCK_TYPE"] = 'newcatalog';
	$arParams2["IBLOCK_ID"] = 44;
	$arParams["IBLOCK_TYPE"] = 'newcatalog';
	$arParams["IBLOCK_ID"] = 44;
	$arCurSection['ID'] = 0;
	
	//unset($arResult["VARIABLES"]["SECTION_CODE"]);
	//unset($arResult["VARIABLES"]["SECTION_ID"]);
}
	
//echo "<pre>",print_r($arResult['VARIABLES']['SECTION_CODE']),"</pre>";
 
	$APPLICATION->IncludeComponent(
		"new:catalog.smart.filter",
		"visual_vertical",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SECTION_ID" => $arCurSection['ID'],
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SAVE_IN_SESSION" => "N",
			"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
			"XML_EXPORT" => "Y",
			"arSectModul" => $arResult['VARIABLES']['SECTION_CODE'],
			"SECTION_TITLE" => "NAME",
			"SECTION_DESCRIPTION" => "DESCRIPTION",
			'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
			"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"]
		),
		$component,
		array('HIDE_ICONS' => 'Y')
	);?><?
	if ($verticalGrid)
	{
		?></div><?
	}
}
if ($verticalGrid)
{
	?><div class="bx_content_section"><?
}
?><?
if($arParams["USE_COMPARE"]=="Y")
{
	?><?$APPLICATION->IncludeComponent(
		"bitrix:catalog.compare.list",
		"",
		array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"NAME" => $arParams["COMPARE_NAME"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
			"COMPARE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			'POSITION_FIXED' => isset($arParams['COMPARE_POSITION_FIXED']) ? $arParams['COMPARE_POSITION_FIXED'] : '',
			'POSITION' => isset($arParams['COMPARE_POSITION']) ? $arParams['COMPARE_POSITION'] : ''
		),
		$component,
		array("HIDE_ICONS" => "Y")
	);?><?
}

if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '');
}
else
{
	$basketAction = (isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '');
}
$intSectionID = 0;
//print_r ($arParams["SET_TITLE"]);

?>
<? if (!empty($arCurSection['PARENT_SECTION'])): ?>
    <?if ($aUserField['UF_NAME']['VALUE']) {?>
     <h2><?= $aUserField['UF_NAME']['VALUE'] ?></h2>
    <?} else {?>
    <h2><?= $arCurSection['NAME'] ?></h2>    
    <?}?>
<? endif ?>




<?
global $USER_FIELD_MANAGER;
 
$aSection   = CIBlockSection::GetList( array(), array(
    'IBLOCK_ID'   => $arResult['IBLOCK_ID'],
    'CODE'          => $arResult['VARIABLES']['SECTION_CODE'],
) )->Fetch();
 
if( !$aSection ) {
    throw new Exception( 'Секция не найдена' );
}
 
$aUserField = $USER_FIELD_MANAGER->GetUserFields(
'IBLOCK_2_SECTION',
$aSection['ID']
); // array

if ($aUserField[UF_ANONS][VALUE]) {
echo $aUserField[UF_ANONS][VALUE];
?>
<script type="text/javascript">
$(document).ready(function(){
 $('#descr').click(function(event){
  event.preventDefault();
  var target_top= $('span[name="descr"]').offset().top;
  $('html, body').animate({scrollTop:target_top}, 'slow');
 });
 
});
</script>
<span id="descr" style="cursor: pointer; color: #444444; border-bottom: none; text-decoration: underline;"> Подробнее</span>
<br /><br /><br />
<?}?>



 
<?/*
if(!in_array($arResult["VARIABLES"]["SECTION_CODE"],$arSECTION_CODE ) ){
	$arParams["IBLOCK_TYPE"] = 'offers';
	$arParams["IBLOCK_ID"] = 4;
	//echo "<pre>",print_r($arFilter),"</pre>";
}
*/
$tpl = "new:catalog.section";

if($arResult["VARIABLES"]["SECTION_CODE"] == 'draivery') {

	unset($arResult["VARIABLES"]["SECTION_CODE"]);
	$tpl = "bitrix:catalog.section";
	$arResult["FOLDER"] = '/catalog/draivery/';

	//$APPLICATION->SetTitle("Купить светодиодные драйверы в СПб");
   $APPLICATION->SetTitle($arCurSection['NAME']);

} else {
GLOBAL ${$arParams["FILTER_NAME"]};
	$arrFilter['OFFERS']['>CATALOG_PRICE_1'] = 0;
$arrFilter['>CATALOG_PRICE_1'] = 0;


}


/*
$$arParams["FILTER_NAME"]['>CATALOG_PRICE_1'] = 0;
$$arParams['OFFERS']['>CATALOG_PRICE_1'] = 0;*/


$intSectionID = $APPLICATION->IncludeComponent(
	$tpl,
	"",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"], 
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],

		"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
		"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
		"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
		"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
		"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
		"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
		"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
		"FILTER_NAME" => $arParams["FILTER_NAME"],
		//"CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TYPE" => "N",
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_FILTER" => $arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
		"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
		"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
		"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
		"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
		"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
		"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
		"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE" => $arParams["PAGER_TITLE"],
		"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
		"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
		"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
		'LABEL_PROP' => $arParams['LABEL_PROP'],
		'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
		'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
		'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
		'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
		'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
		'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
		'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
		'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
		'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
		'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
		'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
		'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

		'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
		"ADD_SECTIONS_CHAIN" => "N",
		'ADD_TO_BASKET_ACTION' => $basketAction,
		'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
		'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
	),
	$component
);?><?
$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;
unset($basketAction);
if ($verticalGrid)
{
	?>
    <?if (ModuleManager::isModuleInstalled("sale"))
    {
    $arRecomData = array();
    $recomCacheID = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
    $obCache = new CPHPCache();
    if ($obCache->InitCache(36000, serialize($recomCacheID), "/sale/bestsellers"))
    {
    $arRecomData = $obCache->GetVars();
    }
    elseif ($obCache->StartDataCache())
    {
    if (Loader::includeModule("catalog"))
    {
    $arSKU = CCatalogSKU::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
    $arRecomData['OFFER_IBLOCK_ID'] = (!empty($arSKU) ? $arSKU['IBLOCK_ID'] : 0);
    }
    $obCache->EndDataCache($arRecomData);
    }
    if (!empty($arRecomData))
    {
    if (!isset($arParams['USE_SALE_BESTSELLERS']) || $arParams['USE_SALE_BESTSELLERS'] != 'N')
    {
    ?>
    <?
    global $arrFilter;
    if(!in_array($arResult["VARIABLES"]["SECTION_CODE"],$arSECTION_CODE ) ){
		$arrFilter = array('PROPERTY_BESTSELLER_VALUE' => "Y", );
    }else{
		$arrFilter = array('PROPERTY_SALELEADER_VALUE'=>'да');
    }
    $APPLICATION->IncludeComponent(
    		"new:catalog.section",
    		"bestsellers",
    		array(
    				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
    				"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
    				"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
    				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
    				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
    				"ELEMENT_SORT_FIELD" => 'RAND',//$arParams["ELEMENT_SORT_FIELD"],
    				"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
    				"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
    				"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
    				"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
    				"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
    				"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
    				"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
    				"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
    				"BASKET_URL" => $arParams["BASKET_URL"],
    				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
    				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
    				"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
    				"PRODUCT_QUANTITY_VARIABLE" => '3',//$arParams["PRODUCT_QUANTITY_VARIABLE"],
    				"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
    				"FILTER_NAME" => 'arrFilter',//$arParams["FILTER_NAME"],
    				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
    				"CACHE_TIME" => $arParams["CACHE_TIME"],
    				"CACHE_FILTER" => $arParams["CACHE_FILTER"],
    				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    				"SET_TITLE" => $arParams["SET_TITLE"],
    				"SET_STATUS_404" => $arParams["SET_STATUS_404"],
    				"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
    				"PAGE_ELEMENT_COUNT" => '3',//$arParams["PAGE_ELEMENT_COUNT"],
    				"LINE_ELEMENT_COUNT" => '3',//$arParams["LINE_ELEMENT_COUNT"],
    				"PRICE_CODE" => $arParams["PRICE_CODE"],
    				"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
    				"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
    				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
    				"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
    				"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
    				"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
    				"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
    				"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
    				"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
    				"PAGER_TITLE" => $arParams["PAGER_TITLE"],
    				"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
    				"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
    				"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
    				"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
    				"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
    				"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
    				"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
    				"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
    				"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
    				"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
    				"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
    				"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
    				"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
    				'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
    				'CURRENCY_ID' => $arParams['CURRENCY_ID'],
    				'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
    				'LABEL_PROP' => $arParams['LABEL_PROP'],
    				'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
    				'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
    				'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
    				'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
    				'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
    				'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
    				'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
    				'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
    				'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
    				'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
    				'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
    				'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
    
    				'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
    				"ADD_SECTIONS_CHAIN" => "N",
    				'ADD_TO_BASKET_ACTION' => $basketAction,
    				'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
    				'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare']
    		),
    		$component
    );
 /*
    $APPLICATION->IncludeComponent("bitrix:sale.bestsellers", "", array(
    "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
    "PAGE_ELEMENT_COUNT" => "5",
    "SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
    "PRODUCT_SUBSCRIPTION" => $arParams['PRODUCT_SUBSCRIPTION'],
    "SHOW_NAME" => "Y",
    "SHOW_IMAGE" => "Y",
    "MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
    "MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
    "MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
    "MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
    "LINE_ELEMENT_COUNT" => 5,
    "TEMPLATE_THEME" => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "BY" => array(
        0 => "AMOUNT",
    ),
    "PERIOD" => array(
        0 => "15",
    ),
    "FILTER" => array(
        0 => "CANCELED",
        1 => "ALLOW_DELIVERY",
        2 => "PAYED",
        3 => "DEDUCTED",
        4 => "N",
        5 => "P",
        6 => "F",
    ),
    "FILTER_NAME" => $arParams["FILTER_NAME"],
    "ORDER_FILTER_NAME" => "arOrderFilter",
    "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
    "SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
    "PRICE_CODE" => $arParams["PRICE_CODE"],
    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
    "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
    "CURRENCY_ID" => $arParams["CURRENCY_ID"],
    "BASKET_URL" => $arParams["BASKET_URL"],
    "ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action")."_slb",
    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
    "SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
    "OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"],
    "ADDITIONAL_PICT_PROP_".$arParams['IBLOCK_ID'] => $arParams['ADD_PICT_PROP'],
    "ADDITIONAL_PICT_PROP_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams['OFFER_ADD_PICT_PROP']
),
    $component,
    array("HIDE_ICONS" => "Y")
);*/
}
if (!isset($arParams['USE_BIG_DATA']) || $arParams['USE_BIG_DATA'] != 'N')
{
    ?><?$APPLICATION->IncludeComponent("bitrix:catalog.bigdata.products", "", array(
    "LINE_ELEMENT_COUNT" => 5,
    "TEMPLATE_THEME" => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
    "BASKET_URL" => $arParams["BASKET_URL"],
    "ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action")."_cbdp",
    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
    "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
    "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
    "SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
    "SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
    "PRICE_CODE" => $arParams["PRICE_CODE"],
    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
    "PRODUCT_SUBSCRIPTION" => $arParams['PRODUCT_SUBSCRIPTION'],
    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
    "SHOW_NAME" => "Y",
    "SHOW_IMAGE" => "Y",
    "MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
    "MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
    "MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
    "MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
    "PAGE_ELEMENT_COUNT" => 5,
    "SHOW_FROM_SECTION" => "Y",
    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "DEPTH" => "2",
    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
    "CACHE_TIME" => $arParams["CACHE_TIME"],
    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
    "SHOW_PRODUCTS_".$arParams["IBLOCK_ID"] => "Y",
    "ADDITIONAL_PICT_PROP_".$arParams["IBLOCK_ID"] => $arParams['ADD_PICT_PROP'],
    "LABEL_PROP_".$arParams["IBLOCK_ID"] => $arParams['LABEL_PROP'],
    "HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
    "CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
    "CURRENCY_ID" => $arParams["CURRENCY_ID"],
    "SECTION_ID" => $intSectionID,
    "SECTION_CODE" => "",
    "SECTION_ELEMENT_ID" => "",
    "SECTION_ELEMENT_CODE" => "",
    "PROPERTY_CODE_".$arParams["IBLOCK_ID"] => $arParams["LIST_PROPERTY_CODE"],
    "CART_PROPERTIES_".$arParams["IBLOCK_ID"] => $arParams["PRODUCT_PROPERTIES"],
    "RCM_TYPE" => (isset($arParams['BIG_DATA_RCM_TYPE']) ? $arParams['BIG_DATA_RCM_TYPE'] : ''),
    "OFFER_TREE_PROPS_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams["OFFER_TREE_PROPS"],
    "ADDITIONAL_PICT_PROP_".$arRecomData['OFFER_IBLOCK_ID'] => $arParams['OFFER_ADD_PICT_PROP']
),
    $component,
    array("HIDE_ICONS" => "Y")
);
}
}
}?>
<span name="descr"></span>
<?=$aUserField[UF_DETAIL][VALUE];?>
        </div>
	<div style="clear: both;"></div>
</div><?




}
?>
<?
if($aUserField[UF_CATALOG_TITLE][VALUE] != '') {?>

<script type="text/javascript">
    jQuery(document).ready(function() {
      document.title = '<?=$APPLICATION->ShowTitle(false);?>';
	  document.title = '<?=$aUserField[UF_CATALOG_TITLE][VALUE];?>';
    });
</script>

<? 
$APPLICATION->SetPageProperty('title', $aUserField[UF_CATALOG_TITLE][VALUE]);
}
?>
<?
if($aUserField[UF_CATALOG_DESCRIPT][VALUE] != '') {?>
<?
$value=$aUserField[UF_CATALOG_DESCRIPT][VALUE];
$APPLICATION->ShowMeta("description");
$APPLICATION->SetPageProperty("description", $value);
?>
<? 
}
?>

