<!DOCTYPE html>
<html lang="pt-br">
<!-- chamar HEADER -->
<?php include '../../header.php'; ?>
<!-- FIM HEADER -->
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Leal Dutra Distribuidora LTDA</title>
<meta name="keywords" content="HTML5 Template" />
<meta name="description" content="Porto - Bootstrap eCommerce Template">
<meta name="author" content="SW-THEMES">
<link rel="icon" type="image/x-icon" href="http://lealdutra.com.br/web/images/favicon.ico">
<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../../assets/css/style.min.css">
</head>
<body>
<main class="main">
  <?php
		//include '../../controller/contato/contato/contato-form.php';
		echo 'aqui vai TELA DE LOGIN';
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
<div class="newsletter-popup mfp-hide" id="newsletter-popup-form" style="background-image: url(../../assets/images/newsletter_popup_bg.jpg)">
  <div class="newsletter-popup-content"> <img src="../../assets/images/logo-leal-popup.png" alt="Logo" class="logo-newsletter">
    <h2>SEJA O PRIMEIRO A SABER DAS NOVIDADES!</h2>
    <p>Inscreva-se em nosso site para receber diariamento ofertas de seus produtos favoritos.</p>
    <form action="#">
      <div class="input-group">
        <input type="email" class="form-control" id="newsletter-email" name="newsletter-email" placeholder="Endereço de email" required>
        <input type="submit" class="btn" value="Enviar!">
      </div>
    </form>
    <div class="newsletter-subscribe">
      <div class="checkbox">
        <label>
          <input type="checkbox" value="1">
          Don't show this popup again </label>
      </div>
    </div>
  </div>
</div>
<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a> 
<script src="../../assets/js/jquery.min.js"></script> 
<script src="../../assets/js/bootstrap.bundle.min.js"></script> 
<script src="../../assets/js/plugins.min.js"></script> 
<script src="../../assets/js/main.min.js"></script>
</body>
</html>