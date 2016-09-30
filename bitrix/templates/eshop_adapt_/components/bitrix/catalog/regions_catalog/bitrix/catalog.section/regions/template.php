<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//ШАБЛОН КАТАЛОГ ТОВАРОВ РЕГИОНЫ?>

<?
$arr_alfab_symbols=array();//получаем массив символов
foreach ($arResult['ITEMS'] as $key => $arItem)
{
	$alfab_symbol_new=mb_strtoupper(mb_substr($arItem['NAME'],0,1,"UTF-8"));//Получаем первый символ строки (нижний регистр)
	if(!in_array($alfab_symbol_new, $arr_alfab_symbols)) {
		$arr_alfab_symbols[]=$alfab_symbol_new;
	}
}
sort($arr_alfab_symbols);
?>
<div id="regions">
	<?
	if($arResult['NAME']) {
	?>
		<h3><?=$arResult['NAME']?></h3>
	<?
	}
	foreach ($arr_alfab_symbols as $alfab_symbol)
	{
	?>
		<div class="letter_wrap">
			<div class="letter"><?=$alfab_symbol?></div>
			<ul class="regions_list">
				<?
				foreach ($arResult['ITEMS'] as $key => $arItem)
				{
					if(mb_strtoupper(mb_substr($arItem['NAME'],0,1,"UTF-8"))==$alfab_symbol)
					{
						if(!$arResult['NAME'])//если sections
						{
							if(CModule::IncludeModule("iblock")){
								//Получение code секции по id секции
								$ar_result2=CIBlockSection::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$arItem['IBLOCK_ID'], "ID"=>$arItem['IBLOCK_SECTION_ID']));
								if($res2=$ar_result2->GetNext())
								{
									$code_sec=$res2['CODE'];
								}
							}
						}
						?>
						<?if($arResult['NAME']) {//если sections?>
							<li><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></li>
						<?} else {?>						
							<li><a href="<?=$arItem['DETAIL_PAGE_URL'].$code_sec.'/'.$arItem['CODE'].'/'?>"><?=$arItem['NAME']?></a></li>
						<?}?>
					<?
					}
				}
				?>
			</ul>
			<div class="clear"></div>
		</div>
	<?
	}
	?>
	<div class="clear"></div>
</div>
<?
