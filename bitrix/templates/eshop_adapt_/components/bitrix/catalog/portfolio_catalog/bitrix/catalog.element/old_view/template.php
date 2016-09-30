<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
    'ID' => $strMainID,
    'PICT' => $strMainID . '_pict',
    'DISCOUNT_PICT_ID' => $strMainID . '_dsc_pict',
    'STICKER_ID' => $strMainID . '_stricker',
    'BIG_SLIDER_ID' => $strMainID . '_big_slider',
    'SLIDER_CONT_ID' => $strMainID . '_slider_cont',
    'SLIDER_LIST' => $strMainID . '_slider_list',
    'SLIDER_LEFT' => $strMainID . '_slider_left',
    'SLIDER_RIGHT' => $strMainID . '_slider_right',
    'OLD_PRICE' => $strMainID . '_old_price',
    'PRICE' => $strMainID . '_price',
    'DISCOUNT_PRICE' => $strMainID . '_price_discount',
    'SLIDER_CONT_OF_ID' => $strMainID . '_slider_cont_',
    'SLIDER_LIST_OF_ID' => $strMainID . '_slider_list_',
    'SLIDER_LEFT_OF_ID' => $strMainID . '_slider_left_',
    'SLIDER_RIGHT_OF_ID' => $strMainID . '_slider_right_',
    'QUANTITY' => $strMainID . '_quantity',
    'QUANTITY_DOWN' => $strMainID . '_quant_down',
    'QUANTITY_UP' => $strMainID . '_quant_up',
    'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
    'QUANTITY_LIMIT' => $strMainID . '_quant_limit',
    'BUY_LINK' => $strMainID . '_buy_link',
    'ADD_BASKET_LINK' => $strMainID . '_add_basket_link',
    'COMPARE_LINK' => $strMainID . '_compare_link',
    'PROP' => $strMainID . '_prop_',
    'PROP_DIV' => $strMainID . '_skudiv',
    'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
    'OFFER_GROUP' => $strMainID . '_set_group_',
    'ZOOM_DIV' => $strMainID . '_zoom_cont',
    'ZOOM_PICT' => $strMainID . '_zoom_pict'
);
$strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/i", "x", $strMainID);
?>
<?php
$picture = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"], Array('width' => 400, 'height' => 280), BX_RESIZE_IMAGE_PROPORTIONAL, true);
?>
<h1><?php echo $arResult['NAME']; ?></h1>
<div style="clear:both;"></div>
<div class="img-detail-porfolio">
    <a title="<?//= $arResult['DETAIL_TEXT'] ?>" href="<?= $arResult['DETAIL_PICTURE']['SRC'] ?>" class="fancybox-button">
        <img src="<?= $picture['src'] ?>">
    </a>
</div>
<div style="" class="text-detail-porfolio">
    <p><span><?= $arResult['PROPERTIES']['OBJECT_TYPE']['NAME'] ?>:</span>
        <?= $arResult['PROPERTIES']['OBJECT_TYPE']['VALUE'] ?></p>
    <p><span><?= $arResult['PROPERTIES']['CITY']['NAME'] ?>:</span>
        <?= $arResult['PROPERTIES']['CITY']['VALUE'] ?></p>
    <p><span><?= $arResult['PROPERTIES']['OBJECT_ADDRESS']['NAME'] ?>:</span>
        <?= $arResult['PROPERTIES']['OBJECT_ADDRESS']['VALUE'] ?></p>
    <p><span><?= $arResult['PROPERTIES']['SERVICE_PHONE']['NAME'] ?>:</span> 
        <?= $arResult['PROPERTIES']['SERVICE_PHONE']['VALUE'] ?></p>
    <p><span><?= $arResult['PROPERTIES']['COMPLETE_ARGOS_LUM']['NAME'] ?>:</span>
        <?= $arResult['PROPERTIES']['COMPLETE_ARGOS_LUM']['VALUE'][0] ?></p>
    <p><span><?= $arResult['PROPERTIES']['MANUFACTURER_OF_LAMPS']['NAME'] ?>:</span>
        <?= $arResult['PROPERTIES']['MANUFACTURER_OF_LAMPS']['VALUE'] ?></p>
    <p><span><?= $arResult['PROPERTIES']['SITE']['NAME'] ?>: </span>
        <a href="http://<?= $arResult['PROPERTIES']['SITE']['VALUE'] ?>" target="_BALNK" rel="nofollow"><?= $arResult['PROPERTIES']['SITE']['VALUE'] ?></a></p>
    <p><span><?= $arResult['PROPERTIES']['MODEL_OF_LAMPS']['NAME'] ?>:</span>
        <?= $arResult['PROPERTIES']['MODEL_OF_LAMPS']['VALUE'][0] ?></p>
    <p><span><?= $arResult['PROPERTIES']['TYPE_OF_LUM']['NAME'] ?>:</span>
        <?= $arResult['PROPERTIES']['TYPE_OF_LUM']['VALUE'][0] ?></p>

    <?if(!empty($arResult['DETAIL_TEXT'])):?>
    <p style="line-height: 21px;"><span>Подробное описание: </span><?=$arResult['DETAIL_TEXT'];?></p>
    <?endif;?>  
</div>
<div style="clear:both"></div>
<?php

    if (!empty($arResult['PROPERTIES']['DOP_IMG']['VALUE'])) {
        foreach ($arResult['PROPERTIES']['DOP_IMG']['VALUE'] as $key => $value) {
            $arfile = CFile::GetFileArray($value);
            $picture_dop = CFile::ResizeImageGet($arfile, Array('width' => 230, 'height' => 156), BX_RESIZE_IMAGE_EXACT, true);
            $truncatetext = TruncateText($arResult['PROPERTIES']['DOP_IMG']['DESCRIPTION'][$key], 15);
            ?>
            <div class="wrap-img-plus">
                <div class="img-plus">
                    <a title="<?= $arResult['PROPERTIES']['DOP_IMG']['DESCRIPTION'][$key] ?>" rel="group" href="<?= $arfile['SRC'] ?>" class="fancybox-button">
                        <img src="<?= $picture_dop['src'] ?>">
                    </a>            
                </div>
                <p>
                    <?= $truncatetext ?>
                </p>
            </div>
            <?php
        }
    }

?>

<script type="text/javascript">
    var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script>