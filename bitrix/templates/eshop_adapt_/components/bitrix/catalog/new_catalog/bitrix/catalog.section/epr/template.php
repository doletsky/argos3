<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if(IsIE() || (strpos($_SERVER['HTTP_USER_AGENT'], 'like Gecko') > 0 && !strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))){
	$TargetWindow = "_self";
} else { 
	$TargetWindow = "_blank";
}?>

<?//ШАБЛОН КАТАЛОГ ТОВАРОВ EPR?>
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
		$arOffersUsed = array();
		foreach ($arr_result_item['OFFERS'] as $key => $arr_result_offers)
		{
			$ofId = $arr_result_offers['ID'];
			if(!in_array($ofId, $arOffersUsed)){
				$res_list=$res_list.'<a href="'.$arr_result_item["DETAIL_PAGE_URL"].'?view=new&offers_id='.$arr_result_offers['ID'].'" target="'.$TargetWindow.'"> '.$arr_result_offers['NAME'].'</a>';
				//'.$arr_result_item['NAME'].' ('.$arr_result_offers['NAME'].')
			}
			$arOffersUsed[] = $ofId;
		}
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
	$ar_result2=CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arResult['IBLOCK_ID'], "SECTION_ID"=>$arResult['ID'], "ACTIVE"=>"Y"), false,Array("UF_ONLY_CATALOG"));
	while($res2=$ar_result2->GetNext())
	{
	   if ($res2["UF_ONLY_CATALOG"]==1)
       {
        continue;
       }
		?>
		<div id="series_<?=$res2['ID']?>" class="catalog_item_wrap">
			<h2 class="catalog_category"><?=$res2['NAME']?></h2>
			<div class="catalog_category_description"><?//=GetMessage("GENERAL_CHARACTERISTICS")?><?=$res2['DESCRIPTION']?></div>
			<?
			$sec_id=$res2['ID'];
			//Получение элементов
			foreach ($arResult['ITEMS'] as $key => $arItem)
			{
				if($sec_id==$arItem['~IBLOCK_SECTION_ID'])
				{
					?>
					<div class="catalog_item">
						<div class="catalog_item_img"><a href="<?=$arItem['DETAIL_PICTURE']['SRC']?>" class="fancybox-button"><img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" /></a><div class="btn_lupa"></div></div>
						<div class="catalog_item_description"><?=$arItem['DETAIL_TEXT']?></div>
						<div class="clear"></div>
					</div>
					<div class="catalog_item_properties">
						<div class="properties_wrap modification">
							<div class="properties_title"><?=GetMessage("MODEL")?></div>
							<?
							$arOffersUsed = array();
							foreach ($arItem['OFFERS'] as $key => $arOffers)
							{
								$ofId = $arOffers['ID'];
								if(!in_array($ofId, $arOffersUsed)){
								
								?>
									<div class="properties_content"><a href="<?=$arItem['DETAIL_PAGE_URL']?>?view=new&offers_id=<?=$arOffers['ID']?>" target="<?=$TargetWindow;?>"><?=$arOffers['NAME']?></a><br/><?echo $arOffers['PROPERTIES']['COMING_SOON']['VALUE'] != '' ? '<span style="color:#DA655B">'.GetMessage("COMING_SOON").'</span>' : ''?></div>
								<?									
								}
								$arOffersUsed[] = $ofId;
							}
							
							?>
						</div>
						<div class="properties_wrap features">
							<div class="properties_title"><?=GetMessage("TECHNICAL_DESCRIPTION")?></div>
							<?
							$arOffersUsed2 = array();
							foreach ($arItem['OFFERS'] as $key => $arOffers)
							{
								$ofId = $arOffers['ID'];
								if(!in_array($ofId, $arOffersUsed2)){
							?>
								<div class="properties_content"><?=$arOffers['DETAIL_TEXT']?></div>							
							<?
								}
								$arOffersUsed2[] = $ofId;
							}
							?>
							<?/*<div class="properties_content"><?=$arItem['PROPERTIES']['TECHNICAL_CHARACTERISTICS']['VALUE']['TEXT']?></div>*/?>
						</div>
						<div class="clear"></div>
					</div>
					<?
				}
			}
			?>
		</div>
		<?
	}
}
?>