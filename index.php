<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Компания «Аргос-Трейд» - уполномоченный торговый представитель завода «Аргос-Электрон»,  производящего источники питания (драйверы) для светодиодов, светодиодные модули, энергосберегающие светодиодные светильники ЖКХ с датчиками присутствия, датчики оптико-акустические.");
$APPLICATION->SetPageProperty("keywords", "светодиодные драйверы, прсветодиодные предбразователи, светодиодные модули и светильники ЖКХ с датчиками");
$APPLICATION->SetPageProperty("title", "Cветодиодные драйверы (источники питания для светодиодов), светодиодные модули и светильники ЖКХ с датчиками производства Аргос-Трейд");
$APPLICATION->SetTitle("LED драйверы, светодиодные блоки питания, LED модули, светодиодные светильники ЖКХ Аргос-Трейд");?>

<div id="content">
	<?/*<div id="breadcrumb"><a href="/" class="main"></a><span class="separate">/</span><a href="/">О компании</a><span class="separate">/</span><span class="current">Об Аргос-Трейд</span></div>*/?>
	<div id="breadcrumb"></div>
	<div class="content_left">
		<!-- Vertical menu -->
		<?$APPLICATION->IncludeComponent("bitrix:menu", "tree_vertical", array(
			"ROOT_MENU_TYPE" => "vert_about",
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
		<h2 class="title_page_red float_l">
		<?//global $USER;if ($USER->IsAdmin()){$code2 = 'main_ru_text'; }else{$code2 = 'main_ru';}?>
			<?
			//Вывод заголовка страницы
		/*	$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>33, "CODE"=>'main_ru_text', "ACTIVE"=>"Y", "PROPERTY_LANG_VALUE"=>"RUS"), Array("NAME"));
			if($ar_fields=$ar_result->GetNext())
			{
				if($ar_fields['NAME'])
				{
					echo trim($ar_fields['NAME']);
				}
			}*/
			?>
		</h2>
		<div id="print">Печатная версия</div>
		<div class="clear"></div>	

		<?
		//Вывод контента страницы
					$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>33, "CODE"=>'main_ru_table_text_before', "ACTIVE"=>"Y", "PROPERTY_LANG_VALUE"=>"RUS"), Array("DETAIL_TEXT","CODE","ACTIVE","PROPERTY_LANG"));
					if($ar_fields=$ar_result->GetNext())
					{
						if($ar_fields['DETAIL_TEXT'])
						{
							echo htmlspecialchars_decode($ar_fields['DETAIL_TEXT']);
						}
					}
		?>	
		<?
$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"main_table", 
	array(
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "40",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "XML_ID",
			3 => "NAME",
			4 => "TAGS",
			5 => "SORT",
			6 => "PREVIEW_TEXT",
			7 => "PREVIEW_PICTURE",
			8 => "DETAIL_TEXT",
			9 => "DETAIL_PICTURE",
			10 => "DATE_ACTIVE_FROM",
			11 => "ACTIVE_FROM",
			12 => "DATE_ACTIVE_TO",
			13 => "ACTIVE_TO",
			14 => "SHOW_COUNTER",
			15 => "SHOW_COUNTER_START",
			16 => "IBLOCK_TYPE_ID",
			17 => "IBLOCK_ID",
			18 => "IBLOCK_CODE",
			19 => "IBLOCK_NAME",
			20 => "IBLOCK_EXTERNAL_ID",
			21 => "DATE_CREATE",
			22 => "CREATED_BY",
			23 => "CREATED_USER_NAME",
			24 => "TIMESTAMP_X",
			25 => "MODIFIED_BY",
			26 => "USER_NAME",
			27 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "URL",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"main_news", 
	array(
		"IBLOCK_TYPE" => "news",
		"IBLOCK_ID" => "1",
		"NEWS_COUNT" => "1",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "FORUM_MESSAGE_CNT",
			2 => "vote_count",
			3 => "rating",
			4 => "vote_sum",
			5 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_STATUS_404" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);
?>	
		<?
		//Вывод контента страницы
					$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>33, "CODE"=>'main_ru_table_text_after', "ACTIVE"=>"Y", "PROPERTY_LANG_VALUE"=>"RUS"), Array("DETAIL_TEXT","CODE","ACTIVE","PROPERTY_LANG"));
					if($ar_fields=$ar_result->GetNext())
					{
						if($ar_fields['DETAIL_TEXT'])
						{
							echo htmlspecialchars_decode($ar_fields['DETAIL_TEXT']);
						}
					}
		?>	

		<?
		$arSelect = array("PROPERTY_FILES_MAIN");
		
		$IP=getRealIp();//получение ip
		$ipDetail = getCountryByIp($IP);//получение страны по ip
		
		if($ipDetail=='BE' || $ipDetail=='KK' || $ipDetail=='UZ' || $ipDetail=='UA')//Белоруссия Казахстан Узбекистан Украина Россиия
		{
			$ar_result1=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>41, "CODE"=>'prices_except', "ACTIVE"=>"Y"), $arSelect);
		}elseif($ipDetail=='RU'){
			$ar_result1=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>41, "CODE"=>'files_main', "ACTIVE"=>"Y"), $arSelect);
		}else{
			$ar_result1=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>41, "CODE"=>'files_main', "ACTIVE"=>"Y"), $arSelect);
		}		
		while($ar_fields=$ar_result1->GetNext())
		{

			$file_info = CFile::GetFileArray($ar_fields["PROPERTY_FILES_MAIN_VALUE"]);
			$path_file = $file_info['SRC'];
			$name_file = $file_info['DESCRIPTION'];	
			$ext = array_pop(explode (".", $file_info['FILE_NAME']));
			?><a class="xls_catalog_link <?=$ext?>" href="<?=$path_file?>"><?=$name_file?></a><?
		}
		?>
		<?
		//Вывод контента страницы
					$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>33, "CODE"=>'main_ru_files_text_before', "ACTIVE"=>"Y", "PROPERTY_LANG_VALUE"=>"RUS"), Array("DETAIL_TEXT","CODE","ACTIVE","PROPERTY_LANG"));
					if($ar_fields=$ar_result->GetNext())
					{
						if($ar_fields['DETAIL_TEXT'])
						{
							echo htmlspecialchars_decode($ar_fields['DETAIL_TEXT']);
						}
					}
		?>	
 

	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>