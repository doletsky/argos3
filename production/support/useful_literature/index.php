<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Полезная литература");?>

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
		<h1>
			<?
			//Вывод заголовка страницы
			$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>33, "CODE"=>"useful_literature", "ACTIVE"=>"Y", "PROPERTY_LANG_VALUE"=>"RUS"), Array("NAME"));
			if($ar_fields=$ar_result->GetNext())
			{
				if($ar_fields['NAME'])
				{
					echo trim($ar_fields['NAME']);
				}
			}
			?>
		</h1>		
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
		<div class="include_area_page">
			<?
			//Вывод контента страницы
			$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>33, "CODE"=>"useful_literature", "ACTIVE"=>"Y", "PROPERTY_LANG_VALUE"=>"RUS"), Array("DETAIL_TEXT","CODE","ACTIVE","PROPERTY_LANG"));
			if($ar_fields=$ar_result->GetNext())
			{
				if($ar_fields['DETAIL_TEXT'])
				{
					echo '<div class="include_area_wrap">'.htmlspecialchars_decode($ar_fields['DETAIL_TEXT']).'</div>';
				}
			}
			//Вывод pdf-файлов
			$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>33, "CODE"=>"useful_literature", "ACTIVE"=>"Y", "PROPERTY_LANG_VALUE"=>"RUS"), Array("PROPERTY_PDF_FILES"));
			while($ar_fields=$ar_result->GetNext())
			{
				if($ar_fields['PROPERTY_PDF_FILES_VALUE'])
				{
					$file = CFile::GetFileArray($ar_fields['PROPERTY_PDF_FILES_VALUE']);
					?><a class="pdf_catalog_link" href="<?=$file['SRC']?>" target="_blank"><?=$file['DESCRIPTION']?></a><?
				}
			}
			?>			
			<div class="images_block_about">
				<?
				//Вывод галереи изображений
				$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>33, "CODE"=>"useful_literature", "ACTIVE"=>"Y", "PROPERTY_LANG_VALUE"=>"RUS"), Array("PROPERTY_IMG_FILES"));			
				while($ar_fields=$ar_result->GetNext())
				{
					if($ar_fields['PROPERTY_IMG_FILES_VALUE'])
					{
						$file = CFile::GetFileArray($ar_fields['PROPERTY_IMG_FILES_VALUE']);
						?><a class="fancybox-button" rel="about_imgs" href="<?=$file['SRC']?>" title="<?=$file['DESCRIPTION']?>"><img src="<?=$file['SRC']?>" /></a><?					
					}
				}
				?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>