<?
if(isset($_GET['view']) && ($_GET['view'])=='new')
{
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header_new.php");
	?>
	<script>
		$(document).ready(function() {
			$('.footer_bot_2').css('padding-bottom',"0px");//убираем паддинг блока над футором
		});
	</script>
	<?
}
else	
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Светодиодные драйверы, светильники ЖКХ, Светодиодные модули производства Аргос-Трейд ");?>

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog", 
	"new_catalog", 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"HIDE_NOT_AVAILABLE" => "N",
		"BASKET_URL" => "/personal/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/production/catalog_online/",
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
		"FILTER_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_PRICE_CODE" => array(
			0 => "BASE",
		),
		"FILTER_OFFERS_FIELD_CODE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DETAIL_PICTURE",
			2 => "",
		),
		"FILTER_OFFERS_PROPERTY_CODE" => array(
			0 => "DEGREE_OF_PROTECTION",
			1 => "",
		),
		"FILTER_VIEW_MODE" => "VERTICAL",
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
		"PRICE_VAT_INCLUDE" => "N",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"USE_PRODUCT_QUANTITY" => "Y",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"SHOW_TOP_ELEMENTS" => "N",
		"SECTION_COUNT_ELEMENTS" => "N",
		"SECTION_TOP_DEPTH" => "1",
		"SECTIONS_VIEW_MODE" => "TEXT",
		"SECTIONS_SHOW_PARENT_NAME" => "Y",
		"PAGE_ELEMENT_COUNT" => "999",
		"LINE_ELEMENT_COUNT" => "3",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"LIST_PROPERTY_CODE" => array(
			0 => "NEWPRODUCT",
			1 => "SALELEADER",
			2 => "SPECIALOFFER",
			3 => "",
		),
		"INCLUDE_SUBSECTIONS" => "N",
		"LIST_META_KEYWORDS" => "UF_KEYWORDS",
		"LIST_META_DESCRIPTION" => "UF_META_DESCRIPTION",
		"LIST_BROWSER_TITLE" => "UF_BROWSER_TITLE",
		"LIST_OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_PICTURE",
			2 => "DETAIL_TEXT",
			3 => "DETAIL_PICTURE",
			4 => "",
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
			0 => "NEWPRODUCT",
			1 => "MANUFACTURER",
			2 => "MATERIAL",
			3 => "CATALOG_TYPE",
			4 => "",
		),
		"DETAIL_META_KEYWORDS" => "KEYWORDS",
		"DETAIL_META_DESCRIPTION" => "META_DESCRIPTION",
		"DETAIL_BROWSER_TITLE" => "TITLE",
		"DETAIL_OFFERS_FIELD_CODE" => array(
			0 => "NAME",
			1 => "SORT",
			2 => "",
		),
		"DETAIL_OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "ARTNUMBER",
			2 => "SIZES_SHOES",
			3 => "SIZES_CLOTHES",
			4 => "COLOR_REF",
			5 => "MORE_PHOTO",
			6 => "",
		),
		"LINK_IBLOCK_TYPE" => "",
		"LINK_IBLOCK_ID" => "",
		"LINK_PROPERTY_SID" => "",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"USE_ALSO_BUY" => "Y",
		"ALSO_BUY_ELEMENT_COUNT" => "3",
		"ALSO_BUY_MIN_BUYES" => "2",
		"USE_STORE" => "Y",
		"USE_STORE_PHONE" => "Y",
		"USE_STORE_SCHEDULE" => "Y",
		"USE_MIN_AMOUNT" => "N",
		"STORE_PATH" => "/store/#store_id#",
		"MAIN_TITLE" => "Наличие на складах",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "asc",
		"PAGER_TEMPLATE" => "arrows",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
		"PAGER_SHOW_ALL" => "N",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "NEWPRODUCT",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"OFFER_TREE_PROPS" => array(
			0 => "",
			1 => "SIZES_SHOES",
			2 => "SIZES_CLOTHES",
			3 => "COLOR_REF",
			4 => "",
		),
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_OLD_PRICE" => "Y",
		"DETAIL_SHOW_MAX_QUANTITY" => "N",
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
		"DETAIL_FB_APP_ID" => "",
		"DETAIL_BRAND_USE" => "Y",
		"DETAIL_BRAND_PROP_CODE" => "",
		"AJAX_OPTION_ADDITIONAL" => "",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
		"STORES" => array(
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
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE#/",
			"element" => "#SECTION_CODE#/#ELEMENT_CODE#/",
			"compare" => "compare/",
		)
	),
	false
);?>

<?
if(!isset($_GET['view']) || (isset($_GET['view']) && $_GET['view']!='new'))
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>