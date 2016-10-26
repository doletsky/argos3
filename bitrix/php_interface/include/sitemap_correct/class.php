<?php
include $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/tune_data.php";
class SMapCorr
{
    // проверка на необходимость корректировки
    function main(&$arFields)//готовит данные для определения необходимых действий и вызывает их
    {
        global $tuneData;
        $mArFields=$arFields;

            if(is_array($tuneData['IBLOCK'][$mArFields['IBLOCK_ID']])){
                $val=$tuneData['IBLOCK'][$mArFields['IBLOCK_ID']];
                file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/debugLogData.txt", print_r($mArFields,true).print_r($val,true));
            }else{
                file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/debugLogData.txt", "do not correcting");
            }

    }
}