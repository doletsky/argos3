<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<pre><?//print_r($arResult)?></pre>
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
	<?foreach($arResult["HIDDEN"] as $arItem):?>
		<input
			type="hidden"
			name="<?echo $arItem["CONTROL_NAME"]?>"
			id="<?echo $arItem["CONTROL_ID"]?>"
			value="<?echo $arItem["HTML_VALUE"]?>"
		/>
	<?endforeach;?>
	<div id="smart_filter" class="filtren">
		<div class="filter_title"><?=GetMessage("TITLE")?></div>
		<?
		$count=1;
		$count_all=count($arResult["ITEMS"])-1;
		foreach($arResult["ITEMS"] as $arItem)
		{
			if(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"]))
			{
				if(($arResult['FORM_ACTION'] == '/production/catalog_online/svetilniki/' || $arResult['FORM_ACTION'] == '/en/production/catalog_online/led_lights/') && ($arItem["ID"]=="326" || $arItem["ID"]=="325")){
				
				}else{
					?>
					<div class="filter_step s_<?=$arItem["ID"]?>">
						<div class="filter_step_title"><?=GetMessage('STEP')?> <?echo ($arItem["ID"]!== '131' && $arItem["ID"]!== '79') ? $count : '2.1'?><?//=$count_all?></div>
						<div class="filter_step_name"><?=$arItem["NAME"]?></div>
						<?
						$one_count=1;
						$one_count_val='';
						foreach($arItem["VALUES"] as $val2 => $ar2) {
							if($one_count==1)
								$one_count_val=$ar2["VALUE"];
							$one_count++;
						}
						/*if($arItem['PROPERTY_TYPE']=='L'){*/
						?>					
						<div class="filter_step_select <?echo ($arItem["ID"]=="326" || $arItem["ID"]=="325") ? "inactive" : ""?>"><?echo ($arItem["ID"]=="326" || $arItem["ID"]=="325") ? GetMessage("CT_BCSF_FILTER_REGULATED") : GetMessage("CT_BCSF_FILTER_SELECT")?><?//=$one_count_val?><div class="filter_step_select_btn"></div></div>
						<ul id="ul_<?echo $arItem["ID"]?>">
							<li id="select_step" class="lvl2 step_reset">								
								<label for=""><?echo GetMessage("CT_BCSF_FILTER_SELECT")?></label>							
							</li>
							<?foreach($arItem["VALUES"] as $val => $ar):?>
								<li id="select_step" class="lvl2<?echo $ar["DISABLED"]? ' lvl2_disabled': ''?>">
									<input type="checkbox" value="<?echo $ar["HTML_VALUE"]?>" name="<?echo $ar["CONTROL_NAME"]?>" id="<?echo $ar["CONTROL_ID"]?>" <?echo $ar["CHECKED"]? 'checked="checked"': ''?> onclick="smartFilter.click(this)" />
									<label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label>
								</li>
							<?endforeach;?>
						</ul>
						<?/*}elseif($arItem['PROPERTY_TYPE']=='S'){?>
							<div id="select_step" class="lvl2">								
								<input type="text" value="" name="<?echo $ar["CONTROL_NAME"]?>" id="<?echo $ar["CONTROL_ID"]?>" onkeyup="smartFilter.click(this)" />							
							</div>						
						<?}*/?>
					</div>
					<?				
					if($arItem["ID"]!== '131' && $arItem["ID"]!== '79'){
						$count++;
					}
				}
			}
		}
		?>
		
		
		<?/*
		<ul>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?if($arItem["PROPERTY_TYPE"] == "N" || isset($arItem["PRICE"])):?>
			<li class="lvl1"> <a href="#" onclick="BX.toggle(BX('ul_<?echo $arItem["ID"]?>')); return false;" class="showchild"><?=$arItem["NAME"]?></a>
				<ul id="ul_<?echo $arItem["ID"]?>">
					<?
						//$arItem["VALUES"]["MIN"]["VALUE"];
						//$arItem["VALUES"]["MAX"]["VALUE"];
					?>
					<li class="lvl2">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td>
									<span class="min-price"><?echo GetMessage("CT_BCSF_FILTER_FROM")?></span>
								</td>
								<td>
									<span class="max-price"><?echo GetMessage("CT_BCSF_FILTER_TO")?></span>
								</td>
							</tr>
							<tr>
								<td><input
									class="min-price"
									type="text"
									name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
									value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
								/></td>
								<td><input
									class="max-price"
									type="text"
									name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
									value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
								/></td>
							</tr>
						</table>
					</li>
				</ul>
			</li>
			<?elseif(!empty($arItem["VALUES"])):;?>
			<li class="lvl1"> <a href="#" onclick="BX.toggle(BX('ul_<?echo $arItem["ID"]?>')); return false;" class="showchild"><?=$arItem["NAME"]?></a>
				<ul id="ul_<?echo $arItem["ID"]?>">
					<?foreach($arItem["VALUES"] as $val => $ar):?>
					<li class="lvl2<?echo $ar["DISABLED"]? ' lvl2_disabled': ''?>"><input
						type="checkbox"
						value="<?echo $ar["HTML_VALUE"]?>"
						name="<?echo $ar["CONTROL_NAME"]?>"
						id="<?echo $ar["CONTROL_ID"]?>"
						<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
						onclick="smartFilter.click(this)"
					/><label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label></li>
					<?endforeach;?>
				</ul>
			</li>
			<?endif;?>
		<?endforeach;?>
		</ul>
		*/?>
		
		<input style="display:none;" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
		<input style="display:none;" type="submit" id="del_filter" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" />
		<div class="filter_result"><?=GetMessage("RES")?> <div id="res">-</div></div>
		<?/*<div class="modef" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?>>
			<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
			<a href="<?echo $arResult["FILTER_URL"]?>" class="showchild"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
			<!--<span class="ecke"></span>-->
		</div>*/?>
	</div>
</form>
<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>');
</script>