<?php
session_start();
require_once("../../config.php");
include '../../conexao-pdo/conexao-mysql-pdo.php';



?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Leal Dutra Distribuidora LTDA</title>
<meta name="keywords" content="Distribuidor de Materiais para Construção" />
<meta name="description" content="Divinolândia - Caconde - São Sebastião da Grama">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $http;?>/assets/images/icon.png">
<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../../assets/css/style.min.css">
</head>
<body>
<?php
	include '../../header.php';
?>
<main class="main">
 
 <?php 
 $marca_index = $_GET['marca'];
 $SQL_nome_marca = "SELECT cod_empresa, cod_marca, nome_marca, logo, visualizado from marca 
 where cod_marca = '$marca_index'
 group by cod_marca";	
	$SQL_nome_marca = $pdo->prepare($SQL_nome_marca);
	$SQL_nome_marca->execute();
	
	($row_fornecedores_limite = $SQL_nome_marca->fetch())
 
 ?>
  <div class="featured-products-section carousel-section">
    <div class="container">
      <h2 class="h3 title mb-4 text-center">Produtos -  <?php echo $row_fornecedores_limite->nome_marca; ?></h2>
      
        <?php
			//include '../../controller/categorias/categoria.php';
			include '../../controller/fornecedores/index_produto_paginacao.php';
		?>
      
    </div>
  </div>
  <div class="mb-5"></div>
 <!---------------PRODUTOS EM DESTAQUE ------------->
 <div class="featured-products-section carousel-section" style="background:#FFF;!important">
    <div class="container">
      <h2 class="h3 title mb-4 text-center">Produtos em Destaque</h2>
      <div class="featured-products owl-carousel owl-theme">
        <?php
			include '../../controller/index_produtos.php';
		?>
      </div>
    </div>
  </div>
<!----------------------------------------------------->
<!--------------- INDEX SUPORTE / AJUDA --------------->
 <div class="mb-5"></div>
  <div class="info-section">
    <div class="container">
      <div class="row">
       <?php include '../../controller/index-ajuda.php'; ?>
      </div>
    </div>
  </div>
<!----------------------------------------------------->
  <div class="promo-section" style="background-image: url(../../assets/images/promo-bg.jpg)">
    <div class="container">
      <h3>Começe a comprar agora mesmo!</h3>
      <a href="<?php echo $http; ?>" class="btn btn-dark">Vamos la!</a> </div>
  </div>
  <!-- SLIDER DE MARCAS -->
 <?php include '../../controller/index-marca.php'; ?>
  <!------------------------------->
</main>
<?php include '../../rodape.php'; ?>
</div>
<?php include '../../header-mobile.php' ?>
<script src="<?php echo $http;?>/assets/js/jquery.min.js"></script> 
<script src="<?php echo $http;?>/assets/js/bootstrap.bundle.min.js"></script> 
<script src="<?php echo $http;?>/assets/js/plugins.min.js"></script> 
<script src="<?php echo $http;?>/assets/js/main.min.js"></script>
</body>
</html>