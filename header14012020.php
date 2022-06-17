<?php

session_start();


ini_set('session.cookie_lifetime', 86400);
ini_set('session.gc_maxlifetime', 86400);

/* Criar SHA1 ao iniciar tela do Carrinho */

if (empty($_SESSION['sha_carrinho'])){
    $_SESSION['sha_carrinho'] = sha1('Deus é fiel'.time());
    //echo $_SESSION['sha_carrinho'];
}

/* FIM - Criar SHA1 ao iniciar tela do Carrinho */
include_once ('conexao-pdo/config.php');
include_once ('conexao-pdo/conexao-mysql-pdo.php');
/*include_once ('model/categoria/categoria.php');
include_once ('model/parametros/parametros.php');*/
include_once ('model/produtos/produtos.php');
include_once ('model/promocao/promocao.php');
include_once ('model/carrinho/carrinho.php');


?>
        <header class="header mb-0">
            <div class="header-top">
                <div class="container">
                    <div class="header-right">
                    <p class="welcome-msg">
                    <?php 
                    if(!empty($_SESSION['nome_do_cliente'])){
                        echo 'Boas compras '.$_SESSION["nome_do_cliente"].' - '.$_SESSION['COD_EMPRESA_cliente'];
                    }else{
                        echo 'Bem Vindo ao 3E Comercial';
                    }
					?>
                    </p>
                        <!--<p class="welcome-msg">Bem Vindo ao 3E Comercial </p>-->

                        <div class="header-dropdown dropdown-expanded">
                            <a href="#">Links</a>
                            <div class="header-menu">
                                <ul>
                                  <?php if(!empty($_SESSION['nome_do_cliente'])){?>
                                  <li><a href="<?php echo $http;?>/view/cliente/my-account">MINHA CONTA </a></li>
                                  <?php }else{ ?>
                                  <li><a href="<?php echo $http;?>/view/cliente/minha-conta">CADASTRE-SE </a></li>
                                  <?php } if (!empty($_SESSION['id_do_cliente'])){?>
                                  <li><a href="<?php echo $http;?>/view/lista-de-desejo/">LISTA DE DESEJO </a></li>
                                  <?php } ?>
                                  <!--  <li><a href="blog.html">BLOG</a></li> -->
                                  <li><a href="<?php echo $http;?>/view/contato/contato/index.php">CONTATO</a></li>
                                  <?php if(!empty($_SESSION['nome_do_cliente'])){?>
                                  <li><a href="<?php echo $http;?>/reset.php">SAIR</a></li>
                                  <?php }else{?>
                                  <li><a href="<?php echo $http; ?>/ajax/login-Index.php" >ENTRAR</a></li>
                                  <!--<li><a href="#" class="login-link">ENTRAR</a></li>-->
                                  <?php } ?>
                                </ul>
                            </div><!-- End .header-menu -->
                        </div><!-- End .header-dropown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-top -->
            
            <div class="container">
                <div class="header-middle">
                    <div class="container-fluid">
                        <div class="header-left">
                            <!--<a href="<?php echo $http; ?>" class="logo">-->
                            <a href="<?php echo $http; ?>" >
                                <img src="<?php echo $http; ?>/Painel/imagens/logo/<?php echo $LogoEmpresaBranco; ?>" alt="3E Comercial" width="200px">
                            </a>
                        </div><!-- End .header-left -->

                        <div class="header-right">
                            <div class="header-search">
                                <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                                <form action="<?php echo $http;?>/view/buscar?cod='s'" method="get" name="buscar">
                                    <div class="header-search-wrapper">
                                        <!--<input type="search" class="form-control" name="q" id="q" placeholder="Buscar..." required>-->
                                        <input type="text" class="form-control" name="buscar" placeholder="Código, nome ou marca do produto..." required>
                                        <button class="btn" type="submit"><i class="icon-magnifier"></i></button>
                                    </div><!-- End .header-search-wrapper -->
                                </form>
                            </div><!-- End .header-search -->

                            <div class="header-contact">
                                <span>Ligue para nós!</span>
                                <a href="tel:#"><strong>12 3961-6444</strong></a>
                            </div><!-- End .header-contact -->

                            <div class="dropdown cart-dropdown">
                                <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                    <span class="cart-count">2</span>
                                </a>

                                <div class="dropdown-menu" >
                                    <div class="dropdownmenu-wrapper">
                                        <div class="dropdown-cart-products">
                                    
                                        <?php while ($row_listar_carrinho = $SQL_listar_carrinho_header->fetch()){ ?>
                                            <div class="product">
                                                <div class="product-details">
                                                <h4 class="product-title"> <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_listar_carrinho->id_produto;?>"><?php echo $row_listar_carrinho->id_produto.' - '.$row_listar_carrinho->nome_produto;?></a> </h4>
                    <span class="cart-product-info"> <span class="cart-product-qty"><?php echo $row_listar_carrinho->qtde;?></span> x <?php echo 'R$ '.number_format($row_listar_carrinho->valor_unitario,2,',','.');?> </span> </div>
                  <!-- End .product-details -->
                  
                  <figure class="product-image-container"> <a href="produto.php" class="product-image"> <img src="<?php echo $http;?>/Painel/imagens/produtos/<?php echo $row_listar_carrinho->imagem;?>" alt="product"> </a> 
                  <a href="<?php echo $http;?>/model/carrinho/carrinho.php?del=<?php echo $row_listar_carrinho->id;?>" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a> </figure>
                                            </div><!-- End .product -->

                                        <!-- End .product -->
                                         <?php } ?>

                                        </div><!-- End .cart-product -->

                                        <div class="dropdown-cart-total">
                                            <span>Total</span>

                                            <span class="cart-total-price"><?php echo 'R$ '.number_format($valorTotalCarrinho,2,',','.'); ?></span>
                                        </div><!-- End .dropdown-cart-total -->

                                        <div class="dropdown-cart-action">
                                        <a href="<?php echo $http;?>/view/carrinho" class="btn">Ver Carrinho</a> 
                                        </div><!-- End .dropdown-cart-total -->
                                    </div><!-- End .dropdownmenu-wrapper -->
                                </div><!-- End .dropdown-menu -->
                            </div><!-- End .dropdown -->
                        </div><!-- End .header-right -->
                    </div><!-- End .container-fluid -->
                </div><!-- End .header-middle -->
            </div><!-- End .container -->

            <div class="header-bottom">
                <div class="container">
                    <div class="header-left">
                        <div class="main-dropdown-menu show is-stuck">
                            <a href="#" class="menu-toggler">
                                <i class="icon-menu"></i>
                                Compre Facil 
                            </a>
                            <nav class="main-nav">
                                <ul class="menu menu-vertical sf-arrows">
                                    <li class="active"><a href="<?php echo $http; ?>"><i class="icon-home"></i>Home</a></li>
                                    
                                    
                                    <li>
                                        <a href="category.html" class="sf-with-ul"><i class="icon-briefcase"></i>Categorias</a>
                                        <div class="megamenu megamenu-fixed-width" style="width:240px">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <ul>
                                            <?php 
											$SQL_listar_categorias = "select T2.id as id_categoria, T1.cod_categoria, T2.nome as categoria from produtos T1 
											LEFT JOIN categoria T2 on
											T1.cod_categoria = T2.sigla
											WHERE T2.sigla is not null
											GROUP BY T1.cod_categoria";
											$SQL_listar_categorias = $pdo->prepare($SQL_listar_categorias);
											$SQL_listar_categorias->execute();
											while($ROW_listar_categoria = $SQL_listar_categorias->fetch()) {
											?>
                                             <li><a href="<?php echo $http; ?>/view/categorias?categoria=<?php echo $ROW_listar_categoria->cod_categoria; ?>"><?php echo $ROW_listar_categoria->categoria;  ?></a></li>
                                            <?php } ?> 
                                                            </ul>
                                                        </div><!-- End .col-lg-6 -->
                                                    </div><!-- End .row -->
                                                </div><!-- End .col-lg-8 --> 
                                            </div>
                                        </div><!-- End .megamenu -->
                                    </li>
                                    <li class="megamenu-container">
                                        <a href="product.html"><i class="icon-video"></i>Marca</a>
                                    </li>
                                     <li class="megamenu-container">
                                        <a href="product.html" class="sf-with-ul"><i class="icon-phone"></i>Contato</a>
                                        <div class="megamenu megamenu-fixed-width" style="width:240px">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <ul>
                                           
                                             <li><a href="<?php echo $http; ?>/view/quem-somos/">Quem Somos</a></li>
                                             <li><a href="<?php echo $http; ?>/view/contato/contato/">Fale Conosco</a></li>
                                             <li><a href="<?php echo $http; ?>/view/contato/trabalhe-conosco/">Trabalhe Conosco</a></li>
                                             <li><a href="<?php echo $http; ?>/view/contato/seja-um-fornecedor/">Seja um Fornecedor</a></li>
                                                            </ul>
                                                        </div><!-- End .col-lg-6 -->
                                                    </div><!-- End .row -->
                                                </div><!-- End .col-lg-8 --> 
                                            </div>
                                        </div><!-- End .megamenu -->
                                    </li>
                                    <li><a href="<?php echo $http.'/view/ofertas?ofertas=1';?>"><i class="icon-cat-gift"></i>Ofertas Especiais</a></li>
                                </ul>
                            </nav>
                        </div><!-- End .main-dropdown-menu -->
                    </div><!-- End .header-left -->
                    <div class="header-right">
                        <div class="custom-link-menu">
                            <!--<a href="#">FASHION PROMO</a>
                            <a href="#">WOMAN SHOES</a>
                            <a href="#">50% OFF FASHION</a>-->
                        </div><!-- End .custom-link-menu -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-bottom -->
        </header><!-- End .header -->

        <script src="<?php echo $http;?>/assets/js/main.min.js"></script>