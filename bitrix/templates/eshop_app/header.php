<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if (!CModule::IncludeModule("mobileapp")) die();

CMobile::Init();
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html<?=$APPLICATION->ShowProperty("Manifest");?> class="<?=CMobile::$platform;?>">
<head>
	<?$APPLICATION->ShowHead();?>
	<meta http-equiv="Content-Type" content="text/html;charset=<?=SITE_CHARSET?>"/>
	<meta name="format-detection" content="telephone=no">
	<!--<link href="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH."/template_styles.css")?>" type="text/css" rel="stylesheet" />-->
	<?//$APPLICATION->ShowHeadStrings();?>
	<?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/script.js");?>
	<?CJSCore::Init('ajax');?>
	<title><?$APPLICATION->ShowTitle()?></title>
<!-- Google Analytics counter -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-75322982-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- Google Analytics counter -->
</head>
<?$APPLICATION->IncludeComponent("bitrix:eshopapp.data","",Array(
),false, Array("HIDE_ICONS" => "Y"));
?>
<body id="body" class="<?=$APPLICATION->ShowProperty("BodyClass");?>">
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter28715076 = new Ya.Metrika({
                    id:28715076,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/28715076" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<?if (!CMobile::getInstance()->getDevice()) $APPLICATION->ShowPanel();?>

<script type="text/javascript">
	app.pullDown({
		enable:true,
		callback:function(){document.location.reload();},
		downtext:"<?=GetMessage("MB_PULLDOWN_DOWN")?>",
		pulltext:"<?=GetMessage("MB_PULLDOWN_PULL")?>",
		loadtext:"<?=GetMessage("MB_PULLDOWN_LOADING")?>"
	});
</script>
<?
if ($APPLICATION->GetCurPage(true) != SITE_DIR."eshop_app/personal/cart/index.php")
{
?>
	<script type="text/javascript">
		app.addButtons({menuButton: {
			type:    'basket',
			style:   'custom',
			callback: function()
			{
				app.openNewPage("<?=SITE_DIR?>eshop_app/personal/cart/");
			}
		}});
	</script>
<?
}
?>
<div class="wrap">
<?
?>