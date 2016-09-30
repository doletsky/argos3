<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "На этой странице Вы найдете ответы на частозадаваемые вопросы о светодиодных модулях, промышленных светильниках, драйверах ИПС. Информация о световом потоке и его пульсациях, мощности светильников, степени защиты, подключение светильников, всё о светодиодных линейках, вопросы цветопередачи, цветовой температуры и многое другое.");
$APPLICATION->SetPageProperty("keywords", "светильники жкх, драйвер светодиодной лампы, драйвер для светодиодной ленты, схема светодиодного драйвера, драйвера для светодиодных светильников, светодиодные модули для строк, светодиодные модули для бегущих строк, светодиодные модули для светильников, светильник жкх с датчиком, световой поток");
$APPLICATION->SetPageProperty("title", "Ответы на вопросы о светильниках ЖКХ, светодиодных модулях и драйверах ИПС");
$APPLICATION->SetTitle("Ваши вопросы о промышленных светильниках, светодиодных модулях и драйверах ИПС");
?>

<? $iblock_id = 23; ?>

<div id="content">
    <?
    $APPLICATION->IncludeComponent("bitrix:breadcrumb", "eshop_adapt", array(
        "START_FROM" => "1",
        "PATH" => "",
        "SITE_ID" => "-"
            ), false, Array('HIDE_ICONS' => 'Y')
    );
    ?>
    <div class="content_left">
        <!-- Vertical menu -->
        <?
        $APPLICATION->IncludeComponent("bitrix:menu", "tree_vertical", array(
            "ROOT_MENU_TYPE" => "vert_production",
            "MENU_CACHE_TYPE" => "A",
            "MENU_CACHE_TIME" => "36000000",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_CACHE_GET_VARS" => array(),
            "MAX_LEVEL" => "2",
            "CHILD_MENU_TYPE" => "podmenu",
            "USE_EXT" => "N",
            "ALLOW_MULTI_SELECT" => "N"
                ), false
        );
        ?>
        <? include ($_SERVER["DOCUMENT_ROOT"] . SITE_DIR . "sidebar.php"); ?>
    </div>
    <div class="content_right">

        <h1>F.A.Q.</h1>				
        <div id="print">Печатная версия</div>
        <div class="clear"></div>
        <p class="text_page_info_2">
            Нажмите для быстрого перехода к группе
        </p>
        <? if (CModule::IncludeModule("iblock")) { ?>
            <div class="tabs_simple_style" style="margin-bottom: 20px;">
                <?php
                $ar_result2 = CIBlockSection::GetList(Array("SORT" => "ASC"), Array("IBLOCK_ID" => $iblock_id));
                while ($res2 = $ar_result2->GetNext()) {
                    ?>
                    <div class="tab_simple_style tab">
                        <a class="s_15" href="#<?= $res2['ID'] ?>"><?= $res2['NAME'] ?></a>                   
                    </div>
                <?php } ?>
            </div>    
        <?php } ?>
        <?
        if (CModule::IncludeModule("iblock")) {
            $ar_result2 = CIBlockSection::GetList(Array("SORT" => "ASC"), Array("IBLOCK_ID" => $iblock_id));
            while ($res2 = $ar_result2->GetNext()) {
                $sec_id = $res2['ID'];
                $sec_name = $res2['NAME'];
                ?>
                <div class="faq_block">
                    <a name="<?= $sec_id ?>"></a>
                    <h2 class="title_page_red"><?= $sec_name ?></h2>
                    <?
                    $arSelect = array("ID", "NAME", "DETAIL_TEXT", "SECTION_ID");
                    $ar_result = CIBlockElement::GetList(Array("SORT" => "ASC", "NAME" => "ASC"), Array("IBLOCK_ID" => $iblock_id, "SECTION_ID" => $sec_id), $arSelect);
                    $count = 1;
                    while ($res = $ar_result->GetNext()) {
                        $addClass = "";
                        if ($count % 2 == 0) {
                            $addClass = " second";
                        }

                        $question = $res['NAME'];
                        $answer = $res['DETAIL_TEXT'];

                        $Trans = array_flip(get_html_translation_table());
                        $answerFormat = strtr($answer, $Trans);
                        ?>
                        <div class="question_wrap<?= $addClass ?>">
                            <div class="question"><?= $count ?>. Вопрос: <?= $question ?></div>
                            <div class="answer"><span>Ответ: </span><?= $answerFormat ?></div>
                        </div>
                        <?
                        $count++;
                    }
                    ?>
                </div>
                <?
            }
        }
        ?>
    </div>
    <div class="clear"></div>
</div>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php") ?>