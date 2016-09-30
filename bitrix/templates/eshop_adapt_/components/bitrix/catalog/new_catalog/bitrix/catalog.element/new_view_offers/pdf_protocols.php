<div id="social_buttons_pdf">
	<?
	//Социальные кнопки
	$reviews_block='Y';//Блок с отзывами есть
	$page='item_'.$_GET['offers_id'];//идентификатор страницы, с которой собираются отзывы
	//include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."social_buttons.php");
	?>
</div>
<div id="content" class="pdf_object">
	<?
	if(isset($_GET['protocol_item_id']))
	{
		//$arSelect = array("ID", "NAME", "PROPERTY_PROT_PDF_PROTOCOLS_COMMON", "PROPERTY_PROT_PDF_PROTOCOLS_ELECTROMAGNETIC", "PROPERTY_PROT_PDF_PROTOCOLS_HARMONIC");
		
		foreach($arResult['OFFERS'] as $offer){
			if($_GET['offers_id'] == $offer['ID']){
				$offer_IBLOCK = $offer['IBLOCK_ID'];
			}
		}
							
		$arSelect = array("ID", "NAME");
		$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$offer_IBLOCK, "ID"=>$_GET['protocol_item_id']), $arSelect);
		if($res=$ar_result->GetNext())
		{
			if($res['CNT']>0)
			{
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
				
				foreach($arProts as $prot)
				{
					if(isset($_GET['pdf_protocols']) && $_GET['pdf_protocols']==$prot[0])
					{
						if($Obj['PROPERTIES'][$_GET['pdf_protocols']]['VALUE']!='')
						{
							$path_file = CFile::GetPath($Obj['PROPERTIES'][$_GET['pdf_protocols']]['VALUE']);//id файла
							?>
							<?if(IsIE()){?>
								<script> 
								$(document).ready(function(){
									var SrcIframe = "#";
									var iframe_el=document.createElement("iframe");
									iframe_el.setAttribute("width","100%");
									iframe_el.setAttribute("height","100%");
									iframe_el.setAttribute("src",SrcIframe);
									iframe_el.setAttribute("class","iframeins");
									iframe_el.setAttribute("style","position: relative;");
									
									$(".pdf_object").append(iframe_el);

									setTimeout (function() {
										var NewLinkFrame = $(".IframeLink").attr("href");
										var PdfHeight = ($(window).height()-128);// 128 - это высота шапки которую мы показываем
										//$(".iframeins").attr("width", $(window).width()+"px");
										$(".iframeins").attr("height", PdfHeight+"px");
										$(".iframeins").css({"width":"100%", "height" :+PdfHeight+"px"});
										$(".iframeins").attr("src", NewLinkFrame);
										$(".iframeins").attr("type", 'application/pdf');
									},2000);
								});
							</script>
							<a href="http://<?=$_SERVER['SERVER_NAME'];?><?=$path_file?>" class="IframeLink" style="display: none;"></a>
							<?}else{?>
								<?/*?>?><object id="pdf_object" data="<?=$path_file?>" type="application/pdf" width="100%" height="0" style="margin:0 auto; position:relative; z-index:1;">
								<?/*<embed width="100%" height="100%" name="plugin" src="<?=$path_file?>" type="application/pdf" wmode="opaque">*/?>
								<?/*?><param name="wmode" value="opaque" /><!-- это параметр позволяет перекрыть объект -->
								alt: <a href="<?=$path_file?>"><?=GetMessage("NO_SUPPORT");?></a>
							</object>--><?*/?>
							<iframe src="https://docs.google.com/gview?url=http://<?=$_SERVER['SERVER_NAME'];?><?=$path_file?>&embedded=true" name="iframeins" width="100%" style="width: 100%;" class="iframeins"></iframe>
							
							<script> 
								$(document).ready(function(){
									setTimeout (function() {
										var PdfHeight = ($(window).height()-128);// 128 - это высота шапки которую мы показываем
										$(".iframeins").attr("height", PdfHeight+"px");
										$(".iframeins").css("height:"+PdfHeight+"px");
										$(".workarea_wrap").height("height:"+PdfHeight+"px");
									},1000);
								});
							</script>
							<?
							}						
						}
						else
							echo 'Протоколы испытаний отсутствуют';
					}
				}
			}
		}
	}
	?>
</div>