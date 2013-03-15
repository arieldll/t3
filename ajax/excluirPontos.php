<?php 
	include '../app/app.php';
	$token = md5($_SESSION["ulo"].'-@@'.$_POST["uk"]);
	if($_POST["tk"]==$token){
		q("DELETE FROM coordenadas WHERE id_usuario='$_SESSION[ulo]' AND id ='$_POST[uk]' AND serad='$_POST[serad]'");
		echo "Excluído com sucesso!";
	}
?>
