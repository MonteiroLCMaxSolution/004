<?php
include '../../config.php';

//session_start();
require_once '../../conexao-pdo/conexao-mysql-pdo.php';
date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());
$data = date('Y-m-d', time());

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

		$cod_produto_n = '138150';
		$sql_produto_img = "select * from produtos where nome_produto like :nome_produto and cod_produto not in (:cod_produto)";
		$sql_produto_img = $pdo->prepare($sql_produto_img);
		$sql_produto_img->bindValue('nome_produto', '%REGISTRO ESF. SOLDAVEL VIQUA%');
		$sql_produto_img->bindValue('cod_produto', $cod_produto_n);
		$sql_produto_img->execute();
		
		while($row_produto_img = $sql_produto_img->fetch()){
		$cod_produto = $row_produto_img->cod_produto;
		$imagem_1 = "REGISTRO ESF. SOLDAVEL VIQUA 50MM LL-138150-1.jpg";
		//$imagem_2 = "REGISTRO ESF. ROSCA INTERNA VIQUA1.1x2-103023-1.jpg";
		//$imagem_3 = "ABRAC NYLON BRASF PTA 2,5X100 100P-8852-3.jpg";
		//$imagem_4 = "TUBO AMANCO ESGOTO-10469-1.jpg";
		$imagem_perfil = "NAO";
		
		/*$delete = "DELETE FROM imagens where cod_produto = :cod_produto";
		$delete = $pdo->prepare($delete);
		$delete->bindValue('cod_produto',$cod_produto);
		$delete->execute(); /**/
		
   	    $insert_img_1 = "INSERT INTO imagens (cod_produto,imagem,imagem_perfil)values(:cod_produto,:imagem,:imagem_perfil)";
		$insert_img_1 = $pdo->prepare($insert_img_1);
		$insert_img_1->bindValue('cod_produto',$cod_produto);
		$insert_img_1->bindValue('imagem',$imagem_1);
		$insert_img_1->bindValue('imagem_perfil',$imagem_perfil);
		$insert_img_1->execute();
		
		/*$insert_img_2 = "INSERT INTO imagens (cod_produto,imagem,imagem_perfil)values(:cod_produto,:imagem,:imagem_perfil)";
		$insert_img_2 = $pdo->prepare($insert_img_2);
		$insert_img_2->bindValue('cod_produto',$cod_produto);
		$insert_img_2->bindValue('imagem',$imagem_2);
		$insert_img_2->bindValue('imagem_perfil',$imagem_perfil);
		$insert_img_2->execute();
		
		/*$insert_img_3 = "INSERT INTO imagens (cod_produto,imagem,imagem_perfil)values(:cod_produto,:imagem,:imagem_perfil)";
		$insert_img_3 = $pdo->prepare($insert_img_3);
		$insert_img_3->bindValue('cod_produto',$cod_produto);
		$insert_img_3->bindValue('imagem',$imagem_3);
		$insert_img_3->bindValue('imagem_perfil',$imagem_perfil);
		$insert_img_3->execute();	 
		
		/*$insert_img_4 = "INSERT INTO imagens (cod_produto,imagem,imagem_perfil)values(:cod_produto,:imagem,:imagem_perfil)";
		$insert_img_4 = $pdo->prepare($insert_img_4);
		$insert_img_4->bindValue('cod_produto',$cod_produto);
		$insert_img_4->bindValue('imagem',$imagem_4);
		$insert_img_4->bindValue('imagem_perfil',$imagem_perfil);
		$insert_img_4->execute(); /**/	 
		
		echo 'ok';
		
		} 
?>