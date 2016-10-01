<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
LocalRedirect("index.php", true, "301");
$APPLICATION->SetPageProperty("description", "Партнеры, дистрибьюторы Аргос-Трейд. Перечень партнеров у которых можно купить светодиодную комплектацию и светильники с сортировкой по регионам или по алфавиту.");
$APPLICATION->SetPageProperty("keywords", "этм, русский свет, техносвет, купить светодиодные модули, купить светодиодные драйверы, купить светильники жкх");
$APPLICATION->SetPageProperty("title", "Где можно купить светодиодные модули, светодиодные драйверы и светильники?");
$APPLICATION->SetTitle("Где можно купить светодиодную комплектацию, светодиодные и светильники?");?>

<?
$iblock_id=31;
$prod_iblock=2;
?>

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
			"ROOT_MENU_TYPE" => "vert_distributors",
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
		<h1>Партнеры</h1>				
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
			<span>
		     <?
				$arSelect = Array("ID", "NAME", "PROPERTY_FILES");
				$arFilter = Array("IBLOCK_ID"=>42, "CODE"=>"distributors", "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
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
		//Получаем массив используемых символов
		if(CModule::IncludeModule("iblock"))
		{
			$arSelect = array("ID", "NAME", "DETAIL_TEXT", "DETAIL_PICTURE", "PROPERTY_LINK_SITE", "PROPERTY_LINK_MAIL", "PROPERTY_DETAILS", "PROPERTY_AFFILIATE", "PROPERTY_MAIN_PARTNERSHIP_ID");
			$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "PROPERTY_AFFILIATE_VALUE"=>"Нет"), $arSelect);
			$arr_alfab_symbols=array();
			while($res=$ar_result->GetNext())
			{
				$alfab_symbol_new=mb_strtolower(mb_substr($res['NAME'],0,1,"UTF-8"));//Получаем первый символ строки (нижний регистр)
				if(!in_array($alfab_symbol_new, $arr_alfab_symbols)) {
					$arr_alfab_symbols[]=$alfab_symbol_new;
				}
			}
		}
		$arrFinRus = array("а", "б", "в", "г", "д", "е", "ж", "з", "и", "к", "л", "м", "н", "о", "п", "р", "с", "т", "у", "ф", "х", "ц", "ч", "ш", "щ", "э", "ю", "я");
		$arrFinEng = array("a", "v", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
		?>
		<p class="text_page_info">Воспользуйтесь быстрым поиском партнеров по алфавиту</p>
		<div id="distributors_menu">
			<ul class="lang_ru">
				<?
				foreach ($arrFinRus as $arrFinEl) {
					if(in_array($arrFinEl, $arr_alfab_symbols)) {
						?>
						<li><a class="ancLinks" href="#distributor_<?=$arrFinEl?>"><?=$arrFinEl?></a></li>
						<?
					}
					else {
						?>
						<li><?=$arrFinEl?></li>
						<?
					}
				}
				?>
			</ul>
			<ul class="lang_en">
				<?
				foreach ($arrFinEng as $arrFinEl) {
					if(in_array($arrFinEl, $arr_alfab_symbols)) {
						?>
						<li><a class="ancLinks" href="#distributor_<?=$arrFinEl?>"><?=$arrFinEl?></a></li>
						<?
					}
					else {
						?>
						<li><?=$arrFinEl?></li>
						<?
					}
				}
				?>
			</ul>
		</div>
		<?
		if(CModule::IncludeModule("iblock"))
		{
			$arSelect = array("ID", "NAME", "DETAIL_TEXT", "DETAIL_PICTURE", "PROPERTY_LINK_SITE", "PROPERTY_LINK_MAIL", "PROPERTY_DETAILS", "PROPERTY_AFFILIATE", "PROPERTY_MAIN_PARTNERSHIP_ID", "PROPERTY_SALE_TYPE_1", "PROPERTY_SALE_TYPE_2", "PROPERTY_SALE_TYPE_3", "PROPERTY_CML2_LINK");
			$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "PROPERTY_AFFILIATE_VALUE"=>"Нет"), $arSelect);
			$alfab_symbol="";
			while($res=$ar_result->GetNext())
			{
				$src_img = CFile::GetPath($res["DETAIL_PICTURE"]);
				$alfab_symbol_new=mb_strtolower(mb_substr($res['NAME'],0,1,"UTF-8"));//Получаем первый символ строки (нижний регистр)
				if($alfab_symbol!=$alfab_symbol_new)
				{
					if($alfab_symbol!='')
						echo '</div>';
					$alfab_symbol=$alfab_symbol_new;
					?>
					<div id="distributor_<?=$alfab_symbol?>">
					<?
				}
				
				?>
				<div class="distributor_wrap">
					<div class="img_logo"><img src="<?=$src_img?>" /></div>
					<div class="descriptions">
						<div class="title"><?=$res['NAME']?></div>
						<div class="address_wrap">
							<?=htmlspecialchars_decode($res['DETAIL_TEXT'])?>
						</div>
						<div class="links">
							<a href="http://<?=$res['PROPERTY_LINK_SITE_VALUE']?>" target="_blank" rel="nofollow" class="site"><?=$res['PROPERTY_LINK_SITE_VALUE']?></a>
							<a href="mailto:<?=$res['PROPERTY_LINK_MAIL_VALUE']?>" class="mail"><?=$res['PROPERTY_LINK_MAIL_VALUE']?></a>
						</div>
						<div class="clear"></div>
						<ul class="details">
						<?						
						//Выбираем указанный тип продукции и способ реализации
							$arPropVal = array();
							$resProps = CIBlockElement::GetProperty($iblock_id, $res['ID'], array("sort" => "asc"), array("CODE"=>"SALE_PROD"));
							while ($ob = $resProps->GetNext())
							{
								$arPropVal[] = $ob['VALUE'];
							}
							if($arPropVal[0] > 0){	
								foreach($arPropVal as $k=>$v){
									$arSelCat = array("ID", "NAME");
									$ar_res=CIBlockSection::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$prod_iblock, "ID"=>$v), $arSelCat);						
									while($arCat=$ar_res->GetNext())
									{
									?>															
										<li><?=$arCat['NAME']?> - <span><?=$res['PROPERTY_SALE_TYPE_'.($k+1).'_VALUE']?></span></li>
									<?
									}
								}	
							}
						?></ul><?
						
						/*if($res['PROPERTY_DETAILS_VALUE']['TEXT'])
							echo htmlspecialchars_decode($res['PROPERTY_DETAILS_VALUE']['TEXT']);*/
						
						$arSelect2 = array("ID", "NAME", "DETAIL_TEXT", "DETAIL_PICTURE", "PROPERTY_LINK_SITE", "PROPERTY_LINK_MAIL", "PROPERTY_DETAILS", "PROPERTY_AFFILIATE", "PROPERTY_MAIN_PARTNERSHIP_ID", "PROPERTY_SALE_TYPE_1", "PROPERTY_SALE_TYPE_2", "PROPERTY_SALE_TYPE_3", "PROPERTY_CML2_LINK");
						$ar_result2=CIBlockElement::GetList(Array("SORT"=>"ASC","NAME"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "PROPERTY_AFFILIATE_VALUE"=>"Да", "PROPERTY_MAIN_PARTNERSHIP_ID"=>$res['ID']), $arSelect2);
						$count=1;
						$end='no';
						while($res2=$ar_result2->GetNext())
						{
							if($count==1)
							{
								$count++;
								$end='yes';
							?>
								<div id="affiliates">
									<div class="affiliates_title"><span>Филиалы</span></div>
							<?}?>
							<div class="affiliates_wrap">
								<!-- <div class="title"><?=$res2['NAME']?></div>
								<div class="address_wrap">-->
									<?	
									if(CModule::IncludeModule('catalog')){
										$arEl = CCatalogProduct::GetByIDEx($res2['PROPERTY_CML2_LINK_VALUE']);	
									}
									//echo 'г.'.$arEl["NAME"].', '.htmlspecialchars_decode($res2['DETAIL_TEXT'])?>
									<?// var_dump($arEl);?>
									<a href="<?=$arEl["DETAIL_PAGE"]?>?>"><?$arEl["NAME"];?>?></a> 
								<!--</div>
								<div class="links">
									<a href="http://<?=$res2['PROPERTY_LINK_SITE_VALUE']?>" target="_blank" class="site"><?=$res2['PROPERTY_LINK_SITE_VALUE']?></a>
									<a href="mailto:<?=$res2['PROPERTY_LINK_MAIL_VALUE']?>" class="mail"><?=$res2['PROPERTY_LINK_MAIL_VALUE']?></a>
								</div>
								<div class="clear"></div>
								<ul class="details">-->
								<?						
								//Выбираем указанный тип продукции и способ реализации
									$arPropVal = array();
									$resProps = CIBlockElement::GetProperty($iblock_id, $res2['ID'], array("sort" => "asc"), array("CODE"=>"SALE_PROD"));
									while ($ob = $resProps->GetNext())
									{
										$arPropVal[] = $ob['VALUE'];
									}									
									
									if($arPropVal[0] > 0){	
										foreach($arPropVal as $k=>$v){
											$arSelCat = array("ID", "NAME");
											$ar_res=CIBlockSection::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$prod_iblock, "ID"=>$v), $arSelCat);						
											while($arCat=$ar_res->GetNext())
											{
											?>															
												<li><?=$arCat['NAME']?> - <span><?=$res2['PROPERTY_SALE_TYPE_'.($k+1).'_VALUE']?></span></li>
											<?
											}
										}	
									}
								?></ul>
							</div>
						<?}?>
						<?if($end=='yes') {?>
							</div>
						<?}?>
					</div>					
					<div class="clear"></div>
				</div>
				<?	
			}
			?>
			</div>
			<?
		}
		?>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>