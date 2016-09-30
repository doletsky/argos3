<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$bDefaultColumns = $arResult["GRID"]["DEFAULT_COLUMNS"];
$colspan = ($bDefaultColumns) ? count($arResult["GRID"]["HEADERS"]) : count($arResult["GRID"]["HEADERS"]) - 1;
$bPropsColumn = false;
$bUseDiscount = false;
$bPriceType = false;
$bShowNameWithPicture = ($bDefaultColumns) ? true : false; // flat to show name and picture column in one column
?>
</div><!--//#order_checkout END-->
<div id="order_confirm">
	<h1><?=GetMessage('CONFIRM_TITLE')?></h1>
	<div id="print"><?=GetMessage("PRINT_LINK")?></div>
	<div class="clear"></div>
	
	<div class="cart_title">
		<div class="cart_title_td item confirm"><?=GetMessage('ITEM')?></div>
		<div class="cart_title_td packing"><?=GetMessage("QUANTITY_PACK")?></div>
		<div class="cart_title_td quantity confirm"><?=GetMessage('QUANTITY')?></div>
		<div class="cart_title_td shipping confirm"><?=GetMessage('SHIPMENT_TERMS')?></div>
		<div class="cart_title_td price confirm"><?=GetMessage('PRICE_UNIT')?></div>
		<div class="cart_title_td cost confirm"><?=GetMessage('PRICE')?></div>
	</div>
	<?
	$count_items=0;
	$packs = 0;
	foreach ($arResult["GRID"]["ROWS"] as $k => $arData)
	{
		//Получаем данные
		$product_id=$arData["data"]["PRODUCT_ID"];
		$ar_res = CCatalogProduct::GetByIDEx($product_id);//получаем все свойства товара/предложения		
		
		//внешний код
		$ex_ID=$ar_res['XML_ID'];
		
		//получаем штрих код
		$dbBarCode = CCatalogStoreBarCode::getList(array(), array("PRODUCT_ID" => $ar_res["ID"]));
		$arBarCode = $dbBarCode->GetNext();		
		$BarCode = $arBarCode['BARCODE'];
		
		$ProductPrefix = $arBarCode ? $BarCode : $ex_ID;
		
		if($ar_res['IBLOCK_TYPE_ID']=='offers')//если предложение
		{
			$id_model=$ar_res['PROPERTIES']['MODEL']['VALUE'];
			$ar_res_model = CCatalogProduct::GetByIDEx($id_model);//получаем все свойства родительского товара			
				
			$model_name=$ar_res_model['NAME'];
			$name=$model_name.' ('.$ar_res['NAME'].')';
			
		}
		else
		{
			$name=$ar_res['NAME'];			
		}
		//Формирование ссылки на товар			
		/*$path_dir=SITE_DIR.'production/catalog_online/'.$sec_code.'/'.$product_code.'/';
		$link=$path_dir;
		if($catalog_view=='modules' || $catalog_view=='ips' || $catalog_view=='epr')
		{
			$link.='?view=new';
		}
		if($catalog_view=='ips' || $catalog_view=='epr')
		{
			$link.='&offers_id='.$product_id;
		}*/
		
		$deviant_packing=$ar_res['PROPERTIES']['DEVIANT_PACKING']['VALUE'];
		if($deviant_packing=='')
			$deviant_packing=1;
		$count_items=$count_items+$arData["data"]["QUANTITY"];/**$deviant_packing;*/
		
		$packs = $packs + $arData["data"]["QUANTITY"] / $deviant_packing;
		?>
		<div class="cart_items">
			<div class="cart_item">			
				<div class="cart_item_td item confirm">
					<span><?=$ProductPrefix?> -&nbsp;</span><span><?=$name?></span>
				</div>
				<?/*<pre style="display:none;"><?print_r($ar_res)?></pre>*/?>
				<div class="cart_item_td packing"><?=$deviant_packing?></div>
				<div class="cart_item_td quantity confirm"><?=$arData["data"]["QUANTITY"]/**$deviant_packing*/?></div>
				<?
				$cookie = 'item'.$product_id;
				$days = $_COOKIE[$cookie];
				?>
				<div class="cart_item_td shipping confirm"><?=GetMessage("SOA_TEMPL_DAYS", Array("#DAYS#"=>$days));?></div>
				<div class="cart_item_td price confirm"><?=$arData["data"]["PRICE_FORMATED"]?></div>
				<div class="cart_item_td cost confirm"><?=$arData["data"]["SUM"]?></div>
			</div>
		</div>
	<?}?>
	<div id="cost_block_confirm">
		<div class="quantity_itogo"><?=GetMessage("SOA_TEMPL_SUM_SUMMARY_ITEMS")?> <?=$count_items?> </div>
		<div class="cost_itogo"><?=GetMessage("SOA_TEMPL_SUM_IT")?> <?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></div>
		<?if(SITE_DIR == '/'){?>
			<div class="text_info_nds">(в том числе НДС 18%)</div>
		<?}?>
		<!--<?
		$tax_price='';
		if(!empty($arResult["arTaxList"]))
		{
			foreach($arResult["arTaxList"] as $val)
			{
				$tax_price=$val["VALUE_MONEY_FORMATED"];
			}
		}
		?>
		<div class="nds_sum">НДС: <?=$tax_price?></div>-->
	</div>
	<div class="clear"></div>
	<?if(SITE_DIR=='/') {?>
		<div class="confirm_text_info">В стоимость включена доставка до выбранного вами терминала в Санкт-Петербурге<br><br>Услуги по доставки товара выбранной транспортной компании оплачиваются клиентом самостоятельно</div>
	<?}?>
	<div class="clear"></div>
			
	<div class="data_order_info"><?=GetMessage("CHECK_DATA")?></div>
	<div id="data_order">
		<div class="data_order_wrap">
			<div class="data_order_title"><?=GetMessage("PROP_CONTACT_DATA")?></div>
			<ul>
				<li><?=GetMessage("CONF_COMP")?>: <span class="confirm_order_prop" id="<?if(SITE_DIR=='/en/') echo 'CONFIRM_ORDER_PROP_33'; else echo 'CONFIRM_ORDER_PROP_8';?>"></span></li>
				<?if(SITE_DIR=='/') {?>
					<li>ИНН: <span class="confirm_order_prop" id="<?if(SITE_DIR=='/en/') echo 'CONFIRM_ORDER_PROP_34'; else echo 'CONFIRM_ORDER_PROP_10';?>"></span></li>
				<?}?>
				<li><?=GetMessage("CONF_CONT_PERSON")?>: <span class="confirm_order_prop" id="<?if(SITE_DIR=='/en/') echo 'CONFIRM_ORDER_PROP_35'; else echo 'CONFIRM_ORDER_PROP_12';?>"></span></li>
				<li><?=GetMessage("CONF_PHONE_WORK")?>: <span class="confirm_order_prop" id="<?if(SITE_DIR=='/en/') echo 'CONFIRM_ORDER_PROP_36'; else echo 'CONFIRM_ORDER_PROP_14';?>"></span></li>
				<li><?=GetMessage("CONF_PHONE_MOB")?>: <span class="confirm_order_prop" id="<?if(SITE_DIR=='/en/') echo 'CONFIRM_ORDER_PROP_37'; else echo 'CONFIRM_ORDER_PROP_27';?>"></span></li>
				<li><?=GetMessage("CONF_FAX")?>: <span class="confirm_order_prop" id="<?if(SITE_DIR=='/en/') echo 'CONFIRM_ORDER_PROP_38'; else echo 'CONFIRM_ORDER_PROP_15';?>"></span></li>
				<li>Е-mail: <span class="confirm_order_prop" id="<?if(SITE_DIR=='/en/') echo 'CONFIRM_ORDER_PROP_39'; else echo 'CONFIRM_ORDER_PROP_13';?>"></span></li>
				<li><?=GetMessage("CONF_WEB")?>: <span class="confirm_order_prop" id="<?if(SITE_DIR=='/en/') echo 'CONFIRM_ORDER_PROP_40'; else echo 'CONFIRM_ORDER_PROP_28';?>"></span></li>
				<li><?=GetMessage("CONF_COMP_ADDR")?>: <span class="confirm_order_prop" id="<?if(SITE_DIR=='/en/') echo 'CONFIRM_ORDER_PROP_41'; else echo 'CONFIRM_ORDER_PROP_9';?>"></span></li>
			</ul>
		</div>
		<div class="data_order_wrap">
			<div class="data_order_title"><?=GetMessage("CONF_DELIVERY_DATA")?></div>
			<ul>
			<?if(SITE_DIR=='/') {?>
				<li>Доставка: Доставка транспортной компанией</li>
			<?}?>
				<li><?=GetMessage("CONF_DELIVERY_ADDR")?>: <span class="confirm_order_prop" id="<?if(SITE_DIR=='/en/') echo 'CONFIRM_ORDER_PROP_42'; else echo 'CONFIRM_ORDER_PROP_19';?>"></span></li>
			<?if(SITE_DIR=='/') {?>
				<li>Выбранная транспортная компания: <span class="confirm_order_prop" id="<?if(SITE_DIR=='/en/') echo 'CONFIRM_ORDER_PROP_43'; else echo 'CONFIRM_ORDER_PROP_29';?>"></span></li>
			<?}?>
			</ul>
		</div>
		<?if(SITE_DIR=='/') {?>
			<div class="data_order_wrap">
				<div class="data_order_title">Логистические параметры грузов</div>
				<ul>
					<li>Вес: 35 кг</li>
					<li>Объем: 50 м<sup>3</sup></li>
				</ul>
			</div>
		
			<div class="data_order_wrap">
				<div class="data_order_title">Количество мест</div>
				<ul>
					
					<li>Заводских упаковок: <?=$packs?></li>
					<li>Россыпью: <?=$count_items?> штук</li>
				</ul>
			</div>
		<?}?>
		<div class="data_order_wrap">
			<div class="data_order_title"><?=GetMessage("DELIVERY_COMMENT")?>: <span class="confirm_order_prop" id="<?if(SITE_DIR=='/en/') echo 'CONFIRM_ORDER_PROP_44'; else echo 'CONFIRM_ORDER_PROP_30';?>"></span></div>
		</div>
		<!--<div class="data_order_title marg_0 price">Ориентировочная стоимость доставки заказа выбранной Вами транспортной компании: 2 000 руб.</div>-->
	</div>
	
	<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
	<input type="hidden" name="profile_change" id="profile_change" value="N">
	<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
	<?/*<div class="bx_ordercart_order_pay_center"><a href="javascript:void();" onClick="submitForm('Y'); return false;" class="checkout"><?=GetMessage("SOA_TEMPL_BUTTON")?></a></div>*/?>
	<div class="confirm_btns">
		<div class="update_data" id="order_step_checkout"><?=GetMessage("CHANGE")?></div>
		<a href="javascript:void();" onClick="submitForm('Y'); return false;" class="submitbutton"><?=GetMessage("SOA_TEMPL_BUTTON")?></a>
		<div class="clear"></div>
	</div>
</div>
	<?/*	
	<div class="bx_ordercart_order_table_container">
		<table>
			<thead>
				<tr>
					<td class="margin"></td>
					<?
					$bPreviewPicture = false;
					$bDetailPicture = false;
					$imgCount = 0;

					// prelimenary column handling
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn)
					{
						if ($arColumn["id"] == "PROPS")
							$bPropsColumn = true;

						if ($arColumn["id"] == "NOTES")
							$bPriceType = true;

						if ($arColumn["id"] == "PREVIEW_PICTURE")
							$bPreviewPicture = true;

						if ($arColumn["id"] == "DETAIL_PICTURE")
							$bDetailPicture = true;
					}

					if ($bPreviewPicture || $bDetailPicture)
						$bShowNameWithPicture = true;


					foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn):

						if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES"))) // some values are not shown in columns in this template
							continue;

						if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
							continue;

						if ($arColumn["id"] == "NAME" && $bShowNameWithPicture):
						?>
							<td class="item" colspan="2">
						<?
							echo GetMessage("SALE_PRODUCTS");
						elseif ($arColumn["id"] == "NAME" && !$bShowNameWithPicture):
						?>
							<td class="item">
						<?
							echo $arColumn["name"];
						elseif ($arColumn["id"] == "PRICE"):
						?>
							<td class="price">
						<?
							echo $arColumn["name"];
						else:
						?>
							<td class="custom">
						<?
							echo $arColumn["name"];
						endif;
						?>
							</td>
					<?endforeach;?>

					<td class="margin"></td>
				</tr>
			</thead>

			<tbody>
				<?foreach ($arResult["GRID"]["ROWS"] as $k => $arData):?>
				<tr>
					<td class="margin"></td>
					<?
					if ($bShowNameWithPicture):
					?>
						<td class="itemphoto">
							<div class="bx_ordercart_photo_container">
								<?
								if (strlen($arData["data"]["PREVIEW_PICTURE_SRC"]) > 0):
									$url = $arData["data"]["PREVIEW_PICTURE_SRC"];
								elseif (strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0):
									$url = $arData["data"]["DETAIL_PICTURE_SRC"];
								else:
									$url = $templateFolder."/images/no_photo.png";
								endif;

								if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["data"]["DETAIL_PAGE_URL"] ?>"><?endif;?>
									<div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
								<?if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
							</div>
							<?
							if (!empty($arData["data"]["BRAND"])):
							?>
								<div class="bx_ordercart_brand">
									<img alt="" src="<?=$arData["data"]["BRAND"]?>" />
								</div>
							<?
							endif;
							?>
						</td>
					<?
					endif;

					// prelimenary check for images to count column width
					foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn)
					{
						$arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData["data"];
						if (is_array($arItem[$arColumn["id"]]))
						{
							foreach ($arItem[$arColumn["id"]] as $arValues)
							{
								if ($arValues["type"] == "image")
									$imgCount++;
							}
						}
					}

					foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn):

						$class = ($arColumn["id"] == "PRICE_FORMATED") ? "price" : "";

						if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES"))) // some values are not shown in columns in this template
							continue;

						if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
							continue;

						$arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData["data"];

						if ($arColumn["id"] == "NAME"):
							$width = 70 - ($imgCount * 20);
						?>
							<td class="item" style="width:<?=$width?>%">

								<h2 class="bx_ordercart_itemtitle">
									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
										<?=$arItem["NAME"]?>
									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
								</h2>

								<div class="bx_ordercart_itemart">
									<?
									if ($bPropsColumn):
										foreach ($arItem["PROPS"] as $val):
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
																	if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
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
						elseif ($arColumn["id"] == "PRICE_FORMATED"):
						?>
							<td class="price right">
								<div class="current_price"><?=$arItem["PRICE_FORMATED"]?></div>
								<div class="old_price right">
									<?
									if (doubleval($arItem["DISCOUNT_PRICE"]) > 0):
										echo SaleFormatCurrency($arItem["PRICE"] + $arItem["DISCOUNT_PRICE"], $arItem["CURRENCY"]);
										$bUseDiscount = true;
									endif;
									?>
								</div>

								<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
									<div style="text-align: left">
										<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
										<div class="type_price_value"><?=$arItem["NOTES"]?></div>
									</div>
								<?endif;?>
							</td>
						<?
						elseif ($arColumn["id"] == "DISCOUNT"):
						?>
							<td class="custom right">
								<span><?=getColumnName($arColumn)?>:</span>
								<?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
							</td>
						<?
						elseif ($arColumn["id"] == "DETAIL_PICTURE" && $bPreviewPicture):
						?>
							<td class="itemphoto">
								<div class="bx_ordercart_photo_container">
									<?
									$url = "";
									if ($arColumn["id"] == "DETAIL_PICTURE" && strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0)
										$url = $arData["data"]["DETAIL_PICTURE_SRC"];

									if ($url == "")
										$url = $templateFolder."/images/no_photo.png";

									if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["data"]["DETAIL_PAGE_URL"] ?>"><?endif;?>
										<div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
									<?if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
								</div>
							</td>
						<?
						elseif (in_array($arColumn["id"], array("QUANTITY", "WEIGHT_FORMATED", "DISCOUNT_PRICE_PERCENT_FORMATED", "SUM"))):
						?>
							<td class="custom right">
								<span><?=getColumnName($arColumn)?>:</span>
								<?=$arItem[$arColumn["id"]]?>
							</td>
						<?
						else: // some property value

							if (is_array($arItem[$arColumn["id"]])):

								foreach ($arItem[$arColumn["id"]] as $arValues)
									if ($arValues["type"] == "image")
										$columnStyle = "width:20%";
							?>
							<td class="custom" style="<?=$columnStyle?>">
								<span><?=getColumnName($arColumn)?>:</span>
								<?
								foreach ($arItem[$arColumn["id"]] as $arValues):
									if ($arValues["type"] == "image"):
									?>
										<div class="bx_ordercart_photo_container">
											<div class="bx_ordercart_photo" style="background-image:url('<?=$arValues["value"]?>')"></div>
										</div>
									<?
									else: // not image
										echo $arValues["value"]."<br/>";
									endif;
								endforeach;
								?>
							</td>
							<?
							else: // not array, but simple value

								echo $arItem[$arColumn["id"]];

							endif;
						endif;

					endforeach;
					?>
				</tr>
				<?endforeach;?>
			</tbody>
		</table>
	</div>

	<div class="bx_ordercart_order_pay">
		<div class="bx_ordercart_order_pay_right">

			<table class="bx_ordercart_order_sum">
				<tbody>
					<tr>
						<td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_WEIGHT_SUM")?></td>
						<td class="custom_t2" class="price"><?=$arResult["ORDER_WEIGHT_FORMATED"]?></td>
					</tr>
					<tr>
						<td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_SUMMARY")?></td>
						<td class="custom_t2" class="price"><?=$arResult["ORDER_PRICE_FORMATED"]?></td>
					</tr>
					<?
					if (doubleval($arResult["DISCOUNT_PRICE"]) > 0)
					{
						?>
						<tr>
							<td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_DISCOUNT")?><?if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"])>0):?> (<?echo $arResult["DISCOUNT_PERCENT_FORMATED"];?>)<?endif;?>:</td>
							<td class="custom_t2" class="price"><?echo $arResult["DISCOUNT_PRICE_FORMATED"]?></td>
						</tr>
						<?
					}
					if(!empty($arResult["arTaxList"]))
					{
						foreach($arResult["arTaxList"] as $val)
						{
							?>
							<tr>
								<td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=$val["NAME"]?> <?=$val["VALUE_FORMATED"]?>:</td>
								<td class="custom_t2" class="price"><?=$val["VALUE_MONEY_FORMATED"]?></td>
							</tr>
							<?
						}
					}
					if (doubleval($arResult["DELIVERY_PRICE"]) > 0)
					{
						?>
						<tr>
							<td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_DELIVERY")?></td>
							<td class="custom_t2" class="price"><?=$arResult["DELIVERY_PRICE_FORMATED"]?></td>
						</tr>
						<?
					}
					if (strlen($arResult["PAYED_FROM_ACCOUNT_FORMATED"]) > 0)
					{
						?>
						<tr>
							<td class="custom_t1" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_PAYED")?></td>
							<td class="custom_t2" class="price"><?=$arResult["PAYED_FROM_ACCOUNT_FORMATED"]?></td>
						</tr>
						<?
					}

					if ($bUseDiscount):
					?>
						<tr>
							<td class="custom_t1 fwb" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_IT")?></td>
							<td class="custom_t2 fwb" class="price"><?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></td>
						</tr>
						<tr>
							<td class="custom_t1" colspan="<?=$colspan?>"></td>
							<td class="custom_t2" style="text-decoration:line-through; color:#828282;"><?=$arResult["PRICE_WITHOUT_DISCOUNT"]?></td>
						</tr>
					<?
					else:
					?>
						<tr>
							<td class="custom_t1 fwb" colspan="<?=$colspan?>" class="itog"><?=GetMessage("SOA_TEMPL_SUM_IT")?></td>
							<td class="custom_t2 fwb" class="price"><?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></td>
						</tr>
					<?
					endif;
					?>
				</tbody>
			</table>
			<div style="clear:both;"></div>

		</div>
		<div style="clear:both;"></div>
	</div>
	*/?>
	<?/*
		<div class="bx_section">
			<h4><?=GetMessage("SOA_TEMPL_SUM_COMMENTS")?></h4>
			<div class="bx_block w100"><textarea name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION" style="max-width:100%;min-height:120px"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea></div>
			<input type="hidden" name="" value="">
			<div style="clear: both;"></div><br />
		</div>
	*/?>