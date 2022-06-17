<?php
if(!isset($_SESSION)){
	session_start();
}
$arquivo = 'conexao-pdo/conexao-mysql-pdo.php';

$parametro = 's';
$tag = '';
while ($parametro != 'n'){
	if (file_exists($tag.$arquivo)) {
		$parametro = 'n';
	} else {
		$tag = '../'.$tag;
	}
}
$arquivo = $tag.$arquivo;

include_once($arquivo);

$config = 'conexao-pdo/config.php';

$parametro = 's';
$tag = '';
while ($parametro != 'n'){
	if (file_exists($tag.$config)) {
		$parametro = 'n';
	} else {
		$tag = '../'.$tag;
	}
}
$config = $tag.$config;

include_once($arquivo);
include_once($config);

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());
$sha1 = $_SESSION['sha_carrinho'];

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); 
/* ATUALIZAR A TABELA PEDIDO_ITEM COM OS IDS DOS SHA1 ENCONTRADOS NA TABELA PRODUTO_CLICK - LEÔNIDAS MONTEIRO - 15/04/2021*/
$SQL = "SELECT DISTINCT a.sha1, a.id_cliente, a.`status` FROM produto_click a WHERE a.id_cliente IS NOT NULL AND a.`status` = 'CARRINHO';";
	$SQL = $pdo->prepare($SQL);
	$SQL->execute();
	while($row = $SQL->fetch()){
			$sha1 = $row->sha1;
			$id_cliente = $row->id_cliente;			
			/* INCLUI O ID DO CLIENTE NA TABELA PEDIDO_ITEM - LEÔNIDAS MONTEIRO - 15/04/2021 */ 
			$SQL_update = "UPDATE pedido_item SET id_cliente = :id_cliente WHERE SHA1 = :SHA1;";
			$SQL_update = $pdo->prepare($SQL_update);
			$SQL_update->bindValue('id_cliente',$id_cliente);
			$SQL_update->bindValue('SHA1',$sha1);
			$SQL_update->execute();
			/* FIM INCLUI O ID DO CLIENTE NA TABELA PEDIDO_ITEM - LEÔNIDAS MONTEIRO - 15/04/2021 */ 
	}
	/* FIM -  ATUALIZAR A TABELA PEDIDO_ITEM COM OS IDS DOS SHA1 ENCONTRADOS NA TABELA PRODUTO_CLICK - LEÔNIDAS MONTEIRO - 15/04/2021*/
	?>