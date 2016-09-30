<?php
if(!defined('INCLUDE_CHECK')) die('У вас нет прав запускать файл на выполнение');

/*function checkEmail($str)
{
    return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
}*/

function send_mail($to,$subject,$body,$from)
{
    $charset = 'utf-8';
    //mb_language("ru");
    $headers  = "MIME-Version: 1.0 \n";
    $headers .= "Content-Type: text/html; charset=".$charset." \n";
    $headers .= "From: ".$from." \n";
    //$headers .= "Reply-To: ".$from." \n";

    $body = mb_convert_encoding($body, $charset,"auto");
    $subject = mb_convert_encoding($subject, $charset, "auto");
    $subject = '=?'.$charset.'?B?'.base64_encode($subject).'?=';

    $sendit=mail($to,$subject,$body,$headers);
    return $sendit;
}
?>