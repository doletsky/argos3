<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Смена пароля");
?>
<h1>Вы запросили смену пароля для своего аккаунта.</h1>
<div style="clear:both"></div>
<?
if(isset($_POST["pass"])){
	$user = new CUser;
	$ID = $_GET["ID"];
	
	$GetHash = $_GET["HASH"];
	$rsUser = $user->GetByID($ID);
	$arUser = $rsUser->Fetch();
	$mail = $arUser["EMAIL"];
	$RealHash = md5($mail);
	$CheckHash = ($RealHash == $GetHash);
	
	if($CheckHash){
		$fields = Array(
		  "PASSWORD"          => $_POST["pass"],
		  "CONFIRM_PASSWORD"  => $_POST["pass"],
		  );
		if($user->Update($ID, $fields)){
			$str = "Пароль успешно изменён на ".$_POST["pass"]."!";
		}else{
			$strError .= $user->LAST_ERROR;
			$str = $strError;
		}
	}else{
		$str = "Ошибка проверки хэш-кода! Изменение невозможно!";
	}
	
	echo "<p style='margin: 20px 0; color: #000'>".$str."</p>";
}
?>
<p style="margin: 20px 0">Чтобы сменить пароль, введите его в поле или нажмите кнопку "Сгенерировать".</p>
<form action="" method="POST">
	<value>Введите пароль:</value><br/><br/>
	<input type="text" name="pass" id="pass" value="" class="input_style"/><a href="" onclick="genPass();return false;" style="color:#444;">Сгенерировать</a><br/><br/><br/>
	<input type="submit" class="submit_style"/>
</form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>