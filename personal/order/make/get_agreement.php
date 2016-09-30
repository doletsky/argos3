<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оформление договора");
?>
<div id="content" class="whole_page basket agree_confirm">
	<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "eshop_adapt", array(
			"START_FROM" => "1",
			"PATH" => "",
			"SITE_ID" => "-"
		),
		false,
		Array('HIDE_ICONS' => 'Y')
	);?>
	<h1 style="float: none">Уважаемый клиент! Спасибо за оформление заказа.</h1>
	<p>Уважаемый клиент, Ваш заказ и договор оформлены. Большое Вам спасибо, что воспользовались "он-лайн заказом"</p>
	<p>
	Здесь прикреплён сформированный договор: <a href="/dompdf_lib/agreement.php/?DOWNLOAD=Y" target="_blank" id="dompdf_zakaz">dogovor.pdf</a><br/>
	Пожалуйста, распечатайте договор, подпишите и отправьте его нам почтой.
	</p>
	<p>Наши менеджеры свяжутся с Вами в ближайшее время.</p>
</div>
<?
if(isset($_POST)){

	$arRes = array();
	$newFile = new VFile;
	
	//загрузка файлов
		$inputName = 'contract_files';
		$Uid = rand(100, 999999);//можно использовать для уникализации папки
		$count = count($_FILES['contract_files']['name']);	
		$subdir = '/upload/contract_files/';
		$filename = $newFile->FullUpload($inputName, $Uid, $count, $subdir);
		$arRes['files'][] = $filename;
		
		if($filename == 'error'){
			$err = true;
		}
		
	
	//собираем файлы
	$path = '/upload/contract_files/';
	
	
	$allFiles = '';	
	
	foreach($arRes['files'][0] as $file){
		$allFiles .= $path.$file.';';
	}
	
	$allFiles = substr($allFiles, 0, -1);	
	
	$_SESSION['agreement'] = array();
	
	foreach($_POST as $k=>$v){
		$_SESSION['agreement'][$k] = $v;
	}
}

include("../../../dompdf_lib/agreement_mail.php");
//отправка на почту
if(isset($_POST['mail']) && empty($_POST['mail'])){
	$mail = $_POST['mail'];//$EMAIL.', '.COption::GetOptionString("sale", "order_email");					
}							
	$arFields87 = Array(						
		"MAILS"=>$mail,
		"CONTRACT"=>"/dompdf_lib/tmp_gen/agreement.pdf",
		"CONTRACT_FILES"=>$allFiles,	
	);
	$arFields88 = Array(
		//"MAILS"=>$mail,
		"CONTRACT_DOC"=>"/dompdf_lib/tmp_gen/agreement.doc",
		"CONTRACT_FILES"=>$allFiles,
	);


	$eventName = "DOCS_SEND";
	$event = new CEvent;
	
	$event->Send($eventName, SITE_ID, $arFields87, "N", 87); //to Client
	$event->Send($eventName, SITE_ID, $arFields88, "N", 88); // to Argos
	
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>