<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
ini_set('mbstring.func_overload', 0);
require_once 'Classes/PHPExcel.php';
require_once('Classes/PHPExcel/Writer/Excel5.php');

if(isset($_POST)){
	
$ORDER_ID = $_POST['order_id'];
$PRODUCTS = $_POST['products'];
$days = $_POST['days'];
$order = $_POST['order'];
$lang = $_POST['lang'];

if(CModule::IncludeModule("sale")) {
	$db_vals = CSaleOrder::GetByID(
        $ORDER_ID
    );	
		
		$CURRENCY = $db_vals['CURRENCY'];
		
	$arPaySys = CSalePaySystem::GetByID($db_vals['PAY_SYSTEM_ID'], $db_vals['PERSON_TYPE_ID']);
		$PSinfo = unserialize($arPaySys["PSA_PARAMS"]);
		?><pre><?//print_r($PSinfo);?></pre><?
		
		//Функция для обработки свойств платёжной системы
		if(!function_exists('GetParam')){
			function GetParam($param, $PSinfo){
				if($PSinfo[$param]['VALUE'] !== ''){
					return $PSinfo[$param]['VALUE'];
				}else{
					return false;
				}
			}
		}
		
		//свойства заказчика
		$db_vals = CSaleOrderPropsValue::GetList(
            array("SORT" => "ASC"),
            array("ORDER_ID" => $ORDER_ID)
        );
		while($arVals = $db_vals->Fetch())
		{			
			$arClientProps[$arVals['CODE']]=$arVals['VALUE'];
		}
		?><pre><?//print_r($arClientProps);?></pre><?
		
		//Функция для обработки свойств заказа
		if(!function_exists('GetClientParam')){
			function GetClientParam($param, $arClientProps){
				if($arClientProps[$param] !== ''){
					return $arClientProps[$param];
				}else{
					return false;
				}
			}
		}
		
	$objPHPExcel = new PHPEXcel();

	$objPHPExcel->setActiveSheetIndex(0);

	//$objPHPExcel->createSheet();

	$active_sheet = $objPHPExcel->getActiveSheet();

	$active_sheet->getPageSetup()
				->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
				
	$active_sheet->getPageSetup()
				->SetPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
				
				
	$active_sheet->getPageMargins()->setTop(1);
	$active_sheet->getPageMargins()->setRight(0.75);
	$active_sheet->getPageMargins()->setLeft(0.75);
	$active_sheet->getPageMargins()->setBottom(1);

	$active_sheet->setTitle("Счёт_".$ORDER_ID."_".$days);	

	$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);	


	//$active_sheet->getColumnDimension('A')->setWidth(7);
	$active_sheet->getColumnDimension('A')->setWidth(30);
	$active_sheet->getColumnDimension('B')->setWidth(50);
	$active_sheet->getColumnDimension('C')->setWidth(15);
	$active_sheet->getColumnDimension('D')->setWidth(15);
	$active_sheet->getColumnDimension('E')->setWidth(7);
	$active_sheet->getColumnDimension('F')->setWidth(15);
/*
	$active_sheet->mergeCells('A1:G1');
	$active_sheet->getRowDimension('1')->setRowHeight(20);
	$active_sheet->setCellValue('A1','Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате обязательно, в противном случае не гарантируется наличие товара на складе.');

	$active_sheet->mergeCells('A3:G3');
	$active_sheet->getRowDimension('3')->setRowHeight(40);
	$active_sheet->setCellValue('A3','ПОСТАВЩИК:  '.GetParam("SELLER_NAME", $PSinfo).'
	  Юридический адрес: '.GetParam("SELLER_ADDRESS", $PSinfo).'
	  Почтовый адрес: '.GetParam("SELLER_ADDRESS", $PSinfo));

	  
	if (GetParam("SELLER_BANK", $PSinfo))
	{
		$sellerBank = sprintf(
			"%s %s",
			GetParam("SELLER_BANK", $PSinfo),
			GetParam("SELLER_BCITY", $PSinfo)
		);
		$sellerRs = GetParam("SELLER_RS", $PSinfo);
	}
	else
	{
	*/
		//$rsPattern = '/\s*\d{10,100}\s*/';
/*
		$sellerBank = trim(preg_replace($rsPattern, ' ', GetParam("SELLER_RS", $PSinfo)));

		preg_match($rsPattern, GetParam("SELLER_RS", $PSinfo), $matches);
		$sellerRs = trim($matches[0]);
	}

		
	$active_sheet->mergeCells('A4:G4');
	$active_sheet->getRowDimension('4')->setRowHeight(40);
	$active_sheet->setCellValue('A4','РЕКВИЗИТЫ ПОСТАВЩИКА:  ИНН '.GetParam("SELLER_INN", $PSinfo).' КПП '.GetParam("SELLER_KPP", $PSinfo).', р/с '.$sellerRs.' '.$sellerBank.', БИК '.GetParam("SELLER_BIK", $PSinfo).', корр.сч. '.GetParam("SELLER_KS", $PSinfo));
	*/
	
	$months = array('Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря');
	$format_date = date('j ').$months[date('n')-1].date(' Y');
/*
	if($order){
		$billNo_tmp = sprintf(
			"СЧЕТ № %s от %s",			
			$ORDER_ID,			
			$format_date
		);
	}else{
		$billNo_tmp = sprintf(
			"СЧЕТ от %s",		
			$format_date
		);
	}


	$active_sheet->mergeCells('A10:G10');
	$active_sheet->setCellValue('A10',$billNo_tmp);
	*/

				
	/*
	$active_sheet->mergeCells('A9:G9');
	$active_sheet->getRowDimension('9')->setRowHeight(30);
	$active_sheet->setCellValue('A9','ПЛАТЕЛЬЩИК:  '.GetClientParam("COMPANY", $arClientProps).', ИНН '.GetClientParam("INN", $arClientProps).' '.GetClientParam("COMPANY_ADR", $arClientProps).' Телефоны: '.GetClientParam("PHONE", $arClientProps));
	
	if($order){
		$active_sheet->mergeCells('A10:G10');
		$active_sheet->setCellValue('A10','Примечание');
		
		$active_sheet->mergeCells('A12:G12');
		$active_sheet->setCellValue('A12',GetParam("COMMENT1", $PSinfo));
	}
	*/
	//$active_sheet->getRowDimension('2')->setRowHeight(30);
	//$active_sheet->setCellValue('A14','№');
	/*
	$active_sheet->setCellValue('A1','Код');
	$active_sheet->setCellValue('B1','Техническое название для счета');
	$active_sheet->setCellValue('C1','Цена продажи');
	$active_sheet->setCellValue('D1','Количество товара');
	$active_sheet->setCellValue('E1','Ед');
	$active_sheet->setCellValue('F1','Сумма');
	*/

	

	
	
	//ТАБЛИЦА ТОВАРОВ
	
	$row_start = 1;
	$i = 0;
	$c = 1;
	/*foreach($price_list as $item) {
		$row_next = $row_start + $i;
		
		$active_sheet->setCellValue('A'.$row_next,$item['id']);
		$active_sheet->setCellValue('B'.$row_next,$item['name']);
		$active_sheet->setCellValue('C'.$row_next,$item['price']);
		$active_sheet->setCellValue('D'.$row_next,$item['quantity']);
		
		$i++;
	}*/

$arProducts = explode(',', $PRODUCTS);

$dbBasket = CSaleBasket::GetList(
	array("DATE_INSERT" => "ASC", "NAME" => "ASC"),
	array("ORDER_ID" => $ORDER_ID, "PRODUCT_ID"=>$arProducts)
);
if ($arBasket = $dbBasket->Fetch())
{

	$n = 0;
	$sum = 0.00;
	$vat = 0;
	$nds = 0;
	do
	{
		// props in product basket
		$arProdProps = array();
		$dbBasketProps = CSaleBasket::GetPropsList(
			array("SORT" => "ASC", "ID" => "DESC"),
			array(
				"BASKET_ID" => $arBasket["ID"],
				"!CODE" => array("CATALOG.XML_ID", "PRODUCT.XML_ID")
			),
			false,
			false,
			array("ID", "BASKET_ID", "NAME", "VALUE", "CODE", "SORT")
		);
		while ($arBasketProps = $dbBasketProps->GetNext())
		{
			if (!empty($arBasketProps) && $arBasketProps["VALUE"] != "")
				$arProdProps[] = $arBasketProps;
		}
		$arBasket["PROPS"] = $arProdProps;

		$productName = $arBasket["NAME"];
		
		//если предложение
		$product_id=$arBasket["PRODUCT_ID"];
			if(CModule::IncludeModule("Catalog")) {
				$ar_res = CCatalogProduct::GetByIDEx($product_id);//получаем все свойства товара
				if($ar_res['IBLOCK_TYPE_ID']=='offers')//если предложение
				{
					$id_model = $ar_res['PROPERTIES']['MODEL']['VALUE'];
					$ar_res_model = CCatalogProduct::GetByIDEx($id_model);//получаем все свойства предложения
					$model_name = $ar_res_model['NAME'];
					$xml_id = $ar_res['XML_ID'];
					
					$res_temp = CIBlockElement::GetByID($ar_res['PROPERTIES']['MODEL']['VALUE']);
					if($ar_res_temp = $res_temp->GetNext()){
						$ar_res['IBLOCK_SECTION_ID'] = $ar_res_temp['IBLOCK_SECTION_ID'];
					}
					
					$res_section = CIBlockSection::GetList(array("SORT"=>"ASC"),array("SECTION_ID"=> 25, "ACTIVE"=>"Y"),false, false, false);
					while($ar_res_temp2 = $res_section->GetNext()){
						$ar_section[] = $ar_res_temp2['ID'];
					}
						
					if(!empty($ar_res['IBLOCK_SECTION_ID']) && in_array($ar_res['IBLOCK_SECTION_ID'], $ar_section) ):
						$name = $model_name;
					else:
						$name = !empty($ar_res['PROPERTIES']['TECH_NAME']['VALUE']) ? $ar_res['PROPERTIES']['TECH_NAME']['VALUE'] : $ar_res['NAME'];
					endif;
				}
				else
				{
					$name = $ar_res['NAME'];
				}
			}
		
		$name = html_entity_decode($name);
		$xml_id = html_entity_decode($xml_id);
		
		$dbprice = CPrice::GetList(
		 array(),
		 array("PRODUCT_ID"=>$product_id),
		 false,
		 false,
		 array()
		);
		
		$q = number_format($arBasket["QUANTITY"], 0, '', '');
		
		while($arprice = $dbprice->Fetch()){
			if($arprice["QUANTITY_FROM"] < $q && $arprice["QUANTITY_TO"] > $q){
				$PRICE = $arprice["PRICE"];
			}
		}		
		
		if ($productName == "OrderDelivery")
			$productName = htmlspecialcharsbx("Доставка");
		else if ($productName == "OrderDiscount")
			$productName = htmlspecialcharsbx("Скидка");
		
		$row_next = $row_start + $i;
		

		//$active_sheet->setCellValue('A'.$row_next,$c);
		$active_sheet->setCellValue('A'.$row_next,$xml_id);
		$active_sheet->setCellValue('B'.$row_next,$name);
		$active_sheet->setCellValue('C'.$row_next,doubleval($arBasket["PRICE"])); //number_format($arBasket["PRICE"], 2, ',', '')   SaleFormatCurrency($arBasket["PRICE"], $CURRENCY, true)
		$active_sheet->setCellValue('D'.$row_next,roundEx($arBasket["QUANTITY"], SALE_VALUE_PRECISION));
		$active_sheet->setCellValue('E'.$row_next,'шт.');
		$active_sheet->setCellValue('F'.$row_next, doubleval($arBasket["PRICE"] * $arBasket["QUANTITY"])
		//number_format($arBasket["PRICE"] * $arBasket["QUANTITY"], 2, ',', '')
		//SaleFormatCurrency($arBasket["PRICE"] * $arBasket["QUANTITY"],$CURRENCY,true)
		);
		
		$active_sheet->getStyle('C'.$row_next)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$active_sheet->getStyle('F'.$row_next)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
/*
echo var_dump(doubleval(number_format($arBasket["PRICE"] * $arBasket["QUANTITY"], 2, ',', ' ')));
die();*/

		$items = $c;
		$i++;
		$c++;

		$arProps[$n] = array();
		foreach ($arBasket["PROPS"] as $vv)
			$arProps[$n][] = sprintf("%s: %s", $vv["NAME"], $vv["VALUE"]);

		$sum += doubleval($arBasket["PRICE"] * $arBasket["QUANTITY"]);
		$nds += doubleval($PRICE * 0.18 * $arBasket["QUANTITY"]);
	}
	while ($arBasket = $dbBasket->Fetch());
	
	$r = $row_next+1;
	//$radd1 = $r+1;
	//$radd2 = $r+2;
	
	$active_sheet->setCellValue('D'.$r, 'Итого руб.');//number_format($sum, 2, ',', '')
	$active_sheet->setCellValue('F'.$r, doubleval($sum) );  //SaleFormatCurrency($sum,$CURRENCY) ;
	$active_sheet->getStyle('F'.$r)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	
	/*
	if($lang == 'ru'){
		$active_sheet->setCellValue('D'.$radd1, 'В том числе');
		$active_sheet->setCellValue('D'.$radd2, 'НДС 18%');
		
		//NDS
		
		$active_sheet->setCellValue('F'.$radd1, SaleFormatCurrency(	
			$nds,
			$CURRENCY
		));
	}
	
	$r1 = $row_next+5;
	$active_sheet->setCellValue('A'.$r1, sprintf(
		"Всего наименований %s, на сумму %s",
		$items,		
		SaleFormatCurrency(	
			$sum,
			$CURRENCY
		)
		)
	);
	
	$r2 = $row_next+6;
	if (in_array($CURRENCY, array("RUR", "RUB")))
	{
		$active_sheet->setCellValue('A'.$r2, sprintf('Сумма: %s', Number2Word_Rus($sum)));
	}
	else
	{
		$active_sheet->setCellValue('A'.$r2, SaleFormatCurrency(			
			$sum,
			$CURRENCY
		));
	}*/
	
	/*
	$r3 = $row_next+8;
	$r4 = $row_next+9;
	
	
	//$active_sheet->getRowDimension($r3)->setRowHeight(30);
	//$active_sheet->getRowDimension($r4)->setRowHeight(30);
	
	if($order){		
		$header = 'Соколов С.Ю.';
		$glavbuh = 'Ковалюк Г.И.';
		
		$active_sheet->setCellValue('C'.$r3, sprintf('Руководитель______________________/%s/', $header));
		$active_sheet->setCellValue('C'.$r4, sprintf('Гл.Бухгалтер______________________/%s/', $glavbuh));
	}
*/
	$r5 = $row_next+2;
	$r6 = $row_next+3;
	$r7 = $row_next+4;
	$r8 = $row_next+5;
	$r9 = $row_next+6;
	
	
	$active_sheet->setCellValue('A'.$r5,'N документа');
	$active_sheet->setCellValue('B'.$r5, intval($ORDER_ID));
	$active_sheet->setCellValue('A'.$r6,'Дата документа');
	$active_sheet->setCellValue('B'.$r6,$format_date);
	$active_sheet->setCellValue('A'.$r7,'ИНН');
	$active_sheet->setCellValue('B'.$r7, intval(GetClientParam("INN", $arClientProps)));
	$active_sheet->setCellValue('A'.$r8,'КПП');
	$active_sheet->setCellValue('B'.$r8, intval(GetClientParam("KPP", $arClientProps)) );
	$active_sheet->setCellValue('A'.$r9,'Наименование контрагента');
	$active_sheet->setCellValue('B'.$r9,GetClientParam("COMPANY", $arClientProps));
	

	$active_sheet->getStyle('A'.$r7)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
	$active_sheet->getStyle('A'.$r8)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
	

}	
	
	//СТИЛИ
	$style_wrap = array(
		'borders'=>array(
			'outline' => array(
				//'style'=>PHPExcel_Style_Border::BORDER_THICK
			),
			'allborders'=>array(
				'style'=>PHPExcel_Style_Border::BORDER_THIN,
				'color' => array(
					'rgb'=>'000000'
				)
			)
		)
	);
	$active_sheet->getStyle('A1:F'.($i+9))->applyFromArray($style_wrap);
	//$active_sheet->getStyle('A12:F16')->applyFromArray($style_wrap);
	
	$style_products = array(
		'borders'=>array(			
			'allborders'=>array(
				'style'=>PHPExcel_Style_Border::BORDER_THIN,
				'color' => array(
					'rgb'=>'000000'
				)
			)
		)
	);
	$active_sheet->getStyle('A1:F'.($i+9))->applyFromArray($style_products);
	
	$style_header = array(
		'font'=>array(
			'bold' => false,
			'name' => 'Arial',
			'size' => 10
		),
		'alignment' => array(
			//'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
			'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_TOP,
		)
	);
	$active_sheet->getStyle('A1:F1')->applyFromArray($style_header);

	$style_contacts = array(
		'font'=>array(
			'bold' => true,
			'italic' => false,
			'name' => 'Arial',
			'size' => 10,
			'color'=>array(
				'rgb' => '000000'
			)
			
		),
		'alignment' => array(
			'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
			'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_TOP,
		)
		/*'borders' => array(
			'bottom' => array(
			'style'=>PHPExcel_Style_Border::BORDER_THICK
			)
		
		)*/
	);
	/*
	$active_sheet->getStyle('A3:G3')->applyFromArray($style_contacts);
	$active_sheet->getStyle('A4:G4')->applyFromArray($style_contacts);	

	$style_title_bill = array(
		'font'=>array(
			'bold' => true,
			'name' => 'Arial',
			'size' => 14
		),
		'alignment' => array(
			'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
		)


	);
	$active_sheet->getStyle('A7:G7')->applyFromArray($style_title_bill);
	$active_sheet->getStyle('A9:G9')->applyFromArray($style_contacts);
	$active_sheet->getStyle('A10:G10')->applyFromArray($style_contacts);
*/
	$style_hprice = array(
		'alignment' => array(
			'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
		),
		/*'fill' => array(
			'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
			'color'=>array(
				'rgb' => 'CFCFCF'
			)
		),*/
		'font'=>array(
			'bold' => true,
			'italic' => false,
			'name' => 'Arial',
			'size' => 10
		),
		'borders'=>array(
			'outline' => array(
				'style'=>PHPExcel_Style_Border::BORDER_THIN
			),
			'allborders'=>array(
				'style'=>PHPExcel_Style_Border::BORDER_THIN,
				'color' => array(
					'rgb'=>'000000'
				)
			)
		
		)	

	);
	//$active_sheet->getStyle('A1:F1')->applyFromArray($style_hprice);

	$style_price = array(
		'alignment' => array(
			'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_LEFT,
			'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER
		),
		/*'borders'=>array(
			'outline' => array(
				'style'=>PHPExcel_Style_Border::BORDER_THIN
			),
			'allborders'=>array(
				'style'=>PHPExcel_Style_Border::BORDER_THIN,
				'color' => array(
					'rgb'=>'696969'
				)
			)
		)*/
	);
	//$active_sheet->getStyle('A15:G'.($i+6))->applyFromArray($style_price);
	/*
	$style_sum = array(		
		'borders'=>array(
			'bottom' => array(
				'style'=>PHPExcel_Style_Border::BORDER_THICK,
				'color' => array(
					'rgb'=>'000000'
				)
			),
			'top' => array(
				'style'=>PHPExcel_Style_Border::BORDER_THICK,
				'color' => array(
					'rgb'=>'000000'
				)
			)		
		)
		
	);
	//$active_sheet->getStyle('A'.(1+$i+1).':F'.(1+$i+3))->applyFromArray($style_sum);
	
	
	$style_sign = array(
		'font'=>array(
			'bold' => true,
			'italic' => true
		)		
	);
	//$active_sheet->getStyle('C'.(1+$i+8))->applyFromArray($style_sign);
	//$active_sheet->getStyle('C'.(1+$i+9))->applyFromArray($style_sign);
	
	$style_sum_letters = array(
		'font'=>array(
			'bold' => true
		)		
	);
	$active_sheet->getStyle('A'.$r2)->applyFromArray($style_sum_letters);	
	
	$active_sheet->getStyle('A'.(1+$i+2))->applyFromArray($style_sum_letters);
	$active_sheet->getStyle('A'.(1+$i+4))->applyFromArray($style_sum_letters);
	*/
	//header("Content-Type:application/vnd.ms-excel");
	//header("Content-Disposition:attachment;filename='simple.xls'");

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	
	//$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

if($days == 1){
	$file = sprintf(
		'Schet No %s ot %s_%s_days.xlsx',
		$ORDER_ID,
		ConvertDateTime($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["DATE_INSERT"], 'YYYY-MM-DD'),
		$days
	);
}else{
	$file = sprintf(
		'Predzakaz No %s ot %s_%s_days.xlsx',
		$ORDER_ID,
		ConvertDateTime($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["DATE_INSERT"], 'YYYY-MM-DD'),
		$days
	);
}	
	if(is_file('tmp_gen/' . $file)) {
		unlink('tmp_gen/' . $file);
	}
	$objWriter->save('tmp_gen/'.$file);
	}
exit();
}