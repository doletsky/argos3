<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Баннеры для размещения на сайтах партнеров компании Аргос-Трейд");
$APPLICATION->SetPageProperty("keywords", "баннеры Аргос-Трейд, продукция Аргос-Трейд");
$APPLICATION->SetPageProperty("title", "Баннеры для партнеров Аргос-Трейд");
$APPLICATION->SetTitle("Баннеры для партнеров Аргос-Трейд");?>

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
		<h1>Баннеры для партнеров</h1>
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
		    
	    <span>
	     <?
			$arSelect = Array("ID", "NAME", "PROPERTY_FILES");
			$arFilter = Array("IBLOCK_ID"=>42, "CODE"=>"partners", "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
			$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>5), $arSelect);
			while($ob = $res->GetNextElement()):?>
				<?php $arFields = $ob->GetFields();
					$file_info = CFile::GetFileArray($arFields["PROPERTY_FILES_VALUE"]);

					$path_file = $file_info['SRC'];
					$name_file = $file_info['DESCRIPTION'];
					$ext = array_pop(explode (".", $file_info['FILE_NAME']));
					?>
					<?php if(is_file($_SERVER['DOCUMENT_ROOT'] . $path_file)):?>
						<a class="xls_catalog_link <?php echo $ext?>" href="<?php echo $path_file?>" target="_blank"><?php echo $arFields['NAME']?></a>
				<?php endif;?>
		<?php endwhile;?>
		</span>
		<br />
		<br />
		
		<?
		$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>32, "ACTIVE"=>"Y"));
		while($ar_fields=$ar_result->GetNext()){			
			$file = CFile::GetFileArray($ar_fields["DETAIL_PICTURE"]);
			?>
			<div class="partners_banners">
				<img src="<?=$file['SRC']?>" />
				<textarea onclick="this.select()" readonly=""><a title="Cветодиодные драйверы, светодиодные модули и светильники ЖКХ с датчиками производства Аргос-Трейд" href=&quot;<?=$file['DESCRIPTION']?>&quot; target=&quot;_blank&quot;><img alt="Мы используем LED драйверы, светильники ЖКХ с датчиком от производителя Аргос-Электрон" src=&quot;http://<?=SITE_SERVER_NAME.$file['SRC']?>&quot; border=&quot;0&quot;></a></textarea>
			</div>
			<?
		}
		?>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>