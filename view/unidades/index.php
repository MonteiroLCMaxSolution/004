<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Leal Dutra Distribuidora LTDA - Minha Conta</title>
<meta name="keywords" content="HTML5 Template" />
<meta name="description" content="Materiais para construção - eletrica - hidraulica- ferramentas">
<meta name="author" content="LC Max Solution">
<link rel="shortcut icon" type="image/x-icon" href="https://lcmaxsolution.com.br/Leal-Dutra/assets/images/icon.png">
<!--<link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../../../assets/css/style.min.css">-->
</head>
<body>
<?php
session_start();
require_once '../../config.php';
 require_once '../../header.php'; ?>
<main class="main">
  <?php
		include '../../controller/unidades/unidades-form.php';
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
    <!-- End .container --> 
  </div>
  <!-- End .promo-section -->
  
  <!-- SLIDER DE MARCAS -->
 <?php include '../../controller/index-marca.php'; ?>
  <!------------------------------->
 
  
</main>
<?php include '../../rodape.php'; ?>

<?php include '../../header-mobile.php' ?>

<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a> 
<script src="../../assets/js/jquery.min.js"></script> 
<script src="../../assets/js/mascara.js"></script> 
<script src="../../assets/js/buscaCEP.js"></script> 
<script src="../../assets/js/bootstrap.bundle.min.js"></script> 
<script src="../../assets/js/plugins.min.js"></script> 
<script src="../../assets/js/main.min.js"></script>
</body>
</html>