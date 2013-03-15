<?php 
header('Content-Type: text/html; charset=utf-8');
mysql_select_db("t3", mysql_connect("localhost", "root", "lilicali"));
define('titulo_site', "Adriel Service");

if(isset($_GET["p"]) && $_GET["p"]=="sair") header("Location: sair.php?t=$_GET[t]");
@session_start();
define('fkpasswd', 'black_jesus');
if(isset($_GET["p"]) && $_GET["p"]=='exit'){
	header("Location: exit.php?k=$_GET[k]");
}

$_SESSION['data_real_login'] = md5(date('H').$_SESSION['ulo']);

foreach($_POST as $p => $v){
	$v = str_replace('%', '&#37;', $v);
	$v = str_replace('&', 'e', $v);
	$_POST[$p] = htmlentities($v, ENT_QUOTES, 'UTF-8');
	
}

foreach($_GET as $g => $v){
	$v = str_replace('%', '&#37;', $v);
	$v = str_replace('&', 'e', $v);
	$_GET[$g] = htmlentities($v, ENT_QUOTES, 'UTF-8');
}

function gerarErro($error, $page=''){
	$_SESSION["erro"] = $error;
	$_SESSION["website_data"] = $_POST;
	unset($_SESSION["sucesso"]);
	if(!$page) $page='cadastro';
}

function q($q){
	//return mysql_query($q) or die(mysql_error());
	return mysql_query($q);
}

function p($p){
	return mysql_fetch_array($p);
}

function n($n){
	return mysql_num_rows($n);
}

function login(){
	if(isset($_SESSION["ulo"]) && n(q("SELECT 1 FROM usuarios WHERE id=".(int)$_SESSION['ulo']))) return true;
	return false;
}

function valor_campo($nome_campo){
	if(isset($_SESSION["website_data"])) return $_SESSION["website_data"][$nome_campo];
	return "";
}

//Inserir cadastro
if(isset($_POST["clogin"], $_POST["csenha"], $_POST["ccsenha"], $_POST["cemail"], $_POST["cnome"]) && $_POST["clogin"]){
	if(strlen($_POST["clogin"])<5) gerarErro("Login é muito curto!");
	if(strlen($_POST["csenha"])<8) gerarErro("Senha é muito curta!");
	if(strlen($_POST["cnome"])<3) gerarErro("Seu nome é muito curto! Você é um robô? :)");
	if(!filter_var($_POST["cemail"], FILTER_VALIDATE_EMAIL)) gerarErro("O email informado é inválido!");
	if(strcmp($_POST["csenha"], $_POST["ccsenha"])) gerarErro("Suas senhas devem ser iguais!");
	if(n(q("SELECT 1 FROM usuarios WHERE UPPER(login) LIKE UPPER('$_POST[clogin]')"))) gerarErro("O usuário já existe!");
	if(!isset($_SESSION["erro"])){
		q("INSERT INTO usuarios(login, senha, nome, email, dtcadastro) values('$_POST[clogin]', '".md5(fkpasswd.$_POST["csenha"])."', '$_POST[cnome]', '$_POST[cemail]', NOW())");
		unset($_SESSION["website_data"]);
		$_SESSION["sucesso"] = "Cadastro realizado com sucesso!";
		unset($_SESSION["erro"]);
		sleep(1);
	}
}

//Valida login
if(isset($_POST["login"], $_POST["senha"])){
	if(strlen($_POST["login"]) && strlen($_POST["senha"])){
		$q = q("SELECT * FROM usuarios WHERE UPPER(login) LIKE UPPER('$_POST[login]') AND senha='".md5(fkpasswd.$_POST["senha"])."'");
		if(n($q)){
			$duser = p($q);
			unset($_SESSION["erro"]);
			$_SESSION["ulo"] =  $duser["id"];
			sleep(2);
			header("Location: ?p=mapa");
		}else $_SESSION["erro"] = "Usuário ou senha não são válidos! Tente novamente :)";
	}else gerarErro("Preencha os campos obrigatórios!");
}

$paginas_necessitam_autenticacao = array('mapa');
if(isset($paginas_necessitam_autenticacao)){
	foreach($paginas_necessitam_autenticacao as $a){
		if($_GET["p"]==$a) if(!login()) header("Location: index.php");
	}
}

?>
