<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
if ($arResult['PROPERTIES']['FORUM_MESSAGE_CNT']['VALUE'])
    $forum_mess = $arResult['PROPERTIES']['FORUM_MESSAGE_CNT']['VALUE'];
else
    $forum_mess = 0;
?>
<div class="date_new"><?= $arResult["DISPLAY_ACTIVE_FROM"] ?></div>
<a href="#new_comments" class="comments_new"><?= GetMessage("COMMENTS") ?><div class="count"><div class="arrow"></div><?= $forum_mess ?></div></a>

<div class="clear"></div>
<h1 class="news"><?= $arResult["NAME"] ?></h1>
<div class="new_text">
    <? echo $arResult["DETAIL_TEXT"]; ?>
</div>
<div id="print" class="no_float"><?= GetMessage("PRINT_LINK") ?></div>
<?
//    if($USER->IsAdmin()){
//        echo "<pre>";
//        echo count($arResult['PROPERTIES']['VIDEO']['VALUE']);
//        echo "</pre>";
//    }

if (!empty($arResult['PROPERTIES']['VIDEO']['VALUE'][0])) {
    ?>
    <a name="video"></a>
    <div class="new_page_text">Видео:</div>
    <?
    foreach ($arResult['PROPERTIES']['VIDEO']['VALUE'] as $key => $video) {
        ?> 
        <div style="width:640px;margin-bottom:20px;">
            <h3 class="hvideo"><?= $arResult['PROPERTIES']['VIDEO']['DESCRIPTION'][$key] ?></h3>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $video ?>" frameborder="0" allowfullscreen></iframe>
        </div>


        <?
    }
}

if (!empty($arResult['PROPERTIES']['VIDEO_BITRIX']['VALUE']) && !empty($arResult['PROPERTIES']['VIDEO_BITRIX']['VALUE'][0])) {
    foreach ($arResult['PROPERTIES']['VIDEO_BITRIX']['VALUE'] as $video) {
        ?>

        <div style="width:640px;margin-bottom:20px;">
            <h3 class="hvideo"><?= $video['title'] ?></h3>
            <a class="video_under" href="<?= $video['path'] ?>" download><?= GetMessage("DOWNLOAD") ?></a>
            <?php
            $APPLICATION->IncludeComponent("bitrix:player", "", Array(
                "PLAYER_TYPE" => "auto",
                "USE_PLAYLIST" => "N",
                "PATH" => $video['path'], //Путь к файлу
                "WIDTH" => "640"/* $res['PROPERTY_VIDEO_VALUE']['width'] */, //Указывается ширина окна плеера в пикселях
                "HEIGHT" => "360"/* $res['PROPERTY_VIDEO_VALUE']['height'] */, //Указывается высота окна плеера в пикселях
                "FILE_TITLE" => $video['title'], //Указывается заголовок ролика
                "FILE_AUTHOR" => $video['author'], //Указывается автор ролика
                "FILE_DATE" => $video['date'], //Указывается дата публикации видео
                "FILE_DESCRIPTION" => $video['desc'], //Произвольное текстовое описание ролика
                "SKIN_PATH" => "/bitrix/components/bitrix/player/mediaplayer/skins",
                "CONTROLBAR" => "bottom", //Указывается расположение панели управления плеера (over none bottom)
                "WMODE_WMV" => "window",
                "VOLUME" => "90", //Указывается уровень громкости звука в процентах от максимального заданного в систем
                "HIGH_QUALITY" => "Y",
                "ADVANCED_MODE_SETTINGS" => "Y",
                "ALLOW_SWF" => "Y",
                "PLAYLIST_DIALOG" => "",
                    )
            );
        }
        ?>
    </div>    
    <?php
}

if ($arResult['PROPERTIES']['FILES']['VALUE']) {
    ?>
    <a name="files"></a>  
    <div class="new_page_text">Прикрепленные файлы:<br>

        <?
        foreach ($arResult['PROPERTIES']['FILES']['VALUE'] as $files) {
            $file = CFile::GetFileArray($files);
            
            ?>
            <a target="_blank" href="<?= $file['SRC'] ?>" download><?= $file['ORIGINAL_NAME'] ?></a></br>
            <?
        }
        ?>
        <?
    }
    ?>


    <?
    /*
      <div class="bx_news_detail">
      <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
      <h2><?=$arResult["NAME"]?></h2>
      <?endif;?>
      <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
      <div class="date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div><br>
      <?endif;?>
      <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
      <img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
      <?endif?>
      <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
      <?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?>
      <?endif;?>
      <?if($arResult["NAV_RESULT"]):?>
      <?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
      <?echo $arResult["NAV_TEXT"];?>
      <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
      <?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
      <?echo $arResult["DETAIL_TEXT"];?>
      <?else:?>
      <?echo $arResult["PREVIEW_TEXT"];?>
      <?endif?>
      </div>
     */?>