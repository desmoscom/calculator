<?php
require 'account/core.php';

if ((isset($_GET['do'])) && ($_GET['do']==='reinstallreshix'))
{
connect();
@query('DROP TABLE main');
$create='CREATE TABLE IF NOT EXISTS `main` (
  `user` tinytext NOT NULL,
  `email` varchar(250) NOT NULL,
  `pass` tinytext NOT NULL,
  `data` longtext NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
query($create);
disconnect();
}
?>