<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$arResult['OFFERS'] = array();
$arResult['FILES'] = array();
//var_dump($arResult['PROPERTIES']['CML2_LINK']['VALUE']);
//var_dump($arResult['PROPERTIES']['TYPE']['VALUE']);

/*$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$arResult['IBLOCK_ID'], "PROPERTY_CML2_LINK"=>$arResult['PROPERTIES']['CML2_LINK']['VALUE']), array('NAME', 'ID'));
while($res=$ar_result->GetNext())
{
	$arResult['OFFERS'][] = $res;
}*/
//$arResult['CATALOG_PRICE_1'] = round($arResult['PRICES']['BASE']['VALUE'], 2);
$arResult['OFFERS'][] = $arResult;
$arResult['PDF'] = false;
$IBLOCK_PDF = 47;
$IBLOCK_CERT = 48;

if($arParams['IBLOCK_TYPE']=='newcatalog_en') {
	$IBLOCK_PDF = 53;
	$IBLOCK_CERT = 52;
}
$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_PDF, "PROPERTY_OFFER"=>$arResult['ID']), array('PROPERTY_FILES'));
while($res=$ar_result->GetNext())
{
	$arResult['PDF'] = CFile::GetPath($res['PROPERTY_FILES_VALUE']);	
}
$arResult['CERT'] = array();
$ar_result=CIblockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_CERT, "PROPERTY_OFFER"=>$arResult['ID']));
while($res=$ar_result->GetNextElement())
{
	$ar_res = $res->GetFields();
	$prps = $res->GetProperties();
	//var_dump($ar_res, $prps);
	//die();
	$CERT = array();
	$CERT['TITLE'] = $ar_res['NAME'];
	$CERT['NAME'] = $prps['CERT']['DESCRIPTION'];
	$CERT['FILE'] = $prps['CERT']['VALUE'];
	$arResult['FILES'][$prps['CERT']['VALUE']] = CFile::GetPath($prps['CERT']['VALUE']);
	foreach ($prps['FILES']["VALUE"] as $key=>$file) {
		$CERT['ITEMS'][$key]['NAME'] = $prps['FILES']['DESCRIPTION'][$key];
		$CERT['ITEMS'][$key]['FILE'] = $file;
		$arResult['FILES'][$file] = CFile::GetPath($file);
	}
	
	$arResult['CERT'][] = $CERT;
}

if(!empty($_GET['certificate_id']) && !empty($arResult['FILES'][$_GET['certificate_id']])) {
	$arResult['FILE_URL'] = $arResult['FILES'][$_GET['certificate_id']];
}

//var_dump($arResult['CERT']);
?>