<?php 
	include 'app/app.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo titulo_site; ?></title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <meta charset="utf-8">
    <script src='js/jquery.js' type='text/javascript'></script>
	<script src='js/funcoes.js' type='text/javascript'></script>
    <?php 
		if(isset($_GET["p"]) && $_GET["p"]=="mapa"){
			echo "<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyCFygwau9wdRMsnm3zqIvxfVVN5MKdVofg' type='text/javascript'></script>
				  <script>
				    google.maps.event.addDomListener(window, 'load', inicializarMapa); //chamada para inicializar o maps
				  </script>";
		}
    ?>
  </head>
  <body>
	<div id="dvsup" class="superior">
		<div style="width: 25%px; float: left">
			<img src="img/logo.png" />
		</div>
		<div style="width: 60%; float: left; color: black; padding-top: 10px; padding-left: 10px;">
			<a href="?p=home" class='sup'>Início</a> | 
			<a href="?p=cadastro" class='sup'>Cadastro</a> 
			<?php 
				if(login()){
					echo "| <a href='?p=mapa' class='sup'>Mapa</a> ";
					echo "| <a href='?p=sair&t=".md5($_SESSION[ulo].date('YmdH'))."' class='sup'>Sair</a>";
				}
			?>
		</div>
	</div>
	
		<?php if(!isset($_GET["p"]) || $_GET["p"]!='mapa') echo "	<div style='padding-top: 10%;'>	<div class='dv_dados'>";
				if(isset($_SESSION["erro"])){
					echo "<div style='border-color: #b52727; border-style: solid; border-width: 2px; background-color: #c45555; font-size: 13px; text-align:center; color: white; text-weight: bold; height: 25px;'><div style='margin-top: 5px;'>Erro: $_SESSION[erro]</div></div>";
					unset($_SESSION["erro"]);
				}
				if(isset($_SESSION["sucesso"])){
					echo "<div style='border-color: #13a200; border-style: solid; border-width: 2px; background-color: #90d786; font-size: 13px; text-align:center; color: white; text-weight: bold; height: 25px;'><div style='margin-top: 5px;'>$_SESSION[sucesso]</div></div>";
					unset($_SESSION["sucesso"]);
				}				
				if(isset($_GET["p"]) && $_GET["p"]) $url = $_GET["p"]; else $url= 'home';
				$url = str_replace(array('.', '..', '/'), '', $url);
				if(file_exists("pag/$url.php")) include "pag/$url.php"; else echo "Página não localizada";
			?>
		<?php if(isset($_GET["p"]) && $_GET["p"]!='mapa') echo "		</div>"; ?>
	</div>
  </body>
</html>

	
