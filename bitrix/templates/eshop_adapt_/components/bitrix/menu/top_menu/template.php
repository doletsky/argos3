<?
//Главное меню
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (empty($arResult))
	return;

$lastSelectedItem = null;
$lastSelectedIndex = -1;

foreach($arResult as $itemIdex => $arItem)
{
	if (!$arItem["SELECTED"])
		continue;
	if ($lastSelectedItem == null || strlen($arItem["LINK"]) >= strlen($lastSelectedItem["LINK"]))
	{
		$lastSelectedItem = $arItem;
		$lastSelectedIndex = $itemIdex;
	}
}
?>
<ul id="menu">
	<?foreach($arResult as $itemIdex => $arItem):?>
		<li<?if ($itemIdex == $lastSelectedIndex):?> class="current"<?endif;?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
		<?
		if($arItem["TEXT"]=="Production")
		{
			?>
			<ul class="sub" style="width: 160px;">
				<li><a href="<?=SITE_DIR?>production/catalog_online/">On-line catalogue</a></li>
				<li><a href="<?=SITE_DIR?>production/catalog_pdf/">PDF-Catalogue</a></li>
				<li><a href="<?=SITE_DIR?>production/price-list/">Price-list</a></li>
				<li><a href="<?=SITE_DIR?>production/support/">Support</a></li>
			</ul>
			<?
		}
		if($arItem["TEXT"]=="Продукция")
		{
			?>
			<ul class="sub" style="width: 160px;">
				<li><a href="<?=SITE_DIR?>production/catalog_online/">On-line каталог</a></li>
                <li><a href="<?=SITE_DIR?>catalog/">Интернет-магазин </a></li>
				<li><a href="<?=SITE_DIR?>production/catalog_pdf/">PDF-каталог</a></li>
				<li><a href="<?=SITE_DIR?>production/price-list/">Прайс-Лист</a></li>
				<li><a href="<?=SITE_DIR?>production/support/">Поддержка</a></li>
			</ul>
			<?
		}
		if($arItem["TEXT"]=="Produkte")
		{
			?>
			<ul class="sub" style="width: 160px;">
				<li><a href="<?=SITE_DIR?>production/catalog_online/">On-line catalogue</a></li>
				<li><a href="<?=SITE_DIR?>production/catalog_pdf/">PDF-Catalogue</a></li>
				<li><a href="<?=SITE_DIR?>production/price-list/">Price-list</a></li>
				<li><a href="<?=SITE_DIR?>production/support/">Support</a></li>
			</ul>
			<?
		}
		?>
		</li>
	<?endforeach;?>
</ul>