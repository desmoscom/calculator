<?php
error_reporting(0);
require 'core.php';
if (isset($_COOKIE['email']))
{
$email=mysql_escape_string($_COOKIE['email']);
connect();
$a=mysqli_fetch_row(query('SELECT `pass` FROM `main` WHERE `email` = "'.$email.'"'));
if (isset($a[0]))
  {
  if (md5($email.$a[0])===$_COOKIE['hash'])
    {
    $name=mysqli_fetch_row(query('SELECT `user` FROM `main` WHERE `email` = "'.$email.'"'));
    $name=$name[0];
    echo '{"name":"'.$name.'","email":"'.$email.'"}';
    }
  else
    {
	echo 'null';
	}
  }
else
  {
  echo 'null';
  }

disconnect();
}
else 
{
echo 'null';
}
?>