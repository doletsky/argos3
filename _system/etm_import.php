<?php
error_reporting( E_ERROR );
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER;
if (!$USER->IsAdmin()) {
	die();
}
if (CModule::IncludeModule("iblock") && CModule::IncludeModule("sale") && CModule::IncludeModule("catalog")) {
	$el = new CIBlockElement;
}

function mTrimm ($value){
	$value = str_replace('""', '"', $value);
	return trim($value, '"');
}
$bOn = false;


$process = isset($_REQUEST['process']) ? 1 : 0 ;
$load = isset($_REQUEST['load']) ? 1 : 0 ;
$filename = isset($_REQUEST['filename']) ? mysql_escape_string($_REQUEST['filename']) : '' ;

$IBLOCK_ID = 31;

$uploads_dir = $_SERVER["DOCUMENT_ROOT"].'/upload/price';
$file = $uploads_dir .'/'. $filename;

//Удалим все старые файлы
$files = array_diff(scandir($uploads_dir), array('.','..', $filename));
foreach ($files as $_file) {
	unlink("$uploads_dir/$_file");
}
unset($files, $_file);

$row = 0;
$dataArr = Array();
$bxXmlArr = array();
$bxXmlArrParent = array();

?>
<style>
	p, table, td {
    	font-size: 13px;
	}
	
   table {
    /*border: 1px solid #399 */
    border-spacing: 0 0 ; /* Расстояние между границ */
   }
   td {
    background: #ccd7db; /* Цвет фона */
    border-right: 1px solid #333; /* Граница вокруг ячеек */
    padding: 2px; /* Поля в ячейках */ 
   }
  
</style>
<h2>Пример таблицы</h2>
<p>КОД товара обязателен, по нему определяется уникальность товара</p>
<table>
<tr><td>ID-категории (если есть)</td><td>ID-родителя</td><td>ID-торг.предложения (если нет категории)</td><td>КОД</td><td>Наименование товара на сайте</td><td>Техническое название для счета</td><td>Остаток</td><td>Цена 0-10:1500.10#11-100:1480.32#101-300#1450</td><td>Кол-во товаров в коробке</td><td>Группа протоколов</td></tr>
</table>
<h2>Загрузка файла</h2>	
<form id="priceloader" action="" method="post" enctype="multipart/form-data">
	<table class="data">
		<tbody>
			<tr>
				<td class="sel">csv файл</td>
				<td><input id="file" type="file" name="file"></td>
				<td><button type="submit">Загрузить новый файл</button></td>
			</tr>
		</tbody>
	</table>

<?
if(!$process) {
	if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
		$tmp_name = $_FILES["file"]["tmp_name"];
		$name = md5($_FILES["file"]["name"] . time()) . '.csv';
		
		if (move_uploaded_file($tmp_name, $uploads_dir . '/' . $name)){
			echo '<h3>Файл загружен</h3>';
			echo 'Файл: '.$_FILES["file"]["name"].'<br />';
			echo '<input type="hidden" name="process">';
			echo '<input type="hidden" name="filename" value="'.$name.'">';
			echo '<input id="process" type="submit" value="Предпросмотр">';
		}
	}
}
?>
</form>
<?

if ($load == 0 && $process){
	echo '<h3>Загрузка в базу сайта</h3><form action="" method="post" enctype="multipart/form-data">';

	echo '<input type="hidden" name="load">';
	echo '<input type="hidden" name="process">';
	echo '<input type="hidden" name="filename" value="'.$filename.'">';
	echo '<input type="submit" value="Все ОК, загрузить в базу сайта">';
	echo '</form>';
}

if($load) {
	$bOn = true;
}

if($process || $load)
{
	
	$el = new CIBlockElement;
	$bs = new CIBlockSection;
	
	
	$params = Array(
			"max_len" => "200", // обрезает символьный код до 100 символов
			"change_case" => "L", // буквы преобразуются к нижнему регистру
			"replace_space" => "-", // меняем пробелы на нижнее подчеркивание
			"replace_other" => "-", // меняем левые символы на нижнее подчеркивание
			"delete_repeat_replace" => "true", // удаляем повторяющиеся нижние подчеркивания
			"use_google" => "false", // отключаем использование google
	);
	
	//$filename = 'stock.csv';
	$csv = file_get_contents($file);
	$csv = iconv('CP1251', 'UTF-8', $csv);

	
	$data_str = explode("\n", $csv);

	
	foreach ($data_str as $str)
	{
		$row++;
	
		//if ($row == 1) continue;
		if (trim($str) == '') {
			continue;
		}
	
	
		$data = explode(';', $str);
		$data = array_map("mTrimm", $data);
		//print_r($data);
		
		/*$arItemSelect = Array("ID", "NAME", "IBLOCK_ID");
		$arItemFilter = Array("IBLOCK_ID"=>5, "?NAME"=>$data[1]);
			
		$rsItem = CIBlockElement::GetList(Array(), $arItemFilter, false, false, $arItemSelect);
		if ($arItem = $rsItem->GetNext()) {
			continue;
		}
		else {
			$arFilter = Array('IBLOCK_ID'=>5, '?NAME'=>$data[0]);
			$db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true);

			if($ar_result = $db_list->GetNext())  {
				$arLoadProductArray = Array(
						"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
						"IBLOCK_SECTION_ID" => $ar_result['ID'],          // элемент лежит в корне раздела
						"IBLOCK_ID"      => 5,
						"NAME"           => $data[1],
						"CODE"		   => CUtil::translit((string) ($data[1]), "ru", $params),
						"ACTIVE"         => "Y",            // активен
				);
				$el->Add($arLoadProductArray);
				var_dump($arLoadProductArray);
			}
			else {
				$arFields = Array(
						"ACTIVE" => 'Y',
						"IBLOCK_SECTION_ID" => 145,
						"IBLOCK_ID" => 5,
						"NAME" => $data[0],
						"CODE"		   => CUtil::translit((string) ($data[0]), "ru", $params)
				);
				
				$ID = $bs->Add($arFields);
				var_dump($arFields);
				
				$arLoadProductArray = Array(
						"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
						"IBLOCK_SECTION_ID" => $ID,          // элемент лежит в корне раздела
						"IBLOCK_ID"      => 5,
						"NAME"           => $data[1],
						"CODE"		   => CUtil::translit((string) ($data[1]), "ru", $params),
						"ACTIVE"         => "Y",            // активен
				);
				
				$el->Add($arLoadProductArray);
				var_dump($arLoadProductArray);
			}

		}
		continue;
		die();*/
		
		$arItemSelect = Array("ID", "NAME", "IBLOCK_ID");
		$arItemFilter = Array("IBLOCK_ID"=>5, "?NAME"=>$data[1]);
			
		$rsItem = CIBlockElement::GetList(Array(), $arItemFilter, false, false, $arItemSelect);
		if ($arItem = $rsItem->GetNext()) {
			var_dump($arItem);
			$ELEMENT_ID = $arItem["ID"];
			//echo "Найдено торговое предложение [{$ELEMENT_ID}] {$data[3]} {$data[4]}<br />";
						
			$PROP = array();
			$PROP['CML2_LINK'] = $ELEMENT_ID;
			$PROP['MAIN_PARTNERSHIP_ID'] = 2176;
			$PROP['AFFILIATE'] = 92;
			$PROP['SALE_PROD'] = array(17, 321);
			$PROP['SALE_TYPE_1'] = 96;
			$PROP['SALE_TYPE_2'] = 97;
			$PROP['LINK_MAIL'] = $data[4];
			$PROP['LINK_SITE'] = 'www.etm.ru';
			
			$arLoadProductArray = Array(
					"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
					"IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
					"IBLOCK_ID"      => 31,
					"PROPERTY_VALUES"=> $PROP,
					"NAME"           => "ЭТМ",
					"CODE"		   => CUtil::translit((string) ('ЭТМ '. $data[1] .' '. $data[2]), "ru", $params),
					"ACTIVE"         => "Y",            // активен
					"PREVIEW_TEXT"   => "",
					"DETAIL_TEXT"    => $data[2] . '<br />' . $data[3],
			);
			
			if($PRODUCT_ID = $el->Add($arLoadProductArray)) {
				echo "New ID: ".$PRODUCT_ID;
				
				$PROP = array();
				$PROP['EMAIL'] = $data[4];
				$PROP['POSITION'] = $data[5];
				$PROP['WORK_TIMES'] = $data[7];
				$PROP['ID_COMPANY'] = $PRODUCT_ID;
				
				$arLoadProductArray = Array(
						"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
						"IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
						"IBLOCK_ID"      => 43,
						"PROPERTY_VALUES"=> $PROP,
						"NAME"           => $data[6],
						"CODE"		   => CUtil::translit((string) ('ЭТМ '. $data[6] . ' '. $data[5] . ' ' . $data[2]), "ru", $params),

						"ACTIVE"         => "Y",            // активен
						"PREVIEW_TEXT"   => "",
						"DETAIL_TEXT"    => $data[2] . '<br />' . $data[7],
				);

					$el->Add($arLoadProductArray);
					echo "Error: ".$el->LAST_ERROR;
			
			}
			
			//die();
			
		}
		else {
			var_dump($arItemFilter);
		}
		//var_dump($arItemFilter);
		//die();
		
	}//end while
	
	if($bOn) {
		unlink($file);
	}
	echo '<h2>Результат загрузки</h2><table border=1>';
	echo '<tr><td>ID-категории (если есть)</td><td>ID-родителя</td><td>ID-торг.предложения (если нет категории)</td><td>КОД</td><td>Наименование товара на сайте</td><td>Техническое название для счета</td><td>Остаток</td><td>Цена 0-10:1500.10#11-100:1480.32#101-300#1450</td><td>Кол-во товаров в коробке</td><td>Группа протоколов</td><td>Валюта</td><td>Статус</td></tr>';
	foreach ($tmpItems as $itemID=>$value){
	echo '<tr>';
	echo "<td><strike>{$tmpItems[$itemID]['CATEGORY']['OLD']}</strike><br>{$tmpItems[$itemID]['CATEGORY']['NEW']}</td>";
	echo "<td><strike>{$tmpItems[$itemID]['MODEL']['OLD']}</strike><br>{$tmpItems[$itemID]['MODEL']['NEW']}</td>
	<td>{$itemID}</td>
	<td><strike>{$tmpItems[$itemID]['XML_ID']['OLD']}</strike><br/>{$tmpItems[$itemID]['XML_ID']['NEW']}</td>
	<td><strike>{$tmpItems[$itemID]['NAME']['OLD']}</strike><br/>{$tmpItems[$itemID]['NAME']['NEW']}</td>
	<td><strike>{$tmpItems[$itemID]['TECH_NAME']['OLD']}</strike><br/>{$tmpItems[$itemID]['TECH_NAME']['NEW']}</td>
	<td><strike>{$tmpItems[$itemID]['QUANTITY']['OLD']}</strike><br/>{$tmpItems[$itemID]['QUANTITY']['NEW']}</td>
	<td><strike>{$tmpItems[$itemID]['PRICE']['OLD']}</strike><br/>{$tmpItems[$itemID]['PRICE']['NEW']}</td>
	<td><strike>{$tmpItems[$itemID]['DEVIANT_PACKING']['OLD']}</strike><br/>{$tmpItems[$itemID]['DEVIANT_PACKING']['NEW']}</td>
	<td><strike>{$tmpItems[$itemID]['PROTOCOLS_GROUP']['OLD']}</strike><br/>{$tmpItems[$itemID]['PROTOCOLS_GROUP']['NEW']}</td>
	<td><strike>{$tmpItems[$itemID]['PRICE_CURRENCY']['OLD']}</strike><br/>{$tmpItems[$itemID]['PRICE_CURRENCY']['NEW']}</td>
	<td>{$tmpItems[$itemID]['STATUS']}</td>
	";
	echo '</tr>';	
	}
	echo '</table>';

}//end if load || process
?>