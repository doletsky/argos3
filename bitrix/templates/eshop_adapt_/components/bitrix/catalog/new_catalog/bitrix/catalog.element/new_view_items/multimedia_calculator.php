<div class="multimedia_body">
	<?
	$files_calculator=$arResult['PROPERTIES']['MULTIMEDIA_CALCULATOR']['VALUE'];	
	if($files_calculator) {
		$count=0;
		foreach ($files_calculator as $file_calculator_id)
		{
			$path_file = CFile::GetPath($file_calculator_id);
			?>
			<a class="xls_catalog_link" href="<?=$path_file?>"><?=$arResult['PROPERTIES']['MULTIMEDIA_CALCULATOR']['DESCRIPTION'][$count]?></a>
			<?
			$count++;
		}
	}
	?>
	<div class="include_area">
		<?
		$include_area=$arResult['PROPERTIES']['MULTIMEDIA_CALCULATOR_INCLUDE']['VALUE']['TEXT'];
		if($include_area)
		{
			echo '<div class="include_area_wrap">'.htmlspecialchars_decode($include_area).'</div>';
		}
		?>
	</div>
</div>