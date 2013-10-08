<?php
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'reshix');

$dbconn=null;
function connect()
{
global $dbconn;
$dbconn=mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
}

function query($str)
{
global $dbconn;
return mysqli_query($dbconn,$str);
}

function disconnect()
{
global $dbconn;
mysqli_close($dbconn);
}
?>