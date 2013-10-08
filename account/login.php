<?php
require 'core.php';

$email=mysql_escape_string($_POST['email']);
$pass=$_POST['password'];

connect();
$a=mysqli_fetch_row(query('SELECT `pass` FROM `main` WHERE `email` = "'.$email.'"'));
if (isset($a[0]))
  {
  if ($pass===$a[0])
    {
    //$name=mysqli_fetch_num(query('SELECT `user` FROM `main` WHERE `email` = '.$email));
    //$name=$name[0];
    setcookie('email',$email,time()+3600*24*30,'/');
    setcookie('hash',md5($email.$a[0]),time()+3600*24*30,'/');
	echo 'null';
    }
  else
    {
	header('HTTP/1.1 401 Unauthorized');
	echo '{"errors": [{"field":"not found","message":"Sorry, your login and password do not match"}],"success":false}';
	}
  }
else
  {
  header('HTTP/1.1 401 Unauthorized');
  echo '{"errors":[{"field":"not found","message":"Sorry, your login and password do not match"}],"success":false}';
  }
?>