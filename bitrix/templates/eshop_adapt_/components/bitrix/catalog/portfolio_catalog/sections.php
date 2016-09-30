<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?
if (SITE_DIR == '/') {
    include "lang/ru/template.php";
}
if (SITE_DIR == '/en/') {
    include "lang/en/template.php";
}
?>
<div>
<script>
$( document ).ready(function() {
function scrollToElement(theElement) {
if (typeof theElement === "string") theElement = document.getElementById(theElement);

    var selectedPosX = 0;
    var selectedPosY = 0;

    while (theElement != null) {
        selectedPosX += theElement.offsetLeft;
        selectedPosY += theElement.offsetTop;
        theElement = theElement.offsetParent;
    }

    window.scrollTo(selectedPosX, selectedPosY);
}


scrollToElement('footer_bot_1'); // теперь это будет работать
});

</script>

    <h1>Портфолио</h1>
    <a id="btn_add_object" class="ancLinks" href="#add_object_form" >Добавить свой объект</a>
    <div id="print">Печатная версия</div>
</div>
<div class="clear"></div>
<?
//Умный фильтр
if (CModule::IncludeModule("iblock") && COption::GetOptionString("eshop", "catalogSmartFilter", "Y", SITE_ID) == "Y") {
    $arFilter = array(
        "ACTIVE" => "Y",
        "GLOBAL_ACTIVE" => "Y",
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    );
    if (strlen($arResult["VARIABLES"]["SECTION_CODE"]) > 0) {
        $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
    } elseif ($arResult["VARIABLES"]["SECTION_ID"] > 0) {
        $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
    }

    $obCache = new CPHPCache;
    if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
        $arCurSection = $obCache->GetVars();
    } else {
        $arCurSection = array();
        $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));
        $dbRes = new CIBlockResult($dbRes);

        if (defined("BX_COMP_MANAGED_CACHE")) {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache("/iblock/catalog");

            if ($arCurSection = $dbRes->GetNext()) {
                $CACHE_MANAGER->RegisterTag("iblock_id_" . $arParams["IBLOCK_ID"]);
            }
            $CACHE_MANAGER->EndTagCache();
        } else {
            if (!$arCurSection = $dbRes->GetNext())
                $arCurSection = array();
        }

        $obCache->EndDataCache($arCurSection);
    }

    $smartFilterTemplate = COption::GetOptionString("main", "wizard_template_id", "eshop_vertical", SITE_ID) == "eshop_horizontal" ? "sidebar" : "";
    ?>

    <?
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.smart.filter", "filter_portfolio", Array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "SECTION_ID" => $arCurSection["ID"],
        "FILTER_NAME" => "arrFilter",
        "PRICE_CODE" => $arParams["PRICE_CODE"],
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_NOTES" => "",
        "CACHE_GROUPS" => "Y",
        "SAVE_IN_SESSION" => "N",
        //"INSTANT_RELOAD" => "Y",
        //"AJAX_MODE" => "Y",
        ), false, Array('HIDE_ICONS' => 'Y')
    );
    ?>
    <?
}

if ($USER->IsAdmin() || $USER->GetID() == 98) {
    
    $APPLICATION->IncludeComponent("bitrix:catalog.filter", "portfolio", Array(
        "IBLOCK_TYPE" => "content", // Тип инфоблока
        "IBLOCK_ID" => "8", // Инфоблок
        "FILTER_NAME" => "arrFilter2", // Имя выходящего массива для фильтрации
        "FIELD_CODE" => array(// Поля
            0 => "DATE_CREATE",
        ),
        "PROPERTY_CODE" => array(// Свойства
            0 => "MANUFACTURER_OF_LAMPS",
            1 => "",
        ),
        "LIST_HEIGHT" => "5", // Высота списков множественного выбора
        "TEXT_WIDTH" => "20", // Ширина однострочных текстовых полей ввода
        "NUMBER_WIDTH" => "5", // Ширина полей ввода для числовых интервалов
        "CACHE_TYPE" => "A", // Тип кеширования
        "CACHE_TIME" => "36000000", // Время кеширования (сек.)
        "CACHE_GROUPS" => "Y", // Учитывать права доступа
        "SAVE_IN_SESSION" => "N", // Сохранять установки фильтра в сессии пользователя
        "PRICE_CODE" => "", // Тип цены
        ), false
    );

    if (is_array($GLOBALS["arrFilter"]) && is_array($GLOBALS["arrFilter2"])) {
        $GLOBALS["arrFilter"] = array_merge($GLOBALS["arrFilter"], $GLOBALS["arrFilter2"]);
    }
    $cnt = CIBlockElement::GetList(
            array(), array_merge(array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "ACTIVE" => "Y"), $GLOBALS["arrFilter"]), array()
    );
    ?>
    <div class="portfolio-selected">Выбранное количество по фильтру: <?= $cnt ?></div>
    <?
}
?>

<?
//Считаем посещения
if (SITE_DIR == '/') {
    $elID = 1072;
} else {
    $elID = 1073;
}
CIBlockElement::CounterInc($elID);
$res = CIBlockElement::GetByID($elID);
if ($ar_res = $res->GetNext()) {
    $counter = $ar_res['SHOW_COUNTER'];
}
?>

<div id="portfolio_result">	
    <div class="navigation_news marg_top_10 portfolio">
        <span class="sort_title"><?= $MESS["SORT_BY"] ?></span>
        <span class="sort_one"><?= $MESS["DATE"] ?></span>
        <a href="<?= SITE_DIR ?>portfolio/?sort=date&order=asc" class="asc btn_sort<? if ($_REQUEST["sort"] == 'date' && $_REQUEST["order"] == 'asc') echo' active' ?>"></a>
        <a href="<?= SITE_DIR ?>portfolio/?sort=date&order=desc" class="desc btn_sort<? if ($_REQUEST["sort"] == 'date' && $_REQUEST["order"] == 'desc') echo' active' ?>"></a>
        <span class="sort_one"><?= $MESS["MANUFACTURE"] ?></span>
        <a href="<?= SITE_DIR ?>portfolio/?sort=manufacturer&order=asc" class="asc btn_sort<? if ($_REQUEST["sort"] == 'manufacturer' && $_REQUEST["order"] == 'asc') echo' active' ?>"></a>
        <a href="<?= SITE_DIR ?>portfolio/?sort=manufacturer&order=desc" class="desc btn_sort<? if ($_REQUEST["sort"] == 'manufacturer' && $_REQUEST["order"] == 'desc') echo' active' ?>"></a>
        <div id="review_count"><?= $MESS["VIEWED_1"] ?><?= $counter ?><?= $MESS["VIEWED_2"] ?></div>
        <div class="clear"></div>
    </div>

    <?
// Elements sort
    $arAvailableSort = array(
        "manufacturer" => Array("PROPERTY_MANUFACTURER_OF_LAMPS", "asc"),
        "date" => Array('date', "desc"),
    );
    $sort = array_key_exists("sort", $_REQUEST) && array_key_exists(ToLower($_REQUEST["sort"]), $arAvailableSort) ? $arAvailableSort[ToLower($_REQUEST["sort"])][0] : "date";
    $sort_order = array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ? ToLower($_REQUEST["order"]) : "desc";
    ?>
    <?
    $intSectionID = 0;
    $intSectionID = $APPLICATION->IncludeComponent(
        "bitrix:catalog.section", "portfolio", array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "USE_ELEMENT_COUNTER" => "Y",
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ELEMENT_SORT_FIELD" => $sort, //$arParams["ELEMENT_SORT_FIELD"],
        "ELEMENT_SORT_ORDER" => $sort_order, //$arParams["ELEMENT_SORT_ORDER"],
        //"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
        //"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
        "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
        "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
        "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
        "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
        "INCLUDE_SUBSECTIONS" => $INCLUDE_SUBSECTIONS, //$arParams["INCLUDE_SUBSECTIONS"],
        "BASKET_URL" => $arParams["BASKET_URL"],
        "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
        "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
        "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
        "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
        "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
        "FILTER_NAME" => $arParams["FILTER_NAME"],
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_FILTER" => $arParams["CACHE_FILTER"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
        "SET_TITLE" => $arParams["SET_TITLE"],
        "SET_STATUS_404" => $arParams["SET_STATUS_404"],
        "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
        "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
        "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
        "PRICE_CODE" => $arParams["PRICE_CODE"],
        "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
        "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
        "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
        "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
        "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
        "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE" => $arParams["PAGER_TITLE"],
        "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
        "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
        "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
        "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
        "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
        "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
        "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
        "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
        "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
        "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
        "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
        "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
        "DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
        'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
        'LABEL_PROP' => $arParams['LABEL_PROP'],
        'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
        'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
        'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
        'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
        'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
        'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
        'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
        'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
        'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
        'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
        'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
        'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
        ), $component
    );
    ?>
</div>
<div id="add_object_form">
    <div class="add_object_title"><?= $MESS["FORM_TITLE"] ?>
    <br />
    <br />
    <span>
     <?
		$arSelect = Array("ID", "NAME", "PROPERTY_FILES");
		$arFilter = Array("IBLOCK_ID"=>42, "CODE"=>"portfolio", "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
		$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>5), $arSelect);
		while($ob = $res->GetNextElement()):?>
		<?php $arFields = $ob->GetFields();
			$file_info = CFile::GetFileArray($arFields["PROPERTY_FILES_VALUE"]);

			$path_file = $file_info['SRC'];
			$name_file = $file_info['DESCRIPTION'];
			$ext = array_pop(explode (".", $file_info['FILE_NAME']));
			?>
			<?php if(is_file($_SERVER['DOCUMENT_ROOT'] . $path_file)):?>
				<a class="xls_catalog_link <?php echo $ext?>" href="<?php echo $path_file?>" target="_blank"><?php echo $arFields['NAME']?></a>
		<?php endif;?>
	<?php endwhile;?>
	</span>
    </div>
    <div class="add_object_content">
        <? if (SITE_DIR == '/en/') { ?>
            <?
            $APPLICATION->IncludeComponent("bitrix:iblock.element.add.form", "portfolio_form", array(
                "IBLOCK_TYPE" => "content",
                "IBLOCK_ID" => "14",
                "STATUS_NEW" => "2",
                "LIST_URL" => "",
                "USE_CAPTCHA" => "N",
                "USER_MESSAGE_EDIT" => "",
                "USER_MESSAGE_ADD" => "",
                "DEFAULT_INPUT_SIZE" => "30",
                "RESIZE_IMAGES" => "Y",
                "PROPERTY_CODES" => array(
                    0 => "NAME",
                    1 => "DETAIL_PICTURE",
                    2 => "171",
                    3 => "257",
                    4 => "172",
                    5 => "173",
                    6 => "174",
                    7 => "175",
                    8 => "176",
                    9 => "177",
                    10 => "178",
                    11 => "259",
                    12 => "354",
                ),
                "PROPERTY_CODES_REQUIRED" => array(
                    0 => "NAME",
                    1 => "DETAIL_PICTURE",
                    2 => "171",
                    3 => "257",
                    4 => "172",
                    5 => "173",
                    6 => "175",
                    7 => "176",
                    8 => "177",
                    9 => "178",
                    10 => "259",
                ),
                "GROUPS" => array(
                    0 => "1",
                    1 => "5",
                ),
                "STATUS" => array(
                    0 => "2",
                ),
                "ELEMENT_ASSOC" => "PROPERTY_ID",
                "ELEMENT_ASSOC_PROPERTY" => "",
                "MAX_USER_ENTRIES" => "100000",
                "MAX_LEVELS" => "100000",
                "LEVEL_LAST" => "Y",
                "MAX_FILE_SIZE" => "0",
                "PREVIEW_TEXT_USE_HTML_EDITOR" => "Y",
                "DETAIL_TEXT_USE_HTML_EDITOR" => "Y",
                "SEF_MODE" => "Y",
                "SEF_FOLDER" => "/",
                "CUSTOM_TITLE_NAME" => "Object name",
                "CUSTOM_TITLE_TAGS" => "",
                "CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
                "CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
                "CUSTOM_TITLE_IBLOCK_SECTION" => "",
                "CUSTOM_TITLE_PREVIEW_TEXT" => "",
                "CUSTOM_TITLE_PREVIEW_PICTURE" => "",
                "CUSTOM_TITLE_DETAIL_TEXT" => "",
                "CUSTOM_TITLE_DETAIL_PICTURE" => ""
                ), false
            );
            ?>
        <? } else { ?>
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:iblock.element.add.form", "portfolio_form", array(
                "IBLOCK_TYPE" => "content",
                "IBLOCK_ID" => "8",
                "STATUS_NEW" => "2",
                "LIST_URL" => "",
                "USE_CAPTCHA" => "N",
                "USER_MESSAGE_EDIT" => "",
                "USER_MESSAGE_ADD" => "",
                "DEFAULT_INPUT_SIZE" => "30",
                "RESIZE_IMAGES" => "Y",
                "PROPERTY_CODES" => array(
                    0 => "NAME",
					1 => "DETAIL_TEXT",
                    2 => "DETAIL_PICTURE",
                    3 => "84",
                    4 => "258",
                    5 => "85",
                    6 => "86",
                    7 => "87",
                    8 => "88",
                    9 => "89",
                    10 => "90",
                    11 => "91",
                    12 => "260",
                    13 => "389",
                    14 => "355",
                ),
                "PROPERTY_CODES_REQUIRED" => array(
                    0 => "NAME",
                    1 => "DETAIL_PICTURE",
                    2 => "84",
                    3 => "258",
                    4 => "85",
                    5 => "86",
                    6 => "88",
                    7 => "89",
                    8 => "90",
                    9 => "91",
                    10 => "260",
                ),
                "GROUPS" => array(
                    0 => "1",
                    1 => "5",
                ),
                "STATUS" => array(
                    0 => "2",
                ),
                "ELEMENT_ASSOC" => "PROPERTY_ID",
                "ELEMENT_ASSOC_PROPERTY" => "",
                "MAX_USER_ENTRIES" => "100000",
                "MAX_LEVELS" => "100000",
                "LEVEL_LAST" => "Y",
                "MAX_FILE_SIZE" => "0",
                "PREVIEW_TEXT_USE_HTML_EDITOR" => "Y",
                "DETAIL_TEXT_USE_HTML_EDITOR" => "Y",
                "SEF_MODE" => "Y",
                "SEF_FOLDER" => "/",
                "CUSTOM_TITLE_NAME" => "Название объекта",
                "CUSTOM_TITLE_TAGS" => "",
                "CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
                "CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
                "CUSTOM_TITLE_IBLOCK_SECTION" => "",
                "CUSTOM_TITLE_PREVIEW_TEXT" => "",
                "CUSTOM_TITLE_PREVIEW_PICTURE" => "",
                "CUSTOM_TITLE_DETAIL_TEXT" => "",
                "CUSTOM_TITLE_DETAIL_PICTURE" => ""
                ), false
            );
            ?>
        <? } ?>
    </div>
</div>