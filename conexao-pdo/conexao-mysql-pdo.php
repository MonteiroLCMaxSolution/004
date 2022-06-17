<?php

		/*$host = "lealdutra.com.br";
		$dbName = "lealdutr_lealdutra";
		$userName = "lealdutr_leal";
		$password = "Leal@dutra2019";
		$charset = 'utf8';*/
		
		$host = "lcmaxsolution.com.br";
		$dbName = "ftplcmax_3e_tst";
		$userName = "ftplcmax_lcmax";
		$password = "Lcmax@2019!";
		$charset = 'utf8';
		

try{
$pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=$charset", $userName, $password);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

}catch ( PDOException $e ){
    echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
}


function anti_injection($sql){
	// remove palavras que contenham sintaxe sql
	$sql = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/i","",$sql);
	$sql = trim($sql);//limpa espaços vazio
	$sql = strip_tags($sql);//tira tags html e php
	$sql = addslashes($sql);//Adiciona barras invertidas a uma string
	return $sql;
	}


?>		
		