<?php
//массив настроек корректора структуры sitemap.xml
$tuneData=array(
    "FILE"=>array(),//этот массив должен оисывать правила корректировки ссылок в sitemap_files.xml
    "IBLOCK"=>array(//этот массив должен оисывать правила корректировки ссылок в sitemap_iblock_N.xml
        "2"=>array(//этот массив должен оисывать правила корректировки ссылок в sitemap_iblock_2.xml
            //в случае, если данные одного инфоблока используются в разных публичных разделах
            //и требуют разлмчных правил формирования ссылок формируем необходимое количество
            //массивов с правилами для каждого раздела
            "fileNamXML"=>"sitemap_iblock_2_2.xml", //имя файла, который будет перезаписан по новым правилам
            "mapLinkData"=>array(//массив описывает, как формировать новый файл
//                "0"=>array(
//                    "del"=>array(//из старого содержимого удаляем
//                        "id"=>array(//все ссылки, сформированные из sections или elements с id
//                            "!sid"=>array(//НЕ на id sections
//                                25, 26, 16, 30, 321
//                            )
//                        )
//                    ),
//                    "add"=>array(
//                        "mask"=>array(
//                            "/catalog/",
//                            "/catalog/#SECTION_ID_25#/",
//                            "/catalog/#SECTION_ID_26#/",
//                            "/catalog/#SECTION_ID_16#/",
//                            "/catalog/#SECTION_ID_30#/",
//                            "/catalog/#SECTION_ID_321#/",
//                            "/catalog/#SECTION_ID_30#/#SKU_ELEMENT_CODE#/",
//                            "/catalog/#SECTION_ID_321#/#SKU_ELEMENT_CODE#/",
//                            "/production/catalog_online/",
//                            "/production/catalog_online/#SECTION_ID_17#/",
//                            "/production/catalog_online/#SECTION_ID_30#/",
//                            "/production/catalog_online/#SECTION_ID_321#/"
//                        )
//                    )
//                ),
                "1"=>array(
                    "add"=>array(
                        "mask"=>array(
                            "/production/catalog_online/#SECTIONS#/?view=new&offers_id=#SKU_ELEMENT_ID#"
                        ),
                        "id"=>array(//все ссылки, сформированные из sections или elements с id
                            "sid"=>array(// id sections
                                30, 321
                            )
                        )
                    )
                )
            )
        )
//    ,
//        "44"=>array(
//            "fileNamXML"=>"sitemap_iblock_44.xml", //имя файла, который будет перезаписан по новым правилам
//            "mapLinkData"=>array(
//                "0"=>array(
//                    "add"=>array(
//                        "mask"=>array("/catalog/draivery/#ELEMENT_CODE#/")
//                    )
//                )
//            )
//        )
    )
);
