<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?>
<div id="content" class="whole_page basket">
	<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "eshop_adapt", array(
			"START_FROM" => "1",
			"PATH" => "",
			"SITE_ID" => "-"
		),
		false,
		Array('HIDE_ICONS' => 'Y')
	);?>
	<h1>Корзина</h1>
	<div id="print">Печатная версия</div>
	<div class="clear"></div>
	<div id="add_new_item_to_cart">
		<div class="title">Добавить новую товарную позицию в заказ</div>
		<a id="go_to_catalog" href="/catalog/">Вернуться в он-лайн каталог</a>
		<div id="search_complete">
			<input type="text" value="Быстрый поиск товара" item_id="" iblock_id="" />
			<div id="search_complete_list"></div>
		</div>
		<input type="submit" value="Добавить к заказу" />
		<div class="clear"></div>
	</div>
	<div id="basket_body">
		<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "basket_new", array(
			"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
			"COLUMNS_LIST" => array(
				0 => "NAME",
				1 => "PROPS",
				2 => "PRICE",
				3 => "QUANTITY",
				4 => "DELETE",
				5 => "DELAY",
				6 => "DISCOUNT",
			),
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"PATH_TO_ORDER" => "/personal/order/make/",
			"HIDE_COUPON" => "N",
			"QUANTITY_FLOAT" => "N",
			"PRICE_VAT_SHOW_VALUE" => "Y",
			"SET_TITLE" => "Y",
			"AJAX_OPTION_ADDITIONAL" => "",
			"OFFERS_PROPS" => array(),
			),
			false
		);?>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>