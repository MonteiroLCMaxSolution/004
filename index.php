<?php 
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
if(!isset($_SESSION)){
    session_start();
}
$versao = '17052022';

if($_GET['pg'] == 'reset'){
	session_destroy();
	$_SESSION['id_do_cliente'] = '';
	$_SESSION['nome_do_cliente'] = '';
	$_SESSION['last_access'] = '';
	$_SESSION['access_customer'] = '';
	$_SESSION['email_do_cliente'] = '';
	$_SESSION['COD_EMPRESA_cliente'] = '';
	$_SESSION['sha1_cliente'] = '';
	$_SESSION['COD_UF'] ='';
	$_SESSION['COD_CIDADE'] = '';
	$_SESSION['sha_carrinho'] = '';
}



if (empty($_SESSION['sha_carrinho'])){
  $_SESSION['sha_carrinho'] = sha1('Deus é fiel'.time());
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $config = 'config.php';
    $parametro = 's';
    $tag = '../';
    while ($parametro != 'n'){
    if (file_exists($config)) {
        $parametro = 'n';
    } else {
        $config = $tag.$config;
    }
    }
    require_once $config;
?>
<!DOCTYPE html>
<html lang="pt-br"> 
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178463374-1"></script>


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>3E Comercial - Distribuidora de Ferragens e Materiais para Construção</title>
    <link rel="shortcut icon" href="<?php echo $http; ?>/favicon.ico" />
    <meta name="keywords" content="3E Comercial - Distribuidora de Ferragens e Materiais para Construção" />
    <meta name="description" content="3E Comercial - Distribuidora de Ferragens Materiais para Construção">
    <meta name="author" content="LC Max Solution">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.min.css">
    <link rel="stylesheet" href="css/cookie.css">
   
    
</head>
<body>

    <input type="hidden" id="http" value="<?php echo $http;?>">
    
    <input type="hidden" name="cookies_aceito" id="cookies_aceito" value="">
    <input type="hidden" id="clienteID" value="<?php echo $_SESSION['id_do_cliente'];?>">
    <div class="page-wrapper" >
        <header class="header mb-0">
            <?php
            require_once 'header.php';
            ?>
        </header><!-- End .header -->

        
        
        <main class="main">
            <div class="container" id="tela_principal">
                <?php
                if (isset($_GET['pg'])){    
                    switch ($_GET['pg']):
						case 'detalhes-produto'; /* Leônidas Monteiro - 17/09/2020 */
						include_once 'ajax/product-quick-view-logado.php';
						break;
						
						case 'politica-privacidade';
						include_once 'controller/politica-privacidade/index.php';
						break;
					
						case 'quem-somos'; /* Leônidas Monteiro - 17/08/2020 */
						include_once 'controller/quem-somos/index.php';
						break;
						
						case 'politica-de-troca'; /* Leônidas Monteiro 20/03/2020 */
						include_once 'controller/forma-de-troca/index.php';
						break;
						
						case 'politica-de-seguranca'; /* Leônidas Monteiro 20/03/2020 */
						include_once 'controller/forma-de-seguranca/index.php';
						break;
						
						case 'promocao'; /* Leônidas Monteiro 16/03/2020 */
						include_once 'controller/promocao/promocao-form.php';
						break;
						
						case 'marca'; /* Leônidas Monteiro 11/03/2020 */
						include_once 'controller/marca/marca-form.php';
						break;
						
						case 'categoria'; /* Leônidas Monteiro 11/03/2020 */
						include_once 'controller/categoria/categoria-form.php';
						break;
						
						case 'dados-pedido';
						include_once 'controller/cliente/dados-pedido.php';
						break;
						
						case 'meus-pedidos';
						include_once 'controller/cliente/meus-pedidos.php';
						break;
						
						case 'alterar-senha';
						include_once 'controller/support/alterar-senha.php';
						break;
					
						case 'dados_cliente';
						 include_once ('controller/cliente/index.php');
						break;
						
						case 'recuperar_senha';
						 include_once ('controller/support/esqueceu-senha.php');
						break;
						
                        case 'finalizar-carrinho';
                        include 'controller/carrinho/finalizar_carrinho.php';
                        break;

                        case 'carrinho';
                        include 'controller/carrinho/cart.php';
                        break;

                        case 'buscar';
                        include 'controller/buscar/resultado_busca.php';
                        break;
                        
                        case 'forma-de-entrega';
                        include 'controller/forma-de-entrega/index.php';
                        break;

                        case 'forma-de-pagamento';
                        include 'controller/forma-de-pagamento/index.php';
                        break;

                        case 'forma-de-seguranca';
                        include 'controller/forma-de-seguranca/index.php';
                        break;

                        case 'como-comprar';
                        include 'controller/como-comprar/index.php';
                        break;

                        case 'login_cliente';
                        include_once 'controller/cliente/login.php';
                        break;

                        case 'login_cliente_hom';
                        include_once 'controller/cliente/login_hom.php';
                        break;

                        case 'contato';
                        include_once ('controller/contato/contato/contato-form.php');
                        break;

                        case 'cadastrar_cliente';
                        include_once ('controller/cliente/index.php');
                        break;

                        case 'home':
                        default:
                        include_once ('controller/index-slider.php');
                        break;
                    endswitch;
                }else{
                    include_once ('controller/index-slider.php');
                }
                include_once ('controller/index-promocao.php');
                ?>
            </div><!-- End .container -->
        </main><!-- End .main -->
         <?php include_once ('footer.php'); ?>
    </div><!-- End .page-wrapper -->

    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <?php
                include_once 'header_mobile.php';
        ?>
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->
    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
    
    <script src="<?php echo $http;?>/assets/js/jquery.min.js?<?php echo $versao;?>"></script> 
    <script src="<?php echo $http;?>/assets/js/bootstrap.bundle.min.js?<?php echo $versao;?>"></script> 
    <script src="<?php echo $http;?>/assets/js/plugins.min.js?<?php echo $versao;?>"></script>
    <script src="<?php echo $http;?>/assets/js/main.min.js?<?php echo $versao;?>"></script>
    <script src="<?php echo $http;?>/assets/js/mascara.js?<?php echo $versao;?>"></script>
    <script src="<?php echo $http;?>/assets/js/buscaCEP.js?<?php echo $versao;?>"></script>
    <script src="<?php echo $http;?>/assets/js/CNPJ_CPF.js?<?php echo $versao;?>"></script>
    <script src="<?php echo $http;?>/assets/buscar/ajax.js?<?php echo $versao;?>"></script>
      
    
    <script src="<?php echo $http;?>/assets/js/ajax.js?<?php echo $versao;?>"></script>
             
			 <?php 
			 
			 
			 	if (!isset($_SESSSION['liberar_cokies'])){
				 	if($_SESSION['liberar_cokies'] == 'ok'){
					 $display = 'style="display:none"';
				 	}else{
					$display = '';
					}
				}else{
					$display = 'style="display:none"';
					}
				?>
			 
			 
			 
			 <!--<div id="posiciona" <?php echo $display; ?>>Usamos cookies para personalizar anúncios e melhorar a sua experiência no site. Ao continuar navegando, você concorda com a nossa Política de Privacidade.<a href="?pg=politica-privacidade"> Política de Privacidade</a><BR/><div class="cookie_button" align=right><a href="javascript:aceitouCookie();">FECHAR</a></div></div>-->
    
</div>
</body>
</html>