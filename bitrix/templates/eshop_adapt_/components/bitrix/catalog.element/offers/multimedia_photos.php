<div class="multimedia_body">
	<?

				$photos_str=$arResult['PROPERTIES']['MULTIMEDIA_PHOTOS']['VALUE'];	
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

				<?

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