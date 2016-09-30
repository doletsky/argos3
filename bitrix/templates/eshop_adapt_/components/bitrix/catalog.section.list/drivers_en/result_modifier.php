<?php
global $arrFilter;

$arSelect = Array("ID", "NAME", "PROPERTY_CML2_LINK", "PROPERTY_CML2_LINK", "PROPERTY_TYPE", "DETAIL_PAGE_URL");
$arFilter = Array("IBLOCK_ID"=>49, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC", "NAME"=>"ASC"), array_merge($arrFilter, $arFilter), false, Array("nPageSize"=>50000), $arSelect);
while($ob = $res->GetNextElement()){
	$arFields = $ob->GetFields();
	$arResult['OFFERS'][$arFields['PROPERTY_CML2_LINK_VALUE']][$arFields['ID']] = $arFields;
	$arResult['ALL_OFFERS'][$arFields['ID']] = $arFields;
}

$arSelect = Array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "NAME");
$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement()){
	$arFields = $ob->GetFields();
	
	if(empty($arResult['OFFERS'][$arFields['ID']])) {
		//
	}
	else {
		$arFields['OFFERS'] = $arResult['OFFERS'][$arFields['ID']];
		$arFields['TYPES'] = array();
		foreach ($arFields['OFFERS'] as $offer) {
			$arFields['TYPES'][$offer['PROPERTY_TYPE_VALUE']] = $offer['PROPERTY_TYPE_VALUE'];
			$arResult['SECTION_ELEMENT_TYPES_OFFERS'][$arFields['IBLOCK_SECTION_ID']][$arFields['ID']][$offer['PROPERTY_TYPE_VALUE']][$offer['ID']] = $offer['ID'];
		}
		$arResult['ITEMS'][$arFields['IBLOCK_SECTION_ID']][$arFields['ID']] = $arFields;
	}
}

$arSelect = Array("ID", "NAME", "DETAIL_PICTURE", "PREVIEW_PICTURE");
$arFilter = Array("IBLOCK_ID"=>51, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC", "NAME"=>"ASC"), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($ob = $res->GetNextElement()){
	$arFields = $ob->GetFields();
	$arFields["PREVIEW_PICTURE"] = CFile::GetFileArray($arFields["PREVIEW_PICTURE"]);
	$arFields["DETAIL_PICTURE"] = CFile::GetFileArray($arFields["DETAIL_PICTURE"]);
	$arFields['PREVIEW_PICTURE_TH'] = CFile::ResizeImageGet($arFields['PREVIEW_PICTURE'], array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
	$arFields['DETAIL_PICTURE_TH'] = CFile::ResizeImageGet($arFields['DETAIL_PICTURE'], array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
	
	$arResult['TYPES'][$arFields['ID']] = $arFields;
}

foreach ($arResult['SECTIONS'] as $key=>&$arSection) {
	if(empty($arResult['ITEMS'][$arSection['ID']])) {
		unset($arResult['SECTIONS'][$key]);
	}
	else {
		$arSection['ITEMS'] = $arResult['ITEMS'][$arSection['ID']];
		$arSection['TYPES'] = array();
		foreach ($arSection['ITEMS'] as &$item) {
			$t = 0;
			$tGroup = 0;
			foreach ($item['TYPES'] as $type) {
				$t++;
				if($t > 2) {
					$tGroup ++;
					//$type = $type . '_'. $t;
					//echo $t;
					//continue;
				}
				
				foreach ($item['OFFERS'] as $offerID=>$offer) {
					if(!empty($arResult['SECTION_ELEMENT_TYPES_OFFERS'][$arSection['ID']][$item['ID']][$type][$offerID])) {
						$item['TYPES_OFFERS'][$type]['OFFERS'][$offerID] = $offer;
					}
				}
				$arSection['TYPES'][$type] = $arResult['TYPES'][$type];
			}
		}
	}
}

$COLS = array();
$SECTIONS = array();
foreach ($arResult['SECTIONS'] as &$arSection) {
	$SECTIONS[$arSection['ID']] = $arSection;
	$COLS[$arSection['UF_COL']][$arSection['ID']] = $arSection['UF_ROW'];
	//die();
}
$arResult['SECTIONS'] = $SECTIONS;
//var_dump($COLS);

asort($COLS);

foreach ($COLS as &$COL) {
	asort($COL);
}

$arResult['COLS'] = $COLS;
//print_r($arResult);
//die();
?>