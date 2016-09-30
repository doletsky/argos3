<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Заполнить анкету на вакансию Аргос-Трейд или Аргос-Электрон");
$APPLICATION->SetPageProperty("keywords", "анкета аргос-трейд, анкета аргос-электрон");
$APPLICATION->SetPageProperty("title", "Заполнить анкету на вакансию Аргос-Трейд или Аргос-Электрон");
$APPLICATION->SetTitle("Заполнить анкету на вакансию Аргос-Трейд или Аргос-Электрон");?>

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
		<h1>Заполнить анкету</h1>
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
		<form id="questionary_form" class="symple_form_page">
			<div class="field_title">Резюме на вакансию</div>
			<input type="text" value="" name="questionary_vacancy" id="questionary_vacancy" />			
			<div class="field_title">Уровень заработной платы</div>
			<input type="text" name="questionary_wages" id="questionary_wages" value="" />
			<div class="field_title">ФИО *</div>
			<input type="text" name="questionary_name" id="questionary_name" value="" />
			<div class="field_title">Дата рождения *</div>
			<?$GLOBALS["APPLICATION"]->IncludeComponent("bitrix:main.calendar","calendar_new",Array(
				"SHOW_INPUT" => "Y",
				//"FORM_NAME" => "form1",
				"INPUT_NAME" => "questionary_date_of_birth",
				//"INPUT_NAME_FINISH" => "",
				//"INPUT_VALUE" => date("d.m.Y"),
				"INPUT_VALUE" => "",
				//"INPUT_VALUE_FINISH" => "", 
				"SHOW_TIME" => "N",
				"HIDE_TIMEBAR" => "Y"
				)
			);?>
			<div class="clear"></div>
			<div class="field_title">Место проживания *</div>
			<input type="text" name="questionary_address" id="questionary_address" value="" />
			<div class="field_title">Контактный телефон *</div>
			<input type="text" name="questionary_phone" id="questionary_phone" value="" />
			<div class="field_title">Адрес электронной почты *</div>
			<input type="text" name="questionary_email" id="questionary_email" value="" />
			<div class="field_title">Уровень образования</div>
			<input type="text" name="questionary_level_of_education" id="questionary_level_of_education" value="" />
			<div class="form_title">Опыт работы *</div>
			<div class="hint">Указывается за период последних 10 лет трудовой деятельности, начиная с последнего.</div>
			<div id="experience_block">
				<div class="experience_wrap" id="experience_1">
					<div class="field_title">Занимаемая должность</div>
					<input type="text" name="questionary_post_1" id="questionary_post_1" class="questionary_post" value="" />
					<div class="field_title">Наименование организации</div>
					<input type="text" name="questionary_organization_1" id="questionary_organization_1" class="questionary_organization" value="" />
					<div class="field_title">Период работы</div>
					<input type="text" name="questionary_period_1" id="questionary_period_1" class="questionary_period" value="" />
					<div class="field_title">Должностные обязанности</div>
					<textarea name="questionary_responsibility_1" id="questionary_responsibility_1" class="questionary_responsibility"></textarea>
					<div class="field_title">Основные достижения</div>
					<textarea name="questionary_progress_1" id="questionary_progress_1" class="questionary_progress"></textarea>
				</div>
			</div>
			<div id="btn_add_experience">Добавить организацию</div>
			<div class="field_title">Наименование учебного заведения</div>
			<input type="text" name="questionary_institution" id="questionary_institution" value="" />
			<div class="field_title">Год окончания</div>
			<?$GLOBALS["APPLICATION"]->IncludeComponent("bitrix:main.calendar","calendar_new",Array(
				"SHOW_INPUT" => "Y",
				//"FORM_NAME" => "form1",
				"INPUT_NAME" => "questionary_finish_year",
				//"INPUT_NAME_FINISH" => "",
				//"INPUT_VALUE" => date("d.m.Y"),
				"INPUT_VALUE" => "",
				//"INPUT_VALUE_FINISH" => "", 
				"SHOW_TIME" => "N",
				"HIDE_TIMEBAR" => "Y"
				)
			);?>
			<div class="clear"></div>
			<div class="field_title">Специальность</div>
			<input type="text" name="questionary_specialty" id="questionary_specialty" value="" />
			<div class="field_title">Дополнительное образование (курсы / тренинги)</div>
			<textarea name="questionary_courses" id="questionary_courses"></textarea>
			<div class="field_title">Ключевые навыки</div>
			<textarea name="questionary_skills" id="questionary_skills"></textarea>
			<div class="field_title">О себе</div>
			<textarea name="questionary_about" id="questionary_about"></textarea>
			
			<input type="submit" value="Отправить" />
			<div id="questionary_err"></div>
		</form>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>