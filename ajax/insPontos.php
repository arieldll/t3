<?php 
	include '../app/app.php';
	if($_POST["coord"]){
		if(strlen($_POST["titulo"])){
			if(login()){
				$as = $_SESSION['ulo'].'-'.date('his');
				$serad = date('Ydm');
				//fas = field "as"
				q("INSERT INTO coordenadas(id_usuario, coordenada, titulo, descricao, data_hora, fas, serad) VALUES('$_SESSION[ulo]', '$_POST[coord]', '$_POST[titulo]', '$_POST[descricao]', NOW(), '$as', '$serad')");
				echo "Ponto adicionado com sucesso!";
			}else echo "Acesso negado!";
		}else echo "Defina um título!";
	}else echo "Selecione uma coordenada";
?>
