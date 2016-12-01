<?php
include $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/tune_data.php";
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
$xmlstr = <<< XML
<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>
XML;
$xmlNew=new SimpleXMLElement($xmlstr);

$BID=0;//id блока, с которым работаем в данный момент
    // проверка на необходимость корректировки
    function SMapCorrMain(&$arFields)//готовит данные для определения необходимых действий и вызывает их
    {
        global $tuneData;
        global $xmlNew;
        global $BID;
        $mArFields=$arFields;
        $BID=$mArFields['IBLOCK_ID'];

            if(is_array($tuneData['IBLOCK'][$mArFields['IBLOCK_ID']])){//если в настройках такой ИБ есть
                $val=$tuneData['IBLOCK'][$mArFields['IBLOCK_ID']];
                //забираем и парсим уже существующий xml
                if (file_exists($_SERVER["DOCUMENT_ROOT"].'/sitemap_new/'.$val["fileNamXML"])) {//если существует
                    $xml = simplexml_load_file($_SERVER["DOCUMENT_ROOT"].'/sitemap_new/'.$val["fileNamXML"]);//получаем xml-объект
                }elseif (file_exists($_SERVER["DOCUMENT_ROOT"].'/'.$val["fileNamXML"])) {//если существует
                    $xml = simplexml_load_file($_SERVER["DOCUMENT_ROOT"].'/'.$val["fileNamXML"]);//получаем xml-объект
                }else{//если не существует инициируем пустой
                    $xml=$xmlNew;
                }
                //читаем массив "mapLinkData" и вызываем соответсвующие функции
                foreach($val["mapLinkData"] as $ver){
                    foreach($ver as $func=>$rules){
                        $func($xml,$rules);
                        $xml=$xmlNew;
                    }
                }
//                file_put_contents($_SERVER["DOCUMENT_ROOT"]."/sitemap_new/".$val["fileNamXML"], $xmlNew->asXML());
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

                                        addLinkXML($xmlNew, (string)$xmlObj->url[$i]->children()[0], (string)$xmlObj->url[$i]->children()[1]);

//                                        $cnt=count($xmlNew);
//                                        $xmlNew->addChild('url');
//                                        $xmlNew->url[$cnt]->addChild($xmlObj->url[$i]->children()[0]->getName(), (string)$xmlObj->url[$i]->children()[0]);
//                                        $xmlNew->url[$cnt]->addChild($xmlObj->url[$i]->children()[1]->getName(), (string)$xmlObj->url[$i]->children()[1]);
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


    }

    function add($xmlObj, $arRule){
        global $xmlNew;
        if(count($xmlNew)<=0)$xmlNew=$xmlObj;
        $arAdd=array();
        foreach($arRule as $fRule=>$dRule){
            $arAdd[$fRule]=$fRule($arRule[$fRule], $arAdd);
        }
        if(count($arAdd)>0){
            $subArAdd=end($arAdd);
//            foreach($arAdd as $subArAdd){
//                foreach($subArAdd as $add){
//                      addLinkXML($xmlNew, 'http://www.argos-trade.com'.$add[0], $add[1]);
//                }
//            }
        }
        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/debugLogXML.txt", print_r($arAdd,true).PHP_EOL.count($xmlNew).PHP_EOL.print_r($xmlNew));//$xmlNew->asXML());
    }

    function repl($xmlObj, $arRule){

    }

    function mask($arMask){
        global $BID;
        $strTempl='';
        $secCode='';
        $arDebug=array();
        foreach($arMask as $k=>$strMask){
            //проверка на наличие шаблона в символах #
            if(substr_count($strMask, '#ELEMENT_CODE#')>0){
                $arFilter = Array(
                    "IBLOCK_ID"=>$BID,
                    "ACTIVE"=>"Y"
                );
                $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter);
                while($ar_fields = $res->GetNext())
                {
                    if(substr_count($strMask, '#SECTION_CODE#')>0){
                        $strTempl='#SECTION_CODE#';
                        $resSec = CIBlockSection::GetByID($ar_fields['IBLOCK_SECTION_ID']);
                        if($arResSec = $resSec->GetNext())
                            $secCode=$arResSec['CODE'];
                    }
                    $arMask['LINKS'][]= array(
                        str_replace('#ELEMENT_CODE#',$ar_fields["CODE"],  str_replace($strTempl, $secCode, $strMask)),
                        ConvertDateTime($ar_fields["TIMESTAMP_X"], "YYYY-MM-DDТHH:MI:SS+03:00")
                    );
                }
            }
            elseif(substr_count($strMask, '#SKU_ELEMENT_CODE#')>0){
                $arDebug['SKU_ELEMENT_CODE']['do']=0;
                $arFilter = Array(
                    "IBLOCK_ID"=>$BID,
                    "ACTIVE"=>"Y",
                    "SECTION_GLOBAL_ACTIVE"=>"Y"
                );
                if(substr_count($strMask, '#SECTION_ID_')>0){
                    $TMP1=explode('#SECTION_ID_', $strMask);
                    $TMP2=explode('#',$TMP1[1]);
                    $arFilter['SECTION_ID']=$TMP2[0];
                    $arFilter['INCLUDE_SUBSECTIONS']="Y";
                    $strTempl='#SECTION_ID_'.$arFilter['SECTION_ID'].'#';
                    $resSec = CIBlockSection::GetByID($arFilter['SECTION_ID']);
                    if($arResSec = $resSec->GetNext())
                        $secCode=$arResSec['CODE'];
                    $arDebug['SKU_ELEMENT_CODE']['sid']=array('id'=>$arFilter['SECTION_ID'],'code'=>$secCode, 'strTempl'=>$strTempl);
                }
                $arDebug['SKU_ELEMENT_CODE']['filter']=$arFilter;
                $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter);
                while($ar_fields = $res->GetNext())
                {
                    $arDebug['SKU_ELEMENT_CODE']['do']++;
                    if(substr_count($strMask, '#SECTION_CODE#')>0){
                        $strTempl='#SECTION_CODE#';
                        $resSec = CIBlockSection::GetByID($ar_fields['IBLOCK_SECTION_ID']);
                        if($arResSec = $resSec->GetNext())
                            $secCode=$arResSec['CODE'];
                    }
                    $resSKU = CCatalogSKU::getOffersList(
                        $ar_fields['ID'], // массив ID товаров
                        $ar_fields['IBLOCK_ID'], // указываете ID инфоблока только в том случае, когда ВЕСЬ массив товаров из одного инфоблока и он известен
                        array('>CATALOG_PRICE_1'=>0), // дополнительный фильтр предложений. по умолчанию пуст.
                        array('ID', 'IBLOCK_ID', 'CODE',"TIMESTAMP_X", 'CATALOG_GROUP_1')
                    );
                    $arDebug['SKU_ELEMENT_CODE']['sku'][$ar_fields['ID']]=$resSKU;
                    foreach($resSKU as $idSKU=>$arSKUs){
                        foreach($arSKUs as $id=>$sku){
                                $arMask['LINKS'][]= array(
                                    str_replace('#SKU_ELEMENT_CODE#',$sku["CODE"], str_replace($strTempl,$secCode, $strMask)),
                                    ConvertDateTime($sku["TIMESTAMP_X"], "YYYY-MM-DDТHH:MI:SS+03:00")
                                );
                        }

                    }

                }
            }
            elseif(substr_count($strMask, '#SKU_ELEMENT_ID#')>0){
                $arFilter = Array(
                    "IBLOCK_ID"=>$BID,
                    "ACTIVE"=>"Y",
                    "SECTION_GLOBAL_ACTIVE"=>"Y"
                );
                $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter);
                while($ar_fields = $res->GetNext())
                {
                    if(substr_count($strMask, '#SECTIONS#')>0){
                        $strTempl='#SECTIONS#';
                        $parSec=$ar_fields['IBLOCK_SECTION_ID'];
                        while($parSec >0){
                            $res_sec = CIBlockSection::GetByID($parSec);
                            if($ar_res_sec = $res_sec->GetNext())
                                $secCode= $ar_res_sec['CODE'].'/'.$secCode;
                            $parSec=$ar_res_sec['IBLOCK_SECTION_ID'];
                        }
                        $secCode=trim($secCode,'/');
                    }
                    $arMask['LINKS'][]= array(
                        str_replace('#SKU_ELEMENT_ID#',$ar_fields["ID"], str_replace($strTempl,$secCode, $strMask)),
                        ConvertDateTime($ar_fields["TIMESTAMP_X"], "YYYY-MM-DDТHH:MI:SS+03:00")
                    );
                    $secCode='';
                }
            }
            elseif(substr_count($strMask, '#SECTION_CODE#')>0){//section_code для случая, когда ссылки без элементов
                $arFilter = Array(
                    "IBLOCK_ID"=>$BID,
                    "ACTIVE"=>"Y"
                );
                $res = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter);
                while($ar_fields = $res->GetNext())
                {
                    $arMask['LINKS'][]= array(
                        str_replace('#SECTION_CODE#',$ar_fields["CODE"], $strMask),
                        ConvertDateTime($ar_fields["TIMESTAMP_X"], "YYYY-MM-DDТHH:MI:SS+03:00")
                    );
                }
            }
            elseif(substr_count($strMask, '#SECTION_ID_')>0){
                $TMP1=explode('#SECTION_ID_', $strMask);
                $TMP2=explode('#',$TMP1[1]);
                $arFilter['SECTION_ID']=$TMP2[0];
                $strTempl='#SECTION_ID_'.$arFilter['SECTION_ID'].'#';
                $resSec = CIBlockSection::GetByID($arFilter['SECTION_ID']);
                if($arResSec = $resSec->GetNext())
                    $secCode=$arResSec['CODE'];
                    if($arResSec['ACTIVE']=="Y"){
                        $arMask['LINKS'][]= array(
                            str_replace($strTempl,$secCode, $strMask),
                            ConvertDateTime($arResSec["TIMESTAMP_X"], "YYYY-MM-DDТHH:MI:SS+03:00")
                        );
                    }
            }
            elseif(strlen($strMask)>0){
                $res_ib = CIBlock::GetByID($BID);
                if($ar_res_ib = $res_ib->GetNext()){
                    $arMask['LINKS'][]= array(
                        $strMask,
                        ConvertDateTime($ar_res_ib["TIMESTAMP_X"], "YYYY-MM-DDТHH:MI:SS+03:00")
                    );
                }
            }
        }
        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/debugMask.txt", print_r($arMask,true).PHP_EOL.print_r($arDebug, true));
        return $arMask['LINKS'];
    }
    function id($arId, $arLink){
        $arLinkTmp=$arLink;
        $rData=array();
        $arNew=array();
        $l='0';
        foreach($arLink as $f=>$fLink){
            foreach($arId as $key=>$arData){
                $b=explode('!',$key);
                $c=count($b);
                $arTmp=$b[$c-1]($arData);//$b[$c-1] - функция

                if($c==2){
                    $l='NOT';
                    foreach($fLink as $k=> $url){
                        $fAdd=1;
                        foreach($arTmp as $cmp){
                            if(substr_count($url[0],$cmp)!=0)$fUnset=0;
                        }
                        if($fAdd==1)$arNew[]=$fLink[$k];//unset($fLink[$k]);
                    }
                }else{
                    foreach($fLink as $k=> $url){
                        $fAdd=0;
                        foreach($arTmp as $cmp){
                            if(substr_count($url[0],$cmp)!=0)$fAdd=1;
                        }
                        if($fAdd==1)$arNew[]=$fLink[$k];
                    }
                }

//            echo $fn=$b[$c-1];
//            $rData[$b[$c-1]]=array(
//               $l =>
//            );
            }
            $arLink=$arNew;
        }

        file_put_contents($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/debugLogFunc.txt", print_r($arId,true).PHP_EOL.print_r($arTmp,true).PHP_EOL.print_r($arLink, true).PHP_EOL.print_r($arNew, true));
        return $arLink;
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

function addLinkXML($xObj, $loc, $lastmod){
    $cnt=count($xObj);
    $fDuble=0;
    for($i=0;$i<$cnt;$i++){
        if(strcmp($xObj->url[$i]->loc, $loc)==0)$fDuble=1;
    }
    if($fDuble!=1){
//        $xObj->addChild('url');
//        $xObj->url[$cnt]->addChild('loc', $loc);
//        $xObj->url[$cnt]->addChild('lastmod', $lastmod);
    }

    return $xObj;
}