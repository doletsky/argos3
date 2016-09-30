<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if(isset($_GET['ORDER_ID'])) {
	if(CModule::IncludeModule("sale")) {
		//подключаем языковой файл
		$dbBasketLid = CSaleBasket::GetList(false, array("ORDER_ID" => $ORDER_ID), false, false, array('LID'));
		if ($lid = $dbBasketLid->Fetch()) {
			if($lid['LID']=='s1')
				require_once("lang/ru/template.php");
			if($lid['LID']=='s2')
				require_once("lang/en/template.php");
		}
		
		$ORDER_ID=$_GET['ORDER_ID'];
		//ищем в куках сроки отгрузки для каждого ID					
		foreach($_COOKIE as $k=>$v){
			$TmpArrCookie = explode('item', $k);			
			$arVals[$TmpArrCookie[1]] = $v;						
		}		
						
		$html='<html><meta http-equiv="content-type" content="text/html; charset=utf-8" /><body>';
		$html=$html.'
		<style>
			.clear {
				clear: both;
			}
			html, body {
				padding:0;
				margin:0;
				width: 100%;
				height: 100%;
			}
			body {
				background:#fff;
			}
			table {
				border-collapse: collapse;
				border-spacing: 0px;
			}
			table td {
				padding:0px;
			}
			#order_form_content {
				width:650px;
				margin:0 auto;
				padding:50px 0px;
			}
			#order_form_content h1 {
				color: #5d5d5d;
				font: bold 18px/30px Arial;
				margin-bottom: 7px;
			}
			#data_order {
				width:622px;
				background-color:#f3f3f3;
				border: solid 1px #d6d6d5;
				padding: 15px 13px;
				margin: 0 auto;
				margin-top:50px;
				
				-moz-border-radius: 5px;
				-webkit-border-radius: 5px;
				-khtml-border-radius: 5px;
				border-radius: 5px;
			}
			#data_order .data_order_wrap {
				border-bottom:solid 1px #e6e6e6;
				margin-bottom:12px;
			}
			#data_order .data_order_title {
				color:#555;
				font: bold 15px/15px Arial;
				margin-bottom:15px;
			}
			#data_order .data_order_title.marg_0 {
				margin-bottom:0px;
			}
			#data_order .data_order_title.price {
				font: bold 16px/20px Arial;
				color:#5d5d5d;
			}
			#data_order ul {
				padding:0px;
			}
			#data_order ul li {
				color:#323232;
				font: normal 14px/19px Arial;
				display:block;
				margin-bottom:10px;
			}
			#data_order ul li span {
				color:#737373;
				font-size:12px;
			}
			#data_order ul li span.confirm_order_prop {
				color:#323232;
				font: normal 14px/19px Arial;
			}
			#data_order ul li sup {
				vertical-align: super;
				font-size: smaller;
			}
			
			.cart_title {
				width:100%;
				height: 29px;
				overflow:hidden;
				
				-moz-border-radius: 5px;
				-webkit-border-radius: 5px;
				-khtml-border-radius: 5px;
				border-radius: 5px;
			}
			.cart_title .cart_title_td {
				height: 29px;
				color: #7f7f7f;
				font: bold 10px/17px Arial;
				text-align: center;
				text-transform:uppercase;
				background:#f3f3f3;
			}
			.cart_title .cart_title_td span {
				font: bold 11px/17px Arial;
				display: inline-block;
				text-transform:none;
				vertical-align: top;
			}
			.cart_title .item.confirm, .cart_item .item.confirm {
				width:130px;
			}
			.cart_title .item {
				text-align:left;
				padding-left:10px;
			}
			.cart_item .item.confirm span {
				display:inline-block;
				vertical-align: middle;
				color:#414141;
				font: normal 12px/19px Arial;
			}
			.cart_title .quantity.confirm, .cart_item .quantity.confirm {
				width:80px;
			}
			.cart_item .quantity.confirm  {
				color:#7f7f7f;
				font: normal 12px/14px Arial;
			}
			.cart_title .shipping.confirm, .cart_item .shipping.confirm {
				width:110px;
			}
			.cart_item .shipping.confirm  {
				color:#414141;
				font: normal 12px/19px Arial;
			}
			.cart_title .price.confirm, .cart_item .price.confirm {
				width:110px;
			}
			.cart_title .cost.confirm, .cart_item .cost.confirm {
				width:110px;
			}
			.cart_title .packing, .cart_item .packing {
				width:89px;
			}
			.cart_item .packing  {
				color: #7f7f7f;
				font: normal 12px/14px Arial;
			}
			.cart_title .cost {
				text-align:right;
				padding-right:10px;
				width:156px;
			}
			.cart_item .cost.confirm {
				text-align:right;
				padding-right:10px;
			}
			.cart_title .price.online, .cart_item .price.online {
				text-align:right;
				padding-right:10px;
				width:164px;
			}
			.cart_items {
				border: solid 1px #fff;
				border-top: none;
				border-bottom: none;
				width: 650px;
			}
			.cart_item {
				width:100%;
			}
			.cart_item .cart_item_td {
				text-align: center;
				vertical-align: middle;
				padding:20px 0px;
			}			
			.cart_item .price {
				color: #646464;
				font: bold 16px/20px Arial;
			}			
			.cart_item .cost {
				color: #414141;
				font: bold 16px/23px Arial;
			}
			.cart_item .item {	
				text-align:left;
				padding-left:10px;
				width:204px;
			}
			
			#cost_block_confirm {
				width:624px;
				border:solid 1px #ccc;
				border-top:none;
				background-color:#f3f3f3;
				padding:12px;
				margin-right:1px;
				
				-moz-border-radius: 0px 0px 5px 5px;
				-webkit-border-radius: 0px 0px 5px 5px;
				-khtml-border-radius: 0px 0px 5px 5px;
				border-radius: 0px 0px 5px 5px;
			}
			#cost_block_confirm .quantity_itogo {
				color:#7c7c7c;
				font: normal 15px/15px Arial;
				margin-bottom:10px;
				text-align:right;
			}
			#cost_block_confirm .cost_itogo {
				color:#414141;
				font: bold 19px/19px Arial;
				margin-bottom:8px;
				text-align:right;
			}
			#cost_block_confirm .text_info_nds {
				text-align:right;
				color: #6a6a6a;
				font: normal 11px/11px Arial;
			}
			#cost_block_confirm .nds_sum {
				text-align:right;
				color: #4b4b4b;
				font: bold 11px/11px Arial;
				margin-top: 8px;
			}
			.confirm_text_info {
				width:650px;
				text-align:right;
				color:#838383;
				font: italic 13px/15px Arial;
				margin-top:13px;
			}
		</style>';
		
		$html=$html.'<div id="order_form_content">';
		$html=$html.'<h1>'.GetMessage('SOA_TEMPL_ORDER_TITLE').' №'.$ORDER_ID.'</h1>';
		$html=$html.'
		<div style="width:650px;border: solid 1px #e2e2e2;">
			<table style="border: solid 1px #f3f3f3;border-top: none;border-bottom: none;width:650px;">
				<tr class="cart_title">
					<td class="cart_title_td item confirm">'.GetMessage("ITEM").'</td>
					<td class="cart_title_td packing">'.GetMessage("QUANTITY_PACK").'</td>
					<td class="cart_title_td quantity confirm">'.GetMessage("QUANTITY").'</td>
					<td class="cart_title_td shipping confirm">'.GetMessage("SHIPMENT_TERMS").'</td>
					<td class="cart_title_td price confirm">'.GetMessage("PRICE_UNIT").'<br>(с НДС)</td>
					<td class="cart_title_td cost confirm">'.GetMessage("PRICE").' (с НДС)</td>
				</tr>
			</table>
		</div>';
		/*$html=$html.'
		<div class="cart_title">
			<div class="cart_title_td item confirm">'.GetMessage("ITEM").'</div>
			<div class="cart_title_td packing">В упаковке</div>
			<div class="cart_title_td quantity confirm">'.GetMessage("QUANTITY").'</div>
			<div class="cart_title_td shipping confirm">'.GetMessage("SHIPMENT_TERMS").'</div>
			<div class="cart_title_td price confirm">'.GetMessage("PRICE_UNIT").'</div>
			<div class="cart_title_td cost confirm">'.GetMessage("PRICE").'</div>
		</div>';*/
	
		$dbBasketItems = CSaleBasket::GetList(false, array("ORDER_ID" => $ORDER_ID), false, false);
		$count_items=0;
		$total_price=0;
		$packs = 0;
		while ($arItems = $dbBasketItems->Fetch())
		{
			/*?><pre><?print_r($arItems)?></pre><?*/
			//Получаем данные
			$product_id=$arItems["PRODUCT_ID"];
			if(CModule::IncludeModule("Catalog")) {
				$ar_res = CCatalogProduct::GetByIDEx($product_id);//получаем все свойства товара
				if($ar_res['IBLOCK_TYPE_ID']=='offers')//если предложение
				{
					$id_model=$ar_res['PROPERTIES']['MODEL']['VALUE'];
					$ar_res_model = CCatalogProduct::GetByIDEx($id_model);//получаем все свойства предложения
					$model_name = $ar_res_model['NAME'];
					
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
			
			$deviant_packing = intval($ar_res['PROPERTIES']['DEVIANT_PACKING']['VALUE']);
			if($deviant_packing == '')
				$deviant_packing = 1;
			$count_items = $count_items+$arItems["QUANTITY"];//*$deviant_packing;
			$packs = $packs + $arData["data"]["QUANTITY"] / $deviant_packing;
			
			//Дни отгрузки
			foreach($arVals as $k=>$v){
				if($k == $arItems["PRODUCT_ID"]){
					$days = $v;					
				}				
			}
						
			if($arItems['CURRENCY']=='USD')
			{				
				$item_price = number_format($arItems["PRICE"], 2, ',', ' '); //sprintf("%.2f", $arItems["PRICE"]);
				$costTmp = $arItems["QUANTITY"]*$arItems["PRICE"];
				$item_cost = number_format($costTmp, 2, ',', ' '); //sprintf("%.2f", $costTmp);
				$price_cur='$<span class="number">'.$item_price.'</span>';
				$cost_cur='$<span class="number">'.$item_cost.'</span>';
				$cur='USD';
			}
			else
			{
				$item_price = number_format($arItems["PRICE"], 2, ',', ' '); //sprintf("%.2f", $arItems["PRICE"]);
				$costTmp = $arItems["QUANTITY"]*$arItems["PRICE"];
				$item_cost = number_format($costTmp, 2, ',', ' '); //sprintf("%.2f", $costTmp);							
				$price_cur='<span class="number">'.$item_price.'</span> руб.';
				$cost_cur='<span class="number">'.$item_cost.'</span> руб.';
				$cur='RUB';
			}		

			$html=$html.'
			<div style="border-bottom: solid 1px #dcdcdc;">
				<table class="cart_items">
					<tr class="cart_item">			
						<td class="cart_item_td item confirm">
							<span>'.$name.'</span>
						</td>
						<td class="cart_item_td packing">'.$deviant_packing.' '.GetMessage('UNIT').'</td>
						<td class="cart_item_td quantity confirm">'.$arItems["QUANTITY"]./**$deviant_packing.*/'</td>
						<td class="cart_item_td shipping confirm">'.GetMessage("SOA_TEMPL_DAYS", Array("#DAYS#"=>$days)).'</td>
						<td class="cart_item_td price confirm">'.$price_cur.'</td>
						<td class="cart_item_td cost confirm">'.$cost_cur.'</td>
					</tr>
				</table>
			</div>';
			$total_price=$total_price+($arItems["QUANTITY"]*$arItems["PRICE"]);
		}
		$total_price = number_format($total_price, 2, ',', ' '); //sprintf("%.2f", $total_price);
		if($cur=='USD')
		{
			$total_price='$<span class="number">'.$total_price.'</span>';
		}
		else
		{
			$total_price='<span class="number">'.$total_price.'</span> руб.';
		}
		
		$html=$html.'
		<div id="cost_block_confirm">
			<div class="quantity_itogo">'.GetMessage("SOA_TEMPL_SUM_SUMMARY_ITEMS").' '.$count_items.'</div>
			<div class="cost_itogo">'.GetMessage("SOA_TEMPL_SUM_IT").' '.$total_price.'</div>';
		if($cur=='RUB'){
			$html=$html.'<div class="text_info_nds">(в том числе НДС 18%)</div>';
		};
			
			/*$tax_price='';
			if(!empty($arResult["arTaxList"]))
			{
				foreach($arResult["arTaxList"] as $val)
				{
					$tax_price=$val["VALUE_MONEY_FORMATED"];
				}
			}*/
			//$html=$html.'<div class="nds_sum">НДС: '.$tax_price.'</div>';
		$html = $html=$html.'
		</div>';
		
		if($cur=='RUB'){
			$html=$html.'			
			<div class="confirm_text_info">В стоимость включена доставка до выбранного вами терминала в Санкт-Петербурге<br><br>Услуги по доставке товара выбранной транспортной компании оплачиваются клиентом самостоятельно</div>';
		}
		
		//Получаем свойств заказа по id
		$db_vals = CSaleOrderPropsValue::GetList(
            array("SORT" => "ASC"),
            array("ORDER_ID" => $ORDER_ID)
        );		
		while($arVals = $db_vals->Fetch())
		{			
			if($arVals['CODE']=='COMPANY')
				$COMPANY=$arVals['VALUE'];
			if($arVals['CODE']=='CONTACT_PERSON')
				$CONTACT_PERSON=$arVals['VALUE'];
			if($arVals['CODE']=='EMAIL')
				$EMAIL=$arVals['VALUE'];
			if($arVals['CODE']=='PHONE_MOBILE')
				$PHONE_MOBILE=$arVals['VALUE'];
			if($arVals['CODE']=='TRANSPORT_COMPANY')
				$TRANSPORT_COMPANY=$arVals['VALUE'];
			if($arVals['CODE']=='COMMENT_FOR_SUBMIT')
				$COMMENT_FOR_SUBMIT=$arVals['VALUE'];
			if($arVals['CODE']=='ADDRESS')
				$ADDRESS=$arVals['VALUE'];
				
			if($arVals['CODE']=='INN')
				$INN=$arVals['VALUE'];
			if($arVals['CODE']=='FAX')
				$FAX=$arVals['VALUE'];
			if($arVals['CODE']=='SITE')
				$SITE=$arVals['VALUE'];
			if($arVals['CODE']=='COMPANY_ADR')
				$COMPANY_ADR=$arVals['VALUE'];
			if($arVals['CODE']=='PHONE')
				$PHONE=$arVals['VALUE'];
				
			if($arVals['CODE']=='LOCATION')
				$LOCATION=$arVals['VALUE'];
		}
		
		/*получаем доставку*/
		if($cur=='USD'){
			$arOrder = CSaleOrder::GetByID($ORDER_ID);
			$deliveryID = $arOrder["DELIVERY_ID"];
			$arDelivery = CSaleDelivery::GetByID($deliveryID);
			$deliveryName = $arDelivery["NAME"];
		}
	
		$html=$html.'<div id="data_order">
			<div class="data_order_wrap">
				<div class="data_order_title">'.GetMessage("PROP_CONTACT_DATA").'</div>
				<ul>
					<li>'.GetMessage("CONF_COMP").': <span class="confirm_order_prop">'.$COMPANY.'</span></li>';
					if($INN && $cur=='RUB') {
						$html=$html.'<li>ИНН: <span class="confirm_order_prop">'.$INN.'</span></li>';
					}
					$html=$html.'<li>'.GetMessage("CONF_CONT_PERSON").': <span class="confirm_order_prop">'.$CONTACT_PERSON.'</span></li>';
					if($PHONE) {
						$html=$html.'<li>'.GetMessage("CONF_PHONE_WORK").': <span class="confirm_order_prop">'.$PHONE.'</span></li>';
					}
					$html=$html.'<li>'.GetMessage("CONF_PHONE_MOB").': <span class="confirm_order_prop">'.$PHONE_MOBILE.'</span></li>';
					if($FAX) {
						$html=$html.'<li>'.GetMessage("CONF_FAX").': <span class="confirm_order_prop">'.$FAX.'</span></li>';
					}
					$html=$html.'<li>Е-mail: <span class="confirm_order_prop">'.$EMAIL.'</span></li>';
					if($SITE) {
						$html=$html.'<li>'.GetMessage("CONF_WEB").': <span class="confirm_order_prop">'.$SITE.'</span></li>';
					}
					if($COMPANY_ADR) {
						$html=$html.'<li>'.GetMessage("CONF_COMP_ADDR").': <span class="confirm_order_prop">'.$COMPANY_ADR.'</span></li>';
					}
				$html=$html.'
				</ul>
			</div>
			<div class="data_order_wrap">';
				
				if($cur=='RUB'){
					$html=$html.'<div class="data_order_title">'.GetMessage("CONF_DELIVERY_DATA").'</div>
					<ul>
						<li>Доставка: Доставка транспортной компанией до дверей</li>';
			
					$html=$html.'<li>'.GetMessage("CONF_DELIVERY_ADDR").': <span class="confirm_order_prop">'.$ADDRESS.'</span></li>';
				
					$html=$html.'<li>Выбранная транспортная компания: <span class="confirm_order_prop">'.$TRANSPORT_COMPANY.'</span></li></ul>';
				}else{
					$html=$html.'<div class="data_order_title">'.GetMessage("CONF_DELIVERY_DATA").'</div>
					<ul>
						<li>'.$deliveryName.'</li></ul>';
				}
				$html=$html.'</div>';
			
			if($cur=='RUB'){
				$html=$html.'<div class="data_order_wrap">
					<div class="data_order_title">Логистические параметры грузов</div>
					<ul>
						<li>Вес: </li>
						<li>Объем: <sup></sup></li>
					</ul>
				</div>
				<div class="data_order_wrap">
					<div class="data_order_title">Количество мест</div>
					<ul>
						<li>Заводских упаковок: '.$packs.'</li>
						<li>Россыпью: '.$count_items.' штук</li>
					</ul>
				</div>';
			}
			
			$html=$html.'<div class="data_order_wrap">
				<div class="data_order_title">'.GetMessage("DELIVERY_COMMENT").': <span class="confirm_order_prop">'.$COMMENT_FOR_SUBMIT.'</span></div>
			</div>			
		</div>';
		//<div class="data_order_title marg_0 price">Ориентировочная стоимость доставки заказа выбранной Вами транспортной компании: 2 000 руб.</div>
		$html=$html.'</div>';
		$html=$html.'</body></html>';
	}
	//echo $html;
	//Подключаем библиотеку для генерации PDF из HTML
	require_once("dompdf/dompdf_config.inc.php");

	$dompdf = new DOMPDF();// Создаем обьект
	$dompdf->set_paper(array(0,0,595.28,841.89));//="A4"
	$dompdf->load_html($html);// Загружаем в него html код
	$dompdf->render();// Создаем из HTML PDF
	$dompdf->stream('zakaz_'.$ORDER_ID.'.pdf'); // Выводим результат (скачивание)
}
?>