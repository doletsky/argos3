<?php
$to      = 'dev@eldario.ru, eld@ya.ru, e.dzhavadov@gmail.com';
$subject = 'the subject';
$message = 'test';
$headers = 'From: kondratieva_o@argo-s.net ' . "\r\n" .
    'Reply-To: kondratieva_o@argo-s.net ' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
//$headers = '';
$res = mail($to, $subject, ($message), $headers);
var_dump($res);
?>