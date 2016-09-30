<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
//если передано id искомого товара
if(isset($_POST['item_name']) && isset($_POST['iblock_id']) && isset($_POST['item_id']) && $_POST['iblock_id']!='' && $_POST['item_id']!='')
{
	$iblock_id=$_POST['iblock_id'];
	$item_id=$_POST['item_id'];
	
	if(CModule::IncludeModule("iblock")) {
		$arSelect = array("IBLOCK_ID", "ID", "NAME", "LID", "DETAIL_PAGE_URL","XML_ID","PROPERTY_*" );	
		$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$iblock_id, "ID"=>$item_id, "ACTIVE"=>"Y"), $arSelect);
        while($ob = $ar_result->GetNextElement()){ 
         $ar_fields = $ob->GetFields();  
 		 $arProps = $ob->GetProperties();	
			$item_name=$ar_fields['NAME'];
			$lid=$ar_fields['LID'];			
			$url=$ar_fields['DETAIL_PAGE_URL'];
            $QUANTITY=1;
			Add2BasketByProductID(
            $item_id, 
            $QUANTITY, 
             array(), 
             array()
            );	
		}
	}
}
else
{
	if(/*isset($_POST['item_name']) || */isset($_POST['item_name_part']))
	{
		//ФУНКЦИИ Декларируются в init.php
		//Получение реального IP-адреса пользователя
		/*function GetRealIp()
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
			$ipDetail=array();
			$f = file_get_contents("http://api.hostip.info/?ip=".$ipAddress);
			//Получаем код страны
			if($f)//если сайт доступен
				preg_match("@<countryAbbrev>(.*?)</countryAbbrev>@si", $f, $countryCode);
			if(!$countryCode[1])//если страна не получена
				return 'EN';//по умолчанию - английская версия
			else
			{
				$ipDetail['countryCode'] = $countryCode[1];		
				return $ipDetail['countryCode'];
			}
		}*/

		//Определяем версию сайта
		if(isset($_COOKIE["site_lang"]))//если пользователем вручную выбрана языковая версия
		{
			if($_COOKIE["site_lang"]=='rus')//если пользователем выбрана русская версия
				$site='ru';
			if($_COOKIE["site_lang"]=='eng')//если пользователем выбрана английская версия
				$site='en';
		}
		else
		{
			$IP=getRealIp();//получение ip
			$ipDetail = getCountryByIp($IP);//получение страны по ip
		
			//Логика редиректов
			if($ipDetail=='RU' || $ipDetail=='BE' || $ipDetail=='KK' || $ipDetail=='UZ' || $ipDetail=='UA' || !$ipDetail)//Белоруссия Казахстан Узбекистан Украина Россиия
				$site='ru';
			else//Другие страны
				$site='en';
		}
		
		//Получаем инфоблоки, соответствующие версии сайта
		if($site!=='ru')
		{
			$iblock_items_id=10;
			$iblock_offers_id=11;
		}
		if($site=='ru')
		{
			$iblock_items_id=2;
			$iblock_offers_id=4;
		}
	}
	
	//Событие по клику на Submit
	/*if(isset($_POST['item_name'])) {
		$item_name=trim($_POST['item_name']);
		
		if(CModule::IncludeModule("iblock")) {
			$arSelect = array("IBLOCK_ID", "ID", "NAME", "LID", "DETAIL_PAGE_URL");	
			$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$iblock_items_id, "NAME"=>$item_name, "ACTIVE"=>"Y"), $arSelect);
			if($ar_fields=$ar_result->GetNext())
			{
				$id_product=$ar_fields['ID'];
				$lid=$ar_fields['LID'];
				$url=$ar_fields['DETAIL_PAGE_URL'];
				if(CModule::IncludeModule("Catalog")) {			
					$ar_res = CCatalogProduct::GetByIDEx($id_product);
					$price=$ar_res['PRICES']['1']['PRICE'];
					$currency=$ar_res['PRICES']['1']['CURRENCY'];
				}
				
				if(CModule::IncludeModule("sale"))
				{
					$arFields = array(
						"QUANTITY" => 1,
						"PRODUCT_ID" => $id_product,
						"PRICE" => 100,
						"CURRENCY" => $currency,
						"LID" => $lid,
						"NAME" => $item_name,
						//"DELAY" => "N",
						"FUSER_ID" => CSaleBasket::GetBasketUserID(),
						"DETAIL_PAGE_URL" => $url,
					);
					CSaleBasket::Add($arFields);
				}
			}
			else
			{
				$arSelect = array("IBLOCK_ID", "ID", "NAME", "LID", "DETAIL_PAGE_URL");	
				$ar_result2=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$iblock_offers_id, "NAME"=>$item_name, "ACTIVE"=>"Y"), $arSelect);
				if($ar_fields2=$ar_result2->GetNext())
				{
					$id_offer=$ar_fields2['ID'];
					$lid=$ar_fields2['LID'];
					$url=$ar_fields2['DETAIL_PAGE_URL'];
					if(CModule::IncludeModule("Catalog")) {			
						$ar_res = CCatalogProduct::GetByIDEx($id_offer);
						$price=$ar_res['PRICES']['1']['PRICE'];
						$currency=$ar_res['PRICES']['1']['CURRENCY'];
					}
					
					if(CModule::IncludeModule("sale"))
					{
						$arFields = array(
							"QUANTITY" => 1,
							"PRODUCT_ID" => $id_offer,
							"PRICE" => $price,
							"CURRENCY" => $currency,
							"LID" => $lid,
							"NAME" => $item_name,
							//"DELAY" => "N",
							"FUSER_ID" => CSaleBasket::GetBasketUserID(),
							"DETAIL_PAGE_URL" => $url,
						);
						CSaleBasket::Add($arFields);
					}
				}
				else
					echo 'no_res';
			}
		}
	}*/
	//Событие на ввод символа (автокомплит)
	if(isset($_POST['item_name_part'])) {
		$item_name=$_POST['item_name_part'];
		
		if(CModule::IncludeModule("iblock")) {
			//Товары
			$name_list='<ul id="items_name_list">';
			$search_res='no';
			$arSelect = array("IBLOCK_ID", "ID", "NAME", "IBLOCK_SECTION_ID");	
			
			$ar_result=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$iblock_items_id, "NAME"=>'%'.$item_name.'%', "ACTIVE"=>"Y"), false);//$arSelect);
			if($ar_result)
			{
				while($ar_fields=$ar_result->GetNext())
				{										
					$arSelect = array("IBLOCK_ID", "ID", "NAME", "IBLOCK_SECTION_ID");	
					$ar_result_offer=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$iblock_offers_id, "PROPERTY_MODEL"=>$ar_fields['ID'], "ACTIVE"=>"Y"), false);//$arSelect);
					$find_offers='no';
					if($ar_result_offer)
					{			
						while($ar_fields_offer=$ar_result_offer->GetNext())
						{
							$res_temp = CIBlockSection::GetByID($ar_fields['IBLOCK_SECTION_ID']);
							if($ar_res_temp = $res_temp->GetNext()){
								if($ar_res_temp['IBLOCK_SECTION_ID'] == 25) 	
									$ar_fields['IBLOCK_SECTION_ID'] = $ar_res_temp['IBLOCK_SECTION_ID'];
							//echo print_r($ar_res_temp),"<br>";
							}
							if($ar_fields['IBLOCK_SECTION_ID'] == 25):
								$name_list=$name_list.'<li item_id="'.$ar_fields_offer['ID'].'" iblock_id="'.$ar_fields_offer['IBLOCK_ID'].'">'.$ar_fields['NAME'].' </li>'; //('.$ar_fields_offer['NAME'].')
							else:
								$name_list=$name_list.'<li item_id="'.$ar_fields_offer['ID'].'" iblock_id="'.$ar_fields_offer['IBLOCK_ID'].'"> '.$ar_fields_offer['NAME'].'</li>'; //('.$ar_fields_offer['NAME'].')
							endif;
							$find_offers='yes';
						}
					}
					if($find_offers=='no')
						$name_list=$name_list.'<li item_id="'.$ar_fields['ID'].'" iblock_id="'.$ar_fields['IBLOCK_ID'].'">'.$ar_fields['NAME'].'</li>';
					
					$search_res='yes';
				}
			}			
			
			//Предложения
			//$arSelect = array("IBLOCK_ID", "ID", "NAME", "PROPERTY_MODEL", "IBLOCK_SECTION_ID");
			//$ar_result2=CIBlockElement::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$iblock_offers_id, "NAME"=>'%'.$item_name.'%', "ACTIVE"=>"Y"), $arSelect);
			if($ar_result2)
			{
				while($ar_fields2=$ar_result2->GetNext())
				{
					if(CModule::IncludeModule("Catalog")) {
						$id_model=$ar_fields2['PROPERTY_MODEL_VALUE'];
						$ar_res_model = CCatalogProduct::GetByIDEx($id_model);//получаем все свойства предложения
						$model_name=$ar_res_model;
					}
					$res_temp = CIBlockSection::GetByID($model_name['IBLOCK_SECTION_ID']);
					if($model_name_temp = $res_temp->GetNext()){
						if($model_name_temp['IBLOCK_SECTION_ID'] == 25)
							$model_name['IBLOCK_SECTION_ID'] = $model_name_temp['IBLOCK_SECTION_ID'];
					}
					//echo print_r($model_name['IBLOCK_SECTION_ID']),"<br>";
					//echo print_r($iblock_offers_id),"<br>";
					//echo $model_name['IBLOCK_SECTION_ID'];
					if(!empty($model_name['IBLOCK_SECTION_ID']) && ($model_name['IBLOCK_SECTION_ID'] == 25 || $model_name['IBLOCK_SECTION_ID'] == 303)):
						$name_list=$name_list.'<li item_id="'.$ar_fields2['ID'].'" iblock_id="'.$ar_fields2['IBLOCK_ID'].'">'.$model_name['NAME'].' </li>';//('.$ar_fields2['NAME'].')
						
					else:
					//if(!empty($model_name['IBLOCK_SECTION_ID']) && $model_name['IBLOCK_SECTION_ID'] == 25):
						$name_list=$name_list.'<li item_id="'.$ar_fields2['ID'].'" iblock_id="'.$ar_fields2['IBLOCK_ID'].'"> '.$ar_fields2['NAME'].'</li>';
					//else:
					//$name_list=$name_list.'<li item_id="'.$ar_fields2['ID'].'" iblock_id="'.$ar_fields2['IBLOCK_ID'].'">'.$model_name['NAME'].' </li>';
					//endif;
					endif;
					
					$search_res='yes';
				}
			}
			
			
			//Определяем версию сайта
				if(isset($_COOKIE["site_lang"]))//если пользователем вручную выбрана языковая версия
				{
					if($_COOKIE["site_lang"]=='rus')//если пользователем выбрана русская версия
						$site='ru';
					if($_COOKIE["site_lang"]=='eng')//если пользователем выбрана английская версия
						$site='en';
				}
				else
				{
					$IP=getRealIp();//получение ip
					$ipDetail = getCountryByIp($IP);//получение страны по ip
				
					//Логика редиректов
					if($ipDetail=='RU' || $ipDetail=='BE' || $ipDetail=='KK' || $ipDetail=='UZ' || $ipDetail=='UA' || !$ipDetail)//Белоруссия Казахстан Узбекистан Украина Россиия
						$site='ru';
					else//Другие страны
						$site='en';
				}
		
		
			if($search_res=='no'){
				if($site == 'ru'){
					$name_list=$name_list.'<li>Соответствий не найдено</li>';
				}else{
					$name_list=$name_list.'<li>No results</li>';
				}
			}
			$name_list=$name_list.'</ul>';
			echo $name_list;
		}
	}
}
?>