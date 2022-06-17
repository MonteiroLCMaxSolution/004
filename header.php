<?php
if(!isset($_SESSION)){
  session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s');
$arquivo = 'config.php';

$parametro = 's';
$tag = '../';
while ($parametro != 'n'){
  if (file_exists($arquivo)) {
    $parametro = 'n';
  } else {
    $arquivo = $tag.$arquivo;
  }
}
require_once $arquivo;

/* FIM - Criar SHA1 ao iniciar tela do Carrinho */
include_once ('conexao-pdo/config.php');
include_once ('conexao-pdo/conexao-mysql-pdo.php');
include_once ('model/categoria/categoria.php');
/*include_once ('model/parametros/parametros.php');*/
include_once ('model/produtos/produtos.php');
include_once ('model/promocao/promocao.php');
include_once ('model/carrinho/carrinho.php');
?>
<meta charset="UTF-8">
<div class="header-top">
  <div class="container">
    <div class="header-left header-dropdowns">
      <div class="header-dropdown">
        <a href="<?php echo $http; ?>" >
          <img src="<?php echo $http; ?>/Painel/imagens/logo/<?php echo $LogoEmpresaBranco; ?>" alt="3E Comercial" width="200px">
        </a>
      </div><!-- End .header-dropown -->
    </div><!-- End .header-left -->

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

      <div class="header-dropdown dropdown-expanded">
        <a href="#">Links</a>
        <div class="header-menu">
          <ul>
            <?php if(!empty($_SESSION['nome_do_cliente'])){?>
              <li><a href="<?php echo $http;?>/?pg=dados_cliente">MINHA CONTA </a></li>
            <?php }else{ ?>
              <li><a href="<?php echo $http;?>/?pg=dados_cliente">CADASTRE-SE </a></li>
            <?php } ?>
            <!--  <li><a href="blog.html">BLOG</a></li> -->
            <li><a href="<?php echo $http;?>/?pg=contato">CONTATO</a></li>
            <?php if(!empty($_SESSION['nome_do_cliente'])){?>
              <li><a href="<?php echo $http;?>/?pg=reset">SAIR</a></li>
            <?php }else{?>
              <li><a href="<?php echo $http; ?>/?pg=login_cliente" >ENTRAR</a></li>
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
        <a href="<?php echo $http; ?>" >
          <img src="<?php echo $http; ?>/Painel/imagens/logo/<?php echo $LogoEmpresaBranco; ?>" alt="3E Comercial" width="200px">
        </a>
      </div>

      <div class="header-right">
        <div class="header-search">
          <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
          <form action="?pg=buscar" method="POST">
            <div class="header-search-wrapper" style="width: 100%">
              <!--<input type="search" class="form-control" name="q" id="q" placeholder="Buscar..." required>-->

              <input type="text" id="campoBuscar" class="form-control" name="buscar" placeholder="Código, nome ou marca do produtos..." required>
              <button class="btn" type="submit" id="buscarProdutos"><i class="icon-magnifier"></i></button>



            </div>
          </form>
        </div>

        <div class="header-contact">
          <span>Ligue para nós!</span>
          <a href="tel:12 3961-6444"><strong>12 3961-6444</strong></a>
        </div>

        <div class="dropdown cart-dropdown">
          <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
            <span class="cart-count" id="qtdeheader"><?php 
            echo $itemTotalCarrinho;
            ?>
          </span>
        </a>

        <div id="listarProdutosHeader">
          <div class="dropdown-menu">
            <div class="dropdownmenu-wrapper">
              <div class="dropdown-cart-products">

                <?php while ($row_listar_carrinho = $SQL_listar_carrinho_header->fetch()){ ?>
                  <div class="product">
                    <div class="product-details">
                      <h4 class="product-title"> <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_listar_carrinho->id_produto;?>"><?php echo $row_listar_carrinho->id_produto.' - '.$row_listar_carrinho->nome_produto;?></a> </h4>
                      <span class="cart-product-info"> <span class="cart-product-qty"><?php echo $row_listar_carrinho->qtde;?></span> x <?php echo 'R$ '.number_format($row_listar_carrinho->valor_unitario,2,',','.');?> = <?php echo 'R$ '.number_format($row_listar_carrinho->valor_total,2,',','.');?> </span> </div>
                      <!-- End .product-details -->

                      <figure style="padding: 5px;" class="product-image-container"> <a href="produto.php" class="product-image"> <img src="<?php echo $http;?>/Painel/imagens/produtos/<?php echo $row_listar_carrinho->imagem;?>" alt="product"> </a> 
                        <a href="<?php echo $http;?>/model/carrinho/carrinho.php?DelCart=<?php echo $row_listar_carrinho->id;?>" class="btn-remove" title="Remover Produto"><i class="icon-cancel"></i></a> </figure>
                        <!--div class="row">
                          <input type="button" class="btnCart" data-botao='-' data-id='<?php echo $row_list_cart->id;?>' data-qtdeMinimo='<?php echo $row_list_cart->minimo_produto_venda;?>' data-valor='<?php echo $row_list_cart->valor_unitario;?>' value="-" style="width:35px; height:35px; border:0px; border-radius:7px; background:#39F; text-align:center; line-height:30px">
                          <input readonly="readonly" style="margin-left:10px; margin-right:10px; height:35px; width:40px; border:1px solid #666; border-radius:7px; text-align:center" id="qtde<?php echo $row_list_cart->id;?>" name="qtde" value="<?php echo (int)$row_list_cart->qtde;?>" class='qtde<?php echo $row_list_cart->id;?>'/>
                          <input type="button" class="btnCart"  data-botao='+' data-id='<?php echo $row_list_cart->id;?>' data-qtdeMinimo='<?php echo $row_list_cart->minimo_produto_venda;?>' data-valor='<?php echo $row_list_cart->valor_unitario;?>' value="+" style="width:35px; height:35px; border:0px; border-radius:7px; background:#39F; text-align:center; line-height:30px">
                        s</div>-->
                      </div><!-- End .product -->

                      <!-- End .product -->
                    <?php } ?>

                  </div><!-- End .cart-product -->

                  <div class="dropdown-cart-total">
                    <span>Total</span>

                    <span class="cart-total-price"><?php echo 'R$ '.number_format($valorTotalCarrinho,2,',','.'); ?></span>
                  </div><!-- End .dropdown-cart-total -->

                  <div class="dropdown-cart-action">
                    <a href="?pg=carrinho" class="btn">Ver Carrinho</a> 
                  </div><!-- End .dropdown-cart-total -->
                </div><!-- End .dropdownmenu-wrapper -->
              </div><!-- End .dropdown-menu -->

            </div>
          </div><!-- End .dropdown -->
        </div><!-- End .header-right -->
      </div><!-- End .container-fluid -->
    </div><!-- End .header-middle -->
  </div><!-- End .container -->

  <?php 
  $pg = '';
  if (isset($_GET['pg'])){ 
    $pg = $_GET['pg'];
  }
  if ($pg != "dados_cliente" and $pg != "contato" and $pg != "login_cliente" and $pg != "alterar-senha" and $pg != "meus-pedidos" and $pg != "dados-pedido" and $pg != "promocao"){

    ?>
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
                <?php while ($ROW_listar_categoria = $SQL_listar_categorias->fetch()){?>
                <li>
                  <a href="#" class="sf-with-ul"><i class="icon-briefcase"></i><?php echo $ROW_listar_categoria->cod_categoria;?></a>
                  <div class="megamenu megamenu-fixed-width" style="width: 300px;height:400px; overflow:auto; background:#F3F3F3">
                    
                            <?php
                              $sql_lstar_subcategorias = "SELECT a.cod_subcategoria  FROM produtos a WHERE a.cod_categoria = :cod_categoria AND a.cod_subcategoria != '' GROUP BY a.cod_subcategoria";

                                  $sql_lstar_subcategorias =$pdo->prepare($sql_lstar_subcategorias);

                                  $sql_lstar_subcategorias->bindValue("cod_categoria",$ROW_listar_categoria->cod_categoria);
                                  $sql_lstar_subcategorias->execute();
                                  while ($row_listar_subcategoria = $sql_lstar_subcategorias->fetch()){
                            ?>
                            <ul>
                              <li style="font-weight: bold !important;"><a href="?pg=categoria&subCategoria=<?php echo $row_listar_subcategoria->cod_subcategoria; ?>"><?php echo $row_listar_subcategoria->cod_subcategoria;?></a>
                              </li>
                            </ul>
                            <?php } ?>
                  </div><!-- End .megamenu -->
                </li>
                <?php } ?>
              </ul>
            </nav>
          </div><!-- End .main-dropdown-menu -->
        </div><!-- End .header-left -->
      </div><!-- End .container -->
    </div><!-- End .header-bottom -->
    <?php  
  }else{?>
    <div class="mobile-menu-overlay"></div>
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
      <div class="mobile-menu-wrapper">
        <?php
        include_once 'header_mobile.php';
        ?>
      </div><!-- End .mobile-menu-wrapper -->
    </div>
  <?php } ?>
