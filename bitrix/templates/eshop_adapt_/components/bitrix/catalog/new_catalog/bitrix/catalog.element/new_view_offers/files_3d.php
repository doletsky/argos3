
<div class="3d_object" style="position:relative; z-index:1; padding-top: 40px">
	<?
	$arOffesUsed = array();
	foreach($arResult['OFFERS'] as $offers)
	{
		if(!in_array($offers['ID'], $arOffesUsed)){
			if($offers['ID']==$_GET['offers_id'])
			{
				if($offers['PROPERTIES']['FILE_3D']["VALUE"]!='')
				{
					foreach($offers['PROPERTIES']['FILE_3D']["VALUE"] as $flash){
						$path_file = CFile::GetPath($flash);//id �����
						?>
							<object   type='application/x-shockwave-flash' data='<?=$path_file?>' width='450'  height='300'>		
								<param name="wmode" value="opaque" /><!-- ��� �������� ��������� ��������� ������ -->
								alt: <a href="<?=$path_file?>"><?=GetMessage("NO_SUPPORT");?></a>
							</object>
						<?
					}
				}
				else
					echo '3D ����� �����������';
			}
		}
		$arOffesUsed[] = $offers["ID"];
	}
	?>
</div>