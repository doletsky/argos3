<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карта сайта");?> 
<div id="content" class="whole_page">
	<?$APPLICATION->IncludeComponent(
		"bitrix:breadcrumb",
		"eshop_adapt",
		Array(
			"START_FROM" => "1",
			"PATH" => "",
			"SITE_ID" => "-"
		),
	false,
	Array(
		'HIDE_ICONS' => 'Y'
	)
	);?> 	 
	<h1>Карта сайта</h1> 	 
	<div id="print">Печатная версия</div>
	<div class="clear"></div>
	<ul id="sitemap_menu">
		<li>
			<a href="/about/">О компании</a>	
			<ul class="lvl2">
				<li><a href="/about/about_argos_trade/">Об Аргос-Трейд</a></li>
				<li><a href="/about/about_argos_electron/">Об Аргос-Электрон</a></li>
				<li><a href="/about/quality_of_products/">Качество продукции</a></li>
				<li><a href="/about/certificates/">Сертификаты</a></li>
				<li><a href="/about/banners_for_partners/">Баннеры для партнеров</a></li>
				<li><a href="/about/career/">Карьера</a></li>
				<li><a href="/about/video/">Видео</a></li>
			</ul>
		</li>
		<li>
			<a href="/news/">Новости</a>	
			<ul class="lvl2">
				<li><a href="/news/newsletter/">Новостная рассылка</a></li>
				<li><a href="/news/mass_media/">СМИ о нас</a></li>
				<li>
					<a href="/news/exhibitions/">Участие в выставках</a>
					<ul class="lvl3">
						<li><a href="/news/exhibitions/exhibitions_coming/">Предстоящие выставки</a></li>
						<li><a href="/news/exhibitions/exhibitions_past/">Прошедшие выставки</a></li>
					</ul>
				</li>
				<li><a href="/news/reviews/">Отзывы</a></li>
				<li><a href="/news/subscribe_news/">Подписка на новости</a></li>
			</ul>
		</li>
		<li>
			<a href="/production/">Продукция</a>	
			<ul class="lvl2">
				<li>
					<a href="/production/catalog_online/">On-line каталог</a>
					<?$APPLICATION->IncludeComponent("bitrix:menu", "tree_vertical_catalog_sitemap", array(
						"ROOT_MENU_TYPE" => "left",
						"MENU_CACHE_TYPE" => "A",
						"MENU_CACHE_TIME" => "36000000",
						"MENU_CACHE_USE_GROUPS" => "Y",
						"MENU_CACHE_GET_VARS" => array(
						),
						"MAX_LEVEL" => "1",
						"CHILD_MENU_TYPE" => "left",
						"USE_EXT" => "Y",
						"DELAY" => "N",
						"ALLOW_MULTI_SELECT" => "N",
						),
						false
					);?>
				</li>
				<li><a href="/production/catalog_pdf/">PDF-каталог</a></li>
				<li><a href="/production/price-list/">Прайс-Лист</a></li>
				<li>
					<a href="/production/support/">Поддержка</a>
					<ul class="lvl3">
						<li><a href="/production/support/technical_information/">Техническая информация</a></li>
						<li><a href="/production/support/faq/">F.A.Q.</a></li>
						<li><a href="/production/support/ask_question/">Задать вопрос</a></li>
						<li><a href="/production/support/useful_literature/">Полезная литература</a></li>
						<li><a href="/production/support/reclamation/">Отправить рекламацию</a></li>
					</ul>
				</li>
			</ul>
		</li>
		<li><a href="/portfolio/">Портфолио</a></li>
		<li>
			<a href="/distributors/partnerships/">Дистрибьюторы</a>	
			<ul class="lvl2">
				<li><a href="/distributors/partnerships/">Партнеры</a></li>
				<li><a href="/distributors/regions/">Регионы</a></li>
			</ul>
		</li>
		<li><a href="/contacts/">Контакты</a></li>
	</ul>
	
 </div>
 
 <?/*$APPLICATION->IncludeComponent("bitrix:main.map", ".default", array(
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SET_TITLE" => "Y",
		"LEVEL" => "5",
		"COL_NUM" => "2",
		"SHOW_DESCRIPTION" => "N"
		),
		false
	);*/?>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>