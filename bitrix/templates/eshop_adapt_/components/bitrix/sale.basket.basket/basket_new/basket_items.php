<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use Bitrix\Sale\DiscountCouponsManager;

echo ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
?>
<div class="cart_title">
	<div class="cart_title_td item"><?=GetMessage("ITEM");?></div>
	<div class="cart_title_td quantity"><?=GetMessage("CT_BCE_QUANTITY");?></div>
	<div class="cart_title_td shipping"><?=GetMessage("SHIPMENT_TERMS");?></div>
	<?
	$IP=getRealIp();//получение ip
	$ipDetail = getCountryByIp($IP);//получение страны по ip
	
	if((SITE_DIR == '/' && $ipDetail == 'RU') || (SITE_DIR == '/' && !$ipDetail)){
		$NDS = true;
	}else{
		$NDS = false;
	}
	
	if($NDS){
		$price_unit = GetMessage("PRICE_UNIT");
		$price = GetMessage("PRICE");
	}else{
		$price_unit = GetMessage("PRICE_UNIT_EX");
		$price = GetMessage("PRICE_EX");
	}
	?>
	<div class="cart_title_td price"><?=$price_unit;?></div>
	<div class="cart_title_td cost"><?=$price;?></div>
</div>
<?
if ($normalCount > 0):
?>
<div class="cart_items">
<?//echo "<pre>",print_r($arResult),"</pre>";?>
	<?
	foreach ($arResult["GRID"]["ROWS"] as $k => $arItem)
	{
		if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y")
		{
			//Получаем данные
			$product_id=$arItem['PRODUCT_ID'];
			$ar_res = CCatalogProduct::GetByIDEx($product_id);//получаем все свойства продукта
			$db_res = CPrice::GetList(
					array(),
					array(
							"PRODUCT_ID" => $product_id,
							"CATALOG_GROUP_ID" => 1
					)
			);
			$price_to = array();
			
			while ($ar_res_price = $db_res->Fetch())
			{
				$ar_res_price['QUANTITY_FROM'] = $ar_res_price['QUANTITY_FROM'] ? $ar_res_price['QUANTITY_FROM'] : 1;
				$price_to[] = '<nobr>'. ($ar_res_price['QUANTITY_TO'] ? ' до ' . $ar_res_price['QUANTITY_TO'] : ' от ' .$ar_res_price['QUANTITY_FROM'] ).' шт. '. CurrencyFormat($ar_res_price["PRICE"], $ar_res_price["CURRENCY"]) .'</nobr>';
			}
			
			if($ar_res['IBLOCK_TYPE_ID']=='offers')//если это предложение
			{
				$id_model=$ar_res['PROPERTIES']['MODEL']['VALUE'];
				$ar_res_model = CCatalogProduct::GetByIDEx($id_model);//получаем все свойства предложения
				$model_name=$ar_res_model['NAME'];
				$temp_section_id = $ar_res['IBLOCK_SECTION_ID'];
				/***********************************/
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
					$name=$ar_res['NAME'];
				endif;
				/**********************************/
				
				
				$sec_id=$ar_res_model['IBLOCK_SECTION_ID'];//id секции
				$iblock_id=$ar_res_model['IBLOCK_ID'];
				$product_code=$ar_res_model['CODE'];
				
				$pdf_tech_char=$ar_res['PROPERTIES']['PDF_OFFERS_TECHNICAL_CHARACTERISTICS']['VALUE'];
			}
			else
			{
				$ar_res['IBLOCK_SECTION_ID'] = $temp_section_id; //возвращаем исходный section_id
				$sec_id=$ar_res['IBLOCK_SECTION_ID'];//id секции
				$iblock_id=$ar_res['IBLOCK_ID'];
				$product_code=$ar_res['CODE'];
				
				$pdf_tech_char=$ar_res['PROPERTIES']['PDF_TECHNICAL_CHARACTERISTICS']['VALUE'];
			}
			$deviant_packing=$ar_res['PROPERTIES']['DEVIANT_PACKING']['VALUE'];
			$props_quantity_item_allowed = $ar_res["PROPERTIES"]["QUANTITY_ITEM_ALLOWED"]["VALUE"];
			
			//Так как выключается активность радиобатона иначе
			$props_quantity_item_allowed = $props_quantity_item_allowed ? $props_quantity_item_allowed : 5000;
			
			$price_info = $ar_res["PROPERTIES"]["PRICE_INFO"]["VALUE"];
			
			if($deviant_packing=='')
				$deviant_packing=1;
			
			//Проверяем, серия это или нет. Если серия, присваиваем id родительской категории			
			$arFilter1=array("IBLOCK_ID"=>$iblock_id,"ID"=>$sec_id);//id инфоблока и id секции
			//Получаем родительскую секцию
			$rsResult1=CIBlockSection::GetList(array("SORT"=>"ASC"),$arFilter1,false,$arSelect=array());
			if($ar1=$rsResult1->GetNext())
			{
				$sec_id_new=$ar1['IBLOCK_SECTION_ID'];
				$sec_code=$ar1['CODE'];
			}
			//проверяем родительскую секцию на серийность
			$arFilter=array("IBLOCK_ID"=>$iblock_id,"ID"=>$sec_id_new);//id инфоблока и id секции
			$rsResult=CIBlockSection::GetList(array("SORT"=>"ASC"),$arFilter,false,$arSelect=array("UF_*"));
			$catalog_list_view="";
			if($ar=$rsResult->GetNext())
			{
				if($ar['UF_CATALOG_LIST_VIEW']!='')//для шаблона каталога с Сериями
				{
					$CATALOG_LIST_VIEW=htmlspecialchars_decode($ar['UF_CATALOG_LIST_VIEW']);				
					$rsEnum = CUserFieldEnum::GetList(array(), array("ID" =>$CATALOG_LIST_VIEW)); // $CATALOG_LIST_VIEW - возвращаемый ID значения 
					$arEnum = $rsEnum->GetNext(); 
					$catalog_list_view=$arEnum['XML_ID'];
				}
				if($catalog_list_view=='series')
				{
					$sec_id=$sec_id_new;
					$sec_code=$ar['CODE'];
				}
			}
			
			$catalog_view="other";
			//Получение значений пользовательских полей для формирования ссылки
			$arFilter=array("IBLOCK_ID"=>$iblock_id,"ID"=>$sec_id);//id инфоблока и id секции
			$rsResult=CIBlockSection::GetList(array("SORT"=>"ASC"),$arFilter,false,$arSelect=array("UF_*"));
			while($ar=$rsResult->GetNext()) 
			{
				if($ar['UF_CATALOG_VIEW']!='')//для шаблона каталога
				{
					$CATALOG_VIEW=htmlspecialchars_decode($ar['UF_CATALOG_VIEW']);				
					$rsEnum = CUserFieldEnum::GetList(array(), array("ID" =>$CATALOG_VIEW)); // $CATALOG_VIEW - возвращаемый ID значения 
					$arEnum = $rsEnum->GetNext(); 
					$catalog_view=$arEnum['XML_ID'];
				}
			}
			
			//Формирование ссылки на товар			
			$path_dir=SITE_DIR.'production/catalog_online/'.$sec_code.'/'.$product_code.'/';
			$link=$path_dir;
			if($catalog_view=='modules' || $catalog_view=='ips' || $catalog_view=='epr')
			{
				$link.='?view=new';
			}
			if($catalog_view=='ips' || $catalog_view=='epr')
			{
				$link.='&offers_id='.$product_id;
			}
			
			//Ссылка на изображение + ссылка на файл технической характеристики
			$str_pdf_tech_char="";
			if($pdf_tech_char!="")//если файл технические хар-ки загружен
			{
				$pdf_path = CFile::GetPath($pdf_tech_char);//путь до файла
				$str_pdf_tech_char='<a href="'.$pdf_path.'" class="passport" target="_blank">'.GetMessage("PRODUCT_PASSPORT").'</a>';
			}
			$str_product_img="";
			$product_img=$ar_res['PROPERTIES']['PRODUCT_IMG']['VALUE'];
			if($product_img!="")//если файл с изображением загружен
			{
				$product_img_path = CFile::GetPath($product_img);//путь до файла
				$str_product_img='<a href="'.$product_img_path.'" class="item_img fancybox-button"></a>';
			}
			?>
			<?/* echo "<pre style='display:none;'>",print_r($arItem),"</pre>"; */?>
			
			
			<div class="cart_item">
				<div class="cart_item_td item">
					<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a class="name" href="<?=$link ?>"><?endif;?>
					<?
					if($ar_res['IBLOCK_TYPE_ID']=='offers')//если это предложение
						echo $name;
						//echo $model_name.' ('.$arItem["NAME"].')';
					else
						echo $arItem["NAME"];
					?>
					<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
					<?=$str_product_img?>
					<?=$str_pdf_tech_char?>
					<div class="clear"></div>
				</div>
					
				<?/*<div class="cart_item_td quantity">	
					<div class="item_order">
						<div class="nav_count count_minus"></div>							
						<input type="text" value="50" disabled="disabled">
						<div class="nav_count count_plus"></div>				
						<div class="clear"></div>
					</div>
				</div>*/?>
						
				<div class="cart_item_td quantity">
					<?/*<table cellspacing="0" cellpadding="0" class="counter">
						<tr>
							<td>*/?>
								<div class="item_order">
									<? if (!empty ($arItem["PRICE"]) && $arItem["PRICE"] > 0 ){?>
										<div class="nav_count count_minus" id="mi"></div>
									<? }?>
									<?$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;?>
									<?/*<input class="inp_quantity" type="text" value="<?=$arItem["QUANTITY"]?>" disabled="disabled" name="QUANTITY_INPUT_<?=$arItem['ID']?>" id="QUANTITY_INPUT_<?=$arItem['ID']?>" onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', '<?=$ratio?>')" />*/?>
										<?//$ZeroQuantity = 'N';
										  if (empty ($arItem["PRICE"]) || $arItem["PRICE"] == 0 ){
										 	$AttrQuantity = 'disabled="disabled" style="margin-left: 20px;"';
										 	$ZeroQuantity = 'Y';
										 }?>
										 
										 
									<input class="quantity_pseudo" type="text" value="<?if ($ZeroQuantity == 'Y') { echo ('0');} else { echo $arItem['QUANTITY'];}/**$deviant_packing*/?>" name="QUANTITY_PSEUDO_<?=$arItem['ID']?>" id="QUANTITY_PSEUDO_<?=$arItem['ID']?>" <?=$AttrQuantity?>   />
									<input class="inp_quantity" type="hidden" value="<?if ($ZeroQuantity == 'Y') { echo ('0');} else { echo $arItem['QUANTITY'];}?>" name="QUANTITY_INPUT_<?=$arItem['ID']?>" id="QUANTITY_INPUT_<?=$arItem['ID']?>" onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', '<?=$ratio?>')" />
									<div class="deviant_packing" style="display:none;"><?=$deviant_packing?></div>
									
									<div class="quantity_item_in_shop" style="display:none;"><?=$ar_res['PRODUCT']['QUANTITY']?></div><?//количество товара в магазине?>
									<div class="quantity_item_allowed" style="display:none;"><?=$props_quantity_item_allowed?></div><?//количество товара, разрешенное к продаже через сайт?>
									
																		
									<!-- quantity selector for mobile -->
									<div style="display:none;">
										<?
										echo getQuantitySelectControl(
											"QUANTITY_SELECT_".$arItem["ID"],
											"QUANTITY_SELECT_".$arItem["ID"],
											$arItem["QUANTITY"],
											$arItem["AVAILABLE_QUANTITY"],
											$arItem["MEASURE_RATIO"],
											$arItem["MEASURE_TEXT"]
										);
										?>
									</div>
									<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
									<? if (!empty ($arItem["PRICE"]) && $arItem["PRICE"] > 0 ){?>
										<div class="nav_count count_plus" id="pl"></div>
									<?}?>
									<div class="clear"></div>
									<a style="display:none;" href="<?echo $path_dir?>?action=ADD2BASKET&id=<?=$arItem["ID"]?>&quantity=0" class="addtoCart" onclick="return addToCart(this);" id="catalog_add2cart_link_<?=$arItem['ID']?>"><?=GetMessage("CATALOG_BUY")?></a>
									<?
										if(CModule::IncludeModule("sale"))
										{
											$dbBasketItems = CSaleBasket::GetList(false, array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "DELAY" => "N","PRODUCT_ID" =>$arItem['ID']), false, false, array("ID","QUANTITY", "PRICE"));
											if ($arItems = $dbBasketItems->Fetch())
												$count_items_in_cart=$arItems['QUANTITY']*1;											
											else
												$count_items_in_cart=0;
										}
									?>
									<div class="quantity_item" style="display:none;"><?=$arItem['CATALOG_QUANTITY']*1-$count_items_in_cart?></div>
								</div>
								<div class="item_order_err"><?=GetMessage("ITEM_ORDER_ERR")?></div>
								<?
								/*$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
								$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
								?>
								<input type="text" size="3" id="QUANTITY_INPUT_<?=$arItem["ID"]?>" name="QUANTITY_INPUT_<?=$arItem["ID"]?>" size="2" maxlength="18" min="0" <?=$max?> step="<?=$ratio?>" style="max-width: 50px" value="<?=$arItem["QUANTITY"]?>" onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', '<?=$ratio?>')" >
								<!-- quantity selector for mobile -->
								<div style="display:none;">
									<?
									echo getQuantitySelectControl(
										"QUANTITY_SELECT_".$arItem["ID"],
										"QUANTITY_SELECT_".$arItem["ID"],
										$arItem["QUANTITY"],
										$arItem["AVAILABLE_QUANTITY"],
										$arItem["MEASURE_RATIO"],
										$arItem["MEASURE_TEXT"]
									);
								?>
								</div>
								<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />?>
							</td>
							<?
							if (isset($arItem["MEASURE_RATIO"])
								&& floatval($arItem["MEASURE_RATIO"]) != 0
								&& !CSaleBasketHelper::isSetParent($arItem)
							):
							?>
							<td id="quantity_control">
								<div class="quantity_control">
									<a href="javascript:void(0);" class="plus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up');"></a>
									<a href="javascript:void(0);" class="minus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down');"></a>
								</div>
							</td>
							<?
							endif;
							if (isset($arItem["MEASURE_TEXT"])):
							?>
								<td style="text-align: left"><?=$arItem["MEASURE_TEXT"]?></td>
							<?
							endif;
							?>
						</tr>
					</table>*/?>
				</div>
				<div class="cart_item_td shipping">
					<div class="shipping_wrap">
						<?
						//Условия отгрузки английская версия
						if(SITE_DIR!=="/") {
							if(CModule::IncludeModule("iblock")){
								$arSelect = array("ID", "NAME", "CODE", "DETAIL_TEXT", "PROPERTY_DAYS");
								$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>37,"CODE"=>'en'), $arSelect);
								while($ar_fields=$ar_result->GetNext()){
									?>
									<div class="pseudo_radio_wrap" onclick="if(!$(this).find('.pseudo_radio.disabled').length);addCookie(<?=$product_id?>, <?=$ar_fields['PROPERTY_DAYS_VALUE']?>)">
										<div class="pseudo_radio <?echo $_COOKIE["item".$product_id]==$ar_fields['PROPERTY_DAYS_VALUE'] ? 'check' : ''?>"><div class="radio_img"></div><div class="radio_text"><?=$ar_fields['NAME']/*GetMessage("SHIPMENT_TERMS_".$ar_fields['PROPERTY_DAYS_VALUE']."_DAYS")*/;?></div></div>
										<div class="btn_show_info"><div class="btn_show_info_text"><?=$ar_fields['DETAIL_TEXT']?></div></div>
									</div>
									<?
								}
							}
						}
						//Условия отгрузки русская версия
						if(SITE_DIR=="/") {
							if(CModule::IncludeModule("iblock")){
								$arSelect = array("ID", "NAME", "CODE", "DETAIL_TEXT", "PROPERTY_DAYS");
								$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>37,"CODE"=>'ru'), $arSelect);
								$check = false;
								while($ar_fields=$ar_result->GetNext()){
								
									
									$N=$arItem["QUANTITY"]; //количество заказанного товара - корзина
									$A= (int) $ar_res['PRODUCT']['QUANTITY']; //количество товара одного вида в магазине - остаток
									$B=$props_quantity_item_allowed; //количество товара, которое разрешено продать через сайт
									//var_dump($N, $B, $A);
									$style_dis='';
									
									if($N<$A && $N<$B && $ar_fields['ID'] == 968) //10 дней отгрузки
									{
										$style_dis=' disabled';
									}
									if(/*isset($_COOKIE["item".$product_id]) && $_COOKIE["item".$product_id] !== $ar_fields['PROPERTY_DAYS_VALUE'] && */($N>$B || $N>$A) && $ar_fields['ID'] == 967) //в течение 1 дня 
									{
										$style_dis=' disabled';
									}
									
									//$check = $_COOKIE["item".$product_id]==1 ? true : false;
									
									$check_item = '';
									if(isset($_COOKIE["item".$product_id]) && $_COOKIE["item".$product_id] == $ar_fields['PROPERTY_DAYS_VALUE']
										&& 
											!$check && $style_dis !== ' disabled' ){
										$check_item = "check";
										$check = true;
										setcookie("item".$product_id, $ar_fields['PROPERTY_DAYS_VALUE'], time() - 3600, "/");
										//echo var_dump($_COOKIE["item".$product_id]);
									}
									else {
										$check_item = "";
									}
									
									?><?//echo "<pre>",print_r($ar_fields),"</pre>";?>
									<div id="radio_<?=$ar_fields['ID']?>" class="pseudo_radio_wrap" onclick="if(!$(this).find('.pseudo_radio.disabled').length);addCookie(<?=$product_id?>, <?=$ar_fields['PROPERTY_DAYS_VALUE']?>)">
										<div class="pseudo_radio<?=$style_dis?> <?echo $check_item;?>"><div class="radio_img"></div><div class="radio_text"><?=$ar_fields['NAME']/*GetMessage("SHIPMENT_TERMS_".$ar_fields['PROPERTY_DAYS_VALUE']."_DAYS")*/;?></div></div>
										<div class="btn_show_info" style="display: none;"><div class="btn_show_info_text"><?=$ar_fields['DETAIL_TEXT']?></div></div>
									</div>
									<?
								}
							}
						}
						?>
						<?/*<div class="pseudo_radio_wrap" onclick="if(!$(this).find('.pseudo_radio.disabled').length)addCookie(<?=$product_id?>, 7)">
							<div class="pseudo_radio <?echo $_COOKIE["item".$product_id]=='7' ? 'check' : ''?>"><div class="radio_img"></div><div class="radio_text"><?=GetMessage("SHIPMENT_TERMS_7_DAYS");?></div></div>
							<div class="btn_show_info"></div>
						</div>
						<div class="pseudo_radio_wrap" onclick="if(!$(this).find('.pseudo_radio.disabled').length)addCookie(<?=$product_id?>, 15)">
							<div class="pseudo_radio <?echo $_COOKIE["item".$product_id]=='15' ? 'check' : ''?>"><div class="radio_img"></div><div class="radio_text"><?=GetMessage("SHIPMENT_TERMS_15_DAYS");?></div></div>
							<div class="btn_show_info"></div>
						</div>
						<div class="pseudo_radio_wrap" onclick="if(!$(this).find('.pseudo_radio.disabled').length)addCookie(<?=$product_id?>, 30)">
							<div class="pseudo_radio <?echo $_COOKIE["item".$product_id]=='30' ? 'check' : ''?>"><div class="radio_img"></div><div class="radio_text"><?=GetMessage("SHIPMENT_TERMS_30_DAYS");?></div></div>
							<div class="btn_show_info"></div>
						</div>
						<div class="pseudo_radio_wrap" onclick="if(!$(this).find('.pseudo_radio.disabled').length)addCookie(<?=$product_id?>, 60)">
							<div class="pseudo_radio disabled <?echo $_COOKIE["item".$product_id]=='60' ? 'check' : ''?>"><div class="radio_img"></div><div class="radio_text"><?=GetMessage("SHIPMENT_TERMS_60_DAYS");?></div></div>
							<div class="btn_show_info"></div>
							<p class="text_info"><?=GetMessage("FROM_5000_PIECES");?></p>
						</div>*/?>
					</div>
				</div>
				<?//echo "<pre>",print_r($arItem['PRICE']),"</pre>";?>
					<?/*if (doubleval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
						<span class="current_price"><?=$arItem["PRICE_FORMATED"]?></span>
						<span class="old_price"><?=$arItem["FULL_PRICE_FORMATED"]?></span>
					<?else:?>
						<span class="current_price"><?=$arItem["PRICE_FORMATED"];?></span>
					<?endif*/?>
					<?
					/*if (doubleval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0){
						$full_price = $arItem["FULL_PRICE"] - $arItem["FULL_PRICE"]*$arItem["DISCOUNT_PRICE_PERCENT"]/100;
					}else{
						$full_price = $arItem["FULL_PRICE"];
					}*/
					//var_dump($arItem);
					//$full_price = sprintf("%.2f", $full_price);
					$full_price = sprintf("%.2f", $arItem["PRICE"]);
					
					if($arItem['CURRENCY']=='USD')
					{
					
					//высчитываем скидку, если определены cookies
						/*if($_COOKIE["item".$product_id]=='60' || $_COOKIE["item".$product_id]=='30'){
							$full_price = round($arItem["FULL_PRICE"] - $arItem["FULL_PRICE"]*0.01, 2);						
												
													
							
						}else{*/
							
						/*}*/
					//***********//
					
					
					
						$price_cur='$<span class="number">'.$full_price.'</span>';
						$cost_cur = sprintf("%.2f", $arItem["QUANTITY"]*$full_price);
						$cost_cur='$<span class="number">'.$cost_cur.'</span>';
					}
					else
					{
						$price_cur='<span class="number">'.$full_price.'</span> руб.';
						$cost_cur = sprintf("%.2f", $arItem["QUANTITY"]*$full_price);
						$cost_cur='<span class="number">'.$cost_cur.'</span> руб.';
						//$cost_cur='<span class="number">'.$arItem['FULL_PRICE'].'</span> руб.';
						//var_dump($arItem);
					}
					?>
					
					<?/*ЕСЛИ ТОВАР БЫЛ ДОБАВЛЕН С НУЛЕВОЙ ЦЕНОЙ И НЕПОНЯТНО ЗАЧЕМ ДОЛЖЕН БЫТЬ В КОРЗИНЕ*/
					
					if (empty ($arItem["PRICE"]) || $arItem["PRICE"] == 0 ){?>
					
						<div class="cart_item_td price ZeroPrice">
							<span class="current_price" style="width: 297px; display: block;">
								<span>недоступен для заказа через сайт</span>
								<div class="btn_show_info"></div>
							</span>
						</div>
						<div class="cart_item_td cost ZeroPrice" style="width: 35px;">		
							<a class="delitem" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"></a>
						</div>
					<? } else {?> 
						<div class="cart_item_td price">
							<?php if($arItem["DISCOUNT_PRICE_PERCENT_FORMATED"] > 0):?>
								<span class="old_price"><?php echo $arItem["FULL_PRICE"]?></span>
							<?php endif;?>
							<span class="current_price"><?=$price_cur?></span>
							<div class="btn_show_info">
								<div class="btn_show_info_text"><?=implode("<br />", $price_to);//$price_info?></div>
							</div>
						</div>
						<div class="cart_item_td cost">
							<span><?=$cost_cur?></span>
							<a class="delitem" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"></a>
						</div>
					<?}?>	
			</div>
			<?
		}
	}				
	?>
</div>
<div>
	<?if ($arParams["HIDE_COUPON"] != "Y"):?>
			<div class="bx_ordercart_order_pay_left">
				<div class="bx_ordercart_coupon">
					<span><b><?=GetMessage("STB_COUPON_PROMT")?></b></span>
					<input type="text" id="COUPON" name="COUPON" value="<?=$arResult["COUPON"]?>" size="21" class="good"> <!-- "bad" if coupon is not valid -->
				</div>
			</div>
		<?endif;?>
</div>
		<?
		/*if ($arParams["HIDE_COUPON"] != "Y")
		{
		?>
			<div class="bx_ordercart_coupon">
				<span><?=GetMessage("STB_COUPON_PROMT")?></span><input type="text" id="coupon" name="COUPON" value="" onchange="enterCoupon();">
			</div><?
				if (!empty($arResult['COUPON_LIST']))
				{
					foreach ($arResult['COUPON_LIST'] as $oneCoupon)
					{
						$couponClass = 'disabled';
						switch ($oneCoupon['STATUS'])
						{
							case DiscountCouponsManager::STATUS_NOT_FOUND:
							case DiscountCouponsManager::STATUS_FREEZE:
								$couponClass = 'bad';
								break;
							case DiscountCouponsManager::STATUS_APPLYED:
								$couponClass = 'good';
								break;
						}
						?><div class="bx_ordercart_coupon"><input disabled readonly type="text" name="OLD_COUPON[]" value="<?=htmlspecialcharsbx($oneCoupon['COUPON']);?>" class="<? echo $couponClass; ?>"><span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span><div class="bx_ordercart_coupon_notes"><?
						if (isset($oneCoupon['CHECK_CODE_TEXT']))
						{
							echo (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
						}
						?></div></div><?
					}
					unset($couponClass, $oneCoupon);
				}
		}
		else
		{
			?>&nbsp;<?
		}*/
?>
<div id="cost_block_cart">
	<input type="submit" class="refresh_btn" name="BasketRefresh" value="<?=GetMessage('SALE_REFRESH')?>">
	<div class="cost_block_right">
		<?php if($arResult['DISCOUNT_PRICE_ALL']>0):?>
		<div class="cost_itogo">Сумма: <span class="old_price"><?php echo $arResult['PRICE_WITHOUT_DISCOUNT']?></span></div>
		<span>Ваша скидка <?php echo $arResult['DISCOUNT_PRICE_ALL_FORMATED']?></span>
		<?php endif;?>
		<div class="cost_itogo">
			<?=GetMessage("SALE_TOTAL")?>
			<?=$arResult["allSum_FORMATED"]?>
		</div>
		<?if($NDS){?><div class="text_info_nds">(в том числе НДС 18%)</div><?}?>
		<?/* <div class="nds_sum">НДС: <?=$arResult["allVATSum_FORMATED"]?></div> */?>
	</div>
	<br />
	<div class="clear"></div>
	<!--<div class="text_info">В стоимость включена доставка до выбранного вами терминала транспортной компании<br />в Санкт-Петербурге</div>-->
	<a href="<?=SITE_DIR?>production/catalog_online/" class="link_to_catalog"><?=GetMessage("BACK_TO_CAT")?></a>
	<a id="basketOrderButton2" href="#" class="checkout"><?=GetMessage("SALE_ORDER")?></a>
	<div class="clear"></div>
</div>
<div class="clear"></div>
<?if(SITE_DIR == '/'){?>
	<!--<iframe src="http://argos-trade.com/edost/edost_example.html" id="edost_frame" name="edost_frame"></iframe>-->
	<div class="BasketDelivery">
		<p>Рассчитать стоимость доставки основными транспортными компаниями, с которыми мы работаем, Вы можете, перейдя на калькуляторы доставки:</p>
		<ul>
			<li><a href="http://www.dellin.ru/requests/" target="_blanck"><img src="<?=SITE_TEMPLATE_PATH?>/images/del_lines.png" /><span>Деловые линии</span></a></li>
			<li><a href="http://www.jde.ru/online/calculator.html"  target="_blanck"><img src="<?=SITE_TEMPLATE_PATH?>/images/gelexp.png" /><span>Желдорэкспедиция</span></a></li>
			<li><a href="http://www.dpd.ru/ols/calc/"  target="_blanck"><img src="<?=SITE_TEMPLATE_PATH?>/images/dpd.png" /><span>DPD</span></a></li>
			<li><a href="http://pecom.ru/services-are/the-calculation-of-the-cost/"  target="_blanck"><img src="<?=SITE_TEMPLATE_PATH?>/images/pek.png" /><span>ПЭК</span></a></li>
		</ul>
	</div>

<?}?>
<?/*			
<div id="calculate_shipping">
	<div class="text_info">Вы можете рассчитать стоимость доставки вашего заказа.</div>
	<div class="shipping_tabs">
		<div class="shipping_tab current tab_1"><span>Расчет экспресс-доставки</span></div>
		<div class="shipping_tab tab_2"><span>Расчет доставки транспортной компанией</span></div>
		<div class="clear"></div>
	</div>
	<div class="shipping_content">
		<div class="step">
			<div class="field_name l_h_39">Откуда</div>
			<div class="field_chose marg_bot_16">
				<input type="text" value="Санкт-Петербург" />
			</div>
			<div class="clear"></div>
			<div class="field_name l_h_39">Куда</div>
			<div class="field_chose">
				<input type="text" value="Новосибирск" />
			</div>
			<div class="clear"></div>
		</div>
		<div class="step">
			<div class="field_name">Вес</div>
			<div class="field_chose marg_bot_10">35 кг</div>
			<div class="clear"></div>
			<div class="field_name">Габариты</div>
			<div class="field_chose">50<span>х</span>86<span>х</span>30 см</div>
			<div class="clear"></div>
		</div>
		<div class="step">
			<div class="field_name">Служба доставки</div>
			<div class="field_chose">
				<div class="pseudo_radio_wrap">
					<div class="pseudo_radio check"><div class="radio_img"></div><div class="radio_text">EMS Почта России</div></div>
					<div class="btn_show_info"></div>
				</div>
				<div class="pseudo_radio_wrap">
					<div class="pseudo_radio"><div class="radio_img"></div><div class="radio_text">СПСР-Экспресс</div></div>
					<div class="btn_show_info"></div>
				</div>
				<div class="pseudo_radio_wrap">
					<div class="pseudo_radio"><div class="radio_img"></div><div class="radio_text">PONY EXPRESS</div></div>
					<div class="btn_show_info"></div>
				</div>
				<div class="pseudo_radio_wrap">
					<div class="pseudo_radio"><div class="radio_img"></div><div class="radio_text">ponyexpress.ru</div></div>
					<div class="btn_show_info"></div>
				</div>
				<div class="pseudo_radio_wrap">
					<div class="pseudo_radio"><div class="radio_img"></div><div class="radio_text">DHL Express</div></div>
					<div class="btn_show_info"></div>
				</div>
				<div class="pseudo_radio_wrap">
					<div class="pseudo_radio"><div class="radio_img"></div><div class="radio_text">UPS</div></div>
					<div class="btn_show_info"></div>
				</div>
				<div class="pseudo_radio_wrap">
					<div class="pseudo_radio"><div class="radio_img"></div><div class="radio_text">СДЭК</div></div>
					<div class="btn_show_info"></div>
				</div>
				<div class="pseudo_radio_wrap">
					<div class="pseudo_radio"><div class="radio_img"></div><div class="radio_text">Гарантпост (76)</div></div>
					<div class="btn_show_info"></div>
				</div>
				<div class="pseudo_radio_wrap">
					<div class="pseudo_radio"><div class="radio_img"></div><div class="radio_text">TNT Express (47)</div></div>
					<div class="btn_show_info"></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="shipping_cost">Стоимость доставки: 2 000 руб.</div>
	<div class="shipping_cost_info">Стоимость доставки не входит в стоимость заказа и указана для справки</div>
</div>
*/?>

<?/*
<div id="basket_items_list">
	<div class="bx_ordercart_order_table_container">
	
		<table>
			<thead>
				<tr>
					<td class="margin"></td>
					<?
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

						if (in_array($arHeader["id"], array("TYPE"))) // some header columns are shown differently
						{
							continue;
						}
						elseif ($arHeader["id"] == "PROPS")
						{
							$bPropsColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELAY")
						{
							$bDelayColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "DELETE")
						{
							$bDeleteColumn = true;
							continue;
						}
						elseif ($arHeader["id"] == "WEIGHT")
						{
							$bWeightColumn = true;
						}

						if ($arHeader["id"] == "NAME"):
						?>
							<td class="item" colspan="2">
						<?
						elseif ($arHeader["id"] == "PRICE"):
						?>
							<td class="price">
						<?
						else:
						?>
							<td class="custom">
						<?
						endif;
						?>
							<?=getColumnName($arHeader)?>
							</td>
					<?
					endforeach;

					if ($bDeleteColumn || $bDelayColumn):
					?>
						<td class="custom"></td>
					<?
					endif;
					?>
						<td class="margin"></td>
				</tr>
			</thead>

			<tbody>
				<?
				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):
				?>
					<tr>
						<td class="margin"></td>
						<?
						foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

							if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in columns in this template
								continue;

							if ($arHeader["id"] == "NAME"):
							?>
								<td class="itemphoto">
									<div class="bx_ordercart_photo_container">
										<?
										if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
											$url = $arItem["PREVIEW_PICTURE_SRC"];
										elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
											$url = $arItem["DETAIL_PICTURE_SRC"];
										else:
											$url = $templateFolder."/images/no_photo.png";
										endif;
										?>

										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									</div>
									<?
									if (!empty($arItem["BRAND"])):
									?>
									<div class="bx_ordercart_brand">
										<img alt="" src="<?=$arItem["BRAND"]?>" />
									</div>
									<?
									endif;
									?>
								</td>
								<td class="item">
									<h2 class="bx_ordercart_itemtitle">
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<?=$arItem["NAME"]?>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									</h2>
									<div class="bx_ordercart_itemart">
										<?
										if ($bPropsColumn):
											foreach ($arItem["PROPS"] as $val):

												if (is_array($arItem["SKU_DATA"]))
												{
													$bSkip = false;
													foreach ($arItem["SKU_DATA"] as $propId => $arProp)
													{
														if ($arProp["CODE"] == $val["CODE"])
														{
															$bSkip = true;
															break;
														}
													}
													if ($bSkip)
														continue;
												}

												echo $val["NAME"].":&nbsp;<span>".$val["VALUE"]."<span><br/>";
											endforeach;
										endif;
										?>
									</div>
									<?
									if (is_array($arItem["SKU_DATA"])):
										foreach ($arItem["SKU_DATA"] as $propId => $arProp):

											// is image property
											$isImgProperty = false;
											foreach ($arProp["VALUES"] as $id => $arVal)
											{
												if (isset($arVal["PICT"]) && !empty($arVal["PICT"]))
												{
													$isImgProperty = true;
													break;
												}
											}

											$full = (count($arProp["VALUES"]) > 5) ? "full" : "";

											if ($isImgProperty): // iblock element relation property
											?>
												<div class="bx_item_detail_scu_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_scu_scroller_container">

														<div class="bx_scu">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%;margin-left:0%;">
															<?
															foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																$selected = "";
																foreach ($arItem["PROPS"] as $arItemProp):
																	if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																	{
																		if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
																			$selected = "class=\"bx_active\"";
																	}
																endforeach;
															?>
																<li style="width:10%;" <?=$selected?>>
																	<a href="javascript:void(0);">
																		<span style="background-image:url(<?=$arSkuValue["PICT"]["SRC"]?>)"></span>
																	</a>
																</li>
															<?
															endforeach;
															?>
															</ul>
														</div>

														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
													</div>

												</div>
											<?
											else:
											?>
												<div class="bx_item_detail_size_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_size_scroller_container">
														<div class="bx_size">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%; margin-left:0%;">
																<?
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																	$selected = "";
																	foreach ($arItem["PROPS"] as $arItemProp):
																		if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																		{
																			if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
																				$selected = "class=\"bx_active\"";
																		}
																	endforeach;
																?>
																	<li style="width:10%;" <?=$selected?>>
																		<a href="javascript:void(0);"><?=$arSkuValue["NAME"]?></a>
																	</li>
																<?
																endforeach;
																?>
															</ul>
														</div>
														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
													</div>

												</div>
											<?
											endif;
										endforeach;
									endif;
									?>
								</td>
							<?
							elseif ($arHeader["id"] == "QUANTITY"):
							?>
								<td class="custom">
									<span><?=getColumnName($arHeader)?>:</span>
									<div class="centered">
										<table cellspacing="0" cellpadding="0" class="counter">
											<tr>
												<td>
													<?
													$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
													$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
													?>
													<input
														type="text"
														size="3"
														id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
														name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
														size="2"
														maxlength="18"
														min="0"
														<?=$max?>
														step="<?=$ratio?>"
														style="max-width: 50px"
														value="<?=$arItem["QUANTITY"]?>"
														onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', '<?=$ratio?>')"
													>
												</td>
												<?
												if (isset($arItem["MEASURE_RATIO"])
													&& floatval($arItem["MEASURE_RATIO"]) != 0
													&& !CSaleBasketHelper::isSetParent($arItem)
												):
												?>
													<td id="quantity_control">
														<div class="quantity_control">
															<a href="javascript:void(0);" class="plus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up');"></a>
															<a href="javascript:void(0);" class="minus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down');"></a>
														</div>
													</td>
												<?
												endif;
												if (isset($arItem["MEASURE_TEXT"])):
												?>
													<td style="text-align: left"><?=$arItem["MEASURE_TEXT"]?></td>
												<?
												endif;
												?>
											</tr>
										</table>
									</div>
									<!-- quantity selector for mobile -->
									<?
									echo getQuantitySelectControl(
										"QUANTITY_SELECT_".$arItem["ID"],
										"QUANTITY_SELECT_".$arItem["ID"],
										$arItem["QUANTITY"],
										$arItem["AVAILABLE_QUANTITY"],
										$arItem["MEASURE_RATIO"],
										$arItem["MEASURE_TEXT"]
									);
									?>
									<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
								</td>
							<?
							elseif ($arHeader["id"] == "PRICE"):
							?>
								<td class="price">
									<?if (doubleval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
										<div class="current_price"><?=$arItem["PRICE_FORMATED"]?></div>
										<div class="old_price"><?=$arItem["FULL_PRICE_FORMATED"]?></div>
									<?else:?>
										<div class="current_price"><?=$arItem["PRICE_FORMATED"];?></div>
									<?endif?>

									<?if (strlen($arItem["NOTES"]) > 0):?>
										<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
										<div class="type_price_value"><?=$arItem["NOTES"]?></div>
									<?endif;?>
								</td>
							<?
							elseif ($arHeader["id"] == "DISCOUNT"):
							?>
								<td class="custom">
									<span><?=getColumnName($arHeader)?>:</span>
									<?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
								</td>
							<?
							elseif ($arHeader["id"] == "WEIGHT"):
							?>
								<td class="custom">
									<span><?=getColumnName($arHeader)?>:</span>
									<?=$arItem["WEIGHT_FORMATED"]?>
								</td>
							<?
							else:
							?>
								<td class="custom">
									<span><?=getColumnName($arHeader)?>:</span>
									<?=$arItem[$arHeader["id"]]?>
								</td>
							<?
							endif;
						endforeach;

						if ($bDelayColumn || $bDeleteColumn):
						?>
							<td class="control">
								<?
								if ($bDeleteColumn):
								?>
									<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><?=GetMessage("SALE_DELETE")?></a><br />
								<?
								endif;
								if ($bDelayColumn):
								?>
									<a href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>"><?=GetMessage("SALE_DELAY")?></a>
								<?
								endif;
								?>
							</td>
						<?
						endif;
						?>
							<td class="margin"></td>
					</tr>
					<?
					endif;
				endforeach;
				?>
			</tbody>

		</table>
	</div>

	<div class="bx_ordercart_order_pay">

	

		<div class="bx_ordercart_order_pay_right">
			<table class="bx_ordercart_order_sum">
				<?if ($bWeightColumn):?>
					<tr>
						<td class="custom_t1"><?=GetMessage("SALE_TOTAL_WEIGHT")?></td>
						<td class="custom_t2"><?=$arResult["allWeight_FORMATED"]?></td>
					</tr>
				<?endif;?>
				<?if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
					<tr>
						<td><?echo GetMessage('SALE_VAT_EXCLUDED')?></td>
						<td><?=$arResult["allSum_wVAT_FORMATED"]?></td>
					</tr>
					<tr>
						<td><?echo GetMessage('SALE_VAT_INCLUDED')?></td>
						<td><?=$arResult["allVATSum_FORMATED"]?></td>
					</tr>
				<?endif;?>

				<?if (doubleval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
					<tr>
						<td class="fwb"><?=GetMessage("SALE_TOTAL")?></td>
						<td class="fwb"><?=str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"])?></td>
					</tr>
					<tr>
						<td class="custom_t1"></td>
						<td class="custom_t2" style="text-decoration:line-through; color:#828282;"><?=$arResult["PRICE_WITHOUT_DISCOUNT"]?></td>
					</tr>
				<?else:?>
					<tr>
						<td class="custom_t1 fwb"><?=GetMessage("SALE_TOTAL")?></td>
						<td class="custom_t2 fwb" id="allSum_FORMATED"><?=$arResult["allSum_FORMATED"]?></td>
					</tr>
				<?endif;?>

			</table>
			<div style="clear:both;"></div>
		</div>
		<div style="clear:both;"></div>

		<div class="bx_ordercart_order_pay_center">
			<div style="float:left">
				<input type="submit" class="bt2" name="BasketRefresh" value="<?=GetMessage('SALE_REFRESH')?>">
			</div>

			<?if ($arParams["USE_PREPAYMENT"] == "Y"):?>
				<?=$arResult["PREPAY_BUTTON"]?>
				<span><?=GetMessage("SALE_OR")?></span>
			<?endif;?>

			<a href="javascript:void(0)" onclick="checkOut();" class="checkout"><?=GetMessage("SALE_ORDER")?></a>
		</div>
	</div>
</div>*/?>
<?
else:
?>
<div id="basket_items_list">
	<table>
		<tbody>
			<tr>
				<td colspan="<?=$numCells?>" style="text-align:center">
					<div class=""><?=GetMessage("SALE_NO_ITEMS");?></div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<?
endif;
?>