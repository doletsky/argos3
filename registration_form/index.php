<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заявка на регистрацию");?>

<div id="content" class="whole_page">
	<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "eshop_adapt", array(
			"START_FROM" => "1",
			"PATH" => "",
			"SITE_ID" => "-"
		),
		false,
		Array('HIDE_ICONS' => 'Y')
	);?>
	<h1>Заявка на регистрацию</h1>
	<div id="print">Печатная версия</div>
	<div class="clear"></div>
	<p class="text_page_info">После заполнения заявки Вы получите логин и пароль по электронной почте.</p>
	<form id="registration_form" class="symple_form_page">
		<input type="text" name="registration_form_company" id="registration_form_company" value="Юридическое название компании *" />
		<input type="text" name="registration_form_view" id="registration_form_view" value="Вид деятельности *" />
		<input type="text" name="registration_form_address" id="registration_form_address" value="Почтовый адрес компании *" />
		<input type="text" name="registration_form_name" id="registration_form_name" value="Ответственное лицо ФИО *" />
		<input type="text" name="registration_form_post" id="registration_form_post" value="Должность *" />
		<input type="text" name="registration_form_email" id="registration_form_email" value="E-mail *" />
		<input type="text" name="registration_form_phone" id="registration_form_phone" value="Телефон +7-111-11-11 *" />		
		<input type="text" name="registration_form_site" id="registration_form_site" value="Сайт" />		
		<textarea name="registration_form_mess" id="registration_form_mess">В какой форме происходит сотрудничество с компанией и по какой продукции *</textarea>
		<input type="submit" value="Отправить" />
		<div id="registration_form_err"></div>
	</form>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>