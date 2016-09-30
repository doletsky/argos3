<div id="content" class="whole multi">
	<h1 class="min"><?=$arResult['NAME']?>. <?=GetMessage("MULTIMEDIA");?></h1>
	<?
	//Социальные кнопки
	$reviews_block='Y';//Блок с отзывами есть
	$page='item_'.$arResult['ID'];//идентификатор страницы, с которой собираются отзывы
	include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."social_buttons.php");
	?>
	<div class="clear"></div>
	<div class="tabs_grey_style">
		<?
		//**получаем первую вкладку с контентом**//
		
		
		$photos=$arResult['PROPERTIES']['MULTIMEDIA_PHOTOS']['VALUE'];
		if($photos){
			$varphotos = true;
		}
		$promo=$arResult['PROPERTIES']['MULTIMEDIA_PROMOTIONAL_MATERIALS']['VALUE'];
		if($promo){
			$varpromo = true;
		}
		$calc=$arResult['PROPERTIES']['MULTIMEDIA_CALCULATOR']['VALUE'];
		if($calc){
			$varcalc = true;
		}
		$file=$arResult['PROPERTIES']['FILE_3D']['VALUE'];
		if($file){
			$varfile = true;
		}				
		$arvideo=$arResult['PROPERTIES']['MULTIMEDIA_VIDEO']['VALUE'];
		if($arvideo) {
			$videoprop = false;
			foreach ($arvideo as $elvideo)
			{
				if($elvideo) {
					$videoprop = true;
				}
			}
		}				

		
		$switchArr = array(
			"photos" => $varphotos,
			"promo" => $varpromo,
			"video" => $videoprop,
			"calc" => $varcalc,
			"file" => $varfile
		);
		$resArr = array(
			"photos" => false,
			"promo" => false,
			"video" => false,
			"calc" => false,
			"file" => false
		);
		
		foreach($switchArr as $variable=>$property){
			if($property){
				$resArr[$variable] = true;
				break;
			}
		}		
		/*END*/
		
		
		
		$inactive_class="inactive";
		$photos_str=$arResult['PROPERTIES']['MULTIMEDIA_PHOTOS']['VALUE'];	
		if($photos_str) {
			$inactive_class="";
		}
		?>
		<a<?if($inactive_class!="inactive") {?> href="?view=new&tab=4&multimedia=1"<?}?> class="tab_grey_style tab_1<?if(isset($_GET['tab']) && $_GET['tab']=='4' && isset($_GET['multimedia']) && $_GET['multimedia']=='1' || isset($_GET['tab']) && $_GET['tab']=='4' && !isset($_GET['multimedia']) && $resArr["photos"]==true)echo' current'?>"><span class="s_15 <?=$inactive_class?>"><?=GetMessage("MULTIMEDIA_PHOTOS");?></span></a>
		<?
		$inactive_class="inactive";
		$files_calculator=$arResult['PROPERTIES']['MULTIMEDIA_PROMOTIONAL_MATERIALS']['VALUE'];	
		if($files_calculator) {
			$inactive_class="";
		}
		?>
		<a<?if($inactive_class!="inactive") {?> href="?view=new&tab=4&multimedia=2"<?}?> class="tab_grey_style tab_2<?if(isset($_GET['tab']) && $_GET['tab']=='4' && isset($_GET['multimedia']) && $_GET['multimedia']=='2' && $inactive_class!="inactive" || isset($_GET['tab']) && $_GET['tab']=='4' && !isset($_GET['multimedia']) && $resArr["promo"]==true)echo' current'?>"><span class="s_15 <?=$inactive_class?>"><?=GetMessage("MULTIMEDIA_MATERIALS");?></span></a>
		<?
		$inactive_class="inactive";
		$links_video=$arResult['PROPERTIES']['MULTIMEDIA_VIDEO']['VALUE'];	
		if($links_video)
		{
			foreach ($links_video as $video)
			{
				if($video) {
					$inactive_class="";
				}
			}
		}
		?>
		<a<?if($inactive_class!="inactive") {?> href="?view=new&tab=4&multimedia=3"<?}?> class="tab_grey_style tab_3<?if(isset($_GET['tab']) && $_GET['tab']=='4' && isset($_GET['multimedia']) && $_GET['multimedia']=='3' && $inactive_class!="inactive" || isset($_GET['tab']) && $_GET['tab']=='4' && !isset($_GET['multimedia']) && $resArr["video"]==true)echo' current'?>"><span class="s_15 <?=$inactive_class?>"><?=GetMessage("MULTIMEDIA_VIDEO");?></span></a>
		<?
		$inactive_class="inactive";
		$files_calculator=$arResult['PROPERTIES']['MULTIMEDIA_CALCULATOR']['VALUE'];	
		if($files_calculator) {
			$inactive_class="";
		}
		?>
		<a<?if($inactive_class!="inactive") {?> href="?view=new&tab=4&multimedia=4"<?}?> class="tab_grey_style tab_4<?if(isset($_GET['tab']) && $_GET['tab']=='4' && isset($_GET['multimedia']) && $_GET['multimedia']=='4' && $inactive_class!="inactive" || isset($_GET['tab']) && $_GET['tab']=='4' && !isset($_GET['multimedia']) && $resArr["calc"]==true)echo' current'?>"><span class="s_15 <?=$inactive_class?>"><?=GetMessage("MULTIMEDIA_APPLICATIONS");?></span></a>
		<?
		
		//размещение флэш файлов
		
		$inactive_class="inactive";					
		$files_3d=$arResult['PROPERTIES']['FILE_3D']['VALUE'];	
		if($files_3d) {
			$inactive_class="";
		}
		
		?>
		<a<?if($inactive_class!="inactive") {?> href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=4&multimedia=6"<?}?> class="tab_grey_style tab_6<?if(isset($_GET['tab']) && $_GET['tab']=='4' && isset($_GET['multimedia']) && $_GET['multimedia']=='6' && $inactive_class!="inactive" || isset($_GET['tab']) && $_GET['tab']=='4' && !isset($_GET['multimedia']) && $resArr["file"]==true)echo' current'?>"><span class="s_15 <?=$inactive_class?>"><?=GetMessage("3D");?></span></a>
		
		<?
		//получить список баннеров с привязкой к элементу
		$count=0;
		//инфоблоки для баннеров
			if(SITE_DIR=='/'){
				$iblock_id_bann=32;
			}else{
				$iblock_id_bann=36;
			}	
		$arSelect = array("ID", "NAME", "PROPERTY_USE_IN_ELEMENT", "DETAIL_PICTURE");
		$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_bann, "ACTIVE"=>"Y"), $arSelect);
		while($ar_fields=$ar_result->GetNext()){
		if($ar_fields['PROPERTY_USE_IN_ELEMENT_VALUE']==$arResult['ID'])
			{			
				$count++;
			}
		}
		$inactive_class="inactive";
		if($count>0){
			$inactive_class="";
		}
		?>
		<a <?if($inactive_class!="inactive") {?> href="?view=new&tab=4&multimedia=5"<?}?> class="tab_grey_style tab_5<?if(isset($_GET['tab']) && $_GET['tab']=='4' && isset($_GET['multimedia']) && $_GET['multimedia']=='5')echo' current'?>"><span class="s_15 <?=$inactive_class?>"><?=GetMessage("MULTIMEDIA_BANNERS");?></span></a>
	</div>
	
	<?
	if(isset($_GET['tab']) && $_GET['tab']=='4' && isset($_GET['multimedia']) && $_GET['multimedia']=='1' || isset($_GET['tab']) && $_GET['tab']=='4' && !isset($_GET['multimedia']) && $resArr["photos"]==true)//Чертежи и фотографии изделия
	{
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/multimedia_photos.php");
	}
	else if(isset($_GET['tab']) && $_GET['tab']=='4' && isset($_GET['multimedia']) && $_GET['multimedia']=='2' || isset($_GET['tab']) && $_GET['tab']=='4' && !isset($_GET['multimedia']) && $resArr["promo"]==true)//Информационно-рекламные материалы
	{
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/multimedia_promotional_materials.php");
	}
	else if(isset($_GET['tab']) && $_GET['tab']=='4' && isset($_GET['multimedia']) && $_GET['multimedia']=='3' || isset($_GET['tab']) && $_GET['tab']=='4' && !isset($_GET['multimedia']) && $resArr["video"]==true)//Видео
	{
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/multimedia_video.php");
	}
	else if(isset($_GET['tab']) && $_GET['tab']=='4' && isset($_GET['multimedia']) && $_GET['multimedia']=='4' || isset($_GET['tab']) && $_GET['tab']=='4' && !isset($_GET['multimedia']) && $resArr["calc"]==true)//Калькулятор
	{
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/multimedia_calculator.php");
	}
	else if(isset($_GET['tab']) && $_GET['tab']=='4' && isset($_GET['multimedia']) && $_GET['multimedia']=='5')//Баннеры для партнеров
	{
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/multimedia_banners.php");
	}else if(isset($_GET['tab']) && $_GET['tab']=='4' && isset($_GET['multimedia']) && $_GET['multimedia']=='6' || isset($_GET['tab']) && $_GET['tab']=='4' && !isset($_GET['multimedia']) && $resArr["files"]==true)//3D
	{
		include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/files_3d.php");
	}
	?>
</div>