<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Search");?>

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
	</div>
	<div class="content_right">		
		<?$APPLICATION->IncludeComponent("bitrix:search.page", "new_search", array(
			"RESTART" => "N",
			"NO_WORD_LOGIC" => "N",
			"CHECK_DATES" => "N",
			"USE_TITLE_RANK" => "N",
			"DEFAULT_SORT" => "rank",
			"FILTER_NAME" => "",
			"arrFILTER" => array(
				0 => "iblock_news",
			),
			"arrFILTER_iblock_news" => array(
				0 => "1",
			),
			"SHOW_WHERE" => "Y",
			"arrWHERE" => array(
				0 => "iblock_news",
			),
			"SHOW_WHEN" => "N",
			"PAGE_RESULT_COUNT" => "50",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "3600",
			"DISPLAY_TOP_PAGER" => "Y",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "Результаты поиска",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => "arrows_news",
			"USE_LANGUAGE_GUESS" => "Y",
			"USE_SUGGEST" => "Y",
			"SHOW_ITEM_TAGS" => "Y",
			"TAGS_INHERIT" => "Y",
			"SHOW_ITEM_DATE_CHANGE" => "Y",
			"SHOW_ORDER_BY" => "Y",
			"SHOW_TAGS_CLOUD" => "N",
			"SHOW_RATING" => "",
			"RATING_TYPE" => "",
			"PATH_TO_USER_PROFILE" => "",
			"AJAX_OPTION_ADDITIONAL" => ""
			),
			false
		);?>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>