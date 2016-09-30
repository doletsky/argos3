<?
if($reviews_block=='Y')
{
	//Социальные кнопки русская версия
	if(CModule::IncludeModule("iblock"))
	{	
		$$page=CIBlockElement::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>20,"PROPERTY_PAGE"=>$page), Array("PROPERTY_PAGE"));		
		if($res=$$page->GetNext())
		{
			$count=$res['CNT'];
		}
	}
	if(!$count)
		$count=0;
}
$url = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
if(isset($sumID)){
	$pageID = $sumID;
	$url = $url.'/#'.$pageID;
}
?>
<div id="social_buttons">
<!--TWITTER-BTN-->
	<a href="https://twitter.com/share" class="twitter-share-button" data-via="Argos_trade" data-hashtags="argos">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<!--END-TWITTER-->
<!--FB-BTN-->
	<div class="fb-like" data-href="<?=$url?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
<!--END-FB-->
<!--VK-BTN-->
<?if(isset($vkID)){
	$vkID=$vkID;
}else{
	$vkID='';
}?>
	<div id="vk_like_<?=$vkID?>" class="vk_like"></div>
	<script type="text/javascript">
	VK.Widgets.Like("vk_like_<?=$vkID?>", {type: "button"}<?echo $pageID ? ','.$pageID : ''?>);
	</script>
<!--END VK-->
	<a class="bookmark_btn" href="#" onclick="return add_favorite(this);">В закладки</a>
	<div id="share"><span>Поделиться</span></div>
	<?if($reviews_block=='Y') {?>
		<a href="/news/reviews/?page=<?=$page?>" target="_blank" class="add_review">Добавить отзыв<div class="count"><div class="arrow"></div><?=$count?></div></a>
	<?}?>
	<div class="clear"></div>
</div>