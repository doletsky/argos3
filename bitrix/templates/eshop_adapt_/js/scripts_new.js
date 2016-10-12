function addToCart(element) {
	if (!element && !element.href)
		return;
	
	var href = element.href;		 
	var button = $(element);
	
	if (href)
		$.get( href+"&ajax_buy=1",
		$.proxy(
	  		function(data) {
				data=$(data).find("#bx_cart_num").html();
				$('#bx_cart_num').html(data);
				$('#make_order_mess').text('Выбранные позиции добавлены в корзину');
			}, button)
		);             
	return false;
}
//Предупреждение при закрытии страниц сайта
/*$(function(){
	$(window).bind('beforeunload', function(event) {
		event.preventDefault();
		event.originalEvent.returnValue = 'При закрытии сайта все заказы в корзине будут не сохранены.';
	});
	// WebKit has bug https://bugs.webkit.org/show_bug.cgi?id=20135
	window.onbeforeunload = function(){ return 'При закрытии сайта все заказы в корзине будут не сохранены.'; } 
	// Opera do not support onbeforeunload !!!
});*/

function simHeight(target){
	var maxHeight = 0;
	$('.bx_catalog_item').find(target).each(function(){
		if ($(this).outerHeight() > maxHeight){
			maxHeight = $(this).outerHeight();
		}
	});
  //console.log($('.bx_catalog_item').find(target));

  $('.bx_catalog_item').find(target).each(function(){
		$(this).height(maxHeight);
	});
}

$(document).ready(function() {

  simHeight('.sim-height');

	//Предупреждение при закрытии страниц сайта
	/*$(document).mouseleave(function(e){
		if(e.pageY <= 1)//при покидании области сайта через верх
		{
			if(($('#bx_cart_num').text().replace('(','').replace(')','')*1)>0)//если корзина не пуста
			{
				//alert('Уже уходите?');
				$('#modal_w_wrap').fadeIn(1);
				$("#modal_w_body").fadeIn(1);
				$("#exit_site_win").fadeIn(1000);
			}
		}
	});
	//Закрытие модального окна
	$(".modal_w .close, .modal_w .close_win, #modal_w_wrap").live('click',function(){
		$(".modal_w").fadeOut(400);
		$("#modal_w_body").fadeOut(1);
		$("#modal_w_wrap").fadeOut(400);
	});*/
	
	//Страница вакансии русс версия - переход по вкладкам
	$("#tab_vacancy_wrap .tab_grey_style").live("click",function() {
		$("#tab_vacancy_wrap .tab_grey_style").removeClass('current');
		$(this).addClass('current');
		var tab_id=$(this).attr('id');
		$('#tab_vacancy_wrap .vacancy_content').removeClass('current');
		$('#tab_vacancy_wrap .vacancy_content#vacancy_content_'+tab_id).addClass('current');
	});
	//Страница Заполнить анкету на вакансию
	var count_experience_blocks=2;
	//Добавление блока места работы
	$("#questionary_form #btn_add_experience").live("click",function() {
		$('#experience_block').append('<div class="experience_wrap" id="experience_'+count_experience_blocks+'"><div class="field_title">Занимаемая должность</div><input type="text" name="questionary_post_'+count_experience_blocks+'" id="questionary_post_'+count_experience_blocks+'" class="questionary_post" value="" /><div class="field_title">Наименование организации</div><input type="text" name="questionary_organization_'+count_experience_blocks+'" id="questionary_organization_'+count_experience_blocks+'" class="questionary_organization" value="" /><div class="field_title">Период работы</div><input type="text" name="questionary_period_'+count_experience_blocks+'" id="questionary_period_'+count_experience_blocks+'" class="questionary_period" value="" /><div class="field_title">Должностные обязанности</div><textarea name="questionary_responsibility_'+count_experience_blocks+'" id="questionary_responsibility_'+count_experience_blocks+'" class="questionary_responsibility"></textarea><div class="field_title">Основные достижения</div><textarea name="questionary_progress_'+count_experience_blocks+'" id="questionary_progress_'+count_experience_blocks+'" class="questionary_progress"></textarea><div class="delite_experience">удалить</div></div>');
		count_experience_blocks++;
	});
	//удаление блока места работы
	$("#questionary_form .delite_experience").live("click",function() {
		$(this).closest('.experience_wrap').remove();
	});
	//Валидация и отправка формы
	$("#questionary_form input[type='submit']").live("click",function()
    {
        var questionary_vacancy = $("#questionary_vacancy").val();
        var questionary_wages = $("#questionary_wages").val();//не обязательное
        var questionary_name = $("#questionary_name").val();
        var questionary_date_of_birth = $("#questionary_date_of_birth").val();
        var questionary_address = $("#questionary_address").val();
        var questionary_phone = $("#questionary_phone").val();
        var questionary_email = $("#questionary_email").val();
        var questionary_level_of_education = $("#questionary_level_of_education").val();//не обязательное
        	
        var questionary_institution = $("#questionary_institution").val();//не обязательное
        var questionary_finish_year = $("#questionary_finish_year").val();//не обязательное
        var questionary_specialty = $("#questionary_specialty").val();//не обязательное
        var questionary_courses = $("#questionary_courses").val();//не обязательное
        var questionary_skills = $("#questionary_skills").val();//не обязательное
        var questionary_about = $("#questionary_about").val();//не обязательное
		
		var count_experience=0;
		var arr_experience = Array();
		$('#experience_block .experience_wrap').each(function(){
			var arr_new = Array();
			arr_new[0] =  $(this).find('.questionary_post').val()+'&&&';
			arr_new[1] =  $(this).find('.questionary_organization').val()+'&&&';
			arr_new[2] =  $(this).find('.questionary_period').val()+'&&&';
			arr_new[3] =  $(this).find('.questionary_responsibility').val()+'&&&';
			arr_new[4] =  $(this).find('.questionary_progress').val();
			
			arr_experience[count_experience]=arr_new;
			count_experience++;
		});
		$.post("/bitrix/templates/eshop_adapt_/libs/submit_forms.php",{questionary_vacancy:questionary_vacancy,questionary_wages:questionary_wages,questionary_name:questionary_name,questionary_date_of_birth:questionary_date_of_birth,questionary_address:questionary_address,questionary_phone:questionary_phone,questionary_email:questionary_email,questionary_level_of_education:questionary_level_of_education,questionary_institution:questionary_institution,questionary_finish_year:questionary_finish_year,questionary_specialty:questionary_specialty,questionary_courses:questionary_courses,questionary_skills:questionary_skills,questionary_about:questionary_about,'arr_experience[]':arr_experience},function(data)
		{
			if(data=='ok')
			{
				$("#questionary_err").html('Спасибо, ваша заявка принята');
			}
			else
			{
				$('#questionary_form input[type="text"]').removeClass('err');
				$('#questionary_form textarea').removeClass('err');
				$("#questionary_"+data).addClass('err');
				ancLink('#questionary_'+data);
			}
		});
        /*$.post("/bitrix/templates/eshop_adapt_/libs/submit_forms.php",{},function(data)
        {
            if(data=='ok')
			{
				$('#ask_question_form input[type="text"]').removeClass('err');
				$('#ask_question_form textarea').removeClass('err');
				if(lang=="RUS")
				{
					$('#ask_question_err').text('Спасибо, ваш вопрос отправлен!').fadeIn();
					$("#ask_question_name").val('ФИО');
					$("#ask_question_phone").val('Телефон');
					$("#ask_question_email").val('E-mail');
					$("#ask_question_mess").val('Вопрос');
				}
				if(lang=="ENG")
				{
					$('#ask_question_err').text('Thank you, your question has been sent!').fadeIn();
					$("#ask_question_name").val('Full name');
					$("#ask_question_phone").val('Phone');
					$("#ask_question_email").val('E-mail');
					$("#ask_question_mess").val('Question');
				}
			}
			else
			{
				$('#ask_question_form input[type="text"]').removeClass('err');
				$('#ask_question_form textarea').removeClass('err');
				if(data=='name')
					$("#ask_question_name").addClass('err');
				if(data=='email')
					$("#ask_question_email").addClass('err');
				if(data=='mess')
					$("#ask_question_mess").addClass('err');
			}
        });*/
		return false;
    });
	
	
	//Галерея изображений на страницах выставок
	if($('.exhibition_wrap').length>0)
	{
		$('.bxslider').each(function(){
			var bx_pager_id=$(this).closest('.multimedia_slider').find('.bx-pager').attr('id');
			$(this).bxSlider({
				pagerCustom: '#'+bx_pager_id,
				captions: true,
				speed: 1000,
				pause: 0,
			});
		});
		
		$('.multimedia_slider .bx-prev, .multimedia_slider .bx-next').click(function() {
			var wrap=$(this).closest('.multimedia_slider').find('.bx-pager');
			var active_img_pos=$(this).closest('.multimedia_slider').find('.bx-pager a.active').attr('data-slide-index');
			var active_img_pos_l=$(this).closest('.multimedia_slider').find('.bx-pager a.active').position().left;
			var new_val=active_img_pos-6;			
			if(active_img_pos<6)
				wrap.animate({"scrollLeft":0},"slow");
			else
				wrap.animate({"scrollLeft":new_val*97},"slow");
		});
	}
	//Галерея изображений на страницах Мультимедиа
	if($('.multimedia_body').length>0)
	{
		$('.bxslider').each(function(){
			var bx_pager_id=$(this).closest('.multimedia_slider').find('.bx-pager').attr('id');
			$(this).bxSlider({
				pagerCustom: '#'+bx_pager_id,
				captions: true,
				speed: 1000,
				pause: 0,
			});
		});
		
		$('.multimedia_slider .bx-prev, .multimedia_slider .bx-next').click(function() {
			var wrap=$(this).closest('.multimedia_slider').find('.bx-pager');
			var active_img_pos=$(this).closest('.multimedia_slider').find('.bx-pager a.active').attr('data-slide-index');
			var active_img_pos_l=$(this).closest('.multimedia_slider').find('.bx-pager a.active').position().left;
			var new_val=active_img_pos-6;			
			if(active_img_pos<6)
				wrap.animate({"scrollLeft":0},"slow");
			else
				wrap.animate({"scrollLeft":new_val*97},"slow");
		});
	}
	
	$('#share_form #share_email').defaultText('E-mail');
	//Валидация формы Поделиться
	$("#share_form input[type='submit']").live("click",function()
    {
        var share_email = $("#share_email").val();
		var href=window.location.href;
		var lang=$('#active_language').text();
        $.post("/bitrix/templates/eshop_adapt_/libs/submit_forms.php",{share_email:share_email,href:href,lang:lang},function(data)
        {
            if(data=='Link has been sent!' || data=='Ссылка была отправлена!')
			{
				$('#share_err').text(data).fadeIn();
				$("#share_email").val('E-mail');
			}
			else
			{
				$('#share_err').text(data).fadeIn();
			}
        });
		return false;
    });
	//Вызов формы Поделиться
	$('#social_buttons #share').live('click',function(){
		$('#modal_w_wrap').fadeIn(1);
		$("#modal_w_body").fadeIn(1);
		$("#share_win").fadeIn(1000);
	});
	//Закрытие модального окна
	$(".modal_w .close, .modal_w .close_win, #modal_w_wrap").live('click',function(){
		$(".modal_w").fadeOut(400);
		$("#modal_w_body").fadeOut(1);
		$("#modal_w_wrap").fadeOut(400);
	});
	
	//Валидация формы Задать вопрос
	if($("#ask_question_name").val()=='Full name')
		$("#ask_question_name").defaultText('Full name');
	if($("#ask_question_name").val()=='ФИО')
		$("#ask_question_name").defaultText('ФИО');
		
	if($("#ask_question_phone").val()=='Phone')
		$("#ask_question_phone").defaultText('Phone');
	if($("#ask_question_phone").val()=='Телефон')
		$("#ask_question_phone").defaultText('Телефон');
		
	$("#ask_question_email").defaultText('E-mail');
		
	if($("#ask_question_mess").val()=='Question')
		$("#ask_question_mess").defaultText('Question');
	if($("#ask_question_mess").val()=='Вопрос')
		$("#ask_question_mess").defaultText('Вопрос');
		
	$("#ask_question_form input[type='submit']").live("click",function()
    {
        var ask_question_name = $("#ask_question_name").val();
        var ask_question_phone = $("#ask_question_phone").val();
        var ask_question_email = $("#ask_question_email").val();
        var ask_question_mess = $("#ask_question_mess").val();
		var lang=$('#active_language').text().trim();
		
        $.post("/bitrix/templates/eshop_adapt_/libs/submit_forms.php",{ask_question_name:ask_question_name,ask_question_phone:ask_question_phone,ask_question_email:ask_question_email,ask_question_mess:ask_question_mess,lang:lang},function(data)
        {
            if(data=='ok')
			{
				$('#ask_question_form input[type="text"]').removeClass('err');
				$('#ask_question_form textarea').removeClass('err');
				
				if(lang=="RUS")
				{				
					$('#ask_question_err').text('Спасибо, ваш вопрос отправлен!').fadeIn();
					$("#ask_question_name").val('ФИО');
					$("#ask_question_phone").val('Телефон');
					$("#ask_question_email").val('E-mail');
					$("#ask_question_mess").val('Вопрос');
				}
				if(lang!=="RUS")
				{
				
					$('#ask_question_err').text('Thank you, your question has been sent!').fadeIn();
					$("#ask_question_name").val('Full name');
					$("#ask_question_phone").val('Phone');
					$("#ask_question_email").val('E-mail');
					$("#ask_question_mess").val('Question');
				}
			}
			else
			{
				$('#ask_question_form input[type="text"]').removeClass('err');
				$('#ask_question_form textarea').removeClass('err');
				if(data=='name')
					$("#ask_question_name").addClass('err');
				if(data=='email')
					$("#ask_question_email").addClass('err');
				if(data=='mess')
					$("#ask_question_mess").addClass('err');
			}
        });
		return false;
    });
	
	//Валидация формы Заявка на регистрацию
	if($("#registration_form #registration_form_company").val()=='Юридическое название компании *')
		$("#registration_form #registration_form_company").defaultText('Юридическое название компании *');
	if($("#registration_form #registration_form_company").val()=='Company name *')
		$("#registration_form #registration_form_company").defaultText('Company name *');
		
	if($("#registration_form #registration_form_view").val()=='Вид деятельности *')
		$("#registration_form #registration_form_view").defaultText('Вид деятельности *');
	if($("#registration_form #registration_form_view").val()=='Kind of activity *')
		$("#registration_form #registration_form_view").defaultText('Kind of activity *');
		
	if($("#registration_form #registration_form_address").val()=='Почтовый адрес компании *')
		$("#registration_form #registration_form_address").defaultText('Почтовый адрес компании *');
	if($("#registration_form #registration_form_address").val()=='Company\'s post address *')
		$("#registration_form #registration_form_address").defaultText('Company\'s post address *');
	
	if($("#registration_form #registration_form_name").val()=='Ответственное лицо ФИО *')
		$("#registration_form #registration_form_name").defaultText('Ответственное лицо ФИО *');
	if($("#registration_form #registration_form_name").val()=='Person responsible (Name, Surname) *')
		$("#registration_form #registration_form_name").defaultText('Person responsible (Name, Surname) *');
	
	if($("#registration_form #registration_form_post").val()=='Должность *')
		$("#registration_form #registration_form_post").defaultText('Должность *');
	if($("#registration_form #registration_form_post").val()=='Position *')
		$("#registration_form #registration_form_post").defaultText('Position *');
	
	if($("#registration_form #registration_form_phone").val()=='Телефон +7-111-11-11 *')
		$("#registration_form #registration_form_phone").defaultText('Телефон +7-111-11-11 *');
	if($("#registration_form #registration_form_phone").val()=='Telephone +7-111-11-11 *')
		$("#registration_form #registration_form_phone").defaultText('Telephone +7-111-11-11 *');
	
	if($("#registration_form #registration_form_site").val()=='Сайт')
		$("#registration_form #registration_form_site").defaultText('Сайт');
	if($("#registration_form #registration_form_site").val()=='Website')
		$("#registration_form #registration_form_site").defaultText('Website');
	
	if($("#registration_form #registration_form_mess").val()=='В какой форме происходит сотрудничество с компанией и по какой продукции *')
		$("#registration_form #registration_form_mess").defaultText('В какой форме происходит сотрудничество с компанией и по какой продукции *');
	if($("#registration_form #registration_form_mess").val()=='How do you collaborate with the company? What products are being ordered? *')
		$("#registration_form #registration_form_mess").defaultText('How do you collaborate with the company? What products are being ordered? *');
		
		
	$("#registration_form #registration_form_email").defaultText('E-mail *');
	
	$("#registration_form input[type='submit']").live("click",function()
    {
        var r_f_company = $("#registration_form_company").val();
        var r_f_view = $("#registration_form_view").val();
        var r_f_address = $("#registration_form_address").val();
        var r_f_name = $("#registration_form_name").val();
        var r_f_post = $("#registration_form_post").val();
        var r_f_phone = $("#registration_form_phone").val();
        var r_f_site = $("#registration_form_site").val();
        var r_f_mess = $("#registration_form_mess").val();
        var r_f_email = $("#registration_form_email").val();        
		var lang=$('#active_language').text().trim();
		
        $.post("/bitrix/templates/eshop_adapt_/libs/submit_forms.php",{r_f_company:r_f_company,r_f_view:r_f_view,r_f_address:r_f_address,r_f_name:r_f_name,r_f_post:r_f_post,r_f_phone:r_f_phone,r_f_site:r_f_site,r_f_mess:r_f_mess,r_f_email:r_f_email,lang:lang},function(data)
        {
		
            if(data=='ok')
			{
				$('#registration_form input[type="text"]').removeClass('err');
				$('#registration_form textarea').removeClass('err');
				if(lang=="RUS")
				{
				
					$('#registration_form_err').text('Спасибо, ваша заявка отправлена!').fadeIn();
					$("#registration_form_company").val('Юридическое название компании *');
					$("#registration_form_view").val('Вид деятельности *');
					$("#registration_form_address").val('Почтовый адрес компании *');
					$("#registration_form_name").val('Ответственное лицо ФИО *');
					$("#registration_form_post").val('Должность *');
					$("#registration_form_phone").val('Телефон *');
					$("#registration_form_site").val('Сайт');
					$("#registration_form_mess").val('В какой форме происходит сотрудничество с компанией и по какой продукции *');
					$("#registration_form_email").val('E-mail *');
				}
				if(lang!=="RUS")
				{
				
					$('#registration_form_err').text('Thank you, your request has been sent!').fadeIn();
					$("#registration_form_company").val('Company name *');
					$("#registration_form_view").val('Kind of activity *');
					$("#registration_form_address").val('Company\'s post address *');
					$("#registration_form_name").val('Person responsible (Name, Surname) *');
					$("#registration_form_post").val('Position *');
					$("#registration_form_phone").val('Telephone *');
					$("#registration_form_site").val('Website');
					$("#registration_form_mess").val('How do you collaborate with the company? What products are being ordered? *');
					$("#registration_form_email").val('E-mail *');
				}
			}
			else
			{
				$('#registration_form input[type="text"]').removeClass('err');
				$('#registration_form textarea').removeClass('err');
				$("#registration_form_"+data).addClass('err');
				
				$("#registration_form_err").html(data);
			}
        });
		return false;
    });
	
	//Псевдо Select
	$('.pseudo-select .select').live('click', function()
	{				
		if($(this).parent().find('.options').is(':visible'))
		{
			var vis="true";
		}
		else
			vis="false";
		if(vis=="true")
		{
			$(this).parent().find('.options').fadeOut('fast');
			$(this).removeClass('hover');
	
		}
		else
		{
			$(this).parent().find('.options').fadeIn('fast');
			$(this).addClass('hover');
		}
	});
						
	$('.pseudo-select .options > li').live('click', function() {
		if(!$(this).hasClass('all'))
		{
			if($(this).find('input[type="checkbox"]').is(':checked')!=true)
			{
				$(this).closest('.pseudo-select').find('input[type="checkbox"]').attr("checked","");
				$(this).find('input[type="checkbox"]').attr("checked","checked");
				$(this).closest('.pseudo-select').find('.select').text($(this).find('span').text());
				$.each($(this).parent().find('span.check'), function(){
					$(this).removeClass('check');
				});
				$(this).find('span').addClass('check');
				$(this).find('input[type="checkbox"]').change();
				$(this).parent().fadeOut('fast');
			}
			else
			{
				$(this).parent().fadeOut('fast');
			}
		}
	});
	$('.pseudo-select .options > li.all').live('click', function() {
		$(this).closest('.pseudo-select').find('input[type="checkbox"]').attr("checked","");
		$(this).closest('.pseudo-select').find('.select').text($(this).find('span').text());
		$.each($(this).parent().find('span.check'), function(){
			$(this).removeClass('check');
		});
		$(this).find('span').addClass('check');
		$(this).closest('.options').find('li:last-child').find('input[type="checkbox"]').change();
		$(this).parent().fadeOut('fast');
	});
	
	
	
	$('#add_new_item_to_cart.en input[type="text"]').defaultText('Product quickfinder');
	$('#add_new_item_to_cart input[type="text"]').defaultText('Быстрый поиск товара');
	
	//Автокомплит
	$('#add_new_item_to_cart input[type="text"]').live('keyup',function(){
		var item_name_part=$(this).val();
		$.post("/bitrix/templates/eshop_adapt_/libs/add_new_item_to_cart.php",{item_name_part:item_name_part},function(data)
		{
			$('#add_new_item_to_cart #search_complete #search_complete_list').html(data);
		});
	});
	$('#add_new_item_to_cart #search_complete #search_complete_list #items_name_list li').live('click',function(){		
		var item_name_new=$(this).text();
		if(item_name_new!='Соответствий не найдено')
		{
			var iblock_id=$(this).attr('iblock_id');
			var item_id=$(this).attr('item_id');
			$('#add_new_item_to_cart input[type="text"]').val(item_name_new);
			$('#add_new_item_to_cart input[type="text"]').attr('iblock_id',iblock_id);
			$('#add_new_item_to_cart input[type="text"]').attr('item_id',item_id);
			$('#search_complete_list').text('');
		}
	});
	
	//Автокомплит для рекламации
	$('.rekl_item_name').live('keyup',function(){
		var item_name_part=$(this).val();
		name = $(this).attr('name');
		
		$.post("/bitrix/templates/eshop_adapt_/libs/add_new_item_to_cart.php",{item_name_part:item_name_part},function(data)
		{			
			$('input[name='+name+']').siblings('#search_wrapper').html(data);
		});
	});
	
	$('#search_wrapper #items_name_list li').live('click',function(){		
		var item_name_new=$(this).text(),
			item_id = $(this).attr('item_id');
		if(item_name_new!='Соответствий не найдено')
		{			
			$(this).parents('#search_wrapper').siblings('.rekl_item_name').val(item_name_new);
			$(this).parents('#search_wrapper').siblings('.rekl_item_name').attr('item_id', item_id);		
			$(this).parents('#search_wrapper').text('');
		}
	});
	
	$('.workarea_wrap').live('click',function(){
		$('#search_wrapper').text('');
	})
	
	
	//Автокомплит для портфолио
	$('.data-table .multiinput').live('keyup',function(){
		if($(this).attr('prop') == 88 || $(this).attr('prop') == 175){
			var item_name_part=$(this).val();
			name = $(this).attr('name');
			arpos = $(this).attr('arpos');
			prop = $(this).attr('prop');
			
			$.post("/bitrix/templates/eshop_adapt_/libs/add_new_item_to_cart.php",{item_name_part:item_name_part},function(data)
			{	
				$('input[arpos='+arpos+'][prop='+prop+']').next('#search_wrapper_'+arpos).html(data);
			});
		}
	});
	
	$('.search_wrapper #items_name_list li').live('click',function(){		
		var item_name_new=$(this).text();
		if(item_name_new!='Соответствий не найдено')
		{			
			$(this).parents('.search_wrapper').prev('.multiinput').val(item_name_new);			
			$(this).parents('.search_wrapper').text('');
		}
	});
	
	$('.workarea_wrap').live('click',function(){
		$('.search_wrapper').text('');
	})
	
	//====//
	
	//Добавление полей для рекламации
	//фото
	$('#add_file').live('click',function(){
		name = $(this).siblings('.files_wrapper').find('input').attr('name');
		
		$(this).siblings('.files_wrapper').append('<div class="add_file_btn pseudo_inp_file"><span class="sel_f">Выберите файл</span><div class="real_inp_file"><label for=""><input type="file" size="0" value="" name="'+name+'"></label></div></div>');
	});
	
	$('#add_file_en').live('click',function(){
		name = $(this).siblings('.files_wrapper').find('input').attr('name');
		
		$(this).siblings('.files_wrapper').append('<div class="add_file_btn pseudo_inp_file"><span class="sel_f">Select file</span><div class="real_inp_file"><label for=""><input type="file" size="0" value="" name="'+name+'"></label></div></div>');
	});
	
	$('#del_position').live('click', function(){
		$(this).parents('.rekl_item_block').remove();
	})
	
	//позиция en
	var name_suff = 2;
	$('#add_position_en').live('click',function(){			
		$('#rekl_item_block_wrapper').append('<div class="rekl_item_block"><table class="item"><tr><td>Product name</td><td>Last three (serial) numbers<div class="btn_show_info"><div class="btn_show_info_text" style="display: none;">информация информация информация 7</div></div></td><td>Batch number (IP00, IP20)<div class="btn_show_info"><div class="btn_show_info_text" style="display: none;">информация информация информация 7</div></div></td><td>Quantity of defective goods</td><td>Total amount of the type of goods acquired</td></tr><tr><td><input type="text" name="rekl_item_name_'+name_suff+'" class="rekl_item_name" value=""><div id="search_wrapper"></div></td><td><input type="text" name="rekl_last_num_'+name_suff+'" id="rekl_last_num" value="" disabled /></td><td><input type="text" name="rekl_issue_num_'+name_suff+'" id="rekl_issue_num" value="" disabled /></td><td><input type="text" name="rekl_def_num_'+name_suff+'" id="rekl_def_num" value=""> items</td><td><input type="text" name="rekl_all_num_'+name_suff+'" id="rekl_all_num" value=""> items</td></tr></table><div class="checkboxes"><label for="rekl_first_on_'+name_suff+'" class="pseudo_check_reclam marg_check"><input type="checkbox" name="rekl_first_on_'+name_suff+'" id="rekl_first_on_'+name_suff+'" style="">The device remains unresponsive or does not turn on</label><label for="rekl_stop_after_'+name_suff+'" class="pseudo_check_reclam marg_check" style="float: left;"><input type="checkbox" name="rekl_stop_after_'+name_suff+'" id="rekl_stop_after_'+name_suff+'" style=""/>Stopped working after</label><label style="float: left; display: block; margin-top: 15px; font: normal 12px/18px Arial; margin-bottom: 26px;"><input type="text" name="rekl_stop_days_'+name_suff+'" id="rekl_stop_days_1" style="width: 20px; margin: -2px 10px 0 10px;"/>days</label></div><div class="rekl_field textarea"><div class="field_title textarea">Detailed defect report<span class="red">*</span></div><textarea rows="4" cols="40" name="rekl_def_desc_'+name_suff+'" id="rekl_def_desc"></textarea></div><div class="rekl_field textarea"><div class="field_title textarea">Please list possible causes of the defect</div><textarea rows="4" cols="40" name="rekl_def_cause_'+name_suff+'" id="rekl_def_cause"></textarea></div><div class="rekl_field"><div class="field_title">How did you find the defect?<span class="red">*</span></div><input type="text" name="rekl_def_moment_'+name_suff+'" id="rekl_def_moment" value=""></div><hr/><p class="photo_title">Defect report should be supported by digital photos (.jpg, .png, .gif up to 5Mb)</p><div class="rekl_field"><div class="field_title" style="float: left; display: block;"><span class="sel_f">Attach photos</span><span class="red">*</span></div><div class="files_wrapper"><div class="add_file_btn pseudo_inp_file">Select file<div class="real_inp_file"><label for=""><input type="file" size="0" value="" name="rekl_def_photo_'+name_suff+'[]"></label></div></div></div><input type="button" id="add_file_en" value="" /></div><input type="button" value="Delete position" id="del_position"></div>');
		name_suff++;
	});
	
	//позиция ru
	var name_suff = 2;
	$('#add_position').live('click',function(){			
		$('#rekl_item_block_wrapper').append('<div class="rekl_item_block"><table class="item"><tr><td>Наименование</td><td>Последние 3 цифры спецификации<div class="btn_show_info"><div class="btn_show_info_text" style="display: none;">информация информация информация 7</div></div></td><td>Номер партии (IP00, IP20)<div class="btn_show_info"><div class="btn_show_info_text" style="display: none;">информация информация информация 7</div></div></td><td>Количество продукции с дефектом</td><td>Общее количество приобретённого вида продукции</td></tr><tr><td><input type="text" name="rekl_item_name_'+name_suff+'" class="rekl_item_name" value=""><div id="search_wrapper"></div></td><td><input type="text" name="rekl_last_num_'+name_suff+'" id="rekl_last_num" value="" disabled /></td><td><input type="text" name="rekl_issue_num_'+name_suff+'" id="rekl_issue_num" value="" disabled /></td><td><input type="text" name="rekl_def_num_'+name_suff+'" id="rekl_def_num" value=""> шт.</td><td><input type="text" name="rekl_all_num_'+name_suff+'" id="rekl_all_num" value=""> шт.</td></tr></table><div class="checkboxes"><label for="rekl_first_on_'+name_suff+'" class="pseudo_check_reclam marg_check"><input type="checkbox" name="rekl_first_on_'+name_suff+'" id="rekl_first_on_'+name_suff+'" style="">Не работает при первом включении</label><label for="rekl_stop_after_'+name_suff+'" class="pseudo_check_reclam marg_check" style="float: left;"><input type="checkbox" name="rekl_stop_after_'+name_suff+'" id="rekl_stop_after_'+name_suff+'" style=""/>Перестал работать через</label><label style="float: left; display: block; margin-top: 15px; font: normal 12px/18px Arial; margin-bottom: 26px;"><input type="text" name="rekl_stop_days_'+name_suff+'" id="rekl_stop_days_1" style="width: 20px; margin: -2px 10px 0 10px;"/>дней</label></div><div class="rekl_field textarea"><div class="field_title textarea">Подробное описание дефекта<span class="red">*</span></div><textarea rows="4" cols="40" name="rekl_def_desc_'+name_suff+'" id="rekl_def_desc"></textarea></div><div class="rekl_field textarea"><div class="field_title textarea">Возможные причины возникновения дефекта</div><textarea rows="4" cols="40" name="rekl_def_cause_'+name_suff+'" id="rekl_def_cause"></textarea></div><div class="rekl_field"><div class="field_title">В какой момент был обнаружен дефект  <span class="red">*</span></div><input type="text" name="rekl_def_moment_'+name_suff+'" id="rekl_def_moment" value=""></div><hr/><p class="photo_title">Описание дефекта должно быть подтверждено фотографическими изображениями (.jpg, .png, .gif до 5Мб).</p><div class="rekl_field"><div class="field_title" style="float: left; display: block;">Прикрепите фотографии<span class="red">*</span></div><div class="files_wrapper"><div class="add_file_btn pseudo_inp_file"><span class="sel_f">Выберите файл</span><div class="real_inp_file"><label for=""><input type="file" size="0" value="" name="rekl_def_photo_'+name_suff+'[]"></label></div></div></div><input type="button" id="add_file" value="" /></div><input type="button" value="Удалить позицию" id="del_position"></div>');
		name_suff++;
	});

    //инициализация чекбокса в рекламации
    $('.pseudo_check_reclam:first').find('input').attr('checked', true);
    $('.pseudo_check_reclam:first').addClass('check');

	//псевдо чекбокс в рекламации
	$('.pseudo_check_reclam').live('click',function(){
        console.log('script_new: '+$(this).find("input").is(':checked'));
		if($(this).find("input").is(':checked')) //если чекбокс не отмечен
		{
            $('.pseudo_check_reclam input').attr('checked', false);
            $('.pseudo_check_reclam').removeClass('check');
            $(this).find("input").attr('checked', true);
			$(this).addClass('check');
            if($(this).attr('for')=='rekl_stop_after_1'){//если надо указать кол-во дней
                $('#rekl_stop_days_1').attr('required',true);
            }else{
                $('#rekl_stop_days_1').removeAttr('required');
            }
		}
		else
		{
            $('.pseudo_check_reclam input').attr('checked', true);
            $('.pseudo_check_reclam').addClass('check');
            $(this).find("input").attr('checked', false);
			$(this).removeClass('check');
            if($(this).attr('for')=='rekl_stop_after_1'){
                $('#rekl_stop_days_1').removeAttr('required');
            }else{
                $('#rekl_stop_days_1').attr('required',true);
            }
		}
	})
	
	//проверка поля количество товара
	$('#reklamation_form.ru').submit(function(){
		$('.rekl_item_block').each(function(){
			def = Number($(this).find('#rekl_def_num').val());
			all = Number($(this).find('#rekl_all_num').val());
			
			if(def<=all){
				err = false;
			}else{	
				$(this).find('#rekl_all_num').parent('td').find('.err').remove();
				$(this).find('#rekl_all_num').parent('td').append('<span class="err" style="position: relative; color: red; display: block;">Неверно заполнено поле</span>');
				err = true;
				offset = $(this).find('.err').offset();			
				$('body,html').animate({
					scrollTop: offset.top - 50
				}, 400);
				return false;
			}
		})

        if($('#rekl_stop_after_1').is(':checked')){
            if($('#rekl_stop_days_1').val()==''){
                err=true;
                $('#rekl_stop_days_1').addClass('err');

                offset = $('#rekl_stop_days_1').offset();
                $('body,html').animate({
                    scrollTop: offset.top - 50
                }, 400);
            }else{
                err=false;
            }
        }
		
		if(err){
			return false;
		}
	})
	
	$('#reklamation_form.en').submit(function(){
		$('.rekl_item_block').each(function(){
			def = Number($(this).find('#rekl_def_num').val());
			all = Number($(this).find('#rekl_all_num').val());
			
			if(def<=all){
				err = false;
			}else{	
				$(this).find('#rekl_all_num').parent('td').find('.err').remove();
				$(this).find('#rekl_all_num').parent('td').append('<span class="err" style="position: relative; color: red; display: block;">Incorrect field value</span>');
				err = true;
				offset = $(this).find('.err').offset();			
				$('body,html').animate({
					scrollTop: offset.top - 50
				}, 400);
				return false;
			}
		})
		
		if(err){			
			return false;
		}
	})
	
	//активизация полей
	$('.rekl_item_name').live('change', function(){			
		setTimeout(function(){
				var val = $(this).val(),
					url = window.location.href,
					item_id = $(this).attr('item_id');
			$.ajax({
				url: url,
				type: "POST",
				dataType: "html",
				data: {val:val, checkproduct:1, item_id:item_id},				
				success: function(data){					
					al = $(data).find('#test_res').html();	
					
					if(al == '1'){				
						$(this).parents('.item').find('#rekl_last_num').removeAttr('disabled');
						$(this).parents('.item').find('#rekl_issue_num').removeAttr('disabled')/*.attr("required", "required")*/;
					}else if(al == '3'){				
						//$(this).parents('.item').find('#rekl_issue_num').removeAttr('disabled');
					}else if(al == '2'){
						$(this).parents('.item').find('#rekl_last_num').removeAttr('disabled');
					}
				}.bind(this)
			})
		}.bind(this),300)		
	})
	

	//выбор файла
	$('.real_inp_file input').live('change', function(){
		file = $(this).val();	
		var re = /\s*\\s*/;
		var tagList = file.split(re);
		if(tagList[2]){
			file_form = tagList[2];
		}else{
			file_form = tagList[0];
		}
		$(this).parents('.pseudo_inp_file').find('.sel_f').text(file_form);
	})
	
	
	
	$('.subscribe-form input[type="text"]').each(function(){
		if($(this).val()=='Your e-mail')
			$(this).defaultText('Your e-mail');
		if($(this).val()=='Ваш e-mail')
			$(this).defaultText('Ваш e-mail');
	});
	
	//Портфолио добавление поля
	$('.portfolio_add').live('click', function(){
		prop = $(this).parent('td').find('input[type=text]').last().attr('prop');
		arpos = $(this).parent('td').find('input[type=text]').last().attr('arpos') * 1;
		arposnew = arpos+1;
		name = 'PROPERTY['+prop+']['+arposnew+']';
		$(this).parent('td').find('input.portfolio_add').before('<input class="multiinput" type="text" name="'+name+'" size="25" value="" prop="'+prop+'" arpos="'+arposnew+'"/><div class="search_wrapper" id="search_wrapper_'+arposnew+'"></div>');
	})
	
	//Страница портфолио - форма добавления объекта
	if($('.fancybox-button').length>0) {
		$("a.fancybox-button").fancybox({
			'overlayShow'	: true,
			'overlayOpacity': 0.5,
			'overlayColor'	: '#000',
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			'width'			: '800',
			'height'		: '550',
			'autoDimensions': false,//для возможности задания ширины,
			//'margin'		: 100,
			'padding'		: 20,
			'titleShow'		: 'true',
			'titlePosition'	: 'over',
		});
	}
	//Смена языка
	$('#language .language_btn').live('click',function(){
		var close='';
		if($('#language .language_list').is(':visible'))
			close='no';
		else
			close='yes';
		if(close=='yes')
			$('#language .language_list').css('display','block');
		if(close=='no')
			$('#language .language_list').css('display','none');
	});
	
	//Вопрос-голосование
	$('#voting input').each(function(){
		if($(this).is(':checked'))
			$(this).closest('.vote').find('.radio_img').addClass('current');
	});
	$('#voting label').live('click',function(){
		$('#voting .radio_img').removeClass('current');
		//if($(this).closest('.vote').find('input').is(':checked'))
			$(this).closest('.vote').find('.radio_img').addClass('current');
	});
	$('#voting .radio_img').live('click',function(){
		$(this).closest('.vote').find('label').click();
	});
	
	//ПЛАВНОЕ СВОРАЧИВАНИЕ ДЛЯ СТРАНИЦЫ FAQ
	$(".question_wrap .question").live('click',function(){
		$(this).closest('.question_wrap').find('.answer').slideToggle('400');//fast 200-600
	});
	
	//Футор прибить к низу страницы (подстраиваем высоту контента)
	if($('#header.min').length>0)
	{
		if($('#content.pdf_object').length>0)
			var min_header_size=87+33;
		else
			var min_header_size=87;			
		
	}
	else
		var min_header_size=0;	
	var page_height=$('#content').height();
	var window_height=$(window).height();
	if(page_height<window_height)
	{
		$('#content').css('min-height',window_height-205-63+min_header_size);
	}
	//при ресайзе окна снова подстраиваем высоту контента
	$(window).resize(function () { 
		var page_height=$('#content').height();
		var window_height=$(window).height();
		if(page_height<window_height)
		{
			$('#content').css('min-height',window_height-205-63+min_header_size);
		}
    });
	
	//для встроенных pdf-страниц высоту подстраиваем под высоту экрана
	if($('#pdf_object').length>0)
	{
		var window_height=$(window).height()-93-55;
		$('#pdf_object').css('height',window_height);
		//$('#footer').remove();//убираем футор
		//$('.footer_bot_2').css('padding-bottom',"0px");//убираем паддинг блока над футором
	}
	if($('.frameins').length>0)
	{
		setTimeout(function(){
			var window_height=$(window).height()-93-55;		
			$('.frameins').css('height',window_height);
		},100)
	}
	
	//Плавная прокрутка до якоря
	$("a.ancLinks").live('click',function() {
		elementClick = $(this).attr("href");
		if(elementClick=='#main')
			destination = $(elementClick).offset().top-69;
		else
			destination = $(elementClick).offset().top-64;
		if($.browser.safari){
			$('body').animate( { scrollTop: destination }, 1100 );
		}else{
			$('html').animate( { scrollTop: destination }, 1100 );
		}
		$('#distributors_menu ul li a').removeClass('current');
		$(this).addClass('current');
		return false;
    });
		
	//Кнопка Сделать заказ в карточке товара
	$('#btn_make_order').live('click',function(){
		var mess = false;
		$('.cart_item_td.quantity').each(function(){
			var v = $(this).find('.inp_quantity').val();
			if(v > 0){
				if(!$(this).siblings('.cart_item_td.shipping').find('.pseudo_radio.check').length){
					mess = true;
				}			
			}
		})
		
		if(mess){			
			if($('#active_language').text()=='RUS'){				
				alert('Пожалуйста, проверьте, установлены ли у заказанных товаров сроки отгрузки!');
			}else{
				alert('Please, check shipment terms');
			}
		}else{
			var no_empty='no';
			$('.item_order a.addtoCart').each(function(){
				if($(this).closest('.item_order').find('input').val()>0)
				{
					$(this).click();
					no_empty='yes';
				}
			});
			if(no_empty=='yes')//если добавлен хотя бы один товар
			{
				win_centre('#addItemInCart');
				$("#addItemInCart").fadeIn(1000);
			}
			else
			{
			
			}
		}
	});
	$("#addItemInCart .close").click(function(){
		$("#addItemInCart").fadeOut(400);
	});
	
	//проверка условий отгрузки в корзине
	//смотри checkOut() в скриптах шаблона корзины
	$("#basketOrderButton2").live('click', function(){
		checkOut();
		return false;
	})
	
	
	
	/*Проверка на кратность при вводе количества товара числом*/
	$('.item_order .quantity_pseudo').live('keyup',function(e)
	{
		quantity_item_new = $(this).val();
		
		$(this).closest('.item_order').find('input.inp_quantity').val(quantity_item_new);
		$(this).closest('.item_order').find('input.inp_quantity').change();
		
		//псеудоинпут(кол-во по упаковкам)
		var deviant_packing=$(this).closest('.item_order').find('.deviant_packing').text()*1;
		//$(this).closest('.item_order').find('input.quantity_pseudo').val(quantity_item_new*deviant_packing);
		//$(this).closest('.item_order').find('input.quantity_pseudo').val(quantity_item_new);		
		
		if(isInteger(quantity_item_new/deviant_packing)==false)//если выбранное кол-во не кратно числу в упаковке
		{
			$(this).closest('.cart_item_td.quantity').find('.item_order_err').css('display','block');
		}
		else
			$(this).closest('.cart_item_td.quantity').find('.item_order_err').css('display','none');
		
		var href_addtoCart=$(this).closest('.item_order').find('a.addtoCart').attr('href');
		href_addtoCart=href_addtoCart.split('quantity=');
		href_addtoCart=href_addtoCart[0]+'quantity='+quantity_item_new;
		$(this).closest('.item_order').find('a.addtoCart').attr('href',href_addtoCart);
		
		//Обновление ИТОГО
		if($('#content.item_card').length>0) {//если страница карточки товара
			var cost_itogo=0;
			$('.cart_item').each(function(){
				var quantity_item_one=$(this).find('input.inp_quantity').val()*1;
				var price_item_one=$(this).find('.number').text()*1;
				var cost_itogo_one=quantity_item_one*price_item_one;
				cost_itogo=cost_itogo+cost_itogo_one;
			});
			//$('#cost_itogo').text(str_triad(cost_itogo));
			cost_itogo = cost_itogo.toFixed(2);
			nds_itogo = (cost_itogo*0.18).toFixed(2);
			$('#cost_itogo').text(cost_itogo);
			$('#nds_itogo').text(nds_itogo);
		}
		if($('#content.basket').length>0) {//если страница корзины
			$count_item=$(this).closest('.cart_item').find('.inp_quantity').val();
			$price_item=$(this).closest('.cart_item').find('.current_price .number').text()*1;
			$(this).closest('.cart_item').find('.cart_item_td.cost span.number').text($count_item*$price_item);
		}
	});
	/*======>_<=====Конец проверок на кратность====>_<====*/
	
	//Псевдо check в новостях - подписка на рассылку				
	$('.pseudo_check.news').live('click',function(){
		if($(this).closest('.reviews-reply-field-setting').find("input").is(':checked')==false) //если чекбокс не отмечен
		{
			$(this).addClass('check');
		}
		else
		{
			$(this).removeClass('check');
		}						
	});
	
	//check в отзывах
	$('.pseudo_check.reviews').live('click',function(){
	
		if($(this).find("input").is(':checked')==true) //если чекбокс не отмечен
		{		
			$(this).addClass('check');
		}
		else
		{			
			$(this).removeClass('check');
		}						
	});
	
	//Рейтинги в новостях
	$('#rating_news .rating_news_radio').live('click',function(){
		$('#rating_news .rating_news_radio').removeClass('current');
		$(this).addClass('current');
		$('#rating_form').find("select [value='"+$(this).attr('value')+"']").attr("selected", "selected");
	});
	
	//--------------------------------------- Выборка параметров фильтра (ПОРТФОЛИО) -----------------------------------------//
	$('#filter_portfolio .pseudo-select input').live('change',function()
	{
		if($('#set_filter').length>0)
		{
			str_all=window.location.href.split('?');
			str=str_all[0]+'?';
			
			//получаем текущую сортировку	
			if(str_all[1])
			{
				sort=str_all[1]+'&';	
			}
			else
				sort='';				
			str_filter='';
			$('#filter_portfolio .pseudo-select input').each(function(){
				if($(this).is(':checked')==true)
				{
					if(str_filter=='')
						str_filter=$(this).attr('id')+'=Y';
					else
						str_filter=str_filter+'&'+$(this).attr('id')+'=Y';
				}
			});
            
			str=str+sort+str_filter+'&set_filter=';
			if($('#active_language').text()=='ENG')
				str=str+'Show';
			if($('#active_language').text()=='RUS')
				str=str+'Показать';			
            
            if ($("form.catalog-filter").length > 0) {
                $("form.catalog-filter input").each(function(){
                    if ($(this).val() != "")
                        str += "&"+$(this).attr('name')+"="+ encodeURIComponent($(this).val());
                });
            }
            
			$.get(str, {}, function(data) {
				$("#portfolio_result").html($(data).find("#portfolio_result").html());
                var temp = $(data).find("#portfolio_result").html();
                if ($(".portfolio-selected").length > 0)
                    $(".portfolio-selected").html($(data).find(".portfolio-selected").html());
                
				//повторно вешаем fancybox для подгруженных элементов
				if($('.fancybox-button').length>0) {
					$("a.fancybox-button").fancybox({
						'overlayShow'	: true,
						'overlayOpacity': 0.5,
						'overlayColor'	: '#000',
						'transitionIn'	: 'elastic',
						'transitionOut'	: 'elastic',
						'width'			: '800',
						'height'		: '550',
						'autoDimensions': false,//для возможности задания ширины,
						//'margin'		: 100,
						'padding'		: 20,
						'titleShow'		: 'true',
						'titlePosition'	: 'over',
					});
				}
				
			});
		}
	});
	
	//--------------------------------------- Выборка параметров фильтра (КАТАЛОГ) -----------------------------------------//
	$("#select_step input").live('change',function()
	{
	/*if($.browser.msie)alert(1);*/
		/*if($(this).is(':checked')==false) //если checkbox не отмечен
		{			
			$(this).closest('#pseudo-check').find('.pseudo_img').removeClass('check');
		}
		else
		{			
			$(this).closest('#pseudo-check').find('.pseudo_img').addClass('check');
		}*/
		if($('#set_filter').length>0)
		{
		
			var str_all=window.location.href.split('?');
			strwohash = strstr(str_all[0], '#', true);
			if(strwohash){
				var str=strwohash+'?';
			}else{
				var str=str_all[0]+'?';
			}			
			
			//получаем текущую сортировку	
			var sort = '';
			if(str_all[1])
			{
				sort='';
				var sort_str=str_all[1].split('&order');
				sort_str=sort_str[0];			
				if(sort_str=='sort=name')
					sort='sort=name&order=asc&';
				if(sort_str=='sort=price')
					sort='sort=price&order=asc&';
				if(sort_str=='sort=date')
					sort='sort=date&order=desc&';
			}
			else{
				sort='';
			}
			var str_filter='';
			var filter_props_str='';
			$('#select_step input').each(function(){
				if($(this).is(':checked')==true)
				{
					if(str_filter=='')
						str_filter=$(this).attr('id')+'=Y';
					else
						str_filter=str_filter+'&'+$(this).attr('id')+'=Y';
						
					//Формируем массив фильтруемых значений свойств
					var id_prop=$(this).attr('id').split('_');
					id_prop=id_prop[1];
					var name_prop=$(this).closest('.lvl2').find('label').text();
					if(filter_props_str=='')
						filter_props_str=id_prop+'='+name_prop;
					else
						filter_props_str=filter_props_str+'&'+id_prop+'='+name_prop;
				}/*else if($(this).attr('type')=='text'){
					if(str_filter=='')
						str_filter=$(this).attr('id')+'='+$(this).val();
					else
						str_filter=str_filter+'&'+$(this).attr('id')+'='+$(this).val();
						
					var id_prop=$(this).attr('id').split('_');
					id_prop=id_prop[1];
					var name_prop=$(this).val();
					if(filter_props_str=='')
						filter_props_str=id_prop+'='+name_prop;
					else
						filter_props_str=filter_props_str+'&'+id_prop+'='+name_prop;
				}*/
			});
			//str=str+sort+str_filter+'&arrFilter_P1_MIN='+$('#arrFilter_P1_MIN').val()+'&arrFilter_P1_MAX='+$('#arrFilter_P1_MAX').val()+'&set_filter=Показать';
			str=str+sort+str_filter+'&set_filter=';
			if($('#active_language').text()=='ENG')
				str=str+'Show';
			if($('#active_language').text()=='RUS')
				str=str+'Показать';
			
			$.get(str, {filter_props_str:filter_props_str}, function(data) {
				//$(".content_right").html($(data).find(".content_right").html());//обновление списка товаров в каталоге по фильтру
				$("#smart_filter .filter_result #res").html($(data).find("#filter_items_res").html());//обновление списка товаров в фильтре
			});
		}
	});
	
	//псевдо-селект фильтра
	$('.filter_step_select_btn').live('click', function(){		
		if(!$(this).parent('.filter_step_select').hasClass('inactive')){
			$(this).parent('.filter_step_select').siblings('ul').slideToggle();
		}
	});
	
	$('.step_reset').live('click', function(){
		$(this).parents("ul").find("input").removeAttr('checked').change();
		$('.lvl2_disabled').css('display', 'block');
	});
	$('.filter_step ul li label').live('click', function(){
		txt = $(this).text();
		$(this).parents('.filter_step').find('.filter_step_select').html(txt+'<div class="filter_step_select_btn"></div>').siblings('ul').slideUp();
		$(this).parent('li').siblings('li').find('input').removeAttr('checked');
		
	});
	
	$('#ul_130 li').live('click', function(){
		$('#ul_326').siblings('.filter_step_select').removeClass('inactive');
	})
	$('#ul_326 li').live('click', function(){
		$('.filter_step.s_131').css('display', 'block');
	})
	
	$('#ul_78 li').live('click', function(){
		$('#ul_325').siblings('.filter_step_select').removeClass('inactive');
	})
	$('#ul_325 li').live('click', function(){
		$('.filter_step.s_79').css('display', 'block');
	})
	$('#arrFilter_325_3541025950').attr('checked', 'checked');
	
	//--------------------------- Сворачивание-разворачивание страниц оформления заказа ---------------------------------------//
	//------------- Кнопка Перейти к подтверждению -------------//
	$('#order_step_checkout').live('click',function(){
		$('#order_checkout').css('display','block');
		$('#order_confirm').css('display','none');
		$(window).scrollTop(0);
	});
	//Валидация обязательных полей
	$('.checkout_field input').live('blur',function() {
		if($(this).closest('.checkout_field').find('span.red').length>0) {//если это обязательное поле
			$(this).removeClass('err');
			if($(this).val()=='')
			{
				$(this).addClass('err');
			}
		}
	});
	//Валидация обязательных полей (textarea)
	$('.checkout_field textarea').live('blur',function() {
		if($(this).closest('.checkout_field').find('span.red').length>0) {//если это обязательное поле
			$(this).removeClass('err');
			if($(this).val()=='')
			{
				$(this).addClass('err');
			}
		}
	});
	

	$('.checkout_field input[name=ORDER_PROP_10]').live('blur',function() {
		if($('.checkout_field.required input[name=ORDER_PROP_10]').val().length == 12 &&
				$.isNaN($('.checkout_field.required input[name=ORDER_PROP_10]'))	){
				$('input[name=ORDER_PROP_49]').closest('.checkout_field').find('span.red').hide();
				$('input[name=ORDER_PROP_49]').closest('.checkout_field').removeClass('required');
				
			}else{
				if($('.checkout_field.required input[name=ORDER_PROP_10]').val().length == 10){
					$('input[name=ORDER_PROP_49]').closest('.checkout_field').find('span.red').show();
					$('input[name=ORDER_PROP_49]').closest('.checkout_field').addClass('required');
				}else{
					$('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_10]').addClass('err');
					if(count_err==1)
						ancLink('#'+$('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_10]').attr('id'));
					order_err='yes';
					count_err++;
				}
		}

	});
	
	//KPP
	$('.checkout_field input[name=ORDER_PROP_49]').live('blur',function() {
		if($('.checkout_field input[name=ORDER_PROP_49]').val().length > 0){
			if($('.checkout_field input[name=ORDER_PROP_49]').val().length == 9 &&
			   $.isNaN($('.checkout_field input[name=ORDER_PROP_49]'))){
			   $('.checkout_field input[name=ORDER_PROP_49]').removeClass('err');
			}else{
				$('.checkout_field input[name=ORDER_PROP_49]').addClass('err');
				if(count_err==1)
					ancLink('#'+$('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_49]').attr('id'));
				order_err='yes';
				count_err++;
			}
		}
		else {
			$('.checkout_field input[name=ORDER_PROP_49]').removeClass('err');
		}
	});
	
	$('#checkout_btn').live('click',function() {
		var order_err='no';
		$('.checkout_field').find('input').removeClass('err');
		var count_err=1;

		//INN 
		if($('.checkout_field.required input[name=ORDER_PROP_10]').val().length == 10 && 
		   $.isNaN($('.checkout_field.required input[name=ORDER_PROP_10]')) ){
		
		}else{
			if($('.checkout_field.required input[name=ORDER_PROP_10]').val().length == 12){
				//alert('sdf');
			}else{
				$('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_10]').addClass('err');
				if(count_err==1)
					ancLink('#'+$('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_10]').attr('id'));
				order_err='yes';
				count_err++;
			}
		}
		
		//KPP
		if($('.checkout_field input[name=ORDER_PROP_49]').val().length > 0){
			if($('.checkout_field input[name=ORDER_PROP_49]').val().length == 9 &&
			   $.isNaN($('.checkout_field input[name=ORDER_PROP_49]'))){
				
			}else{
				$('.checkout_field input[name=ORDER_PROP_49]').addClass('err');
				if(count_err==1)
					ancLink('#'+$('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_49]').attr('id'));
				order_err='yes';
				count_err++;
			}
		}
		
		/*
		 * 		//INN 
		if($('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_10]').val().length == 10 && 
		   $.isNaN($('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_10]')) ){
			//KPP
			if($('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_49]').val().length == 9 &&
			   $.isNaN($('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_49]'))){ 
				
			}else{
				$('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_49]').addClass('err');
				if(count_err==1)
					ancLink('#'+$('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_49]').attr('id'));
				order_err='yes';
				count_err++;
			}			
		
		}else{
			if($('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_10]').val().length == 12){
				
			}else{
				
				$('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_10]').addClass('err');
				if(count_err==1)
					ancLink('#'+$('.checkout_field span.red').closest('.checkout_field').find('input[name=ORDER_PROP_10]').attr('id'));
				order_err='yes';
				count_err++;
			}
		}
		 */

		
		
		//Валидация обязательных полей
		$('.checkout_field.required span.red').each(function(){
			if($(this).closest('.checkout_field').find('input').val()=='')
			{
				$(this).closest('.checkout_field').find('input').addClass('err');
				if(count_err==1)
					ancLink('#'+$(this).closest('.checkout_field').find('input').attr('id'));
				order_err='yes';
				count_err++;
			}
			if($(this).closest('.checkout_field').find('textarea').val()=='')
			{
				$(this).closest('.checkout_field').find('textarea').addClass('err');
				if(count_err==1)
					ancLink('#'+$(this).closest('.checkout_field').find('textarea').attr('id'));
				order_err='yes';
				count_err++;
			}
		});
		if(order_err=='no')
		{
			$('#order_checkout').css('display','none');
			$('#order_confirm').css('display','block');
			$(window).scrollTop(0);
			$('.confirm_order_prop').each(function(){
				var confirm_order_prop_id=$(this).attr('id').replace('CONFIRM_','');
				$(this).text($('#order_checkout').find('#'+confirm_order_prop_id).val());
			});
			
		}
	});
	
	//Закрытие блоков в левой колонке
	$('.btn_close_block').live('click',function() {
		var sidebar_block_id=$(this).closest('.sidebar_block').attr('pos');//banner_1 banner_2 subscribe voting_1 voting_2
		var sidebar_block_page=$(this).closest('.sidebar_block').attr('page');//catalog_page other_page
		$(this).closest('.sideblock_wrap').replaceWith('');
		//устанавливаем куки
		$.cookie(sidebar_block_id+'_'+sidebar_block_page, 'close', {
			expires: 1,//на 1 день
			path: '/',
		});
	});
	
	//Сохраняем выбранную пользователем языковую версию сайта
	$('#lang_rus').live('click',function() {
		//устанавливаем куки
		$.cookie('site_lang', 'rus', {
			expires: 7,//на 7 дней
			path: '/',
		});
	});
	$('#lang_eng').live('click',function() {
		//устанавливаем куки
		$.cookie('site_lang', 'eng', {
			expires: 7,//на 7 дней
			path: '/',
		});
	});
	$('#lang_deu').live('click',function() {
		//устанавливаем куки
		$.cookie('site_lang', 'deu', {
			expires: 7,//на 7 дней
			path: '/',
		});
	});
	
	//Генерация PDF
	$('#dompdf_zakaz').live('click',function() {
		/*$.post('/en/personal/order/make/?ORDER_ID=8/', {pdf:'pdf'}, function(data) {
			alert(data);
			//data=$(data).find("#content").html();
			//$("#content").html(data);
			//alert(data);
			data=$(data).find("#order_form_div .confirm").html();
			$('#order_form_div .confirm').html(data);
		});*/
		/*$.ajax({
			url: "/dompdf_lib/dompdf.php",
			type: "POST",
			dataType: "html",
			data: {pdf: 'pdf'},
			//data: $("form[name='basket_form']").serialize(),
			success: function(data){
				data=$(data).find("#order_form_div .confirm").html();
				$('#order_form_div .confirm').html(data);
				alert(data);
			}
		});*/
		//return false;
	});
	
	/*псевдо радио кнопки для учёта сроков поставки*/
	$('.pseudo_radio').live('click', function(){
		if(!$(this).hasClass('disabled')){
			$(this).parents('.shipping_wrap').find('.pseudo_radio_wrap').each(function(){
				$(this).find('.pseudo_radio').removeClass('check');
			});
			$(this).addClass('check');
			
			//пересчёт цены для корзины и карточки товара
			if($(this).parents('.bx_ordercart').length > 0){
				setTimeout(function(){
					location.reload();
				},300);
			}else{
				item_id = $(this).parents('.cart_item').find('.hid_item_id').val();
				setTimeout(function(){$.ajax({
					url: window.location.href,
					type: "POST",
					dataType: "html",
					data: {},				
					success: function(data){					
						$('.item_'+item_id+' .cart_item_td.price.online .number').html($(data).find('.item_'+item_id+' .cart_item_td.price.online .number').html());						
					}
				})}, 300);
			}
		}
	}); 
	
	
	//вывод блоков с информацией для условий отгрузки
	$('.cart_item .btn_show_info').mouseenter(function(){
		if($(this).find('.btn_show_info_text').text()!='')
			$(this).find('.btn_show_info_text').css('display','block');
	});
	$('.cart_item .btn_show_info').mouseleave(function(){
		$(this).find('.btn_show_info_text').css('display','none');
	});
	
	
	$('.rekl_item_block .item .btn_show_info').live('mouseenter', function(){
		if($(this).find('.btn_show_info_text').text()!='')
			$(this).find('.btn_show_info_text').css('display','block');
	});
	$('.rekl_item_block .item .btn_show_info').live('mouseleave', function(){
		$(this).find('.btn_show_info_text').css('display','none');
	});
	
	
	//отказ от оформления договора
	$('#make_contract').click(function(){		
		$('#contract_form').slideDown();
	})
	
	//печать
	$('#print').click(function(){
		printBlock();
	})
	
	//дистрибьюторы
	$('#affiliates .affiliates_title span').click(function(){
		$(this).parent('.affiliates_title').siblings('.affiliates_wrap').slideToggle(0);
	})
	
	//Comments
	
	$('.news_comments_tab').live('click', function(){
		$(this).siblings('.news_comments_tab').removeClass('current');		
		$(this).addClass('current');
		
		var tabID = $(this).attr('id');
		$('.news_comments_content').removeClass('c-form_visible');
		$('.news_comments_content[data-tab='+tabID+']').addClass('c-form_visible');
		
		if($(this).hasClass('tab_1')){
			$('.reviews-block-container').removeClass('comments_invisible');
			$('.reviews-block-container').addClass('comments_visible');
		}else{
			$('.reviews-block-container').removeClass('comments_visible');
			$('.reviews-block-container').addClass('comments_invisible');
		}
	})
	
	//проверка файла в договоре
	$('#contract_form').submit(function(){
		stop = false;
		$('.req_file').each(function(){
			if($(this).val() == ''){
				alert('Добавьте хотя бы один документ из списка выше!');
				stop = true;
			}
		})		
		if(stop){
			return false;
		}
	})
	
	
	//меню сертификатов для IE
	if($.browser.msie || navigator.userAgent.match(/like Gecko/)){
	
		$('#menu_new .sub li.first_inner').hover(function(){
			
			var coord = $(this).offset();			
			var inner_h = $(this).parent('.sub').height();
			
			$(this).find('.sub_psd li').each(function(){
				tmpH = $(this).height();
				inner_h += tmpH;
			})
			
			if($.browser.msie && $.browser.version == 8){
				inner_h = 400;//задаём фиксированную высоту фрейма
			}
			
			$("#iehack")			
			.css('width', $(this).parent('.sub').width())
			.css('height', inner_h)
			.offset({top:coord.top, left:coord.left});			
			
		},
		function(){
			$("#iehack")
			.offset({top:0, left:0})
			.css('width', 0);
		})
	}
	
	/*$('#edost_frame').ready(function(){
		bh = $('#edost_frame').contents().find('body').height();		
		$('#edost_frame').height(bh+100);		
	})
	$('#edost_frame').load(function(){
		bh = $('#edost_frame').contents().find('body').height();		
		$('#edost_frame').height(bh+100);
	})*/

		/*if ($('html').hasClass('bx-ie')) {

			alert('ie');
			$('.frameins').style('width: 900px');

		}*/


});


function str_triad(str) {
	//Разбиение по триадам
	str = str + '';
	str=str.replace(/\s/g,"");	
	var newVal = '', length = str.length, i;
	for( i = 1; i * 3 < length; i++ )
		newVal = ' ' + str.substring( length - i*3, length - ( i - 1 ) * 3 ) + newVal;
	str=str.substr( 0, 3 - i*3 + length ) + newVal;
	return str;
}
//Выравнивание модального окна по центру
function win_centre(element) {
	var left_size=Math.round(($('body').width()-$(element).outerWidth())/2);
	$(element).css('left',left_size+'px');
}
//Функция замещения текста
$.fn.defaultText = function(value)
{
    var element = this.eq(0);
    element.data('defaultText',value);
    element.focus(function()
    {
        if(element.val() == value)
        {
            element.val('').removeClass('defaultText');
        }
    }).blur(function()
    {
        if(element.val() == '' || element.val() == value)
        {
            element.addClass('defaultText').val(value);
        }
    });
    return element.blur();
}
//плавная прокрутка до якоря
function ancLink(elementClick)
{
	destination = $(elementClick).offset().top;
	if($.browser.safari){
		$('body').animate( { scrollTop: destination }, 500 );
	}else{
		$('html').animate( { scrollTop: destination }, 500 );
	}
	return false;
}
//Добавление страницы в закладки
function add_favorite(a) {
	title=document.title;
	url=document.location;
	try {
		// Internet Explorer
		window.external.AddFavorite(url, title);
	}
	catch (e) {
		try {
			// Mozilla
			window.sidebar.addPanel(title, url, "");
		}
		catch (e) {
			// Opera и Firefox 23+
			if (typeof(opera)=="object" || window.sidebar) {
				a.rel="sidebar";
				a.title=title;
				a.url=url;
				a.href=url;
				return true;
			}
			else {
				// Unknown
				if($('#active_language').text()=='ENG')
					alert('Press Ctrl-D to add this page to your bookmarks');
				if($('#active_language').text()=='RUS')
					alert('Нажмите Ctrl-D, чтобы добавить страницу в закладки');
			}
		}
	}
	return false;
}

/*функция для учёта сроков поставки*/
function addCookie(id, pay_days){
	//alert($.cookie("item"+id));
	//$.cookie("item"+id, null);
	//$.cookie("item"+id, null, {expires: -1});
	//$.cookie("item"+id, null, {path:'/', expires: -1});
	//$.cookie("item"+id, null, {path:'/personal/order/make/', expires: -1});
	//$.cookie("item"+id, pay_days, {path: "/personal/order/make/", expires: 100});
	//$.cookie("item"+id, pay_days, {path: "/", expires: 100});
	$.cookie("item"+id, pay_days, {path:'/', expires: 3, domain: '.argos-trade.com' });
	//alert($.cookie("item"+id));
}

function printBlock(){
	var content;
	$('body').addClass('isPrint');
	if($('body .whole_page').length){
		content = $('body #content').html();
	}else{
		content = $('body .content_right').html();
	}	
	$('body').append('<div id="toPrint" style="display:block">'+content+'</div>');
	if (window.print) {
		window.print() ; 
	} else {
		alert('Ваш браузер не поддерживает функцию печати. Установите более новую версию.');
	}
	setTimeout(Cleaner(), 0);
}

function Cleaner(){
	$('body').removeClass('isPrint');
	$('body #toPrint').remove();
	window.location = window.location.href;
}

//генератор пароля
function genPass(){
	pass = rand();
	$("#pass").val(pass);	
}
function rand() {
    var result       = '';
    var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    var max_position = words.length - 1;
        for( i = 0; i < 10; ++i ) {
            position = Math.floor ( Math.random() * max_position );
            result = result + words[position];
        }
    return result;
}

function strstr( haystack, needle, bool ) {	// Find first occurrence of a string
	// 
	// +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

	var pos = 0;

	pos = haystack.indexOf( needle );
	if( pos == -1 ){
		return false;
	} else{
		if( bool ){
			return haystack.substr( 0, pos );
		} else{
			return haystack.slice( pos );
		}
	}
}
//проверка на кратность (целочисленность)
	function isInteger(num)
	{
		return (num ^ 0) === num;
	}
	if($('#basket_body').length>0)
	{
		$('.cart_item').each(function(){
			var quantity_item=$(this).find('input.inp_quantity').val()*1;
			var deviant_packing=$(this).find('.deviant_packing').text()*1;
			if(isInteger(quantity_item/deviant_packing)==false)//если выбранное кол-во не кратно числу в упаковке
			{
				$(this).find('.item_order_err').css('display','block');
			}
		});
	}

	//определяем функцию bind и trim для долбанного IE8 
	if (!Function.prototype.bind) {
	  Function.prototype.bind = function(oThis) {
		if (typeof this !== 'function') {
		  // closest thing possible to the ECMAScript 5
		  // internal IsCallable function
		  throw new TypeError('Function.prototype.bind - what is trying to be bound is not callable');
		}

		var aArgs   = Array.prototype.slice.call(arguments, 1),
			fToBind = this,
			fNOP    = function() {},
			fBound  = function() {
			  return fToBind.apply(this instanceof fNOP && oThis
					 ? this
					 : oThis,
					 aArgs.concat(Array.prototype.slice.call(arguments)));
			};

		fNOP.prototype = this.prototype;
		fBound.prototype = new fNOP();

		return fBound;
	  };
	}
	
	if(typeof String.prototype.trim !== 'function') {
	  String.prototype.trim = function() {
		return this.replace(/^\s+|\s+$/g, ''); 
	  }
	}

	
	
	/*Часть вынесена из document.ready из-за проблем с IE*/
	
	$('.item_order .nav_count').live('click', function(e)
	{
		quantity_item=$(this).closest('.item_order').find('input.inp_quantity').val()*1;
		if($(this).hasClass("count_minus"))
		{
			if(quantity_item>0)
			{
				quantity_item_new = quantity_item-1;				
			}
			else
				return false;
		}
		if ($(this).hasClass("count_plus"))
		{
			quantity_item_new = quantity_item+1;
		}
		$(this).closest('.item_order').find('input.inp_quantity').val(quantity_item_new);
		$(this).closest('.item_order').find('input.inp_quantity').change();
		
		//псеудоинпут(кол-во по упаковкам)
		var deviant_packing=$(this).closest('.item_order').find('.deviant_packing').text()*1;
		//$(this).closest('.item_order').find('input.quantity_pseudo').val(quantity_item_new*deviant_packing);
		$(this).closest('.item_order').find('input.quantity_pseudo').val(quantity_item_new);
		
		//изменение активности условий отгрузки (русская версия сайта)
		if($('#active_language').text()=='RUS')
		{
			var N = quantity_item_new; //количество заказанного товара
			var A = $(this).closest('.item_order').find('.quantity_item_in_shop').text(); //количество товара одного вида в магазине
			var B = $(this).closest('.item_order').find('.quantity_item_allowed').text(); //количество товара, которое разрешено продать через сайт
			//alert(N+' '+A+' '+B);
			$(this).closest('.cart_item').find('.shipping_wrap .pseudo_radio').removeClass('disabled');
			
			if(N<A && N<B)
			{
				$(this).closest('.cart_item').find('#radio_968').find('.pseudo_radio').addClass('disabled');
			}
			if(N>B || N>A)
			{
				$(this).closest('.cart_item').find('#radio_967').find('.pseudo_radio').addClass('disabled');
			}					
		}
		
		if(isInteger(quantity_item_new/deviant_packing)==false)//если выбранное кол-во не кратно числу в упаковке
		{
			$(this).closest('.cart_item_td.quantity').find('.item_order_err').css('display','block');
		}
		else
			$(this).closest('.cart_item_td.quantity').find('.item_order_err').css('display','none');
		
		var href_addtoCart=$(this).closest('.item_order').find('a.addtoCart').attr('href');
		href_addtoCart=href_addtoCart.split('quantity=');
		href_addtoCart=href_addtoCart[0]+'quantity='+quantity_item_new;
		$(this).closest('.item_order').find('a.addtoCart').attr('href',href_addtoCart);
		
		//Обновление ИТОГО
		if($('#content.item_card').length>0) {//если страница карточки товара
			var cost_itogo=0;
			$('.cart_item').each(function(){
				var quantity_item_one=$(this).find('input.inp_quantity').val()*1;
				var price_item_one=$(this).find('.number').text()*1;
				var cost_itogo_one=quantity_item_one*price_item_one;
				cost_itogo=cost_itogo+cost_itogo_one;
				
			});
			//$('#cost_itogo').text(str_triad(cost_itogo));
			cost_itogo = cost_itogo.toFixed(2);
			nds_itogo = (cost_itogo*0.18).toFixed(2);
			$('#cost_itogo').text(cost_itogo);
			$('#nds_itogo').text(nds_itogo);
		}
		if($('#content.basket').length>0) {//если страница корзины
			$count_item=$(this).closest('.cart_item').find('.inp_quantity').val();
			$price_item=$(this).closest('.cart_item').find('.current_price .number').text()*1;
			$(this).closest('.cart_item').find('.cart_item_td.cost span.number').text(($count_item*$price_item).toFixed(2));
		}
	});
	//ДОБАВЛЕНИЕ НОВОЙ ТОВАРНОЙ ПОЗИЦИИ К ЗАКАЗУ
	$('#add_new_item_to_cart input[type="submit"]').live('click',function(){
		var item_name=$('#add_new_item_to_cart').find('input[type="text"]').val();
		var iblock_id=$('#add_new_item_to_cart').find('input[type="text"]').attr('iblock_id');
		var item_id=$('#add_new_item_to_cart').find('input[type="text"]').attr('item_id');
		$.post("/bitrix/templates/eshop_adapt_/libs/add_new_item_to_cart.php",{item_name:item_name, iblock_id:iblock_id, item_id:item_id},function(data)
        {
				
			if(data!='no_res')//если товар найден
			{
				
				if($('#active_language').text().trim()=='ENG')
					path="/en/personal/cart/";
				if($('#active_language').text().trim()=='RUS')
					path="/personal/cart/";
				if($('#active_language').text().trim()=='DEU')
					path="/de/personal/cart/";
				//обновление корзины	
			
				$.get(path, {}, function(data) {
					
					$("#basket_body").html($(data).find("#basket_body").html());
					$('#add_new_item_to_cart input[type="text"]').val('Быстрый поиск товара');
					$('#add_new_item_to_cart.en input[type="text"]').val('Product quickfinder');
					$('#header .cart_block').html($(data).find("#header .cart_block").html());
				});
			}
        });
		return false;
	});
