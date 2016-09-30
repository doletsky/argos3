<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новый раздел");
?> 
<div> 
  <br />
  <a href="http://www.argos-trade.com/" target="_blank" ><img src="http://argos-trade.com/upload/iblock/197/logo_Аргос Трейд.jpg" border="0"  /></a></div>
 
<div> 
  <br />
 </div>
 
<div> 
  <br />
 <a href="http://www.argos-trade.com/" target="_blank" ><img src="http://argos-trade.com/upload/iblock/e42/банер13.jpg" border="0"  /></a> </div>
 
<div> 
  <br />
 <a href="http://www.argos-trade.com/" target="_blank" ><img src="http://argos-trade.com/upload/iblock/138/банер15.jpg" border="0"  /></a></div>
 
<div> 
  <br />
 <a href="http://www.argos-trade.com/" target="_blank" ><img src="http://argos-trade.com/upload/iblock/0f5/банер16.jpg" border="0"  /></a> </div>
 
<div>
  <br />
</div>
 
<div> 
  <br />
 </div>
 
<div><?$APPLICATION->IncludeComponent(
	"bitrix:voting.current", 
	"with_description", 
	array(
		"CHANNEL_SID" => "UF_BLOG_POST_VOTE",
		"VOTE_ID" => "16",
		"VOTE_ALL_RESULTS" => "N",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "3600",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?></div>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>