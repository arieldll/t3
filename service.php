<?php 
	@ob_start();
	include 'app/app.php';
	if(isset($_REQUEST["as"]) && isset($_REQUEST["serad"])){
		$r = q("SELECT * FROM coordenadas WHERE fas='$_GET[as]' AND serad='$_GET[serad]'");
		if(n($r)){
			$r = p($r);
			$r["coordenada"] = str_replace(array('(', ')'), '', $r["coordenada"]);
			$coordenada = explode(',', $r["coordenada"]);
			$lat = $coordenada[0];
			$lng = $coordenada[1];
			$datahora = explode(' ', $r["data_hora"]);
			$data = $datahora[0];
			$hora = $datahora[1];
			$dados_ponto = array(
					"status"=>"OK",
					"nome_ponto" => $r["titulo"],
					"ponto_descricao"=> $r["descricao"],
					"lat" => $lat,
					"lng" => $lng,
					"data" => $data,
					"hora" => $hora
				);
			if($_REQUEST['imei']) q("INSERT INTO visualizacao_coordenadas(id_coordenada, IMEI, data_hora) VALUES('$r[id]', '$_REQUEST[imei]', NOW())");
		}else{
			$dados_ponto = array("status" => "erro");
		}
	}else $dados_ponto = array("status"=>"erro");
	echo json_encode($dados_ponto);
?>
