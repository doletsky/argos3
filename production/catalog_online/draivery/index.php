<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Каталог светодиодных драйверов. Выбор мощности. Прайс. Гарантия три года.");
$APPLICATION->SetPageProperty("keywords", "купить драйвер для светодиодного прожектора светильника ламп светодиодные led драйверы для светодиода управляющий led driver модуль со встроенным драйвером источники питания блок питания с функцией диммирования уличный спб мск нижний новгород казань краснодар екатеринбург новосибирск самара");
$APPLICATION->SetPageProperty("title", "Купить светодиодные драйверы (LED driver) в СПб, блоки и источники питания для светодиодного светильника с диммированием уличные");
$APPLICATION->SetTitle("Cветодиодные драйверы");
?> 
<div id="content"> 	<?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"eshop_adapt",
	Array(
		"START_FROM" => "1",
		"PATH" => "",
		"SITE_ID" => "-"
	),
false,
Array(
	'HIDE_ICONS' => 'Y'
)
);?> 	
  <div class="content_left"> 		
<!-- Vertical menu -->
 		<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"tree_vertical_catalog",
	Array(
		"ROOT_MENU_TYPE" => "left",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	)
);?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter",
	"filter_new",
	Array(
		"IBLOCK_TYPE" => "newcatalog",
		"IBLOCK_ID" => 44,
		"SECTION_ID" => 0,
		"FILTER_NAME" => "arrFilter",
		"PRICE_CODE" => array(0=>"BASE",),
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_NOTES" => "",
		"CACHE_GROUPS" => "Y",
		"SAVE_IN_SESSION" => "N"
	),
false,
Array(
	'HIDE_ICONS' => 'Y'
)
);?> 		<?include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."sidebar.php");?> 	</div>
 	
  <div class="content_right"> 	
    <h1>Cветодиодные драйверы</h1>
   	<?php $APPLICATION->AddChainItem("Комплектация для производства светодиодных светильников", "/production/catalog_online/svetodiodnye/");?> 		<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"drivers",
	Array(
		"VIEW_MODE" => "LINE",
		"SHOW_PARENT_NAME" => "Y",
		"IBLOCK_TYPE" => "newcatalog",
		"IBLOCK_ID" => "45",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "",
		"SECTION_URL" => "",
		"COUNT_ELEMENTS" => "N",
		"TOP_DEPTH" => "2",
		"SECTION_FIELDS" => array(0=>"",1=>"",),
		"SECTION_USER_FIELDS" => array(0=>"UF_NAME",1=>"UF_ROW",2=>"UF_COL",),
		"ADD_SECTIONS_CHAIN" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y"
	)
);?>
    <br />
  <?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "seo_text.php",
		"EDIT_TEMPLATE" => ""
	),
false
);?>
    <br />
   	</div>
 	
  <div class="clear"></div>
 </div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>