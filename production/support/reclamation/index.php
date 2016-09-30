<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "рекламация, претензия, он-лайн форма от производителя");
$APPLICATION->SetPageProperty("description", "Возможность отправить он-лайн рекламацию производителю");
$APPLICATION->SetPageProperty("title", "Отправить рекламацию");
$APPLICATION->SetTitle("Отправить рекламацию");?>

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
	<?
		require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/templates/eshop_adapt_/libs/submit_forms.php');
	?>
	<div class="content_right">	
		<?if (isset($success) && $success){
			echo "<div class='info_mess'>Сообщение успешно отправлено</div>";
		}elseif (isset($success) && !$success){
			echo "<div class='info_mess'>Произошла ошибка! Пожалуйста, свяжитесь с нами по телефону или почте</div>";
		}?>
		<h1>Рекламация</h1>		
		<div id="print">Печатная версия</div>
		
		<div class="clear"></div>
		
		<form id="reklamation_form" class="symple_form_page ru" method="post" action="" enctype="multipart/form-data">			
			<div class="rekl_field">
				<div class="field_title">Наименование организации <span class="red">*</span></div>
				<input type="text" name="rekl_organization" id="rekl_organization" value="" required>
			</div>
			<div class="rekl_field">
				<div class="field_title">Город <span class="red">*</span></div>
				<input type="text" name="rekl_city" id="rekl_city" value="" required>
			</div>			
			<div class="rekl_field">
				<div class="field_title">Контактное лицо <span class="red">*</span></div>
				<input type="text" name="rekl_contact" id="rekl_contact" value="" required>
			</div>
			<div class="rekl_field">
				<div class="field_title">E-Mail <span class="red">*</span></div>
				<input type="email" name="rekl_mail" id="rekl_mail" value="" required>
			</div>
			<div class="rekl_field">
				<div class="field_title">Телефон <span class="red">*</span></div>
				<input type="text" name="rekl_phone" id="rekl_phone" value="" required>
			</div>
			<div class="rekl_field">
				<div class="field_title">Номер и дата товаросопроводительного документа  <span class="red">*</span></div>
				<input type="text" name="rekl_num_date" id="rekl_num_date" value="" required>
			</div>
			<div class="rekl_field">
				<div class="field_title">Дата приёмки товара <span class="red">*</span></div>
				<input type="text" id="rekl_date" name="rekl_date" value="" required><!--<img src="/bitrix/js/main/core/images/calendar-icon.gif" alt="Выбрать дату в календаре" class="calendar-icon" onclick="BX.calendar({node:this, field:'rekl_date', form: '', bTime: false, currentTime: '1406717387', bHideTime: true});" onmouseover="BX.addClass(this, 'calendar-icon-hover');" onmouseout="BX.removeClass(this, 'calendar-icon-hover');" border="0">-->			<div class="clear"></div>
				<?$APPLICATION->IncludeComponent("bitrix:main.calendar","",Array(
					 "SHOW_INPUT" => "N",
					 "FORM_NAME" => "",
					 "INPUT_NAME" => "rekl_date",
					 "INPUT_NAME_FINISH" => "rekl_date",
					 "INPUT_VALUE" => "",
					 "INPUT_VALUE_FINISH" => "", 
					 "SHOW_TIME" => "N",
					 "HIDE_TIMEBAR" => "Y"
					)
				);?>
			</div>
			<div id="rekl_item_block_wrapper">
				<div class="rekl_item_block">
					<table class="item">
						<tr>
							<td>Наименование</td>
							<td>Последние цифры спецификации
							<div class="btn_show_info"><div class="btn_show_info_text" style="display: none; background:url(/bitrix/templates/eshop_adapt_/images/new_images/spec_num.jpg) 0 0 / contain no-repeat;">help</div></div>
							</td>
							<td>Номер партии (IP00, IP20)
							<div class="btn_show_info"><div class="btn_show_info_text" style="display: none;background:url(/bitrix/templates/eshop_adapt_/images/new_images/issue_num.jpg) 0 0 / contain no-repeat;">help</div></div>
							</td>
							<td>Количество продукции с дефектом</td>
							<td>Общее количество приобретённого вида продукции</td>
						</tr>
						<tr>
							<td>
								<input type="text" name="rekl_item_name_1" class="rekl_item_name" value="">
								<div id="search_wrapper"></div>
							</td>
							<td><input type="text" name="rekl_last_num_1" id="rekl_last_num" value="" disabled /></td>
							<td><input type="text" name="rekl_issue_num_1" id="rekl_issue_num" value="" disabled /></td>
							<td><input type="text" name="rekl_def_num_1" id="rekl_def_num" value=""> шт.</td>
							<td><input type="text" name="rekl_all_num_1" id="rekl_all_num" value=""> шт.</td>
						</tr>
					</table>
					<div class="checkboxes">
						
							<label for="rekl_first_on_1" class="pseudo_check_reclam marg_check"><input type="checkbox" name="rekl_first_on_1" id="rekl_first_on_1" style="">
							Не работает при первом включении</label>						
						
							<label for="rekl_stop_after_1" class="pseudo_check_reclam marg_check" style="float: left;"><input type="checkbox" name="rekl_stop_after_1" id="rekl_stop_after_1" style=""/>
							Перестал работать через</label>
							
							<label style="float: left; display: block; margin-top: 15px; font: normal 12px/18px Arial; margin-bottom: 26px;"><input type="text" name="rekl_stop_days_1" id="rekl_stop_days_1" style="width: 20px; margin: -2px 10px 0 10px;"/>дней</label>
						
					</div>
					<div class="rekl_field textarea">
						<div class="field_title textarea">Подробное описание дефекта<span class="red">*</span></div>	
							<textarea rows="4" cols="40" name="rekl_def_desc_1" id="rekl_def_desc" required></textarea>					
					</div>
					<div class="rekl_field textarea">
						<div class="field_title textarea">Возможные причины возникновения дефекта</div>
							<textarea rows="4" cols="40" name="rekl_def_cause_1" id="rekl_def_cause"></textarea>					
					</div>
					<div class="rekl_field">
						<div class="field_title">В какой момент был обнаружен дефект  <span class="red">*</span></div>
						<input type="text" name="rekl_def_moment_1" id="rekl_def_moment" value="" required>
					</div>
					<hr/>
					<p class="photo_title">Описание дефекта должно быть подтверждено фотографическими изображениями (.jpg, .png, .gif до 5 Мб).</p>
					<div class="rekl_field">
						<div class="field_title" style="float: left; display: block;">Прикрепите фотографии<span class="red">*</span></div>
						<div class="files_wrapper">
							<div class="add_file_btn pseudo_inp_file">
								<span class="sel_f">Выберите файл</span>
								<div class="real_inp_file">
									<label for=""><input type="file" size="0" value="" name="rekl_def_photo_1[]" required></label>							
								</div>
							</div>						
						</div>
						<input type="button" id="add_file" value="" />
					</div>			
				</div>
			</div>
			<input type="button" id="add_position" value="Добавить новую позицию" />
			
			<div class="rekl_field files">
				<div class="field_title">Прикрепите Акт о браке (.jpg, .pdf, .doc, .docx, до 5 Мб)</div>
				<div class="files_wrapper">
					<div class="add_file_btn pseudo_inp_file">
						<span class="sel_f">Выберите файл</span>
						<div class="real_inp_file">
							<label for=""><input type="file" size="0" value="" name="rekl_def_brak[]"></label>
						</div>
					</div>
				</div>	
				<input type="button" id="add_file" value="" />
			</div>	
			
			<div class="rekl_field files">
				<div class="field_title">Прикрепите Акт о бое (.jpg, .pdf, .doc, .docx, до 5 Мб)</div>
				<div class="files_wrapper">
					<div class="add_file_btn pseudo_inp_file">
						<span class="sel_f">Выберите файл</span>
						<div class="real_inp_file">
							<label for=""><input type="file" size="0" value="" name="rekl_def_boy[]"></label>
						</div>
					</div>
				</div>
				<input type="button" id="add_file" value="" />
			</div>	
			<div class="rekl_field files">
				<div class="field_title">Прочее (.jpg, .pdf, .doc, .docx, до 5 Мб)</div>
				<div class="files_wrapper">
					<div class="add_file_btn pseudo_inp_file">
						<span class="sel_f">Выберите файл</span>
						<div class="real_inp_file">
							<label for=""><input type="file" size="0" value="" name="rekl_def_else[]"></label>
						</div>
					</div>
				</div>
				<input type="button" id="add_file" value="" />
			</div>	
				
			<input type="submit" value="Отправить"/>
			<div id="questionary_err"></div>
		</form>
	</div>
	<div class="clear"></div>
</div>
<?
//принимаем POST
if(isset($_POST['checkproduct'])){

	$product = $_POST['val'];
	$productID = $_POST['item_id'];
	$prodPart = substr($product, 0, 7);
	$iblockID = 2;
	
	if(CModule::IncludeModule("iblock")){
		$dbSelect = CIBlockElement::GetList(array(), array("IBLOCK_ID"=>$iblockID, "NAME"=>$prodPart.'%', "ACTIVE"=>"Y"));
		if($arRes = $dbSelect->GetNext()){
			
			$sectionID = $arRes['IBLOCK_SECTION_ID'];
		}
		
		//массив разделов
	  $db_list = CIBlockSection::GetList(Array(), Array('IBLOCK_ID'=>$iblockID), false, Array('ID','CODE','DEPTH_LEVEL','IBLOCK_SECTION_ID'));	  
	  while($ar_result = $db_list->GetNext())
	  {		
		$arSections[] = $ar_result;
	  }
	  ?><pre><?//print_r($arSections);?></pre><?
	  $SecID = $sectionID;  
	  
	  //выберем из массива раздела родительский раздел первого уровня
	  function finder($arSections, $SecID){			
		foreach($arSections as $section){
			if($SecID){
			
				if($section['ID']==$SecID){
					if($section['DEPTH_LEVEL']=='2'){						
						return $section['ID'];						
					}else{						
						$TmpPage = finder($arSections, $section['IBLOCK_SECTION_ID']);
					}
				}
				 
			}else{
				if($section['ID']==$SecID){
					
					if($section['DEPTH_LEVEL']=='2'){						
						return $section['ID'];						
					}else{
						$TmpPage = finder($arSections, $section['IBLOCK_SECTION_ID']);
					}
				}
			}			
		}		
		return $TmpPage;		
	  }
	  
		$page = finder($arSections, $SecID);
		
		if($page == '25'){
			$checknum = '2';
			if($productID > 0){
				if(CModule::IncludeModule('catalog')){
					$arEl = CCatalogProduct::GetByIDEx($productID);
					if($arEl['PROPERTIES']['DEGREE_OF_PROTECTION']['VALUE_ENUM'] == 'IP20' || $arEl['PROPERTIES']['DEGREE_OF_PROTECTION']['VALUE_ENUM'] == 'IP00'){
						$checknum = '1';
					}else{
						$checknum = '2';
					}
				}
			}
			?><div id="test_res"><?=$checknum?></div><?
		}elseif($page == '180'){
			?><div id="test_res">3</div><?
		}
	
		
	}
	
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>