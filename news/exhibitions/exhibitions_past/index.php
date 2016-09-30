<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Прошедшие выставки");?>
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
		<h1>Архив выставок</h1>
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
		<?
		if(CModule::IncludeModule("iblock"))
		{
			$iblock=6;
			$arSelect = array("ID", "NAME", "DETAIL_TEXT", "PROPERTY_EXHIBITION_DATA", "PROPERTY_EXHIBITION_SITE");
			$ar_result=CIBlockElement::GetList(Array("SORT"=>"DESC"), Array("IBLOCK_ID"=>$iblock, "ACTIVE"=>"Y"), $arSelect);
			while($res=$ar_result->GetNext())
			{
				$date1=date('Y-m-d');
				$date2=explode(' - ',$res['PROPERTY_EXHIBITION_DATA_VALUE']);
				$date2=explode('.',$date2[1]);
				$date2=$date2[2].'-'.$date2[1].'-'.$date2[0];
				if(strtotime($date1)>strtotime($date2))//предстоящие выставки
				{
				?>
				<div class="exhibition_wrap">
					<div class="exhibition_date"><?=$res['PROPERTY_EXHIBITION_DATA_VALUE']?></div>
					<div class="exhibition_title"><?=$res['NAME']?></div>
					<div class="exhibition_description"><?=htmlspecialchars_decode($res['DETAIL_TEXT'])?></div>
					<?
					$db_props = CIBlockElement::GetProperty($iblock, $res['ID'], "sort", "asc", Array("CODE"=>"EXHIBITION_PHOTOS"));
					$photos_str=$db_props->Fetch();
					if($photos_str['VALUE'])
					{
						?>
						<div class="exhibition_photo_title">Фотографии</div>
						<div class="multimedia_slider">
							<ul class="bxslider">
								<?
								$db_props2 = CIBlockElement::GetProperty($iblock, $res['ID'], "sort", "asc", Array("CODE"=>"EXHIBITION_PHOTOS"));
								while($ar_props2 = $db_props2->Fetch())
								{
									$src_img = CFile::GetPath($ar_props2["VALUE"]);
									$title=$ar_props2['DESCRIPTION'];
									?>
									<li>
										<img src="<?=$src_img?>" title="<?=$title?>" />
									</li>
									<?
								}
								?>
							</ul>
							<div class="bx-pager_wrap">
								<div id="bx-pager<?=$res['ID']?>" class="bx-pager">
									<div class="bx-pager-inner">
										<?
										$db_props3 = CIBlockElement::GetProperty($iblock, $res['ID'], "sort", "asc", Array("CODE"=>"EXHIBITION_PHOTOS"));
										$count=0;
										while($ar_props3 = $db_props3->Fetch())
										{
											$src_img = CFile::GetPath($ar_props3["VALUE"]);
											?>
											<a data-slide-index="<?=$count?>" href=""><img src="<?=$src_img?>" /></a>
											<?
											$count++;
										}
										?>
										<div class="clear"></div>
									</div>
								</div>
							</div>
						</div>
						<?
					}
					?>
					<div class="exhibition_link">Сайт выставки: <a href="<?=$res['PROPERTY_EXHIBITION_SITE_VALUE']?>" target="_blank" ><?=$res['PROPERTY_EXHIBITION_SITE_VALUE']?></a></div>
					<?
					//Социальные кнопки
					$reviews_block='Y';//Блок с отзывами есть
					$page='exhibition_'.$res['ID'];//идентификатор страницы, с которой собираются отзывы
					
					$sumID = $res['ID'];
					$vkID=$res['ID'];
					include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."social_buttons.php");
					?>
				</div>
				<?
				}
			}
		}
		?>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>