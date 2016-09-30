<div id="social_buttons_pdf">
	<?
	//Социальные кнопки
	$reviews_block='Y';//Блок с отзывами есть
	$page='item_'.$arResult['ID'];//идентификатор страницы, с которой собираются отзывы
	//include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."social_buttons.php");
	?>
</div>
<div id="content" class="pdf_object">
	<?
	//ПРИВЯЗКА СЕРТИФИКАТОВ ОСУЩЕСТВЛЯЕТСЯ ПО ТОВАРУ, А НЕ ПРЕДЛОЖЕНИЮ
	
	//инфоблоки для сертификатов
	if(SITE_DIR=='/en/')
		$iblock_id_cert=13;
	if(SITE_DIR=='/')
		$iblock_id_cert=7;
		
	if(isset($_GET['certificate_id']))
	{
		$cert_id=$_GET['certificate_id'];
		
		$arSelect = array("ID", "NAME", "PROPERTY_USE_IN_SECTION", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
		$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "ID"=>$cert_id), $arSelect);
		if($res=$ar_result->GetNext())
		{
			$path_file = CFile::GetPath($res["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
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
										$(".iframeins").css({"width": "100px", "height" :+PdfHeight+"px"});
										$(".iframeins").attr("src", NewLinkFrame);
										$(".iframeins").attr("type", 'application/pdf');
									},2000);
								});
			</script>
			<a href="http://<?=$_SERVER['SERVER_NAME'];?><?=$path_file?>" class="IframeLink" style="display: none;"></a>
			<?}else{?>
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
	}
	
	

	
	/*$item_id=$arResult['ID'];
	if(isset($_GET['certificate_item_id']))
		$item_id=$_GET['certificate_item_id'];
		
	//инфоблоки для сертификатов
	if(SITE_DIR=='/en/')
		$iblock_id_cert=13;
	if(SITE_DIR=='/')
		$iblock_id_cert=7;
		
	$arr_certificates=array();//массив сертификатов
	
	//Привязка к элементу
	$arSelect = array("ID", "NAME", "PROPERTY_USE_IN_ELEMENT", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
	$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_ELEMENT"=>$item_id), $arSelect);
	while($res=$ar_result->GetNext())
	{
		if($res['CNT']>0)
		{
			$link = CFile::GetPath($res["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
			if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
			{
				?>
				<a class="pdf_catalog_link" href="<?=$link?>" target="_blank"><?=$res['NAME']?></a>
				<?
				$arr_certificates[]=$link;
			}
		}
	}
	
	//Привязка к разделу
	$sec_id=$arResult['IBLOCK_SECTION_ID'];
	if(isset($_GET['certificate_sec_id']))
		$sec_id=$_GET['certificate_sec_id'];
		
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
		$arSelect = array("ID", "NAME", "PROPERTY_USE_IN_SECTION", "PROPERTY_CERTIFICATE_PROTOCOLS_FILES");
		$ar_result=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id_cert, "PROPERTY_USE_IN_SECTION"=>$section), $arSelect);
		while($res=$ar_result->GetNext())
		{
			if($res['CNT']>0)
			{
				$link = CFile::GetPath($res["PROPERTY_CERTIFICATE_PROTOCOLS_FILES_VALUE"]);
				if (!in_array($link, $arr_certificates))//если сертификат еще не выведен
				{
					?>					
					<a class="pdf_catalog_link" href="<?=$link?>" target="_blank"><?=$res['NAME']?></a>
					<?
					$arr_certificates[]=$link;
				}
			}
		}
	}*/
	?>
</div>