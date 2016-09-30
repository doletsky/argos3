<?
$banners_iblock=22;//иблок баннеров
$iblock=2;//иблок каталога
?>

<?
//--------------------------- Механизм вывода баннеров в зависимости от сохраненного в COOKIE количества посещений каждого родительского раздела каталога текущим пользователем -------------------------------//
//Получаем массив главных разделов
if(CModule::IncludeModule("iblock"))
{
	$arr_main_cat=array();//Массив главных разделов
	$arSelect = Array("NAME", "DEPTH_LEVEL", "ID", "ACTIVE", "IBLOCK_ID");
	$ar_main_cat=CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock, "ACTIVE"=>"Y", "DEPTH_LEVEL" => "1"), $arSelect);
	while($res_main_cat=$ar_main_cat->GetNext())
	{
		$arr_main_cat[]=$res_main_cat['ID'];
	}
}
//Получаем id раздела с наибольшим кол-вом посещений
$max_visits=0;
$use_in_sec_id='';
foreach ($arr_main_cat as $section_id)
{
	if(isset($_COOKIE['parent_id_'.$section_id]))
	{
		if($_COOKIE['parent_id_'.$section_id]>$max_visits)
		{
			$max_visits=$_COOKIE['parent_id_'.$section_id];//наибольшее число посещений
			$use_in_sec_id=$section_id;//id раздела с наибольшим числом посещений
		}
	}
}

//инициализируем страницу, где выводим баннер
if(strrpos($_SERVER['REQUEST_URI'], "production/catalog_online")!==false)//если найдена подстрока, то это страница каталога
{
	//$page='catalog_page';
	
	//сохраним главные разделы
	if(strrpos($_SERVER['REQUEST_URI'], "/en/")){
		$iblockID = 10;
	}else{
		$iblockID = 2;
	}
	
	//массив разделов
	  $db_list = CIBlockSection::GetList(Array(), Array('IBLOCK_ID'=>$iblockID), false, Array('ID','CODE','DEPTH_LEVEL','IBLOCK_SECTION_ID'));	  
	  while($ar_result = $db_list->GetNext())
	  {		
		$arSections[] = $ar_result;
	  }
	  ?><pre><?//print_r($arSections);?></pre><?
	  $code = $arResult['VARIABLES']['SECTION_CODE'];  
	  
	  //выберем из массива раздела родительский раздел первого уровня
	  function finder($code, $arSections, $SecID){			
		foreach($arSections as $section){
			if($code){
			
				if($section['CODE']==$code){
					if($section['DEPTH_LEVEL']=='1'){						
						return $section['CODE'];						
					}else{						
						$TmpPage = finder(false, $arSections, $section['IBLOCK_SECTION_ID']);
					}
				}
				 
			}else{
				if($section['ID']==$SecID){
					
					if($section['DEPTH_LEVEL']=='1'){						
						return $section['CODE'];						
					}else{
						$TmpPage = finder(false, $arSections, $section['IBLOCK_SECTION_ID']);
					}
				}
			}			
		}		
		return $TmpPage;		
	  }
	  
	$page = finder($code, $arSections, false);
}
else
{
	$page='other_page';
}
?>

<?
if(!isset($_COOKIE["banner_1_".$page])) {
	if(CModule::IncludeModule("iblock"))
	{
		if($max_visits!=0)//если есть посещения разделов
		{
			$arSelect = array("ID", "NAME", "DETAIL_PICTURE", "PROPERTY_LINK", "PROPERTY_USE_IN_SECTION", "PROPERTY_POSITION_IN_SIDEBAR");
			$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$banners_iblock, "ACTIVE"=>"Y", "PROPERTY_POSITION_IN_SIDEBAR_VALUE"=>"1", "PROPERTY_USE_IN_SECTION"=>$use_in_sec_id), $arSelect);
			if($res=$ar_result->GetNext())
			{
				$src_img = CFile::GetPath($res["DETAIL_PICTURE"]);
				?>
				<div class="sideblock_wrap">
					<?
					if($res['PROPERTY_LINK_VALUE']) {?>
						<a target="_blank" href="<?=$res['PROPERTY_LINK_VALUE']?>">
					<?}?>
					<div id="banner" class="sidebar_block" pos="banner_1" page="<?=$page?>">
						<div class="img_block"><img alt="<?=$res["NAME"]?>" src="<?=$src_img?>" /></div>
						<div class="btn_close_block" onclick="return false;"></div><div class="clear"></div>
					</div>
					<div class="sidebar_block_shadow"></div>
					<?if($res['PROPERTY_LINK_VALUE']) {?>
						</a>
					<?
					}
					?>
				</div>
				<?
			}
			else //если баннеры отключены (нет активных) - активность должна стоять либо у всех баннеров для текущей позиции, либо ни у одного - то подключаем опрос
			{
				//Получаем нужное id опроса в зависимости от полученной категории
				if($use_in_sec_id==16)//люминесцентные светильники
					$vote_id=1;
				if($use_in_sec_id==17)//Светодиодные светильники
					$vote_id=3;
				if($use_in_sec_id==321)//Светильники ЖКХ
					$vote_id=4;
					
				if(!isset($_COOKIE["voting_1_".$page])) {?>		
					<?$APPLICATION->IncludeComponent("bitrix:voting.form","new_voting",Array(
							"VOTE_ID" => $vote_id, 
							"VOTE_RESULT_TEMPLATE" =>"",// "vote_result.php?VOTE_ID=#VOTE_ID#", 
							"CACHE_TYPE" => "A", 
							"CACHE_TIME" => "3600" 
						)
					);?>
				<?}
			}
		}
		else//если нет посещений разделов
		{
			$arSelect = array("ID", "NAME", "DETAIL_PICTURE", "PROPERTY_LINK", "PROPERTY_POSITION_IN_SIDEBAR");
			$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$banners_iblock, "ID"=>777, "ACTIVE"=>"Y", "PROPERTY_POSITION_IN_SIDEBAR_VALUE"=>"1"), $arSelect);
			if($res=$ar_result->GetNext())
			{
				$src_img = CFile::GetPath($res["DETAIL_PICTURE"]);
				?>
				<div class="sideblock_wrap">
					<?
					if($res['PROPERTY_LINK_VALUE']) {?>
						<a target="_blank" href="<?=$res['PROPERTY_LINK_VALUE']?>">
					<?}?>
					<div id="banner" class="sidebar_block" pos="banner_1" page="<?=$page?>">
						<div class="img_block"><img alt="<?=$res["NAME"]?>" src="<?=$src_img?>" /></div>
						<div class="btn_close_block" onclick="return false;"></div><div class="clear"></div>
					</div>
					<div class="sidebar_block_shadow"></div>
					<?if($res['PROPERTY_LINK_VALUE']) {?>
						</a>
					<?
					}
					?>
				</div>
				<?
			}
			else //если баннеры отключены (нет активных) - активность должна стоять либо у всех баннеров для текущей позиции, либо ни у одного - то подключаем опрос
			{
				//Нужное id опроса в зависимости от полученной категории
				$vote_id=15;					
				if(!isset($_COOKIE["voting_1_".$page])) {?>		
					<?$APPLICATION->IncludeComponent("bitrix:voting.form","new_voting",Array(
							"VOTE_ID" => $vote_id, 
							"VOTE_RESULT_TEMPLATE" =>"",// "vote_result.php?VOTE_ID=#VOTE_ID#", 
							"CACHE_TYPE" => "A", 
							"CACHE_TIME" => "3600" 
						)
					);?>
				<?}
			}
		}
	}
}
?>
<?if(!isset($_COOKIE["subscribe_".$page])) {?>
	<div class="sideblock_wrap">
		<div id="subscribe" class="sidebar_block" pos="subscribe" page="<?=$page?>">
			<div class="btn_close_block"></div><div class="clear"></div>
			<div class="title">Подпишитесь, чтобы<br>получать последние новости</div>
			<?$APPLICATION->IncludeComponent("bitrix:subscribe.form","subscribe_new",Array(
				"USE_PERSONALIZATION" => "Y", 
				"PAGE" => "#SITE_DIR#personal/subscribe/subscr_edit.php", 
				"SHOW_HIDDEN" => "Y",
				"CACHE_TYPE" => "A", 
				"CACHE_TIME" => "3600" 
				)
			);?>
			<?/*<a class="unsubscribe" href="<?=SITE_DIR?>">Отписаться от рассылки</a>*/?>
		</div>
		<div class="sidebar_block_shadow"></div>
	</div>
<?}?>
<?
if(!isset($_COOKIE["banner_2_".$page])) {
	if(CModule::IncludeModule("iblock"))
	{
		if($max_visits!=0)//если есть посещения разделов
		{
			$arSelect = array("ID", "NAME", "DETAIL_PICTURE", "PROPERTY_LINK", "PROPERTY_USE_IN_SECTION", "PROPERTY_POSITION_IN_SIDEBAR");
			$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$banners_iblock, "ACTIVE"=>"Y", "PROPERTY_POSITION_IN_SIDEBAR_VALUE"=>"2", "PROPERTY_USE_IN_SECTION"=>$use_in_sec_id), $arSelect);
			if($res=$ar_result->GetNext())
			{
				$src_img = CFile::GetPath($res["DETAIL_PICTURE"]);
				?>
				<div class="sideblock_wrap">
					<?
					if($res['PROPERTY_LINK_VALUE']) {?>
						<a target="_blank" href="<?=$res['PROPERTY_LINK_VALUE']?>">
					<?}?>
					<div id="banner" class="sidebar_block" pos="banner_2" page="<?=$page?>">
						<div class="img_block"><img alt="<?=$res["NAME"]?>" src="<?=$src_img?>" /></div>
						<div class="btn_close_block" onclick="return false;"></div><div class="clear"></div>
					</div>
					<div class="sidebar_block_shadow"></div>
					<?if($res['PROPERTY_LINK_VALUE']) {?>
						</a>
					<?
					}
					?>
				</div>
				<?
			}
			else //если баннеры отключены (нет активных) - активность должна стоять либо у всех баннеров для текущей позиции, либо ни у одного - то подключаем опрос
			{
				//Получаем нужное id опроса в зависимости от полученной категории
				if($use_in_sec_id==16)//люминесцентные светильники
					$vote_id=5;
				if($use_in_sec_id==17)//Светодиодные светильники
					$vote_id=6;
				if($use_in_sec_id==321)//Светильники ЖКХ
					$vote_id=7;
					
				if(!isset($_COOKIE["voting_2_".$page])) {?>		
					<?$APPLICATION->IncludeComponent("bitrix:voting.form","new_voting",Array(
							"VOTE_ID" => $vote_id, 
							"VOTE_RESULT_TEMPLATE" =>"",// "vote_result.php?VOTE_ID=#VOTE_ID#", 
							"CACHE_TYPE" => "A", 
							"CACHE_TIME" => "3600" 
						)
					);?>
				<?}
			}
		}
		else//если нет посещений разделов
		{
			$arSelect = array("ID", "NAME", "DETAIL_PICTURE", "PROPERTY_LINK", "PROPERTY_POSITION_IN_SIDEBAR");
			$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$banners_iblock, "ID"=>778, "ACTIVE"=>"Y", "PROPERTY_POSITION_IN_SIDEBAR_VALUE"=>"2"), $arSelect);
			if($res=$ar_result->GetNext())
			{
				$src_img = CFile::GetPath($res["DETAIL_PICTURE"]);
				?>
				<div class="sideblock_wrap">
					<?
					if($res['PROPERTY_LINK_VALUE']) {?>
						<a target="_blank" href="<?=$res['PROPERTY_LINK_VALUE']?>">
					<?}?>
					<div id="banner" class="sidebar_block" pos="banner_2" page="<?=$page?>">
						<div class="img_block"><img alt="<?=$res["NAME"]?>" src="<?=$src_img?>" /></div>
						<div class="btn_close_block" onclick="return false;"></div><div class="clear"></div>
					</div>
					<div class="sidebar_block_shadow"></div>
					<?if($res['PROPERTY_LINK_VALUE']) {?>
						</a>
					<?
					}
					?>
				</div>
				<?
			}
			else //если баннеры отключены (нет активных) - активность должна стоять либо у всех баннеров для текущей позиции, либо ни у одного - то подключаем опрос
			{
				//Нужное id опроса в зависимости от полученной категории
				$vote_id=16;					
				if(!isset($_COOKIE["voting_1_".$page])) {?>		
					<?$APPLICATION->IncludeComponent("bitrix:voting.form","new_voting",Array(
							"VOTE_ID" => $vote_id, 
							"VOTE_RESULT_TEMPLATE" =>"",// "vote_result.php?VOTE_ID=#VOTE_ID#", 
							"CACHE_TYPE" => "A", 
							"CACHE_TIME" => "3600" 
						)
					);?>
				<?}
			}
		}
	}
}
?>