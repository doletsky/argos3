<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//ШАБЛОН КАРТОЧКИ ТОВАРА НОВЫЙ ВИД ПО ПРЕДЛОЖЕНИЯМ?>

<div id="header" class="min">
	<div id="menu_new_wrap">
		<ul id="menu_new">
			<li<?if(isset($_GET['tab']) && $_GET['tab']=='1' || !isset($_GET['tab']))echo' class="current"'?>><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=1">Технические характеристики</a></li>
			<li<?if(isset($_GET['tab']) && $_GET['tab']=='2')echo' class="current"'?>><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=2">Протоколы испытаний</a></li>
			<li<?if(isset($_GET['tab']) && $_GET['tab']=='3')echo' class="current"'?>><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3">Сертификаты</a></li>
			<li<?if(isset($_GET['tab']) && $_GET['tab']=='4')echo' class="current"'?>><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=4">Мультимедиа</a></li>
			<li<?if(isset($_GET['tab']) && $_GET['tab']=='5')echo' class="current"'?>><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=5">Портфолио</a></li>
			<li<?if(isset($_GET['tab']) && $_GET['tab']=='6')echo' class="current"'?>><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=6">Он-лайн заказ</a></li>
		</ul>
	</div>
</div>
<div id="content" class="whole_page padd_top_18">
<pre style="display:none;"><?print_r($arResult)?></pre>
	<?
	if(isset($_GET['tab']) && $_GET['tab']=='1' || !isset($_GET['tab']))//Технические характеристики
	{
		foreach($arResult['OFFERS'] as $offers)
		{
			if($offers['ID']==$_GET['offers_id'])
			{
				if($offers['PROPERTIES']['PDF_OFFERS_TECHNICAL_CHARACTERISTICS']["VALUE"]!='')
				{
					$path_file = CFile::GetPath($offers['PROPERTIES']['PDF_OFFERS_TECHNICAL_CHARACTERISTICS']["VALUE"]);//id файла
					?>
						<object data="<?=$path_file?>" type="application/pdf" width="100%" height="1000px;">
							alt: <a href="<?=$path_file?>">Технические характеристики</a>
						</object>
					<?
				}
				else
					echo 'Технические характеристики отсутствуют';
			}
		}
		/*$code=$arResult["VARIABLES"]["ELEMENT_CODE"];
		$iblock_id=$arParams['IBLOCK_ID'];
		$type="IBLOCK_ELEMENT";
		$id_element=getIdByCode($code, $iblock_id, $type);
			
		if(CModule::IncludeModule("iblock"))
		{
			$db_props = CIBlockElement::GetProperty($arParams['IBLOCK_ID'], $id_element, "sort", "asc", Array("CODE"=>"PDF_TECHNICAL_CHARACTERISTICS"));
			if($ar_props = $db_props->Fetch())
			{
				$path_file = CFile::GetPath($ar_props["VALUE"]);//id файла
				?>
				<object data="<?=$path_file?>" type="application/pdf" width="100%" height="1000px;">
					alt: <a href="<?=$path_file?>">Технические характеристики</a>
				</object>
				<?
			}
		}*/
	}
	else if(isset($_GET['tab']) && $_GET['tab']=='2')//Протоколы испытаний
	{
		foreach($arResult['OFFERS'] as $offers)
		{
			if($offers['ID']==$_GET['offers_id'])
			{
				if($offers['PROPERTIES']['PDF_OFFERS_PROTOCOLS']["VALUE"]!='')
				{
					$path_file = CFile::GetPath($offers['PROPERTIES']['PDF_OFFERS_PROTOCOLS']["VALUE"]);//id файла
					?>
						<object data="<?=$path_file?>" type="application/pdf" width="100%" height="1000px;">
							alt: <a href="<?=$path_file?>">Протоколы испытаний</a>
						</object>
					<?
				}
				else
					echo 'Протоколы испытаний отсутствуют';
			}
		}
	}
	else if(isset($_GET['tab']) && $_GET['tab']=='3')//Сертификаты
	{
		foreach($arResult['OFFERS'] as $offers)
		{
			if($offers['ID']==$_GET['offers_id'])
			{
				if($offers['PROPERTIES']['PDF_OFFERS_CERTIFICATES']["VALUE"]!='')
				{
					$path_file = CFile::GetPath($offers['PROPERTIES']['PDF_OFFERS_CERTIFICATES']["VALUE"]);//id файла
					?>
						<object data="<?=$path_file?>" type="application/pdf" width="100%" height="1000px;">
							alt: <a href="<?=$path_file?>">Сертификаты</a>
						</object>
					<?
				}
				else
					echo 'Сертификаты отсутствуют';
			}
		}
	}
	else if(isset($_GET['tab']) && $_GET['tab']=='4')//Мультимедиа
	{
		
	}
	else if(isset($_GET['tab']) && $_GET['tab']=='5')//Портфолио
	{
		
	}
	else if(isset($_GET['tab']) && $_GET['tab']=='6')//Он-лайн заказ
	{
	?>
		<h1><?=$arResult['NAME']?>. Он-лайн заказ</h1>
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
		<p class="text_page_info">Выберите артикул товара, укажите количество и условия отгрузки</p>
		<div class="cart_title">
			<div class="cart_title_td item online">Товар</div>
			<div class="cart_title_td packing">В упаковке</div>
			<div class="cart_title_td quantity">Количество</div>
			<div class="cart_title_td shipping">Условия отгрузки</div>
			<div class="cart_title_td price online">Цена за шт. <span>(с НДС)</span></div>
		</div>
		<div class="cart_items">
			<?
			foreach($arResult['OFFERS'] as $offers)
			{
			?>
			<div class="cart_item">			
				<div class="cart_item_td item online">
					<a href="/" class="name"><?=$offers['NAME']?></a>
					<a href="/" class="passport">паспорт товара</a>
				</div>
				<div class="cart_item_td packing">5 шт.</div>
				<div class="cart_item_td quantity">	
					<div class="item_order">
						<div class="nav_count count_minus"></div>
						<input class="inp_quantity" type="text" value="0" disabled="disabled" name="QUANTITY_<?=$offers['ID']?>" id="QUANTITY_<?=$offers['ID']?>" />
						<div class="nav_count count_plus"></div>
						<div class="clear"></div>
						<a style="display:none;" href="<?echo $arResult["DETAIL_PAGE_URL"]?>?action=ADD2BASKET&id=<?=$offers["ID"]?>&quantity=0" class="addtoCart" onclick="return addToCart(this);" id="catalog_add2cart_link_<?=$offers['ID']?>"><?=GetMessage("CATALOG_BUY")?></a>
						<?
							if(CModule::IncludeModule("sale"))
							{
								$dbBasketItems = CSaleBasket::GetList(false, array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL", "DELAY" => "N","PRODUCT_ID" =>$offers['ID']), false, false, array("ID","QUANTITY", "PRICE"));
								if ($arItems = $dbBasketItems->Fetch())
									$count_items_in_cart=$arItems['QUANTITY']*1;											
								else
									$count_items_in_cart=0;
							}
						?>
						<div class="quantity_item" style="display:none;"><?=$offers['CATALOG_QUANTITY']*1-$count_items_in_cart?></div>
					</div>
				</div>
				<div class="cart_item_td shipping">
					<div class="shipping_wrap">
						<div class="pseudo_radio_wrap">
							<div class="pseudo_radio check"><div class="radio_img"></div><div class="radio_text">в течение 3 дней после оплаты</div></div>
							<div class="btn_show_info"></div>
						</div>
						<div class="pseudo_radio_wrap">
							<div class="pseudo_radio"><div class="radio_img"></div><div class="radio_text">в течение 10 дней после оплаты</div></div>
							<div class="btn_show_info"></div>
						</div>
						<div class="pseudo_radio_wrap">
							<div class="pseudo_radio disabled"><div class="radio_img"></div><div class="radio_text">в течение 60 дней после внесения авансового платежа</div></div>
							<div class="btn_show_info"></div>
							<p class="text_info">(от 5000 шт.)</p>
						</div>
					</div>
				</div>
				<div class="cart_item_td price online"><?=number_format($offers['CATALOG_PRICE_1'], 0, '', ' ')?> руб.<div class="btn_show_info"></div></div>
				<div style="display:none;" class="item_price"><?=$offers['CATALOG_PRICE_1']?></div>
			</div>
			<?}?>
		</div>
		<div id="cost_block_online_order">
			<div class="cost_itogo">Итого: <span id="cost_itogo">0</span> руб.</div>
			<div class="text_info_nds">(в том числе НДС 18%)</div>
			<div class="text_info">В стоимость включена доставка до выбранного вами терминала в Санкт-Петербурге</div>
			<div id="btn_make_order">Сделать заказ</div>
			<div class="clear"></div>
			<div id="addItemInCart">
				<h4>Товар добавлен в корзину</h4>
				<a class="order" href="/personal/cart/">Оформить заказ</a>
				<a href="javascript:void(0)" class="close">Продолжить покупки</a>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
			
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
	<?
	}
	?>
</div>