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
 
<div class="title">
    <h1>Интернет-магазин</h1>
</div>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	".default", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "",
		"COUNT_ELEMENTS" => "Y",
		"TOP_DEPTH" => "2",
		"SECTION_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SECTION_URL" => "/catalog/#SECTION_CODE#",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"VIEW_MODE" => "LINE",
		"SHOW_PARENT_NAME" => "Y"
	),
	false
);
?>



</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>