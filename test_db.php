<?//проверка соединения с базой
$host = "localhost";
$user = "u0024962_default";
$password = "F3C!nbRn";
$db = "u0024962_default";
$db_Conn = @mysql_pconnect($host, $user, $password);
mysql_select_db($db);
if (!$db_Conn)
{
 echo "Не соединяется...<br>";
}
else
{
 echo "Соединилось!<br>";
}
?>
