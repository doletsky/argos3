<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (count($arResult) < 1)
	return;
$wizTemplateId = COption::GetOptionString("main", "wizard_template_id", "eshop_vertical", SITE_ID);
$bManyIblock = array_key_exists("IBLOCK_ROOT_ITEM", $arResult[0]["PARAMS"]);

$curRand = rand();
?>

<ul class="lvl3">
<?
	$previousLevel = 0;
	foreach($arResult as $key => $arItem):

		//Проверка на серию (не выводим серии)	
		if(SITE_ID=='s2')//для сайта англ версия
		{
			$iBlock=10;
			$catalog_list_view_id=22;//id свойства - является серией
		}
		if(SITE_ID=='s1')//для сайта русс версия
		{
			$iBlock=2;
			$catalog_list_view_id=11;//id свойства - является серией
		}
		$ser_id='';
		$catalog_list_view=0;
		if(CModule::IncludeModule("iblock")) {
			$arFilter1=array("IBLOCK_ID"=>$iBlock,"NAME"=>$arItem["TEXT"]);//id инфоблока и id секции
			$rsResult1=CIBlockSection::GetList(array("SORT"=>"ASC"),$arFilter1,false,$arSelect=array("ID"));
			if($ar1=$rsResult1->GetNext())
			{
				$ser_id=$ar1['ID'];
			}
			if($ser_id!='') {
				$arFilter=array("IBLOCK_ID"=>$iBlock,"ID"=>$ser_id);//id инфоблока и id секции
				$rsResult=CIBlockSection::GetList(array("SORT"=>"ASC"),$arFilter,false,$arSelect=array("UF_*"));
				while($ar=$rsResult->GetNext()) 
				{
					if($ar['UF_CATALOG_LIST_VIEW']!='')//для шаблона каталога с Сериями
					{
						$catalog_list_view=$ar['UF_CATALOG_LIST_VIEW'];//id серии категории
					}
				}
			}
		}		
		
		if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel): // recursion end
			echo str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
		endif;

		if ($arItem["IS_PARENT"]): //has children
			$i = $key;
			$bHasSelected = $arItem['SELECTED'];
			$childSelected = false;
			if (!$bHasSelected)         //if parent is selected, check children
			{
				while ($arResult[++$i]['DEPTH_LEVEL'] > $arItem['DEPTH_LEVEL'])
				{
					if ($arResult[$i]['SELECTED'])
					{
						$bHasSelected = $childSelected = true; break;   // if child is selected, select parent
					}
				}
			}

		//	$className = $nHasSelected ? 'selected' : '';//($bHasSelected ? 'selected' : '');
?>
		<? if ($arItem['DEPTH_LEVEL'] > 1 && !$childSelected && $bHasSelected) :  // if child is selected, but his children are not selected?>
			<li class="current selected cat_lvl<?=$arItem['DEPTH_LEVEL']?>">
				<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a><?if ($wizTemplateId == "eshop_vertical"):?><span class="showchild_menu_<?=$curRand?> showchild"><span class="arrow"></span></span><?endif?>
			<ul class="<?if($catalog_list_view==$catalog_list_view_id)echo'disnon'?>">

		<? else:?>
			<?$className = $bHasSelected ? 'current selected' : '';
			/*if ($arItem['DEPTH_LEVEL'] > 1)*/ $className.= " cat_lvl".$arItem['DEPTH_LEVEL'];?>
			<li<?=$className ? ' class="'.$className.'"' : ''?>>
				<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a><span class="showchild_menu_<?=$curRand?> showchild<?if ($wizTemplateId == "eshop_vertical_popup"):?>_popup<?endif?>"><span class="arrow"></span></span>
				<ul class="<?if($catalog_list_view==$catalog_list_view_id)echo'disnon '?>sub"<?//=$bHasSelected || $wizTemplateId == "eshop_vertical_popup" || ($bManyIblock && $arItem['DEPTH_LEVEL'] <= 1) ? '' : ' style="display: none;"'?>>
		<? endif?>
<?
		else:  // no childs
			if ($arItem["PERMISSION"] > "D"):
				$className = $arItem['SELECTED'] ? 'current selected' : '';
			/*if ($arItem['DEPTH_LEVEL'] > 1)*/ $className.= " cat_lvl".$arItem['DEPTH_LEVEL'];
?>
			<li<?=$className ? ' class="'.$className.'"' : ''?>>
				<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li><?
			endif;
		endif;

		$previousLevel = $arItem["DEPTH_LEVEL"];
	endforeach;

	if ($previousLevel > 1)://close last item tags
		echo str_repeat("</ul></li>", ($previousLevel-1) );
	endif;
?>
</ul>
<?if ($wizTemplateId == "eshop_vertical"):?>
<script type="text/javascript">
	function setHeightlvlp(clickitem){
		if(clickitem.closest("li").find("ul:first").attr('rel')){
			heightlvl2Ul = clickitem.closest("li").find("ul:first").attr('rel');
		} else {
			clickitem.closest("li").find("ul:first").css({display: 'block',height:"auto"});
			heightlvl2Ul = clickitem.closest("li").find("ul:first").height();
		}
	}

	var lis = $('.vertical_menu').find('li');
	for(var i = 0; i < lis.length; i++) {
		if($(lis[i]).hasClass('current')) {
			if($(lis[i]).parents("li").hasClass('lvl1')){

				var ul = $(lis[i]).find('ul:first');
				$(ul).css({display: 'block',height:"auto"});
				var h = $(ul).height();
				$(ul).css({height: 0, display: 'block'});

				var ulp= $(lis[i]).parents("li.lvl1").find('ul:first');
				$(ulp).css({display: 'block'});
				var hp = $(ulp).height();
				$(ulp).css({height: 0, display: 'block'});

				$(ul).attr("rel", h);
				// $(ulp).attr("rel", hp);
				$(ul).css({height: h+'px'});
				$(ulp).css({height: h+hp+'px'});
			} else {
				var ul = $(lis[i]).find('ul:first');
				$(ul).css({display: 'block',height:"auto"});
				var h = $(ul).height();
				$(ul).css({height: 0, display: 'block'});
				$(ul).attr("rel", h);
				$(ul).css({height: h+'px'})
			}
		}
	}
	
	$(".arrow").live('click', function() {
		var clickitem = $(this);
		if( clickitem.closest("li").hasClass('lvl1')){
			if( clickitem.closest("li").hasClass('current')){
				clickitem.closest("li").find("ul").animate({height: 0}, 300);
				clickitem.closest("li").removeClass("current");
				//clickitem.closest("li").find(".current").removeClass("current");				
			} else {
				setHeightlvlp(clickitem);
				clickitem.closest("li").find("ul:first").attr('rel',heightlvl2Ul);
				clickitem.closest("li").find("ul:first").css({height: 0, display: 'block'});
				clickitem.closest("li").find("ul:first").animate({height: heightlvl2Ul+'px'}, 300);
				clickitem.closest("li").addClass("current");
			}
		} else {
			if( clickitem.closest("li").hasClass('current')){
				setHeightlvlp(clickitem);
				heightLVL1= clickitem.parents(".lvl1").find("ul:first").height(); 
				var resulth = parseInt(heightLVL1)-parseInt(heightlvl2Ul)
				clickitem.closest("li").find("ul").animate({height: 0}, 300);
				clickitem.parents(".lvl1").find("ul:first").animate({height: resulth+"px"}, 300);
				clickitem.closest("li").removeClass("current");
			} else {
				setHeightlvlp(clickitem);
				heightLVL1 = clickitem.parents(".lvl1").find("ul:first").height();
				clickitem.closest("li").find("ul:first").attr('rel',heightlvl2Ul);
				clickitem.closest("li").find("ul:first").css({height: 0, display: 'block'});
				clickitem.closest("li").find("ul:first").animate({height: heightlvl2Ul+'px'}, 300);
				clickitem.parents(".lvl1").find("ul:first").animate({height:  parseInt(heightlvl2Ul)+ parseInt(heightLVL1)+'px'}, 300);
				clickitem.closest("li").addClass("current");
			}
		}
		return false;
	});
</script>
<?endif?>