<div class="multimedia_body">
	<?
	/*$links_video=$arResult['PROPERTIES']['MULTIMEDIA_VIDEO_YOUTUBE']['VALUE'];	
	if($links_video)
	{
		foreach ($links_video as $link_video_id)
		{
		?>
			<div style="margin:0 auto; margin-bottom:30px; width:640px;">
				<iframe width="640" height="360" src="//www.youtube.com/embed/<?=$link_video_id?>" frameborder="0" allowfullscreen></iframe>
			</div>
		<?
		}
	}*/
	$links_video=$arResult['PROPERTIES']['MULTIMEDIA_VIDEO']['VALUE'];	
	if($links_video)
	{
		foreach ($links_video as $video)
		{
			if($video) {
			?>
				<div style="margin:0 auto; width:640px;">
					<h3 class="hvideo"><?=$video['title']?></h3>
					<p class="dvideo"><?=$video['desc']?></p>
					<?
					$APPLICATION->IncludeComponent("bitrix:player","",Array(
						"PLAYER_TYPE" => "auto",
						"USE_PLAYLIST" => "N",
						"PATH" => $video['path'],//Путь к файлу
						"WIDTH" => "640"/*$video['width']*/,//Указывается ширина окна плеера в пикселях
						"HEIGHT" => "360"/*$video['height']*/,//Указывается высота окна плеера в пикселях
						"FILE_TITLE" => $video['title'],//Указывается заголовок ролика
						"FILE_AUTHOR" => $video['author'],//Указывается автор ролика
						"FILE_DATE" => $video['date'],//Указывается дата публикации видео
						"FILE_DESCRIPTION" => $video['desc'],//Произвольное текстовое описание ролика
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
					<a class="video_under" href="<?=$video['path']?>" download>Скачать</a>
				</div>
				<?
			}
		}
	}
	?>
	<div class="include_area">
		<?
		$include_area=$arResult['PROPERTIES']['MULTIMEDIA_VIDEO_INCLUDE']['VALUE']['TEXT'];
		if($include_area)
		{
			echo '<div class="include_area_wrap">'.htmlspecialchars_decode($include_area).'</div>';
		}
		?>
	</div>
</div>