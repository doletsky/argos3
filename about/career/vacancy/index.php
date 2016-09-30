<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Мы всегда рады профессиональным сотрудникам. Ознакомьтесь с нашими вакансиями, выбирайте подходящую и присылайте резюме.");
$APPLICATION->SetPageProperty("keywords", "вакансии аргос-трейд, вакансии аргос-электрон, вакансии производителя светильников, вакансии производителя светодиодных драйверов, вакансии производителя светодиодных модулей");
$APPLICATION->SetPageProperty("title", "Вакансии Аргос-Трейд и Аргос-Электрон, компании по производству светильников, светодиодных драйверов и модулей");
$APPLICATION->SetTitle("Вакансии Аргос-Трейд и Аргос-Электрон, компании по производству светильников, светодиодных драйверов и модулей");?>

<?$iblock_id=38;?>

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
		<h1>Вакансии</h1>				
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
		<p class="text_page_info">Ознакомиться с вакансиями компании вы можете на следующих биржах труда:</p>
		<a href="/" target="_blank" class="vacancy_link" id="head_hunter"></a>
		<a href="/" target="_blank" class="vacancy_link" id="super_job"></a>
		<a href="/" target="_blank" class="vacancy_link" id="job_ru"></a>
		<div id="tab_vacancy_wrap">
			<?
			if(CModule::IncludeModule("iblock")) {
				$ar_result=CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "DEPTH_LEVEL"=>1, "ACTIVE"=>"Y"), false, array());
				$count=1;
				while($res=$ar_result->GetNext())
				{					
					?>
					<div class="tab_grey_style<?if($count==1)echo' current';?> w_274" id="tab_<?=$count?>"><span><?=$res['NAME']?></span></div>
					<?
					$count++;
				}
				?><div style="clear:both"></div><?
				$ar_result3=CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "DEPTH_LEVEL"=>1, "ACTIVE"=>"Y"), false, array());
				$count2=1;
				while($res3=$ar_result3->GetNext())
				{
					$sec_id=$res3['ID'];
					
					?>
					<div class="vacancy_content<?if($count2==1)echo' current';?>" id="vacancy_content_tab_<?=$count2?>">
						<?
						$ar_result2=CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "SECTION_ID"=>$sec_id, "ACTIVE"=>"Y"), false, array());
						while($res2=$ar_result2->GetNext())
						{							
							$sec_id2=$res2['ID'];
							?>
							<h2 class="title_page_red"><?=$res2['NAME']?></h2>
							<div class="vacancy_wrap">
								<?
								$arSelect = array("ID", "NAME");
								$ar_result4=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "SECTION_ID"=>$sec_id2, "ACTIVE"=>"Y"), false, $arSelect);
								$count3=1;
								while($res4=$ar_result4->GetNext())
								{
								?>
									<div class="vacancy_title<?if($count3>1) echo' marg_top_45';?>"><?=$res4['NAME']?></div>
									<div class="vacancy_step">Обязанности:</div>
									<ul class="vacancy_list">
										<?
										$db_props = CIBlockElement::GetProperty($iblock_id, $res4['ID'], array("sort" => "asc"), Array("CODE"=>"RESPONSIBILITY"));
										while($ar_props = $db_props->Fetch()){
											$responsibility=$ar_props['VALUE'];
											?>
											<li>- <?=$responsibility?></li>
											<?
										}
										?>
									</ul>
									<div class="vacancy_step">Требования:</div>
									<ul class="vacancy_list">
										<?
										$db_props = CIBlockElement::GetProperty($iblock_id, $res4['ID'], array("sort" => "asc"), Array("CODE"=>"REQUIREMENTS"));
										while($ar_props = $db_props->Fetch()){
											$requirements=$ar_props['VALUE'];
											?>
											<li>- <?=$requirements?></li>
											<?
										}
										?>
									</ul>
									<div class="vacancy_step">Мы предлагаем:</div>
									<ul class="vacancy_list">
										<?
										$db_props = CIBlockElement::GetProperty($iblock_id, $res4['ID'], array("sort" => "asc"), Array("CODE"=>"OFFER"));
										while($ar_props = $db_props->Fetch()){
											$offers=$ar_props['VALUE'];
											?>
											<li>- <?=$offers?></li>
											<?
										}
										?>
									</ul>
								<?
									$count3++;
								}
								?>
							</div>
							<?
						}
						?>
					</div>
					<?
					$count2++;
				}
			}
			?>
		</div>
		<p class="vacancy_info">Если вас заинтересовали представленные вакансии, <a href="/about/career/questionary/">заполните анкету</a> на нашем сайте, и в ближайшее время мы свяжемся с вами.</p>
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