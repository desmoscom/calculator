<?php
require 'core.php';
//print_r($_POST);
$inp=$_POST['hash'];
if (isset($_COOKIE['email']))
{
$email=mysql_escape_string($_COOKIE['email']);
connect();
$a=mysqli_fetch_row(query('SELECT `pass` FROM `main` WHERE `email` = "'.$email.'"'));
if (isset($a[0]))
  {
  if (md5($email.$a[0])===$_COOKIE['hash'])
    {
    //$name=mysqli_fetch_row(query('SELECT `user` FROM `main` WHERE `email` = "'.$email.'"'));
    //$name=$name[0];
    //echo '{"isEdmodoUser":false,"isDriveUser":false,"name":"'.$name.'","email":"'.$email.'"}';
	$str=mysqli_fetch_row(query('SELECT `data` FROM `main` WHERE `email` = "'.$email.'"'));
	$str=base64_decode($str[0]);
	$res='';
	if($str==='')
	  {  
      echo '{"myGraphs":[]}';
	  }
	else
	  {
	  $data=explode(chr(1),$str);
	  //$res.='{"myGraphs":[';
	  //file_put_contents('t.txt',count($data));
	  for ($i=0;$i<count($data);$i++)
	    {
		$a=explode(chr(2),$data[$i]);
		if ($a[0]!==$inp) { $res[]=$data[$i]; }
		/*if ($a[1]!='') {$res.=$a[1];
		if($i!=count($data)-1) { $res.=','; } }*/
		}
	  //$res.=']}';
	  query('UPDATE `main` SET `data` = "'.base64_encode(implode(chr(1),$res)).'" WHERE `email` = "'.$email.'"');
	  }
	//echo '{"thumbUrl": "'.$img.'", "hash": "'.$ghash.'", "title": "'.$title.'", "created": "2013-08-24T07:48:54.459Z", "access": "link", "state": '.$f.', "pushed_to_drive": false}';
    //echo $res;
	echo 'null';
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