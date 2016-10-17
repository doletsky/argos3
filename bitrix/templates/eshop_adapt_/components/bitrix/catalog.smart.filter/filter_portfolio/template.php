<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
CJSCore::Init(array("fx"));
?>

<?
//Меняем порядом вывода полей
$new_arr=array();
if(SITE_DIR=='/en/')
{
	$new_arr[]=$arResult["ITEMS"]['257'];	
	$new_arr[]=$arResult["ITEMS"]['171'];
	$new_arr[]=$arResult["ITEMS"]['259'];
}
if(SITE_DIR=='/')
{
	$new_arr[]=$arResult["ITEMS"]['258'];
	$new_arr[]=$arResult["ITEMS"]['84'];
	$new_arr[]=$arResult["ITEMS"]['260'];
}
?>
<div id="filter_portfolio">
		<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter">
			<?foreach($arResult["HIDDEN"] as $arItem):?>
				<input
					type="hidden"
					name="<?echo $arItem["CONTROL_NAME"]?>"
					id="<?echo $arItem["CONTROL_ID"]?>"
					value="<?echo $arItem["HTML_VALUE"]?>"
				/>
			<?endforeach;?>
			<?foreach($new_arr as $key=>$arItem):?>
				<?if(isset($arItem["PRICE"])):?>
					<?
					if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
						continue;
					?>
					<div class="bx_filter_container price">
						<span class="bx_filter_container_title"><?=$arItem["NAME"]?></span>
						<div class="bx_filter_param_area">
							<div class="bx_filter_param_area_block"><div class="bx_input_container">
									<input
										class="min-price"
										type="text"
										name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
										id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
										value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
										size="5"
										onkeyup="smartFilter.keyup(this)"
									/>
							</div></div>
							<div class="bx_filter_param_area_block"><div class="bx_input_container">
									<input
										class="max-price"
										type="text"
										name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
										id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
										value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
										size="5"
										onkeyup="smartFilter.keyup(this)"
									/>
							</div></div>
							<div style="clear: both;"></div>
						</div>
						<div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
							<div class="bx_ui_slider_range" style="left: 0; right: 0%;"  id="drag_tracker_<?=$key?>"></div>
							<a class="bx_ui_slider_handle left"  href="javascript:void(0)" style="left:0;" id="left_slider_<?=$key?>"></a>
							<a class="bx_ui_slider_handle right" href="javascript:void(0)" style="right:0%;" id="right_slider_<?=$key?>"></a>
						</div>
						<div class="bx_filter_param_area">
							<div class="bx_filter_param_area_block" id="curMinPrice_<?=$key?>"><?=$arItem["VALUES"]["MIN"]["VALUE"]?></div>
							<div class="bx_filter_param_area_block" id="curMaxPrice_<?=$key?>"><?=$arItem["VALUES"]["MAX"]["VALUE"]?></div>
							<div style="clear: both;"></div>
						</div>
					</div>

					<script type="text/javascript" defer="defer">
						var DoubleTrackBar<?=$key?> = new cDoubleTrackBar('drag_track_<?=$key?>', 'drag_tracker_<?=$key?>', 'left_slider_<?=$key?>', 'right_slider_<?=$key?>', {
							OnUpdate: function(){
								BX("<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>").value = this.MinPos;
								BX("<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>").value = this.MaxPos;
							},
							Min: parseFloat(<?=$arItem["VALUES"]["MIN"]["VALUE"]?>),
							Max: parseFloat(<?=$arItem["VALUES"]["MAX"]["VALUE"]?>),
							MinInputId : BX('<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>'),
							MaxInputId : BX('<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>'),
							FingerOffset: 8,
							MinSpace: 1,
							RoundTo: 1
						});
					</script>
				<?endif?>
			<?endforeach?>

			<?foreach($new_arr as $key=>$arItem):?>
				<?if($arItem["PROPERTY_TYPE"] == "N" ):?>
					<?
					if (!$arItem["VALUES"]["MIN"]["VALUE"] || !$arItem["VALUES"]["MAX"]["VALUE"] || $arItem["VALUES"]["MIN"]["VALUE"] == $arItem["VALUES"]["MAX"]["VALUE"])
						continue;
					?>					
					<div class="bx_filter_container price">
						<span class="bx_filter_container_title"><?=$arItem["NAME"]?></span>
						<div class="bx_filter_param_area">
							<div class="bx_filter_param_area_block"><div class="bx_input_container">
								<input
									class="min-price"
									type="text"
									name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
									value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
								/>
							</div></div>
							<div class="bx_filter_param_area_block"><div class="bx_input_container">
								<input
									class="max-price"
									type="text"
									name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
									id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
									value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
									size="5"
									onkeyup="smartFilter.keyup(this)"
								/>
							</div></div>
							<div style="clear: both;"></div>
						</div>
						<div class="bx_ui_slider_track" id="drag_track_<?=$key?>">
							<div class="bx_ui_slider_range" style="left: 0; right: 0%;"  id="drag_tracker_<?=$key?>"></div>
							<a class="bx_ui_slider_handle left"  href="javascript:void(0)" style="left:0;" id="left_slider_<?=$key?>"></a>
							<a class="bx_ui_slider_handle right" href="javascript:void(0)" style="right:0%;" id="right_slider_<?=$key?>"></a>
						</div>
						<div class="bx_filter_param_area">
							<div class="bx_filter_param_area_block" id="curMinPrice_<?=$key?>"><?=$arItem["VALUES"]["MIN"]["VALUE"]?></div>
							<div class="bx_filter_param_area_block" id="curMaxPrice_<?=$key?>"><?=$arItem["VALUES"]["MAX"]["VALUE"]?></div>
							<div style="clear: both;"></div>
						</div>
					</div>
					<script type="text/javascript" defer="defer">
						var DoubleTrackBar<?=$key?> = new cDoubleTrackBar('drag_track_<?=$key?>', 'drag_tracker_<?=$key?>', 'left_slider_<?=$key?>', 'right_slider_<?=$key?>', {
							OnUpdate: function(){
								BX("<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>").value = this.MinPos;
								BX("<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>").value = this.MaxPos;
							},
							Min: parseFloat(<?=$arItem["VALUES"]["MIN"]["VALUE"]?>),
							Max: parseFloat(<?=$arItem["VALUES"]["MAX"]["VALUE"]?>),
							MinInputId : BX('<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>'),
							MaxInputId : BX('<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>'),
							FingerOffset: 8,
							MinSpace: 1,
							RoundTo: 1
						});
					</script>
				<?elseif(!empty($arItem["VALUES"]) && !isset($arItem["PRICE"])):?>
					<div class="pseudo-select<?if($arItem["CODE"]=='OBJECT_TYPE')echo' w300 float_l marg_r_15'; if($arItem["CODE"]=='TYPE_OF_LUM')echo' w375 float_l';?>">
						<div class="select"><?=$arItem["NAME"]?></div>
						<ul class="options<?if($arItem["CODE"]=='CITY') echo " city";?>">
							<li class="all"><span class="check"><?=$arItem["NAME"]?></span></li>
							<?foreach($arItem["VALUES"] as $val => $ar):?>
								<li class="lvl2<?echo $ar["DISABLED"] ? ' disabled': ''?>">
									<span class="<?echo $ar["CHECKED"] ? ' check': ''?>"><?echo $ar["VALUE"];?></span>
									<input
										type="checkbox"
										value="<?echo $ar["HTML_VALUE"]?>"
										name="<?echo $ar["CONTROL_NAME"]?>"
										id="<?echo $ar["CONTROL_ID"]?>"
										<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
										onchange="smartFilter.click(this)"
										<?if ($ar["DISABLED"]):?>disabled<?endif?>
									/>
									<?/*<label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label>*/?>
								</li>
							<?endforeach;?>
						</ul>
					</div>
				<?/*<div class="bx_filter_container">
					<span class="bx_filter_container_title"><?=$arItem["NAME"]?></span>
					<div class="bx_filter_block">
						<?foreach($arItem["VALUES"] as $val => $ar):?>
						<span class="<?echo $ar["DISABLED"] ? 'disabled': ''?>">
							<input
								type="checkbox"
								value="<?echo $ar["HTML_VALUE"]?>"
								name="<?echo $ar["CONTROL_NAME"]?>"
								id="<?echo $ar["CONTROL_ID"]?>"
								<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
								onclick="smartFilter.click(this)"
								<?if ($ar["DISABLED"]):?>disabled<?endif?>
							/>
							<label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label>
						</span>
						<?endforeach;?>
					</div>
				</div>*/?>
				<?endif;?>
			<?endforeach;?>
			<div style="clear: both;"></div>
			<div class="bx_filter_control_section" style="display:none;">
				<span class="icon"></span><input class="bx_filter_search_button" type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>" />
				<input class="bx_filter_search_button" type="submit" id="del_filter" name="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" />

				<div class="bx_filter_popup_result" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;top: 75px;left: 25px;right: 25px;">
					<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
					<a href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
					<!--<span class="ecke"></span>-->
				</div>
			</div>
		</form>
		<div style="clear: both;"></div>
</div>
<script>
	var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>');
</script>