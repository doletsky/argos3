<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Стоимость светодиодных модулей, драйверов, светильников ЖКХ, оптико-акустических датчиков компании Аргос-Трейд.");
$APPLICATION->SetPageProperty("keywords", "светильник жкх цена, светодиодные модули цена, купить светодиодный драйвер, купить драйвер для светодиодного светильника, купить светильник жкх");
$APPLICATION->SetPageProperty("title", "Стоимость светодиодных модулей, драйверов, светильников ЖКХ, оптико-акустических датчиков - Аргос-Трейд");
$APPLICATION->SetTitle("Стоимость светодиодных модулей, драйверов, светильников ЖКХ, оптико-акустических датчиков - Аргос-Трейд");?>

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
			"ROOT_MENU_TYPE" => "vert_production",
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
		<h1>Прайс-Лист</h1>				
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
		<?
		$arSelect = array("PROPERTY_PRICES");
		
		$IP=getRealIp();//получение ip
		$ipDetail = getCountryByIp($IP);//получение страны по ip
		
		if($ipDetail=='BE' || $ipDetail=='KK' || $ipDetail=='UZ' || $ipDetail=='UA')//Белоруссия Казахстан Узбекистан Украина Россиия
		{
			$ar_result1=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>25, "CODE"=>'prices_except', "ACTIVE"=>"Y"), $arSelect);
		}elseif($ipDetail=='RU'){
			$ar_result1=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>25, "CODE"=>'prices_rus', "ACTIVE"=>"Y"), $arSelect);
		}else{
			$ar_result1=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>25, "CODE"=>'prices_rus', "ACTIVE"=>"Y"), $arSelect);
		}		
		while($ar_fields=$ar_result1->GetNext())
		{
			$file_info = CFile::GetFileArray($ar_fields["PROPERTY_PRICES_VALUE"]);
			$path_file = $file_info['SRC'];
			$name_file = $file_info['DESCRIPTION'];	
			$ext = array_pop(explode (".", $file_info['FILE_NAME']));
			?><a class="xls_catalog_link <?=$ext?>" href="<?=$path_file?>"><?=$name_file?></a><?
		}
		?>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>