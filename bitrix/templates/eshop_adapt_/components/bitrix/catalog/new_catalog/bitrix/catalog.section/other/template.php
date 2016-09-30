<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/*
 * $arItem['SECOND_PICT']
 */
 
if (!empty($arResult['ITEMS']))
{
	
	if ($arParams["DISPLAY_TOP_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}

foreach ($arResult['ITEMS'] as $key => $arItem)
{
	?>
	<div class="catalog_item_wrap catalog_item_wrap_other">
		<div class="catalog_item">
			<div class="catalog_item_img">
			<?if($arItem["DETAIL_PICTURE"]["SRC"]){?>
				<a href="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>" class="fancybox-button"><img src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>"></a>
				<div class="btn_lupa"></div>
			<?}else{?>
				<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>">
			<?}?>
			</div>
			<div class="catalog_item_description">
				<h3><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h3>
				<p><?=$arItem["PREVIEW_TEXT"]?></p>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<?
}
?><div style="clear: both;"></div>

<?
	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}
}
?>