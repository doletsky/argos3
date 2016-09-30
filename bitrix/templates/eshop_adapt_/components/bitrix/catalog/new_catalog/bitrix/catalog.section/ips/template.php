<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?

if(IsIE() || (strpos($_SERVER['HTTP_USER_AGENT'], 'like Gecko') > 0 && !strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))){
	$TargetWindow = "_self";
} else { 
	$TargetWindow = "_blank";
}?>

<?//ШАБЛОН КАТАЛОГ ТОВАРОВ IPS?>
<?
if(isset($_GET['filter_props_str']) && $_GET['filter_props_str']!='')
{
	$arr_result=$arResult['ITEMS'];	
	$filter_props_str=$_GET['filter_props_str']; //'78=50&325=регулируемый ток';
	$filter_props_str=explode('&',$filter_props_str); //массив всех пар св-во предложения + значение для фильтрации
	
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
			echo '<pre>',print_r($arr_result_item['IBLOCK_SECTION_ID']),'</pre>';
			$ofId = $arr_result_offers['ID'];
			if(!in_array($ofId, $arOffersUsed)){
				//if($arr_result_item['IBLOCK_SECTION_ID'] ==25):
				$res_list=$res_list.'<a href="'.$arr_result_item["DETAIL_PAGE_URL"].'?view=new&offers_id='.$arr_result_offers['ID'].'"  target="'.$TargetWindow.'">'.$arr_result_item['NAME'].' </a><br>';
				//.$arr_result_item['NAME'].' ('.$arr_result_offers['NAME'].')
				//endif;
				
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
	$ar_result2=CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arResult['IBLOCK_ID'], "SECTION_ID"=>$arResult['ID']), false,Array("UF_ONLY_CATALOG"));
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
			<?
			$sec_id=$res2['ID'];
			
			$arr_offers=array();//массив всех предложений
			//$arr_degree_of_protection=array();//массив всех степеней защиты
			foreach ($arResult['ITEMS'] as $key => $arItem)
			{
				if($sec_id==$arItem['~IBLOCK_SECTION_ID'])
				{				
					foreach ($arItem['OFFERS'] as $key => $arOffers)
					{
						if (!in_array($arOffers['NAME'], $arr_offers)) {
							$arr_offers[]=$arOffers['NAME'];
						}
						/*if (!in_array($arOffers['PROPERTIES']['DEGREE_OF_PROTECTION']['VALUE'], $arr_degree_of_protection)) {
							$arr_degree_of_protection[]=$arOffers['PROPERTIES']['DEGREE_OF_PROTECTION']['VALUE'];
						}*/
					}
				}
			}
			sort($arr_offers);
			//sort($arr_degree_of_protection);
			
			//foreach ($arr_degree_of_protection as $arr_degree_of_protection_el)
			//{
				$arr_offers_new=array();
			?>
				<div class="catalog_item_ips">
					<?/*<div class="catalog_item_ips_title"><?=$arr_degree_of_protection_el?></div>*/?>
					<table class="catalog_item_ips_table">
						<tr>
							<td rowspan="4" class="header_big w141 bg_207"><?=GetMessage("DRIVER_MODELS_TITLE");?></td>
							<td colspan="6" class="header_big bg_29 w97"><?=GetMessage("DRIVER_TYPES_TITLE");?></td>
						</tr>
						<tr>
							<?
							foreach ($arr_offers as $arr_offers_el)
							{
								//$offers_el='no';
								$offers_el='yes';
								foreach ($arResult['ITEMS'] as $key => $arItem)
								{
									if($sec_id==$arItem['~IBLOCK_SECTION_ID'])
									{
										foreach ($arItem['OFFERS'] as $key => $arOffers)
										{
										
											if($arOffers['NAME']==$arr_offers_el)
											{
												//if($arOffers['PROPERTIES']['DEGREE_OF_PROTECTION']['VALUE']==$arr_degree_of_protection_el)
													//$offers_el='yes';
											}
										}
									}
								}
								if($offers_el=='yes')
								{
									$arr_offers_new[]=$arr_offers_el;
									?>
									<td class="header_middle w97"><?=$arr_offers_el?></td>
									<?
								}
							}
							sort($arr_offers_new);
							
							?>
							
						</tr>
						<tr>
							<?
							foreach ($arr_offers as $arr_offers_el)
							{
								//$offers_el='no';
								$offers_el='yes';
								foreach ($arResult['ITEMS'] as $key => $arItem)
								{
									if($sec_id==$arItem['~IBLOCK_SECTION_ID'])
									{
										foreach ($arItem['OFFERS'] as $key => $arOffers)
										{
										
											if($arOffers['NAME']==$arr_offers_el)
											{
												//if($arOffers['PROPERTIES']['DEGREE_OF_PROTECTION']['VALUE']==$arr_degree_of_protection_el)
													//$offers_el='yes';
											}
										}
									}
								}
								if($offers_el=='yes')
								{
									if(CModule::IncludeModule("iblock"))
									{	
										$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>12,"NAME"=>$arr_offers_el), Array("NAME","DETAIL_PICTURE","PROPERTY_DRAWINGS_NAME"));		
										if($res=$ar_result->GetNext())
										{
											$src_img = CFile::GetPath($res["DETAIL_PICTURE"]);//id картинки
											if($src_img)
											{
											?>
												<td class="w97"><a href="<?=$src_img?>" class="fancybox-button"><div class="ips_img"><img src="<?=$src_img?>" /><div class="lupa"></div></div></a></td>
											<?
											}
											else
											{
											?>
												<td class="w97"><div class="ips_img"><div class="lupa"></div></div></td>
											<?
											}
										}
										else
										{
										?>
											<td class="w97">&nbsp;</td>
										<?
										}
									}
								}
							}
							?>
						</tr>
						<tr>
							<?
							foreach ($arr_offers as $arr_offers_el)
							{
								//$offers_el='no';
								$offers_el='yes';
								foreach ($arResult['ITEMS'] as $key => $arItem)
								{
									if($sec_id==$arItem['~IBLOCK_SECTION_ID'])
									{
										foreach ($arItem['OFFERS'] as $key => $arOffers)
										{
										
											if($arOffers['NAME']==$arr_offers_el)
											{
												//if($arOffers['PROPERTIES']['DEGREE_OF_PROTECTION']['VALUE']==$arr_degree_of_protection_el)
													//$offers_el='yes';
											}
										}
									}
								}
								if($offers_el=='yes')
								{
									if(CModule::IncludeModule("iblock"))
									{	
										$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>12,"NAME"=>$arr_offers_el), Array("NAME","PROPERTY_DRAWINGS_FOR_IPS_CATALOG","PROPERTY_DRAWINGS_NAME"));		
										if($res=$ar_result->GetNext())
										{
											$file = CFile::GetPath($res["PROPERTY_DRAWINGS_FOR_IPS_CATALOG_VALUE"]);//id файла
											if($file)
											{
											?>
											<td class="w97"><a href="<?=$file?>" class="fancybox-button"><div class="ips_img"><img src="<?=$file?>" /><div class="lupa"></div></div></a></td>
											<?/*?>
											
											//Это для загрузки пдф
												<td class="w97 drawing">
												<a href="#drawing<?=$res["PROPERTY_DRAWINGS_FOR_IPS_CATALOG_VALUE"]?>" class="fancybox-button">
												
												<div class="lupa"></div>
												
												
												<?=$res['PROPERTY_DRAWINGS_NAME_VALUE']?></a>
												<div id="pdf_drawing<?=$res["PROPERTY_DRAWINGS_FOR_IPS_CATALOG_VALUE"]?>">
													<div class="drawing_pdf" id="drawing<?=$res["PROPERTY_DRAWINGS_FOR_IPS_CATALOG_VALUE"]?>" style=" width:700px; height:400px; margin:0 auto;">
														<object data="<?=$file?>" type="application/pdf" width="700px" height="300px">
															alt: <a href="<?=$file?>">
																<?
																if(SITE_DIR=='/')
																	echo 'Ваш браузер не поддерживает загрузку pdf-файлов. Включите поддержку pdf в настройка вашего браузера или воспользуйтесь другим.';
																else
																	echo 'Your browser does not support loading pdf-files. Turn pdf support in your browser or use another.';
																?>
															</a>
														</object>
													</div>
												</div>
												<script>
													$(document).ready(function() {
														//грабли для удаления самосоздающегося дива-обертки для .drawing_pdf при закрытии фенсибокса (тем не менее в эксплорере не всегда открывается чертеж - выявить баг не удалось)
														$("#fancybox-overlay, #fancybox-close").live('click',function() {
															if($('#fancybox-content .drawing_pdf').length>0)
															{
																var drawing_pdf_id=$('#fancybox-content .drawing_pdf').attr('id');
																var drawing_pdf_content=$('#fancybox-content .drawing_pdf').closest('#fancybox-content').find('div').html();
																$('#pdf_'+drawing_pdf_id).html(drawing_pdf_content);
															}
															$('#fancybox-content').html('');
														});
													});
												
												</script>
												</td><?*/?>
											<?
											}
											else
											{
											?>
												<td class="w97 drawing"><div class="lupa"></div></td>
											<?
											}
										}
										else
										{
										?>
											<td class="w97 drawing">&nbsp;</td>
										<?
										}
									}
								}								
							}
							?>
						</tr>
						<pre><?//print_r($arResult['ITEMS'])?></pre>
						<?
						
						foreach ($arResult['ITEMS'] as $key => $arItem)
						{						
							if($sec_id==$arItem['~IBLOCK_SECTION_ID'])
							{
							?>
								<?
								$str_items='';
								$str_empty='yes';//пустая ли строка
								foreach ($arr_offers_new as $arr_offers_new_el)
								{
									$link='no'; //добавление пустых ячеек
									$arOffersUsed = array();
									foreach ($arItem['OFFERS'] as $key => $arOffers)
									{
										$ofId = $arOffers['ID'];
										if(!in_array($ofId, $arOffersUsed)){									
											if ($arOffers['NAME']==$arr_offers_new_el)
											{
												$str_items=$str_items.'<td class="w97"><a href="'.$arItem["DETAIL_PAGE_URL"].'?view=new&offers_id='.$arOffers['ID'].'" target="'.$TargetWindow.'">'.GetMessage("TO_LINK").'</a></td>';
												$link='yes';
												$str_empty='no';
											}
											$arOffersUsed[] = $ofId;
										}
									}
									if($link=='no')//если нет предложения, добавляем пустую ячейку
									{
										$str_items=$str_items.'<td class="w97"></td>';
									}
								}
								if($str_empty=='no') { //если строка не пуста
								?>
									<tr class="links">
										<td class="header_min"><?=$arItem['NAME']?> <?echo $arItem['PROPERTIES']['COMING_SOON']['VALUE'] != '' ? '<span style="color:#DA655B">'.GetMessage("COMING_SOON").'</span>' : ''?></td>
										<?echo $str_items;?>
									</tr>
								<?
								}
								?>
							<?}
						}?>
					</table>
				</div>
			<?
			//}
			?>
		</div>
		<?
	}
}
?>
<?/*<h3 class="catalog"><?=GetMessage("COMING_SOON");?></h3>
<a class="pdf_catalog_link" href="/bitrix/templates/eshop_adapt_/files/Argust_Treid_2014_2.pdf" target="_blank">Constant Current LED drivers IP20 35-300TA (300-390), 35-350ТD (220-300)</a>
<a class="pdf_catalog_link" href="/bitrix/templates/eshop_adapt_/files/Argust_Treid_2014_3.pdf" target="_blank">Current Constant LED drivers IP20 30-900Т, 37-900Т</a>
<a class="pdf_catalog_link" href="/bitrix/templates/eshop_adapt_/files/Argust_Treid_2014_4.pdf" target="_blank">Current Constant LED driver 60-700T, Cylindrical</a>*/?>
