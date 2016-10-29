<?php
include $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/tune_data.php";
CModule::IncludeModule("iblock");
$xmlstr = <<< XML
<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>
XML;
$xmlNew=new SimpleXMLElement($xmlstr);
    // проверка на необходимость корректировки
    function SMapCorrMain(&$arFields)//готовит данные для определения необходимых действий и вызывает их
    {
        global $tuneData;
        global $xmlNew;
        $mArFields=$arFields;

            if(is_array($tuneData['IBLOCK'][$mArFields['IBLOCK_ID']])){//если в настройках такой ИБ есть
                $val=$tuneData['IBLOCK'][$mArFields['IBLOCK_ID']];
                //забираем и парсим уже существующий xml
                if (file_exists($_SERVER["DOCUMENT_ROOT"].'/'.$val["fileNamXML"])) {//если существует
                    $xml = simplexml_load_file($_SERVER["DOCUMENT_ROOT"].'/'.$val["fileNamXML"]);//получаем xml-объект
                }else{//если не существует инициируем пустой
                    $xml=$xmlNew;
                }
                //читаем массив "mapLinkData" и вызываем соответсвующие функции
                foreach($val["mapLinkData"] as $ver){
                    foreach($ver as $func=>$rules){
                        $func($xml,$rules);
                    }
                }
                file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/debugLogData.txt", print_r($mArFields,true).print_r($xml,true).PHP_EOL.$xml->asXML());
            }else{
                file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/debugLogData.txt", "do not correcting");
            }

    }

    function del($xmlObj, $arRule){
        global $xmlNew;
        $arDel=array();
        foreach($arRule as $fRule=>$dRule){
            $arDel[$fRule]=$fRule($arRule[$fRule]);
        }
        if(count($arDel)>0){
            foreach($arDel as $subArDel){
                foreach($subArDel as $param){
                    foreach($param as $logic=>$arStr){
                        $i=0;
//                        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/debugLogPARAM.txt", $logic.PHP_EOL.print_r($arStr,true));
                        if($logic=='NOT'){//все, что не содержит удаляем
                            foreach($xmlObj->url as $url){
                                foreach($arStr as $str){
                                    if(substr_count((string)$url->loc, $str)!=0){
                                        //удаление из xml объекта
                                        $cnt=count($xmlNew);
                                        $xmlNew->addChild('url');
                                        $xmlNew->url[$cnt]->addChild($xmlObj->url[$i]->children()[0]->getName(), (string)$xmlObj->url[$i]->children()[0]);
                                        $xmlNew->url[$cnt]->addChild($xmlObj->url[$i]->children()[1]->getName(), (string)$xmlObj->url[$i]->children()[1]);
//                                        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/debugLogXML"."_".$i.".txt", substr_count((string)$url->loc, $str).print_r($xmlObj->url[$i], true));
//                                        $arI[]=$i;
//                                    }else{
//
                                    }
                                }
                                $i++;
                            }
                        }else{//все, что содержит удаляем

                        }

                    }
                }
            }

        }

        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/debugLogXML.txt", print_r($arDel,true).PHP_EOL.count($xmlNew).PHP_EOL.$xmlNew->asXML());
    }

    function add($xmlObj, $arRule){

    }

    function repl($xmlObj, $arRule){

    }

    function mask($arMask){

    }
    function id($arId){
        $rData=array();
        $l='0';
        foreach($arId as $key=>$arData){
            $b=explode('!',$key);
            $c=count($b);
            if($c==2){
                $l='NOT';
            }
//            file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/debugLogFunc.txt", print_r($b,true).PHP_EOL.$b[$c-1]);
//            echo $fn=$b[$c-1];
            $rData[$b[$c-1]]=array(
               $l =>  $b[$c-1]($arData)
            );
        }
        return $rData;
    }
    function code($arCode){

    }

    function sid($arSid){//из section_id возвращает section_code
        $arSidCode=array();
        foreach($arSid as $sid){
            $res = CIBlockSection::GetByID($sid);
            $arSidFields = $res->GetNext();
            if(strlen($arSidFields['CODE'])>0) $arSidCode[]="/".$arSidFields['CODE']."/";
        }
        return $arSidCode;
    }
    function eid($arEid){

    }