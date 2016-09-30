<?
if(isset($_GET['filter_props_str']) && $_GET['filter_props_str']!='')
{
		foreach ($arResult['ALL_OFFERS'] as $key => $arr_result_item)
		{

				$res_list=$res_list.'<a href="'.$arr_result_item["DETAIL_PAGE_URL"].'"  target="_blank">'.$arr_result_item['NAME'].' </a><br>';
		}
	?>
	<div style="display:none;" id="filter_items_res"><?=$res_list?></div>
<?
}
?>
<div class="clear"></div>
<p class="text_page_info_2">Click to jump to the group</p>
<div class="tabs_simple_style">
<?php foreach ($arResult['COLS'] as $S=>$COL):?>
	<ul>
		<?php foreach ($COL as $SECTION_ID=>$ROW):?>
			<?php $arSection = $arResult['SECTIONS'][$SECTION_ID];?>
			<li class="tab_simple_style_link"><a class="link" href="#sect<?php echo $arSection['ID']?>"><?php echo $arSection['NAME']?></a></li>
		<?php endforeach;?>
	</ul>
<?php endforeach;?>
</div>
<div>
	<?php foreach ($arResult['SECTIONS'] as &$arSection):?>
	<div class="catalog_item_wrap">
		<a name="sect<?php echo $arSection['ID']?>"></a>
		<h3 class="catalog_category"><?php echo $arSection['UF_NAME'] ? $arSection['UF_NAME'] : 'Не заполнено название'?></h3>
		<div class="catalog_category_description"><?php echo $arSection['DESCRIPTION']?></div>
		<div class="catalog_item_ips">
		<?php $types = array_chunk($arSection['TYPES'], 2, true);
			foreach ($types as $type) {
				printTable($arSection, $type);
				//var_dump($section);
			}
		?>
		<?php //var_dump($arSection['TYPES']);?>
			<?php //printTable($arSection);?>
		</div>
	</div>
	<?php endforeach;?>
	
</div>


<?php function printTable($arSection, $types)
{
?>
	<table class="catalog_item_ips_table">
	<tr>
	<td class="header_big version bg_207" rowspan="3">VERSION</td>
	<td class="header_big bg_29 " colspan="6">LED DRIVER TYPE</td>
	</tr>
	<tr>
					<?php foreach ($types as $type):?>
					<td class="header_middle " colspan="2"><?php echo $type['NAME']?></td>
					<?php endforeach;?>
					</tr>
					<tr>
					<?php foreach ($types as $type):?>
					<td class="header_middle " colspan="2">
					
					<table>				
					<tr><td class="header_middle ">Drawing</td><td class="header_middle ">Photo</td></tr>
					<tr class="img">
						<td class="">
						<?php if(!empty($type['PREVIEW_PICTURE']['SRC'])):?>
						<a href="<?php echo $type['PREVIEW_PICTURE']['SRC']?>" class="fancybox-button">
							<div class="ips_img" style="overflow: hidden">
								<img src="<?php echo $type['PREVIEW_PICTURE_TH']['src']?>" style="height:auto">
								<div class="lupa"></div>
							</div>
						</a>
						<?php endif;?>
						</td>
						<td class="">
						<?php if(!empty($type['DETAIL_PICTURE']['SRC'])):?>
						<a href="<?php echo $type['DETAIL_PICTURE']['SRC']?>" class="fancybox-button">
							<div class="ips_img" style="overflow: hidden">
								<img src="<?php echo $type['DETAIL_PICTURE_TH']['src']?>" style="height:auto">
								<div class="lupa"></div>
							</div>
						</a>
						<?php endif;?>
						</td>
					</tr>
					<tr>
						<td class="header_middle " colspan="2">ORDER ARTICLE</td>
					</tr>
					</table>
					
					</td>
					<?php endforeach;?>
					</tr>
					<?php foreach ($arSection['ITEMS'] as $item):?>
					<?php $show = false;?>
					<?php foreach ($types as $type) {
						if(!$show && count($item['TYPES_OFFERS'][$type['ID']]['OFFERS'])) {
							$show = true;
						}
					}?>
					<?php if($show):?>
					<tr class="links">
	
						<td class="header_middle"><?php echo $item['NAME']?></td>
						<?php foreach ($types as $type):?>
						<td colspan="2">
							<table>
								<tr>
								<?php $offers = $item['TYPES_OFFERS'][$type['ID']]['OFFERS'];?>
								<?php 
									$offersCnt = count($offers);
								?>
								<?php $cnt = 0;?>
								<?php foreach ($offers as $offer):?>
								<?php $cnt ++;?>
								<?php if($cnt > 1 && ($cnt) % 2 != 0):?>
								</tr>
								<tr>
								<?php endif;?>
								<td class=""><a href="<?php echo $offer['DETAIL_PAGE_URL']?>" target="_blank"><?php echo $offer['NAME']?></a></td>
								<?php endforeach;?>
								<?php if($offersCnt % 2 != 0):?>
								<td>&nbsp;</td>
								<?php endif;?>
								</tr>
							</table>
						</td>
						<?php endforeach;?>
					</tr>
					<?php endif;?>
					<?php endforeach;?>
				</table>
<?php
}
?>