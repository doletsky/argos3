<?php
/**
 * Created by PhpStorm.
 * User: adoletskiy
 * Date: 28.11.16
 * Time: 15:51
 */
$reserved=array(
    "ELEMENT", "IBLOCK", "SECTION", "SKU", "PROPERTY"
);
$str='/#PROPERTY_WIN_SIZE_VALUE_1200_SECTION_svet_v_okne_SECTION_FULLPATH_CODE#/catalog/#SECTION_32_ELEMENT_*_CODE#/';
$params=array();

$arStr=explode('#',$str);
$cnt=count($arStr);
if($cnt>2){
    for($i=0;$i<floor(($cnt-1)/2);$i++){
        $arMask=explode('_',$arStr[1+$i*2]);
        $param=array();
        foreach($arMask as $k=>$item){
            if($k==count($arMask)-1){
                $param[count($param)-1]['RETURN']=$item;
                break;
            }
            if(in_array($item,$reserved)){
                $param[count($param)]['FIELD']=$item;
            }else{
                if(strlen($param[count($param)-1]['PARAM'])>0){//���� �������� � ����� ��� ��������� � �������������� ������� "_", �� �������� ��� �������
                    $param[count($param)-1]['PARAM'].="_".$item;
                }else{
                    $param[count($param)-1]['PARAM']=$item;
                }

            }
        }
        ?>
        <pre><?php print_r($arMask)?></pre>
    <?
        $params[]=$param;
    }

    foreach($params as $j=>$arVal){
        foreach($arVal as $key=>$val){
        if((int)$val['PARAM']){                         //���� �������� ������������� - ������ ��� ID
            $params[$j][$key]['ID']=(int)$val['PARAM'];
        }else{                                          //����� ��� ����� ���� VALUE, CODE ��� ����.�������� FULLPATH ��� *

            if(substr_count($val['PARAM'],'_VALUE_')){//���� �������� �������� ������ �������� �������� �������� - VALUE
                $arTmp=explode('_VALUE_',$val['PARAM']);
                if((int)$arTmp[0]){//���� �������� ������������� - ������ ��� ID
                    $params[$j][$key]['ID']=(int)$arTmp[0];
                }
                else{
                    $params[$j][$key]['CODE']=$arTmp[0];
                }
                $params[$j][$key]['VALUE']=$arTmp[1];
            }
            elseif(substr_count($val['PARAM'],'FULLPATH')){//��������� �������� ������ ����
                $params[$j][$key]['FULLPATH']='Y';
            }
            elseif(substr_count($val['PARAM'],'*')){//���� �������� �������� �� �����, �.�. ������� ���

            }
            else{
                $params[$j][$key]['CODE']=$val['PARAM'];
            }
        }
    }}
    ?>
    <pre><?php print_r($params)?></pre>
<?
}
?>