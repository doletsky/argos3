<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arViewModeList = array('LINE', 'TEXT', 'TILE');
$arViewStyles = array(
	'LINE' => array(
		'CONT' => 'bx_catalog_line',
		'TITLE' => 'bx_catalog_line_category_title',
		'LIST' => 'bx_catalog_line_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/line-empty.png'
	),
	'TEXT' => array(
		'CONT' => 'bx_catalog_text',
		'TITLE' => 'bx_catalog_text_category_title',
		'LIST' => 'bx_catalog_text_ul'
	),
	'TILE' => array(
		'CONT' => 'bx_catalog_tile',
		'TITLE' => 'bx_catalog_tile_category_title',
		'LIST' => 'bx_catalog_tile_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png'
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];
$boolShowDepth = (1 < $arParams['TOP_DEPTH']);
$strDepthSym = '>';
?>

<?
if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID'])
{
	$this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], CIBlock::GetArrayByID($arResult['SECTION']["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], CIBlock::GetArrayByID($arResult['SECTION']["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
	?>
	<h1><? echo $arResult['SECTION']['NAME']; ?></h1>
	<div id="print"><?=GetMessage("PRINT_LINK");?></div>
	<div class="clear"></div>
	<?
}

if (0 < $arResult["SECTIONS_COUNT"])
{
	$count=1;
	foreach ($arResult['SECTIONS'] as &$arSection)
	{
		if($count==3)
			$count=1;
		if($count==1)
		{
			$add_class='left';			
		}
		if($count==2)
		{
			$add_class='right';			
		}
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="item_wrap <?=$add_class?>"><img src="<? echo $arSection['PICTURE']['SRC']; ?>" /><a href="<? echo $arSection['SECTION_PAGE_URL']; ?>"><? echo $arSection['NAME']; ?></a></div>
		<?
		$count++;
	}
	unset($arSection);
}
?>
<div class="clear"></div>