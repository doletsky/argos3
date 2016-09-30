<div id="content" id="pdf_object" class="pdf_object" style="position:relative; z-index:1;">
<?php if($arResult['FILE_URL']):?>					
						<?if(IsIE() || (strpos($_SERVER['HTTP_USER_AGENT'], 'like Gecko') > 0 && !strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))){?>
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
										//$(".iframeins").attr("width", $(window).width()-20 +"px");
										$(".iframeins").attr("height", PdfHeight+"px");
										$(".iframeins").css({"width": "100%", "height" :+PdfHeight+"px"});
										$(".iframeins").attr("src", NewLinkFrame);
										$(".iframeins").attr("type", 'application/pdf');
									},2000);
								});
							</script>
							<a href="http://<?=$_SERVER['SERVER_NAME'];?><?=$arResult['FILE_URL']?>" class="IframeLink" style="display: none;"></a>
						<?}else{?>
							<?/*?>?><object id="pdf_object" data="<?=$path_file?>" type="application/pdf" width="100%" height="0" style="margin:0 auto; position:relative; z-index:1;">
								<?/*<embed width="100%" height="100%" name="plugin" src="<?=$path_file?>" type="application/pdf" wmode="opaque">*/?>
								<?/*?><param name="wmode" value="opaque" /><!-- это параметр позволяет перекрыть объект -->
								alt: <a href="<?=$path_file?>"><?=GetMessage("NO_SUPPORT");?></a>
							</object>--><?*/?>
							<iframe src="https://docs.google.com/gview?url=http://<?=$_SERVER['SERVER_NAME'];?><?=$arResult['FILE_URL']?>&embedded=true" name="iframeins" width="100%" style="width: 100%;" class="iframeins"></iframe>
							
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
						<?}?>
<?php endif;?>
</div>