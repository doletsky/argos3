<?php
//массив настроек корректора структуры sitemap.xml
$tuneData=array(
    "FILE"=>array(),//этот массив должен оисывать правила корректировки ссылок в sitemap_files.xml
    "IBLOCK"=>array(//этот массив должен оисывать правила корректировки ссылок в sitemap_iblock_N.xml
        "2"=>array(//этот массив должен оисывать правила корректировки ссылок в sitemap_iblock_2.xml
            //в случае, если данные одного инфоблока используются в разных публичных разделах
            //и требуют разлмчных правил формирования ссылок формируем необходимое количество
            //массивов с правилами для каждого раздела
            "fileNamXML"=>"sitemap_iblock_2.xml", //имя файла, который будет перезаписан по новым правилам
            "mapLinkData"=>array(//массив описывает, как формировать новый файл
                "0"=>array(
                    "del"=>array(//из старого содержимого удаляем
                        "id"=>array(//все ссылки, сформированные из sections или elements с id
                            "!sid"=>array(//НЕ на id sections
                                25, 26, 16, 30, 321
                            )
                        )
                    )
                )

            )


        )
    )
);

//$xml = simplexml_load_file($_SERVER["DOCUMENT_ROOT"].'/sitemap.xml');
////echo $xml->sitemap[1]->loc.PHP_EOL;
//echo $xml->sitemap[1]->loc->asXML();
////var_dump($xml);
//file_put_contents($_SERVER["DOCUMENT_ROOT"].'/sitemap_test.xml',$xml->sitemap[1]->loc->asXML());