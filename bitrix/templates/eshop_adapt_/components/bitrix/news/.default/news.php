<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<h1><?=GetMessage("TITLE_PAGE");?></h1>
<?if($arParams["USE_RSS"]=="Y"):?>
	<?
	if(method_exists($APPLICATION, 'addheadstring'))
		$APPLICATION->AddHeadString('<link rel="alternate" type="application/rss+xml" title="'.$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rss"].'" href="'.$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rss"].'" />');
	?>
	<a class="icon_rss" href="<?=$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["rss"]?>" title="rss" target="_self"><?/*<img alt="RSS" src="<?=$templateFolder?>/images/gif-light/feed-icon-16x16.gif" border="0" align="right" style="margin-top: 1px; margin-right: 1px;"/>*/?><?=GetMessage("RSS")?></a>
<?endif?>
<div id="print"><?=GetMessage("PRINT_LINK");?></div>
<div class="clear"></div>
<div class="navigation_news">
	<span class="sort_title"><?=GetMessage("SORT_BY")?></span>
	<span class="sort_one"><?=GetMessage("SORT_DATE")?></span>
	<a href="<?=SITE_DIR?>news/newsletter/?sort=date&order=asc" class="asc btn_sort<?if($_REQUEST["sort"]=='date' && $_REQUEST["order"]=='asc')echo' active'?>"></a>
	<a href="<?=SITE_DIR?>news/newsletter/?sort=date&order=desc" class="desc btn_sort<?if($_REQUEST["sort"]=='date' && $_REQUEST["order"]=='desc')echo' active'?>"></a>
	<span class="sort_one"><?=GetMessage("SORT_POPULARITY")?></span>
	<a href="<?=SITE_DIR?>news/newsletter/?sort=rating&order=asc" class="asc btn_sort<?if($_REQUEST["sort"]=='rating' && $_REQUEST["order"]=='asc')echo' active'?>"></a>
	<a href="<?=SITE_DIR?>news/newsletter/?sort=rating&order=desc" class="desc btn_sort<?if($_REQUEST["sort"]=='rating' && $_REQUEST["order"]=='desc')echo' active'?>"></a>
	<div id="search_news">
		<?if($arParams["USE_SEARCH"]=="Y"):?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:search.form",
				"news_search",
				Array(
					"PAGE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["search"]
				),
				$component
			);?>
		<?endif?>
	</div>
	<div class="clear"></div>
</div>

<?// Elements sort
	$arAvailableSort = array(
		"rating" => Array("PROPERTY_rating", "asc"),
		"date" => Array('ACTIVE_FROM', "desc"),
	);
	$sort = array_key_exists("sort", $_REQUEST) && array_key_exists(ToLower($_REQUEST["sort"]), $arAvailableSort) ? $arAvailableSort[ToLower($_REQUEST["sort"])][0] : "ACTIVE_FROM";
	$sort_order = array_key_exists("order", $_REQUEST) && in_array(ToLower($_REQUEST["order"]), Array("asc", "desc")) ? ToLower($_REQUEST["order"]) : "desc";
?>
<?if($arParams["USE_FILTER"]=="Y"):?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.filter",
	"",
	Array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"FILTER_NAME" => $arParams["FILTER_NAME"],
		"FIELD_CODE" => $arParams["FILTER_FIELD_CODE"],
 		"PROPERTY_CODE" => $arParams["FILTER_PROPERTY_CODE"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
	),
	$component
);
?>
<?endif?>
<?
//������ ��� ������ �������� �� ���������� IB
GLOBAL $arrFilter;
$arrFilter = array(
   'IBLOCK_ID' => array(),
   'IBLOCK_TYPE' => 'news',
);
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"",
	Array(
		"IBLOCK_TYPE"	=>	$arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"	=>	$arParams["IBLOCK_ID"],
		"NEWS_COUNT"	=>	$arParams["NEWS_COUNT"],
		"SORT_BY1"	=>	$sort,//$arParams["SORT_BY1"],
		"SORT_ORDER1"	=>	$sort_order,//$arParams["SORT_ORDER1"],
		//"SORT_BY2"	=>	$arParams["SORT_BY2"],
		//"SORT_ORDER2"	=>	$arParams["SORT_ORDER2"],
		"FIELD_CODE"	=>	$arParams["LIST_FIELD_CODE"],
		"PROPERTY_CODE"	=>	$arParams["LIST_PROPERTY_CODE"],
		"DETAIL_URL"	=>	$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
		"DISPLAY_PANEL"	=>	$arParams["DISPLAY_PANEL"],
		"SET_TITLE"	=>	$arParams["SET_TITLE"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"INCLUDE_IBLOCK_INTO_CHAIN"	=>	$arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
		"CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
		"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
		"CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"DISPLAY_TOP_PAGER"	=>	$arParams["DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER"	=>	$arParams["DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE"	=>	$arParams["PAGER_TITLE"],
		"PAGER_TEMPLATE"	=>	$arParams["PAGER_TEMPLATE"],
		"PAGER_SHOW_ALWAYS"	=>	$arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_DESC_NUMBERING"	=>	$arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME"	=>	$arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
		"DISPLAY_DATE"	=>	$arParams["DISPLAY_DATE"],
		"DISPLAY_NAME"	=>	"Y",
		"DISPLAY_PICTURE"	=>	$arParams["DISPLAY_PICTURE"],
		"DISPLAY_PREVIEW_TEXT"	=>	$arParams["DISPLAY_PREVIEW_TEXT"],
		"PREVIEW_TRUNCATE_LEN"	=>	$arParams["PREVIEW_TRUNCATE_LEN"],
		"ACTIVE_DATE_FORMAT"	=>	$arParams["LIST_ACTIVE_DATE_FORMAT"],
		"USE_PERMISSIONS"	=>	$arParams["USE_PERMISSIONS"],
		"GROUP_PERMISSIONS"	=>	$arParams["GROUP_PERMISSIONS"],
		"FILTER_NAME"	=>	"arrFilter",//$arParams["FILTER_NAME"],
		"HIDE_LINK_WHEN_NO_DETAIL"	=>	$arParams["HIDE_LINK_WHEN_NO_DETAIL"],
		"CHECK_DATES"	=>	$arParams["CHECK_DATES"],
	),
	$component
);?>