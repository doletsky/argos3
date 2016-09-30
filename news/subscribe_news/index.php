<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подписка на новости");?>

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
	<div class="content_right">				
		<h1>Подписка на новости</h1>				
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
		<?/*<div id="subscribe_news_page">
		<?$APPLICATION->IncludeComponent("bitrix:subscribe.form","subscribe_new",Array(
			"USE_PERSONALIZATION" => "Y", 
			"PAGE" => "#SITE_DIR#personal/subscribe/subscr_edit.php", 
			"SHOW_HIDDEN" => "Y", 
			"CACHE_TYPE" => "A", 
			"CACHE_TIME" => "3600" 
			)
		);?>		
		</div>*/?>
		<?$APPLICATION->IncludeComponent(
			"new:subscribe.edit",
			"eshop",
			Array(
				"AJAX_MODE" => "N",
				"SHOW_HIDDEN" => "N",
				"ALLOW_ANONYMOUS" => "Y",
				"SHOW_AUTH_LINKS" => "Y",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"SET_TITLE" => "N",
				"AJAX_OPTION_SHADOW" => "Y",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N"
			),
		false
		);?>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>