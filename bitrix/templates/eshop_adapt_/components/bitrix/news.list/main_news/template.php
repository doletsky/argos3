<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if (count($arResult["ITEMS"]) < 1)
	return;
?>
<div style="margin: 15px 0 -5px 0px; font-weight: bold;">Последняя добавленная новость</div>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
		if($arItem['PROPERTIES']['FORUM_MESSAGE_CNT']['VALUE'])
			$forum_mess=$arItem['PROPERTIES']['FORUM_MESSAGE_CNT']['VALUE'];
		else
			$forum_mess=0;
		if($arItem['PROPERTIES']['rating']['VALUE'])
			$rating=$arItem['PROPERTIES']['rating']['VALUE'];
		else
			$rating=0;
		if($arItem['PROPERTIES']['vote_count']['VALUE'])
			$vote_count=$arItem['PROPERTIES']['vote_count']['VALUE'];
		else
			$vote_count=0;
		
	?>
<?/*<pre><?print_r($arItem)?></pre>*/?>
<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('NEWS_ELEMENT_DELETE_CONFIRM')));
        
        //считаем количество видео в списках
        $cnt_file = empty($arItem['PROPERTIES']['VIDEO_BITRIX']['VALUE'][0]) ? 0 : count($arItem['PROPERTIES']['VIDEO_BITRIX']['VALUE']);
        if(is_array($arItem['PROPERTIES']['VIDEO']['VALUE'])){
            $cnt_youtube = count($arItem['PROPERTIES']['VIDEO']['VALUE']);
        }else{
            $cnt_youtube = 0;
        }
        $cnt_video = $cnt_file + $cnt_youtube;
//        if($USER->IsAdmin()){
//            echo count($arItem['PROPERTIES']['VIDEO_BITRIX']['VALUE']);
//        }
?>
	<div class="news_wrap">
		<div class="news_content">
			<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="news_title"><?echo $arItem["NAME"]?></a>
			<div class="news_anons"><?echo $arItem["PREVIEW_TEXT"];?></div>
			<a style="color:blue;" href="<?echo $arItem["DETAIL_PAGE_URL"]?>" class="reed_more"><?=GetMessage("REED_MORE")?></a>
		</div>
		<div class="news_footer">
			<div class="news_date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></div>
                        <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>#files" style="display:block;"><div class="news_footer_block files"><?=GetMessage("FILES")?><div class="count"><div class="arrow"></div><?if($arItem['PROPERTIES']['FILES']['VALUE']!='')echo count($arItem['PROPERTIES']['FILES']['VALUE']);else echo '0';?></div></div></a>
                        <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>#video" style="display:block;"><div class="news_footer_block video"><?=GetMessage("VIDEO")?><div class="count"><div class="arrow"></div><?if(count($arItem['PROPERTIES']['VIDEO']['VALUE']) > 0 || !empty($arItem['PROPERTIES']['VIDEO_BITRIX']['VALUE'][0])) echo $cnt_video;else echo '0';?></div></div></a>
                        <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>#comments" style="display:block;"><div class="news_footer_block comments"><?=GetMessage("COMMENTS")?><div class="count"><div class="arrow"></div><?=$forum_mess?></div></div></a>
			<div class="news_footer_block rating"><?=GetMessage("RATING")?><span><?=$rating?></span> (<?=GetMessage("VOTES_COUNT")?><?=$vote_count?>)</div>
			<div class="clear"></div>
		</div>
	</div>
<?endforeach;?>


<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>