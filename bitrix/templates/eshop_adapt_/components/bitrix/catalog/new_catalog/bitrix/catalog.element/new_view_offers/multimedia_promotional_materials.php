<div class="multimedia_body">
    <?
    $arOffesUsed = array();
    foreach ($arResult['OFFERS'] as $offers) {
        if (!in_array($offers['ID'], $arOffesUsed)) {
            if ($offers['ID'] == $_GET['offers_id']) {

                //Собираем в структурированный массив
                $arFiles = $offers['PROPERTIES']['MULTIMEDIA_PROMOTIONAL_MATERIALS']['VALUE'];
                $arResultFiles = array();
                if ($arFiles) {
                    foreach ($arFiles as $key => $file_id) {
                        $desc = $offers['PROPERTIES']['MULTIMEDIA_PROMOTIONAL_MATERIALS']['DESCRIPTION'][$key];
                        $arDesc = explode("****", $desc);
                        $path_file = CFile::GetPath($file_id);
                        if (!$arDesc[1]) {
                            $group = 0;
                        } else {
                            $group = $arDesc[1];
                        }
                        $arResultFiles[$group][] = array(
                            "NAME" => $arDesc[0],
                            "PATH" => $path_file,
                            "VERSION" => $arDesc[2] ? $arDesc[2] : false,
                            "LAST_UPDATE" => $arDesc[3] ? $arDesc[3] : false,
                        );
                    }
                    ?>
                    <table class="multimedia-promotion">
                    <?//echo "<pre>",print_r($arResultFiles),"</pre>";?>
                        <?
                        foreach ($arResultFiles as $group_name => $arItems) {
                            ?>
                            
                            <?if($group_name !== 0):?>
                             
                            <thead>
                                <tr>
                                    <td>
                                        <?= $group_name === 0 ? "" : $group_name ?>
                                    </td>
                                    <td>
                                        Версия документа
                                    </td>
                                    <td>
                                        Последнее обновление
                                    </td>
                                </tr>
                            </thead>
                           
                            <tbody>
                                <?
                                foreach ($arItems as $arItem) {
                                    ?>
                                    <tr>
                                        <td>
                                            <a class="file_catalog_link" href="<?= $arItem["PATH"] ?>" target="_blank"><?= $arItem["NAME"] ?></a>
                                        </td>
                                        <td>
                                            <?= $arItem["VERSION"] ?>
                                        </td>
                                        <td>
                                            <?= $arItem["LAST_UPDATE"] ?>
                                        </td>
                                    </tr>
                                    <?
                                }?>
                         	</tbody>   
                         	<?endif;?>
						<?  }?>
                                              
                    </table>
                    <?
                }
            }
        }
        $arOffesUsed[] = $offers["ID"];
    }
    ?>
    <div class="include_area">
        <?
        $include_area = $arResult['PROPERTIES']['MULTIMEDIA_PROMOTIONAL_MATERIALS_INCLUDE']['VALUE']['TEXT'];
        if ($include_area) {
            echo '<div class="include_area_wrap">' . htmlspecialchars_decode($include_area) . '</div>';
        }
        ?>
    </div>
</div>