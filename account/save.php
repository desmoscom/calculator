<?php
require 'core.php';

function timetojs()
{
return date('Y-m-d',time()-3600*4).'T'.date('H:i:s',time()-3600*4).'.500Z';
//return '2013-08-24T07:48:54.459Z';
}
function getname($str)
{
$a=explode('"title":',$str);
$b=$a[1];
$c=explode('"',$b);
return $c[1];
}

$img=$_POST['thumb_data'];
$f=rawurldecode($_POST['calc_state']);
$ghash=$_POST['graph_hash'];
$title=$_POST['title'];
if (isset($_COOKIE['email']))
{
$email=mysql_escape_string($_COOKIE['email']);
connect();
$a=mysqli_fetch_row(query('SELECT `pass` FROM `main` WHERE `email` = "'.$email.'"'));
if (isset($a[0]))
  {
  if (md5($email.$a[0])===$_COOKIE['hash'])
    {
	$graph=Array();
	$graph[0]=$ghash;
	$graph[1]='{"thumbUrl": "'.$img.'", "hash": "'.$ghash.'", "title": "'.$title.'", "created": "'.timetojs().'", "access": "link", "state": '.$f.'}';
	$graph[1]=str_replace(chr(1),'&#1;',$graph[1]);
	$graph[1]=str_replace(chr(2),'&#2;',$graph[1]);
	//$graph[2]=$title;
	$str=mysqli_fetch_row(query('SELECT `data` FROM `main` WHERE `email` = "'.$email.'"'));
	$str=base64_decode($str[0]);
	
	if ($str==='') { /*$data=Array();*/ } else { $data=explode(chr(1),$str); }
	$data[]=implode(chr(2),$graph);
	for($i=0;$i<count($data);$i++)
	  {
	  for($j=0;$j<count($data);$j++)
	    {
	    $test1=getname($data[$i]);
	    $test2=getname($data[$j]);
		if (($test1===$test2) && ($i!=$j)) unset($data[$i]);
	    }
	  }
	query('UPDATE `main` SET `data` = "'.base64_encode(implode(chr(1),$data)).'" WHERE `email` = "'.$email.'"');
	
	echo $graph[1];

    }
  else
    {
	header('HTTP/1.1 403 Unauthorized');
	echo 'null';
	}
  }
else
  {
  header('HTTP/1.1 403 Unauthorized');
  echo 'null';
  }

disconnect();
}
else 
{
header('HTTP/1.1 403 Unauthorized');
echo 'null';
}

?>