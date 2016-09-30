<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

if(!empty($arResult["CATEGORIES"])):?>
<div class="title-search-wrap">
	<table class="title-search-result">
		<?
		
		foreach($arResult["CATEGORIES"] as $category_id => $arCategory)
		{?>
			<?/*<tr>
				<th class="title-search-separator">&nbsp;</th>
				<td class="title-search-separator">&nbsp;</td>
			</tr>*/?>
			<?$count=1;?>
			<?foreach($arCategory["ITEMS"] as $i => $arItem)
			{
			
			
				if($count==2)
					$add_class='second';
				else
					$add_class='';
			?>
				<?if(isset($arItem["ICON"])) {?>
			
					<?/*if($i == 0):?>
						<th>&nbsp;<?echo $arCategory["TITLE"]?></th>
					<?else:?>
						<th>&nbsp;</th>
					<?endif*/?>

					<?if($category_id === "all"){?>
						<?/*<td class="title-search-all"><a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></td>*/?>
					<?}
					elseif(isset($arItem["ICON"])){?>
						<?
						$link="";
						$product_id=$arItem['ITEM_ID'];					
						
						if(CModule::IncludeModule("catalog")) {
							$ar_res = CCatalogProduct::GetByIDEx($product_id);//получаем все свойства продукта
							$iblock_id=$ar_res['IBLOCK_ID'];
							$iblock_sec_id=$ar_res['IBLOCK_SECTION_ID'];						
							$product_code=$ar_res['CODE'];
							if($iblock_id==10)
								$offer_id=11;
							if($iblock_id==2)
								$offer_id=4;
						}
						
						//Проверяем, серия это или нет. Если серия, присваиваем id родительской категории			
						$arFilter1=array("IBLOCK_ID"=>$iblock_id,"ID"=>$iblock_sec_id);//id инфоблока и id секции
						//Получаем родительскую секцию
						$rsResult1=CIBlockSection::GetList(array("SORT"=>"ASC"),$arFilter1,false,$arSelect=array());
						if($ar1=$rsResult1->GetNext())
						{
							$sec_id_new=$ar1['IBLOCK_SECTION_ID'];
							$sec_code=$ar1['CODE'];
							$sec_id_new_temp= $ar1['IBLOCK_SECTION_ID'];
						}
						//проверяем родительскую секцию на серийность
						$arFilter=array("IBLOCK_ID"=>$iblock_id,"ID"=>$sec_id_new);//id инфоблока и id секции
						$rsResult=CIBlockSection::GetList(array("SORT"=>"ASC"),$arFilter,false,$arSelect=array("UF_*"));
						$catalog_list_view="";
						if($ar=$rsResult->GetNext())
						{
							if($ar['UF_CATALOG_LIST_VIEW']!='')//для шаблона каталога с Сериями
							{
								$CATALOG_LIST_VIEW=htmlspecialchars_decode($ar['UF_CATALOG_LIST_VIEW']);				
								$rsEnum = CUserFieldEnum::GetList(array(), array("ID" =>$CATALOG_LIST_VIEW)); // $CATALOG_LIST_VIEW - возвращаемый ID значения 
								$arEnum = $rsEnum->GetNext(); 
								$catalog_list_view=$arEnum['XML_ID'];
							}
							if($catalog_list_view=='series')
							{
								$sec_id=$sec_id_new;
								$sec_code=$ar['CODE'];
							}
						}
						$link.=SITE_DIR.'production/catalog_online/'.$sec_code.'/'.$product_code.'/';
				
						//Получение всех родительских категорий
						$rsPath = GetIBlockSectionPath($iblock_id, $iblock_sec_id); 
						while($arPath=$rsPath->GetNext())
						{
							//Получаем тип каталога
							$arFilter=array("IBLOCK_ID"=>$iblock_id,"ID"=>$arPath["ID"]);//id инфоблока и id секции
							$rsResult=CIBlockSection::GetList(array("SORT"=>"ASC"),$arFilter,false,$arSelect=array("UF_*"));
							while($ar=$rsResult->GetNext()) 
							{
								if($ar['UF_CATALOG_VIEW']!='')//для шаблона каталога
								{
									$CATALOG_VIEW=htmlspecialchars_decode($ar['UF_CATALOG_VIEW']);				
									$rsEnum = CUserFieldEnum::GetList(array(), array("ID" =>$CATALOG_VIEW)); // $CATALOG_VIEW - возвращаемый ID значения 
									$arEnum = $rsEnum->GetNext(); 
									$catalog_view=$arEnum['XML_ID'];
								}
							}
							if($catalog_view=='modules' || $catalog_view=='ips' || $catalog_view=='epr')
							{
								$link.='?view=new';
							}
						}
						
						$arIDOffers = array();
						$arNameOffers = array();
							
						$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$offer_id,"PROPERTY_MODEL"=>$product_id), false);//Array("NAME","ID","IBLOCK_ID","PROPERTY_MODEL"));		
						while($res=$ar_result->GetNext())//если есть предложения
						{
							//$link.='&offers_id='.$res['ID'];
							$arIDOffers[] = $res['ID'];
							$arNameOffers[] = $res['NAME'];
						}
						
						if(!empty($arIDOffers)){
							foreach($arIDOffers as $k=>$OfferId){			
								if($count==2)
									$add_class='second';
								else
									$add_class='';
								?>
								<tr><td class="title-search-item"><div class="<?=$add_class?>">
								<??>
								<a href="<?echo /*$arItem["URL"].*/$link.'&offers_id='.$OfferId?>" target="_blank">
								<?/*<img src="<?echo $arItem["ICON"]?>">*/?>
								<?//echo "<pre>", print_r($sec_id_new_temp),"</pre>";
								if($sec_id_new_temp == 25 ):
									echo $arItem["NAME"];
								else:
									echo $arNameOffers[$k];
								endif;
								?>
								<?//echo $arItem["NAME"].'-'.$arNameOffers[$k]?>
								</a>
								</div>
								</td></tr>
								<?
								if($count==2)
									$count=0;
								$count++;
							}
						}else{
						?>
						<?//echo "<pre>",print_r($arItem),"</pre>";?>
							<tr><td class="title-search-item"><div class="<?=$add_class?>">
								<a href="<?echo /*$arItem["URL"].*/$link?>" target="_blank">
								<?/*<img src="<?echo $arItem["ICON"]?>">*/?><?echo $arItem["NAME"]?>
								</a>
									</div>
								</td>
							</tr>
						<?/*<pre><?print_r($ar_res)?></pre>*/?>
						<?	
							if($count==2)
								$count=0;
							$count++;
						}
						
						?>
					<?}
					else{?>
						<?/*<td class="title-search-more"><a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></td>*/?>
					<?}?>
				
				<?}?>
			<?}
		}?>
		<?/*<tr>
			<th class="title-search-separator">&nbsp;</th>
			<td class="title-search-separator">&nbsp;</td>
		</tr>*/?>
	</table>
	<div class="clear"></div>
	<?/*<div class="title-search-fader"></div>*/?>
</div>
<?endif;
?>