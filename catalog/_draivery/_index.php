<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Продукция");
$filterView = (COption::GetOptionString("main", "wizard_template_id", "eshop_adapt_horizontal", SITE_ID) == "eshop_adapt_vertical" ? "HORIZONTAL" : "VERTICAL");
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
<?php
$arParams = array(
		"IBLOCK_TYPE" => "newcatalog",
		"IBLOCK_ID" => "44",
		"HIDE_NOT_AVAILABLE" => "N",
		"BASKET_URL" => "/personal/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/catalog/draivery/",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "Y",
		"SET_STATUS_404" => "Y",
		"USE_ELEMENT_COUNTER" => "Y",
		"USE_FILTER" => "Y",
		"FILTER_NAME" => "",
		"FILTER_VIEW_MODE" => "VERTICAL",
		"FILTER_FIELD_CODE" => array(
			0 => "DRIVER_CLASS",
			1 => "DEVIANT_PACKING",
			2 => "MAX_POWER",
			3 => "STABILIZING",
			4 => "DIMMIROVANIYE",
			5 => "PROGRAMMABLE",
			6 => "CURRENT_ADJUSTMENT",
			7 => "STABILIZATION_TYPE",
			8 => "DEGREE_OF_PROTECTION",
			9 => "TYPE",
			10 => "TYPE_CONNECT",
			11 => "TYPES_PROTECTION",
			12 => "LEVEL_RIPPLE",
			13 => "FLAG_DREGIM",
			14 => "FLAG_CE",
			15 => "FLAG_EMS",
			16 => "",
		),
		"FILTER_PROPERTY_CODE" => array(
			0 => "DRIVER_CLASS",
			1 => "DEVIANT_PACKING",
			2 => "MAX_POWER",
			3 => "STABILIZING",
			4 => "DIMMIROVANIYE",
			5 => "PROGRAMMABLE",
			6 => "CURRENT_ADJUSTMENT",
			7 => "STABILIZATION_TYPE",
			8 => "DEGREE_OF_PROTECTION",
			9 => "TYPE",
			10 => "TYPE_CONNECT",
			11 => "TYPES_PROTECTION",
			12 => "LEVEL_RIPPLE",
			13 => "FLAG_DREGIM",
			14 => "FLAG_CE",
			15 => "FLAG_EMS",
			16 => "",
		),
		"FILTER_PRICE_CODE" => array(
			0 => "BASE",
		),
		"FILTER_OFFERS_FIELD_CODE" => "",
		"FILTER_OFFERS_PROPERTY_CODE" => "",
		"USE_REVIEW" => "Y",
		"MESSAGES_PER_PAGE" => "10",
		"USE_CAPTCHA" => "Y",
		"REVIEW_AJAX_POST" => "Y",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"FORUM_ID" => "1",
		"URL_TEMPLATES_READ" => "",
		"SHOW_LINK_TO_FORUM" => "Y",
		"POST_FIRST_MESSAGE" => "N",
		"USE_COMPARE" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_PROPERTIES" => array(
			0 => "CML2_LINK",
		),
		"USE_PRODUCT_QUANTITY" => "Y",
		"CONVERT_CURRENCY" => "N",
		"CURRENCY_ID" => "RUB",
		"QUANTITY_FLOAT" => "N",
		"OFFERS_CART_PROPERTIES" => "",
		"SHOW_TOP_ELEMENTS" => "N",
		"SECTION_COUNT_ELEMENTS" => "N",
		"SECTION_TOP_DEPTH" => "3",
		"SECTIONS_VIEW_MODE" => "LIST",
		"SECTIONS_SHOW_PARENT_NAME" => "N",
		"PAGE_ELEMENT_COUNT" => "15",
		"LINE_ELEMENT_COUNT" => "3",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "NEWPRODUCT",
			2 => "SALELEADER",
			3 => "SPECIALOFFER",
			4 => "",
		),
		"INCLUDE_SUBSECTIONS" => "Y",
		"LIST_META_KEYWORDS" => "-",
		"LIST_META_DESCRIPTION" => "-",
		"LIST_BROWSER_TITLE" => "-",
		"LIST_OFFERS_FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "TAGS",
			5 => "SORT",
			6 => "PREVIEW_TEXT",
			7 => "PREVIEW_PICTURE",
			8 => "DETAIL_TEXT",
			9 => "DETAIL_PICTURE",
			10 => "DATE_ACTIVE_FROM",
			11 => "ACTIVE_FROM",
			12 => "DATE_ACTIVE_TO",
			13 => "ACTIVE_TO",
			14 => "SHOW_COUNTER",
			15 => "SHOW_COUNTER_START",
			16 => "IBLOCK_TYPE_ID",
			17 => "IBLOCK_ID",
			18 => "IBLOCK_CODE",
			19 => "IBLOCK_NAME",
			20 => "IBLOCK_EXTERNAL_ID",
			21 => "DATE_CREATE",
			22 => "CREATED_BY",
			23 => "CREATED_USER_NAME",
			24 => "TIMESTAMP_X",
			25 => "MODIFIED_BY",
			26 => "USER_NAME",
			27 => "",
		),
		"LIST_OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "SIZES_SHOES",
			2 => "SIZES_CLOTHES",
			3 => "COLOR_REF",
			4 => "MORE_PHOTO",
			5 => "ARTNUMBER",
			6 => "",
		),
		"LIST_OFFERS_LIMIT" => "0",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "CML2_LINK",
			1 => "DRIVER_CLASS",
			2 => "DEVIANT_PACKING",
			3 => "MAX_POWER",
			4 => "STABILIZING",
			5 => "DIMMIROVANIYE",
			6 => "PROGRAMMABLE",
			7 => "CURRENT_ADJUSTMENT",
			8 => "STABILIZATION_TYPE",
			9 => "DEGREE_OF_PROTECTION",
			10 => "TYPE",
			11 => "TYPE_CONNECT",
			12 => "TYPES_PROTECTION",
			13 => "LEVEL_RIPPLE",
			14 => "FLAG_DREGIM",
			15 => "FLAG_CE",
			16 => "FLAG_EMS",
			17 => "MANUFACTURER",
			18 => "MATERIAL",
			19 => "",
		),
		"DETAIL_META_KEYWORDS" => "-",
		"DETAIL_META_DESCRIPTION" => "-",
		"DETAIL_BROWSER_TITLE" => "-",
		"DETAIL_OFFERS_FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "TAGS",
			5 => "SORT",
			6 => "PREVIEW_TEXT",
			7 => "PREVIEW_PICTURE",
			8 => "DETAIL_TEXT",
			9 => "DETAIL_PICTURE",
			10 => "DATE_ACTIVE_FROM",
			11 => "ACTIVE_FROM",
			12 => "DATE_ACTIVE_TO",
			13 => "ACTIVE_TO",
			14 => "SHOW_COUNTER",
			15 => "SHOW_COUNTER_START",
			16 => "IBLOCK_TYPE_ID",
			17 => "IBLOCK_ID",
			18 => "IBLOCK_CODE",
			19 => "IBLOCK_NAME",
			20 => "IBLOCK_EXTERNAL_ID",
			21 => "DATE_CREATE",
			22 => "CREATED_BY",
			23 => "CREATED_USER_NAME",
			24 => "TIMESTAMP_X",
			25 => "MODIFIED_BY",
			26 => "USER_NAME",
			27 => "",
		),
		"DETAIL_OFFERS_PROPERTY_CODE" => array(

		),
		"LINK_IBLOCK_TYPE" => "newcatalog",
		"LINK_IBLOCK_ID" => "",
		"LINK_PROPERTY_SID" => "",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"USE_ALSO_BUY" => "Y",
		"ALSO_BUY_ELEMENT_COUNT" => "3",
		"ALSO_BUY_MIN_BUYES" => "2",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_TEMPLATE" => "arrows",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
		"PAGER_SHOW_ALL" => "N",
		"ADD_PICT_PROP" => "MULTIMEDIA_PHOTOS",
		"LABEL_PROP" => "-",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => "",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_OLD_PRICE" => "Y",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_COMPARE" => "Сравнение",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"DETAIL_USE_VOTE_RATING" => "Y",
		"DETAIL_VOTE_DISPLAY_AS_RATING" => "rating",
		"DETAIL_USE_COMMENTS" => "Y",
		"DETAIL_BLOG_USE" => "Y",
		"DETAIL_VK_USE" => "N",
		"DETAIL_FB_USE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"USE_STORE" => "Y",
		"USE_STORE_PHONE" => "Y",
		"USE_STORE_SCHEDULE" => "Y",
		"USE_MIN_AMOUNT" => "N",
		"STORE_PATH" => "/store/#store_id#",
		"MAIN_TITLE" => "Наличие на складах",
		"MIN_AMOUNT" => "10",
		"DETAIL_BRAND_USE" => "Y",
		"DETAIL_BRAND_PROP_CODE" => array(
			0 => "",
			1 => "BRAND_REF",
			2 => "",
		),
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "Y",
		"TEMPLATE_THEME" => "blue",
		"COMMON_SHOW_CLOSE_POPUP" => "N",
		"DETAIL_SHOW_MAX_QUANTITY" => "N",
		"DETAIL_BLOG_URL" => "catalog_comments",
		"DETAIL_BLOG_EMAIL_NOTIFY" => "N",
		"DETAIL_FB_APP_ID" => "",
		"USE_SALE_BESTSELLERS" => "Y",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"USE_COMMON_SETTINGS_BASKET_POPUP" => "N",
		"TOP_ADD_TO_BASKET_ACTION" => "ADD",
		"SECTION_ADD_TO_BASKET_ACTION" => "ADD",
		"DETAIL_ADD_TO_BASKET_ACTION" => array(
			0 => "BUY",
		),
		"DETAIL_SHOW_BASIS_PRICE" => "Y",
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
		"DETAIL_DISPLAY_NAME" => "Y",
		"DETAIL_DETAIL_PICTURE_MODE" => "POPUP",
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
		"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E",
		"STORES" => array(
			0 => "1",
		),
		"USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SHOW_EMPTY_STORE" => "Y",
		"SHOW_GENERAL_STORE_INFORMATION" => "N",
		"USE_BIG_DATA" => "N",
		"BIG_DATA_RCM_TYPE" => "bestsell",
		"COMMON_ADD_TO_BASKET_ACTION" => "ADD",
		"SEF_URL_TEMPLATES" => array(
			"sections" => "/catalog/draivery/",
			"section" => "#SECTION_CODE#/",
			"element" => "#SECTION_CODE#/#ELEMENT_CODE#/",
			"compare" => "compare/",
		)
	);
?>
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
	</div>
	<div class="clear"></div>
</div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>