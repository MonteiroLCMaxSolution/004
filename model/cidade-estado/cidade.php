<?php
include '../../conexao-pdo/conexao-mysql-pdo.php';
session_start();

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());

/* ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);  */
 
$idestado = $_GET['uf'];
$lista_cidade = "SELECT * FROM cidade a WHERE a.estado = :idestado;";
$lista_cidade = $pdo->prepare($lista_cidade);
$lista_cidade->bindValue('idestado',$idestado);
$lista_cidade->execute();



?>