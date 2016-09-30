<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="regions">
	<?
	if($arResult['NAME']) {
	?>
		<h3><?=$arResult['NAME']?></h3>
		<hr />
	<?
	}
	//print_r($arResult['ITEMS']);
?>

				<?
				foreach ($arResult['ITEMS'] as $key => $arItem):
					if($arItem['OFFERS']):
					?>
					<br />
					<h3><?=$arItem['NAME']?></h3>
					
					<?php
					foreach ($arItem['OFFERS'] as $key => $arOneOffer)
					{
						if(empty($arOneOffer["DETAIL_PICTURE"]['SRC']) && !empty($arOneOffer['PROPERTIES']['MAIN_PARTNERSHIP_ID']['VALUE'])) {
							$res = CIBlockElement::GetByID($arOneOffer['PROPERTIES']['MAIN_PARTNERSHIP_ID']['VALUE']);
							if($ar_res = $res->GetNext()) {
								$pic =  CFile::GetPath($ar_res['DETAIL_PICTURE']);
								$arOneOffer["DETAIL_PICTURE"]['SRC'] = $pic;
							}
						
						}
					
						?>
							
							<div class="distributor_wrap">
								<div class="img_logo"><img src="<?=$arOneOffer["DETAIL_PICTURE"]['SRC']?>" /></div>
								<div class="descriptions">
									<div class="title"><?=$arOneOffer['NAME']?></div>
									<div class="address_wrap">
										<?=htmlspecialchars_decode($arOneOffer['DETAIL_TEXT'])?>
									</div>
									<div class="links">
										<a href="http://<?=$arOneOffer['PROPERTIES']['LINK_SITE']['VALUE']?>" target="_blank" class="site"><?=$arOneOffer['PROPERTIES']['LINK_SITE']['VALUE']?></a>
										<a href="mailto:<?=$arOneOffer['PROPERTIES']['LINK_MAIL']['VALUE']?>" class="mail"><?=$arOneOffer['PROPERTIES']['LINK_MAIL']['VALUE']?></a>
									</div>
									<div class="clear"></div>
									<ul class="details">
										<?						
										
									
										if($arOneOffer['PROPERTIES']['SALE_PROD']['VALUE'][0] > 0){	
											foreach($arOneOffer['PROPERTIES']['SALE_PROD']['VALUE'] as $k=>$v){
												$arSelCat = array("ID", "NAME");
												$ar_res=CIBlockSection::GetList(Array("NAME"=>"ASC"), Array("IBLOCK_ID"=>$prod_iblock, "ID"=>$v), $arSelCat);						
												while($arCat=$ar_res->GetNext())
												{
												?>															
													<li><?=$arCat['NAME']?> - <span><?=$arOneOffer['PROPERTIES']['SALE_TYPE_'.($k+1)]['VALUE']?></span></li>
												<?
												}
											}	
										}
										?></ul>
									<?
									if($arOneOffer['PROPERTIES']['DETAILS']['VALUE']['TEXT'])
										echo htmlspecialchars_decode($arOneOffer['PROPERTIES']['DETAILS']['VALUE']['TEXT']);
									?>
									
								</div>					
							</div>
							<br class="clear" />
							<? if (!empty($arOneOffer['USERS'])) {?>
								<table class="TableUsersPartners" style="margin-top: 30px4
								">
									<tr class="First">
										<td>ФИО сотрудника</td>
										<td>Должность</td>
										<td>E-mail</td>
										<td>Режим работы</td>
									</tr>
									<?foreach ($arOneOffer['USERS'] as $user) {?>
												
										<tr>
											<td class="UserImage"><img src="<?=$user['FIELDS']["PREVIEW_PICTURE"] ? CFile::GetPath($user['FIELDS']["PREVIEW_PICTURE"]) : SITE_TEMPLATE_PATH . '/images/no_photo.png'?>" width="100px"/><span><?= $user['FIELDS']['NAME'];?></span></td>
											<td><?= $user['PROPS']['POSITION']['VALUE'];?></td>
											<td><a href="mailto:<?= $user['PROPS']['EMAIL']['VALUE'];?>" target="_blanc"><?= $user['PROPS']['EMAIL']['VALUE'];?></a></td>
											<td><?= $user['PROPS']['WORK_TIMES']['VALUE']['TEXT'];?></td>
										</tr>	
									<?}?>
								</table>
							<?}?>
						<?
						}
						?>
				<?php endif;?>
				<?endforeach;?>
			</ul>
			<div class="clear"></div>
		</div>
<?
