<?php
class SMapCorr
{
    // проверка на необходимость корректировки
    function main(&$arFields)
    {
        if($arFields["RESULT"])
            AddMessage2Log("Запись с кодом ".$arFields["ID"]." изменена.");
        else
            AddMessage2Log("Ошибка изменения записи ".$arFields["ID"]." (".$arFields["RESULT_MESSAGE"].").");
    }
}