<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Видеоролики о производстве источников питания светодиодов (LED драйверов), преимуществах энергоэффективных антивандальных светодиодных светильников производства Аргос-Трейд, определение пульсаций светового потока эксплуатируемого светильника");
$APPLICATION->SetPageProperty("keywords", "антивандальные светильники, led драйверы, определение пульсаций, световой поток");
$APPLICATION->SetPageProperty("title", "Видеоролики о производстве LED драйверов Аргос-Трейд, об антивандальных светильниках, о пульсациях светового потока в светильниках");
$APPLICATION->SetTitle("Видеоролики о производстве LED драйверов Аргос-Трейд, об антивандальных светильниках, о пульсациях светового потока в светильниках");?>

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
			"ROOT_MENU_TYPE" => "vert_about",
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
		<h1>Видео</h1>
		<div id="print">Печатная версия</div>
		<div class="clear"></div>
		<?
		$iblock_id=29; 
		$code='VIDEO_RU';
		if(CModule::IncludeModule("iblock"))
		{
			$arSelect = array("ID", "NAME", "PROPERTY_VIDEO", "CODE");
			$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "CODE"=>$code), $arSelect);
			while($res=$ar_result->GetNext())
			{
				if($res['PROPERTY_VIDEO_VALUE']!=Array())
				{
					/*?><pre><?print_r($res['PROPERTY_VIDEO_VALUE'])?></pre><?*/
					?>
					<div style="width:640px;">
						<h3 class="hvideo"><?=$res['PROPERTY_VIDEO_VALUE']['title']?></h3>
						<p class="dvideo"><?=$res['PROPERTY_VIDEO_VALUE']['desc']?></p>
						<?
						$APPLICATION->IncludeComponent("bitrix:player","",Array(
							"PLAYER_TYPE" => "auto",
							"USE_PLAYLIST" => "N",
							"PATH" => $res['PROPERTY_VIDEO_VALUE']['path'],//Путь к файлу
							"WIDTH" => "640"/*$res['PROPERTY_VIDEO_VALUE']['width']*/,//Указывается ширина окна плеера в пикселях
							"HEIGHT" => "360"/*$res['PROPERTY_VIDEO_VALUE']['height']*/,//Указывается высота окна плеера в пикселях
							"FILE_TITLE" => $res['PROPERTY_VIDEO_VALUE']['title'],//Указывается заголовок ролика
							"FILE_AUTHOR" => $res['PROPERTY_VIDEO_VALUE']['author'],//Указывается автор ролика
							"FILE_DATE" => $res['PROPERTY_VIDEO_VALUE']['date'],//Указывается дата публикации видео
							"FILE_DESCRIPTION" => $res['PROPERTY_VIDEO_VALUE']['desc'],//Произвольное текстовое описание ролика
							"SKIN_PATH" => "/bitrix/components/bitrix/player/mediaplayer/skins",
							"CONTROLBAR" => "bottom",//Указывается расположение панели управления плеера (over none bottom)
							"WMODE_WMV" => "window",
							"VOLUME" => "90",//Указывается уровень громкости звука в процентах от максимального заданного в систем
							"HIGH_QUALITY" => "Y",
							"ADVANCED_MODE_SETTINGS" => "Y",
							"ALLOW_SWF" => "Y",
							"PLAYLIST_DIALOG" => "",
							/*"PROVIDER" => "video",//Указывается медиа-провайдер потокового видео:
							"STREAMER" => "",//Указывается приложение на сервере для потокового видео						
							"PREVIEW" => "",//Задается путь к рисунку заставки для предварительного просмотра						
							"FILE_DURATION" => "",//Указывается продолжительность ролика в секундах
							"SKIN" => "bitrix.swf",//Указывается путь к папке со скинами Flash плеера
							"WMODE" => "window",//Указывается режим окна Flash плеера
							"PLAYLIST" => "right",
							"PLAYLIST_SIZE" => "180",
							"LOGO" => "/logo.png",
							"LOGO_LINK" => "",
							"LOGO_POSITION" => "bottom-left",
							"PLUGINS" => array("tweetit-1", "fbit-1"),
							"PLUGINS_TWEETIT-1" => "tweetit.link=",
							"PLUGINS_FBIT-1" => "fbit.link=",
							"ADDITIONAL_FLASHVARS" => "",						
							"SHOW_CONTROLS" => "Y",//При отмеченной опции будет отображаться панель управления плеером
							"PLAYLIST_TYPE" => "auto",//Указывается тип плеера
							"PLAYLIST_PREVIEW_WIDTH" => "64",
							"PLAYLIST_PREVIEW_HEIGHT" => "48",
							"SHOW_DIGITS" => "Y",//При отмеченной опции будет показано текущее и оставшееся время воспроизведения ролика
							"CONTROLS_BGCOLOR" => "a01f1b",//Указывается код цвета для фона панели управления плеера
							"CONTROLS_COLOR" => "000000",//Указывается код цвета для элементов управления плеера
							"CONTROLS_OVER_COLOR" => "000000",//Указывается код цвета для элементов управления плеера при наведении указателя мыши
							"SCREEN_COLOR" => "000000",//Указывается код цвета для экрана плеера
							"AUTOSTART" => "N",//При отмеченной опции проигрывание медиафайла(ов) будет начато сразу после загрузки страницы
							"REPEAT" => "list",//Указывается вариант повтора при проигрывании медиафайла(ов) или списка воспроизведения						
							"MUTE" => "N",						
							"SHUFFLE" => "N",
							"START_ITEM" => "1",						
							"PLAYER_ID" => "",
							"BUFFER_LENGTH" => "10",
							"DOWNLOAD_LINK" => "http://ваш_сайт.com/video.flv",
							"DOWNLOAD_LINK_TARGET" => "_self",
							"ADDITIONAL_WMVVARS" => "",*/
							)
						);
						?>
						<a class="video_under" href="<?=$res['PROPERTY_VIDEO_VALUE']['path']?>" download>Скачать</a>
					</div>
					<?
				}
			}
		}
		?>
		<?/*<h3 class="hvideo">Definition of the Luminous Flux Pulsations</h3>
		<video width="400" height="200" controls="controls" poster="video/duel.jpg" class="videopage_el">
		   <source src="/bitrix/templates/eshop_adapt_/multimedia/argos_puls_eng.ogv" type='video/ogg; codecs="theora, vorbis"'>
		   <source src="/bitrix/templates/eshop_adapt_/multimedia/argos_puls_eng.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
		   <!--<source src="/bitrix/templates/eshop_adapt_/multimedia/argos_puls_eng.webm" type='video/webm; codecs="vp8, vorbis"'>-->
		   tag video is not supported. 
		   <a style="color: white" href="/bitrix/templates/eshop_adapt_/multimedia/argos_puls_eng.mp4" download>download</a>.
		</video>
		<a class="video_under" href="/bitrix/templates/eshop_adapt_/multimedia/argos_puls_eng.mp4" download>Download</a>.
		<h3 class="hvideo">ARGOS-ELECTRON Factory</h3>
		<video width="400" height="200" controls="controls" poster="video/duel.jpg" class="videopage_el">
		   <source src="/bitrix/templates/eshop_adapt_/multimedia/argos_eng_2014.ogv" type='video/ogg; codecs="theora, vorbis"'>
		   <source src="/bitrix/templates/eshop_adapt_/multimedia/argos_eng_2014.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
		   <!--<source src="/bitrix/templates/eshop_adapt_/multimedia/argos_eng_2014.webm" type='video/webm; codecs="vp8, vorbis"'>-->
		   tag video is not supported. 
		   <a style="color: white" href="/bitrix/templates/eshop_adapt_/multimedia/argos_eng_2014.mp4" download>download</a>.
		</video>
		<a class="video_under" href="/bitrix/templates/eshop_adapt_/multimedia/argos_eng_2014.mp4" download>Download</a>.*/?>
	</div>
	<div class="clear"></div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php")?>