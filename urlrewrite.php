<?
$arUrlRewrite = array(
	array(
		"CONDITION" => "#^/en/production/catalog_online/led_drivers/(.*)/(.*)#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/en/production/catalog_online/led_drivers/detail.php",
	),
	array(
		"CONDITION" => "#^/production/catalog_online/draivery/(.*)/(.*)#",
		"RULE" => "ELEMENT_CODE=\$1",
		"ID" => "",
		"PATH" => "/production/catalog_online/draivery/detail.php",
	),
	array(
		"CONDITION" => "#^/en/production/catalog_online/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/en/production/catalog_online/index.php",
	),
	array(
		"CONDITION" => "#^/de/production/catalog_online/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/de/production/catalog_online/index.php",
	),
	array(
		"CONDITION" => "#^/production/catalog_online/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/production/catalog_online/index.php",
	),
	array(
		"CONDITION" => "#^/de/distributors/regions/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/de/distributors/regions/index.php",
	),
	array(
		"CONDITION" => "#^/bitrix/services/ymarket/#",
		"RULE" => "",
		"ID" => "",
		"PATH" => "/bitrix/services/ymarket/index.php",
	),
	array(
		"CONDITION" => "#^/en/distributors/regions/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/en/distributors/regions/index.php",
	),
	array(
		"CONDITION" => "#^/distributors/regions/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/distributors/regions/index.php",
	),
	array(
		"CONDITION" => "#^/de/news/newsletter/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/de/news/newsletter/index.php",
	),
	array(
		"CONDITION" => "#^/en/news/newsletter/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/en/news/newsletter/index.php",
	),
	array(
		"CONDITION" => "#^/en/personal/order/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.order",
		"PATH" => "/en/personal/order/index.php",
	),
	array(
		"CONDITION" => "#^/de/personal/order/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.order",
		"PATH" => "/de/personal/order/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/draivery/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/catalog/draivery/index.php",
	),
	array(
		"CONDITION" => "#^/news/newsletter/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/news/newsletter/index.php",
	),
	array(
		"CONDITION" => "#^/personal/order/#",
		"RULE" => "",
		"ID" => "bitrix:sale.personal.order",
		"PATH" => "/personal/order/index.php",
	),
	array(
		"CONDITION" => "#^/news/reviews/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/de/news/reviews/index.php",
	),
	array(
		"CONDITION" => "#^/news/reviews/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/en/news/reviews/index.php",
	),
	array(
		"CONDITION" => "#^/news/reviews/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/news/reviews/index.php",
	),
	array(
		"CONDITION" => "#^/en/catalog/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/en/catalog/index.php",
	),
	array(
		"CONDITION" => "#^/de/catalog/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/de/catalog/index.php",
	),
	array(
		"CONDITION" => "#^/portfolio/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/portfolio/index.php",
	),
	array(
		"CONDITION" => "#^/de/store/#",
		"RULE" => "",
		"ID" => "bitrix:catalog.store",
		"PATH" => "/de/store/index.php",
	),
	array(
		"CONDITION" => "#^/en/store/#",
		"RULE" => "",
		"ID" => "bitrix:catalog.store",
		"PATH" => "/en/store/index.php",
	),
	array(
		"CONDITION" => "#^/en/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/en/news/index.php",
	),
	array(
		"CONDITION" => "#^/de/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/de/news/index.php",
	),
	array(
		"CONDITION" => "#^/catalog/#",
		"RULE" => "",
		"ID" => "bitrix:catalog",
		"PATH" => "/catalog/index.php",
	),
	array(
		"CONDITION" => "#^/store/#",
		"RULE" => "",
		"ID" => "bitrix:catalog.store",
		"PATH" => "/store/index.php",
	),
	array(
		"CONDITION" => "#^/news/#",
		"RULE" => "",
		"ID" => "bitrix:news",
		"PATH" => "/news/index.php",
	),
	array(
		"CONDITION" => "#^/#",
		"RULE" => "",
		"ID" => "bitrix:iblock.element.add.form",
		"PATH" => "/bitrix/templates/eshop_adapt_/components/bitrix/catalog/portfolio_catalog/sections.php",
	),
);

?>