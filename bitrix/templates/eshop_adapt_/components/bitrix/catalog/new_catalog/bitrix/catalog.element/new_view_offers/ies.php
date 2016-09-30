<div id="content" class="whole">
	<h1 class="min"><?=$arResult['NAME']?>. <?=GetMessage("IES");?></h1>
	<div class="clear"></div>
	<?
	//Социальные кнопки
	$reviews_block='Y';//Блок с отзывами есть
	$page='item_'.$_GET['offers_id'];//идентификатор страницы, с которой собираются отзывы
	//include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."social_buttons.php");
	?>
	<div style="margin-top: 30px">
	
	<pre><?//print_r($arResult)?></pre>
	<?					$arOffersUsed = array();
	
						foreach($arResult['OFFERS'] as $offer){
						
							$ofId = $offer['ID'];
							if(!in_array($ofId, $arOffersUsed)){
							
								if($_GET['offers_id'] == $offer['ID']){
									if($offer['PROPERTIES']['PROTOCOLS_GROUP']["VALUE"]!=''){
										
										$VALUES = array();
										$arSelect = array("ID", "NAME", "PROPERTY_MODEL");
										$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$offer['IBLOCK_ID'], "PROPERTY_PROTOCOLS_GROUP"=>$offer['PROPERTIES']['PROTOCOLS_GROUP']["VALUE"]), $arSelect);
										while($res=$ar_result->GetNext())
										{									
											if($res['CNT']>0)										{			
												
												$TmpID = $res["ID"];										
												$Obj = CCatalogProduct::GetByIDEx($TmpID);
												
												$res1 = CIBlockElement::GetProperty($Obj["IBLOCK_ID"], $TmpID, array(), array("CODE" => "IES"));
												while ($ob = $res1->GetNext())
												{											
													$VALUES[] = array($ob['VALUE'],$ob['DESCRIPTION']);
												}											
											}
										}
										foreach($VALUES as $file_ies_id){
											if($file_ies_id[0] != ''){
												$path_file = CFile::GetPath($file_ies_id[0]);
												?>
												<a class="file_catalog_link" href="<?=$path_file?>" target="_blank" download><?=$file_ies_id[1]?></a>
												<?
												$count++;
											}
										}
									}else{
											
										$files_ies=$offer['PROPERTIES']['IES']['VALUE'];	
										if($files_ies != '') {
											$count=0;
											foreach ($files_ies as $file_ies_id)
											{
												$path_file = CFile::GetPath($file_ies_id);
												?>
												<a class="file_catalog_link" href="<?=$path_file?>" target="_blank" download><?=$offer['PROPERTIES']['IES']['DESCRIPTION'][$count]?></a>
												<?
												$count++;
											}
										}
											
									}
								}
							}
							$arOffersUsed[] = $ofId;
						}
	?>
	
	</div>
</div>