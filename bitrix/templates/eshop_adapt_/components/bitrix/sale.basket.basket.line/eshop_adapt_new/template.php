<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (IntVal($arResult["NUM_PRODUCTS"])>0):?>
	<a class="cart_block" href="<?=$arParams["PATH_TO_BASKET"]?>"><span id="bx_cart_num">(<?echo intval($arResult["NUM_PRODUCTS"]);?>)</span></a>
<?else:?>
	<a class="cart_block" href="<?=$arParams["PATH_TO_BASKET"]?>"><span id="bx_cart_num">(0)</span></a>
<?endif?>