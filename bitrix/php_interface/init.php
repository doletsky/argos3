<?
function pre_debug($array){
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

AddEventHandler("main", "OnEndBufferContent", "stopLink");

function stopLink(&$content){
	global $USER, $APPLICATION;
	
	if((is_object($USER) && $USER->IsAuthorized()) || strpos($APPLICATION->GetCurDir(), "/bitrix/")!==false) return;
	if($APPLICATION->GetProperty("save_kernel") == "Y") return;
	//$content = preg_replace("/(<a [^>]*?href\s*=\s*[\"|']+?)[^\"']*?([\"|']+?[^>]*>)/si","\$1\$2",$content);
	//$content = 
	$content = preg_replace('~(<a(?>.*?href))=(["\'])([a-z0-9]++://(?![a-z0-9\.]*?argos-trade\.com).*?)\2~eS', '"\1=\"#\" onmouseover=\"this.href=\'$3\';this.target=\'_blank\'\"";', $content);
	
	//$content = preg_replace("/\<a href\=\"(https*\:\/\/[\w\.]+)\"\>(.*)\<\/a\>/i","[url]$1[/url]", $content);
}

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("MyClass_code", "OnBeforeIBlockElementAddHandler"));
class MyClass_code
{    
    function OnBeforeIBlockElementAddHandler(&$arFields)
    {
        if($arFields["IBLOCK_ID"] ==8 && empty($arFields["CODE"])){
        $name = $arFields["NAME"];
            $arParams = array("replace_space"=>"-","replace_other"=>"-");
            $trans = Cutil::translit($name,"ru",$arParams);
        $arFields["CODE"] = $trans;}
    }
}

include(GetLangFileName(dirname(__FILE__)."/", "/init.php"));
//Событие корзины перед добавлением товара в корзину
AddEventHandler("sale", "OnBeforeBasketAdd", "funcBasketAdd");
function funcBasketAdd(&$arFields)
{
	if (isset($_GET['quantity'])){
		$arFields['QUANTITY']=$_GET['quantity'];
	}
	
	/*$arFields['QUANTITY']=12;
	$arFields["PRICE"] = 12;
	$arFields["CALLBACK_FUNC"] = ""; 
	$arFields["IGNORE_CALLBACK_FUNC"] = "Y";	*/
	
}

//Событие корзины до удаления записи
/*AddEventHandler( 'sale', 'OnBeforeBasketDelete', 'ddOnBeforeBasketDelete' );
function ddOnBeforeBasketDelete( $iId )
{
	if(isset($_GET['count']) && $_GET['count']=='all')
	{
		//Для очищения корзины от всех товаров
		CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());		
	}
}*/


//===========GEOIP===========

//Получение реального IP-адреса пользователя
	function getRealIp()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}	
	//Получать информацию по IP
	function getCountryByIp($ipAddress)
	{
		$countryCode = null;
		
		return $countryCode = 'RU';
		
		$cache = new CPHPCache();
		$cache_time = 3600000;
		$cache_id = 'ip' . $ipAddress;
		
		$cache_path = '/';
		
		
		if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
			$countryCode = $cache->GetVars();
		}
		
		if (empty($countryCode)) {
			
			$ipDetail=array();
			
			//сервис host-ip
			//$f = file_get_contents("http://api.hostip.info/?ip=".$ipAddress);/***раскомментировать**/
			
			
			//сервис sypexgeo
			$f = file_get_contents("http://api.sypexgeo.net/json/$ipAddress");
			$obData = json_decode($f);		/*получаем объект с кучей данных о местоположении*/
			
			if(!$obData) {//если страна не получена
				$countryCode = 'RU';//по умолчанию - русская версия
			}
			else
			{
				$ipDetail['countryCode'] = $obData->country->iso;
					
				$countryCode = !empty($ipDetail['countryCode']) ? $ipDetail['countryCode'] : 'RU';
			}
			//****************//

		
			if ($cache_time > 0) {
				$cache->StartDataCache($cache_time, $cache_id, $cache_path);
				$cache->EndDataCache($countryCode);
			}
		}

		return $countryCode;

		 
		 
		/*//Получаем название города
		//preg_match("@<Hostip>(\s)*<gml:name>(.*?)</gml:name>@si", $f, $city);
		preg_match("@</ip>(\s)*<gml:name>(.*?)</gml:name>@si", $f, $city);
		$ipDetail['city'] = $city[2];
		
		//Получаем название страны
		preg_match("@<countryName>(.*?)</countryName>@si", $f, $country);
		$ipDetail['country'] = $country[1];
		*/
		
		
		//Получаем код страны /**раскомментировать***/
		/*if($f)//если сайт доступен
			preg_match("@<countryAbbrev>(.*?)</countryAbbrev>@si", $f, $countryCode);
		if(!$countryCode[1])//если страна не получена
			return 'RU';//по умолчанию - русская версия
		else
		{
			$ipDetail['countryCode'] = $countryCode[1];		
			return $ipDetail['countryCode'];
		}*/
		
	}
	
//+======================================


//ПОДПИСКА
//Добавление вкладки
AddEventHandler("main", "OnAdminTabControlBegin", "MyOnAdminTabControlBegin");
function MyOnAdminTabControlBegin(&$form)
{
   if (strpos($GLOBALS["APPLICATION"]->GetCurPage(),"/bitrix/admin/subscr_edit.php")===false){} else {
      $subscr_arrmy["USER_PROPERTIES"]=$GLOBALS["USER_FIELD_MANAGER"]->GetUserFields(
         "MY_SUBSCRIPTION",
         $_REQUEST["ID"],
         LANGUAGE_ID
      );
	  
	  foreach($subscr_arrmy["USER_PROPERTIES"] as $k=>$arUField){
		$newVal = str_replace("\"", "'", $arUField['VALUE']);		
		$subscr_arrmy["USER_PROPERTIES"][$k]['VALUE'] = $newVal;
	  }
	  
	  
	  
      if ($_REQUEST["ID"]):
         $form->tabs[] = array("DIV" => "my_edit", "TAB" => "Дополнительные данные", "ICON"=>"main_user_edit", "TITLE"=>"Дополнительные данные о подписчике", "CONTENT"=>
            '
			<tr valign="top">
               <td>Компания:</td>
               <td><input type="text" name="UF_COMPANY_NAME" value="'.$subscr_arrmy["USER_PROPERTIES"]["UF_COMPANY_NAME"]["VALUE"].'" size="30"><br></td>
            </tr>
			<tr valign="top">
               <td>Город:</td>
               <td><input type="text" name="UF_TOWN" value="'.$subscr_arrmy["USER_PROPERTIES"]["UF_TOWN"]["VALUE"].'" size="30"><br></td>
            </tr>
            <tr valign="top">
               <td>ФИО:</td>
               <td><input type="text" name="UF_FIO" value="'.$subscr_arrmy["USER_PROPERTIES"]["UF_FIO"]["VALUE"].'" size="30"><br></td>
            </tr>
			<tr valign="top">
               <td>Должность:</td>
               <td><input type="text" name="UF_POST" value="'.$subscr_arrmy["USER_PROPERTIES"]["UF_POST"]["VALUE"].'" size="30"><br></td>
            </tr>
			<tr valign="top">
               <td>Сайт:</td>
               <td><input type="text" name="UF_SITE" value="'.$subscr_arrmy["USER_PROPERTIES"]["UF_SITE"]["VALUE"].'" size="30"><br></td>
            </tr>
            <tr valign="top">
               <td>Телефон:</td>
               <td><input type="text" name="UF_PHONE" value="'.$subscr_arrmy["USER_PROPERTIES"]["UF_PHONE"]["VALUE"].'" size="30"><br></td>
            </tr>
            
            '
         );
      endif;
   }
}
//Добавление дополнительныч столбцов в таблице подписчиков
AddEventHandler("main", "OnAdminListDisplay", "MyOnAdminListDisplay");
function MyOnAdminListDisplay(&$list)
{
   //add custom group action
   if($list->table_id == "tbl_subscr"){
      $timeArOption=array(
         "COMPANY_NAME"=>array(
            "id"=>"COMPANY_NAME",
            "content"=>"Компания",
         ),
		 "TOWN"=>array(
            "id"=>"TOWN",
            "content"=>"Город",
         ),
		 "FIO"=>array(
            "id"=>"FIO",
            "content"=>"ФИО",
         ),
		 "POST"=>array(
            "id"=>"POST",
            "content"=>"Должность",
         ),
         "SITE"=>array(
            "id"=>"SITE",
            "content"=>"Сайт",
         ),
         "PHONE"=>array(
            "id"=>"PHONE",
            "content"=>"Телефон",
         )
      );

      foreach ($timeArOption as $key=>$tumeOp):
         $list->aHeaders[$key]=$tumeOp;
         $list->arVisibleColumns[]=$key;
      endforeach;

      foreach($list->aRows as $row):
         $subscr_arrmy["USER_PROPERTIES"]=$GLOBALS["USER_FIELD_MANAGER"]->GetUserFields(
            "MY_SUBSCRIPTION",
            $row->arRes["ID"],
            LANGUAGE_ID
         );
         foreach ($timeArOption as $key=>$tumeOp):
            $row->aHeaders[$key] = $tumeOp;
            $row->aHeadersID[]=$key;
            $row->aFields[$key]["view"]=array(
                "type" => "html",
                "value" => $subscr_arrmy["USER_PROPERTIES"]['UF_'.$key]["VALUE"]
            );
            $row->arRes[$key]=$subscr_arrmy["USER_PROPERTIES"]['UF_'.$key]["VALUE"];
         endforeach;
      endforeach;
   }
}
//Сохранение пользовательских свойств
AddEventHandler("main", "OnBeforeProlog", "MyOnBeforeProlog");
function MyOnBeforeProlog()
{
  if (strpos($GLOBALS["APPLICATION"]->GetCurPage(),"/bitrix/admin/subscr_edit.php")===false){} else {
   if($_SERVER["REQUEST_METHOD"] == "POST"){          
         if ($_REQUEST["ID"]):
             global $USER_FIELD_MANAGER;
            $arUserFields = $USER_FIELD_MANAGER->GetUserFields("MY_SUBSCRIPTION");
            $arUsFields = array();
            foreach($arUserFields as $FIELD_ID => $arField)
               $arUsFields[$FIELD_ID] = $_REQUEST[$FIELD_ID];
            $USER_FIELD_MANAGER->Update("MY_SUBSCRIPTION", $_REQUEST["ID"], $arUsFields);
         endif;
   }
  }
}

//Событие для автоматического включения НДС в цену
//AddEventHandler("sale", "OnProductAdd", "OnProductAdd");
function OnProductAdd($ID,$Fields)
{
	$res=Array("VAT_INCLUDED"=>'Y');
	CCatalogProduct::Update($ID,$res);
}


//добавляем НДС и скидки
//AddEventHandler("catalog", "OnGetOptimalPrice", "MyGetOptimalPrice");
   
function MyGetOptimalPrice(
    $intProductID,
    $quantity = 1,
    $arUserGroups = array(),
    $renewal = "N",
    $arPrices = array(),
    $siteID = false,
    $arDiscountCoupons = false
 )/*{ 
	//работает без учёта расширенных цен. Для их работы немного изменяем функцию GetOptimalPrice ниже.
	//НДС в зависимости от IP
	$ar_res = CCatalogProduct::GetByIDEx($intProductID);
	?><pre><?//print_r($ar_res)?></pre><?
	//die();
	
	$price = $ar_res['PRICES'][1]['PRICE'];
	
	$IP=getRealIp();//получение ip
	$ipDetail = getCountryByIp($IP);//получение страны по ip
	
	if(SITE_DIR == '/' && $ipDetail == 'RU'){
		$new_price = $price + $price * 0.18;
	}else{
		$new_price = $price;
	}
	
	$currency = $ar_res['PRICES'][1]['CURRENCY'];
	
	//массивы скидок
	if($_COOKIE["item".$intProductID]=='60'){
		$arDiscount = array(
                'VALUE_TYPE'=> 'P',
                'VALUE'=>'2',
                'CURRENCY'=>$currency 
            );
	}elseif($_COOKIE["item".$intProductID]=='30'){
		$arDiscount = array(
                'VALUE_TYPE'=> 'P',
                'VALUE'=>'1',
                'CURRENCY'=>$currency 
            );
	}else{
		$arDiscount = array();
	}
	
	//результирующий массив
	return array(
        'PRICE' => array(
            'PRICE' => $new_price,
            'CURRENCY' => $currency,
        ),
        'DISCOUNT_LIST' => array(
            $arDiscount
        ),
    );
 }*/
 {
		global $APPLICATION;
		
		$intProductID = intval($intProductID);
		if (0 >= $intProductID)
		{
			$APPLICATION->ThrowException(GetMessage("BT_MOD_CATALOG_PROD_ERR_PRODUCT_ID_ABSENT"), "NO_PRODUCT_ID");
			return false;
		}

		$quantity = doubleval($quantity);
		if (0 >= $quantity)
		{
			$APPLICATION->ThrowException(GetMessage("BT_MOD_CATALOG_PROD_ERR_QUANTITY_ABSENT"), "NO_QUANTITY");
			return false;
		}

		if (!is_array($arUserGroups) && intval($arUserGroups)."|" == $arUserGroups."|")
			$arUserGroups = array(intval($arUserGroups));

		if (!is_array($arUserGroups))
			$arUserGroups = array();

		if (!in_array(2, $arUserGroups))
			$arUserGroups[] = 2;

		$rsVAT = CCatalogProduct::GetVATInfo($intProductID);
		if ($arVAT = $rsVAT->Fetch())
		{
			$arVAT['RATE'] = doubleval($arVAT['RATE'] * 0.01);
		}
		else
		{
			$arVAT = array('RATE' => 0.0, 'VAT_INCLUDED' => 'N');
		}

		$renewal = (($renewal == "N") ? "N" : "Y");

		if (false === $siteID)
			$siteID = SITE_ID;

		if (false === $arDiscountCoupons)
			$arDiscountCoupons = CCatalogDiscountCoupon::GetCoupons();

		$strBaseCurrency = CCurrency::GetBaseCurrency();
		if (empty($strBaseCurrency))
		{
			$APPLICATION->ThrowException(GetMessage("BT_MOD_CATALOG_PROD_ERR_NO_BASE_CURRENCY"), "NO_BASE_CURRENCY");
			return false;
		}

		$intIBlockID = intval(CIBlockElement::GetIBlockByID($intProductID));
		if (0 >= $intIBlockID)
		{
			$APPLICATION->ThrowException(str_replace("#ID#", $intProductID, GetMessage('BT_MOD_CATALOG_PROD_ERR_ELEMENT_ID_NOT_FOUND')), "NO_ELEMENT");
			return false;
		}

		if (!isset($arPrices) || !is_array($arPrices))
			$arPrices = array();

		if (empty($arPrices))
		{
			$arPrices = array();
			$dbPriceList = CPrice::GetListEx(
				array(),
				array(
						"PRODUCT_ID" => $intProductID,
						"GROUP_GROUP_ID" => $arUserGroups,
						"GROUP_BUY" => "Y",
						"+<=QUANTITY_FROM" => $quantity,
						"+>=QUANTITY_TO" => $quantity
					),
				false,
				false,
				array("ID", "CATALOG_GROUP_ID", "PRICE", "CURRENCY")
			);
			while ($arPriceList = $dbPriceList->Fetch())
			{
				$arPriceList['ELEMENT_IBLOCK_ID'] = $intIBlockID;
				$arPrices[] = $arPriceList;
			}
		}
		else
		{
			foreach ($arPrices as &$arOnePrice)
			{
				$arOnePrice['ELEMENT_IBLOCK_ID'] = $intIBlockID;
			}
			if (isset($arOnePrice))
				unset($arOnePrice);
		}

		if (empty($arPrices))
			return false;

//		$boolDiscountVat = ('N' != COption::GetOptionString('catalog', 'discount_vat', 'Y'));
		$boolDiscountVat = true;
		$strDiscSaveApply = COption::GetOptionString('catalog', 'discsave_apply', 'R');

		$dblMinPrice = -1;
		$arMinPrice = array();
		$arMinDiscounts = array();

		foreach ($arPrices as &$arPriceList)
		{
			$arPriceList['VAT_RATE'] = $arVAT['RATE'];
			$arPriceList['VAT_INCLUDED'] = $arVAT['VAT_INCLUDED'];
			$arPriceList['ORIG_VAT_INCLUDED'] = $arPriceList['VAT_INCLUDED'];

			if ($boolDiscountVat)
			{
				if ('N' == $arPriceList['VAT_INCLUDED'])
				{
					$arPriceList['PRICE'] *= (1 + $arPriceList['VAT_RATE']);
					$arPriceList['VAT_INCLUDED'] = 'Y';
				}
			}
			else
			{
				if ('Y' == $arPriceList['VAT_INCLUDED'])
				{
					$arPriceList['PRICE'] /= (1 + $arPriceList['VAT_RATE']);
					$arPriceList['VAT_INCLUDED'] = 'N';
				}
			}

			if ($arPriceList["CURRENCY"] == $strBaseCurrency)
				$dblCurrentPrice = $arPriceList["PRICE"];
			else
				$dblCurrentPrice = CCurrencyRates::ConvertCurrency($arPriceList["PRICE"], $arPriceList["CURRENCY"], $strBaseCurrency);

			$arDiscounts = CCatalogDiscount::GetDiscount($intProductID, $intIBlockID, $arPriceList["CATALOG_GROUP_ID"], $arUserGroups, $renewal, $siteID, $arDiscountCoupons);

			$arDiscSave = array();
			$arPriceDiscount = array();

			$arResultPrice = array(
				'PRICE' => $dblCurrentPrice,
				'CURRENCY' => $strBaseCurrency,
			);
			$arDiscountApply = array();

			
			if (-1 == $dblMinPrice || $dblMinPrice > $arResultPrice['PRICE'])
			{
				$dblMinPrice = $arResultPrice['PRICE'];
				$arMinPrice = $arPriceList;
				$arMinDiscounts = $arDiscountApply;
			}
		}
		if (isset($arPriceList))
			unset($arPriceList);

		if ($boolDiscountVat)
		{
			if ('N' == $arMinPrice['ORIG_VAT_INCLUDED'])
			{
				$arMinPrice['PRICE'] /= (1 + $arMinPrice['VAT_RATE']);
				$arMinPrice['VAT_INCLUDED'] = $arMinPrice['ORIG_VAT_INCLUDED'];
			}
		}
		else
		{
			if ('Y' == $arMinPrice['ORIG_VAT_INCLUDED'])
			{
				$arMinPrice['PRICE'] *= (1 + $arMinPrice['VAT_RATE']);
				$arMinPrice['VAT_INCLUDED'] = $arMinPrice['ORIG_VAT_INCLUDED'];
			}
		}
		unset($arMinPrice['ORIG_VAT_INCLUDED']);

		$dblMinPrice = roundEx($dblMinPrice, CATALOG_VALUE_PRECISION);
		
		
	//Корректировка массива цен//-------------------------------//
		//НДС в зависимости от IP		
	$IP=getRealIp();//получение ip
	$ipDetail = getCountryByIp($IP);//получение страны по ip	
	
	if((SITE_DIR == '/' && $ipDetail == 'RU') || (SITE_DIR == '/' && !$ipDetail)){
		$new_price = $arMinPrice['PRICE']; // + $arMinPrice['PRICE'] * 0.18;
	}else{
		$new_price = $arMinPrice['PRICE'];
	}
	
	$currency = $arMinPrice['CURRENCY'];
	
	//формируем свои массивы скидок вместо стандартных
	if($_COOKIE["item".$intProductID]=='60'){
		$arDiscount = array(
                'VALUE_TYPE'=> 'P',
                'VALUE'=>'2',
                'CURRENCY'=>$currency 
            );
	}elseif($_COOKIE["item".$intProductID]=='30'){
		$arDiscount = array(
                'VALUE_TYPE'=> 'P',
                'VALUE'=>'1',
                'CURRENCY'=>$currency 
            );
	}else{
		$arDiscount = array();
	}
		
	//результирующий массив
	$arMinPrice['PRICE'] = $new_price;	
	 //-----------------------------------------//
		

		$arResult = array(
			'PRICE' => $arMinPrice,
			//'DISCOUNT_PRICE' => $dblMinPrice,
			//'DISCOUNT' => array(),
			'DISCOUNT_LIST' => array(
            $arDiscount
        ),
		);
		
		return $arResult;
	}
 
 
 
 
//Отписка
AddEventHandler("subscribe", "BeforePostingSendMail", array("SubscribeHandlers", "BeforePostingSendMailHandler"));

class SubscribeHandlers
{
    function BeforePostingSendMailHandler($arFields)
    {
        $rsSub = CSubscription::GetByEmail($arFields["EMAIL"]);
        $arSub = $rsSub->Fetch();

        $arFields["BODY"] = str_replace("#MAIL_ID#", $arSub["ID"], $arFields["BODY"]);
        $arFields["BODY"] = str_replace("#MAIL_MD5#", SubscribeHandlers::GetMailHash($arFields["EMAIL"]), $arFields["BODY"]);

        return $arFields;
    }

    function GetMailHash($email)
    {
        return md5(md5($email) . MAIL_SALT);
    }
}


//класс для отправки файлов
	class VFile{

		static function FullUpload($inputName, $Uid, $count, $subdir){		
			
			//params
			$uploadFile_extentions = array('.jpg','.JPG','.jpeg','.JPEG', '.png', '.bmp', '.tiff', '.gif', '.pdf', '.doc', '.docx');
			$max_File_size = 1024*5*1024; //файл 5Mb		

			if (isset($_FILES[$inputName]['name']) && $_FILES[$inputName]['name'][0] !== ''){
				for($i=0; $i<$count; $i++){
					//vars
					$safe_name = str_replace(" ", "_", $_FILES[$inputName]['name'][$i]);
					$uploadFile = $safe_name;
					$uploadFileSize = $_FILES[$inputName]['size'][$i];
					$tmpFile = $_FILES[$inputName]['tmp_name'][$i];
					$uploaddir = $_SERVER['DOCUMENT_ROOT'].$subdir;
					
					$extensionFile=strrchr($uploadFile, '.' );
					if(!in_array($extensionFile, $uploadFile_extentions) || $uploadFileSize > $max_File_size)
					{
							if(SITE_DIR == '/')
								echo "<div class='info_mess fr'>Произошла ошибка, возможно, превышен максимальный размер файла или у файла недопустимое расширение</div>";
							if(SITE_DIR == '/en/')
								echo "<div class='info_mess fr'>File download has failed because of wrong extention or too big size of a file. Please try again</div>";
								
							$file = 'error';
					}else{						
						$file[] = self::ImageUpload($uploaddir, $uploadFile, $tmpFile);										
					}
				}
				if($file){
					return $file;		
				}
			}
			
		}
		
		static function ImageUpload($uploaddir, $uploadFile, $tmpFile){
			
			if(!file_exists($uploaddir)){
				mkdir($uploaddir, 0755);
			}
			if(file_exists($uploaddir . basename($uploadFile))){
				$arrName = explode('.', $uploadFile);
				$name = $arrName[0].'_'.rand(10000, 99999);
				$uploadfile = $uploaddir . $name.'.'.$arrName[1];
				$fileUpl = $name.'.'.$arrName[1];		
			}else{
				$uploadfile = $uploaddir . basename($uploadFile);
				$fileUpl = basename($uploadFile);		
			}
			
			if (move_uploaded_file($tmpFile, $uploadfile)) {
				//echo "<div class='info_mess'>Файл корректен и был успешно загружен.</div>";
			} else {
				echo "<div class='info_mess'>Произошла ошибка, возможно, превышен максимальный размер файла</div>";
			}
			return $fileUpl;
		}
	}
	
	//******************//
	
	
	/*Отправление пользователю письма о регистрации*/
	AddEventHandler("main", "OnAfterUserAdd", "OnAfterUserRegisterHandler");/*добавление*/
	AddEventHandler("main", "OnAfterUserUpdate", "OnAfterUserRegisterHandler");/*обновление*/
	//AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");/*регистрация*/
	//AddEventHandler("main", "OnAfterUserSimpleRegister", "OnAfterUserRegisterHandler");/*упрощённая регистрация*/
	
	function OnAfterUserRegisterHandler(&$arFields)
	{
	   if (intval($arFields["ID"])>0)
	   {   
		  $toSend = Array();
		  $toSend["PASSWORD"] = $arFields["CONFIRM_PASSWORD"];
		  $toSend["EMAIL"] = $arFields["EMAIL"];
		  $toSend["USER_ID"] = $arFields["ID"];
		  $toSend["USER_IP"] = $arFields["USER_IP"];
		  $toSend["USER_HOST"] = $arFields["USER_HOST"];
		  $toSend["LOGIN"] = $arFields["LOGIN"];
		  $toSend["NAME"] = (trim ($arFields["NAME"]) == "")? $toSend["NAME"] = '' : $arFields["NAME"];
		  $toSend["LAST_NAME"] = ( trim ($arFields["LAST_NAME"]) == "")? $toSend["LAST_NAME"] = '' : $arFields["LAST_NAME"];
		  $toSend["HASH"] = md5($toSend["EMAIL"]);
		  $toSend["CH_PASS_MESS"] = "";	 
		  
		 	//ссылка в зависимости от языка  
		  if($arFields['LID'] == 'ru'){
			$toSend["CH_PASS_LINK"] = 'http://argos-trade.com/personal/changepass.php?ID='.$toSend["USER_ID"].'&HASH='.$toSend["HASH"];
			$toSend["THEME_PORTFOLIO"] = "Создание портфолио";
		  }elseif($arFields['LID'] == 'en'){
			$toSend["CH_PASS_LINK"] = 'http://argos-trade.com/en/personal/changepass.php?ID='.$toSend["USER_ID"].'&HASH='.$toSend["HASH"];
			$toSend["THEME_PORTFOLIO"] = "New portfolio";
		  }elseif($arFields['LID'] == 'de'){
			$toSend["CH_PASS_LINK"] = 'http://argos-trade.com/de/personal/changepass.php?ID='.$toSend["USER_ID"].'&HASH='.$toSend["HASH"];
			$toSend["THEME_PORTFOLIO"] = "New portfolio";
		  }
			
			/*если обновляем пароль с сайта, то не хватает данных для шаблона. получам их тут*/
			if($toSend["LOGIN"] == ''){
				$user = new CUser;
				$rsUser = $user->GetByID($toSend["USER_ID"]);
				$arUser = $rsUser->Fetch();
				$toSend["LOGIN"] = $arUser["LOGIN"];
				$toSend["NAME"] = (trim ($arUser["NAME"]) == "")? $toSend["NAME"] = "": $arUser["NAME"];
				$toSend["LAST_NAME"] = ( trim ($arUser["LAST_NAME"]) == "")? $toSend["LAST_NAME"] = "": $arUser["LAST_NAME"];
				$toSend["CH_PASS_MESS"] = "Это письмо отправлено вам в ответ на запрос смены пароля.";
				
				if($arUser['LID'] == 'ru'){
					$toSend["CH_PASS_MESS"] = "Это письмо отправлено вам в ответ на запрос смены пароля.";
				}elseif($arUser['LID'] == 'en'){
					$toSend["CH_PASS_MESS"] = "This is the answer for your request to change the password.";
				}elseif($arUser['LID'] == 'de'){
					$toSend["CH_PASS_MESS"] = "This is the answer for your request to change the password.";
				}
			}
			
		    $arrSites = array();
			$objSites = CSite::GetList();
			while ($arrSite = $objSites->Fetch())
				$arrSites[] = $arrSite["ID"];
				
		  CEvent::SendImmediate ("NEW_USER_WITH_PASS", $arrSites, $toSend);/*не записываем событие в таблицу, чтобы писать - нужно использовать CEvent::Send*/
	   }
	   return $arFields;
	}
	/*==================*/

	AddEventHandler("main", "OnBuildGlobalMenu", "DoBuildGlobalMenu");

	function DoBuildGlobalMenu(&$aGlobalMenu, &$aModuleMenu)
	{
		$aModuleMenu[] = array(
			"parent_menu" => "global_menu_services",
			"text" => "Загрузка остатков",
			"section" => "ext_upload",
			"sort" => 300,
			"items_id" => "menu_ext_upload",
			"title" => "Выгрузка остатков",
			"url" => "/bitrix/admin/catalog_stock.php",
			"more_url" => array(),
		);
	}

    //корректор sitemap.xml
    include $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/include/sitemap_correct/class.php";
    AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "SMapCorrMain");


?>