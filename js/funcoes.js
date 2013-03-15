var map;
var blinclmap=false; //blinclmap = bloqueia inclusão marcador no mapa
var marcador=null, localizacao, lastmarcador; //marcador, localizacao
var status_addpoint=0; //status do botão addpoint [0-não clicado, 1-clicado, 2-OK]
var lista_obj = new Array();
var indiceUso;
function inicializarMapa(){

	var mapOptions = {
	  zoom: 8,
	  center: new google.maps.LatLng(-34.397, 150.644),
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById('mapa_geral'), mapOptions);
	google.maps.event.addListener(map, 'click', function(event){
		if(blinclmap){
			localizacao = event.latLng;
			adicionaMarcador(event.latLng, "", "");
			blinclmap = false;
		}
	});
	
function criaCoordenada(coordenada){
	obj = coordenada.split(',');
	var opcoes = new google.maps.LatLng(obj[0], obj[1]);
	return opcoes;
}

function adicionaMarcador(posicao, titulo, descricao){
	conteudo_string = "<div id='content' style='color: black;'><b>"+titulo+"</b><br />"+descricao+"</div>";
	
	var janela_info = new google.maps.InfoWindow({
		content: conteudo_string
	});
	
	marcador = new google.maps.Marker({
		position: posicao,
		map: map,
		title: titulo,
		draggable:true,
		animation: google.maps.Animation.DROP
	});
	marcador.setVisible(true);
	if(titulo!="" && descricao!="") {
		google.maps.event.addListener(marcador, 'click', function(){
		  janela_info.open(map,marcador);
		});
	}
	map.setCenter(marcador.getPosition());
}
function liberaInclusao(){
	blinclmap = true;
}
function bloqueiaInclusao(){
	blinclmap = false;
}

function preparaInclusao(){ //exibe campo de titulo e descrição para o ponto...
	$('#addmapa').fadeIn();
	$('#titulo_point').val('');
	$('#comentario_point').val('');
	$('#titulo_point').focus();
}

function removeInclusao(){
	$('#addmapa').fadeOut();
	$('#addpoint').val('Adicionar ponto');
}

function gravaPonto(coord, titulo, descricao){
	$.post('ajax/insPontos.php', {'coord':coord.toString(), 'titulo':titulo, 'descricao':descricao}, function(dados){
		alert(dados);
	});
	atualizaPontosUsuario();
}

function normalPontosBanco(){
	$('.pontos_banco').css('color', 'gray');
	$('.pontos_banco').css('background-color', 'white');
}

function atualizaPontosUsuario(){
	$.post('ajax/atualizaPontosUsuario.php', {hora:'786'}, function(dados){
		$('#infosweb').html('Meus pontos: <br />');
		lista_obj.splice(0, lista_obj.length); //Limpar o vetor que guarda
		r = JSON.parse(dados);
		if(r.res!="erro"){
			for(i=0; i<r.pontos.length; i++){
				if(r.pontos[i].titulo){
					var conteudo =  "<div id='"+i+"' class='pontos_banco'>"
					conteudo+= i+1+"-<b>"+r.pontos[i].titulo+'</b><br />';
					conteudo+='<div id="e'+i+'" style="color: #8B1A1A;">';
					conteudo+='</div>';		
					lista_obj.push({"coord":r.pontos[i].coordenada, "titulo":unescape(r.pontos[i].titulo), "descricao":unescape(r.pontos[i].descricao), "uk":r.pontos[i].uk, "fas":r.pontos[i].as, "serad":r.pontos[i].serad, "tk":r.pontos[i].tk});
					$('#infosweb').append(conteudo);
				}
			}
		}else{
			$('#infosweb').html("<div class='pontos_branco'>Nenhum ponto adicionado</div>");
		}
			$('.pontos_banco').click(function(){
				mudarMenuUpdateFuncoes(true);
				var lista = $(this).attr('id');
				indiceUso = lista;
				destroiMarcador();
				var contem = "<div>"+(parseInt(lista)+1)+"-<b>"+lista_obj[lista].titulo+"</b></div><div>"+lista_obj[lista].descricao+"</div>";
				$(this).html(contem);
				adicionaMarcador(criaCoordenada(lista_obj[lista].coord), lista_obj[lista].titulo, lista_obj[lista].descricao);
				removeInclusao();
			});
			
			$('.pontos_banco').hover(function(){
				normalPontosBanco();
				$(this).css('background-color', '#7C0000');
				$(this).css('color', 'white');
			});
			
			$('#infosweb').hover(function(){
				normalPontosBanco();
			});
		
	});
	$('#infosweb').fadeIn();
	var tam = window.innerHeight;
	//$('#infosweb').css('height', (tam-100)+"px");
	//$('#infosweb').css('margin-top', (10)+"px");
}

$('#addpoint').click(function(){
	mudarMenuUpdateFuncoes(false);
	switch(status_addpoint){
		case 0:
			destroiMarcador();
			liberaInclusao();
			preparaInclusao();
			status_addpoint=1;
			$(this).val('OK');
			destroiLocalizacao();
			atualizaPontosUsuario();
		break;
		case 1:
			if(marcador!=null && localizacao!=null){
				if($('#titulo_point').val()){
					marcador.title=$('#titulo_point').val();
					gravaPonto(localizacao, $('#titulo_point').val(), $('#comentario_point').val());
					status_addpoint=0;
					normalizaMarcador($('#titulo_point').val(), $('#comentario_point').val());
					$(this).val('Adicionar ponto');
					removeInclusao();
					atualizaPontosUsuario();
				}else{
					alert("Defina um título");
					$('#titulo_point').focus();
				}
			}else alert("Você deve marcar um ponto!");
		break;
	}
	atualizaPontosUsuario();
});

$('#desfpoint').click(function(){
	if(marcador) marcador.setMap(null);
	$('#addmapa').hide();
	$('#dvdinamico').hide();
	$('#dvfuncoes').hide();
});

$('#dispoint').click(function(){
	var fas = lista_obj[indiceUso].fas;
	var serad = lista_obj[indiceUso].serad;
	$('#dvdinamico').html("<div class='sucesso_preto' style='margin-top: 10px; width: 95%'><center><b>Disponibilizado com sucesso!</b></center>Disponível AS: "+fas+"<br />Serad: "+serad+"</div>");
	$('#dvdinamico').animate({
		opacity: 1,
		left: '+=50',
		height: 'toggle'
	  }, 1800, function() {
	  });
});

$('#rmpoint').click(function(){
	if(confirm("Deseja realmente excluir este ponto?")){
		$.post('ajax/excluirPontos.php', {coord:lista_obj[indiceUso].coord, uk: lista_obj[indiceUso].uk, serad:lista_obj[indiceUso].serad, tk:lista_obj[indiceUso].tk}, function(dados){
			destroiMarcador();
			atualizaPontosUsuario();
			mudarMenuUpdateFuncoes(false);
			alert(dados);
		});
	}
});

function destroiMarcador(){
	if(marcador) marcador.setMap(null);
}



function normalizaMarcador(titulo, descricao){
	conteudo_string = "<div id='content' style='color: black;'><b>"+titulo+"</b><br />"+descricao+"</div>";
	
	var janela_info = new google.maps.InfoWindow({
		content: conteudo_string
	});
	
	google.maps.event.addListener(marcador, 'click', function(){
	  janela_info.open(map,marcador);
	});
}

function destroiLocalizacao(){
	localizacao = null;
}

function mudarMenuUpdateFuncoes(bool){
	if(bool) $('#dvfuncoes').fadeIn(); else $('#dvfuncoes').fadeOut();
	$('#dvdinamico').hide();
}

atualizaPontosUsuario();

}


