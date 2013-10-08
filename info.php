<?php
error_reporting(0);
require 'account/core.php';
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
	
	$data=mysqli_fetch_row(query('SELECT `data` FROM `main` WHERE `email` = "'.$email.'"'));
    $data=$data[0];
	$size=strlen($data);
	$size=round(($size/1024)*10)/10;
    //echo '{"name":"'.$name.'","email":"'.$email.'"}';
	echo 'Ваше имя: '.$name.'<br/>';
	echo 'Ваш e-mail: '.$email.'<br/>';
	echo 'Вы занимаете: '.$size.' КБ.<br/>';
    }
  else
    {
	echo 'Вы не авторизованы';
	}
  }
else
  {
  echo 'Вы не авторизованы';
  }

disconnect();
}
else 
{
echo 'Вы не авторизованы';
}
?>