<div id="content" class="whole_page padd_top_18 item_card">
	<h1><?=$arResult['NAME']?>. <?=GetMessage("ONLINE_ORDER");?></h1>
	<div id="print"><?=GetMessage("PRINT_LINK");?></div>
	<div class="clear"></div>
	<p class="text_page_info"><?=GetMessage("CHOOSE");?></p>
	<?
	$IP=getRealIp();//получение ip
	$ipDetail = getCountryByIp($IP);//получение страны по ip
	
	?>
	<div class="cart_title">
		<div class="cart_title_td item online"><?=GetMessage("ITEM");?></div>
		<div class="cart_title_td packing"></div>
		<div class="cart_title_td quantity"><?=GetMessage("CT_BCE_QUANTITY");?></div>
		<div class="cart_title_td shipping"><?=GetMessage("SHIPMENT_TERMS");?></div>
		<?if((SITE_DIR == '/'  && $ipDetail == 'RU') || (SITE_DIR == '/'  && !$ipDetail)){?>
			<div class="cart_title_td price online"><?=GetMessage("PRICE_UNIT");?></div>
		<?}else{?>
			<div class="cart_title_td price online"><?=GetMessage("PRICE_UNIT_WO_TAX");?></div>
		<?}?>
	</div>
	<div class="cart_items">
		<?
	
		//Если указана группа для товаров
		
		if($arResult['PROPERTIES']['PROTOCOLS_GROUP']["VALUE"]!='')
		{
			$arSelect = array("ID", "NAME", "IBLOCK_SECTION_ID", "CODE");
			$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$arResult['IBLOCK_ID'], "PROPERTY_PROTOCOLS_GROUP"=>$arResult['PROPERTIES']['PROTOCOLS_GROUP']["VALUE"]), $arSelect);
			while($res=$ar_result->GetNext())
			{								
				$item_gr = CCatalogProduct::GetByIDEx($res['ID']);
				$iblock_sec_id=$res['IBLOCK_SECTION_ID'];
				
				//Проверяем, серия это или нет. Если серия, присваиваем id родительской категории			
				$arFilter1=array("IBLOCK_ID"=>$arResult['IBLOCK_ID'],"ID"=>$iblock_sec_id);//id инфоблока и id секции
				//Получаем родительскую секцию
				$rsResult1=CIBlockSection::GetList(array("SORT"=>"ASC"),$arFilter1,false,$arSelect=array());
				if($ar1=$rsResult1->GetNext())
				{
					$sec_id_new=$ar1['IBLOCK_SECTION_ID'];
					$sec_code=$ar1['CODE'];
				}
				//проверяем родительскую секцию на серийность
				$arFilter=array("IBLOCK_ID"=>$arResult['IBLOCK_ID'],"ID"=>$sec_id_new);//id инфоблока и id секции
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
						$sec_code=$ar['CODE'];
					}
				}
				
				//Ссылка на изображение + ссылка на файл технической характеристики
				$str_pdf_tech_char="";
				$pdf_tech_char=$item_gr['PROPERTIES']['PDF_TECHNICAL_CHARACTERISTICS']["VALUE"];
				if($pdf_tech_char!="")//если файл технические хар-ки загружен
				{
					$pdf_path = CFile::GetPath($pdf_tech_char);//путь до файла
					$str_pdf_tech_char='<a href="'.$pdf_path.'" class="passport" target="_blank">'.GetMessage("PASSPORT").'</a>';
				}
				$str_product_img="";
				$product_img=$item_gr['PROPERTIES']['PRODUCT_IMG']['VALUE'];
				if($product_img!="")//если файл с изображением загружен
				{
					$product_img_path = CFile::GetPath($product_img);//путь до файла
					$str_product_img='<a href="'.$product_img_path.'" class="item_img fancybox-button"></a>';
				}
				?>
				<div class="cart_item item_<?=$item_gr['ID']?>">		
					<input type="hidden" value="<?=$item_gr['ID']?>" class="hid_item_id"/>
					<div class="cart_item_td item online">
						<a href="" class="name"><?=$item_gr['NAME']?></a>
						<?=$str_product_img?>
						<?=$str_pdf_tech_char?>
					</div>
					<div class="cart_item_td packing"><?if($item_gr['PROPERTIES']['DEVIANT_PACKING']['VALUE']!='') echo $item_gr['PROPERTIES']['DEVIANT_PACKING']['VALUE'].' '.GetMessage("MEASURE"); else echo '1 '.GetMessage("MEASURE");?></div>
					<div class="cart_item_td quantity">	
						<div class="item_order">
							<? if (!empty($item_gr['CATALOG_PRICE_1']) && $item_gr['CATALOG_PRICE_1'] != 0) {?>
								<div class="nav_count count_minus"></div>
							<?}?>	
							<input class="quantity_pseudo" type="text" value="0" name="QUANTITY_PSEUDO_<?=$item_gr['ID']?>" id="QUANTITY_PSEUDO_<?=$item_gr['ID']?>" <? if (empty($item_gr['CATALOG_PRICE_1']) || $item_gr['CATALOG_PRICE_1'] <= 0) {?>disabled="disabled"<?}?> />
							<input class="inp_quantity" type="hidden" value="0" name="QUANTITY_<?=$item_gr['ID']?>" id="QUANTITY_<?=$item_gr['ID']?>" />
							<div class="deviant_packing" style="display:none;"><?if($item_gr['PROPERTIES']['DEVIANT_PACKING']['VALUE']!='') echo $item_gr['PROPERTIES']['DEVIANT_PACKING']['VALUE']; else echo '1';?></div>
							
							<div class="quantity_item_in_shop" style="display:none;"><?=$item_gr['PRODUCT']['QUANTITY']?></div><?//количество товара в магазине?>
							<div class="quantity_item_allowed" style="display:none;"><?=$item_gr['PROPERTIES']['QUANTITY_ITEM_ALLOWED']['VALUE']?></div><?//количество товара, разрешенное к продаже через сайт?>
							
							<? if (!empty($item_gr['CATALOG_PRICE_1']) && $item_gr['CATALOG_PRICE_1'] != 0) {?>
								<div class="nav_count count_plus"></div>
							<?}?>	
							<div class="clear"></div>
							<a style="display:none;" href="<?=SITE_DIR?>production/catalog_online/<?echo $sec_code?>/<?echo $res["CODE"]?>/?action=ADD2BASKET&id=<?=$item_gr["ID"]?>&quantity=0" class="addtoCart" onclick="return addToCart(this);" id="catalog_add2cart_link_<?=$item_gr['ID']?>"><?=GetMessage("CATALOG_BUY")?></a>
							<?
							if(CModule::IncludeModule("sale"))
							{
								$dbBasketItems = CSaleBasket::GetList(false, array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "DELAY" => "N","PRODUCT_ID" =>$item_gr['ID']), false, false, array("ID","QUANTITY", "PRICE"));
								if ($arItems = $dbBasketItems->Fetch())
									$count_items_in_cart=$arItems['QUANTITY']*1;											
								else
									$count_items_in_cart=0;
							}
							?>
							<div class="quantity_item" style="display:none;"><?=$item_gr['CATALOG_QUANTITY']*1-$count_items_in_cart?></div>
						</div>
						<div class="item_order_err"><?=GetMessage("ITEM_ORDER_ERR")?></div>
					</div>
					<div class="cart_item_td shipping">
						<div class="shipping_wrap">
							<?
							$product_id=$item_gr['ID'];
							$props_quantity_item_allowed = $item_gr["PROPERTIES"]["QUANTITY_ITEM_ALLOWED"]["VALUE"];
							$price_info = $item_gr["PROPERTIES"]["PRICE_INFO"]["VALUE"];
							//Условия отгрузки английская версия
							if(SITE_DIR!=="/") {
								if(CModule::IncludeModule("iblock")){
									$arSelect = array("ID", "NAME", "CODE", "DETAIL_TEXT", "PROPERTY_DAYS");
									$ar_result2=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>37,"CODE"=>'en'), $arSelect);
									while($ar_fields=$ar_result2->GetNext()){
										?>
										<div class="pseudo_radio_wrap" onclick="if(!$(this).find('.pseudo_radio.disabled').length)addCookie(<?=$product_id?>, <?=$ar_fields['PROPERTY_DAYS_VALUE']?>)">
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
									$ar_result2=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>37,"CODE"=>'ru'), $arSelect);
									while($ar_fields=$ar_result2->GetNext()){
										$N=$count_items_in_cart; //количество заказанного товара
										$A=$item_gr['PRODUCT']['QUANTITY']; //количество товара одного вида в магазине										
										$B=$props_quantity_item_allowed; //количество товара, которое разрешено продать через сайт
										
										$style_dis = '';
										
										if($N<$A && $N<$B && $ar_fields['ID']==968)//10 дней отгрузки
										{
											$style_dis = ' disabled';
										}

										if(($N>$B || $N>$A) && $ar_fields['ID'] == 967) //в течение 1 дня
										//if(($N>$B || $N>$A || ($A < 1 && $B < 1)) && $ar_fields['ID']==967)
										{
											$style_dis=' disabled';
										}
										if(empty($style_dis)) {
		
											setcookie("item".$product_id, $ar_fields['PROPERTY_DAYS_VALUE'],  time()+3600, "/", ".argos-trade.com", 1);
											//setcookie("item".$product_id, $ar_fields['PROPERTY_DAYS_VALUE'], time() + 3600, "/");
										}
										
										?>
										<div id="radio_<?=$ar_fields['ID']?>" class="pseudo_radio_wrap" onclick="if(!$(this).find('.pseudo_radio.disabled').length);addCookie(<?=$product_id?>, <?=$ar_fields['PROPERTY_DAYS_VALUE']?>)">
											<div class="pseudo_radio<?=$style_dis?> <?echo $_COOKIE["item".$product_id]==$ar_fields['PROPERTY_DAYS_VALUE'] ? 'check' : ''?>"><div class="radio_img"></div><div class="radio_text"><?=$ar_fields['NAME']/*GetMessage("SHIPMENT_TERMS_".$ar_fields['PROPERTY_DAYS_VALUE']."_DAYS")*/;?></div></div>
											<div class="btn_show_info"><div class="btn_show_info_text"><?=$ar_fields['DETAIL_TEXT']?></div></div>
										</div>
										<?
									}
								}
							}
							?>
						</div>
					</div>					
					<?				
					
					$item_price = $item_gr['PRICES'][1]['PRICE']; 
						
					if((SITE_DIR == '/'  && $ipDetail == 'RU') || (SITE_DIR == '/'  && !$ipDetail)){
						$nds_item = $item_price * 0.18;							
						$item_price = $item_price + $nds_item;
							
						$discount = 0;
						if($_COOKIE["item".$product_id]=='60'){
							$discount = $item_price*0.02;
						}elseif($_COOKIE["item".$product_id]=='30'){
							$discount = $item_price*0.01;
						}
						$item_price = round($item_price - $discount, 2);							
						
						$NDS = true;
					}else{
						$discount = 0;
						if($_COOKIE["item".$product_id]=='60'){
							$discount = $item_price*0.02;
						}elseif($_COOKIE["item".$product_id]=='30'){
							$discount = $item_price*0.01;
						}
							
						$item_price = round($item_price - $discount, 2);
						$NDS = false;
					}
				
					if($item_gr['CATALOG_CURRENCY_1']=='USD')
					{
						$item_price = sprintf("%.2f", $item_price);
						$price_cur='$<span class="number">'.$item_price.'</span>';						
						$itogo_cur='$<span id="cost_itogo">0</span>';
					}
					else
					{
						$item_price = sprintf("%.2f", $item_price);
						$price_cur='<span class="number">'.$item_price.'</span> руб.';					
						$itogo_cur='<span id="cost_itogo">0</span> руб.';
					}
					?>
					
					<div class="cart_item_td price online">
						<? if (empty($item_gr['CATALOG_PRICE_1']) || $item_gr['CATALOG_PRICE_1'] == 0) {?>
							Недоступен для заказа через сайт
						<?} else {?>
							<?=$price_cur?>
						<?}?>
					
					<div class="btn_show_info"><div class="btn_show_info_text"><?=$price_info?></div></div></div>
					<div style="display:none;" class="item_price"><?=$item_gr['CATALOG_PRICE_1']?></div>
				</div>
				<?
			}
		}
		else
		{
			//Ссылка на изображение + ссылка на файл технической характеристики
			$str_pdf_tech_char="";
			$pdf_tech_char=$arResult['PROPERTIES']['PDF_TECHNICAL_CHARACTERISTICS']["VALUE"];
			if($pdf_tech_char!="")//если файл технические хар-ки загружен
			{
				$pdf_path = CFile::GetPath($pdf_tech_char);//путь до файла
				$str_pdf_tech_char='<a href="'.$pdf_path.'" class="passport" target="_blank">'.GetMessage("PASSPORT").'</a>';
			}
			$str_product_img="";
			$product_img=$arResult['PROPERTIES']['PRODUCT_IMG']['VALUE'];
			if($product_img!="")//если файл с изображением загружен
			{
				$product_img_path = CFile::GetPath($product_img);//путь до файла
				$str_product_img='<a href="'.$product_img_path.'" class="item_img fancybox-button"></a>';
			}
			?>
			<div class="cart_item item_<?=$arResult['ID']?>">	
				<input type="hidden" value="<?=$arResult['ID']?>" class="hid_item_id"/>
				<div class="cart_item_td item online">
					<a href="" class="name"><?=$arResult['NAME']?></a>
					<?=$str_product_img?>
					<?=$str_pdf_tech_char?>
				</div>
				<div class="cart_item_td packing"><?if($arResult['PROPERTIES']['DEVIANT_PACKING']['VALUE']!='') echo $arResult['PROPERTIES']['DEVIANT_PACKING']['VALUE'].' '.GetMessage("MEASURE"); else echo '1 '.GetMessage("MEASURE");?></div>
				<div class="cart_item_td quantity">	
					<div class="item_order">
						<? if (!empty($arResult['CATALOG_PRICE_1']) && $arResult['CATALOG_PRICE_1'] != 0) {?>
							<div class="nav_count count_minus"></div>
						<?}?>	
						<input class="quantity_pseudo" type="text" value="0" name="QUANTITY_PSEUDO_<?=$arResult['ID']?>" id="QUANTITY_PSEUDO_<?=$arResult['ID']?>" <? if (empty($arResult['CATALOG_PRICE_1']) || $arResult['CATALOG_PRICE_1'] <= 0) {?>disabled="disabled"<?}?> />
						<input class="inp_quantity" type="hidden" value="0" name="QUANTITY_<?=$arResult['ID']?>" id="QUANTITY_<?=$arResult['ID']?>" />
						<div class="deviant_packing" style="display:none;"><?if($arResult['PROPERTIES']['DEVIANT_PACKING']['VALUE']!='') echo $arResult['PROPERTIES']['DEVIANT_PACKING']['VALUE']; else echo '1';?></div>
						
						<div class="quantity_item_in_shop" style="display:none;"><?=$arResult['CATALOG_QUANTITY']?></div><?//количество товара в магазине?>
						<div class="quantity_item_allowed" style="display:none;"><?=$arResult['PROPERTIES']['QUANTITY_ITEM_ALLOWED']['VALUE']?></div><?//количество товара, разрешенное к продаже через сайт?>
						
						<? if (!empty($arResult['CATALOG_PRICE_1']) && $arResult['CATALOG_PRICE_1'] != 0) {?>
							<div class="nav_count count_plus"></div>
						<?}?>
						<div class="clear"></div>
						<a style="display:none;" href="<?echo $arResult["DETAIL_PAGE_URL"]?>?action=ADD2BASKET&id=<?=$arResult["ID"]?>&quantity=0" class="addtoCart" onclick="return addToCart(this);" id="catalog_add2cart_link_<?=$arResult['ID']?>"><?=GetMessage("CATALOG_BUY")?></a>
						<?
						if(CModule::IncludeModule("sale"))
						{
							$dbBasketItems = CSaleBasket::GetList(false, array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "DELAY" => "N","PRODUCT_ID" =>$arResult['ID']), false, false, array("ID","QUANTITY", "PRICE"));
							if ($arItems = $dbBasketItems->Fetch())
								$count_items_in_cart=$arItems['QUANTITY']*1;											
							else
								$count_items_in_cart=0;
						}
						?>
						<div class="quantity_item" style="display:none;"><?=$arResult['CATALOG_QUANTITY']*1-$count_items_in_cart?></div>
					</div>
					<div class="item_order_err"><?=GetMessage("ITEM_ORDER_ERR")?></div>
				</div>
				<div class="cart_item_td shipping">
					<div class="shipping_wrap">
						<?
						$product_id=$arResult['ID'];
						$props_quantity_item_allowed = $arResult["PROPERTIES"]["QUANTITY_ITEM_ALLOWED"]["VALUE"];
						$price_info = $arResult["PROPERTIES"]["PRICE_INFO"]["VALUE"];
						//Условия отгрузки английская версия
						if(SITE_DIR!=="/") {
							if(CModule::IncludeModule("iblock")){
								$arSelect = array("ID", "NAME", "CODE", "DETAIL_TEXT", "PROPERTY_DAYS");
								$ar_result2=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>37,"CODE"=>'en'), $arSelect);
								while($ar_fields=$ar_result2->GetNext()){
									?>
									<div class="pseudo_radio_wrap" onclick="if(!$(this).find('.pseudo_radio.disabled').length)addCookie(<?=$product_id?>, <?=$ar_fields['PROPERTY_DAYS_VALUE']?>)">
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
								$ar_result2=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>37,"CODE"=>'ru'), $arSelect);
								$check = false;
								while($ar_fields=$ar_result2->GetNext()){
									$N=$count_items_in_cart; //количество заказанного товара
									$A=$arResult['CATALOG_QUANTITY']; //количество товара одного вида в магазине
									$B=$props_quantity_item_allowed; //количество товара, которое разрешено продать через сайт	
									
									if($N==0) { //в корзине нет количества, какую выбирать точку? 
										$N = $B;
									}
									$style_dis='';
									
									if($N<$A && $N<$B && $ar_fields['ID']==968)
									{
										$style_dis = ' disabled';
									}
									//  $N кол-во заказанного товара > $B кол-во разрешено продать через сайт ||
									//  $N кол-во заказанного товара > $A кол-во товара одного вида в магазине ||
									// ($A кол-во товара одного вида в магазине < 1 && $B кол-во разрешено продать через сайт < 1)

									if(($N>$B || $N>$A) && $ar_fields['ID'] == 967) //в течение 1 дня
									//if(($N>$B || $N>$A || ($A < 1 && $B < 1)) && $ar_fields['ID']==967)
									{
										$style_dis = ' disabled';
										$check_item = '';
									}
									//$_COOKIE["item".$product_id]==$ar_fields['PROPERTY_DAYS_VALUE'] ? 'check' : ''
										
									$check_item = '';
									if( $_COOKIE["item".$product_id] == $ar_fields['PROPERTY_DAYS_VALUE'] ||
									!isset($_COOKIE["item".$product_id]) &&	!$check && $style_dis !== ' disabled' ){
										$check_item = "check";
										$check = true;
										setcookie("item".$product_id, $ar_fields['PROPERTY_DAYS_VALUE'],  time()+3600, "/");
									}
									?>
									<div id="radio_<?=$ar_fields['ID']?>" class="pseudo_radio_wrap" onclick="if(!$(this).find('.pseudo_radio.disabled').length)addCookie(<?=$product_id?>, <?=$ar_fields['PROPERTY_DAYS_VALUE']?>)">
										<div class="pseudo_radio<?=$style_dis?> <?echo $check_item?>"><div class="radio_img"></div><div class="radio_text"><?=$ar_fields['NAME']/*GetMessage("SHIPMENT_TERMS_".$ar_fields['PROPERTY_DAYS_VALUE']."_DAYS")*/;?></div></div>
										<div class="btn_show_info"><div class="btn_show_info_text"><?=$ar_fields['DETAIL_TEXT']?></div></div>
									</div>
									<?
								}
							}
						}
						?>
					</div>
				</div>
				<?
				$item_price = $arResult['CATALOG_PRICE_1']; 
					
					if((SITE_DIR == '/'  && $ipDetail == 'RU') || (SITE_DIR == '/'  && !$ipDetail)){
						$nds_item = $item_price * 0.18;							
						$item_price = $item_price + $nds_item;
							
						$discount = 0;
						if($_COOKIE["item".$product_id]=='60'){
							$discount = $item_price*0.02;
						}elseif($_COOKIE["item".$product_id]=='30'){
							$discount = $item_price*0.01;
						}
						$item_price = round($item_price - $discount, 2);							
						
						$NDS = true;
					}else{
						$discount = 0;
						if($_COOKIE["item".$product_id]=='60'){
							$discount = $item_price*0.02;
						}elseif($_COOKIE["item".$product_id]=='30'){
							$discount = $item_price*0.01;
						}
							
						$item_price = round($item_price - $discount, 2);
						$NDS = false;
					}
					
				if($arResult['CATALOG_CURRENCY_1']=='USD')
				{
					$item_price = sprintf("%.2f", $item_price);
					$price_cur='$<span class="number">'.$item_price.'</span>';					
					$itogo_cur='$<span id="cost_itogo">0</span>';
				}
				else
				{
					$item_price = sprintf("%.2f", $item_price);
					$price_cur='<span class="number">'.$item_price.'</span> руб.';					
					$itogo_cur='<span id="cost_itogo">0</span> руб.';
				}
				?>
				<div class="cart_item_td price online">
					
					<? if (empty($arResult['CATALOG_PRICE_1']) || $arResult['CATALOG_PRICE_1'] == 0) {?>
						 Недоступен для заказа через сайт
					<?} else {?>
						<?=$price_cur?>
					<?}?>
					<div class="btn_show_info">
						<div class="btn_show_info_text"><?=$price_info?></div>
					</div>
				</div>
				<div style="display:none;" class="item_price"><?=$arResult['CATALOG_PRICE_1']?></div>
			</div>
		<?}?>
	</div>
	<div id="cost_block_online_order">
		<div class="cost_itogo"><?=GetMessage("TOTAL");?><?=$itogo_cur?></div>
		<?if ($NDS){?>
			<div class="text_info_nds"><?=GetMessage("VAT");?></div>
			<div class="nds_sum">НДС: <span id="nds_itogo">0</span> руб.</div>
		<?}?>
		<!--<div class="text_info">В стоимость включена доставка до выбранного вами терминала транспортной компании<br />в Санкт-Петербурге</div>-->
		<a href="<?=SITE_DIR?>production/catalog_online/" class="link_to_catalog"><?=GetMessage("BACK_TO_CAT");?></a>
		<div id="btn_make_order"><?=GetMessage("MAKE_ORDER");?></div>
		<div class="clear"></div>
		<div id="addItemInCart">
			<h4><?=GetMessage("ADDED_TO_CART");?></h4>
			<a class="order" href="<?=SITE_DIR?>personal/cart/"><?=GetMessage("GO_TO_PROCESS");?></a>
			<a href="javascript:void(0)" class="close"><?=GetMessage("GO_ON_SHOP");?></a>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>

	<?if(SITE_DIR == '/'){?>
	<!-- <iframe src="http://argos-trade.com/edost/edost_example.html" id="edost_frame" name="edost_frame"></iframe>-->
	<?}?>
	
	<div class="BasketDelivery">
		<p>Рассчитать стоимость доставки основными транспортными компаниями, с которыми мы работаем, Вы можете, перейдя на калькуляторы доставки:</p>
		<ul>
			<li><a href="http://www.dellin.ru/requests/" target="_blanck"><img src="<?=SITE_TEMPLATE_PATH?>/images/del_lines.png" /><span>Деловые линии</span></a></li>
			<li><a href="http://www.jde.ru/online/calculator.html"  target="_blanck"><img src="<?=SITE_TEMPLATE_PATH?>/images/gelexp.png" /><span>Желдорэкспедиция</span></a></li>
			<li><a href="http://www.dpd.ru/ols/calc/"  target="_blanck"><img src="<?=SITE_TEMPLATE_PATH?>/images/dpd.png" /><span>DPD</span></a></li>
			<li><a href="http://pecom.ru/services-are/the-calculation-of-the-cost/"  target="_blanck"><img src="<?=SITE_TEMPLATE_PATH?>/images/pek.png" /><span>ПЭК</span></a></li>
		</ul>
	</div>
	<?
	/*		
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
	
</div>