<?
//Получаем свойства заказа по id и свойства платёжной системы
		$db_vals = CSaleOrder::GetByID(
            $ORDER_ID
        );	
		
		$CURRENCY = $db_vals['CURRENCY'];
		
		$arPaySys = CSalePaySystem::GetByID($db_vals['PAY_SYSTEM_ID'], $db_vals['PERSON_TYPE_ID']);
		$PSinfo = unserialize($arPaySys["PSA_PARAMS"]);
		?><?//echo "<pre>",print_r($PSinfo),"</pre>";?>
		
		<?
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
            array("ORDER_ID" => $arResult['ORDER_ID'])
        );
		while($arVals = $db_vals->Fetch())
		{			
			$arClientProps[$arVals['CODE']]=$arVals['VALUE'];
		}
		?><?//echo "<pre>",print_r($arClientProps),"</pre>";?>
		
		<?
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
		
if (!is_array($arOrder))
	$arOrder = CSaleOrder::GetByID($ORDER_ID);

if (!CSalePdf::isPdfAvailable())
	die();

if ($_REQUEST['BLANK'] == 'Y')
	$blank = true;

$pdf = new CSalePdf('P', 'pt', 'A4');

if (GetParam('BACKGROUND', $PSinfo))
{
	$pdf->SetBackground(
		GetParam('BACKGROUND', $PSinfo),
		GetParam('BACKGROUND_STYLE', $PSinfo)
	);
}

$pageWidth  = $pdf->GetPageWidth();
$pageHeight = $pdf->GetPageHeight();

$pdf->AddFont('Font', '', 'pt_sans-regular.ttf', true);
$pdf->AddFont('Font', 'B', 'pt_sans-bold.ttf', true);

$fontFamily = 'Font';
$fontSize   = 10.5;

$margin = array(
	'top' => intval(GetParam('MARGIN_TOP', $PSinfo) ?: 15) * 72/25.4,
	'right' => intval(GetParam('MARGIN_RIGHT', $PSinfo) ?: 15) * 72/25.4,
	'bottom' => intval(GetParam('MARGIN_BOTTOM', $PSinfo) ?: 15) * 72/25.4,
	'left' => intval(GetParam('MARGIN_LEFT', $PSinfo) ?: 20) * 72/25.4
);

$width = $pageWidth - $margin['left'] - $margin['right'];

$pdf->SetDisplayMode(100, 'continuous');
$pdf->SetMargins($margin['left'], $margin['top'], $margin['right']);
$pdf->SetAutoPageBreak(true, $margin['bottom']);

$pdf->AddPage();


$y0 = $pdf->GetY();
$logoHeight = 0;
$logoWidth = 0;

if (GetParam('PATH_TO_LOGO', $PSinfo))
{
	list($imageHeight, $imageWidth) = $pdf->GetImageSize(GetParam('PATH_TO_LOGO', $PSinfo));

	$logoHeight = $imageHeight + 5;
	$logoWidth  = $imageWidth + 5;

	$pdf->Image(GetParam('PATH_TO_LOGO', $PSinfo), $pdf->GetX(), $pdf->GetY());
}

$pdf->SetFont($fontFamily, '', 8);
if($order) {
	$pdf->Write(15, CSalePdf::prepareToPdf('Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате обязательно, в противном случае не гарантируется наличие товара на складе.'));
	$pdf->Ln();
}

$pdf->SetFont($fontFamily, 'B', $fontSize);

$pdf->SetX($pdf->GetX() + $logoWidth);
$pdf->Write(15, CSalePdf::prepareToPdf('ПОСТАВЩИК: '));
$pdf->Write(15, CSalePdf::prepareToPdf(GetParam("SELLER_NAME", $PSinfo)));
$pdf->Ln();

if (GetParam("SELLER_ADDRESS", $PSinfo))
{
	$pdf->SetX($pdf->GetX() + $logoWidth);
	$pdf->MultiCell(0, 15, CSalePdf::prepareToPdf(sprintf("Юридический адрес: %s", GetParam("SELLER_ADDRESS", $PSinfo))), 0, 'L');
	//$pdf->MultiCell(0, 15, CSalePdf::prepareToPdf(sprintf("Почтовый адрес: %s", GetParam("SELLER_ADDRESS", $PSinfo))), 0, 'L');
}

if (GetParam("SELLER_PHONE", $PSinfo))
{
	$pdf->SetX($pdf->GetX() + $logoWidth);
	$pdf->Write(15, CSalePdf::prepareToPdf(sprintf("Тел.: %s", GetParam("SELLER_PHONE"))));
	$pdf->Ln();
}


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
	$rsPattern = '/\s*\d{10,100}\s*/';

	$sellerBank = trim(preg_replace($rsPattern, ' ', GetParam("SELLER_RS", $PSinfo)));

	preg_match($rsPattern, GetParam("SELLER_RS", $PSinfo), $matches);
	$sellerRs = trim($matches[0]);
}


//шапка вместо табличной разбивки
if($order) {
	$pdf->Write(15, CSalePdf::prepareToPdf("РЕКВИЗИТЫ ПОСТАВЩИКА: "));
	
	$pdf->Write(15, (GetParam("SELLER_INN", $PSinfo))
			? CSalePdf::prepareToPdf(sprintf("ИНН %s ", GetParam("SELLER_INN", $PSinfo)))
			: '');
			
	$pdf->Write(15, (GetParam("SELLER_KPP", $PSinfo))
		? CSalePdf::prepareToPdf(sprintf("КПП %s, ", GetParam("SELLER_KPP", $PSinfo)))
		: '');


	$pdf->Write(15, CSalePdf::prepareToPdf('р/с'));		
	$pdf->Write(15, CSalePdf::prepareToPdf($sellerRs));
	
	$pdf->Write(15, CSalePdf::prepareToPdf($sellerBank));
	
	$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(", БИК %s, ", GetParam("SELLER_BIK", $PSinfo))));
	
	$pdf->Write(15, CSalePdf::prepareToPdf('корр.сч.'));	
	$pdf->Write(15, CSalePdf::prepareToPdf(GetParam("SELLER_KS", $PSinfo)));
}

//*********************//

/*
//табличная шапка	
$pdf->Ln();
$pdf->SetY(max($y0 + $logoHeight, $pdf->GetY()));

$pdf->SetFont($fontFamily, '', $fontSize);

$x0 = $pdf->GetX();
$y0 = $pdf->GetY();


$pdf->Cell(
	150, 18,
	(GetParam("SELLER_INN"))
		? CSalePdf::prepareToPdf(sprintf("ИНН %s", GetParam("SELLER_INN")))
		: ''
);
$x1 = $pdf->GetX();
$pdf->Cell(
	150, 18,
	(GetParam("SELLER_KPP"))
		? CSalePdf::prepareToPdf(sprintf("КПП %s", GetParam("SELLER_KPP")))
		: ''
);
$x2 = $pdf->GetX();
$pdf->Cell(50, 18);
$x3 = $pdf->GetX();
$pdf->Cell(0, 18);
$x4 = $pdf->GetX();

$pdf->Line($x0, $y0, $x4, $y0);

$pdf->Ln();
$y1 = $pdf->GetY();

$pdf->Line($x1, $y0, $x1, $y1);

$pdf->Cell(300, 18, CSalePdf::prepareToPdf('Получатель'));
$pdf->Cell(50, 18);
$pdf->Cell(0, 18);

$pdf->Line($x0, $y1, $x2, $y1);

$pdf->Ln();
$y2 = $pdf->GetY();

$pdf->Cell(300, 18, CSalePdf::prepareToPdf(GetParam("SELLER_NAME")));
$pdf->Cell(50, 18, CSalePdf::prepareToPdf('Сч. №'));
$pdf->Cell(0, 18, CSalePdf::prepareToPdf($sellerRs));

$pdf->Ln();
$y3 = $pdf->GetY();

$pdf->Cell(300, 18, CSalePdf::prepareToPdf('Банк получателя'));
$pdf->Cell(50, 18, CSalePdf::prepareToPdf('БИК'));
$pdf->Cell(0, 18, CSalePdf::prepareToPdf(GetParam("SELLER_BIK")));

$pdf->Line($x0, $y3, $x4, $y3);

$pdf->Ln();
$y4 = $pdf->GetY();

$pdf->Cell(300, 18, CSalePdf::prepareToPdf($sellerBank));
$pdf->Cell(50, 18, CSalePdf::prepareToPdf('Сч. №'));
$pdf->Cell(0, 18, CSalePdf::prepareToPdf(GetParam("SELLER_KS")));

$pdf->Ln();
$y5 = $pdf->GetY();

$pdf->Line($x0, $y5, $x4, $y5);

$pdf->Line($x0, $y0, $x0, $y5);
$pdf->Line($x2, $y0, $x2, $y5);
$pdf->Line($x3, $y0, $x3, $y5);
$pdf->Line($x4, $y0, $x4, $y5);

$pdf->Ln();
$pdf->Ln();

*/
$pdf->Ln();	
$pdf->Ln();	

$pdf->SetFont($fontFamily, 'B', $fontSize*2);

$months = array('Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря');
$format_date = date('j ').$months[date('n')-1].date(' Y');

if($order){
	$billNo_tmp = CSalePdf::prepareToPdf(sprintf(
		"СЧЕТ № %s от %s",
		//$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["ACCOUNT_NUMBER"],
		$ORDER_ID,
		//GetParam("DATE_INSERT")
		$format_date
	));
}else{
	$billNo_tmp = CSalePdf::prepareToPdf(sprintf(
		"Предзаказ", //СЧЕТ от %s
		$format_date
	));
}
$billNo_width = $pdf->GetStringWidth($billNo_tmp);
$pdf->Cell(0, 20, $billNo_tmp, 0, 0, 'C');
$pdf->Ln();

$pdf->SetFont($fontFamily, '', $fontSize);

if (GetParam("ORDER_SUBJECT", $PSinfo))
{
	$pdf->Cell($width/2-$billNo_width/2-2, 15, '');
	$pdf->MultiCell(0, 15, CSalePdf::prepareToPdf(GetParam("ORDER_SUBJECT", $PSinfo)), 0, 'L');
}
/*
if (GetParam("DATE_PAY_BEFORE", $PSinfo) && $order)
{
	$pdf->Cell($width/2-$billNo_width/2-2, 15, '');
	$pdf->MultiCell(0, 15, CSalePdf::prepareToPdf(sprintf(
		"Срок оплаты %s",
		ConvertDateTime(GetParam("DATE_PAY_BEFORE", $PSinfo), FORMAT_DATE)
	)), 0, 'L');
}*/
$pdf->Ln();

if (GetClientParam("COMPANY", $arClientProps))
{
	$pdf->SetFont($fontFamily, 'B', $fontSize);
	
	$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(
		"ПЛАТЕЛЬЩИК: %s",
		GetClientParam("COMPANY", $arClientProps)
	)));
	if (GetClientParam("INN", $arClientProps))
		$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(" ИНН %s", GetClientParam("INN", $arClientProps))));
	if (GetClientParam("COMPANY_ADR", $arClientProps))
		$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(", %s", GetClientParam("COMPANY_ADR", $arClientProps))));
	if (GetClientParam("PHONE", $arClientProps))
		$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(", %s", GetClientParam("PHONE", $arClientProps))));
	/*if (GetClientParam("FAX", $arClientProps))
		$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(", %s", GetClientParam("FAX", $arClientProps))));
	if (GetClientParam("CONTACT_PERSON", $arClientProps))
		$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(", %s", GetClientParam("CONTACT_PERSON", $arClientProps))));*/
	$pdf->Ln();
}

$pdf->SetFont($fontFamily, '', $fontSize);

//Комментарии к счёту
if ((GetParam("COMMENT1", $PSinfo) && $order)|| GetParam("COMMENT2", $PSinfo))
{
	$pdf->Write(15, CSalePdf::prepareToPdf('Примечание:'));
	$pdf->Ln();

	$pdf->SetFont($fontFamily, '', $fontSize);

	if (GetParam("COMMENT1", $PSinfo))
	{
		$pdf->Write(15, HTMLToTxt(preg_replace(
			array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
			CSalePdf::prepareToPdf(GetParam("COMMENT1", $PSinfo))
		), '', array(), 0));
		$pdf->Ln();		
	}

	if (GetParam("COMMENT2", $PSinfo))
	{
		$pdf->Write(15, HTMLToTxt(preg_replace(
			array('#</div>\s*<div[^>]*>#i', '#</?div>#i'), array('<br>', '<br>'),
			CSalePdf::prepareToPdf(GetParam("COMMENT2", $PSinfo))
		), '', array(), 0));
		$pdf->Ln();
		$pdf->Ln();
	}
}

/*
$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(
	"Грузополучатель: %s ИНН %s, %s",
	GetParam("BUYER_NAME"),
	GetParam("BUYER_INN"),
	GetParam("BUYER_ADDRESS")
)));
$pdf->Ln();
*/

// Список товаров
$dbBasket = CSaleBasket::GetList(
	array("DATE_INSERT" => "ASC", "NAME" => "ASC"),
	array("ORDER_ID" => $ORDER_ID, "PRODUCT_ID"=>$products)
);
if ($arBasket = $dbBasket->Fetch())
{
	$arColsCaption = array(
		1 => CSalePdf::prepareToPdf('№'),
		CSalePdf::prepareToPdf('Наименование товара'),
		CSalePdf::prepareToPdf('Кол-во'),
		CSalePdf::prepareToPdf('Ед.'),
		CSalePdf::prepareToPdf('Цена (с НДС) руб.'),
		CSalePdf::prepareToPdf('Ставка НДС'),
		CSalePdf::prepareToPdf('Сумма (с НДС) руб.')
	);
	$arCells = array();
	$arProps = array();
	$arRowsWidth = array(1 => 0, 0, 0, 0, 0, 0, 0);

	for ($i = 1; $i <= 7; $i++)
		$arRowsWidth[$i] = max($arRowsWidth[$i], $pdf->GetStringWidth($arColsCaption[$i]));

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
					$id_model=$ar_res['PROPERTIES']['MODEL']['VALUE'];
					$ar_res_model = CCatalogProduct::GetByIDEx($id_model);//получаем все свойства предложения
					$model_name=$ar_res_model['NAME'];
					
					$res_temp = CIBlockElement::GetByID($ar_res['PROPERTIES']['MODEL']['VALUE']);
					if($ar_res_temp = $res_temp->GetNext()){
						$ar_res['IBLOCK_SECTION_ID'] = $ar_res_temp['IBLOCK_SECTION_ID'];
					}

					$res_section = CIBlockSection::GetList(array("SORT"=>"ASC"),array("SECTION_ID"=> 25, "ACTIVE"=>"Y"),false, false, false);
					while($ar_res_temp2 = $res_section->GetNext()){
						$ar_section[] = $ar_res_temp2['ID'];
					}
					
					if(!empty($ar_res['IBLOCK_SECTION_ID']) && in_array($ar_res['IBLOCK_SECTION_ID'], $ar_section) ):
						$name=$model_name;
					else:
						$name = !empty($ar_res['PROPERTIES']['TECH_NAME']['VALUE']) ? $ar_res['PROPERTIES']['TECH_NAME']['VALUE'] : $ar_res['NAME'];
					endif;

				}
				else
				{
					
					$name = $ar_res['NAME'];
				}
			}

		/*получим цену без НДС и значение НДС*/
		$dbprice = CPrice::GetList(
		 array(),
		 array("PRODUCT_ID"=>$product_id),
		 false,
		 false,
		 array()
		);
		
		$q = number_format($arBasket["QUANTITY"], 0, '', '');
		
		while($arprice = $dbprice->Fetch()){
			if(empty($arprice["QUANTITY_FROM"]) || is_null($arprice["QUANTITY_FROM"]) ) $arprice["QUANTITY_FROM"] = 0;
			if(empty($arprice["QUANTITY_TO"]) || is_null($arprice["QUANTITY_TO"]) ) $arprice["QUANTITY_TO"] = 0;
			
			if($arprice["QUANTITY_FROM"] <= $q && $arprice["QUANTITY_TO"] >= $q){
				$PRICE = $arprice["PRICE"];
			}

		}
		
		//$arBasket["PRICE"];
		//echo '<pre>',var_dump(),'</pre>';

		//die();
		
		$nds += doubleval($PRICE * 0.18 * $arBasket["QUANTITY"]);
		
		/*==============*/	
			
		if ($productName == "OrderDelivery")
			$productName = htmlspecialcharsbx("Доставка");
		else if ($productName == "OrderDiscount")
			$productName = htmlspecialcharsbx("Скидка");

		$arCells[++$n] = array(
			1 => CSalePdf::prepareToPdf($n),
			CSalePdf::prepareToPdf($name),
			CSalePdf::prepareToPdf(roundEx($arBasket["QUANTITY"], SALE_VALUE_PRECISION)),
			CSalePdf::prepareToPdf('шт.'),
			CSalePdf::prepareToPdf(number_format($arBasket["PRICE"], 2, ',', ' ')), //SaleFormatCurrency($arBasket["PRICE"], $arBasket["CURRENCY"])
			CSalePdf::prepareToPdf(roundEx($arBasket["VAT_RATE"]*100, SALE_VALUE_PRECISION)."%"),
			CSalePdf::prepareToPdf(number_format($arBasket["PRICE"] * $arBasket["QUANTITY"] , 2, ',', ' ') )
			//SaleFormatCurrency($arBasket["PRICE"] * $arBasket["QUANTITY"],$arBasket["CURRENCY"],true)	) 
		);

		$arProps[$n] = array();
		foreach ($arBasket["PROPS"] as $vv)
			$arProps[$n][] = CSalePdf::prepareToPdf(sprintf("%s: %s", $vv["NAME"], $vv["VALUE"]));

		for ($i = 1; $i <= 7; $i++)
			$arRowsWidth[$i] = max($arRowsWidth[$i], $pdf->GetStringWidth($arCells[$n][$i]));

		$sum += doubleval($arBasket["PRICE"] * $arBasket["QUANTITY"]);
		$vat = max($vat, $arBasket["VAT_RATE"]);
		$items = $n;
	}
	while ($arBasket = $dbBasket->Fetch());

	/*if (DoubleVal($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["PRICE_DELIVERY"]) > 0)
	{
		$arDelivery_tmp = CSaleDelivery::GetByID($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["DELIVERY_ID"]);

		$sDeliveryItem = "Доставка";
		if (strlen($arDelivery_tmp["NAME"]) > 0)
			$sDeliveryItem .= sprintf(" (%s)", $arDelivery_tmp["NAME"]);
		$arCells[++$n] = array(
			1 => CSalePdf::prepareToPdf($n),
			CSalePdf::prepareToPdf($sDeliveryItem),
			CSalePdf::prepareToPdf(1),
			CSalePdf::prepareToPdf(''),
			CSalePdf::prepareToPdf(SaleFormatCurrency(
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["PRICE_DELIVERY"],
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"]
			)),
			CSalePdf::prepareToPdf(roundEx($vat*100, SALE_VALUE_PRECISION)."%"),
			CSalePdf::prepareToPdf(SaleFormatCurrency(
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["PRICE_DELIVERY"],
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"]
			))
		);

		for ($i = 1; $i <= 7; $i++)
			$arRowsWidth[$i] = max($arRowsWidth[$i], $pdf->GetStringWidth($arCells[$n][$i]));

		$sum += doubleval($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["PRICE_DELIVERY"]);
	}

	

	if ($sum < $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["PRICE"])
	{
		$arCells[++$n] = array(
			1 => null,
			null,
			null,
			null,
			null,
			CSalePdf::prepareToPdf("Подытог:"),
			CSalePdf::prepareToPdf(SaleFormatCurrency($sum, $GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"]))
		);

		$arRowsWidth[7] = max($arRowsWidth[7], $pdf->GetStringWidth($arCells[$n][7]));
	}*/

	$taxes = false;
	$dbTaxList = CSaleOrderTax::GetList(
		array("APPLY_ORDER" => "ASC"),
		array("ORDER_ID" => $ORDER_ID)
	);

	while ($arTaxList = $dbTaxList->Fetch())
	{
		$taxes = true;

		$arCells[++$n] = array(
			1 => null,
			null,
			null,
			null,
			null,
			CSalePdf::prepareToPdf(sprintf(
				"%s%s%s:",
				($arTaxList["IS_IN_PRICE"] == "Y") ? "В том числе " : "",
				$arTaxList["TAX_NAME"],
				($vat <= 0 && $arTaxList["IS_PERCENT"] == "Y")
					? sprintf(' (%s%%)', roundEx($arTaxList["VALUE"],SALE_VALUE_PRECISION))
					: ""
			)),
			CSalePdf::prepareToPdf(SaleFormatCurrency(
				$arTaxList["VALUE_MONEY"],
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["CURRENCY"]
			))
		);

		$arRowsWidth[7] = max($arRowsWidth[7], $pdf->GetStringWidth($arCells[$n][7]));
	}

	if (!$taxes && $lang == 'ru')
	{
		$arCells[++$n] = array(
			1 => null,
			null,
			null,
			null,
			null,
			CSalePdf::prepareToPdf("НДС:"),
			//CSalePdf::prepareToPdf(number_format($nds , 2, ',', ' ') )//SaleFormatCurrency($nds,	$CURRENCY)
			CSalePdf::prepareToPdf(number_format($sum * (1 - 1/1.18)  , 2, ',', ' ') )//SaleFormatCurrency($nds,	$CURRENCY)
		);

		$arRowsWidth[7] = max($arRowsWidth[7], $pdf->GetStringWidth($arCells[$n][7]));
	}

	if (DoubleVal($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SUM_PAID"]) > 0)
	{
		$arCells[++$n] = array(
			1 => null,
			null,
			null,
			null,
			null,
			CSalePdf::prepareToPdf("Уже оплачено:"),
			CSalePdf::prepareToPdf(SaleFormatCurrency(
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SUM_PAID"],
				$CURRENCY
			))
		);

		$arRowsWidth[7] = max($arRowsWidth[7], $pdf->GetStringWidth($arCells[$n][7]));
	}

	if (DoubleVal($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["DISCOUNT_VALUE"]) > 0)
	{
		$arCells[++$n] = array(
			1 => null,
			null,
			null,
			null,
			null,
			CSalePdf::prepareToPdf("Скидка:"),
			CSalePdf::prepareToPdf(SaleFormatCurrency(
				$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["DISCOUNT_VALUE"],
				$CURRENCY
			))
		);

		$arRowsWidth[7] = max($arRowsWidth[7], $pdf->GetStringWidth($arCells[$n][7]));
	}

	$arCells[++$n] = array(
		1 => null,
		null,
		null,
		null,
		null,
		CSalePdf::prepareToPdf("Итого:"),
		CSalePdf::prepareToPdf(number_format($sum , 2, ',', ' ') )
				//SaleFormatCurrency(	//$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SHOULD_PAY"],	$sum,$CURRENCY)
	
	);

	$arRowsWidth[7] = max($arRowsWidth[7], $pdf->GetStringWidth($arCells[$n][7]));

	for ($i = 1; $i <= 7; $i++)
		$arRowsWidth[$i] += 10;
	if ($vat <= 0)
		$arRowsWidth[6] = 0;
	$arRowsWidth[2] = $width - (array_sum($arRowsWidth)-$arRowsWidth[2]);
}
$pdf->Ln();

$x0 = $pdf->GetX();
$y0 = $pdf->GetY();

for ($i = 1; $i <= 7; $i++)
{
	if ($vat > 0 || $i != 6)
		$pdf->Cell($arRowsWidth[$i], 20, $arColsCaption[$i], 0, 0, 'C');
	${"x$i"} = $pdf->GetX();
}

$pdf->Ln();

$y5 = $pdf->GetY();

$pdf->Line($x0, $y0, $x7, $y0);
for ($i = 0; $i <= 7; $i++)
{
	if ($vat > 0 || $i != 6)
		$pdf->Line(${"x$i"}, $y0, ${"x$i"}, $y5);
}
$pdf->Line($x0, $y5, $x7, $y5);

$rowsCnt = count($arCells);
for ($n = 1; $n <= $rowsCnt; $n++)
{
	$arRowsWidth_tmp = $arRowsWidth;
	$accumulated = 0;
	for ($j = 1; $j <= 7; $j++)
	{
		if (is_null($arCells[$n][$j]))
		{
			$accumulated += $arRowsWidth_tmp[$j];
			$arRowsWidth_tmp[$j] = null;
		}
		else
		{
			$arRowsWidth_tmp[$j] += $accumulated;
			$accumulated = 0;
		}
	}

	$x0 = $pdf->GetX();
	$y0 = $pdf->GetY();

	$pdf->SetFont($fontFamily, '', $fontSize);

	if (!is_null($arCells[$n][2]))
	{
		$text = $arCells[$n][2];
		$cellWidth = $arRowsWidth_tmp[2];
	}
	else
	{
		$text = $arCells[$n][6];
		$cellWidth = $arRowsWidth_tmp[6];
	}

	for ($l = 0; $pdf->GetStringWidth($text) > 0; $l++)
	{
		$pos = ($pdf->GetStringWidth($text) > $cellWidth)
			? strrpos(substr($text, 0, strlen($text)*$cellWidth/$pdf->GetStringWidth($text)), ' ')
			: strlen($text);
		if (!$pos)
			$pos = strlen($text);

		if (!is_null($arCells[$n][1]))
			$pdf->Cell($arRowsWidth_tmp[1], 15, ($l == 0) ? $arCells[$n][1] : '', 0, 0, 'C');
		if ($l == 0)
			$x1 = $pdf->GetX();

		if (!is_null($arCells[$n][2]))
			$pdf->Cell($arRowsWidth_tmp[2], 15, substr($text, 0, $pos));
		if ($l == 0)
			$x2 = $pdf->GetX();

		if (!is_null($arCells[$n][3]))
			$pdf->Cell($arRowsWidth_tmp[3], 15, ($l == 0) ? $arCells[$n][3] : '', 0, 0, 'R');
		if ($l == 0)
			$x3 = $pdf->GetX();

		if (!is_null($arCells[$n][4]))
			$pdf->Cell($arRowsWidth_tmp[4], 15, ($l == 0) ? $arCells[$n][4] : '', 0, 0, 'R');
		if ($l == 0)
			$x4 = $pdf->GetX();

		if (!is_null($arCells[$n][5]))
			$pdf->Cell($arRowsWidth_tmp[5], 15, ($l == 0) ? $arCells[$n][5] : '', 0, 0, 'R');
		if ($l == 0)
			$x5 = $pdf->GetX();

		if (!is_null($arCells[$n][6])) {
			if (is_null($arCells[$n][2]))
				$pdf->Cell($arRowsWidth_tmp[6], 15, substr($text, 0, $pos), 0, 0, 'R');
			else if ($vat > 0)
				$pdf->Cell($arRowsWidth_tmp[6], 15, ($l == 0) ? $arCells[$n][6] : '', 0, 0, 'R');
		}
		if ($l == 0)
			$x6 = $pdf->GetX();

		if (!is_null($arCells[$n][7]))
			$pdf->Cell($arRowsWidth_tmp[7], 15, ($l == 0) ? $arCells[$n][7] : '', 0, 0, 'R');
		if ($l == 0)
			$x7 = $pdf->GetX();

		$pdf->Ln();

		$text = trim(substr($text, $pos));
	}

	if (isset($arProps[$n]) && is_array($arProps[$n]))
	{
		$pdf->SetFont($fontFamily, '', $fontSize-2);
		foreach ($arProps[$n] as $property)
		{
			$pdf->Cell($arRowsWidth_tmp[1], 12, '');
			$pdf->Cell($arRowsWidth_tmp[2], 12, $property);
			$pdf->Cell($arRowsWidth_tmp[3], 12, '');
			$pdf->Cell($arRowsWidth_tmp[4], 12, '');
			$pdf->Cell($arRowsWidth_tmp[5], 12, '');
			if ($vat > 0)
				$pdf->Cell($arRowsWidth_tmp[6], 12, '');
			$pdf->Cell($arRowsWidth_tmp[7], 12, '', 0, 1);
		}
	}

	$y5 = $pdf->GetY();

	if ($y0 > $y5)
		$y0 = $margin['top'];
	for ($i = (is_null($arCells[$n][1])) ? 6 : 0; $i <= 7; $i++)
	{
		if ($vat > 0 || $i != 5)
			$pdf->Line(${"x$i"}, $y0, ${"x$i"}, $y5);
	}

	$pdf->Line((!is_null($arCells[$n][1])) ? $x0 : $x6, $y5, $x7, $y5);
}
$pdf->Ln();


$pdf->SetFont($fontFamily, '', $fontSize);
$pdf->Write(15, CSalePdf::prepareToPdf(sprintf(
	"Всего наименований %s, на сумму %s",
	$items,number_format($sum , 2, ',', ' ')
	//SaleFormatCurrency(	//$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SHOULD_PAY"],		$sum,		$CURRENCY	)
)));
$pdf->Ln();

$pdf->SetFont($fontFamily, 'B', $fontSize);
if (in_array($CURRENCY, array("RUR", "RUB")))
{
	$pdf->Write(15, CSalePdf::prepareToPdf(Number2Word_Rus($sum)));
}
else
{
	$pdf->Write(15, CSalePdf::prepareToPdf(SaleFormatCurrency(
		//$GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["SHOULD_PAY"],
		$sum,
		$CURRENCY
	)));
}
$pdf->Ln();
$pdf->Ln();

$pdf->Ln();

if($order){

	if (!$blank && GetParam('PATH_TO_STAMP', $PSinfo))
		$pdf->Image(GetParam('PATH_TO_STAMP', $PSinfo), $margin['left']+20, $pdf->GetY()+70);
				
	$pdf->SetFont($fontFamily, 'B', $fontSize);

	if (GetParam("SELLER_DIR_POS", $PSinfo))
	{
		if (GetParam("SELLER_DIR", $PSinfo) || GetParam("SELLER_DIR_SIGN", $PSinfo))
		{
			$isDirSign = false;
			if (!$blank && GetParam('SELLER_DIR_SIGN', $PSinfo))
			{
				list($signHeight, $signWidth) = $pdf->GetImageSize(GetParam('SELLER_DIR_SIGN', $PSinfo));

				if ($signHeight && $signWidth)
				{
					$ratio = min(100/$signHeight, 150/$signWidth);
					$signHeight = $ratio * $signHeight;
					$signWidth  = $ratio * $signWidth;

					$isDirSign = true;
				}
			}

			if ($isDirSign)
				$pdf->SetY($pdf->GetY() + $signHeight - 15);
			$pdf->Write(15, CSalePdf::prepareToPdf(GetParam("SELLER_DIR_POS", $PSinfo)));

			if ($isDirSign)
			{
				$pdf->Image(
					GetParam('SELLER_DIR_SIGN', $PSinfo),
						$pdf->GetX() + 110 - $signWidth/2, $pdf->GetY() - $signHeight + 40,
						$signWidth, $signHeight
				);
			}

			$x1 = $pdf->GetX();
			$pdf->Cell(160, 15, '');
			$x2 = $pdf->GetX();

			if (GetParam("SELLER_DIR", $PSinfo))
				$pdf->Write(15, CSalePdf::prepareToPdf('('.GetParam("SELLER_DIR", $PSinfo).')'));
			$pdf->Ln();

			$y2 = $pdf->GetY();
			$pdf->Line($x1+5, $y2, $x2, $y2);

			$pdf->Ln();
		}
	}

	if (GetParam("SELLER_ACC_POS", $PSinfo))
	{
		if (GetParam("SELLER_ACC", $PSinfo) || GetParam("SELLER_ACC_SIGN", $PSinfo))
		{
			$isAccSign = false;
			if (!$blank && GetParam('SELLER_ACC_SIGN', $PSinfo))
			{
				list($signHeight, $signWidth) = $pdf->GetImageSize(GetParam('SELLER_ACC_SIGN', $PSinfo));

				if ($signHeight && $signWidth)
				{
					$ratio = min(37.5/$signHeight, 150/$signWidth);
					$signHeight = $ratio * $signHeight;
					$signWidth  = $ratio * $signWidth;

					$isAccSign = true;
				}
			}

			if ($isAccSign)
				$pdf->SetY($pdf->GetY() + $signHeight - 15);
			$pdf->Write(15, CSalePdf::prepareToPdf(GetParam("SELLER_ACC_POS", $PSinfo)));

			if ($isAccSign)
			{
				$pdf->Image(
					GetParam('SELLER_ACC_SIGN', $PSinfo),
					$pdf->GetX() + 80 - $signWidth/2, $pdf->GetY() - $signHeight + 15,
					$signWidth, $signHeight
				);
			}

			$x1 = $pdf->GetX();
			$pdf->Cell((GetParam("SELLER_DIR", $PSinfo)) ? $x2-$x1 : 160, 15, '');
			$x2 = $pdf->GetX();

			if (GetParam("SELLER_ACC", $PSinfo))
				$pdf->Write(15, CSalePdf::prepareToPdf('('.GetParam("SELLER_ACC", $PSinfo).')'));
			$pdf->Ln();

			$y2 = $pdf->GetY();
			$pdf->Line($x1+5, $y2, $x2, $y2);
		}
	}

}

	$dest = 'F';

if($days == 1){
	$file = sprintf(
			'Schet No %s ot %s_%s_days.pdf',
			$ORDER_ID,
			ConvertDateTime($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["DATE_INSERT"], 'YYYY-MM-DD'),
			$days
		);	
		$output = $pdf->Output(
		$file, $dest
	);
}else{
	$file = sprintf(
			'Predzakaz No %s ot %s_%s_days.pdf',
			$ORDER_ID,
			ConvertDateTime($GLOBALS["SALE_INPUT_PARAMS"]["ORDER"]["DATE_INSERT"], 'YYYY-MM-DD'),
			$days
		);
		$output = $pdf->Output(
			$file, $dest
	);	
}

	if (!copy($file,$_SERVER['DOCUMENT_ROOT'].'/dompdf_lib/tmp_gen/'.$file)) {
      
   }
   else{
      unlink($file);
   }

return;
?>