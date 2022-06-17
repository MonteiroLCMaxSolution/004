<?php
/* Criado por Leônidas Monteiro - 23/02/2019 */ 
session_start();
echo $favorito = $_GET['favoritos'];
include_once ('../../config.php');
include_once ('../../conexao-pdo/conexao-mysql-pdo.php');
//session_start();
date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());
$idCliente = $_SESSION['id_do_cliente'];
$codEmpresa = $_SESSION['COD_EMPRESA_cliente'];
$SQL_consult = "SELECT * FROM favoritos WHERE cod_produto = :codProduto AND cod_empresa = :codEmpresa AND id_cliente = :idCliente";
$SQL_consult = $pdo->prepare($SQL_consult);
$SQL_consult->bindValue('codProduto',$favorito);
$SQL_consult->bindValue('codEmpresa',$codEmpresa);
$SQL_consult->bindValue('idCliente',$idCliente);
$SQL_consult->execute();
if ($SQL_consult->rowCount() > 0){
	$acao = "NSERT INTO favoritos(cod_produto,cod_empresa,id_cliente,data_cadastro)VALUES(".$favorito.",".$codEmpresa.",".$idCliente.",".$dataLocal;
	$IP = $_SERVER['REMOTE_ADDR'];
	$descricao = "Cliente: ".$_SESSION['nome_do_cliente'].", tentou cadastrar o código: ".$favorito.", mas já consta em nossa BD!";
	$usuario = $idCliente;
	$origem = $_SERVER['HTTP_REFERER'];
	$SQL_insert_log = "INSERT INTO logs(cod_empresa,datahora,acao,IP,descricao,usuario,origem)VALUES(:codempresa,:datahora,:acao,:IP,:descricao,:usuario,:origem)";
	$SQL_insert_log = $pdo->prepare($SQL_insert_log);
	$SQL_insert_log->bindValue('codempresa',$codEmpresa);
	$SQL_insert_log->bindValue('datahora',$dataLocal);
	$SQL_insert_log->bindValue('acao',$acao);
	$SQL_insert_log->bindValue('IP',$IP);
	$SQL_insert_log->bindValue('descricao',$descricao);
	$SQL_insert_log->bindValue('usuario',$usuario);
	$SQL_insert_log->bindValue('origem',$origem);
	$SQL_insert_log->execute();	
}else{
	$SQL_insert_favorito = "INSERT INTO favoritos(cod_produto,cod_empresa,id_cliente,data_cadastro)VALUES(:codProduto,:codEmpresa,:idCliente,:dataCadastro)";
	$SQL_insert_favorito = $pdo->prepare($SQL_insert_favorito);
	$SQL_insert_favorito->bindValue('codProduto',$favorito);
	$SQL_insert_favorito->bindValue('codEmpresa',$codEmpresa);
	$SQL_insert_favorito->bindValue('idCliente',$idCliente);
	$SQL_insert_favorito->bindValue('dataCadastro',$dataLocal);
	$SQL_insert_favorito->execute();
	
	$acao = "NSERT INTO favoritos(cod_produto,cod_empresa,id_cliente,data_cadastro)VALUES(".$favorito.",".$codEmpresa.",".$idCliente.",".$dataLocal;
	$IP = $_SERVER['REMOTE_ADDR'];
	$descricao = "Cliente: ".$_SESSION['nome_do_cliente'].", cadastrou o código: ".$favorito.", como seu favorito!";
	$usuario = $idCliente;
	$origem = $_SERVER['HTTP_REFERER'];
	$SQL_insert_log = "INSERT INTO logs(cod_empresa,datahora,acao,IP,descricao,usuario,origem)VALUES(:codempresa,:datahora,:acao,:IP,:descricao,:usuario,:origem)";
	$SQL_insert_log = $pdo->prepare($SQL_insert_log);
	$SQL_insert_log->bindValue('codempresa',$codEmpresa);
	$SQL_insert_log->bindValue('datahora',$dataLocal);
	$SQL_insert_log->bindValue('acao',$acao);
	$SQL_insert_log->bindValue('IP',$IP);
	$SQL_insert_log->bindValue('descricao',$descricao);
	$SQL_insert_log->bindValue('usuario',$usuario);
	$SQL_insert_log->bindValue('origem',$origem);
	$SQL_insert_log->execute();	
}	

?>
