<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Участие в выставках");?>

<?header('Location: '.SITE_DIR.'news/exhibitions/exhibitions_coming/');?>

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
			"MAX_LEVEL" => "3",
			"CHILD_MENU_TYPE" => "podmenu",
			"USE_EXT" => "N",
			"ALLOW_MULTI_SELECT" => "N"
			),
			false
		);
		?>
	</div>
	<div class="content_right">				
		<h1>Участие в выставках</h1>				
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>