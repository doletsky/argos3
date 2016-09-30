<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<form name="<?= $arResult["FILTER_NAME"] . "_form" ?>" action="<?= $arResult["FORM_ACTION"] ?>" method="get" class="catalog-filter">
    <?
    foreach ($arResult["ITEMS"] as $arItem):
        if (array_key_exists("HIDDEN", $arItem)):
            echo $arItem["INPUT"];
        endif;
    endforeach;
    ?>
    <table class="data-table" cellspacing="0" cellpadding="2">
        <tbody>
            <? foreach ($arResult["ITEMS"] as $code => $arItem): ?>
                <? if (!array_key_exists("HIDDEN", $arItem)): ?>
                    <tr>
                        <td valign="top">
                            <?= $arItem["NAME"] ?>:
                        </td>
                        <td valign="top">
                            <?= $arItem["INPUT"] ?>
                        </td>
                    </tr>
                <? endif ?>
            <? endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <button type="submit" name="set_filter" value="<?= GetMessage("IBLOCK_SET_FILTER") ?>" class="detail-text"><?= GetMessage("IBLOCK_SET_FILTER") ?></button>
                    <input type="hidden" name="set_filter" value="Y" />&nbsp;&nbsp;
                </td>
            </tr>
        </tfoot>
    </table>
</form>
