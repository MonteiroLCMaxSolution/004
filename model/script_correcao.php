<?php
	// Leônidas Monteiro - 15/01/2020	
	ini_set('display_errors',1);
	ini_set('display_startup_erros',1);
	error_reporting(E_ALL);

	require_once '../conexao-pdo/conexao-mysql-pdo.php';
	$SQL_list_clie = "SELECT COD_CLIENTE,PASSWORD FROM cliente WHERE PASSWORD1 IS NULL;";
	$SQL_list_clie = $pdo->prepare($SQL_list_clie);
	$SQL_list_clie->execute();
	while ($row_list_clie = $SQL_list_clie->fetch()){
		//echo password_hash($row_list_clie->PASSWORD, PASSWORD_DEFAULT).'<BR/>';
		$codcliente = $row_list_clie->COD_CLIENTE;
		$password = password_hash($row_list_clie->PASSWORD, PASSWORD_DEFAULT);
		$SQL_edt_pas = "UPDATE cliente SET PASSWORD1 = :password WHERE COD_CLIENTE = :COD_CLIENTE;";
		$SQL_edt_pas = $pdo->prepare($SQL_edt_pas);
		$SQL_edt_pas->bindValue('password',$password);
		$SQL_edt_pas->bindValue('COD_CLIENTE',$codcliente);
		$SQL_edt_pas->execute();
	}
?>