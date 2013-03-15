<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Adriel Service</title>
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyCFygwau9wdRMsnm3zqIvxfVVN5MKdVofg" type="text/javascript"></script>
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/funcoes.js" type="text/javascript"></script>
    <script>
      google.maps.event.addDomListener(window, 'load', inicializarMapa); //chamada para inicializar o maps
    </script>
  </head>
  <body>
	<div id="dvsup" class="superior">
		<img src="img/logo.png" />
	</div>
	<div style="height: 90%;">
		<div class="f1">
			<div id="mapa_geral"></div>
		</div>
		<div class="f2">
			<div style="width: 95%; margin-left: auto; margin-right: auto;">
				<div id="controles">
					<input type="button" value="Adicionar ponto" class="botao_padrao" id="addpoint" />
					<input type="button" value="Desfazer" class="botao_padrao" id="desfpoint"/>
				</div>
				<div id="addmapa" style="display: none;">
					Título: <br />
					<input type="text" id="titulo_point" class="campo_padrao" />
					Comentário: <br />
					<input type="text" id="comentario_point" class="campo_padrao"/>
				</div>
			</div>
		</div>
	</div>
    
  </body>
</html>

	
