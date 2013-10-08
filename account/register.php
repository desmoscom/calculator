<?php
require 'core.php';
$name=mysql_escape_string($_POST['name']);
$email=mysql_escape_string($_POST['email']);
$pass=mysql_escape_string($_POST['password']);

function checkemail($str)
{
$l=strlen($str);
if(($l<101) && ($l>5))
{
$str=preg_replace('/([a-zA-Z0-9]+)/','',$str);
$str=str_replace('@','',$str);
$str=str_replace('-','',$str);
$str=str_replace('.','',$str);
if($str==='') { return true; } else { return false; }
}
else
{
return false;
}
}

connect();
$test=mysqli_fetch_row(query('SELECT `user` FROM `main` WHERE `email` = "'.$email.'"'));
if (count($test)>0)
{
header('HTTP/1.1 403 Forbidden');
echo '{"errors": [{"field": "duplicate_email", "message": "Sorry, someone has already registered with this email address."}], "success": false}';
}
else
{
if (strlen($name)<4 || strlen($name)>32)
{
header('HTTP/1.1 403 Forbidden');
echo '{"errors": [{"field": "duplicate_email", "message": "Login length must be from 4 to 32 symbols."}], "success": false}';
}
else
{
if (strlen($pass)<6 || strlen($pass)>32)
{
header('HTTP/1.1 403 Forbidden');
echo '{"errors": [{"field": "duplicate_email", "message": "Password length must be from 6 to 32 symbols."}], "success": false}';
}
else
{
if(checkemail($email))
{
query('INSERT INTO `main` VALUES ("'.$name.'","'.$email.'","'.$pass.'",""'.')');
setcookie('email',$email,time()+3600*24*30,'/');
setcookie('hash',md5($email.$pass),time()+3600*24*30,'/');
echo 'null';

$message='You have been registered at site site.com. Your password is '.$pass.'.';
$headers='Content-type: text/html; charset=UTF-8
From: Test.com <robot@test.com>
';
mail($email,'Test Registration',$message,$headers);
}
else
{
header('HTTP/1.1 403 Forbidden');
echo '{"errors": [{"field": "duplicate_email", "message": "Incorrect email address."}], "success": false}';
}
}
}
}
disconnect();
?>