<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Светодиодное освещение объектов с использованием светодиодных драйверов и светодиодных модулей Аргос-Трейд");
$APPLICATION->SetPageProperty("keywords", "светодиодные светильники ЖКХ, светодиодные драйверы, светодиодные модули");
$APPLICATION->SetPageProperty("title", "Портфолио Аргос-Трейд: конкретные объекты применение светильников ЖКХ, светодиодных драйверов и светодиодных модулей");
$APPLICATION->SetTitle("Портфолио Аргос-Трейд: конкретные объекты применение светильников ЖКХ, светодиодных драйверов и светодиодных модулей");?> 
<div class="whole_page" id="content"> 	<?$APPLICATION->IncludeComponent(
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

 	 	 	 	<?$APPLICATION->IncludeComponent(
	"bitrix:catalog",
	"portfolio_catalog",
	Array(
		"SECTIONS_VIEW_MODE" => "TEXT",
		"SECTIONS_SHOW_PARENT_NAME" => "Y",
		"FILTER_VIEW_MODE" => "VERTICAL",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
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
		"AJAX_MODE" => "N",
		"SEF_MODE" => "Y",
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "8",
		"USE_FILTER" => "Y",
		"USE_REVIEW" => "Y",
		"USE_COMPARE" => "N",
		"SHOW_TOP_ELEMENTS" => "N",
		"SECTION_COUNT_ELEMENTS" => "N",
		"SECTION_TOP_DEPTH" => "1",
		"PAGE_ELEMENT_COUNT" => "15",
		"LINE_ELEMENT_COUNT" => "3",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"LIST_PROPERTY_CODE" => array("NEWPRODUCT","SALELEADER","SPECIALOFFER"),
		"INCLUDE_SUBSECTIONS" => "N",
		"LIST_META_KEYWORDS" => "-",
		"LIST_META_DESCRIPTION" => "-",
		"LIST_BROWSER_TITLE" => "-",
		"DETAIL_PROPERTY_CODE" => array("NEWPRODUCT","MANUFACTURER","MATERIAL","CATALOG_TYPE"),
		"DETAIL_META_KEYWORDS" => "-",
		"DETAIL_META_DESCRIPTION" => "-",
		"DETAIL_BROWSER_TITLE" => "-",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_ELEMENT_CHAIN" => "N",
		"PRICE_CODE" => array(),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"BASKET_URL" => "/personal/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_PRODUCT_QUANTITY" => "Y",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(),
		"LINK_IBLOCK_TYPE" => "",
		"LINK_IBLOCK_ID" => "",
		"LINK_PROPERTY_SID" => "",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"USE_ALSO_BUY" => "Y",
		"USE_STORE" => "Y",
		"USE_ELEMENT_COUNTER" => "Y",
		"PAGER_TEMPLATE" => "arrows",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
		"PAGER_SHOW_ALL" => "N",
		"FILTER_NAME" => "",
		"FILTER_FIELD_CODE" => array(),
		"FILTER_PROPERTY_CODE" => array(),
		"FILTER_PRICE_CODE" => array(),
		"MESSAGES_PER_PAGE" => "10",
		"USE_CAPTCHA" => "Y",
		"REVIEW_AJAX_POST" => "Y",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"FORUM_ID" => "1",
		"URL_TEMPLATES_READ" => "",
		"SHOW_LINK_TO_FORUM" => "Y",
		"STORES" => array(),
		"USE_MIN_AMOUNT" => "N",
		"USER_FIELDS" => array(),
		"FIELDS" => array(),
		"SHOW_EMPTY_STORE" => "Y",
		"SHOW_GENERAL_STORE_INFORMATION" => "N",
		"STORE_PATH" => "/store/#store_id#",
		"MAIN_TITLE" => "Наличие на складах",
		"ALSO_BUY_ELEMENT_COUNT" => "3",
		"ALSO_BUY_MIN_BUYES" => "2",
		"HIDE_NOT_AVAILABLE" => "N",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"SEF_FOLDER" => "/portfolio/",
		"SEF_URL_TEMPLATES" => Array(
			"section" => "",
			"element" => "#ELEMENT_CODE#/",
			"compare" => "compare/"
		),
		"VARIABLE_ALIASES" => Array(
			"section" => Array(),
			"element" => Array(),
			"compare" => Array(),
		)
	)
);?> </div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>