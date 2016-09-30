<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?=SITE_CHARSET?>"/>
<link href="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH."/template_styles.css")?>" type="text/css" rel="stylesheet" />
<?$APPLICATION->ShowCSS(true, true);?>
<?$APPLICATION->ShowHeadStrings();?>
<?$APPLICATION->ShowHeadScripts();?>
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
<body class="<?=$APPLICATION->ShowProperty("BodyClass");?>">