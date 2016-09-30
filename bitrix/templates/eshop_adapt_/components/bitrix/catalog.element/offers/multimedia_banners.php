<div class="multimedia_body">
	<?
	$arSelect = array("ID", "NAME", "PROPERTY_USE_IN_ELEMENT", "DETAIL_PICTURE");
	$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_bann, "ACTIVE"=>"Y"), $arSelect);
	while($ar_fields=$ar_result->GetNext()){
		if($ar_fields['PROPERTY_USE_IN_ELEMENT_VALUE']==$arResult['ID'])
		{
			$file = CFile::GetFileArray($ar_fields["DETAIL_PICTURE"]);
			?>
			<div class="partners_banners">
				<img src="<?=$file['SRC']?>" />
				<textarea onclick="this.select()" readonly=""><a href=&quot;<?=$file['DESCRIPTION']?>&quot; target=&quot;_blank&quot;><img src=&quot;http://<?=SITE_SERVER_NAME.$file['SRC']?>&quot; border=&quot;0&quot;></a></textarea>
			</div>
			<?
		}
	}
	?>
	<div class="include_area">
		<?
		$include_area=$arResult['PROPERTIES']['MULTIMEDIA_BANNERS_INCLUDE']['VALUE']['TEXT'];
		if($include_area)
		{
			echo '<div class="include_area_wrap">'.htmlspecialchars_decode($include_area).'</div>';
		}
		?>
	</div>
</div>