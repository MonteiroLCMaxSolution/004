<?php
require_once("../../config.php");

session_start();

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Leal Dutra Distribuidora LTDA - <?php echo $_GET['name'];?></title>
<meta name="keywords" content="Distribuidor de Materiais para Construção" />
<meta name="description" content="Divinolândia - Caconde - São Sebastião da Grama">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $http;?>/assets/images/icon.png">
<link rel="stylesheet" href="<?php echo $http;?>/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo $http;?>/assets/css/style.min.css">
</head>
<body>
<?php
	include '../../header.php';
?>
<main class="main">
<?php

	include '../../controller/fornecedores/fornecedores-form.php';
?>
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
<script src="<?php echo $http;?>/assets/js/mascara.js"></script>
<script src="<?php echo $http;?>/assets/js/buscaCEP.js"></script>
<script src="<?php echo $http;?>/assets/js/CNPJ_CPF.js"></script>
<script src="<?php echo $http;?>/assets/js/plugins.min.js"></script> 
<script src="<?php echo $http;?>/assets/js/main.min.js"></script>
<script src="<?php echo $http;?>/assets/js/ajax.js"></script>
</body>
</html>