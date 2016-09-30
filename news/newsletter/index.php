<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "светильники ЖКХ новости, светодиодные драйверы, LED драйверы новости, светоионые модули новости");
$APPLICATION->SetPageProperty("description", "Новая продукция, полезная информация для покупателей, скидки и бонусы, ценовая политика, участие в выставках, дилерские условия компании Аргос-Трейд для партнеров.");
$APPLICATION->SetPageProperty("title", "Новости о светильниках ЖКХ, светодиодных драйверах, светодиодных модулях, скидках и бонусах на продукцию Аргос-Трейд");
$APPLICATION->SetTitle("Новости о светильниках ЖКХ, светодиодных драйверах, светодиодных модулях, скидках и бонусах на продукцию Аргос-Трейд");?>

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
		<?$APPLICATION->IncludeComponent("bitrix:menu", "tree_vertical", array(
			"ROOT_MENU_TYPE" => "vert_news",
			"MENU_CACHE_TYPE" => "A",
			"MENU_CACHE_TIME" => "36000000",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"MENU_CACHE_GET_VARS" => array(),
			"MAX_LEVEL" => "2",
			"CHILD_MENU_TYPE" => "podmenu",
			"USE_EXT" => "N",
			"ALLOW_MULTI_SELECT" => "N"
			),
			false
		);
		?>
		<?include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."sidebar.php");?>
	</div>
	<?
	$arAvailableSort = array(
		"rating" => Array("PROPERTY_rating", "asc"),
		"date" => Array('ACTIVE_FROM', "desc"),
	);
	$sort = array_key_exists("sort", $_REQUEST) && array_key_exists(ToLower($_REQUEST["sort"]), $arAvailableSort) ? $arAvailableSort[ToLower($_REQUEST["sort"])][0] : "ACTIVE_FROM";
	$sort_order = array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ? ToLower($_REQUEST["order"]) : "desc";
	?>
	<div class="content_right">
		<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	".default", 
	array(
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "1",
		"NEWS_COUNT" => "10",
		"USE_SEARCH" => "Y",
		"USE_RSS" => "Y",
		"NUM_NEWS" => "20",
		"NUM_DAYS" => "180",
		"YANDEX" => "N",
		"USE_RATING" => "Y",
		"MAX_VOTE" => "5",
		"VOTE_NAMES" => array(
			0 => "1",
			1 => "2",
			2 => "3",
			3 => "4",
			4 => "5",
			5 => "",
		),
		"USE_CATEGORIES" => "N",
		"USE_REVIEW" => "Y",
		"MESSAGES_PER_PAGE" => "10",
		"USE_CAPTCHA" => "Y",
		"REVIEW_AJAX_POST" => "Y",
		"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
		"FORUM_ID" => "4",
		"URL_TEMPLATES_READ" => "",
		"SHOW_LINK_TO_FORUM" => "N",
		"POST_FIRST_MESSAGE" => "N",
		"USE_FILTER" => "N",
		"SORT_BY1" => $sort,
		"SORT_ORDER1" => $sort_order,
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"CHECK_DATES" => "Y",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/news/newsletter/",
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
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"USE_PERMISSIONS" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "FORUM_MESSAGE_CNT",
			1 => "vote_count",
			2 => "rating",
			3 => "vote_sum",
			4 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_NAME" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_PROPERTY_CODE" => array(
			0 => "FORUM_MESSAGE_CNT",
			1 => "vote_count",
			2 => "rating",
			3 => "vote_sum",
			4 => "",
		),
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PAGER_TEMPLATE" => "arrows_news",
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"PAGER_TEMPLATE" => "arrows_news",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
		"PAGER_SHOW_ALL" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"ADD_ELEMENT_CHAIN" => "N",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "",
			"detail" => "#ELEMENT_CODE#/",
			"search" => "search/",
			"rss" => "rss/",
			"rss_section" => "#SECTION_ID#/rss/",
		)
	),
	false
);?>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>