<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="confirm">
<?
if (!empty($arResult["ORDER"]))
{
	?>
	<h1><?=GetMessage("SOA_TEMPL_ORDER_COMPLETE")?></h1>
	<div id="print"><?=GetMessage("PRINT_LINK")?></div>
	<div class="clear"></div>
	<p><?=GetMessage("THANKU_MESS");?></p>
	<ul>
		<li>- <?=GetMessage("SOA_TEMPL_ZAKAZ");?> <a href="/dompdf_lib/dompdf.php/?ORDER_ID=<?=$arResult['ORDER_ID']?>" target="_blank" id="dompdf_zakaz">zakaz.pdf</a> (<?=GetMessage("SOA_TEMPL_ZAKAZ_ADD");?>)</li>
		<?
		if (!empty($arResult["PAY_SYSTEM"]))
		{
			if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
			{
				if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
				{
					if (CSalePdf::isPdfAvailable())
					{
					
						//список товаров корзины
						$dbBasketItems = CSaleBasket::GetList(false, array("ORDER_ID" => $arResult['ORDER_ID']), false, false);	
						while ($arItems = $dbBasketItems->Fetch())
						{
							/*?><pre><?print_r($arItems)?></pre><?*/
							//Получаем данные
							$product_id=$arItems["PRODUCT_ID"];
							$arIDs[] = $product_id; // массив ID заказанных товаров
						}
						
						//ищем в куках сроки отгрузки для каждого ID					
						foreach($_COOKIE as $k=>$v){
							$TmpArrCookie = explode('item', $k);
							if($TmpArrCookie[1] && in_array($TmpArrCookie[1], $arIDs)){
								$arVals[$TmpArrCookie[1]] = $v;
							}			
						}
						
						foreach ($arVals as $k=>$v){
							$arVals2[] = $v;			
						}
						$arVals2 = array_unique($arVals2);
						
						foreach ($arVals2 as $val){
							foreach($arVals as $k=>$v){
								if($val == $v){
									$arrX[$v][]=$k;
								}
							}			
						}
						
						if($arResult['ORDER']['LID'] == 's1'){
							$lang = 'ru';
						}else{
							$lang = 'en';
						}
						
						foreach($arrX as $k=>$v){
							$idstr = implode(',',$v); 
							if($k!='1')$predzakaz = true;
							
					?>
							<li><?echo GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y&PRODUCTS=$idstr&days=$k&lang=$lang", "#DAYS#"=>$k));
							echo $predzakaz ? GetMessage("SOA_TEMPL_PREDZAKAZ") : '';							
							?></li>
					<?	
							//генерируем pdf счета для отправки на почту
							$ORDER_ID = $arResult['ORDER_ID'];
							$days = $k;
							$products = $v;
							$save = true;
							if($days == '1') $order=true;
							
							include('generate_bill_pdf.php');
							$arFiles[] = $file;
							
							//генерируем xls счета для отправки компании через аякс	
							$jsStr = CUtil::PhpToJSObject($idstr);
							?>
							<script>
							<?if($order){?>
								order = 1;
							<?}else{?>
								order = 0;
							<?}?>
							/*if(orderbool){
								order = 1;
							}else{
								order = 0
							}*/
							products = <?=$jsStr?>;
							$.ajax({
							  type: "POST",
							  url: "/phpexcel_lib/generate_bill_xls.php",
							  data: {order_id: <?=$ORDER_ID?>, days:<?=$days?> , products:products , order:order},
							  success: function(data){
													
							  }
							});
							</script>
							
							<?
							$arFilesXls[] = str_replace('.pdf', '.xlsx',$file);							
						}
					}
				}	
			}
		}
		
		
		?>
		<!--<li>- предзаказ <a href="" target="_blank">zakaz.pdf</a> (срок поставки 10 дней)</li>-->
	</ul>
	
	<?$db_vals = CSaleOrderPropsValue::GetList(
            array("SORT" => "ASC"),
            array("ORDER_ID" => $arResult['ORDER_ID'])
        );	

		//vars
		 $COMPANY;
		 $CONTACT_PERSON;
		 $EMAIL;
		 $PHONE_MOBILE;
		 $TRANSPORT_COMPANY;
		 $COMMENT_FOR_SUBMIT;
		 $ADDRESS;
		 $INN;
		 $FAX;
		 $SITE;
		 $COMPANY_ADR;
		 $PHONE;
		 $LOCATION;
		
		while($arVals = $db_vals->Fetch())
		{
			if($arVals['CODE']=='COMPANY')
				$COMPANY=$arVals['VALUE'];
			if($arVals['CODE']=='CONTACT_PERSON')
				$CONTACT_PERSON=$arVals['VALUE'];
			if($arVals['CODE']=='EMAIL')
				$EMAIL=$arVals['VALUE'];			
			if($arVals['CODE']=='PHONE_MOBILE')
				$PHONE_MOBILE=$arVals['VALUE'];
			if($arVals['CODE']=='TRANSPORT_COMPANY')
				$TRANSPORT_COMPANY=$arVals['VALUE'];
			if($arVals['CODE']=='COMMENT_FOR_SUBMIT')
				$COMMENT_FOR_SUBMIT=$arVals['VALUE'];
			if($arVals['CODE']=='ADDRESS')
				$ADDRESS=$arVals['VALUE'];
				
			if($arVals['CODE']=='INN')
				$INN=$arVals['VALUE'];
			if($arVals['CODE']=='FAX')
				$FAX=$arVals['VALUE'];
			if($arVals['CODE']=='SITE')
				$SITE=$arVals['VALUE'];
			if($arVals['CODE']=='COMPANY_ADR')
				$COMPANY_ADR=$arVals['VALUE'];
			if($arVals['CODE']=='PHONE')
				$PHONE=$arVals['VALUE'];
				
			if($arVals['CODE']=='LOCATION')
				$LOCATION=$arVals['VALUE'];		
		}?>
	
	
	<?if($arResult['ORDER']['LID'] == 's1'){?>
		<p class="important">Уважаемый клиент, нам необходимо с Вами подписать договор.</p>
		<p>P.S. если мы с Вами уже его подписали ранее и срок действия его не истек, то не нужно.</p>
		<div id="make_contract">Оформить договор</div>
		<a href="/personal/order/make/thank_you.php/" id="no_contract">Отказаться от оформления</a>
		<div class="clear"></div>
			<form method="POST" action="/personal/order/make/get_agreement.php/" id="contract_form">
				<div id="data_agreement">
					<div class="agreement_wrap">
						<div class="agreement_field">
							<div class="agreement_name_field">Юр. лицо <span>(в соответствие с Уставом)</span></div>
							<input type="text" name="jur" value="<?=$COMPANY?>"/>
						</div>
						<div class="agreement_title">В лице</div>
						<div class="agreement_field">
							<div class="agreement_name_field">Должность <span>(в род. падеже)</span></div>
							<input type="text" name="pos"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">Должность <span>(в именит. падеже)</span></div>
							<input type="text" name="pos_imenit"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">ФИО <span>(в род. падеже)</span></div>
							<input type="text" name="fio"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">ФИО <span>(в именит. падеже)</span></div>
							<input type="text" name="fio_imenit"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">На основании</div>
							<input type="text" name="fund" value="Устава"/>
						</div>
					</div>
					<div class="agreement_wrap">
						<div class="agreement_field">
							<div class="agreement_name_field">Телефон <span>(рабочий)</span></div>
							<input type="text" name="phone" value="<?=$PHONE?>"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">Телефон <span>(моб.)</span></div>
							<input type="text" name="mob_phone" value="<?=$PHONE_MOBILE?>"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">Факс</div>
							<input type="text" name="fax" value="<?=$FAX?>"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">Е-mail</div>
							<input type="text" name="mail" value="<?=$EMAIL?>"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">Сайт</div>
							<input type="text" name="site"/>
						</div>
					</div>
					<div class="agreement_wrap">
						<div class="agreement_field">
							<div class="agreement_name_field">ИНН</div>
							<input type="text" name="inn" value="<?=$INN?>"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">КПП</div>
							<input type="text" name="kpp"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">ОГРН</div>
							<input type="text" name="ogrn"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">Банк</div>
							<input type="text" name="bank"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">р/с</div>
							<input type="text" name="rs"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">к/с</div>
							<input type="text" name="ks"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">БИК</div>
							<input type="text" name="bik"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">Юридический адрес</div>
							<textarea name="juraddr" value="<?=$COMPANY_ADR?>"></textarea>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">Фактический адрес</div>
							<textarea name="factaddr" value="<?=$ADDRESS?>"></textarea>
						</div>
					</div>
					<div class="agreement_wrap"  style="margin-bottom: 0;">
						<div class="agreement_field">
							<div class="agreement_name_field">Вид доставки</div>
							<input type="text" name="delivery"/>
						</div>
						<div class="agreement_field">
							<div class="agreement_name_field">Выбранная транспортная компания</div>
							<input type="text" name="transpcomp" value="<?=$TRANSPORT_COMPANY?>"/>
						</div>
					</div>
					<div class="confirm_btns" style="width: 441px">				
						<input type="submit" value="Сформировать договор" class="submitbutton">
						<div class="clear"></div>
					</div>
				</div>
				
			</form>
		<div class="clear"></div>
		<p>Мы будем очень Вам благодарны, если Вы введете необходимые реквизиты в он-лайн форме заполнения договора и нажмете по завершению ввода кнопку «сформировать договор».</p>
		<p>После этого окно/вкладка «корзина» перезагрузится и Вы увидите сформированный договор в PDF, а его копия автоматически будет направлена Вам на e-mail. Пожалуйста, распечатайте договор, подпишите и отправьте его нам почтой.</p>
	<?}?>
	
	
	<?/*<b><?=GetMessage("SOA_TEMPL_ORDER_COMPLETE")?></b><br /><br />
	<table class="sale_order_full_table">
		<tr>
			<td>
				<?= GetMessage("SOA_TEMPL_ORDER_SUC", Array("#ORDER_DATE#" => $arResult["ORDER"]["DATE_INSERT"], "#ORDER_ID#" => $arResult["ORDER"]["ACCOUNT_NUMBER"]))?>
				<br /><br />
				<?= GetMessage("SOA_TEMPL_ORDER_SUC1", Array("#LINK#" => $arParams["PATH_TO_PERSONAL"])) ?>
			</td>
		</tr>
	</table>
	<?
	if (!empty($arResult["PAY_SYSTEM"]))
	{
		?>
		<br /><br />

		<table class="sale_order_full_table">
			<tr>
				<td class="ps_logo">
					<div class="pay_name"><?=GetMessage("SOA_TEMPL_PAY")?></div>
					<?=CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"], 100, 100, "border=0", "", false);?>
					<div class="paysystem_name"><?= $arResult["PAY_SYSTEM"]["NAME"] ?></div><br>
				</td>
			</tr>
			<?
			if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
			{
				?>
				<tr>
					<td>
						<?
						if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
						{
							?>
							<script language="JavaScript">
								window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
							</script>
							<?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))))?>
							<?
							if (CSalePdf::isPdfAvailable())
							{
								?><br />
								<?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
								<?
							}
						}
						else
						{
							if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
							{
								include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
							}
						}
						?>
					</td>
				</tr>
				<?
			}
			?>
		</table>
		<?
	}*/
	
	//генерируем pdf заказа для отправки на почту
	include('generate_order_pdf.php');	
	
	 
	
	//отправка вложения стандартным событием + модуль MailAttachments
					$mail = 'adp_wings@mail.ru';//$EMAIL.', '.COption::GetOptionString("sale", "order_email");
					
					//pdf
					if(isset($arFiles[0])){
						$schet1 = "/dompdf_lib/tmp_gen/".$arFiles[0];
					}else{
						$schet1 = false;
					}
					if(isset($arFiles[1])){
						$schet2 = "/dompdf_lib/tmp_gen/".$arFiles[1];
					}else{
						$schet2 = false;
					}
					if(isset($arFiles[2])){
						$schet3 = "/dompdf_lib/tmp_gen/".$arFiles[2];
					}else{
						$schet3 = false;
					}
					if(isset($arFiles[3])){
						$schet4 = "/dompdf_lib/tmp_gen/".$arFiles[3];
					}else{
						$schet4 = false;
					}
					
					//xls
					if(isset($arFilesXls[0])){
						$schet1_xls = "/phpexcel_lib/tmp_gen/".$arFilesXls[0];
					}else{
						$schet1_xls = false;
					}
					if(isset($arFilesXls[1])){
						$schet2_xls = "/phpexcel_lib/tmp_gen/".$arFilesXls[1];
					}else{
						$schet2_xls = false;
					}
					if(isset($arFilesXls[2])){
						$schet3_xls = "/phpexcel_lib/tmp_gen/".$arFilesXls[2];
					}else{
						$schet3_xls = false;
					}
					if(isset($arFilesXls[3])){
						$schet4_xls = "/phpexcel_lib/tmp_gen/".$arFilesXls[3];
					}else{
						$schet4_xls = false;
					}
					
					
					$arFields = Array(						
						"MAILS"=>$mail,
						"ORDER_PDF"=>"/dompdf_lib/tmp_gen/order_".$ORDER_ID.".pdf",
						"SCHET_1"=>$schet1,
						"SCHET_2"=>$schet2,
						"SCHET_3"=>$schet3,
						"SCHET_4"=>$schet4,
						"SCHET_1_XLS"=>$schet1_xls,
						"SCHET_2_XLS"=>$schet2_xls,
						"SCHET_3_XLS"=>$schet3_xls,
						"SCHET_4_XLS"=>$schet4_xls
					);

					$eventName = "DOCS_SEND";
					
					$event = new CEvent;
					$event->Send($eventName, SITE_ID, $arFields, "N");
					
	
	
	//удалить созданные файлы надо бы...
	
  //===================================//
}
else
{
	?>
	<h1><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></h1>
	<div id="print"><?=GetMessage("PRINT_LINK")?></div>
	<div class="clear"></div>
	<p><?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ORDER_ID"]))?></p>
	<p><?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?></p>
	
	<?/*<b><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></b><br /><br />
	<table class="sale_order_full_table">
		<tr>
			<td>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ORDER_ID"]))?>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
			</td>
		</tr>
	</table>*/?>
	<?
}
?>
</div>
