<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if(IsIE() || (strpos($_SERVER['HTTP_USER_AGENT'], 'like Gecko') > 0 && !strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))){
	$TargetWindow = "_self";
} else { 
	$TargetWindow = "_blank";
}?>

<?//ШАБЛОН КАТАЛОГ ТОВАРОВ Модули?>
<?
if(isset($_GET['filter_props_str']) && $_GET['filter_props_str']!='')
{
	$arr_result=$arResult['ITEMS'];	
	$filter_props_str=$_GET['filter_props_str'];
	$filter_props_str=explode('&',$filter_props_str);//массив всех пар св-во предложения + значение для фильтрации
	
	foreach ($arr_result as $key => $arItem)
	{
		foreach ($arItem['OFFERS'] as $key2 => $arOffers)
		{
			$del='no';
			foreach ($arOffers['PROPERTIES'] as $key3 => $arOffersProps)
			{
				if (in_array($arOffersProps['ID'].'='.$arOffersProps['VALUE'], $filter_props_str)) {
					$del='exactly_no';
				}
				if (!in_array($arOffersProps['ID'].'='.$arOffersProps['VALUE'], $filter_props_str))
				{
					if($del!='exactly_no')
						$del='yes';
				}
			}
			if($del=='yes')
				unset($arr_result[$key]['OFFERS'][$key2]);
		}
	}
	$res_list='';
	foreach ($arr_result as $key => $arr_result_item) {		
		$res_list=$res_list.'<a href="'.$arr_result_item["DETAIL_PAGE_URL"].'?view=new&offers_id='.$arr_result_offers['ID'].'" target="'.$TargetWindow.'">'.$arr_result_item['NAME'].'</a>';
	}
	?>
	<div style="display:none;" id="filter_items_res"><?=$res_list?></div>
	<?
}
?>

<?
if (!empty($arResult['ITEMS']))
{
	//Получение секций
	$ar_result2=CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arResult['IBLOCK_ID'], "SECTION_ID"=>$arResult['ID'], "ACTIVE" => "Y"), false,Array("UF_ONLY_CATALOG"));
	while($res2=$ar_result2->GetNext())
	{
	   if ($res2["UF_ONLY_CATALOG"]==1)
       {
        continue;
       }
	   
		?>
		<div id="series_<?=$res2['ID']?>" class="catalog_item_wrap">
			<h2 class="catalog_category"><?=$res2['NAME']?></h2>
			<div class="catalog_category_description"><?=GetMessage("GENERAL_CHARACTERISTICS")?><?=$res2['DESCRIPTION']?></div>
			<div class="catalog_item_modules">
				<table class="catalog_item_modules_table">							
					<tr class="header_main">
						<td class="w108"><?=GetMessage("MODEL")?></td>
						<td class="w68"><?=GetMessage("DIMENSION")?></td>
						<td class="w43"><?=GetMessage("QTY")?></td>
						<td class="w43"><?=GetMessage("CRI")?></td>
						<td class="w68"><?=GetMessage("PCB_MATERIAL")?></td>
						<td class="w70"><?=GetMessage("CONNECTION_TYPE")?></td>
						<td class="w43"><?=GetMessage("LM")?></td>
						<td class="w43"><?=GetMessage("LM_W")?></td>
						<td class="w63"><?=GetMessage("W")?></td>
						<td class="w63"><?=GetMessage("V")?></td>
						<td class="w63"><?=GetMessage("OUTPUT_CURRENT")?></td>
						<td class="w43"><?=GetMessage("CCT")?></td>
					</tr>
					<?
					$sec_id=$res2['ID'];
					
					//Получение элементов
					foreach ($arResult['ITEMS'] as $key => $arItem)
					{
						if($sec_id==$arItem['~IBLOCK_SECTION_ID'])
						{		
							
							?>
							<tr class="data">
								<td class="w108"><a href="<?=$arItem['DETAIL_PAGE_URL']?>?view=new" target="<?=$TargetWindow;?>"><?=$arItem['NAME']?></a><br/><?echo $arItem['PROPERTIES']['COMING_SOON']['VALUE'] != '' ? '<span style="color:#DA655B">'.GetMessage("COMING_SOON").'</span>' : ''?></td>
								<td class="w68"><?=$arItem['PROPERTIES']['MODULES_DIMENSIONS']['VALUE']?></td>
								<td class="w43"><?=$arItem['PROPERTIES']['MODULES_LED']['VALUE']?></td>
								<td class="w43"><?=$arItem['PROPERTIES']['MODULES_CRI']['VALUE']?></td>
								<td class="w68"><?=$arItem['PROPERTIES']['MODULES_MATERIAL']['VALUE']?></td>
								<td class="w70"><?=$arItem['PROPERTIES']['MODULES_VIEW_COMMUTATION']['VALUE']?></td>
								<td class="w43"><?=$arItem['PROPERTIES']['MODULES_LM']['VALUE']?></td>
								<td class="w43"><?=$arItem['PROPERTIES']['MODULES_LM_W']['VALUE']?></td>
								<td class="w63"><?=$arItem['PROPERTIES']['MODULES_RATING_W']['VALUE']?></td>
								<td class="w63"><?=$arItem['PROPERTIES']['MODULES_RATING_V']['VALUE']?></td>
								<td class="w63"><?=$arItem['PROPERTIES']['MODULES_AMPERAGE']['VALUE']?></td>
								<td class="w43"><?=$arItem['PROPERTIES']['MODULES_SSC']['VALUE']?></td>
							</tr>
							<?
						}
					}
					?>
				</table>
			</div>
		</div>
		<?
	}
}
?>