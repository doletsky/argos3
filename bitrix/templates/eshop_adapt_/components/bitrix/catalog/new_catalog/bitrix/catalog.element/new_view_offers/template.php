<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//ШАБЛОН КАРТОЧКИ ТОВАРА НОВЫЙ ВИД ПО ПРЕДЛОЖЕНИЯМ?>
<div id="header" class="min" style="position:relative; z-index:2;">

	<div id="menu_new_wrap">
	<iframe id="iehack" name="iehack" src="/iehack.php"></iframe>
		<?
		
		//menu visibility
		if($arResult['PROPERTIES']['TAB_DATASHEET']['VALUE']=='да'){
			$datasheet = true;
		}
		if($arResult['PROPERTIES']['TAB_PROTOCOLS']['VALUE']=='да'){
			$protocols = true;
		}
		if($arResult['PROPERTIES']['TAB_SERTIFICATES']['VALUE']=='да'){
			$sertificates = true;
		}
		if($arResult['PROPERTIES']['TAB_MULTIMEDIA']['VALUE']=='да'){
			$multimedia = true;
		}
		if($arResult['PROPERTIES']['TAB_IES']['VALUE']=='да'){
			$ies = true;
		}
		if($arResult['PROPERTIES']['TAB_PORTFOLIO']['VALUE']=='да'){
			$portfolio = true;
		}
		if($arResult['PROPERTIES']['TAB_ORDER']['VALUE']=='да'){
			$ordertab = true;
		}
		
		?>
		<ul id="menu_new">
			<li class="<?if(isset($_GET['tab']) && $_GET['tab']=='1' || !isset($_GET['tab']))echo 'current'?> <?echo !$datasheet ? 'inactive' : ''?>"><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=1"><?=GetMessage("DATASHEET");?></a></li>
			
			<li  class="<?if(isset($_GET['tab']) && $_GET['tab']=='2')echo'current'?> <?echo !$protocols ? 'inactive' : ''?>">
				<a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=2" onclick="return false;"><?=GetMessage("TEST_REPORTS");?></a>
				<div>
					<ul class="sub">
						<?				
						
						//Привязка группы протоколов по предложениям
						$arOffersUsed = array();
						foreach($arResult['OFFERS'] as $offer){
						
							$ofId = $offer['ID'];
							if(!in_array($ofId, $arOffersUsed)){
							
								if($_GET['offers_id'] == $offer['ID']){
									if($offer['PROPERTIES']['PROTOCOLS_GROUP']["VALUE"]!=''){
										
										$arSelect = array("ID", "NAME", "PROPERTY_MODEL");
										$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$offer['IBLOCK_ID'], "PROPERTY_PROTOCOLS_GROUP"=>$offer['PROPERTIES']['PROTOCOLS_GROUP']["VALUE"]), $arSelect);
										while($res=$ar_result->GetNext())
										{									
											if($res['CNT']>0)
											{
												//модель предложения
												$model = CCatalogProduct::GetByIDEx($res['PROPERTY_MODEL_VALUE']);
												
												$TmpID = $res["ID"]; //шаблон свойства протокола PROT_*
												$arProts = array();
												$Obj = CCatalogProduct::GetByIDEx($TmpID);
												foreach($Obj['PROPERTIES'] as $k => $prop)
												{
													$arTmp = array();
													$arProp = explode('_', $k);							
													if($arProp[0] == 'PROT'){						
														$arTmp = array($k, $prop['NAME'], $Obj['ID']);						
														$arProts[] = $arTmp;				
													}					
												}
												?>
												<li class="first_inner">
													<div><?=$model['NAME']?></div>
													<ul class="sub_psd">
														<?
														foreach($arProts as $type){
															if($Obj['PROPERTIES'][$type[0]]['VALUE']!='')
															{
																?><li><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=2&protocol_item_id=<?=$Obj['ID']?>&pdf_protocols=<?=$type[0]?>"><?echo $type[1];?></a></li><?
															}
														}
														?>
													</ul>
												</li>
												<?
											}
										}
									}else{
										?>
											<!--<li>
												<div><?=$arResult['NAME']?></div>
											</li>-->
										<?
									}
								}
							}
							$arOffersUsed[] = $ofId;
						}		
						
						
					?>
					</ul>
				</div>
			</li>
			
			<li  class="<?if(isset($_GET['tab']) && $_GET['tab']=='3')echo 'current'?> <?echo !$sertificates ? 'inactive' : ''?>">
				<a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3" onclick="return false;"><?=GetMessage("CERTIFICATES");?></a>
				<div>
					<ul class="sub">
						<?
						//инфоблоки для сертификатов
						if(SITE_DIR=='/en/')
							$iblock_id_cert=13;
						if(SITE_DIR=='/')
							$iblock_id_cert=7;
						
						//Если указана группа для товаров
						if($arResult['PROPERTIES']['PROTOCOLS_GROUP']["VALUE"]!='')
						{
							$arSelect = array("IBLOCK_ID", "ID", "NAME", "IBLOCK_SECTION_ID");
							$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$arResult['IBLOCK_ID'], "PROPERTY_PROTOCOLS_GROUP"=>$arResult['PROPERTIES']['PROTOCOLS_GROUP']["VALUE"]), $arSelect);
							while($res=$ar_result->GetNext())
							{
							
								if($res['CNT']>0)
								{
									?>
									<li class="first_inner">
										<div><?=$res['NAME']?></div>
										<ul class="sub_psd">
											<?
											$item_id=$res['ID'];
												
											$arr_certificates=array();//массив сертификатов
											
											//Привязка к элементу
											$arSelectCert = array("ID", "NAME", "PROPERTY_USE_IN_ELEMENT", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
											$ar_result_cert=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_ELEMENT"=>$item_id), $arSelectCert);
											while($cert=$ar_result_cert->GetNext())
											{
												if($cert['CNT']>0)
												{
													$link = CFile::GetPath($cert["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
													if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
													{
														?>
														<li><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3&certificate_id=<?=$cert['ID']?>"><?=$cert['NAME']?></a></li>
														<?
														$arr_certificates[]=$link;
													}
												}
											}
											
											//Привязка к предложению												
											if(SITE_DIR=='/'){
												$offer_iblock_id=4;
											}else{
												$offer_iblock_id=11;
											}
											$arSelectOffers = array("ID");
											$arResOffers = CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$offer_iblock_id, "PROPERTY_MODEL"=>$item_id), $arSelectOffers);
											
											while($arOffer = $arResOffers->GetNext())
											{
												$arSelectCert = array("ID", "NAME", "PROPERTY_USE_IN_ELEMENT", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
												$ar_result_cert=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_ELEMENT"=>$arOffer["ID"]), $arSelectCert);
												while($cert=$ar_result_cert->GetNext())
												{
													if($cert['CNT']>0)
													{
														$link = CFile::GetPath($cert["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
														if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
														{
															?>
															<li><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3&certificate_id=<?=$cert['ID']?>"><?=$cert['NAME']?></a></li>
															<?
															$arr_certificates[]=$link;
														}
													}
												}
											}
											
											
											//Привязка к разделу
											$sec_id=$res['IBLOCK_SECTION_ID'];
												
											$iblock_id=$arResult['IBLOCK_ID'];
											$arr_section=array();//массив для всех родительских разделов
											//получение всех секций для текущего элемента
											$rsPath = GetIBlockSectionPath($iblock_id, $sec_id); 
											while($arPath=$rsPath->GetNext()) {
												$arr_section[]=$arPath['ID'];
											}
											//для каждого раздела ищем совпадающие сертификаты
											foreach ($arr_section as $section)
											{
												$arSelectCert = array("ID", "NAME", "PROPERTY_USE_IN_SECTION", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
												$ar_result_cert=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_SECTION"=>$section), $arSelectCert);
												while($cert=$ar_result_cert->GetNext())
												{
													if($cert['CNT']>0)
													{
														$link = CFile::GetPath($cert["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
														if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
														{
															?>
															<li><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3&certificate_id=<?=$cert['ID']?>"><?=$cert['NAME']?></a></li>
															<?
															$arr_certificates[]=$link;
														}
													}
												}
											}
											?>
											<?/*<a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3&certificate_item_id=<?=$res['ID']?>&certificate_sec_id=<?=$res['IBLOCK_SECTION_ID']?>"><?=$res['NAME']?></a>*/?>
										</ul>
									</li>
									<?
								}
							}
						}
						else
						{
						?>
							<li class="first_inner">
								<div><?=$arResult['NAME'];?></div>
								<ul class="sub_psd">
									<?									
									$item_id=$arResult['ID'];
												
									$arr_certificates=array();//массив сертификатов
											
									//Привязка к элементу
									$arSelectCert = array("ID", "NAME", "PROPERTY_USE_IN_ELEMENT", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
									$ar_result_cert=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_ELEMENT"=>$item_id), $arSelectCert);
									while($cert=$ar_result_cert->GetNext())
									{
										if($cert['CNT']>0)
										{
											$link = CFile::GetPath($cert["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
											if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
											{
												?>
												<li><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3&certificate_id=<?=$cert['ID']?>"><?=$cert['NAME']?></a></li>
												<?
												$arr_certificates[]=$link;
											}
										}
									}
									
									//привязка к предложению
									if($_REQUEST["offers_id"]){
										$offer_id=$_REQUEST["offers_id"];									
										$arSelectCert = array("ID", "NAME", "PROPERTY_USE_IN_ELEMENT", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
										$ar_result_cert=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_ELEMENT"=>$offer_id), $arSelectCert);
										while($cert=$ar_result_cert->GetNext())
										{
											if($cert['CNT']>0)
											{
												$link = CFile::GetPath($cert["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
												if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
												{
													?>
													<li><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3&certificate_id=<?=$cert['ID']?>"><?=$cert['NAME']?></a></li>
													<?
													$arr_certificates[]=$link;
												}
											}
										}
									}
									
											
									//Привязка к разделу
									$sec_id=$arResult['IBLOCK_SECTION_ID'];
												
									$iblock_id=$arResult['IBLOCK_ID'];
									$arr_section=array();//массив для всех родительских разделов
									//получение всех секций для текущего элемента
									$rsPath = GetIBlockSectionPath($iblock_id, $sec_id); 
									while($arPath=$rsPath->GetNext()) {
										$arr_section[]=$arPath['ID'];
									}
									//для каждого раздела ищем совпадающие сертификаты
									foreach ($arr_section as $section)
									{
										$arSelectCert = array("ID", "NAME", "PROPERTY_USE_IN_SECTION", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
										$ar_result_cert=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_SECTION"=>$section), $arSelectCert);
										while($cert=$ar_result_cert->GetNext())
										{
											if($cert['CNT']>0)
											{
												$link = CFile::GetPath($cert["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
												if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
												{
													?>
													<li><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3&certificate_id=<?=$cert['ID']?>"><?=$cert['NAME']?></a></li>
													<?
													$arr_certificates[]=$link;
												}
											}
										}
									}
									?>
									<?/*<a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=3&certificate_item_id=<?=$res['ID']?>&certificate_sec_id=<?=$res['IBLOCK_SECTION_ID']?>"><?=$res['NAME']?></a>*/?>
								</ul>
							</li>
						<?
						}
					?>
					</ul>
				</div>
			</li>
			
			<li  class="<?if(isset($_GET['tab']) && $_GET['tab']=='4')echo 'current'?> <?echo !$multimedia ? 'inactive' : ''?>"><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=4"><?=GetMessage("MULTIMEDIA");?></a></li>
			<?
			/*//вывод ссылки на IES
			if(SITE_DIR=='/en/')
				$iblock_id_lights=93;
			if(SITE_DIR=='/')
				$iblock_id_lights=18;
				
			$obSec = CIBlockSection::GetList(array("SORT"=>"ASC"), array('SECTION_ID'=>$iblock_id_lights));
			while ($arSec = $obSec->GetNext())
			{	
				$arSections[] = $arSec['ID'];
			}
			
			$rsParentSection = CIBlockSection::GetByID($arResult['IBLOCK_SECTION_ID']);
			if ($arParentSection = $rsParentSection->GetNext())
			{		
				$curSecParent = $arParentSection['IBLOCK_SECTION_ID'];
			}
			
			if(in_array($curSecParent, $arSections)){*/
				?>
				<li  class="<?if(isset($_GET['tab']) && $_GET['tab']=='7')echo 'current'?> <?echo !$ies ? 'inactive' : ''?>"><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=7">IES</a></li>
				<?
			/*}		*/	
			?>
			
			<li  class="<?if(isset($_GET['tab']) && $_GET['tab']=='5')echo 'current'?> <?echo !$portfolio ? 'inactive' : ''?>"><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=5"><?=GetMessage("PORTFOLIO");?></a></li>

			
			<li  class="<?if(isset($_GET['tab']) && $_GET['tab']=='6')echo 'current'?> <?echo !$ordertab ? 'inactive' : ''?>"><a href="?view=new&offers_id=<?=$_GET['offers_id']?>&tab=6"><?=GetMessage("ONLINE_ORDER");?></a></li>
			
			
		</ul>
		
	</div>
</div>
<?
if(isset($_GET['tab']) && $_GET['tab']=='1' || !isset($_GET['tab']))//Технические характеристики
{
	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/pdf_technical_characteristics.php");
}
else if(isset($_GET['tab']) && $_GET['tab']=='2')//Протоколы испытаний
{
	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/pdf_protocols.php");
}
else if(isset($_GET['tab']) && $_GET['tab']=='3')//Сертификаты
{
	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/pdf_certificates.php");
}
else if(isset($_GET['tab']) && $_GET['tab']=='4')//Мультимедиа
{
	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/multimedia.php");
}
else if(isset($_GET['tab']) && $_GET['tab']=='5')//Портфолио
{
	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/portfolio.php");
}
else if(isset($_GET['tab']) && $_GET['tab']=='6')//Он-лайн заказ
{
	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/online_order.php");
}
else if(isset($_GET['tab']) && $_GET['tab']=='7')//IES
{
	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/ies.php");
}
?>
<h1><?php echo $arResult['NAME']?></h1>
<?//Окно Поделиться?>
		<div id="modal_w_body">
			<div id="modal_w_wrap"></div>
			<div id="share_win" class="modal_w">
				<div class="close">X</div>
				<div class="title"><?=GetMessage("SHARE_LINK")?></div>
				<form id="share_form">
					<input type="text" name="share_email" id="share_email" value="E-mail" />
					<input type="submit" value="<?=GetMessage("SHARE_SUBMIT")?>" />
					<div id="share_err"></div>
				</form>
			</div>
		</div>