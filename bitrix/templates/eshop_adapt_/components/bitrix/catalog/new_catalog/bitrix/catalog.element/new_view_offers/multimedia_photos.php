<div class="multimedia_body">
	<?
	$arOffesUsed = array();
	foreach($arResult['OFFERS'] as $offers)
	{
		if(!in_array($offers['ID'], $arOffesUsed)){
			if($offers['ID']==$_GET['offers_id'])
			{
				$photos_str=$offers['PROPERTIES']['MULTIMEDIA_PHOTOS']['VALUE'];	
				if($photos_str) {
				?>
					<div class="multimedia_slider">
						<ul class="bxslider">
							<?
							$count=0;
							foreach ($photos_str as $photo_id)
							{
								$src_img = CFile::GetPath($photo_id);
								?>
								<li>
									<a href="<?=$src_img?>" class="fancybox-button"><img src="<?=$src_img?>" title="<?=$offers['PROPERTIES']['MULTIMEDIA_PHOTOS']['DESCRIPTION'][$count]?>" /></a>
								</li>
								<?
								$count++;
							}
							?>
						</ul>
						<div class="bx-pager_wrap">
							<div id="bx-pager<?=$res['ID']?>" class="bx-pager">
								<div class="bx-pager-inner">
									<?
									$count=0;
									foreach ($photos_str as $photo_id)
									{
										$src_img = CFile::GetPath($photo_id);
										?>
										<a data-slide-index="<?=$count?>" href=""><img src="<?=$src_img?>" /></a>
										<?
										$count++;
									}
									?>
									<div class="clear"></div>
								</div>
							</div>
						</div>
					</div>
			
			
					<?/*<div id="multimedia_slider">
						<div id="lofslidecontent45" class="lof-slidecontent" style="width:946px; height:501px;">
							<div class="preload"><div></div></div>
							<!-- MAIN CONTENT --> 
							<div class="lof-main-outer" style="width:946px; height:501px;">
								<ul class="lof-main-wapper">
									<?
									$count=0;
									foreach ($photos_str as $photo_id)
									{
										$src_img = CFile::GetPath($photo_id);
										?>
										<li>
											<img src="<?=$src_img?>" title="<?=$offers['PROPERTIES']['MULTIMEDIA_PHOTOS']['DESCRIPTION'][$count]?>" />           
											<div class="lof-main-item-desc"><?=$offers['PROPERTIES']['MULTIMEDIA_PHOTOS']['DESCRIPTION'][$count]?></div>
										</li>
										<?
										$count++;
									}
									?>
								</ul>  	
							</div>
							<!-- NAVIGATOR -->
							<div class="lof-navigator-wapper" style="width:946px;">	
								<div onclick="return false" href="" class="lof-previous">Previous</div>
								<div class="lof-navigator-outer" style="width:900px !important;">
									<ul class="lof-navigator">
										<li><img src="/bitrix/templates/eshop_adapt_/images/new_images/multimedia_img_1.jpg" style="width:102px; height:68px;" /></li>
										<li><img src="/bitrix/templates/eshop_adapt_/images/new_images/multimedia_img_2.jpg" style="width:102px; height:68px;" /></li>
										<li><img src="/bitrix/templates/eshop_adapt_/images/new_images/multimedia_img_1.jpg" style="width:102px; height:68px;" /></li>
										<li><img src="/bitrix/templates/eshop_adapt_/images/new_images/multimedia_img_2.jpg" style="width:102px; height:68px;" /></li>
										<li><img src="/bitrix/templates/eshop_adapt_/images/new_images/multimedia_img_1.jpg" style="width:102px; height:68px;" /></li>
										<li><img src="/bitrix/templates/eshop_adapt_/images/new_images/multimedia_img_2.jpg" style="width:102px; height:68px;" /></li>
										<li><img src="/bitrix/templates/eshop_adapt_/images/new_images/multimedia_img_1.jpg" style="width:102px; height:68px;" /></li>
										<li><img src="/bitrix/templates/eshop_adapt_/images/new_images/multimedia_img_2.jpg" style="width:102px; height:68px;" /></li>
										<li><img src="/bitrix/templates/eshop_adapt_/images/new_images/multimedia_img_1.jpg" style="width:102px; height:68px;" /></li>
										<li><img src="/bitrix/templates/eshop_adapt_/images/new_images/multimedia_img_2.jpg" style="width:102px; height:68px;" /></li>
									</ul>
								</div>
								<div onclick="return false" href="" class="lof-next">Next</div>
							</div>
						</div>
					</div>*/?>
				<?
				}
			}
		}
		$arOffesUsed[] = $offers["ID"];
	}
	?>
	<div class="include_area">
		<?
		$include_area=$arResult['PROPERTIES']['MULTIMEDIA_PHOTOS_INCLUDE']['VALUE']['TEXT'];
		if($include_area)
		{
			echo '<div class="include_area_wrap">'.htmlspecialchars_decode($include_area).'</div>';
		}
		?>
	</div>
</div>