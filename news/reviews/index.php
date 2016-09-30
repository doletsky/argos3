<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отзывы");?>

<?$iblock_id=20;?>
<div id="content">
	<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "eshop_adapt", array(
			"START_FROM" => "1",
			"PATH" => "",
			"SITE_ID" => "-"
		),
		false,
		Array('HIDE_ICONS' => 'Y')
	);?>
	<div class="content_left">
		<!-- Vertical menu -->
		<?$APPLICATION->IncludeComponent("bitrix:menu", "tree_vertical", array(
			"ROOT_MENU_TYPE" => "vert_news",
			"MENU_CACHE_TYPE" => "A",
			"MENU_CACHE_TIME" => "36000000",
			"MENU_CACHE_USE_GROUPS" => "Y",
			"MENU_CACHE_GET_VARS" => array(),
			"MAX_LEVEL" => "2",
			"CHILD_MENU_TYPE" => "podmenu",
			"USE_EXT" => "N",
			"ALLOW_MULTI_SELECT" => "N"
			),
			false
		);
		?>
		<?include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."sidebar.php");?>
	</div>
	<div class="content_right">
		<h1>Отзывы</h1>
		<a href="#reviews_block" id="btn_add_review" class="ancLinks">Добавить свой отзыв</a>
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
		<?
		//Получаем страницу, с которой был совершен переход, для фильтрафии отзывов
		if(isset($_GET['page']))
			$page=$_GET['page'];
		else
			$page='all';
		if($page!='all')
		{
			$arrFilter = array(
				"PROPERTY_PAGE" => $page,
			);
		}
		?>
		<?$APPLICATION->IncludeComponent("bitrix:catalog", "reviews_catalog", array(
			"IBLOCK_TYPE" => "content",
			"IBLOCK_ID" => $iblock_id,
			"HIDE_NOT_AVAILABLE" => "N",
			"BASKET_URL" => "/personal/cart/",
			"ACTION_VARIABLE" => "action",
			"PRODUCT_ID_VARIABLE" => "id",
			"SECTION_ID_VARIABLE" => "SECTION_ID",
			"PRODUCT_QUANTITY_VARIABLE" => "quantity",
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"SEF_MODE" => "Y",
			"SEF_FOLDER" => "/news/reviews/",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"SET_TITLE" => "Y",
			"SET_STATUS_404" => "Y",
			"USE_ELEMENT_COUNTER" => "Y",
			"USE_FILTER" => "Y",
			"FILTER_NAME" => "arrFilter",
			"FILTER_FIELD_CODE" => array(
				0 => "",
				1 => "",
			),
			"FILTER_PROPERTY_CODE" => array(
				0 => "",
				1 => "",
			),
			"FILTER_PRICE_CODE" => array(
				0 => "BASE",
			),
			"FILTER_VIEW_MODE" => "VERTICAL",
			"USE_REVIEW" => "Y",
			"MESSAGES_PER_PAGE" => "10",
			"USE_CAPTCHA" => "Y",
			"REVIEW_AJAX_POST" => "Y",
			"PATH_TO_SMILE" => "/bitrix/images/forum/smile/",
			"FORUM_ID" => "1",
			"URL_TEMPLATES_READ" => "",
			"SHOW_LINK_TO_FORUM" => "Y",
			"POST_FIRST_MESSAGE" => "N",
			"USE_COMPARE" => "N",
			"PRICE_CODE" => array(
				0 => "BASE",
			),
			"USE_PRICE_COUNT" => "N",
			"SHOW_PRICE_COUNT" => "1",
			"PRICE_VAT_INCLUDE" => "Y",
			"PRICE_VAT_SHOW_VALUE" => "N",
			"PRODUCT_PROPERTIES" => array(
			),
			"USE_PRODUCT_QUANTITY" => "Y",
			"CONVERT_CURRENCY" => "Y",
			"CURRENCY_ID" => "RUB",
			"SHOW_TOP_ELEMENTS" => "N",
			"SECTION_COUNT_ELEMENTS" => "N",
			"SECTION_TOP_DEPTH" => "1",
			"SECTIONS_VIEW_MODE" => "TEXT",
			"SECTIONS_SHOW_PARENT_NAME" => "Y",
			"PAGE_ELEMENT_COUNT" => "15",
			"LINE_ELEMENT_COUNT" => "1",
			"ELEMENT_SORT_FIELD" => "sort",
			"ELEMENT_SORT_ORDER" => "asc",
			"ELEMENT_SORT_FIELD2" => "id",
			"ELEMENT_SORT_ORDER2" => "desc",
			"LIST_PROPERTY_CODE" => array(
				0 => "",
				1 => "NEWPRODUCT",
				2 => "SALELEADER",
				3 => "SPECIALOFFER",
				4 => "",
			),
			"INCLUDE_SUBSECTIONS" => "N",
			"LIST_META_KEYWORDS" => "-",
			"LIST_META_DESCRIPTION" => "-",
			"LIST_BROWSER_TITLE" => "-",
			"DETAIL_PROPERTY_CODE" => array(
				0 => "",
				1 => "NEWPRODUCT",
				2 => "MANUFACTURER",
				3 => "MATERIAL",
				4 => "CATALOG_TYPE",
				5 => "",
			),
			"DETAIL_META_KEYWORDS" => "-",
			"DETAIL_META_DESCRIPTION" => "-",
			"DETAIL_BROWSER_TITLE" => "-",
			"LINK_IBLOCK_TYPE" => "",
			"LINK_IBLOCK_ID" => "",
			"LINK_PROPERTY_SID" => "",
			"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
			"USE_ALSO_BUY" => "Y",
			"ALSO_BUY_ELEMENT_COUNT" => "3",
			"ALSO_BUY_MIN_BUYES" => "2",
			"USE_STORE" => "Y",
			"USE_STORE_PHONE" => "Y",
			"USE_STORE_SCHEDULE" => "Y",
			"USE_MIN_AMOUNT" => "N",
			"STORE_PATH" => "/store/#store_id#",
			"MAIN_TITLE" => "Наличие на складах",
			"PAGER_TEMPLATE" => "arrows_news",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "Товары",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
			"PAGER_SHOW_ALL" => "N",
			"ADD_PICT_PROP" => "-",
			"LABEL_PROP" => "-",
			"SHOW_DISCOUNT_PERCENT" => "Y",
			"SHOW_OLD_PRICE" => "Y",
			"DETAIL_SHOW_MAX_QUANTITY" => "N",
			"MESS_BTN_BUY" => "Купить",
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",
			"MESS_BTN_COMPARE" => "Сравнение",
			"MESS_BTN_DETAIL" => "Подробнее",
			"MESS_NOT_AVAILABLE" => "Нет в наличии",
			"DETAIL_USE_VOTE_RATING" => "Y",
			"DETAIL_VOTE_DISPLAY_AS_RATING" => "rating",
			"DETAIL_USE_COMMENTS" => "Y",
			"DETAIL_BLOG_USE" => "Y",
			"DETAIL_VK_USE" => "N",
			"DETAIL_FB_USE" => "Y",
			"DETAIL_FB_APP_ID" => "",
			"DETAIL_BRAND_USE" => "Y",
			"DETAIL_BRAND_PROP_CODE" => "",
			"AJAX_OPTION_ADDITIONAL" => "",
			"SEF_URL_TEMPLATES" => array(
				"sections" => "",
				"section" => "#SECTION_CODE#/",
				"element" => "#SECTION_CODE#/#ELEMENT_CODE#/",
				"compare" => "compare/",
			)
			),
			false
		);?>
		<?/*		
		<div class="navigation_news_bott">
			<span class="nav_title">Страницы:</span>
			<a href="/" class="btn_first">Первая</a>
			<a href="/" class="btn_prev"></a>
			<a href="/" class="btn_page current">1</a>
			<a href="/" class="btn_page">2</a>
			<a href="/" class="btn_page">3</a>
			<a href="/" class="btn_next"></a>
			<a href="/" class="btn_last">Последняя</a>
		</div>
		<div class="clear"></div>		
		*/?>
		<div id="reviews_block">
			<div class="reviews_title">Оставить отзыв</div>
			<div id="reviews_form">
				<div class="reviews_content">
					<?$APPLICATION->IncludeComponent("bitrix:iblock.element.add.form", "reviews_form", Array(
						"SEF_MODE" => "Y",	// Включить поддержку ЧПУ
						"IBLOCK_TYPE" => "content",	// Тип инфоблока
						"IBLOCK_ID" => $iblock_id,	// Инфоблок
						"PROPERTY_CODES" => array(	// Свойства, выводимые на редактирование
							0 => "NAME",
							1 => "196",
							2 => "197",
							3 => "195",
							4 => "198",
							5 => "199",
							6 => "296",
							7 => "DETAIL_TEXT",
						),
						"PROPERTY_CODES_REQUIRED" => array(	// Свойства, обязательные для заполнения
							0 => "NAME",
							1 => "196",
							2 => "197",
							3 => "195",
							4 => "198",
							5 => "DETAIL_TEXT",
						),
						"GROUPS" => array(	// Группы пользователей, имеющие право на добавление/редактирование
							0 => "2",//все пользователи
						),
						"STATUS_NEW" => "2",	// Статус после сохранения
						"STATUS" => array(	// Редактирование возможно для статуса
							0 => "2",
						),
						"LIST_URL" => "",	// Страница со списком своих элементов
						"ELEMENT_ASSOC" => "PROPERTY_ID",	// Привязка к пользователю
						"ELEMENT_ASSOC_PROPERTY" => "",	// по свойству инфоблока -->
						"MAX_USER_ENTRIES" => "100000",	// Ограничить кол-во элементов для одного пользователя
						"MAX_LEVELS" => "100000",	// Ограничить кол-во рубрик, в которые можно добавлять элемент
						"LEVEL_LAST" => "Y",	// Разрешить добавление только на последний уровень рубрикатора
						"USE_CAPTCHA" => "Y",	// Использовать CAPTCHA
						"USER_MESSAGE_EDIT" => "",	// Сообщение об успешном сохранении
						"USER_MESSAGE_ADD" => "",	// Сообщение об успешном добавлении
						"DEFAULT_INPUT_SIZE" => "30",	// Размер полей ввода
						"RESIZE_IMAGES" => "Y",	// Использовать настройки инфоблока для обработки изображений
						"MAX_FILE_SIZE" => "0",	// Максимальный размер загружаемых файлов, байт (0 - не ограничивать)
						"PREVIEW_TEXT_USE_HTML_EDITOR" => "Y",	// Использовать визуальный редактор для редактирования текста анонса
						"DETAIL_TEXT_USE_HTML_EDITOR" => "Y",	// Использовать визуальный редактор для редактирования подробного текста
						"CUSTOM_TITLE_NAME" => "ФИО",	// * наименование *
						"CUSTOM_TITLE_TAGS" => "",	// * теги *
						"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",	// * дата начала *
						"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",	// * дата завершения *
						"CUSTOM_TITLE_IBLOCK_SECTION" => "",	// * раздел инфоблока *
						"CUSTOM_TITLE_PREVIEW_TEXT" => "",	// * текст анонса *
						"CUSTOM_TITLE_PREVIEW_PICTURE" => "",	// * картинка анонса *
						"CUSTOM_TITLE_DETAIL_TEXT" => "Отзыв",	// * подробный текст *
						"CUSTOM_TITLE_DETAIL_PICTURE" => "",	// * подробная картинка *
						"SEF_FOLDER" => "/",	// Каталог ЧПУ (относительно корня сайта)
						"VARIABLE_ALIASES" => ""
						),
						false
					);?>
				</div>
			</div>
		</div>
		<?/*
		<div id="reviews_block">
			<div class="reviews_title">Оставить отзыв</div>				
			<div id="reviews_form">
				<div class="reviews_content">
					<div class="field_title">ФИО *</div>
					<div class="field_text">
						<input type="text" />
					</div>
					<div class="clear"></div>
					<div class="field_title">Должность *</div>
					<div class="field_text">
						<input type="text" />
					</div>
					<div class="clear"></div>
					<div class="field_title">Компания *</div>
					<div class="field_text">
						<input type="text" />
					</div>
					<div class="clear"></div>
					<div class="field_title">Е-mail *</div>
					<div class="field_text">
						<input type="text" />
					</div>
					<div class="clear"></div>
					<div class="pseudo_check check marg_check reviews">Согласие на рассылку</div>
					<div class="field_title">Телефон * <span>(рабочий или мобильный)</span></div>
					<div class="field_text">
						<input type="text" />
					</div>
					<div class="clear"></div>
					<div class="field_title">Сайт</div>
					<div class="field_text">
						<input type="text" />
					</div>
					<div class="clear"></div>
					<div class="field_title">Отзыв *</div>
					<div class="field_text reviews">
						<textarea></textarea>
					</div>
					<div class="clear"></div>
					<div class="field_title">Код *</div>
					<img src="/bitrix/templates/eshop_adapt_/images/new_images/captcha_img.jpg" class="captcha" />
					<div class="field_text">
						<input class="min" type="text" />
					</div>
					<div class="clear"></div>
					<input type="submit" value="Отправить отзыв" />
				</div>
			</div>
		</div>
		*/?>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>