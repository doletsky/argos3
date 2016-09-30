<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
if (!empty($arResult['ITEMS'])) {
    $count = 1;
    foreach ($arResult['ITEMS'] as $key => $arItem) {
        ?>
        <div class="portfolio_wrap<? if ($count == 3) echo ' last'; ?>">
            <?
            //$src_img = CFile::GetPath($arItem["DETAIL_PICTURE"]['ID']);//id картинки

            $img_src = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE'], Array('width' => 292, 'height' => 219), BX_RESIZE_IMAGE_EXACT, true);

           ?>
            <a href="<?= $arItem['DETAIL_PICTURE']['SRC'] ?>" class="img_wrap fancybox-button">
                <img src="<?= $img_src['src'] ?>" />
            </a>
            <div class="wraper-object-new">
                <div class="object_text object_type"><span><?= GetMessage("OBJECT_TYPE") ?>: </span><?= $arItem['PROPERTIES']['OBJECT_TYPE']['VALUE'] ?></div>
                <div class="object_text object_name"><span><?= GetMessage("OBJECT_NAME") ?>: </span><?= $arItem['NAME'] ?></div>
                <div class="object_text object_address"><span><?= GetMessage("CITY") ?>: </span><?= $arItem['PROPERTIES']['CITY']['VALUE'] ?></div>
            </div>    
            <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="detail-text" target="_BLANK" rel="nofollow">Подробнее</a>

            
            <?php
            /*
              <div class="object_text object_address"><span><?=GetMessage("CITY")?>: </span><?=$arItem['PROPERTIES']['CITY']['VALUE']?></div>
              <div class="object_text object_address"><span><?=GetMessage("ADDRESS")?>: </span><?=$arItem['PROPERTIES']['OBJECT_ADDRESS']['VALUE']?></div>
              <div class="object_text object_phone"><span><?=GetMessage("TELEPHONE")?>: </span><?=$arItem['PROPERTIES']['SERVICE_PHONE']['VALUE']?></div>
              <?
              $file_id=$arItem['PROPERTIES']['THANKS_LETTER']['VALUE'];
              if($file_id > 0){
              ?>
              <div class="object_text object_thanks">
              <span><?=GetMessage("RECOMMENDATION_LETTER")?>: </span>
              <?
              $file_info = CFile::GetFileArray($file_id);
              ?>
              <a target="_blank" href="<?=$file_info['SRC']?>"><?=$file_info['ORIGINAL_NAME']?></a>
              </div>
              <?
              }
              ?>
              <div class="object_text object_manufacture object_grade"><span><?=GetMessage("MANUFACTURER")?>: </span><?=$arItem['PROPERTIES']['MANUFACTURER_OF_LAMPS']['VALUE']?></div>
              <div class="object_text object_site"><span><?=GetMessage("WEBSITE")?>: </span><?=$arItem['PROPERTIES']['SITE']['VALUE']?></div>
              <?/*if($arItem['PROPERTIES']['TYPE_OF_LUM']['VALUE']!='') {
              foreach ($arItem['PROPERTIES']['TYPE_OF_LUM']['VALUE_XML_ID'] as $id_complete)
              {
              if($id_complete==3)
              { */
            /* if($arItem['PROPERTIES']['MODEL_OF_LAMPS']['VALUE']!='')
              {
              $strValues = implode(', ', $arItem['PROPERTIES']['MODEL_OF_LAMPS']['VALUE']);
              ?>
              <div class="object_text object_model">
              <span><?=GetMessage("MODEL")?>: </span><?=$strValues?>
              </div>
              <?
              } */
            /* }
              }
              } */
            ?>

            <?
            /* if($arItem['PROPERTIES']['TYPE_OF_LUM']['VALUE']!='') {
              foreach ($arItem['PROPERTIES']['TYPE_OF_LUM']['VALUE_XML_ID'] as $id_complete)
              {
              if($id_complete==1)
              { */
            /* if($arItem['PROPERTIES']['COMPLETE_ARGOS_LUM']['VALUE']!='')
              {
              $strValues = implode(', ', $arItem['PROPERTIES']['COMPLETE_ARGOS_LUM']['VALUE']);
              ?>
              <div class="object_text object_grade">
              <span><?=GetMessage("EQUIPMENT")?>: </span><?=$strValues?>
              </div>
              <?
              } */
            /* }
              if($id_complete==2)
              { */
            /* if($arItem['PROPERTIES']['COMPLETE_ARGOS_LED']['VALUE']!='')
              {
              $strValues = implode(', ', $arItem['PROPERTIES']['COMPLETE_ARGOS_LED']['VALUE']);
              ?>
              <div class="object_text object_grade">
              <span><?=GetMessage("EQUIPMENT")?>: </span><?=$strValues?>
              </div>
              <?
              } */
            /* }
              }
              } */
            ?>

        </div>
        <?
        if ($count == 3) {
            echo '<div class="clear"></div>';
            $count = 0;
        }
        $count++;
    }
}
?>
<?= $arResult["NAV_STRING"] ?>