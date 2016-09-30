<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("subscribe");
//header('Content-Type: text/html; charset=utf-8');

function DisplayExcel($arHeaders, $arData) {
    /** @global CMain $APPLICATION */
    global $APPLICATION;
    echo '
		<html>
		<head>
		<title>Подписчики</title>
		<meta http-equiv="Content-Type" content="text/html; charset=' . LANG_CHARSET . '">
		<style>
			td {mso-number-format:\@;}
			.number0 {mso-number-format:0;}
			.number2 {mso-number-format:Fixed;}
		</style>
		</head>
		<body>';

    echo "<table border=\"1\">";
    echo "<tr>";

    foreach ($arHeaders as $header) {
        echo '<td>';
        echo $header;
        echo '</td>';
    }
    echo "</tr>";


    foreach ($arData as $arRow) {
        echo "<tr>";
        foreach ($arRow as $key => $val) {


            echo '<td>';
            echo ($val <> "" ? $val : '&nbsp;');
            echo '</td>';
        }
        echo "</tr>";
    }

    echo "</table>";
    echo '</body></html>';
}

function ShowExcelHeaders() {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: filename=subscribers.xls");
}

$rsSubscription = CSubscription::GetList();

$arResult = array();
//перебираем подписчиков
while ($arSubscription = $rsSubscription->GetNext()) {

    //получаем рубники, на которые подписан подписчик
    $arRubrics = array();
    $rsRubrics = CSubscription::GetRubricList($arSubscription["ID"]);
    while ($arRubric = $rsRubrics->GetNext()) {
        if ($arRubric["ACTIVE"] == "Y") {
            $arRubrics[] = $arRubric["NAME"];
        }
    }

    $subscr_arrmy["USER_PROPERTIES"] = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields(
        "MY_SUBSCRIPTION", $arSubscription["ID"], LANGUAGE_ID
    );

    $arResult[] = array(
        "COMPANY" => $subscr_arrmy["USER_PROPERTIES"]["UF_COMPANY_NAME"]["VALUE"],
        "CITY" => $subscr_arrmy["USER_PROPERTIES"]["UF_TOWN"]["VALUE"],
        "FIO" => $subscr_arrmy["USER_PROPERTIES"]["UF_FIO"]["VALUE"],
        "RANG" => $subscr_arrmy["USER_PROPERTIES"]["UF_POST"]["VALUE"], //должность
        "RUBRIC" => implode(", ", $arRubrics),
        "EMAIL" => $arSubscription["EMAIL"],
        "SITE" => $subscr_arrmy["USER_PROPERTIES"]["UF_SITE"]["VALUE"],
        "PHONE" => $subscr_arrmy["USER_PROPERTIES"]["UF_PHONE"]["VALUE"],
        "DATE_TIME" => $arSubscription["DATE_INSERT"]
    );
}

$arHeaders = array(
    "COMPANY" => "Компания",
    "CITY" => "Город",
    "FIO" => "ФИО",
    "RANG" => "Должность",
    "RUBRIC" => "Рубрика",
    "EMAIL" => "E-mail",
    "SITE" => "Сайт",
    "PHONE" => "Телефон",
    "DATE_TIME" => "Дата/время"
);

ShowExcelHeaders();
DisplayExcel($arHeaders, $arResult);
?>