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

$IBLOCK_ID = 4;

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
	//$filename = 'stock.csv';
	$csv = file_get_contents($file);
	$csv = iconv('CP1251', 'UTF-8', $csv);

	
	$data_str = explode("\n", $csv);

	
	foreach ($data_str as $str)
	{
		$row++;
	
		if ($row == 1) continue;
		if (trim($str) == '') {
			continue;
		}
	
	
		$data = explode(';', $str);
		$data = array_map("mTrimm", $data);
		
		if(empty($data[3])) {
			continue;
		}
	
	
		$data[0] = trim($data[0]);
		$data[1] = trim($data[1]);
		$data[2] = trim($data[2]);
		$prices = array();
		
		$data[7] = str_replace(',', '.', $data[7]);
		
		$tmp = explode('#', $data[7]);
		foreach ($tmp as $_tmp) {
			$__tmp = explode(':', $_tmp);
			$prices[$__tmp[0]] =  round(trim($__tmp[1]), 2);
		}
		
		$bPrice = 0;
		
		foreach ($prices as $value) {
			$value = round($value, 2);
			if($value > 0) {
				$bPrice = 1;
			}
		}
		
		if($bPrice == 1) {
			$data[7] = $prices;
		}
	
		$dataArr[$data[3]] = $data;
				
		if(!empty($data[1]) && !empty($data[2])) {
			$bxXmlArr[$data[2]] = $data[3];
		}
		elseif(!empty($data[0])) {
			$bxXmlArr[$data[1]] = $data[3];
		}

		
		if(!empty($data[0]) && empty($data[1]) && empty($data[2]) && !empty($data[3]) && !empty($data[3])) {
			//var_dump('product', $data);
			$arItemSelect = Array("ID", "XML_ID", "NAME", "IBLOCK_ID");
			$arItemFilter = Array("XML_ID"=>$data[3]);
		
			$rsItem = CIBlockElement::GetList(Array(), $arItemFilter, false, false, $arItemSelect);
			if ($arItem = $rsItem->GetNext()) {
				$ELEMENT_ID = $arItem["ID"];
				//echo "Найден товар [{$ELEMENT_ID}] {$data[3]} {$data[4]}<br />";
			}
			else {
				echo "Добавлен новый товар {$data[3]} {$data[4]}<br />";
				$arFields = Array(
						"NAME" => $data[4],
						"ACTIVE" => 'N',
						"XML_ID" => $data[3],
						//"CODE" => $_node['CODE'],
						"IBLOCK_ID" => 2
				);
				
				$ELEMENT_ID = $el->Add($arFields);
				CCatalogProduct::Add(array("ID" => $ELEMENT_ID));
			}
			
			$bxXmlArr[$ELEMENT_ID] = $data[3];
		}
		
		if(empty($data[0]) && !empty($data[1]) && empty($data[2]) && !empty($data[3]) && !empty($data[3])) {
			//var_dump('offer', $data);
			$arItemSelect = Array("ID", "XML_ID", "NAME", "IBLOCK_ID");
			$arItemFilter = Array("XML_ID"=>$data[3]);
			
			$rsItem = CIBlockElement::GetList(Array(), $arItemFilter, false, false, $arItemSelect);
			if ($arItem = $rsItem->GetNext()) {
				$ELEMENT_ID = $arItem["ID"];
				echo "Найдено торговое предложение [{$ELEMENT_ID}] {$data[3]} {$data[4]}<br />";
			}
			else {
				echo "Добавлен новое торговое предложение {$data[3]} {$data[4]}<br />";
					
				$arFields = Array(
						"NAME" => $data[4],
						"ACTIVE" => 'N',
						"XML_ID" => $data[3],
						//"CODE" => $_node['CODE'],
						"IBLOCK_ID" => 4
				);
	
				$ELEMENT_ID = $el->Add($arFields);
				CCatalogProduct::Add(array("ID" => $ELEMENT_ID));
			}
			
			$bxXmlArr[$ELEMENT_ID] = $data[3];

		}
	}
	
	//print_r($bxXmlArr);
	//print_r($dataArr);
	
	
	
	//$bxXmlArr = array(2517=>1231);
	//Массив товаров
	$tmpItems = array();
	$arItemSelect = Array("ID", "XML_ID", "NAME", "IBLOCK_SECTION_ID", "CATALOG_GROUP_1", "CATALOG_QUANTITY", "PROPERTY_MODEL", "PROPERTY_TECH_NAME", "PROPERTY_DEVIANT_PACKING", "PROPERTY_PROTOCOLS_GROUP");
	$arItemFilter = Array("ID"=>array_keys($bxXmlArr));
	if(count($arItemFilter['ID']) < 1) {
		die('Файл не корректный!');
	}
	
	$rsItem = CIBlockElement::GetList(Array(), $arItemFilter, false, false, $arItemSelect);
	while ($arItem = $rsItem->GetNext())
	{
		$itemID = intVal($arItem['ID']);
		$xmlID = $bxXmlArr[$itemID];
		$price = $dataArr[$xmlID][7];
		
		//print_r($arItem);
	
		
		$PRPS = array();
		
		$PRPS["MODEL"] 			 = $dataArr[$xmlID][1];
		$PRPS["TECH_NAME"] 		 = $dataArr[$xmlID][5];
		$PRPS["DEVIANT_PACKING"] = $dataArr[$xmlID][8];
		//$PRPS["PROTOCOLS_GROUP"] = $dataArr[$xmlID][9];
		$PRPS["PROTOCOLS_GROUP"] = '';
		
		$tmpItems[$itemID]['MODEL']['OLD'] = $arItem['PROPERTY_MODEL_VALUE'];
		$tmpItems[$itemID]['MODEL']['NEW'] = $PRPS["MODEL"];
		
		$tmpItems[$itemID]['TECH_NAME']['OLD'] = $arItem['PROPERTY_TECH_NAME_VALUE'];
		$tmpItems[$itemID]['TECH_NAME']['NEW'] = $PRPS["TECH_NAME"];
		
		$tmpItems[$itemID]['DEVIANT_PACKING']['OLD'] = $arItem['PROPERTY_DEVIANT_PACKING_VALUE'];
		$tmpItems[$itemID]['DEVIANT_PACKING']['NEW'] = $PRPS["DEVIANT_PACKING"];
		
		//$tmpItems[$itemID]['PROTOCOLS_GROUP']['OLD'] = $arItem['PROPERTY_PROTOCOLS_GROUP_VALUE'];
		//$tmpItems[$itemID]['PROTOCOLS_GROUP']['NEW'] = $PRPS["PROTOCOLS_GROUP"];
		
		//print_r($arItem);
		//print_r($dataArr[$xmlID]);
		//die();
	
	
	
			$PRICE_TYPE_ID = 1;
			$PRICE_TYPE_CATALOG = 'CATALOG_PRICE_' . $PRICE_TYPE_ID;
	

			$arrPrice = Array(
					"PRODUCT_ID" => $itemID,
					"CATALOG_GROUP_ID" => $PRICE_TYPE_ID,
					"CURRENCY" => trim($dataArr[$xmlID][9])
			);
			
			$tmpItems[$itemID]['PRICE']['OLD'] = $arItem[$PRICE_TYPE_CATALOG] . '(отображается последняя цена)';
			$tmpItems[$itemID]['PRICE']['NEW'] = '';
			$tmpItems[$itemID]['PRICE_CURRENCY']['OLD'] = $arItem['CATALOG_CURRENCY_1'];
			$tmpItems[$itemID]['PRICE_CURRENCY']['NEW'] = $dataArr[$xmlID][9];
			
			$arrPrices = array();
			if(is_array($price)) {
				foreach ($price as $d=>$val) {
					$arrPrice = Array(
							"PRODUCT_ID" => $itemID,
							"CATALOG_GROUP_ID" => $PRICE_TYPE_ID,
							"CURRENCY" => trim($dataArr[$xmlID][9])
					);
					
					$tmpItems[$itemID]['PRICE']['NEW'] .= $d . ': ';
				
					$d = explode('-', $d);
					
					$arrPrice["PRICE"] = $val;
					$arrPrice["QUANTITY_FROM"] = $d[0];
					$arrPrice["QUANTITY_TO"] = is_numeric($d[1]) ? $d[1] : 99999;
					
					if(empty($arrPrice["QUANTITY_TO"]) || $arrPrice["QUANTITY_TO"] <= 0 || $arrPrice["QUANTITY_TO"] >= 99999) {
						unset($arrPrice["QUANTITY_TO"]);
					}
					
					$arrPrices[] = $arrPrice;
					
					$tmpItems[$itemID]['PRICE']['NEW'] .= $val .'; ';
										
				}
			}
			else {
				$arrPrice["PRICE"] = $price;
				$arrPrices[] = $arrPrice;
				$tmpItems[$itemID]['PRICE']['NEW'] .= $price;
	
			}
			
			
			$arFields = array(
					"NAME"=>$dataArr[$xmlID][4],
					"XML_ID"=>$dataArr[$xmlID][3],
			);

			if(!empty($dataArr[$xmlID][0])) {
				$tmpItems[$itemID]['CATEGORY']['OLD'] = $arItem['IBLOCK_SECTION_ID'];
				$tmpItems[$itemID]['CATEGORY']['NEW'] = $dataArr[$xmlID][0];
				$arFields['IBLOCK_SECTION_ID'] = $dataArr[$xmlID][0];
				//print_r($arItem);
				//die();
			}
			else {
				$tmpItems[$itemID]['CATEGORY']['OLD'] = '-';
				$tmpItems[$itemID]['CATEGORY']['NEW'] = '-';
			}
			
			
			$tmpItems[$itemID]['NAME']['OLD'] = $arItem['NAME'];
			$tmpItems[$itemID]['NAME']['NEW'] = $arFields['NAME'];
			
			$tmpItems[$itemID]['XML_ID']['OLD'] = $arItem['XML_ID'];
			$tmpItems[$itemID]['XML_ID']['NEW'] = $arFields['XML_ID'];
			
			$arQuantity = Array(
					"ID"		 => $itemID,
					"QUANTITY" => intval($dataArr[$xmlID][6])
			);

			$tmpItems[$itemID]['QUANTITY']['OLD'] = $arItem['CATALOG_QUANTITY'];
			$tmpItems[$itemID]['QUANTITY']['NEW'] = $arQuantity['QUANTITY'];
			
			$tmpItems[$itemID]['STATUS'] = 'Не загружен';

			//print_r($tmpItems);
			//print_r($arrPrice);
			
			//die();
			
	
			if($bOn) {
				
				$tmpItems[$itemID]['STATUS'] = '';
				
				foreach ($PRPS as $PROPERTY_CODE=>$PROPERTY_VALUE) {
					CIBlockElement::SetPropertyValuesEx($itemID, false, array($PROPERTY_CODE => $PROPERTY_VALUE));
					$tmpItems[$itemID]['STATUS'] .= "{$PROPERTY_CODE} set<br>";
				}
				
				$DB->Query('delete from b_catalog_price where PRODUCT_ID = '.$itemID, true);
				$DB->Update('b_catalog_price', array('PRICE'=>0), "WHERE PRODUCT_ID IN ({$itemID})");
				$DB->Update('b_catalog_product', array('QUANTITY'=>0), "WHERE ID IN ({$itemID})");
	
				if(empty($arFields['NAME'])) {
					unset($arFields['NAME']);
				}
				
				$res = $el->Update($arItem["ID"], $arFields);
	
				//Установка кол-ва
				$cProduct = new CCatalogProduct;
	
				$resProduct = $cProduct->Add($arQuantity);
				if(!$resProduct){
					$tmpItems[$itemID]['STATUS'] = $resProduct->LAST_ERROR;
				}
				else {
					$tmpItems[$itemID]['STATUS'] .= 'Количество установлено<br>';
				}
				
				
				$resPrice = CPrice::GetList(
						array(),
						array(
								"PRODUCT_ID" => $itemID,
								"CATALOG_GROUP_ID" => $PRICE_TYPE_ID
						)
				);
					
				if ($arr = $resPrice->Fetch())
				{
					$tmpItems[$itemID]['STATUS'] .= 'price update<br>';
					foreach ($arrPrices as $arrPrice) {
						$r = CPrice::Update($arr['ID'], $arrPrice);
						//var_dump($r);
					}
				}
				elseif( count($arrPrices) > 0 )
				{	
					$tmpItems[$itemID]['STATUS'] .= 'price add';
					//var_dump($arrPrice);
					foreach ($arrPrices as $arrPrice) {
						$r = CPrice::Add($arrPrice);
						$tmpItems[$itemID]['STATUS'] .= (bool) $r;
						//var_dump($r);
					}
					$tmpItems[$itemID]['STATUS'] .= '<br />';
				}
				else {
					$tmpItems[$itemID]['STATUS'] .= 'no add 0<br>';
					//var_dump('no add 0');
				}

				
				
			}
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