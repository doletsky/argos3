<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");
?>
<br /><br />
<h1 style="font-size: 40px;margin-left: 50px;">Страница не найдена</h1>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<b style = "margin-left: 50px;">404!</b>
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<?
/*$APPLICATION->IncludeComponent("bitrix:main.map", ".default", array(
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"SET_TITLE" => "Y",
	"LEVEL"	=>	"3",
	"COL_NUM"	=>	"2",
	"SHOW_DESCRIPTION" => "Y"
	),
	false
);*/

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>