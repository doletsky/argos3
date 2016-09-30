<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<table border="1" width="100%"> 
  <tbody> 
	<tr> 
	<? 
	$count_i = 0;
	foreach($arResult["ITEMS"] as $arItem):?>
    	<td width="250px">
              <div class="main_table">
              	<div class="table_item">
					<a href="<?=$arItem['PROPERTIES']['URL']['VALUE']?>"><img
						border="0"
						src="<?=$arItem["DETAIL_PICTURE"]["SRC"]?>"
						width="<?=$arItem["DETAIL_PICTURE"]["WIDTH"]?>"
						height="<?=$arItem["DETAIL_PICTURE"]["HEIGHT"]?>"
						alt="<?=$arItem["DETAIL_PICTURE"]["ALT"]?>"
						title="<?=$arItem["DETAIL_PICTURE"]["TITLE"]?>"
						/></a><br>
              		<div><a href="<?=$arItem['PROPERTIES']['URL']['VALUE']?>"><?=$arItem["NAME"]?></a></div>
              	</div> 
              </div>
        </td>
    	<?if (($count_i + 1) % 3 == 0) echo '</tr><tr>'; ?>
	<?
	$count_i++;
	endforeach;?>
	
	<?
	$arFilter = Array("IBLOCK_ID"=>'8', "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "WF_STATUS_ID"=>"1" );
	$res = CIBlockElement::GetList(Array("ID"=>"DESC"), $arFilter, false, Array ("nTopCount" => 1), Array());
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$arFields['PROP'] = $ob->GetProperties();
		
		$rsFile = CFile::GetByID($arFields["DETAIL_PICTURE"]);
		$arFile = $rsFile->Fetch();
		$file = CFile::ResizeImageGet($arFile, array('width'=>160, 'height'=>120), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		$arFields["DETAIL_PICTURE"] = $arFile;
		$arFields["DETAIL_PICTURE"]['SRC'] = $file['src'];
		$arFields["DETAIL_PICTURE"]["WIDTH"] = $file['width'];
		$arFields["DETAIL_PICTURE"]["HEIGHT"] = $file['height'];
		//echo "<pre>",print_r($arFields),"</pre>";
	?>
    	<td width="250px">
              <div class="main_table">
              	<div class="table_item">
					<a href="/portfolio/<?//=$arFields['DETAIL_PAGE_URL']?>"><img
						src="<?=$arFields["DETAIL_PICTURE"]["SRC"]?>"
						width="<?=$arFields["DETAIL_PICTURE"]["WIDTH"]?>"
						height="<?=$arFields["DETAIL_PICTURE"]["HEIGHT"]?>"
						/></a><br>
              		<div><a href="/portfolio/">Последнее добавленное портфолио</a></div>
              	</div> 
              </div>
        </td>
    <?}?>    
   </tbody>
 </table>
<? //echo "<pre>",print_r($arItem['PROPERTIES']['URL']['VALUE']),"</pre>";?>

