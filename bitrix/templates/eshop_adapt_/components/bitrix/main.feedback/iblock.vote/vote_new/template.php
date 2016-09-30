<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//Let's determine what value to display: rating or average ?
if($arParams["DISPLAY_AS_RATING"] == "vote_avg")
{
	if($arResult["PROPERTIES"]["vote_count"]["VALUE"])
		$DISPLAY_VALUE = round($arResult["PROPERTIES"]["vote_sum"]["VALUE"]/$arResult["PROPERTIES"]["vote_count"]["VALUE"], 2);
	else
		$DISPLAY_VALUE = 0;
}
else
{
	if($arResult["PROPERTIES"]["rating"]["VALUE"])
		$DISPLAY_VALUE = $arResult["PROPERTIES"]["rating"]["VALUE"];
	else
		$DISPLAY_VALUE = 0;
}
if($arResult["PROPERTIES"]["vote_count"]["VALUE"])
	$votes_count=$arResult["PROPERTIES"]["vote_count"]["VALUE"];
else
	$votes_count=0;
?>
<form id="rating_form" method="post" action="<?=POST_FORM_ACTION_URI?>">
	<div id="rating_news">
		<div class="rating_news_title">Оцените новость</div>
		<div value="0" class="rating_news_radio current">1</div>
		<div value="1" class="rating_news_radio">2</div>
		<div value="2" class="rating_news_radio">3</div>
		<div value="3" class="rating_news_radio">4</div>
		<div value="4" class="rating_news_radio">5</div>					
		<div class="rating_news_text">Рейтинг <span><?=$DISPLAY_VALUE?></span> (оценок <?=$votes_count?>)</div>
		<div class="clear"></div>
	</div>
	<select name="rating" style="display:none;">
		<?foreach($arResult["VOTE_NAMES"] as $i=>$name):?>
			<option value="<?=$i?>"><?=$name?></option>
		<?endforeach?>
	</select>
	<?echo bitrix_sessid_post();?>
	<input type="hidden" name="back_page" value="<?=$arResult["BACK_PAGE_URL"]?>" />
	<input type="hidden" name="vote_id" value="<?=$arResult["ID"]?>" />
	<input class="btn_estimate" type="submit" name="vote" value="Оценить" />
	<div class="clear"></div>
</form>
<?/*
<div class="iblock-vote">
	<form method="post" action="<?=POST_FORM_ACTION_URI?>">
		<select name="rating">
			<?foreach($arResult["VOTE_NAMES"] as $i=>$name):?>
				<option value="<?=$i?>"><?=$name?></option>
			<?endforeach?>
		</select>
		<?echo bitrix_sessid_post();?>
		<input type="hidden" name="back_page" value="<?=$arResult["BACK_PAGE_URL"]?>" />
		<input type="hidden" name="vote_id" value="<?=$arResult["ID"]?>" />
		<input type="submit" name="vote" value="Голосовать" />
	</form>
</div>*/?>