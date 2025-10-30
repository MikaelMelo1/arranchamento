<?php
require_once "./conf.php";
mysql_connect($host,$user,$pass) or die ("Impossivel conectar ao servidor MySQL"); 	
mysql_select_db($db) or die ("Impossivel abrir o banco de dados");
?>
