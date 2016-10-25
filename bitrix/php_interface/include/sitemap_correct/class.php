<?php
include $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/tune_data.php";
class SMapCorr
{

    // проверка на необходимость корректировки
    function main(&$arFields)//готовит данные для определения необходимых действий и вызывает их
    {
        $mArFields=$arFields;
        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/debugLogData.txt", print_r($mArFields,true).print_r($tuneData,true));
    }
}