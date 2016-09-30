<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<div id="content">
<?$APPLICATION->IncludeComponent("new:subscribe.unsubscribe", "", array(
			"ASD_MAIL_ID"=>$_REQUEST['mid'],
			"ASD_MAIL_MD5"=>$_REQUEST['mhash']
			),
			false
		);
		?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>