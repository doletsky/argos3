<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Text");?> 
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
	"tree_vertical",
	Array(
		"ROOT_MENU_TYPE" => "vert_production",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(),
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "podmenu",
		"USE_EXT" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	)
);?> <?include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."sidebar.php");?> </div>
 	 
  <div class="content_right"> 
	text
   </div>
 </div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>