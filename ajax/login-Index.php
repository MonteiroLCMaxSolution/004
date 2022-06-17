<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once ('../conexao-pdo/config.php'); ?>
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
    <link rel="stylesheet" href="<?php echo $http; ?>/assets/css/bootstrap.min.css">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="<?php echo $http; ?>/assets/css/style.min.css">
</head>
<body>
    <div class="page-wrapper">
       <?php include_once ('../header.php'); ?>

        <main class="main">
            <div class="container">
            	<div class="col-lg-9 offset-lg-3">
               <div class="featured-products-section carousel-section">
    <div class="container">      
        <div class="row">
            <div class="col-md-6">
                <h2 class="title mb-2">Faça seu Loginfffffffff <?php session_start(); echo $_SESSION['codprodutodados']; ?></h2>

                <form action="<?php echo $http; ?>/model/cliente/cliente.php?login='1'" class="mb-1" method="post">
                    <label for="login-email">Login, Email ou CNPJ <span class="required">*</span></label>
                    <input name="login" class="form-input form-wide mb-2" id="login-email" required />

                    <label for="login-password">Senha <span class="required">*</span></label>
                    <input type="password" class="form-input form-wide mb-2" id="login-password" required name="password" />

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-md">Entrar</button>

                        
                    </div><!-- End .form-footer -->
                    <a href="<?php echo $http; ?>/view/cliente/recuperar-senha" class="forget-password"> Esqueceu sua senha?</a><br />
                    <a href="<?php echo $http; ?>/?pg=dados_cliente" class="forget-password"> Não tem cadastro? Clique aqui.</a> 
                </form>
            </div><!-- End .col-md-6 -->

            <div class="col-md-6">
                <h2 class="title mb-2">Cadastrar</h2><span> Se ainda não é cadastrado em nosso sistema e quer aproveitar das facilidades de comprar e consultar os nossos preços e até mesmo receber nossas promoções é só clicar  no botão abaixo para preencher o formulário e em segundos já poder efetuar sua compra com total segurança!</span>

                    <div class="form-footer">
                        <div ><a href="?pg=dados_cliente" class="btn btn-primary btn-md">Registrar</a></div>
                    </div><!-- End .form-footer -->
        </div>
      </div>
    </div>
  </div>
               </div>
				

                <div class="mb-3"></div><!-- margin -->
                
     <!-------------------------------------------------------------> 
			<?php include_once ('../controller/index-promocao.php'); ?>
               

                <div class="mb-6"></div><!-- margin -->
            </div><!-- End .container -->
        </main><!-- End .main -->

      <?php include_once ('../footer.php'); ?>
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