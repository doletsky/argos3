<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<table border="1" width="100%"> 
  <tbody> 
	<tr> 
		<td width="250px">
              <div class="main_table">
              	<div class="table_item">
					<a href="/en/production/catalog_online/led_drivers/"><img
						border="0"
						src="/upload/iblock/e59/diod-driver.png"
						/></a><br>
              		<div><a href="/en/production/catalog_online/led_drivers/">LED Drivers</a></div>
              	</div> 
              </div>
        </td>
		<td width="250px">
              <div class="main_table">
              	<div class="table_item">
					<a href="/en/production/catalog_online/led_lights/"><img
						border="0"
						src="/upload/iblock/69e/lamp-datchik2.png"
						/></a><br>
              		<div><a href="/en/production/catalog_online/led_lights/">Stairway Lights</a></div>
              	</div> 
              </div>
        </td>
	<?
	$arFilter = Array("IBLOCK_ID"=>'14', "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "WF_STATUS_ID"=>"1" );
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
              		<div><a href="/en/portfolio/">Portfolio</a></div>
              	</div> 
              </div>
        </td>
    <?}?>
    <tr>
    <td></td>
		<td width="250px">
              <div class="main_table">
              	<div class="table_item">
					<a href="/en/production/support/ask_question/"><img
						border="0"
						src="/upload/supp_en.png"
						/></a><br>
              		<div><a href="/en/production/support/ask_question/">Support</a></div>
              	</div> 
              </div>
        </td>
    
    <td></td>
    </tr>    
   </tbody>
 </table>
<? //echo "<pre>",print_r($arItem['PROPERTIES']['URL']['VALUE']),"</pre>";?>

