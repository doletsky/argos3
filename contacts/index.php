<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Главный офис компании Аргос-Трейд находится в Санкт-Петербурге, производство Аргос-Электрон находится в  Ленинградской области.");
$APPLICATION->SetPageProperty("keywords", "адрес аргос-трейд, телефон аргос-трейд");
$APPLICATION->SetPageProperty("title", "Контакты Аргос-Трейд");
$APPLICATION->SetTitle("Контакты Аргос-Трейд");
?> 
<div id="content" class="whole_page"> 	<?
    $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb", "eshop_adapt", Array(
        "START_FROM" => "1",
        "PATH" => "",
        "SITE_ID" => "-"
        ), false, Array(
        'HIDE_ICONS' => 'Y'
        )
    );
    ?> 	 
    <h1>Контакты</h1>

    <div id="print">Печатная версия</div>

    <div class="clear"></div>
    <?
    //Вывод контента страницы
    if (CModule::IncludeModule('iblock')):
        $ar_result = CIBlockElement::GetList(Array("SORT" => "ASC"), Array("IBLOCK_ID" => 33, "CODE" => "contacts_ru", "ACTIVE" => "Y", "PROPERTY_LANG_VALUE" => "RUS"), Array("DETAIL_TEXT", "CODE", "ACTIVE", "PROPERTY_LANG"));
        if ($ar_fields = $ar_result->GetNext()) {
            if ($ar_fields['DETAIL_TEXT']) {
                echo '<div class="include_area_wrap">' . htmlspecialchars_decode($ar_fields['DETAIL_TEXT']) . '</div>';
            }
        }
    endif;
    ?>		

</div>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php") ?>