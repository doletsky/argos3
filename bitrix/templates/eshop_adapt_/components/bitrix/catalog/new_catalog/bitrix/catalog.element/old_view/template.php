<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="content" class="whole item-old-view">
	<h1><?=$arResult["NAME"]?></h1>
	<div id="print"><?=GetMessage("PRINT_LINK")?></div>
	<div class="clear"></div>
	<?if($arResult["DETAIL_PICTURE"]["SRC"]!==''){?>
		<a href="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" class="fancybox-button"><img src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"></a>				
	<?}?>
	<p><?=$arResult["DETAIL_TEXT"]?></p>
</div>