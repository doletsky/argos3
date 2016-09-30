<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div id="content">
	<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "eshop_adapt", array(
			"START_FROM" => "1",
			"PATH" => "",
			"SITE_ID" => "-"
		),
		false,
		Array('HIDE_ICONS' => 'Y')
	);?>
	<div class="content_left">
		<!-- Vertical menu -->
		<?$APPLICATION->IncludeComponent("bitrix:menu", "tree_vertical_catalog", array(
			"ROOT_MENU_TYPE" => "left",
			"MENU_CACHE_TYPE" => "A",
			"MENU_CACHE_TIME" => "36000000",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"MENU_CACHE_GET_VARS" => array(
			),
			"MAX_LEVEL" => "1",
			"CHILD_MENU_TYPE" => "left",
			"USE_EXT" => "Y",
			"DELAY" => "N",
			"ALLOW_MULTI_SELECT" => "N",
			),
			false
		);?>
		
		<?
		$UF_SEO_TEXT = '';
		if(CModule::IncludeModule("iblock")){
			//Получение id секции по названию секции
			$ar_result2=CIBlockSection::GetList(Array("SORT"=>"­­ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE"=>$arResult["VARIABLES"]['SECTION_CODE']));
			if($res2=$ar_result2->GetNext()){
				$sec_id=$res2['ID'];				
			}
		}
		//Получение значений пользовательских полей для выбора шаблона
		$arFilter=array("IBLOCK_ID"=>$arParams['IBLOCK_ID'],"ID"=>$sec_id);//id инфоблока и id секции
		$rsResult=CIBlockSection::GetList(array("SORT"=>"ASC"),$arFilter,false,$arSelect=array("UF_*"));
		while($ar=$rsResult->GetNext()) 
		{
			$UF_SEO_TEXT = $ar['UF_SEO_TEXT'];
			if($ar['UF_CATALOG_LIST_VIEW']!='')//для шаблона каталога с Сериями
			{
				$CATALOG_LIST_VIEW.=htmlspecialchars_decode($ar['UF_CATALOG_LIST_VIEW']);				
				$rsEnum = CUserFieldEnum::GetList(array(), array("ID" =>$CATALOG_LIST_VIEW)); // $CATALOG_LIST_VIEW - возвращаемый ID значения 
				$arEnum = $rsEnum->GetNext(); 
				$catalog_list_view=$arEnum['XML_ID'];
			}
		}
		if($catalog_list_view=='series')
			$INCLUDE_SUBSECTIONS='YES';
		else
		{
			$INCLUDE_SUBSECTIONS='NO';
			$catalog_list_view="no_series";
		}
		?>
		
		<?
		/*if(CModule::IncludeModule("iblock")){
			//Получение id секции по названию секции
			$ar_result2=CIBlockSection::GetList(Array("SORT"=>"­­ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE"=>$arResult["VARIABLES"]['SECTION_CODE']));
			if($res2=$ar_result2->GetNext()){
				$sec_id=$res2['ID'];
			}
		}*/
		
		$catalog_view="";//other
		//Получение значений пользовательских полей для выбора шаблона
		$arFilter=array("IBLOCK_ID"=>$arParams['IBLOCK_ID'],"ID"=>$sec_id);//id инфоблока и id секции
		$rsResult=CIBlockSection::GetList(array("SORT"=>"ASC"),$arFilter,false,$arSelect=array("UF_*"));
		while($ar=$rsResult->GetNext()) 
		 {  
		  
			if($ar['UF_CATALOG_VIEW']!='')//для шаблона каталога
			{
				$CATALOG_VIEW.=htmlspecialchars_decode($ar['UF_CATALOG_VIEW']);				
				$rsEnum = CUserFieldEnum::GetList(array(), array("ID" =>$CATALOG_VIEW)); // $CATALOG_VIEW - возвращаемый ID значения 
				$arEnum = $rsEnum->GetNext(); 
				$catalog_view=$arEnum['XML_ID'];
			}
			/*if($ar['UF_CARD_ITEMS_VIEW']!='')//для шаблона карточки товара
			{
				$CARD_ITEMS_VIEW.=htmlspecialchars_decode($ar['UF_CARD_ITEMS_VIEW']);				
				$rsEnum = CUserFieldEnum::GetList(array(), array("ID" =>$CARD_ITEMS_VIEW)); // $CARD_ITEMS_VIEW - возвращаемый ID значения 
				$arEnum = $rsEnum->GetNext(); 
				$card_items_view=$arEnum['XML_ID'];
			}*/
		}
		?>
		
		<?//Умный фильтр
		if($catalog_view!='' && $catalog_view!='other') {
		if (CModule::IncludeModule("iblock") && COption::GetOptionString("eshop", "catalogSmartFilter", "Y", SITE_ID)=="Y")
		{
			$arFilter = array(
				"ACTIVE" => "Y",
				"GLOBAL_ACTIVE" => "Y",
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			);
			if(strlen($arResult["VARIABLES"]["SECTION_CODE"])>0)
			{
				$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
			}
			elseif($arResult["VARIABLES"]["SECTION_ID"]>0)
			{
				$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
			}
				
			$obCache = new CPHPCache;
			if($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
			{
				$arCurSection = $obCache->GetVars();
			}
			else
			{
				$arCurSection = array();
				$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));
				$dbRes = new CIBlockResult($dbRes);

				if(defined("BX_COMP_MANAGED_CACHE"))
				{
					global $CACHE_MANAGER;
					$CACHE_MANAGER->StartTagCache("/iblock/catalog");

					if ($arCurSection = $dbRes->GetNext())
					{
						$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
					}
					$CACHE_MANAGER->EndTagCache();
				}
				else
				{
					if(!$arCurSection = $dbRes->GetNext())
						$arCurSection = array();
				}

				$obCache->EndDataCache($arCurSection);
			}
			
			$smartFilterTemplate = COption::GetOptionString("main", "wizard_template_id", "eshop_vertical", SITE_ID) == "eshop_horizontal" ? "sidebar" : "";
			?>
			
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter",
				"filter_new",
				Array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => $arCurSection["ID"],
					"FILTER_NAME" => "arrFilter",
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "36000000",
					"CACHE_NOTES" => "",
					"CACHE_GROUPS" => "Y",
					"SAVE_IN_SESSION" => "N",
					//"INSTANT_RELOAD" => "Y",
					//"AJAX_MODE" => "Y",
				),
				false,
				Array('HIDE_ICONS' => 'Y')
			);?>
		<?
		}
		}
		?>
		<?include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."sidebar.php");?>
	</div>
		
	<div class="content_right">
    
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			$catalog_list_view,
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
				"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
				"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
                "SECTION_USER_FIELDS" => array("UF_ONLY_CATALOG"),
				"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"]
			),
			$component
		);?>		
		
		<?
		if(CModule::IncludeModule("iblock")){
			//Получение id секции по названию секции
			$ar_result_desc=CIBlockSection::GetList(Array("SORT"=>"­­ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "ID"=>$sec_id));
			if($res_desc=$ar_result_desc->GetNext())
			{
			?>
				<div class='description_catalog'><?=$res_desc['DESCRIPTION']?></div>
			<?
			}
		}
		?>
		
		<?
		//--------------------------- Механизм сохранения в COOKIE количества посещений каждого родительского раздела каталога текущим пользователем -------------------------------//
		//Получаем массив главных разделов
		$arr_main_cat=array();//Массив главных разделов
		$arSelect = Array("NAME", "DEPTH_LEVEL", "ID", "ACTIVE", "IBLOCK_ID");
		$ar_main_cat=CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y", "DEPTH_LEVEL" => "1"), $arSelect);
		while($res_main_cat=$ar_main_cat->GetNext())
		{
		  
			$arr_main_cat[]=$res_main_cat['ID'];
		}
		//Проверяем, к какому из главных разделов относится текущий раздел
		$rsPath = GetIBlockSectionPath($arParams["IBLOCK_ID"], $sec_id);
		$parent_id='';//название категории
		while($arPath=$rsPath->GetNext()) {
			if (in_array($arPath["ID"], $arr_main_cat))//Получаем id родителя
			{
				$parent_id='parent_id_'.$arPath["ID"];//ID родителя
			}
		}
		if(!isset($_COOKIE[$parent_id]))
		{
			$visits = 1;//количество просмотров страницы каталога
			setcookie($parent_id, $visits, time()+7*24*60*60, " /", "");//устанавливаем на неделю в корневую директорию
		}
		else
		{
			$visits = $_COOKIE[$parent_id]+1;//количество просмотров страницы каталога
			setcookie($parent_id, $visits, time()+7*24*60*60, " /", "");//устанавливаем на неделю в корневую директорию
		}
		//echo $visits;//количество просмотров страницы каталога
		//echo $parent_id;//название категории
		?>
		
		<?
		if($catalog_view == '') {
			$catalog_view = 'empty';
		}
        
		$intSectionID = 0;
		$intSectionID = $APPLICATION->IncludeComponent(
			"bitrix:catalog.section",
			$catalog_view,//подключаем нужный шаблон
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
				"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
				"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
				"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
				"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
				"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
				"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
				"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
				"INCLUDE_SUBSECTIONS" => $INCLUDE_SUBSECTIONS,//$arParams["INCLUDE_SUBSECTIONS"],
				"BASKET_URL" => $arParams["BASKET_URL"],
				"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
				"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
				"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
				"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
				"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
				"FILTER_NAME" => $arParams["FILTER_NAME"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
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
                "SECTION_USER_FIELDS" => array("UF_ONLY_CATALOG"),

				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
				"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
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

				"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
				"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
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
			),
			$component
		);
		//}
		?>
		<?php if($UF_SEO_TEXT):?>
		<div class="bottom-text">
			<?php echo $UF_SEO_TEXT?>
		</div>
		<?php endif;?>
	</div>
	<div class="clear"></div>
</div>

<?/*

<?
if (!$arParams["FILTER_VIEW_MODE"])
	$arParams["FILTER_VIEW_MODE"] = "VERTICAL";

if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL"):?>
<div class="workarea grid2x1">
<?endif?>
<?
if ('Y' == $arParams['USE_FILTER'])
{
	if (CModule::IncludeModule("iblock"))
	{
		$arFilter = array(
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ACTIVE" => "Y",
			"GLOBAL_ACTIVE" => "Y",
		);
		if(0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
		{
			$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
		}
		elseif('' != $arResult["VARIABLES"]["SECTION_CODE"])
		{
			$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
		}

		$obCache = new CPHPCache();
		if($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
		{
			$arCurSection = $obCache->GetVars();
		}
		else
		{
			$arCurSection = array();
			$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

			if(defined("BX_COMP_MANAGED_CACHE"))
			{
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache("/iblock/catalog");

				if ($arCurSection = $dbRes->GetNext())
				{
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
				}
				$CACHE_MANAGER->EndTagCache();
			}
			else
			{
				if(!$arCurSection = $dbRes->GetNext())
					$arCurSection = array();
			}

			$obCache->EndDataCache($arCurSection);
		}
	}
?>
<?if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL"):?>
	<div class="bx_sidebar">
<?endif?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.smart.filter",
		"visual_".($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL" ? "horizontal" : "vertical"),
		Array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"SECTION_ID" => $arCurSection['ID'],
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_NOTES" => "",
			"CACHE_GROUPS" => "Y",
			"SAVE_IN_SESSION" => "N",
			"XML_EXPORT" => "Y",
			"SECTION_TITLE" => "NAME",
			"SECTION_DESCRIPTION" => "DESCRIPTION"
		),
		$component,
		array('HIDE_ICONS' => 'Y')
	);?>
<?if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL"):?>
	</div>
<?endif?>
<?
}
?>
<?if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL"):?>
	<div class="bx_content_section">
<?endif?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"]
	),
	$component
);?><?
if($arParams["USE_COMPARE"]=="Y")
{?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.compare.list",
	"",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"NAME" => $arParams["COMPARE_NAME"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		"COMPARE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
	),
	$component
);?><?
}

$intSectionID = 0;
?><?$intSectionID = $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
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
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
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

		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
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
	),
	$component
);
?>
<?if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL"):?>
	</div>
	<div style="clear: both;"></div>
</div>
<?endif?>

*/?>