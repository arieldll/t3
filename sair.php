<?php 
	include 'app/app.php';
	if(md5($_SESSION["ulo"].date('YmdH'))==$_GET["t"]) unset($_SESSION["ulo"]);
	header("Location: index.php");
?>
