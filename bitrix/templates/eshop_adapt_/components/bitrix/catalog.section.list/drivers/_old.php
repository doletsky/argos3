<div class="clear"></div>
<p class="text_page_info_2">Нажмите для быстрого перехода к группе</p>
<div class="tabs_simple_style">
	<ul style="margin: 20px;">
		<?php foreach ($arResult['SECTIONS'] as &$arSection):?>
		<li class="tab_simple_style_link"><a class="link" href="#sect<?php echo $arSection['ID']?>"><?php echo $arSection['NAME']?></a></li>
		<?php endforeach;?>
	</ul>
</div>
<div>
	<?php foreach ($arResult['SECTIONS'] as &$arSection):?>
	<div class="catalog_item_wrap">
		<h3 class="catalog_category"><?php echo $arSection['UF_NAME'] ? $arSection['UF_NAME'] : 'Не заполнено название'?></h3>
		<div class="catalog_category_description"><?php echo $arSection['DESCRIPTION']?></div>
		<div class="catalog_item_ips">
		<a name="sect<?php echo $arSection['ID']?>"></a>
		<?php $sections = array_chunk($arSection['TYPES'], 2, true);
			foreach ($sections as $section) {
				//printTable($section);
				var_dump($section);
			}
		?>
		<?php //var_dump($arSection['TYPES']);?>
			<?php //printTable($arSection);?>
		</div>
	</div>
	<?php endforeach;?>
	
</div>


<?php function printTable($arSection)
{
?>
	<table class="catalog_item_ips_table">
	<tr>
	<td class="header_big w141 bg_207" rowspan="3">ВЕРСИЯ</td>
	<td class="header_big bg_29 w97" colspan="6">ВИД ИПС</td>
	</tr>
	<tr>
					<?php foreach ($arSection['TYPES'] as $type):?>
					<td class="header_middle w97" colspan="2"><?php echo $type['NAME']?></td>
					<?php endforeach;?>
					</tr>
					<tr>
					<?php foreach ($arSection['TYPES'] as $type):?>
					<td class="header_middle w97" colspan="2">
					
					<table>				
					<tr><td class="header_middle w97">Чертеж</td><td class="header_middle w97">Фото</td></tr>
					<tr class="img">
						<td class="w97">
						<?php if(!empty($type['PREVIEW_PICTURE']['SRC'])):?>
						<a href="<?php echo $type['PREVIEW_PICTURE']['SRC']?>" class="fancybox-button">
							<div class="ips_img" style="overflow: hidden">
								<img src="<?php echo $type['PREVIEW_PICTURE_TH']['src']?>" style="height:auto">
								<div class="lupa"></div>
							</div>
						</a>
						<?php endif;?>
						</td>
						<td class="w97">
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
						<td class="header_middle w97" colspan="2">Наименование для заказа</td>
					</tr>
					</table>
					
					</td>
					<?php endforeach;?>
					</tr>
	
					<?php foreach ($arSection['ITEMS'] as $item):?>
					<tr class="links">
	
						<td class="header_middle"><?php echo $item['NAME']?></td>
						<?php foreach ($arSection['TYPES'] as $type):?>
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
								<td class="w97"><a href="<?php echo $offer['DETAIL_PAGE_URL']?>"><?php echo $offer['NAME']?></a></td>
								<?php endforeach;?>
								<?php if($offersCnt % 2 != 0):?>
								<td>&nbsp;</td>
								<?php endif;?>
								</tr>
							</table>
						</td>
						<?php endforeach;?>
					</tr>
					<?php endforeach;?>
				</table>
<?php
}
?>