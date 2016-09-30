<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($APPLICATION->GetDirProperty("CATALOG_PAGE")) {
	echo $APPLICATION->GetDirProperty("CATALOG_PAGE");
}
else
	echo $APPLICATION->GetDirProperty("CATALOG_PAGE");

IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
$wizTemplateId = COption::GetOptionString("main", "wizard_template_id", "eshop_adapt_horizontal", SITE_ID);
CUtil::InitJSCore();
CJSCore::Init(array("fx"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
	<title><?$APPLICATION->ShowTitle()?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="user-scalable=yes, initial-scale=1.0, maximum-scale=1.0, width=device-width">
	
	<meta property="og:url" content="http://argos-trade.com<?=$_SERVER["REQUEST_URI"]?>">	
	<meta property="og:site_name" content="Argos trade">
	<meta property="fb:app_id" content="940022239345331">
	<meta property="og:type" content="website" >	
	<meta property="og:image" content="<?=SITE_DIR?>/favicon.ico" >
	
	<link rel="shortcut icon" type="image/x-icon" href="<?=SITE_DIR?>/favicon.ico" />
	<?$APPLICATION->ShowHead();
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/colors.css');
	//$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/lofslide_style.css');
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/jquery.bxslider.css');
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/jquery.fancybox-1.3.4.css');
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/new_styles.css');
	
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-1.8.2.min.js");
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.fancybox-1.3.4.pack.js");
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/script.js");	
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/scripts_new.js");	
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.bxslider.min.js");
	//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/lofslide.jquery.easing.js");
	//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/lofslide.js");
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.cookie.js");
	?>
</head>
<body class="grey">
<!-- Google Analytics counter -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75322982-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- Google Analytics counter -->

	<?
	//функции определения кода страны в init.php
	
	if(isset($_COOKIE["site_lang"]))//если пользователем вручную выбрана языковая версия
	{
		if($_COOKIE["site_lang"]=='rus')//если пользователем выбрана русская версия
		{
			if(SITE_DIR=='/en/')//если зашли на английскую версию
				header('Location: /');
		}
		if($_COOKIE["site_lang"]=='eng')//если пользователем выбрана английская версия
		{
			if(SITE_DIR=='/')//если зашли на английскую версию
				header('Location: /en/');
		}
		if($_COOKIE["site_lang"]=='deu')//если пользователем выбрана английская версия
		{
			if(SITE_DIR=='/')//если зашли на английскую версию
				header('Location: /de/');
		}
		if($_COOKIE["site_lang"]=='aut')//если пользователем выбрана английская версия
		{
			if(SITE_DIR=='/')//если зашли на английскую версию
				header('Location: /aut/');
		}
	}
	else
	{
		$IP=getRealIp();//получение ip
		$ipDetail = getCountryByIp($IP);//получение страны по ip
	
		//Логика редиректов
		if($ipDetail=='RU' || $ipDetail=='BE' || $ipDetail=='KK' || $ipDetail=='UZ' || $ipDetail=='UA')//Белоруссия Казахстан Узбекистан Украина Россиия
		{
			if(SITE_DIR=='/en/')//если зашли на английскую версию
			{
				header('Location: /');
			}
		}
		elseif($ipDetail=='DE' || $ipDetail=='AT')//Германия, Австрия
		{
			if(SITE_DIR=='/' || SITE_DIR=='/en/')//если зашли на русскую версию
			{
				header('Location: /de/');
			}
		}
		elseif(!$ipDetail){
			if(SITE_DIR!=='/')//если зашли на русскую версию
			{
				header('Location: /');
			}
		}
		else//Другие страны
		{
			if(SITE_DIR=='/')//если зашли на русскую версию
			{
				header('Location: /en/');
			}
		}
	}
	?>
	
	<div id="panel"><?$APPLICATION->ShowPanel();?></div>
	<?//$APPLICATION->IncludeComponent("bitrix:eshop.banner", "", array());?>
	<?/*<div class="wrap" id="bx_eshop_wrap">*/?>
	<div class="footer_bot_1">
		<div class="footer_bot_2">
		<div id="header" class="min">
			<?/*Авторизация
			$APPLICATION->IncludeComponent("bitrix:system.auth.form", "eshop_adapt", array(
					"REGISTER_URL" => SITE_DIR."login/",
					"PROFILE_URL" => SITE_DIR."personal/",
					"SHOW_ERRORS" => "N"
				),
				false,
				array()
			);
			*/?>
			<div class="header_inner min">
				<?
				if(SITE_DIR!=='/')
					$logo_file='logo_min_en.png';
				else
					$logo_file='logo_min.png';
				?>
				<a href="<?=SITE_DIR?>" class="logo"><img src="/bitrix/templates/eshop_adapt_/images/new_images/<?=$logo_file?>"></a>
				<div class="header_right">
					<div class="header_top">
						<div class="header_col col_1">
							<a href="<?=SITE_DIR?>" class="icon_home"></a>
							<a href="<?=SITE_DIR?>" class="icon_site_map"></a>
						</div>
						<div class="header_col col_2">
							<div class="phone"><?=GetMessage("PHONE_HEADER");?></div>
							<div class="phone_text"><?=GetMessage("PHONE_HEADER_TEXT");?></div>
						</div>
						<div class="header_col col_3">
							<a href="mailto:Kunilovskiy@argos-trade.com" class="icon_mail"><span><?=GetMessage("WRITE_A_LETTER")?></span></a>
						</div>
						<div class="header_col col_4">
							<a href="skype:nearest_flower?call" class="icon_call"><span><?=GetMessage("CALL_US_ONLINE")?></span></a>
						</div>
						
						<div id="language">
						<div class="language_btn">
							<div id="active_language" class="<?
							if(SITE_DIR=='/en/') {
								echo 'eng'; 
							}elseif(SITE_DIR=='/de/') {
								echo 'deu';
							}else{
								echo 'rus';
							}?>">
							<?if(SITE_DIR=='/en/') {
								echo 'ENG'; 
							}elseif(SITE_DIR=='/de/'){
								echo 'DEU';
							}else{
								echo 'RUS';
							}?></div>
							<div id="btn_language"></div>
							<div class="clear"></div>
						</div>
						<ul class="language_list">
							<li><a id="lang_rus" href="/">RUS</a></li>
							<li><a id="lang_eng" href="/en/">ENG</a></li>
							<li><a id="lang_deu" href="/de/">DEU</a></li>
						</ul>
					</div>
						
						<?
					//global $USER;
					//if($USER->IsAdmin()){
						$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "eshop_adapt_new", array(
								"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
								"PATH_TO_PERSONAL" => SITE_DIR."personal/",
								"SHOW_PERSONAL_LINK" => "N"
							),
							false,
							array()
						);
					//}
					?>
						
						<?if(SITE_DIR!=='/') {?>
							<?$APPLICATION->IncludeComponent("bitrix:search.title", "template1", array(
								"NUM_CATEGORIES" => "1",
								"TOP_COUNT" => "100",
								"CHECK_DATES" => "N",
								"SHOW_OTHERS" => "N",
								"PAGE" => SITE_DIR."production/catalog_online/",
								"CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS") ,
								"CATEGORY_0" => array(
									0 => "iblock_catalog",
								),
								"CATEGORY_0_iblock_catalog" => array(
									0 => 10,
								),
								"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
								"SHOW_INPUT" => "Y",
								"INPUT_ID" => "title-search-input",
								"CONTAINER_ID" => "search",
								"PRICE_CODE" => array(
									0 => "BASE",
								),
								"SHOW_PREVIEW" => "Y",
								"PREVIEW_WIDTH" => "75",
								"PREVIEW_HEIGHT" => "75",
								"CONVERT_CURRENCY" => "Y"
								),
								false
							);?>
						<?}
						else {?>
							<?$APPLICATION->IncludeComponent("bitrix:search.title", "template1", array(
								"NUM_CATEGORIES" => "1",
								"TOP_COUNT" => "100",
								"CHECK_DATES" => "N",
								"SHOW_OTHERS" => "N",
								"PAGE" => SITE_DIR."production/catalog_online/",
								"CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS") ,
								"CATEGORY_0" => array(
									0 => "iblock_catalog",
								),
								"CATEGORY_0_iblock_catalog" => array(
									0 => 2,
								),
								"CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
								"SHOW_INPUT" => "Y",
								"INPUT_ID" => "title-search-input",
								"CONTAINER_ID" => "search",
								"PRICE_CODE" => array(
									0 => "BASE",
								),
								"SHOW_PREVIEW" => "Y",
								"PREVIEW_WIDTH" => "75",
								"PREVIEW_HEIGHT" => "75",
								"CONVERT_CURRENCY" => "Y"
								),
								false
							);?>
						<?}?>
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	<div class="workarea_wrap min">
		<?/*$APPLICATION->IncludeComponent("bitrix:breadcrumb", "eshop_adapt", array(
				"START_FROM" => "1",
				"PATH" => "",
				"SITE_ID" => "-"
			),
			false,
			Array('HIDE_ICONS' => 'Y')
		);*/?>