<?php
date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());

/* ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); */

if (isset($_SESSION['COD_EMPRESA_cliente'])){
	 $codEmpresa = $_SESSION['COD_EMPRESA_cliente'];	
}else{
	$codEmpresa = 1;
}

/* definir parametro da tela dados-produto */
	$destaque = 'DESTAQUE';
 	$SQL_status_destaque = "SELECT a.parametro FROM parametros a WHERE a.item = :destaque and a.cod_empresa = :codEmpresa"; 
	$SQL_status_destaque = $pdo->prepare($SQL_status_destaque);
	$SQL_status_destaque->bindValue('destaque',$destaque);
	$SQL_status_destaque->bindValue('codEmpresa',$codEmpresa);
	$SQL_status_destaque->execute();
/* FIM - definir parametro da tela dados-produto */
/* definir parametro da forma de pagamento */
	$PAGAMENTO = 'PAGAMENTO';
 	$SQL_status_PGTO = "SELECT a.parametro FROM parametros a WHERE a.item = :destaque and a.cod_empresa = :codEmpresa"; 
	$SQL_status_PGTO = $pdo->prepare($SQL_status_PGTO);
	$SQL_status_PGTO->bindValue('destaque',$PAGAMENTO);
	$SQL_status_PGTO->bindValue('codEmpresa',$codEmpresa);
	$SQL_status_PGTO->execute();
	if ($SQL_status_PGTO->rowCount() > 0){
		$row_status_PGTO = $SQL_status_PGTO->fetch();
		$_SESSION['status_pagamento'] = $row_status_PGTO->parametro;	
	}
/* FIM - definir parametro da forma de pagamento */

?>