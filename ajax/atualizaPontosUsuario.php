<?php 
	include '../app/app.php';
		if(login()){
			$q = q("SELECT * FROM coordenadas WHERE id_usuario = '$_SESSION[ulo]'");
			$dados="";
			if(n($q)) $dados["res"] = "OK"; else $dados["res"] = "erro";
			while($p = p($q)){
				$dados["pontos"][] = array(
					"coordenada"=>str_replace(array('(', ')'),'', $p["coordenada"]),
					"titulo"=>$p["titulo"],
					"descricao"=>$p["descricao"],
					"uk"=>$p["id"],
					"as"=>$p["fas"],
					"tk"=>md5($_SESSION["ulo"].'-@@'.$p["id"]),
					"serad"=>$p["serad"]
				);
			}
		echo json_encode($dados);
	}else echo "Acesso negado!";
?>
