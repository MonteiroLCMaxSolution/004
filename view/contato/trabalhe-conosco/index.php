  <!DOCTYPE html>
<html lang="en">
<head>
<?php include_once ('../../../conexao-pdo/config.php'); ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $NomeEmpresa; ?></title>

    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="<?php echo $NomeEmpresa; ?>">
    <meta name="author" content="SW-THEMES">
        
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo $http; ?>/Painel/imagens/logo/<?php echo $IconEmpresa; ?>">

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="../../../assets/css/style.min.css">
</head>
<body>
    <div class="page-wrapper">
       <?php include_once ('../../../header.php'); ?>

        <main class="main">
            <div class="container">
            	<div class="col-lg-9 offset-lg-3">
            <?php include_once ('../../../controller/contato/trabalhe-conosco/trabalhe-conosco-form.php');	?>
               </div>
				

                <div class="mb-3"></div><!-- margin -->
                
     <!-------------------------------------------------------------> 
			<?php include_once ('../../../controller/index-promocao.php'); ?>
               

                <div class="mb-6"></div><!-- margin -->
            </div><!-- End .container -->
        </main><!-- End .main -->

      <?php include_once ('../../../footer.php'); ?>
    </div><!-- End .page-wrapper -->


    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

    <!-- Plugins JS File -->
   <script src="<?php echo $http;?>/assets/js/jquery.min.js"></script> 
	<script src="<?php echo $http;?>/assets/js/bootstrap.bundle.min.js"></script> 
    <script src="<?php echo $http;?>/assets/js/mascara.js"></script>
    <script src="<?php echo $http;?>/assets/js/buscaCEP.js"></script>
    <script src="<?php echo $http;?>/assets/js/CNPJ_CPF.js"></script>
    <script src="<?php echo $http;?>/assets/js/plugins.min.js"></script> 
    <script src="<?php echo $http;?>/assets/js/main.min.js"></script>
</body>
</html>