<?php
require 'core.php';
//print_r($_POST);

$name=mysql_escape_string($_POST['name']);
$oldpass=(string)mysql_escape_string($_POST['old_pass']);
$newpass=(string)mysql_escape_string($_POST['new_pass']);
$newpass2=(string)mysql_escape_string($_POST['repeat_new_pass']);

if ($newpass==='') {$newpass=$oldpass; $newpass2=$oldpass; }
if ($newpass===$newpass2)
{
if (isset($_COOKIE['email']))
{
$email=mysql_escape_string($_COOKIE['email']);
connect();
$a=mysqli_fetch_row(query('SELECT `pass` FROM `main` WHERE `email` = "'.$email.'"'));
if (isset($a[0]))
  {
  if ((md5($email.$a[0])===$_COOKIE['hash']) && ($oldpass===$a[0]))
    {
	if (strlen($name)<4 || strlen($name)>32)
    {
    header('HTTP/1.1 403 Forbidden');
    echo '{"errors": [{"field": "password", "message": "Login length must be from 4 to 32 symbols."}], "success": false}';
    }
    else
    {
    if (strlen($newpass)<6 || strlen($newpass)>32)
    {
    header('HTTP/1.1 403 Forbidden');
    echo '{"errors": [{"field": "password", "message": "Password length must be from 6 to 32 symbols."}], "success": false}';
    }
    else
    {
    //$name=mysqli_fetch_row(query('SELECT `user` FROM `main` WHERE `email` = "'.$email.'"'));
    //$name=$name[0];
    //echo '{"isEdmodoUser":false,"isDriveUser":false,"name":"'.$name.'","email":"'.$email.'"}';
	
	query('UPDATE `main` SET `user` = "'.$name.'" WHERE `email` = "'.$email.'"');
	query('UPDATE `main` SET `pass` = "'.$newpass.'" WHERE `email` = "'.$email.'"');
	setcookie('hash',md5($email.$newpass),time()+3600*24*30,'/');
	echo '{"name": "'.$name.'", "success": true, "email": "'.$email.'"}';
	}
    }
	}
  else
    {
	header('HTTP/1.1 403 Forbidden');
	echo '{"errors": [{"field": "password", "message": "Incorrect old password, please try again"}], "success": false}';
	}
  }
else
  {
  header('HTTP/1.1 403 Forbidden');
  echo '{"errors": [{"field": "password", "message": "Incorrect old password, please try again"}], "success": false}';
  }

disconnect();
}
else 
{
header('HTTP/1.1 403 Forbidden');
echo '{"errors": [{"field": "password", "message": "Incorrect old password, please try again"}], "success": false}';
}
}
else
{
header('HTTP/1.1 403 Forbidden');
echo '{"errors": [{"field": "repeat_new_pass", "message": "The repeat new password that you entered did not match. Please try again."}], "success": false}';
}
?>