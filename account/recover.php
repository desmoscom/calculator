<?php
require 'core.php';
//$name=$_POST['name'];
$email=mysql_escape_string($_POST['email']);
//$pass=$_POST['password'];

connect();
$test=mysqli_fetch_row(query('SELECT `pass` FROM `main` WHERE `email` = "'.$email.'"'));
if (count($test)==0)
{
header('HTTP/1.1 403 Forbidden');
echo '{"errors": [{"field": "user_not_found", "message": "Sorry, we could not find any users registered with this email address."}], "success": false}';
}
else
{
$pass=$test[0];
echo '{"message": "Please check your email for a password recovery link.", "success": true}';

$message='Your password is '.$pass.'.';
$headers='Content-type: text/html; charset=UTF-8
From: Test <robot@test.com>
';
mail($email,'Test Password Recovery',$message,$headers);
}
disconnect();
?>