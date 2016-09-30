<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?php
$site_name = "argos-trade.com";

//получаем e-mail отдела продаж
if(CModule::IncludeModule("main") && CModule::IncludeModule("sale"))
{
	$mail_from="noreply@argos-trade.com";
	//$mail_to = "Kunilovskiy@argos-trade.com, kondratieva_o@argo-s.net"; отправка реализована через шаблон
	//$mail_to = COption::GetOptionString("main", "email_from");
}
	
//Форма Поделиться
if(isset($_POST['share_email']))
{
	$mail_to_new = trim($_POST['share_email']);
	$link = trim($_POST['href']);
	$lang = trim($_POST['lang']);
	
	if($lang!=='RUS')
	{
		$email_err='Enter E-mail.';
		$email_err_correct='Please enter a valid E-mail.';
		$shared_text='Interesting link to share: ';
		$subject='Interesting link to share';
		$link_send='Link has been sent!';
	}
	if($lang=='RUS')
	{
		$email_err='Введите E-mail.';
		$email_err_correct='Введите корректный E-mail.';
		$shared_text='С вами решили поделиться интересной ссылкой: ';
		$subject='С вами решили поделиться интересной ссылкой';
		$link_send='Ссылка была отправлена!';
	}
	
	if($share_email=='E-mail' || $share_email=='')
		echo $email_err;
	else if(!preg_match('/[0-9a-z\._-]+@[0-9a-z\._-]+\.[a-z]{2,6}/',$share_email))
		echo $email_err_correct;
	else
	{
		$title_email='E-mail';
		$mess='<p>'.$shared_text.'<a href="'.$link.'">'.$link.'</a></p>';				
		
		define('INCLUDE_CHECK',true);
        require 'send_mail.php';
		$sendit=send_mail(
            //to:
            $mail_to_new,
            //subject:
            $subject,
            //body:
            $mess,
            //headers (from):
            $site_name.'<'.$mail_from.'>'
        );
		if ($sendit==TRUE)
		{
			echo $link_send;
		}
	}
}

//Форма Заполнить анкету на вакансию
if(isset($_POST['arr_experience']))
{
	$questionary_vacancy = trim($_POST['questionary_vacancy']);
	$questionary_wages = trim($_POST['questionary_wages']);
	$questionary_name = trim($_POST['questionary_name']);//обязательное
	$questionary_date_of_birth = trim($_POST['questionary_date_of_birth']);//обязательное
	$questionary_address = trim($_POST['questionary_address']);//обязательное
	$questionary_phone = trim($_POST['questionary_phone']);//обязательное
	$questionary_email = trim($_POST['questionary_email']);//обязательное
	$questionary_level_of_education = trim($_POST['questionary_level_of_education']);
	$questionary_institution = trim($_POST['questionary_institution']);
	$questionary_finish_year = trim($_POST['questionary_finish_year']);
	$questionary_specialty = trim($_POST['questionary_specialty']);
	$questionary_courses = trim($_POST['questionary_courses']);
	$questionary_skills = trim($_POST['questionary_skills']);
	$questionary_about = trim($_POST['questionary_about']);
	$arr_experience = $_POST['arr_experience'];
	$arr_experience_1=explode('&&&,',$arr_experience[0]);
	
	if($questionary_name=='')
		echo 'name';
	else if($questionary_date_of_birth=='')
		echo 'date_of_birth';
	else if($questionary_address=='')
		echo 'address';
	else if($questionary_phone=='')
		echo 'phone';
	else if($questionary_email=='')
		echo 'email';
	else if(!preg_match('/^[0-9-+]+$/i',$questionary_phone))
		echo 'phone';
	else if(!preg_match('/[0-9a-z\._-]+@[0-9a-z\._-]+\.[a-z]{2,6}/',$questionary_email))
		echo 'email';
	else if($arr_experience_1[0]=='')
		echo 'post_1';
	else if($arr_experience_1[1]=='')
		echo 'organization_1';
	else if($arr_experience_1[2]=='')
		echo 'period_1';
	else if($arr_experience_1[3]=='')
		echo 'responsibility_1';
	else if($arr_experience_1[4]=='')
		echo 'progress_1';
	else
	{
		$title_vacancy='Резюме на вакансию';
		$title_wages='Уровень заработной платы';
		$title_name='ФИО';
		$title_date_of_birth='Дата рождения';
		$title_address='Место проживания';
		$title_phone='Контактный телефон';
		$title_email='Адрес электронной почты';
		$title_level_of_education='Уровень образования';
		$title_institution='Наименование учебного заведения';
		$title_finish_year='Год окончания';
		$title_specialty='Специальность';
		$title_courses='Дополнительное образование (курсы / тренинги)';
		$title_skills='Ключевые навыки';
		$title_about='О себе';
		
		$str="";
		$count_main=1;
		foreach($arr_experience as $arr_experience_res)
		{
			$str=$str.'<br><p><b>Место работы '.$count_main.'</b></p>';
			$arr_experience_res2=explode('&&&,',$arr_experience_res);
			$count=1;
			foreach($arr_experience_res2 as $arr_experience_res2_res)
			{
				if($count=1)
					$title='Занимаемая должность';
				if($count=2)
					$title='Наименование организации';
				if($count=3)
					$title='Период работы';
				if($count=4)
					$title='Должностные обязанности';
				if($count=5)
					$title='Основные достижения';
				$str=$str."<p><b>".$title.": </b>".$arr_experience_res2_res."</p>";
			}
			$count_main++;
		}
		
		$mess=	"<p><b>".$title_vacancy.": </b>".$questionary_vacancy."</p>".
				"<p><b>".$title_wages.": </b>".$questionary_wages."</p>".
				"<p><b>".$title_name.": </b>".$questionary_name."</p>".				
				"<p><b>".$title_date_of_birth.": </b>".$questionary_date_of_birth."</p>".				
				"<p><b>".$title_address.": </b>".$questionary_address."</p>".				
				"<p><b>".$title_phone.": </b>".$questionary_phone."</p>".				
				"<p><b>".$title_email.": </b>".$questionary_email."</p>".				
				"<p><b>".$title_level_of_education.": </b>".$questionary_level_of_education."</p>".
				"<p><b>".$title_institution.": </b>".$questionary_institution."</p>".
				"<p><b>".$title_finish_year.": </b>".$questionary_finish_year."</p>".
				"<p><b>".$title_specialty.": </b>".$questionary_specialty."</p>".
				"<p><b>".$title_courses.": </b>".$questionary_courses."</p>".
				"<p><b>".$title_skills.": </b>".$questionary_skills."</p>".
				"<p><b>".$title_about.": </b>".$questionary_about."</p>".$str;
		
		define('INCLUDE_CHECK',true);
        require 'send_mail.php';
		/*$sendit=send_mail(
            //to:
            $mail_to,
            //subject:
            'Заявка на вакансию',
            //body:
            $mess,
            //headers (from):
            $site_name.'<'.$mail_from.'>'
        );*/
		
		//Отправка на почту
	
			$arFields = Array(	
				"CONTENT"=>$mess	
			);

			$eventName = "SEND_FORM";
							
			$event = new CEvent;
			
			$success = false;
			
			if(!$err){
				if($sendit = $event->SendImmediate($eventName, SITE_ID, $arFields,"N",86)){				
					$success = 'Y';
				}	
			}
		
		if ($sendit==TRUE)
		{
			echo 'ok';
		}
	}	
}

//Форма Задать вопрос
if(isset($_POST['ask_question_name']) && isset($_POST['ask_question_phone']) && isset($_POST['ask_question_email']) && isset($_POST['ask_question_mess']))
{	
	$lang = trim($_POST['lang']);

	if($lang!=='RUS')
	{
		$question_name_empty="Full name";
		$question_phone_empty="Phone";
		$question_mess_empty="Question";
	}
	if($lang=='RUS')
	{
		$question_name_empty="ФИО";
		$question_phone_empty="Телефон";
		$question_mess_empty="Вопрос";
	}
	
	$question_name = trim($_POST['ask_question_name']);
	$question_phone = trim($_POST['ask_question_phone']);
	$question_email = trim($_POST['ask_question_email']);	
	$question_mess = trim($_POST['ask_question_mess']);
	
	if($question_phone=='Телефон' || $question_phone=='Phone')
		$question_phone=='';
		
	if($question_name==$question_name_empty || $question_name=='')
		echo 'name';
	//else if($question_phone==$question_phone_empty || $question_phone=='')
		//echo 'phone';
	else if($question_email=='E-mail' || $question_email=='')
		echo 'email';
	else if($question_mess==$question_mess_empty || $question_mess=='')
		echo 'mess';
	//else if(!preg_match('/^[0-9-+]+$/i',$question_phone))
		//echo 'phone';
	else if(!preg_match('/[0-9a-z\._-]+@[0-9a-z\._-]+\.[a-z]{2,6}/',$question_email))
		echo 'email';
	else
	{
		$title_name='Имя';
		$title_phone='Телефон';
		$title_email='E-mail';
		$title_mess='Вопрос';
		$mess=	"<p><b>".$title_name.": </b>".$question_name."</p>".
				"<p><b>".$title_phone.": </b>".$question_phone."</p>".
				"<p><b>".$title_email.": </b>".$question_email."</p>".
				"<p><b>".$title_mess.": </b>".$question_mess."</p>";
		
		define('INCLUDE_CHECK',true);
        require 'send_mail.php';
		/*$sendit=send_mail(
            //to:
            $mail_to,
            //subject:
            'Вопрос специалисту',
            //body:
            $mess,
            //headers (from):
            $site_name.'<'.$mail_from.'>'
        );*/
		
		//Отправка на почту
	
			$arFields = Array(	
				"CONTENT"=>$mess	
			);

			$eventName = "SEND_FORM";
							
			$event = new CEvent;
			
			$success = false;
			
			if(!$err){
				if($sendit = $event->SendImmediate($eventName, SITE_ID, $arFields,"N", 85)){				
					$success = 'Y';
				}	
			}
			
			
		if ($sendit==TRUE)
		{
			echo 'ok';
		}
	}
}

//Форма Заявка на регистрацию
if(isset($_POST['r_f_company']) && isset($_POST['r_f_view']) && isset($_POST['r_f_address']) && isset($_POST['r_f_name']) && isset($_POST['r_f_post']) && isset($_POST['r_f_phone']) && isset($_POST['r_f_site']) && isset($_POST['r_f_mess']) && isset($_POST['r_f_email']))
{
	$lang = trim($_POST['lang']);
	
	if($lang!=='RUS')
	{
		$r_f_company_empty="Company name *";
		$r_f_view_empty="Kind of activity *";
		$r_f_address_empty="Company's post address *";
		$r_f_name_empty="Person responsible (Name, Surname) *";
		$r_f_post_empty="Position *";
		$r_f_phone_empty="Telephone +7-111-11-11 *";
		$r_f_site_empty="Website";
		$r_f_mess_empty="How do you collaborate with the company? What products are being ordered? *";
		$r_f_email_empty="E-mail *";
	}
	if($lang=='RUS')
	{
		$r_f_company_empty="Юридическое название компании *";
		$r_f_view_empty="Вид деятельности *";
		$r_f_address_empty="Почтовый адрес компании *";
		$r_f_name_empty="Ответственное лицо ФИО *";
		$r_f_post_empty="Должность *";
		$r_f_phone_empty="Телефон *";
		$r_f_site_empty="Сайт";
		$r_f_mess_empty="В какой форме происходит сотрудничество с компанией и по какой продукции *";
		$r_f_email_empty="E-mail *";
	}
	
	$r_f_company = trim($_POST['r_f_company']);
	$r_f_view = trim($_POST['r_f_view']);
	$r_f_address = trim($_POST['r_f_address']);	
	$r_f_name = trim($_POST['r_f_name']);
	$r_f_post = trim($_POST['r_f_post']);
	$r_f_phone = trim($_POST['r_f_phone']);
	$r_f_site = trim($_POST['r_f_site']);
	$r_f_mess = trim($_POST['r_f_mess']);
	$r_f_email = trim($_POST['r_f_email']);
	
	if($r_f_site_empty=='Сайт' || $r_f_site_empty=='Website')
		$r_f_site_empty=='';
		
	if($r_f_company==$r_f_company_empty || $r_f_company=='')
		echo 'company';
	else if($r_f_view==$r_f_view_empty || $r_f_view=='')
		echo 'activity';
	else if($r_f_address==$r_f_address_empty || $r_f_address=='')
		echo 'address';
	else if($r_f_name==$r_f_name_empty || $r_f_name=='')
		echo 'name';
	else if($r_f_post==$r_f_post_empty || $r_f_post=='')
		echo 'position';
	else if($r_f_email==$r_f_email_empty || $r_f_email=='')
		echo 'email';
	else if($r_f_phone==$r_f_phone_empty || $r_f_phone=='')
		echo 'phone';	
	//else if($r_f_site==$r_f_site_empty || $r_f_site=='')
	//	echo 'site';
	else if($r_f_mess==$r_f_mess_empty || $r_f_mess=='')
		echo 'mess';
	else if(!preg_match('/[0-9a-z\._-]+@[0-9a-z\._-]+\.[a-z]{2,6}/',$r_f_email))
		echo 'email';
	else if(!preg_match('/^[0-9-+]+$/i',$r_f_phone))
		echo 'phone';
	else
	{
		$title_company='Юридическое название компании';
		$title_view='Вид деятельности';
		$title_address='Почтовый адрес компании';
		$title_name='Ответственное лицо ФИО';
		$title_post='Должность';		
		$title_email='E-mail';
		$title_phone='Телефон';
		$title_site='Сайт';
		$title_mess='В какой форме происходит сотрудничество с компанией и по какой продукции';
		$mess=	"<p><b>".$title_company.": </b>".$r_f_company."</p>".
				"<p><b>".$title_view.": </b>".$r_f_view."</p>".
				"<p><b>".$title_address.": </b>".$r_f_address."</p>".
				"<p><b>".$title_name.": </b>".$r_f_name."</p>".
				"<p><b>".$title_post.": </b>".$r_f_post."</p>".
				"<p><b>".$title_email.": </b>".$r_f_email."</p>".
				"<p><b>".$title_phone.": </b>".$r_f_phone."</p>".
				"<p><b>".$title_site.": </b>".$r_f_site."</p>".
				"<p><b>".$title_mess.": </b>".$r_f_mess."</p>";
		
		define('INCLUDE_CHECK',true);
        require 'send_mail.php';
		
		//Добавим пользователя
		$user = new CUser;
		
		function generate_password($number)  
		{  
			$arr = array(
			'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','x','y','z',
			'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','X','Y','Z',
			'1','2','3','4','5','6','7','8','9','0');  
			// Генерируем пароль  
			$pass = "";  
			for($i = 0; $i < $number; $i++)  
			{  
			  // Вычисляем случайный индекс массива  
			  $index = rand(0, count($arr) - 1);  
			  $pass .= $arr[$index];  
			}  
			return $pass;  
		}
		
		$pass = generate_password(6);
		
		if($lang=='RUS'){
			$lid = 'ru';
		}elseif($lang=='ENG'){
			$lid = 'en';
		}elseif($lang=='DEU'){
			$lid = 'de';
		}
			
		
		$arFields = Array(
		  "NAME"              => $r_f_name,
		  "EMAIL"             => $r_f_email,
		  "LOGIN"             => $r_f_email,
		  "LID"               => $lid,
		  "ACTIVE"            => "Y",
		  "GROUP_ID"          => array(5),
		  "PASSWORD"          => $pass,
		  "CONFIRM_PASSWORD"  => $pass
		);

		$ID = $user->Add($arFields);
		if (intval($ID) > 0){
		
			/*$sendit=send_mail(
				//to:
				$mail_to,
				//subject:
				'Заявка на регистрацию',
				//body:
				$mess,
				//headers (from):
				$site_name.'<'.$mail_from.'>'
			);*/
			
			//Отправка на почту
	
			$arFields = Array(	
				"CONTENT"=>$mess	
			);

			$eventName = "SEND_FORM";
							
			$event = new CEvent;
			
			$success = false;
			
			if(!$err){			
			
				if($sendit = $event->SendImmediate($eventName, SITE_ID, $arFields, "N", 84)){				
					$success = 'Y';
				}	
			}
			
		}else{
			echo $user->LAST_ERROR;				
		}
		
		if ($sendit==TRUE)
		{
			echo 'ok';
		}
	}
}

//форма рекламации
if(isset($_POST['rekl_organization'])){
	?><pre><?//print_r($_POST)?></pre><?
	?><pre><?//print_r($_FILES)?></pre><?	
	/*класс для отправки файлов в init.php*/
	
	
	//основные данные
	$organization = $_POST['rekl_organization'];
	$city = $_POST['rekl_city'];
	$contact = $_POST['rekl_contact'];
	$mail = $_POST['rekl_mail'];
	$phone = $_POST['rekl_phone'];
	$date = $_POST['rekl_date'];
	$num_date = $_POST['rekl_num_date'];
	
	//обработка добавляемых данных
	$arKeys = array();
	foreach($_POST as $k=>$v){
		$TmpK = explode('_', $k);
		if($TmpK[3] && !in_array($TmpK[3], $arKeys)){
			$arKeys[] = $TmpK[3];
		}		
	}
	sort($arKeys);
	
	//массив полей по каждому товару
	$arRes = array();
	$newFile = new VFile;
	
	for($i=1; $i<=count($arKeys); $i++){
		$arTmp = array(
			'item_name'=>$_POST['rekl_item_name_'.$i],
			'last_num'=>$_POST['rekl_last_num_'.$i],
			'issue_num'=>$_POST['rekl_issue_num_'.$i],
			'def_num'=>$_POST['rekl_def_num_'.$i],
			'all_num'=>$_POST['rekl_all_num_'.$i],
			'def_desc'=>$_POST['rekl_def_desc_'.$i],
			'def_cause'=>$_POST['rekl_def_cause_'.$i],
			'def_moment'=>$_POST['rekl_def_moment_'.$i],
			'first_on'=>$_POST['rekl_first_on_'.$i],
			'stop_after'=>$_POST['rekl_stop_after_'.$i],
			'stop_days'=>$_POST['rekl_stop_days_'.$i]
		);
		$arRes['data'][] = $arTmp; 
		
		//загрузка файлов
		$inputName = 'rekl_def_photo_'.$i;
		$Uid = rand(100, 999999);//можно использовать для уникализации папки
		$count = count($_FILES['rekl_def_photo_'.$i]['name']);	
		$subdir = '/upload/reclamation_files/';
		$filename = $newFile->FullUpload($inputName, $Uid, $count, $subdir);
		$arRes['files'][] = $filename;		
		
		if($filename == 'error'){
			$err = true;
		}
		
	}
	//конец добавляемых данных
	
	//Добавляем файлы из статичных полей
		$arInput = array(
		'rekl_def_brak', 'rekl_def_boy', 'rekl_def_else'
		);
		foreach($arInput as $input){
			$inputName = $input;
			$Uid = rand(100, 999999);//можно использовать для уникализации папки
			$count = count($_FILES['rekl_def_brak']['name']);
			$subdir = '/upload/reclamation_files/';			
			$filename = $newFile->FullUpload($inputName, $Uid, $count, $subdir);
			$arRes['files']['dop'][$input] = $filename;
			
			if($filename == 'error'){
				$err = true;
			}
		}
	
	//vars
	$header = '<!DOCTYPE html><html><body>';
    $content = "";
	$content = $content.'<h1>Рекламация</h1><p>';
	if($organization!==''){
		$content = $content.'Организация: '.$organization.'<br/>';
	}
	if($city!==''){
		$content = $content.'Город : '.$city.'<br/>';
	}
	if($contact!==''){
		$content = $content.'Контактное лицо : '.$contact.'<br/>';
	}
	if($mail!==''){
		$content = $content.'Почта : '.$mail.'<br/>';
	}
	if($phone!==''){
		$content = $content.'Телефон : '.$phone.'<br/>';
	}
	if($date!==''){
		$content = $content.'Дата покупки : '.$date.'<br/>';
	}
	if($num_date!==''){
		$content = $content.'Номер и дата сопроводительного документа : '.$num_date.'<br/>';
	}
	$content = $content.'</p>';
	$content = $content.'<h3>Товары:</h3><p>';
	foreach($arRes['data'] as $k=>$v){
		$content = $content.'Наименование: '.$v['item_name'].'<br/>';
		$content = $content.'Последние цифры спецификации: '.$v['last_num'].'<br/>';
		$content = $content.'Номер партии: '.$v['issue_num'].'<br/>';
		$content = $content.'Количество с дефектом: '.$v['def_num'].'<br/>';
		$content = $content.'Количество всего: '.$v['all_num'].'<br/>';
		if($v['first_on']=='on'){
			$content = $content.'Не работает при первом включении: Да<br/>';
		}
		if($v['stop_after']=='on'){
			$content = $content.'Перестал работать через: '.$v['stop_days'].' дней<br/>';
		}
		$content = $content.'Описание дефекта: '.$v['def_desc'].'<br/>';
		$content = $content.'Возможные причины: '.$v['def_cause'].'<br/>';
		$content = $content.'Момент обнаружения: '.$v['def_moment'].'<br/><br/>';
		$content = $content.'Файлы: ';
		foreach($arRes['files'][$k] as $file){
			$content = $content.'<br/>'.$file;
		}
		$content = $content.'</p>';
		$content = $content.'<p>';
	}
	$content = $content.'</p>';
	$content = $content.'<h4>Дополнительные файлы:</h4>';
	$content = $content.'<p>';
	foreach($arRes['files']['dop'] as $k=>$dopfiles){
		foreach($dopfiles as $dopfile){
			$content = $content.' '.$dopfile.'<br/>';
		}
	}
	$content = $content.'</p>';
	
	$footer = '</body></html>';
	
	//собираем файлы
	$path = '/upload/reclamation_files/';
	
	
	$allFiles = '';
	
	foreach($arRes['files']['dop'] as $k=>$dopfiles){
		foreach($dopfiles as $k=>$dopfile){
			$allFiles .= $path.$dopfile.';';
		}
	}
	foreach($arRes['data'] as $k=>$v){
		foreach($arRes['files'][$k] as $file){
			$allFiles .= $path.$file.';';
		}
	}
	$allFiles = substr($allFiles, 0, -1);
	
	
		
	//Отправка на почту
	
	$arFields = Array(	
		"CONTENT"=>$header.$content.$footer,		
		"FILE_1_1"=>$allFiles,		
        "EMAIL"=> $mail,
	);
    
    if (file_exists($_SERVER["DOCUMENT_ROOT"]."/include/tcpdf/tcpdf.php")) {
        include($_SERVER["DOCUMENT_ROOT"]."/include/tcpdf/tcpdf.php");
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(20, 30, 20);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('dejavusans');
        $pdf->AddPage();
        $pdf->writeHTML($content, true, false, true, false, '');
        $pdf_file = '/upload/reclamation_files/reclamation'.uniqid().'.pdf';
        $pdf->Output($_SERVER["DOCUMENT_ROOT"]. $pdf_file, "F");
        $arFields["FILE_1_1"] .= ";".$pdf_file;
    }

	$eventName = "SEND_RECLAMATION";
					
	$event = new CEvent;
	
	$success = false;
	
	if(!$err){
		if($event->Send($eventName, SITE_ID, $arFields, "N")){				
			$success = 'Y';
		}	
	}	

}

?>