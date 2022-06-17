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
<?php 
$SQL_listar_categorias = "SELECT a.cod_categoria FROM produtos a 

WHERE a.cod_categoria <> '' AND a.cod_categoria <> 'OUTROS' AND a.cod_categoria <> 'ST' GROUP BY a.cod_categoria";
$SQL_listar_categorias = $pdo->prepare($SQL_listar_categorias);
$SQL_listar_categorias->execute();
?>
<span class="mobile-menu-close"><i class="icon-cancel"></i></span>




































































































































<nav class="mobile-nav">
  <ul class="mobile-menu">

    <?php while ($ROW_listar_categoria = $SQL_listar_categorias->fetch()){?>
      <li>
        <a href="#" class="sf-with-ul"><i class="icon-briefcase"></i><?php echo $ROW_listar_categoria->cod_categoria;?></a>
        <div class="megamenu megamenu-fixed-width" style="width:350px">
          <div class="row">
            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-6">
                  <ul style=" background-color: #778899;">

                    <?php
                              $sql_lstar_subcategorias = "SELECT a.cod_subcategoria  FROM produtos a WHERE a.cod_categoria = :cod_categoria AND a.cod_subcategoria != '' GROUP BY a.cod_subcategoria";

                                  $sql_lstar_subcategorias =$pdo->prepare($sql_lstar_subcategorias);

                                  $sql_lstar_subcategorias->bindValue("cod_categoria",$ROW_listar_categoria->cod_categoria);
                                  $sql_lstar_subcategorias->execute();
                                  while ($row_listar_subcategoria = $sql_lstar_subcategorias->fetch()){
                            ?>
                              <li style="font-weight: bold !important; background-color: #778899"><a href="?pg=categoria&subCategoria=<?php echo $row_listar_subcategoria->cod_subcategoria; ?>"><?php echo $row_listar_subcategoria->cod_subcategoria;?></a>
                              </li>
                            <?php } ?>

                  </ul>
                </div><!-- End .col-lg-6 -->
              </div><!-- End .row -->
            </div><!-- End .col-lg-8 --> 
          </div>
        </div>
      </li>
    <?php } ?>

  </ul>
</nav>