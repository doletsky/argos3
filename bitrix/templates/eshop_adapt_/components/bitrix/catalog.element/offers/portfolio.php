<div id="content" class="whole_page padd_top_18 item_card">
	<?
	//ПРИВЯЗКА СЕРТИФИКАТОВ ОСУЩЕСТВЛЯЕТСЯ ПО ТОВАРУ, А НЕ ПРЕДЛОЖЕНИЮ		
	$item_name=$arResult['NAME'];
	
	//инфоблоки для портфолио		
	if(SITE_DIR=='/'){
		$iblock_id_port=8;
	}else{
		$iblock_id_port=14;
	}
		
	//Привязка к элементу	
		
	$arSelect = array("ID", "IBLOCK_ID", "NAME", "DETAIL_PICTURE", "PROPERTY_COMPLETE_ARGOS_LUM", "PROPERTY_COMPLETE_ARGOS_LED", "PROPERTY_MODEL_OF_LAMPS", "PROPERTY_OBJECT_TYPE", "PROPERTY_OBJECT_ADDRESS", "PROPERTY_CITY", "PROPERTY_SERVICE_PHONE", "PROPERTY_THANKS_LETTER", "PROPERTY_MANUFACTURER_OF_LAMPS", "PROPERTY_SITE");
	$arFilter = array(	
		"ACTIVE"=>"Y",
		array(
			"LOGIC" => "OR",
			array("IBLOCK_ID"=>$iblock_id_port, "PROPERTY_COMPLETE_ARGOS_LUM"=>'%'.$item_name.'%'),
			array("IBLOCK_ID"=>$iblock_id_port, "PROPERTY_COMPLETE_ARGOS_LED"=>'%'.$item_name.'%'),
			array("IBLOCK_ID"=>$iblock_id_port, "PROPERTY_MODEL_OF_LAMPS"=>'%'.$item_name.'%'),
		),
	);
	
	$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, $arSelect);
	$count=1;
	//$ar_result->Fetch();

	$arIDs = array();
	
	while($arItem=$ar_result->GetNext())
	{
		if(!in_array($arItem['ID'], $arIDs)){
			$arIDs[] = $arItem['ID'];
			
			if($arItem['CNT']>0)
			{
				/*?><pre><?print_r($arItem);?></pre><?*/
				?>
				<div class="portfolio_wrap<?if($count==3) echo ' last';?>">
					<div class="img_wrap">
						<?
						$src_img = CFile::GetPath($arItem["DETAIL_PICTURE"]);//id картинки
						?>
						<a href="<?=$src_img?>" class="img_wrap fancybox-button">
							<img src="<?=$src_img?>" />
						</a>					
					</div>
					<div class="object_text object_type"><span><?=GetMessage("OBJECT_TYPE")?>: </span><?=$arItem['PROPERTY_OBJECT_TYPE_VALUE']?></div>
					<div class="object_text object_name"><span><?=GetMessage("OBJECT_NAME")?>: </span><?=$arItem['NAME']?></div>
					<div class="object_text object_address"><span><?=GetMessage("CITY")?>: </span><?=$arItem['PROPERTY_CITY_VALUE']?></div>
					<div class="object_text object_address"><span><?=GetMessage("ADDRESS")?>: </span><?=$arItem['PROPERTY_OBJECT_ADDRESS_VALUE']?></div>
					<div class="object_text object_phone"><span><?=GetMessage("TELEPHONE")?>: </span><?=$arItem['PROPERTY_SERVICE_PHONE_VALUE']?></div>
					<div class="object_text object_thanks">
						<span><?=GetMessage("RECOMMENDATION_LETTER")?>: </span>
						<?
						$file_id=$arItem['PROPERTY_THANKS_LETTER_VALUE'];
						$file_info = CFile::GetFileArray($file_id);
						?>
						<a target="_blank" href="<?=$file_info['SRC']?>"><?=$file_info['ORIGINAL_NAME']?></a>
					</div>				
					<div class="object_text object_manufacture"><span><?=GetMessage("MANUFACTURER")?>: </span><?=$arItem['PROPERTY_MANUFACTURER_OF_LAMPS_VALUE']?></div>
					<div class="object_text object_site"><span><?=GetMessage("WEBSITE")?>: </span><?=$arItem['PROPERTY_SITE_VALUE']?></div>
					<?
					if($arItem['PROPERTY_MODEL_OF_LAMPS_VALUE']!='')
					{						
					?>
						<div class="object_text object_model">
							<span><?=GetMessage("MODEL")?>: </span><?=GetStrProp("MODEL_OF_LAMPS", $arItem["IBLOCK_ID"], $arItem["ID"])?>
						</div>
					<?
						
					}
					?>
					<?
					if($arItem['PROPERTY_COMPLETE_ARGOS_LUM_VALUE']!='')
					{						
					?>
						<div class="object_text object_grade">
							<span><?=GetMessage("EQUIPMENT_1")?>: </span><?=GetStrProp("COMPLETE_ARGOS_LUM", $arItem["IBLOCK_ID"], $arItem["ID"])?>
						</div>
					<?
						
					}
					if($arItem['PROPERTY_COMPLETE_ARGOS_LED_VALUE']!='')
					{
					?>
						<div class="object_text object_grade_2">
							<span><?=GetMessage("EQUIPMENT_2")?>: </span><?=GetStrProp("COMPLETE_ARGOS_LED", $arItem["IBLOCK_ID"], $arItem["ID"])?>
						</div>
					<?
						
					}
					?>
				</div>
				<?
				if($count==3)
				{
					echo '<div class="clear"></div>';
					$count=0;
				}
				$count++;
			}
		}
	}
	?>
</div>
