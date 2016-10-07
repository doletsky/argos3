<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
if ($arResult['PROPERTIES']['CATALOG_TITLE']['VALUE']>''){
$APPLICATION->SetTitle($arResult['PROPERTIES']['CATALOG_TITLE']['VALUE']);
$value=$arResult['PROPERTIES']['CATALOG_TITLE']['VALUE'];
$APPLICATION->SetPageProperty("title", $value);//иное значение title присваивается в строке 113 по условию
}
if ($arResult['PROPERTIES']['CATALOG_META_DESCRIPTION']['VALUE']>''){
	//$APPLICATION->SetTitle($arResult['PROPERTIES']['CATALOG_META_DESCRIPTION']['VALUE']);
$value=$arResult['PROPERTIES']['CATALOG_META_DESCRIPTION']['VALUE'];
$APPLICATION->ShowMeta("description");
$APPLICATION->SetPageProperty("description", $value);
}



$templateLibrary = array('popup');
$currencyList = '';
if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BASIS_PRICE' => $strMainID.'_basis_price',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'BASKET_ACTIONS' => $strMainID.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
    if ($arResult['PROPERTIES']['CATALOG_NAME']['VALUE']>''){
    $arResult['NAME']=$arResult['PROPERTIES']['CATALOG_NAME']['VALUE'];
    $strAlt=$arResult['PROPERTIES']['CATALOG_NAME']['VALUE'];
    }
    if ($arResult['PROPERTIES']['CATALOG_TITLE']['VALUE']>''){
    $strTitle=$arResult['PROPERTIES']['CATALOG_TITLE']['VALUE'];
    }


?><div class="bx_item_detail <? echo $templateData['TEMPLATE_CLASS']; ?>" id="<? echo $arItemIDs['ID']; ?>">
<?
if ('Y' == $arParams['DISPLAY_NAME'])
{
?>
<div class="bx_item_title">
	<? if ($arResult['PROPERTIES']['CATALOG_H1']['VALUE']!=''){?>
	<span class="span_h1"><?=$arResult["NAME"];?></span><br />

    <h1><span><?=$arResult['PROPERTIES']['CATALOG_H1']['VALUE']?></span></h1>
	<?} else {?>
   <h1><span data-target="test"><?=$arResult["NAME"];?></span></h1>
</div>

<?
}
reset($arResult['MORE_PHOTO']);
$arFirstPhoto = current($arResult['MORE_PHOTO']);
?>
	<div class="bx_item_container">
		<div class="bx_lt">
<div class="bx_item_slider" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
	<div class="bx_bigimages" id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>">
	<div class="bx_bigimages_imgcontainer">
	<!-- <span class="bx_bigimages_aligner"></span> -->
	<img id="<? echo $arItemIDs['PICT']; ?>" src="<? echo $arFirstPhoto['SRC']; ?>" alt="<? echo $strAlt; ?>" title="<? echo $strTitle; ?>">
<?
if ($arResult['LABEL'])
{
?>
	<div class="bx_stick average left top" id="<? echo $arItemIDs['STICKER_ID'] ?>" title="<? echo $arResult['LABEL_VALUE']; ?>"></div>
<?
}
?>
	</div>
	</div>
<?
if ($arResult['SHOW_SLIDER'])
{
	if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
	{
		if (5 < $arResult['MORE_PHOTO_COUNT'])
		{
			$strClass = 'bx_slider_conteiner full';
			$strOneWidth = (100/$arResult['MORE_PHOTO_COUNT']).'%';
			$strWidth = (20*$arResult['MORE_PHOTO_COUNT']).'%';
			$strSlideStyle = '';
		}
		else
		{
			$strClass = 'bx_slider_conteiner';
			$strOneWidth = '20%';
			$strWidth = '100%';
			$strSlideStyle = 'display: none;';
		}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
	<div class="bx_slider_scroller_container">
	<div class="bx_slide">
	<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">
<?
		foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto)
		{
?>
	<li data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
<?
		}
		unset($arOnePhoto);
?>
	</ul>
	</div>
	<div class="bx_slide_left" id="<?=$arItemIDs['SLIDER_LEFT']; ?>" style="<?=$strSlideStyle; ?>"></div>
	<div class="bx_slide_right" id="<?=$arItemIDs['SLIDER_RIGHT']; ?>" style="<?=$strSlideStyle; ?>"></div>
	</div>
	</div>
<?
	}
	else
	{
		foreach ($arResult['OFFERS'] as $key => $arOneOffer)
		{
			if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
				continue;
			$strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
			if (5 < $arOneOffer['MORE_PHOTO_COUNT'])
			{
				$strClass = 'bx_slider_conteiner full';
				$strOneWidth = (100/$arOneOffer['MORE_PHOTO_COUNT']).'%';
				$strWidth = (20*$arOneOffer['MORE_PHOTO_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_slider_conteiner';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<?=$strClass; ?>" id="<?=$arItemIDs['SLIDER_CONT_OF_ID'].$arOneOffer['ID']; ?>" style="display: <?=$strVisible; ?>;">
	<div class="bx_slider_scroller_container">
	<div class="bx_slide">
	<ul style="width: <?=$strWidth; ?>;" id="<?=$arItemIDs['SLIDER_LIST_OF_ID'].$arOneOffer['ID']; ?>">
<?
			foreach ($arOneOffer['MORE_PHOTO'] as &$arOnePhoto)
			{
?>
	<li data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
<?
			}
			unset($arOnePhoto);
?>
	</ul>
	</div>
	<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
	<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
	</div>
	</div>
<?
		}
	}
}
?>
</div>
		</div>
		<div class="bx_rt">

                <?
                  //if ('' != $arResult['DETAIL_TEXT'])
                    if ('' != $arResult['PROPERTIES']['CATALOG_PREVIEW']['VALUE']['TEXT'])
                {
                    ?>
                    <div class="bx_item_description" style="line-height: 18px;">
						<?/*if ('html' == $arResult['DETAIL_TEXT_TYPE']):?>
                            <?=$arResult['DETAIL_TEXT'];?>

                        <?else:?>
                            <p><?=$arResult['DETAIL_TEXT']; ?></p>
                        <?endif;*/?>
                        <? echo $arResult['PROPERTIES']['CATALOG_PREVIEW']['VALUE']['TEXT'];?>

                      <a href="#descr">подробнее</a>  <br /><br />
                    </div>

                <?
                }
                ?>





<?
$useBrands = ('Y' == $arParams['BRAND_USE']);
$useVoteRating = ('Y' == $arParams['USE_VOTE_RATING']);
if ($useBrands || $useVoteRating)
{
?>
	<div class="bx_optionblock">
<?
	if ($useVoteRating)
	{
		?><?$APPLICATION->IncludeComponent(
			"bitrix:iblock.vote",
			"stars",
			array(
				"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
				"IBLOCK_ID" => $arParams['IBLOCK_ID'],
				"ELEMENT_ID" => $arResult['ID'],
				"ELEMENT_CODE" => "",
				"MAX_VOTE" => "5",
				"VOTE_NAMES" => array("1", "2", "3", "4", "5"),
				"SET_STATUS_404" => "N",
				"DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
				"CACHE_TYPE" => $arParams['CACHE_TYPE'],
				"CACHE_TIME" => $arParams['CACHE_TIME']
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?><?
	}
	if ($useBrands)
	{
		?><?$APPLICATION->IncludeComponent("bitrix:catalog.brandblock", ".default", array(
			"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
			"IBLOCK_ID" => $arParams['IBLOCK_ID'],
			"ELEMENT_ID" => $arResult['ID'],
			"ELEMENT_CODE" => "",
			"PROP_CODE" => $arParams['BRAND_PROP_CODE'],
			"CACHE_TYPE" => $arParams['CACHE_TYPE'],
			"CACHE_TIME" => $arParams['CACHE_TIME'],
			"CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
			"WIDTH" => "",
			"HEIGHT" => ""
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?><?
	}
?>
	</div>
<?
}
unset($useVoteRating, $useBrands);
?>
<div class="item_price">
<?
$boolDiscountShow = (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF']);
//echo "<pre>",print_r($arResult['MIN_PRICE']),"</pre>";
if (empty($arResult['MIN_PRICE'])){
echo ('Недоступен для заказа через сайт - звоните!');
}
?>
	<div class="item_old_price" id="<? echo $arItemIDs['OLD_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? $arResult['MIN_PRICE']['PRINT_VALUE'] : ''); ?></div>
	<div class="item_current_price" id="<? echo $arItemIDs['PRICE']; ?>"><?=$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];?></div>
	<div class="item_economy_price" id="<? echo $arItemIDs['DISCOUNT_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? GetMessage('CT_BCE_CATALOG_ECONOMY_INFO', array('#ECONOMY#' => $arResult['MIN_PRICE']['PRINT_DISCOUNT_DIFF'])) : ''); ?></div>
</div>
<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) && !empty($arResult['OFFERS_PROP']))
{
	$arSkuProps = array();
?>
<div class="item_info_section" style="padding-right:150px;" id="<? echo $arItemIDs['PROP_DIV']; ?>">
<?
	foreach ($arResult['SKU_PROPS'] as &$arProp)
	{
		if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))
			continue;
		$arSkuProps[] = array(
			'ID' => $arProp['ID'],
			'SHOW_MODE' => $arProp['SHOW_MODE'],
			'VALUES_COUNT' => $arProp['VALUES_COUNT']
		);
		if ('TEXT' == $arProp['SHOW_MODE'])
		{
			if (5 < $arProp['VALUES_COUNT'])
			{
				$strClass = 'bx_item_detail_size full';
				$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
				$strWidth = (20*$arProp['VALUES_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_item_detail_size';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
		<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
		<div class="bx_size_scroller_container"><div class="bx_size">
			<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
<?
			foreach ($arProp['VALUES'] as $arOneValue)
			{
				$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
?>
<li data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID']; ?>" data-onevalue="<? echo $arOneValue['ID']; ?>" style="width: <? echo $strOneWidth; ?>; display: none;">
<i title="<? echo $arOneValue['NAME']; ?>"></i><span class="cnt" title="<? echo $arOneValue['NAME']; ?>"><? echo $arOneValue['NAME']; ?></span></li>
<?
			}
?>
			</ul>
			</div>
			<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
			<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
		</div>
	</div>
<?
		}
		elseif ('PICT' == $arProp['SHOW_MODE'])
		{
			if (5 < $arProp['VALUES_COUNT'])
			{
				$strClass = 'bx_item_detail_scu full';
				$strOneWidth = (100/$arProp['VALUES_COUNT']).'%';
				$strWidth = (20*$arProp['VALUES_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_item_detail_scu';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_cont">
		<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>
		<div class="bx_scu_scroller_container"><div class="bx_scu">
			<ul id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;margin-left:0%;">
<?
			foreach ($arProp['VALUES'] as $arOneValue)
			{
				$arOneValue['NAME'] = htmlspecialcharsbx($arOneValue['NAME']);
?>
<li data-treevalue="<? echo $arProp['ID'].'_'.$arOneValue['ID'] ?>" data-onevalue="<? echo $arOneValue['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>; display: none;" >
<i title="<? echo $arOneValue['NAME']; ?>"></i>
<span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');" title="<? echo $arOneValue['NAME']; ?>"></span></span></li>
<?
			}
?>
			</ul>
			</div>
			<div class="bx_slide_left" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_left" data-treevalue="<? echo $arProp['ID']; ?>"></div>
			<div class="bx_slide_right" style="<? echo $strSlideStyle; ?>" id="<? echo $arItemIDs['PROP'].$arProp['ID']; ?>_right" data-treevalue="<? echo $arProp['ID']; ?>"></div>
		</div>
	</div>
<?
		}
	}
	unset($arProp);
?>
</div>
<?
}
?>
<div class="item_info_section">
<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	$canBuy = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['CAN_BUY'];
}
else
{
	$canBuy = $arResult['CAN_BUY'];
}
$buyBtnMessage = ($arParams['MESS_BTN_BUY'] != '' ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY'));
$addToBasketBtnMessage = ($arParams['MESS_BTN_ADD_TO_BASKET'] != '' ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCE_CATALOG_ADD'));
$notAvailableMessage = ($arParams['MESS_NOT_AVAILABLE'] != '' ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE'));
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);

$showSubscribeBtn = false;
$compareBtnMessage = ($arParams['MESS_BTN_COMPARE'] != '' ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCE_CATALOG_COMPARE'));

if ($arParams['USE_PRODUCT_QUANTITY'] == 'Y')
{
?>
	<div class="item_buttons vam">
		<span class="item_buttons_counter_block">
			<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>">-</a>
			<input id="<? echo $arItemIDs['QUANTITY']; ?>" type="text" class="tac transparent_input" value="<? echo (isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])
					? 1
					: $arResult['CATALOG_MEASURE_RATIO']
				); ?>">
			<a href="javascript:void(0)" class="bx_bt_button_type_2 bx_small bx_fwb" id="<? echo $arItemIDs['QUANTITY_UP']; ?>">+</a>
			<span class="bx_cnt_desc" id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo (isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'].'.' : ''); ?></span>
		</span>

<?
	if ($arParams['DISPLAY_COMPARE'] || $showSubscribeBtn)
	{
?>
		<span class="item_buttons_counter_block">
<?
		if ($arParams['DISPLAY_COMPARE'])
		{
?>
			<a href="javascript:void(0);" class="bx_big bx_bt_button_type_2 bx_cart" id="<? echo $arItemIDs['COMPARE_LINK']; ?>"><? echo $compareBtnMessage; ?></a>
<?
		}
		if ($showSubscribeBtn)
		{

		}
?>
		</span>
<?
	}
?>
    <?if ($arParams['SHOW_BASIS_PRICE'] == 'Y')
    {
        $basisPriceInfo = array(
            '#PRICE#' => ' до ' . $arResult['MIN_BASIS_PRICE']['PRINT_DISCOUNT_VALUE'],
            '#MEASURE#' => ('шт.')
        );
        ?>
        <p id="<? echo $arItemIDs['BASIS_PRICE']; ?>" class="item_section_name_gray"><? echo GetMessage('CT_BCE_CATALOG_MESS_BASIS_PRICE', $basisPriceInfo); ?></p>
    <?
    }?>
	</div>
<?
	if ('Y' == $arParams['SHOW_MAX_QUANTITY'])
	{
		if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
		{
?>
	<p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>" style="display: none;"><? echo GetMessage('OSTATOK'); ?>: <span></span></p>
<?
		}
		else
		{
			if ('Y' == $arResult['CATALOG_QUANTITY_TRACE'] && 'N' == $arResult['CATALOG_CAN_BUY_ZERO'])
			{
?>
	<p id="<? echo $arItemIDs['QUANTITY_LIMIT']; ?>"><? echo GetMessage('OSTATOK'); ?>: <span><? echo $arResult['CATALOG_QUANTITY']; ?></span></p>
<?
			}
		}
	}
}
else
{
?>
	<div class="item_buttons vam">
		<span class="item_buttons_counter_block" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" style="float: right; display: <? echo ($canBuy ? '' : 'none'); ?>;">
<?
	if ($showBuyBtn)
	{
?>
			<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
<?
	}
	if ($showAddBtn)
	{
?>
		<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['ADD_BASKET_LINK']; ?>"><span></span><? echo $addToBasketBtnMessage; ?></a>
<?
	}
?>
		</span>
		<span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" style="display: <? echo (!$canBuy ? '' : 'none'); ?>;"><? echo $notAvailableMessage; ?></span>
	</div>
<?
}

?>





</div>


		<?if($arResult['MIN_PRICE']['VALUE'] <> 0):?>
		<span class="item_buttons_counter_block" id="<? echo $arItemIDs['BASKET_ACTIONS']; ?>" style="float: left; display: <? echo ($canBuy ? '' : 'none'); ?>;">
		<?//echo $arResult['MIN_PRICE']['VALUE'];?>
		<?/*if($arResult['MIN_PRICE']['VALUE'] <> 0):?>
				<?else:?>
			<span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" ><? echo $notAvailableMessage; ?></span>
		<?endif;*/?>
<?
	if ($showBuyBtn)
	{
?>
			<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['BUY_LINK']; ?>"><span></span><? echo $buyBtnMessage; ?></a>
<?
	}
	if ($showAddBtn)
	{
?>
			<a href="javascript:void(0);" class="bx_big bx_bt_button bx_cart" id="<? echo $arItemIDs['ADD_BASKET_LINK']; ?>"><span></span><? echo $addToBasketBtnMessage; ?></a>
<?
	}
?>
		</span>
<?else:?>
		<!-- <span id="<? echo $arItemIDs['NOT_AVAILABLE_MESS']; ?>" class="bx_notavailable" style="float: right;"><? echo $notAvailableMessage; ?></span> -->
<?
endif;
unset($showAddBtn, $showBuyBtn);
?>
<div style="clear: both;"></div>
<br />
<div id="u120" class="text" style="visibility: visible; left: 0px; transform-origin: 111px 14px 0px; margin-top: 10px;">
<p>
<span style="font-size: 24px;">Остались вопросы? </span>
</p>
</div>
<br />
<div id="u121" class="ax_default paragraph" style="font-size: 16px; color: #454A4C; width: 50%; float: left;">
Звоните 8-800-200-19-83
<br /><br />
Пишите на почту <br />
<a href="mailto:kunilovskiy@argos-trade.com" style="padding-top: 7px;float: left;">kunilovskiy@argos-trade.com</a>
</div>
<div id="u121" class="ax_default paragraph" style="font-size: 13px; color: #333333;width: 50%; float: left; ">

	<?if(!empty($arResult['PROPERTIES']['PDF_OFFERS_TECHNICAL_CHARACTERISTICS']['VALUE'])):?>
		<a class="pdf_catalog_link" href="<?=$arResult['PROPERTIES']['PDF_OFFERS_TECHNICAL_CHARACTERISTICS']['VALUE']['URL'];?>">
			Технические характеристики
		</a>
	<?endif;?>
</div>


<div style="clear: both;"></div>
<br /><br />
<div id="u121" class="ax_default paragraph" style="font-size: 13px; color: #333333;width: 50%; float: left;margin-top: -15px;">
Для получения статуса дистрибьютора и коммерческих условий, необходимо связаться с торговым отделом по вышеуказанному телефону.
</div>

 	<?if(!empty($arResult['PROPERTIES']['PDF_TECHNICAL_CHARACTERISTICS']['VALUE'])):?>
		<a class="pdf_catalog_link" href="<?=$arResult['PROPERTIES']['PDF_TECHNICAL_CHARACTERISTICS']['VALUE']['URL'];?>">
			Протоколы испытаний
		</a>
	<?endif;?>


			<div class="clb"></div>
		</div>

		<div class="bx_md">



<section class="tabs">
	<input id="tab_1" type="radio" name="tab" checked="checked" />
	<input id="tab_2" type="radio" name="tab" />
	<input id="tab_3" type="radio" name="tab" />
    <input id="tab_4" type="radio" name="tab" />
    <input id="tab_5" type="radio" name="tab" />
	<label for="tab_1" id="tab_l1">Описание товара</label>
	<label for="tab_2" id="tab_l2">Характеристики</label>
	<label for="tab_4" id="tab_l4">Сертификаты</label>
    <?if(stristr($APPLICATION->GetCurPage(), 'draivery') === FALSE) {?>
      <label for="tab_3" id="tab_l3">IES-файл</label>
    <?}?>

    <label for="tab_5" id="tab_l5">Оплата и доставка</label>
	<div style="clear:both"></div>

	<div class="tabs_cont">
		<div id="tab_c1">
            <div class="item_info_section">
            <a name="descr"></a>
                <?
                if ('' != $arResult['PREVIEW_TEXT'])
                {
                    ?>
                    <div class="bx_item_description">
                        <?if ('html' == $arResult['PREVIEW_TEXT_TYPE']):?>
                        <div style="color: #0083D3; font-size: 17px; font-weight: bold; line-height: 35px;">

                        </div>
                            <?=$arResult['PREVIEW_TEXT'];?>
                        <?else:?>
                        <div style="color: #0083D3; font-size: 17px; font-weight: bold; line-height: 35px;">

                        </div>
                            <p><?=$arResult['PREVIEW_TEXT']; ?></p>
                        <?endif;?>
                    </div>
                <?
                }
                ?>
            </div>

		</div>
		<div id="tab_c2">
<div class="props">
	<div class="prop_block_name" style="">

	</div>
	<table>
		<?
		$i=0;
		foreach ($arResult['PROPS'] as $propID => $propInfo):
			//echo "<pre>", print_r($propInfo),"</pre>";
			if(!empty($propInfo['VALUE'])):
			?>
			<tr>
				<td style="width: 340px;"><?=$propInfo['NAME']; ?></td>
				<td><?=is_array($propInfo['VALUE']) ? implode(', ', $propInfo['VALUE']) : $propInfo['VALUE']?></td>
			</tr>
			<?endif;$i++;?>
		<?endforeach;?>
	</table>
</div>

        <br />
		</div>
		<div id="tab_c3">


<?//print_r($arResult['PROPERTIES']['IES']['VALUE'])?>

<?
									$mxResult = CCatalogSku::GetProductInfo($arResult['ID']);
                                    $res = CIBlockElement::GetByID($mxResult['ID']);
                                     if($ar_res = $res->GetNext()){
                                     //   echo $ar_res['NAME'];
                                     }
                                    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
                                    $arFilter = Array("IBLOCK_ID"=>$ar_res[IBLOCK_ID],"ID"=>$ar_res[ID], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
                                    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
                                    while($ob = $res->GetNextElement()){
                                      $arFields = $ob->GetFields();
                                      //print_r($arFields);
                                      $arProps = $ob->GetProperties();
                                      //print_r($arProps);
                                    }



									if($arProps['PROPERTIES']['PROTOCOLS_GROUP']["VALUE"]!=''){

										$VALUES = array();
										$arSelect = array("ID", "NAME", "PROPERTY_MODEL");
										$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$arFields['IBLOCK_ID'], "PROPERTY_PROTOCOLS_GROUP"=>$arResult['PROPERTIES']['PROTOCOLS_GROUP']["VALUE"]), $arSelect);
										while($res=$ar_result->GetNext())
										{
											if($res['CNT']>0)										{

												$TmpID = $res["ID"];
												$Obj = CCatalogProduct::GetByIDEx($TmpID);

												$res1 = CIBlockElement::GetProperty($Obj["IBLOCK_ID"], $TmpID, array(), array("CODE" => "IES"));
												while ($ob = $res1->GetNext())
												{
													$VALUES[] = array($ob['VALUE'],$ob['DESCRIPTION']);
												}
											}
										}
										foreach($VALUES as $file_ies_id){
											if($file_ies_id[0] != ''){
												$path_file = CFile::GetPath($file_ies_id[0]);
												?>
												<a class="file_catalog_link" href="<?=$path_file?>" target="_blank" download><?=$file_ies_id[1]?></a>
												<?
												$count++;
											}
										}
									}else{

										$files_ies=$arResult['PROPERTIES']['IES']['VALUE'];
										if($files_ies != '') {
											$count=0;
											foreach ($files_ies as $file_ies_id)
											{
												$path_file = CFile::GetPath($file_ies_id);
												?>
												<a class="file_catalog_link" href="<?=$path_file?>" target="_blank" download><?=$arResult['PROPERTIES']['IES']['DESCRIPTION'][$count]?></a>
												<?
												$count++;
											}
										}

									}
?>




     	<?/*if(!empty($arResult['PROPERTIES']['PDF_OFFERS_TECHNICAL_CHARACTERISTICS']['VALUE'])):

$path_file = $arResult['PROPERTIES']['PDF_OFFERS_TECHNICAL_CHARACTERISTICS']['VALUE']['URL'];
?>
<iframe src="https://docs.google.com/viewer?url=http://<?=$_SERVER['SERVER_NAME'];?><?=$path_file?>&embedded=true"
style="width: 100%; height: 600px;" frameborder="0">Ваш браузер не поддерживает фреймы</iframe>

		<?endif;*/?>
        <br />
        </div>

		<div id="tab_c4">
						<?
						//инфоблоки для сертификатов
						$iblock_id_cert=7;

						//Если указана группа для товаров
						if($arResult['PROPERTIES']['PROTOCOLS_GROUP']["VALUE"]!='')
						{
							$arSelect = array("IBLOCK_ID", "ID", "NAME", "IBLOCK_SECTION_ID");
							$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$arResult['IBLOCK_ID'], "PROPERTY_PROTOCOLS_GROUP"=>$arResult['PROPERTIES']['PROTOCOLS_GROUP']["VALUE"]), $arSelect);
							while($res=$ar_result->GetNext())
							{

								if($res['CNT']>0)
								{
									?>
										<div><?=$res['NAME']?></div>
											<?
											$item_id=$res['ID'];

											$arr_certificates=array();//массив сертификатов

											//Привязка к элементу
											$arSelectCert = array("ID", "NAME", "PROPERTY_USE_IN_ELEMENT", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
											$ar_result_cert=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_ELEMENT"=>$item_id), $arSelectCert);
											while($cert=$ar_result_cert->GetNext())
											{
												if($cert['CNT']>0)
												{
													$link = CFile::GetPath($cert["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
													if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
													{
														?>
														<a class="pdf_catalog_link" target="_blank" href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3&certificate_id=<?=$cert['ID']?>"><?=$cert['NAME']?></a>
														<?
														$arr_certificates[]=$link;
													}
												}
											}

											//Привязка к предложению
											if(SITE_DIR=='/'){
												$offer_iblock_id=4;
											}else{
												$offer_iblock_id=11;
											}
											$arSelectOffers = array("ID");
											$arResOffers = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$offer_iblock_id, "PROPERTY_MODEL"=>$item_id), $arSelectOffers);

											while($arOffer = $arResOffers->GetNext())
											{
												$arSelectCert = array("ID", "NAME", "PROPERTY_USE_IN_ELEMENT", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
												$ar_result_cert=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_ELEMENT"=>$arOffer["ID"]), $arSelectCert);
												while($cert=$ar_result_cert->GetNext())
												{
													if($cert['CNT']>0)
													{
														$link = CFile::GetPath($cert["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
														if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
														{
															?>
															<a class="pdf_catalog_link" target="_blank" href="<?=$link?>"><?=$cert['NAME']?></a>
															<?
															$arr_certificates[]=$link;
														}
													}
												}
											}


											//Привязка к разделу
											$sec_id=$res['IBLOCK_SECTION_ID'];

											$iblock_id=$arResult['IBLOCK_ID'];
											$arr_section=array();//массив для всех родительских разделов
											//получение всех секций для текущего элемента
											$rsPath = GetIBlockSectionPath($iblock_id, $sec_id);
											while($arPath=$rsPath->GetNext()) {
												$arr_section[]=$arPath['ID'];
											}
											//для каждого раздела ищем совпадающие сертификаты
											foreach ($arr_section as $section)
											{
												$arSelectCert = array("ID", "NAME", "PROPERTY_USE_IN_SECTION", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
												$ar_result_cert=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_SECTION"=>$section), $arSelectCert);
												while($cert=$ar_result_cert->GetNext())
												{
													if($cert['CNT']>0)
													{
														$link = CFile::GetPath($cert["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
														if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
														{
															?>
                                                            <a class="pdf_catalog_link" target="_blank" href="<?=$link?>"><?=$cert['NAME']?></a>
															<?
															$arr_certificates[]=$link;
														}
													}
												}
											}
											?>
											<?/*<a class="pdf_catalog_link"  href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3&certificate_item_id=<?=$res['ID']?>&certificate_sec_id=<?=$res['IBLOCK_SECTION_ID']?>"><?=$res['NAME']?></a>*/?>
									<?
								}
							}
						}
						else
						{
						?>

									<?
									$item_id=$arResult['ID'];
									$arr_certificates=array();//массив сертификатов
									//Привязка к предложению
									$arSelectCert = array("ID", "NAME", "PROPERTY_USE_IN_ELEMENT", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
									$ar_result_cert=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_ELEMENT"=>$item_id), $arSelectCert);
									while($cert=$ar_result_cert->GetNext())
									{
										if($cert['CNT']>0)
										{
											$link = CFile::GetPath($cert["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
											if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
											{
												?>
                                                <a class="pdf_catalog_link" target="_blank" href="<?=$link?>"><?=$cert['NAME']?></a>
												<?
												$arr_certificates[]=$link;
											}
										}
									}
									//привязка к элементу
									$mxResult = CCatalogSku::GetProductInfo($arResult['ID']);
									$item_id=$mxResult['ID'];
									$arSelectCert = array("ID", "NAME", "PROPERTY_USE_IN_ELEMENT", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
									$ar_result_cert=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_ELEMENT"=>$item_id), $arSelectCert);
									while($cert=$ar_result_cert->GetNext())
									{
										if($cert['CNT']>0)
										{
											$link = CFile::GetPath($cert["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
											if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
											{
												?>
                                                <a class="pdf_catalog_link" target="_blank" href="<?=$link?>"><?=$cert['NAME']?></a>
												<?
												$arr_certificates[]=$link;
											}
										}
									}
									//Привязка к разделу
                                    if (is_array($mxResult))
                                     {
                                         //echo 'ID товара = '.$mxResult['ID'];
                                         $res = CIBlockElement::GetByID($mxResult['ID']);
                                         if($ar_res = $res->GetNext()){
                                          $res_sec = CIBlockSection::GetByID($ar_res[IBLOCK_SECTION_ID]);
                                            if($ar_res_sec = $res_sec->GetNext()){

                                              }
                                           }
                                     }

                                    $sec_id=$ar_res_sec[ID];
                                    $nav = CIBlockSection::GetNavChain(false, $sec_id);
                                     while($arItem = $nav->Fetch()){
                                     $ITEMS[] = $arItem;
                                   }

									//для каждого раздела ищем совпадающие сертификаты
									foreach ($ITEMS as $section)
									{
										$arSelectCert = array("ID", "NAME", "PROPERTY_USE_IN_SECTION", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
										$ar_result_cert=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_SECTION"=>$section), $arSelectCert);
										while($cert=$ar_result_cert->GetNext())
										{
											if($cert['CNT']>0)
											{
												$link = CFile::GetPath($cert["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
												if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
												{
													?>
													<a class="pdf_catalog_link" target="_blank" href="<?=$link?>"><?=$cert['NAME']?></a>
													<?
													$arr_certificates[]=$link;
												}
											}
										}
									}
									?>
									<?/*<a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3&certificate_item_id=<?=$res['ID']?>&certificate_sec_id=<?=$res['IBLOCK_SECTION_ID']?>"><?=$res['NAME']?></a>*/?>
						<?
						}
					?>


         <br />
        </div>
		<div id="tab_c5">

<div id="u121" class="ax_default paragraph" style="font-size: 14px; color: #454A4C; float: left; line-height: 18px;">
Компания работает только с юридическими лицами  по счету.<br />
Если Вы физическое лицо – для покупки обращайтесь к нашим дистрибьюторам:
<br /><br />
Отгрузка производится от 1 шт., по всей территории Российской Федерации. По вопросам доставки за пределы РФ просим Вас связаться я торговым отделом по телефонам:
<br /><br />
<span style="color: blue;">
+7-812-458-55-63<br />
+7-812-458-55-64
</span>
<br /><br />
Либо выслать заявку на почту: <a href="mailto:kunilovskiy@argos-trade.com">kunilovskiy@argos-trade.com</a>
<br /><br />
Отправка товара происходит на следующий день после 100% предоплаты, транспортной компанией, по их расценкам. Доставка до терминала транспортной компании в СПБ – бесплатно.
<br /><br /><br />
</div>
		</div>

	</div>
</section>

<br />

<div style="clear: both;"></div>
<? if (!empty($arResult[PROPERTIES][PERELINKS][VALUE])){?>
<span style="float: left; font-size: 24px; padding-top: 10px;">Вам так же будет интересно</span>
<?}?>

<br /><br />
<div style="float: left;">
<?
foreach ($arResult[PROPERTIES][PERELINKS][VALUE] as $perelink) {

$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PREVIEW_PICTURE", "PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = Array("IBLOCK_ID"=>$arResult[IBLOCK_ID],"ID"=>$perelink, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($ob = $res->GetNextElement()){
 $arFields = $ob->GetFields();
?>

<div style="position: relative; float: left; width: 210px;">
<img src="<?=CFile::GetPath($arFields['PREVIEW_PICTURE'])?>" width="150">
<?$mxResult = CCatalogSku::GetProductInfo($arFields[ID]);
if (is_array($mxResult))
  {
    //echo 'ID товара = '.$mxResult['ID'];
    $res = CIBlockElement::GetByID($mxResult['ID']);
    if($ar_res = $res->GetNext()){
         $res_sec = CIBlockSection::GetByID($ar_res[IBLOCK_SECTION_ID]);
           if($ar_res_sec = $res_sec->GetNext()){
           }
     }
  }
?>

<a  style="color: #393939; font: normal 16px/49px Tahoma;"  href="<?=$APPLICATION->GetCurPage()?>?action=ADD2BASKET&id=<?=$arFields['ID']?>">В корзину</a>
<?$ssylka='/catalog/'.$ar_res_sec[CODE].'/'.$arFields[CODE].'/';?>
<a style="color: #393939; font: normal 16px/49px Tahoma;padding-left: 10px;" href="<?=$ssylka?>" >Подробнее</a>
</div>
<?}?>

<?}?>
</div>

<?$mxResult = CCatalogSku::GetProductInfo($arResult[ID]);
if (is_array($mxResult))
  {
    //echo 'ID товара = '.$mxResult['ID'];

    $res = CIBlockElement::GetByID($mxResult['ID']);
    if($ar_res = $res->GetNext()){
         $res_sec = CIBlockSection::GetByID($ar_res[IBLOCK_SECTION_ID]);
           if($ar_res_sec = $res_sec->GetNext()){
           }
     }
  }
?>

			<?	//$APPLICATION->AddChainItem("Каталог", "/catalog/");
	//$APPLICATION->AddChainItem($ar_res_sec[NAME], '/catalog/'.$ar_res_sec[CODE]);
?>


		</div>

			<div style="clear: both;"></div>
	</div>
	<div class="clb"></div>
</div><?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	foreach ($arResult['JS_OFFERS'] as &$arOneJS)
	{
		if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
		{
			$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
			$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
		}
		$strProps = '';
		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($arOneJS['DISPLAY_PROPERTIES']))
			{
				foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
				{
					$strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
						is_array($arOneProp['VALUE'])
						? implode(' / ', $arOneProp['VALUE'])
						: $arOneProp['VALUE']
					).'</dd>';
				}
			}
		}
		$arOneJS['DISPLAY_PROPERTIES'] = $strProps;
	}
	if (isset($arOneJS))
		unset($arOneJS);
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'NAME' => $arResult['~NAME']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $arSkuProps
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
	{
?>
<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
<?
		if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
		{
			foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
			{
?>
	<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
<?
				if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
					unset($arResult['PRODUCT_PROPERTIES'][$propID]);
			}
		}
		$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
		if (!$emptyProductProperties)
		{
?>
	<table>
<?
			foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
			{
?>
	<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
	<td>
<?
				if(
					'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
					&& 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
				)
				{
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
					}
				}
				else
				{
					?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option><?
					}
					?></select><?
				}
?>
	</td></tr>
<?
			}
?>
	</table>
<?
		}
?>
</div>
<?
	}
	if ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] != $arResult['MIN_PRICE']['VALUE'])
	{
		$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
		$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
	}
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'BASIS_PRICE' => $arResult['MIN_BASIS_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ($arParams['ADD_PROPERTIES_TO_BASKET'] == 'Y'),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
	unset($emptyProductProperties);
}
?>
<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
BX.message({
	ECONOMY_INFO_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO'); ?>',
	BASIS_PRICE_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_BASIS_PRICE') ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE'); ?>',
	BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK'); ?>',
	COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK') ?>',
	COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
	COMPARE_TITLE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE') ?>',
	BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
</script>