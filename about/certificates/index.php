<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Сертификаты соответствия Таможенного Союза на светодиодные драйверы, светильники ЖКХ, оптико-акустические датчики, протоколы испытаний на общую безопасность и ЭМС светодиодных драйверов, светильников ЖКХ, оптико-акустических датчиков.");
$APPLICATION->SetPageProperty("keywords", "сертификаты на драйверы, протоколы испытаний на драйверы, сертификаты на светильники, протоколы испытаний на светильники");
$APPLICATION->SetPageProperty("title", "Сертификаты и протоколы испытаний на светодиодные драйверы, светильники, оптико-акустические датчики Аргос-Трейд");
$APPLICATION->SetTitle("Сертификаты и протоколы испытаний на светодиодные драйверы, светильники, оптико-акустические датчики Аргос-Трейд");?>

<? $iblock_id=7; ?>

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
		<h1>Сертификаты</h1>				
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
		<p class="desc">Если у Вас не открывается архив, то все документы, находящиеся в нем, можно просмотреть или скачать в карточке интересующего Вас товара.</p>		
		<div class="certificates_wrap">
			<?
			if(CModule::IncludeModule("iblock"))
			{
				$arSelect = array("ID", "NAME", "DEPTH_LEVEL", "ELEMENT_CNT");
				$ar_result=CIBlockSection::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "DEPTH_LEVEL"=>1, "ACTIVE"=>"Y"), true, $arSelect);
				while($res=$ar_result->GetNext())
				{					
					
					if($res['ELEMENT_CNT']>0)
					{
						?>
						<h2 class="certificates_title"><?=$res['NAME']?></h2>
						<div class="certificates_properties">
							<?
							$arSelect = array("ID", "NAME", "DEPTH_LEVEL", "ELEMENT_CNT", "UF_SERTIFICATE_RUS");
							$ar_result2=CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "SECTION_ID"=>$res['ID'], "DEPTH_LEVEL"=>2, "ACTIVE"=>"Y"), true, $arSelect);
							$count_main=1;
							while($res2=$ar_result2->GetNext())
							{
							
								//основной сертификат
							
								$mainCertID = $res2["UF_SERTIFICATE_RUS"];							
								$main_cert = CFile::GetFileArray($mainCertID);
								$linkToCert = $main_cert['SRC'];
											
								/*****/
								
								/*if($res2['ELEMENT_CNT']>0)
								{*/
									if($count_main==1)
										$add_class=" left";
									else
										$add_class=" right";
									?>
									<div class="properties_wrap<?=$add_class?>">
										<?
										if($linkToCert != ''){
										?>
											<div class="properties_title"><a href="<?=$linkToCert?>" target="_blank"><?=$res2['NAME']?></a></div>
										<?}else{?>
											<div class="properties_title"><?=$res2['NAME']?></div>
										<?}?>
										<div class="properties_content">
											<p>Протоколы:</p>
											<ul>
												<?
												$arSelect = array("ID", "NAME");
												$ar_result3=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "SECTION_ID"=>$res2['ID'], "ACTIVE"=>"Y"), $arSelect);
												while($res3=$ar_result3->GetNext())
												{
													$db_props = CIBlockElement::GetProperty($iblock_id, $res3['ID'], "sort", "asc", Array("CODE"=>"CERTIFICATE_PROTOCOLS_FILES"));
													while($ar_props = $db_props->Fetch())
													{
														$file = CFile::GetFileArray($ar_props["VALUE"]);
														$link=$file['SRC'];
														//$name=$file['DESCRIPTION'];
														?>
														<li><a target="_blank" href="<?=$link?>"><?=$res3['NAME']?></a></li>
														<?
													}
												}
												?>
											</ul>
										</div>
										<div class="properties_imgs">
											<?
											$arSelect = array("ID", "NAME");
											$ar_result3=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "SECTION_ID"=>$res2['ID']), $arSelect);
											while($res3=$ar_result3->GetNext())
											{
												$db_props3 = CIBlockElement::GetProperty($iblock_id, $res3['ID'], "sort", "asc", Array("CODE"=>"CERTIFICATE_IMAGES"));
												while($ar_props3 = $db_props3->Fetch())
												{
													if($ar_props3["VALUE"]) {
														$src_img = CFile::GetPath($ar_props3["VALUE"]);
														?>
														<img src="<?=$src_img?>" />
														<?
													}
												}
											}
											?>
										</div>
									</div>
									<?
									$count_main++;
									if($count_main>2)
										$count_main=1;
								/*}*/
							}
							?>
							<div class="clear"></div>
						</div>
						<?
					}
				}
			}
			?>				
		</div>
		<?
		//Социальные кнопки
		$reviews_block='N';//Блок с отзывами есть
		//$page='';//идентификатор страницы, с которой собираются отзывы
		include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."social_buttons.php");
		?>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>