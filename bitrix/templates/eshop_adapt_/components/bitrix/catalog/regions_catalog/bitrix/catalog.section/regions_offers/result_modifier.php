<?php
GLOBAL $arrFilter;
//var_dump($arrFilter);

$title_name = '';

$ArrUsersPartners = array();
$arSelect = Array("*","PROP_*");
$arFilter = Array("IBLOCK_ID"=>"43", "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_ID_COMPANY.PROPERTY_MAIN_PARTNERSHIP_ID"=>(int)($_REQUEST['PARENT']));
$resUser = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
$i_user=0;
while($obUser = $resUser->GetNextElement())
{
	$arFieldsUser = $obUser->GetFields();
	$arPropsUser = $obUser->GetProperties();
	$ArrUsersPartners[$i_user]['FIELDS'] = $arFieldsUser;
	$ArrUsersPartners[$i_user]['PROPS'] = $arPropsUser;
	$i_user++;
}
foreach ($arResult['ITEMS'] as $key => &$arItem) {
	$arItem['NEW_OFFERS'] = array();
	foreach ($arItem['OFFERS'] as $key => $offer_dest){
			if ((int) $offer_dest['PROPERTIES']['MAIN_PARTNERSHIP_ID']['VALUE'] === (int)($_REQUEST['PARENT'])) {
				$title_name = $offer_dest['NAME'];
				foreach ($ArrUsersPartners as $keyUsers => $UsersPartners) {
					if ($UsersPartners['PROPS']['ID_COMPANY']['VALUE'] == $offer_dest['ID']){
							
						$offer_dest['USERS'][]= $UsersPartners;
					}
				}
				
				$arItem['NEW_OFFERS'][] = $offer_dest;
				
			}
			
	}
	//var_dump($offer_dest['PROPERTIES']['MAIN_PARTNERSHIP_ID']);

	unset ($arItem['OFFERS']);
	$arItem['OFFERS'] = $arItem['NEW_OFFERS'];
	unset ($arItem['NEW_OFFERS']);

	$APPLICATION->SetPageProperty("title", 'Дистрибьюторы светильников ЖКХ ' . $title_name . ': ' . $arResult['NAME']);
}
?>