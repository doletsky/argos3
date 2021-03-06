<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if (!function_exists("showFilePropertyField"))
{
	function showFilePropertyField($name, $property_fields, $values, $max_file_size_show=50000)
	{
		$res = "";

		if (!is_array($values) || empty($values))
			$values = array(
				"n0" => 0,
			);

		if ($property_fields["MULTIPLE"] == "N")
		{
			$res = "<label for=\"\"><input type=\"file\" size=\"".$max_file_size_show."\" value=\"".$property_fields["VALUE"]."\" name=\"".$name."[0]\" id=\"".$name."[0]\"></label>";
		}
		else
		{
			$res = '
			<script type="text/javascript">
				function addControl(item)
				{
					var current_name = item.id.split("[")[0],
						current_id = item.id.split("[")[1].replace("[", "").replace("]", ""),
						next_id = parseInt(current_id) + 1;

					var newInput = document.createElement("input");
					newInput.type = "file";
					newInput.name = current_name + "[" + next_id + "]";
					newInput.id = current_name + "[" + next_id + "]";
					newInput.onchange = function() { addControl(this); };

					var br = document.createElement("br");
					var br2 = document.createElement("br");

					BX(item.id).parentNode.appendChild(br);
					BX(item.id).parentNode.appendChild(br2);
					BX(item.id).parentNode.appendChild(newInput);
				}
			</script>
			';

			$res .= "<label for=\"\"><input type=\"file\" size=\"".$max_file_size_show."\" value=\"".$property_fields["VALUE"]."\" name=\"".$name."[0]\" id=\"".$name."[0]\"></label>";
			$res .= "<br/><br/>";
			$res .= "<label for=\"\"><input type=\"file\" size=\"".$max_file_size_show."\" value=\"".$property_fields["VALUE"]."\" name=\"".$name."[1]\" id=\"".$name."[1]\" onChange=\"javascript:addControl(this);\"></label>";
		}

		return $res;
	}
}


if (!function_exists("PrintPropsForm"))
{
	function PrintPropsForm($arSource = array(), $locationTemplate = ".default")
	{
		if (!empty($arSource))
		{
			?>
				<div>
					<?
					$groups_arr=array('Данные компании','Контактные данные');//Разбиваем на группы
					foreach ($groups_arr as $group_name ) {
					?>
						<div class="checkout_wrap">
							<?							
							if($group_name!='Данные компании' && $group_name!='Реквизиты') {?>						
								<?if(SITE_DIR != '/'){
									if($group_name == $groups_arr[1]){										
										$group_name_en = 'Contacts';		
									}									
									?><div class="checkout_title"><?=$group_name_en?></div><?
								}else{?>
									<div class="checkout_title"><?=$group_name?></div>		
								<?}?>
							<?}?>
							<div class="checkout_content"<?if($group_name=='Доставка') echo ' id="delivery"';?>>
								<?
								foreach($arSource as $arProperties)
								{
									if($arProperties['GROUP_NAME']==$group_name)
									{ /*?><pre style="display:none;"><?print_r($arProperties)?></pre><?*/
										if ($arProperties["TYPE"] == "CHECKBOX")
										{
											?>
											<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" value="">

											<div class="bx_block r1x3 pt8">
												<?=$arProperties["NAME"]?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="bx_sof_req">*</span>
												<?endif;?>
											</div>

											<div class="bx_block r1x3 pt8"><input type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>></div>

											<div style="clear: both;"></div>
											<?
										}
										elseif ($arProperties["TYPE"] == "TEXT")
										{//echo "<pre>",print_r($arProperties['ID']),"</pre>";
											//if($arProperties['ID'] == 49 || $arProperties['ID'] == 10)unset($arProperties['VALUE']);
											?>
											<div class="checkout_field<?if ($arProperties["REQUIED_FORMATED"]=="Y" || $arProperties['ID'] == 49):?> required<?php endif;?>">
												<div class="checkout_name_field">
													<?=htmlspecialchars_decode($arProperties["NAME"])?>
													<?if ($arProperties["REQUIED_FORMATED"]=="Y" || $arProperties['ID'] == 49):?>
														<span class="red">*</span>
													<?endif;?>
												</div>
												
												<input class="order_field_input_text" type="text" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="<?=$arProperties["VALUE"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>">
											</div>
											<?
										}
										elseif ($arProperties["TYPE"] == "SELECT")
										{
											?>
											<br/>
											<div class="bx_block r1x3 pt8">
												<?=$arProperties["NAME"]?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="bx_sof_req">*</span>
												<?endif;?>
											</div>

											<div class="bx_block r3x1">
												<select name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
													<?
													foreach($arProperties["VARIANTS"] as $arVariants):
													?>
														<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
													<?
													endforeach;
													?>
												</select>
											</div>
											<div style="clear: both;"></div>
											<?
										}
										elseif ($arProperties["TYPE"] == "MULTISELECT")
										{
											?>
											<br/>
											<div class="bx_block r1x3 pt8">
												<?=$arProperties["NAME"]?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="bx_sof_req">*</span>
												<?endif;?>
											</div>

											<div class="bx_block r3x1">
												<select multiple name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
													<?
													foreach($arProperties["VARIANTS"] as $arVariants):
													?>
														<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
													<?
													endforeach;
													?>
												</select>
											</div>
											<div style="clear: both;"></div>
											<?
										}
										elseif ($arProperties["TYPE"] == "TEXTAREA")
										{
											$rows = ($arProperties["SIZE2"] > 10) ? 4 : $arProperties["SIZE2"];
											?>
											<div class="checkout_field">
												<div class="checkout_name_field">
													<?=htmlspecialchars_decode($arProperties["NAME"])?>
													<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
														<span class="red">*</span>
													<?endif;?>
												</div>
												<textarea rows="<?=$rows?>" cols="<?=$arProperties["SIZE1"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>
											</div>
											<?
										}
										elseif ($arProperties["TYPE"] == "LOCATION")
										{
											$value = 0;
											if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0)
											{
												foreach ($arProperties["VARIANTS"] as $arVariant)
												{
													if ($arVariant["SELECTED"] == "Y")
													{
														$value = $arVariant["ID"];
														break;
													}
												}
											}
											?>											
											<div class="checkout_field" style="display: none">
												<div class="checkout_name_field">
													<?=$arProperties["NAME"]?>
													<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
														<span class="red">*</span>
													<?endif;?>
												</div>
												<?
												$GLOBALS["APPLICATION"]->IncludeComponent(
													"bitrix:sale.ajax.locations",
													$locationTemplate,
													array(
														"AJAX_CALL" => "N",
														"COUNTRY_INPUT_NAME" => "COUNTRY",
														"REGION_INPUT_NAME" => "REGION",
														"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
														"CITY_OUT_LOCATION" => "Y",
														"LOCATION_VALUE" => $value,
														"ORDER_PROPS_ID" => $arProperties["ID"],
														"ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
														"SIZE1" => $arProperties["SIZE1"],
													),
													null,
													array('HIDE_ICONS' => 'Y')
												);
												?>
											</div>
											<?
										}
										elseif ($arProperties["TYPE"] == "RADIO")
										{
											?>
											<div class="bx_block r1x3 pt8">
												<?=$arProperties["NAME"]?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="bx_sof_req">*</span>
												<?endif;?>
											</div>

											<div class="bx_block r3x1">
												<?
												if (is_array($arProperties["VARIANTS"]))
												{
													foreach($arProperties["VARIANTS"] as $arVariants):
													?>
														<input
															type="radio"
															name="<?=$arProperties["FIELD_NAME"]?>"
															id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"
															value="<?=$arVariants["VALUE"]?>" <?if($arVariants["CHECKED"] == "Y") echo " checked";?> />

														<label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"><?=$arVariants["NAME"]?></label></br>
													<?
													endforeach;
												}
												?>
											</div>
											<div style="clear: both;"></div>
											<?
										}
										elseif ($arProperties["TYPE"] == "FILE")
										{
											?>
											<div class="add_file_title">
												<?=htmlspecialchars_decode($arProperties["NAME"])?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="red">*</span>
												<?endif;?>
											</div>
											<div class="add_file_btn pseudo_inp_file">
												<span class="sel_f"><?=GetMessage("SELECT")?></span>
												<div class="real_inp_file"><?=showFilePropertyField("ORDER_PROP_".$arProperties["ID"], $arProperties, $arProperties["VALUE"], $arProperties["SIZE1"])?></div>
											</div>
											<div class="clear"></div>
											<?
										}
									}
								}
								?>
							</div>
						</div>
						<?
					}
					?>
				</div>
			<?
		}
	}
	?>	
	
	<?
	function PrintPropsForm2($arSource = array(), $locationTemplate = ".default")
	{
		if (!empty($arSource))
		{
			?><div><?
			$groups_arr=array('Доставка');//Разбиваем на группы
			foreach ($groups_arr as $group_name ) {
				?>
				<div class="checkout_wrap">
					<?if($group_name!='Данные компании' && $group_name!='Реквизиты') {
						if(SITE_DIR != '/'){
							$group_name_en = 'Delivery';
							?><div class="checkout_title"><?=$group_name_en?></div><?
						}else{
							?><div class="checkout_title"><?=$group_name?></div>
						<?}?>
					<?}?>
					<div class="checkout_content">
				<?
			}
		}
	}
	?>
	
	<?
	function PrintPropsForm3($arSource = array(), $locationTemplate = ".default")
	{
		if (!empty($arSource))
		{
			?>
				<?/*<div>*/?>
					<?
					$groups_arr=array('Доставка');//Разбиваем на группы
					foreach ($groups_arr as $group_name ) {
					?>
						<?/*<div class="checkout_wrap">*/?>
							<?/*if($group_name!='Данные компании' && $group_name!='Реквизиты') {?><div class="checkout_title"><?=$group_name?></div><?}*/?>
							<?/*<div class="checkout_content">*/?>
								<?
								foreach($arSource as $arProperties)
								{
									if($arProperties['GROUP_NAME']==$group_name)
									{
										/*?><pre style="display:none;"><?print_r($arProperties)?></pre><?*/
										if ($arProperties["TYPE"] == "CHECKBOX")
										{
											?>
											<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" value="">

											<div class="bx_block r1x3 pt8">
												<?=$arProperties["NAME"]?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="bx_sof_req">*</span>
												<?endif;?>
											</div>

											<div class="bx_block r1x3 pt8"><input type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>></div>

											<div style="clear: both;"></div>
											<?
										}
										elseif ($arProperties["TYPE"] == "TEXT")
										{
											?>
											<div class="checkout_field">
												<div class="checkout_name_field">
													<?=htmlspecialchars_decode($arProperties["NAME"])?>
													<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
														<span class="red">*</span>
													<?endif;?>
												</div>
												<input class="order_field_input_text" type="text" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="<?=$arProperties["VALUE"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>">
											</div>
											<?
										}
										elseif ($arProperties["TYPE"] == "SELECT")
										{
											?>
											<br/>
											<div class="bx_block r1x3 pt8">
												<?=$arProperties["NAME"]?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="bx_sof_req">*</span>
												<?endif;?>
											</div>

											<div class="bx_block r3x1">
												<select name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
													<?
													foreach($arProperties["VARIANTS"] as $arVariants):
													?>
														<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
													<?
													endforeach;
													?>
												</select>
											</div>
											<div style="clear: both;"></div>
											<?
										}
										elseif ($arProperties["TYPE"] == "MULTISELECT")
										{
											?>
											<br/>
											<div class="bx_block r1x3 pt8">
												<?=$arProperties["NAME"]?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="bx_sof_req">*</span>
												<?endif;?>
											</div>

											<div class="bx_block r3x1">
												<select multiple name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
													<?
													foreach($arProperties["VARIANTS"] as $arVariants):
													?>
														<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
													<?
													endforeach;
													?>
												</select>
											</div>
											<div style="clear: both;"></div>
											<?
										}
										elseif ($arProperties["TYPE"] == "TEXTAREA")
										{
											$rows = ($arProperties["SIZE2"] > 10) ? 4 : $arProperties["SIZE2"];
											?>
											<div class="checkout_field">
												<div class="checkout_name_field">
													<?=htmlspecialchars_decode($arProperties["NAME"])?>
													<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
														<span class="red">*</span>
													<?endif;?>
												</div>
												<textarea rows="<?=$rows?>" cols="<?=$arProperties["SIZE1"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>
											</div>
											<?
										}
										elseif ($arProperties["TYPE"] == "LOCATION")
										{
											$value = 0;
											if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0)
											{
												foreach ($arProperties["VARIANTS"] as $arVariant)
												{
													if ($arVariant["SELECTED"] == "Y")
													{
														$value = $arVariant["ID"];
														break;
													}
												}
											}
											?>
											<div class="checkout_field" style="display: none">
												<div class="checkout_name_field">
													<?=$arProperties["NAME"]?>
													<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
														<span class="red">*</span>
													<?endif;?>
												</div>
												<?
												$GLOBALS["APPLICATION"]->IncludeComponent(
													"bitrix:sale.ajax.locations",
													$locationTemplate,
													array(
														"AJAX_CALL" => "N",
														"COUNTRY_INPUT_NAME" => "COUNTRY",
														"REGION_INPUT_NAME" => "REGION",
														"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
														"CITY_OUT_LOCATION" => "Y",
														"LOCATION_VALUE" => $value,
														"ORDER_PROPS_ID" => $arProperties["ID"],
														"ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
														"SIZE1" => $arProperties["SIZE1"],
													),
													null,
													array('HIDE_ICONS' => 'Y')
												);
												?>
											</div>
											<?
										}
										elseif ($arProperties["TYPE"] == "RADIO")
										{
											?>
											<div class="bx_block r1x3 pt8">
												<?=$arProperties["NAME"]?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="bx_sof_req">*</span>
												<?endif;?>
											</div>

											<div class="bx_block r3x1">
												<?
												if (is_array($arProperties["VARIANTS"]))
												{
													foreach($arProperties["VARIANTS"] as $arVariants):
													?>
														<input
															type="radio"
															name="<?=$arProperties["FIELD_NAME"]?>"
															id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"
															value="<?=$arVariants["VALUE"]?>" <?if($arVariants["CHECKED"] == "Y") echo " checked";?> />

														<label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"><?=$arVariants["NAME"]?></label></br>
													<?
													endforeach;
												}
												?>
											</div>
											<div style="clear: both;"></div>
											<?
										}
										elseif ($arProperties["TYPE"] == "FILE")
										{
											?>
											<div class="add_file_title">
												<?=htmlspecialchars_decode($arProperties["NAME"])?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="red">*</span>
												<?endif;?>
											</div>
											<div class="add_file_btn pseudo_inp_file">
												<span class="sel_f"><?=GetMessage("SELECT")?></span>
												<div class="real_inp_file"><?=showFilePropertyField("ORDER_PROP_".$arProperties["ID"], $arProperties, $arProperties["VALUE"], $arProperties["SIZE1"])?></div>
											</div>
											<div class="clear"></div>
											<?
										}
									}
								}
								?>
							</div>
						</div>
						<?
					}
					?>
				</div>
			<?
		}
	}
	?>
	
	<?
	function PrintPropsForm4($arSource = array(), $locationTemplate = ".default")
	{
		if (!empty($arSource))
		{
			?>
				<div>
					<?
					$groups_arr=array('Реквизиты');//Разбиваем на группы
					foreach ($groups_arr as $group_name ) {
					?>
						<div class="checkout_wrap">
							<?if($group_name!='Данные компании' && $group_name!='Реквизиты') {?><div class="checkout_title"><?=$group_name?></div><?}?>
							<div class="checkout_content"<?if($group_name=='Доставка') echo ' id="delivery"';?>>
								<?
								foreach($arSource as $arProperties)
								{
									if($arProperties['GROUP_NAME']==$group_name)
									{
										/*?><pre style="display:none;"><?print_r($arProperties)?></pre><?*/
										if ($arProperties["TYPE"] == "CHECKBOX")
										{
											?>
											<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" value="">

											<div class="bx_block r1x3 pt8">
												<?=$arProperties["NAME"]?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="bx_sof_req">*</span>
												<?endif;?>
											</div>

											<div class="bx_block r1x3 pt8"><input type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>></div>

											<div style="clear: both;"></div>
											<?
										}
										elseif ($arProperties["TYPE"] == "TEXT")
										{
											?>
											<div class="checkout_field">
												<div class="checkout_name_field">
													<?=htmlspecialchars_decode($arProperties["NAME"])?>
													<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
														<span class="red">*</span>
													<?endif;?>
												</div>
												<input class="order_field_input_text" type="text" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="<?=$arProperties["VALUE"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>">
											</div>
											<?
										}
										elseif ($arProperties["TYPE"] == "SELECT")
										{
											?>
											<br/>
											<div class="bx_block r1x3 pt8">
												<?=$arProperties["NAME"]?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="bx_sof_req">*</span>
												<?endif;?>
											</div>

											<div class="bx_block r3x1">
												<select name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
													<?
													foreach($arProperties["VARIANTS"] as $arVariants):
													?>
														<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
													<?
													endforeach;
													?>
												</select>
											</div>
											<div style="clear: both;"></div>
											<?
										}
										elseif ($arProperties["TYPE"] == "MULTISELECT")
										{
											?>
											<br/>
											<div class="bx_block r1x3 pt8">
												<?=$arProperties["NAME"]?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="bx_sof_req">*</span>
												<?endif;?>
											</div>

											<div class="bx_block r3x1">
												<select multiple name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
													<?
													foreach($arProperties["VARIANTS"] as $arVariants):
													?>
														<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
													<?
													endforeach;
													?>
												</select>
											</div>
											<div style="clear: both;"></div>
											<?
										}
										elseif ($arProperties["TYPE"] == "TEXTAREA")
										{
											$rows = ($arProperties["SIZE2"] > 10) ? 4 : $arProperties["SIZE2"];
											?>
											<div class="checkout_field">
												<div class="checkout_name_field">
													<?=htmlspecialchars_decode($arProperties["NAME"])?>
													<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
														<span class="red">*</span>
													<?endif;?>
												</div>
												<textarea rows="<?=$rows?>" cols="<?=$arProperties["SIZE1"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>
											</div>
											<?
										}
										elseif ($arProperties["TYPE"] == "LOCATION")
										{
											$value = 0;
											if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0)
											{
												foreach ($arProperties["VARIANTS"] as $arVariant)
												{
													if ($arVariant["SELECTED"] == "Y")
													{
														$value = $arVariant["ID"];
														break;
													}
												}
											}
											?>
											<div class="checkout_field" style="display: none">
												<div class="checkout_name_field">
													<?=$arProperties["NAME"]?>
													<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
														<span class="red">*</span>
													<?endif;?>
												</div>
												<?
												$GLOBALS["APPLICATION"]->IncludeComponent(
													"bitrix:sale.ajax.locations",
													$locationTemplate,
													array(
														"AJAX_CALL" => "N",
														"COUNTRY_INPUT_NAME" => "COUNTRY",
														"REGION_INPUT_NAME" => "REGION",
														"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
														"CITY_OUT_LOCATION" => "Y",
														"LOCATION_VALUE" => $value,
														"ORDER_PROPS_ID" => $arProperties["ID"],
														"ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
														"SIZE1" => $arProperties["SIZE1"],
													),
													null,
													array('HIDE_ICONS' => 'Y')
												);
												?>
											</div>
											<?
										}
										elseif ($arProperties["TYPE"] == "RADIO")
										{
											?>
											<div class="bx_block r1x3 pt8">
												<?=$arProperties["NAME"]?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="bx_sof_req">*</span>
												<?endif;?>
											</div>

											<div class="bx_block r3x1">
												<?
												if (is_array($arProperties["VARIANTS"]))
												{
													foreach($arProperties["VARIANTS"] as $arVariants):
													?>
														<input
															type="radio"
															name="<?=$arProperties["FIELD_NAME"]?>"
															id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"
															value="<?=$arVariants["VALUE"]?>" <?if($arVariants["CHECKED"] == "Y") echo " checked";?> />

														<label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"><?=$arVariants["NAME"]?></label></br>
													<?
													endforeach;
												}
												?>
											</div>
											<div style="clear: both;"></div>
											<?
										}
										elseif ($arProperties["TYPE"] == "FILE")
										{
											?>
											<div class="add_file_title">
												<?=htmlspecialchars_decode($arProperties["NAME"])?>
												<?if ($arProperties["REQUIED_FORMATED"]=="Y"):?>
													<span class="red">*</span>
												<?endif;?>
											</div>
											<div class="add_file_btn pseudo_inp_file">
												<span class="sel_f"><?=GetMessage("SELECT")?></span>
												<div class="real_inp_file"><?=showFilePropertyField("ORDER_PROP_".$arProperties["ID"], $arProperties, $arProperties["VALUE"], $arProperties["SIZE1"])?></div>
											</div>
											<div class="clear"></div>
											<?
										}
									}
								}
								?>
							</div>
						</div>
						<?
					}
					?>
				</div>
			<?
		}
	}
}
?>