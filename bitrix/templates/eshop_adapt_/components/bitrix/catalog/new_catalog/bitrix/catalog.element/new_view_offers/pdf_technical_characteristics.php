<div id="social_buttons_pdf">
	<?
	//Социальные кнопки
	$reviews_block='Y';//Блок с отзывами есть
	$page='item_'.$_GET['offers_id'];//идентификатор страницы, с которой собираются отзывы
	//include ($_SERVER["DOCUMENT_ROOT"].SITE_DIR."social_buttons.php");
	?>
</div>
<!--<iframe name="f1" id="f1" src="/test_db.php"></iframe>-->
<div id="content" id="pdf_object" class="pdf_object" style="position:relative; z-index:1;">
	<?
	$arOffesUsed = array();
	foreach($arResult['OFFERS'] as $offers)
	{
		if(!in_array($offers['ID'], $arOffesUsed)){
			if($offers['ID']==$_GET['offers_id'])
			{
				if($offers['PROPERTIES']['PDF_OFFERS_TECHNICAL_CHARACTERISTICS']["VALUE"]!='')
				{
					$path_file = CFile::GetPath($offers['PROPERTIES']['PDF_OFFERS_TECHNICAL_CHARACTERISTICS']["VALUE"]);//id файла

					?>						
						<?if(IsIE() || (strpos($_SERVER['HTTP_USER_AGENT'], 'like Gecko') > 0 && !strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))){?>
					<!--<iframe src="" name="iframeins" width="100%" style="width: 100%;" class="iframeins"></iframe>-->
							<?							
						/*if(!isset($_GET["ie"])){
								header("Location: http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&ie=reload");
							}	

						*/?>
							<?/* $JpgPath =trim ($path_file,'.pdf');
								$JpgPathFull = $_SERVER['DOCUMENT_ROOT'].$JpgPath.'.jpg';
								$JpgSrcPath = $JpgPath.'.jpg';
								if (!file_exists($JpgPathFull)) {
									$path_pdf = $_SERVER['DOCUMENT_ROOT'].$path_file;
									$img =new imagick($path_pdf);
									$img->setImageFormat('jpg');
									$img->writeImage($JpgPathFull);
									echo "<img src='".$_SERVER['SERVER_NAME'].$JpgSrcPath."' />";
								}*/?>
								<!--<img src="<?//=$_SERVER['SERVER_NAME'];?><?//=$JpgSrcPath;?>"/>-->
								
							
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
										var PdfHeight = ($(window).height());// 128 - это высота шапки которую мы показываем
										//$(".iframeins").attr("width", $(window).width()-20 +"px");
										$(".iframeins").attr("height", PdfHeight+"px");
										$(".iframeins").css({"width": "100%", "height" :+PdfHeight+"px"});
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
							<iframe src="https://docs.google.com/gview?url=http://<?=$_SERVER['SERVER_NAME'];?><?=$path_file?>&embedded=true" name="iframeins" width="100%" style="width: 100%;min-height:2000px;" class="iframeins"></iframe>
							
							<script> 
								$(document).ready(function(){
									setTimeout (function() {
										var PdfHeight = ($(window).height());// 128 - это высота шапки которую мы показываем
										$(".iframeins").attr("height", PdfHeight+"px");
										$(".iframeins").css("height:"+PdfHeight+"px");
										$(".workarea_wrap").height("height:"+PdfHeight+"px");
									},1000);
								});
							</script>
						<?}?>
						
					<?
				}
				else
					echo 'Технические характеристики отсутствуют';
			}
		}
		$arOffesUsed[] = $offers["ID"];
	}
	?>
</div>