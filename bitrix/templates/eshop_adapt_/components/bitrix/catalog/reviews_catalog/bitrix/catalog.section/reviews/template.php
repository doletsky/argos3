<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if (!empty($arResult['ITEMS']))
{
	?>
	<div id="reviews_wrap">
	<?
	//pre_debug($arResult['ITEMS']);
		foreach ($arResult['ITEMS'] as $key => $arItem)
		{		
			/*?><pre style="display:none;"><?print_r($arItem)?></pre><?*/
			?>
			<div class="reviews_one">
				<div class="reviews_left">
					<div class="reviews_date">
						<?if(SITE_DIR=='/en/') {
							$date=explode(' ',$arItem['DATE_ACTIVE_FROM']);
							$date=explode('/',$date[0]);
							echo $date[1].'.'.$date[0].'.'.$date[2];
						}
						else {
							$date=explode(' ',$arItem['DATE_ACTIVE_FROM']);
							$date=$date[0];
							echo str_replace('/','.',$date);
						}?>
					</div>
					<div class="reviews_name"><?=$arItem['NAME']?></div>
					<div class="reviews_post"><?=$arItem['PROPERTIES']['POSITION']['VALUE']?></div>
					<div class="reviews_firm"><?=$arItem['PROPERTIES']['COMPANY']['VALUE']?></div>
					<div class="reviews_mail"><?=$arItem['PROPERTIES']['WEBSITE']['VALUE']?></div>
				</div>
				<div class="reviews_right"><?=$arItem['DETAIL_TEXT']?></div>
			</div>
		<?		
		}
	?>
	</div>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
	<?
}
?>