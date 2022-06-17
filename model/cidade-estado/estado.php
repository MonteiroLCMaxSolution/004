<?php
include '../../../conexao-pdo/conexao-mysql-pdo.php';
session_start();

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());

/* ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);   */

$lista_estado = "SELECT * FROM estado;";
$lista_estado = $pdo->prepare($lista_estado);
$lista_estado->execute();

/*if($lista_estado->rowCount() > 0){
		$row = $lista_estado->fetch();
		echo $row->id;
	}else{
		echo 'não achou';
	}
*/
?>