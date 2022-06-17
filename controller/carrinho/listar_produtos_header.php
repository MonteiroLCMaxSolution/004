<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$arquivo = '../model/carrinho/carrinho.php';

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
  if ($SQL_soma_header->rowCount() > 0){
    $SQL_soma_header = $SQL_soma_header->fetch();
    $valor_total = $SQL_soma_header->valor_total;
  }
?>
<div id="listarProdutosHeader">
<div class="dropdown-menu" >
  <div class="dropdownmenu-wrapper">
    <div class="dropdown-cart-products">
      <?php while ($row_listar_carrinho = $SQL_list_header->fetch()){ ?>
        <div class="product">
          <div class="product-details">
            <h4 class="product-title">
              <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_listar_carrinho->id_produto;?>"><?php echo $row_listar_carrinho->id_produto.' - '.$row_listar_carrinho->nome_produto;?></a>
            </h4>
            <span class="cart-product-info">
             <span class="cart-product-qty"><?php echo $row_listar_carrinho->qtde;?></span> x <?php echo 'R$ '.number_format($row_listar_carrinho->valor_unitario,2,',','.');?> </span> 
           </div>
           <!-- End .product-details -->

           <figure class="product-image-container"><img src="<?php echo $http;?>/Painel/imagens/produtos/<?php echo $row_listar_carrinho->imagem;?>" alt="<?php echo $row_listar_carrinho->nome_produto;?>" height="90px">
            
            <!-- <a href="<?php echo $http;?>/model/carrinho/carrinho.php?del=<?php echo $row_listar_carrinho->id;?>" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a> -->

            <a href="javascript: del_product(<?php echo $row_listar_carrinho->id;?>)" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a>

          </figure><div class="row">
                                              <input type="button" class="btnCart" data-botao='-' data-id='<?php echo $row_list_cart->id;?>' data-qtdeMinimo='<?php echo $row_list_cart->minimo_produto_venda;?>' data-valor='<?php echo $row_list_cart->valor_unitario;?>' value="-" style="width:35px; height:35px; border:0px; border-radius:7px; background:#39F; text-align:center; line-height:30px">
                                                <input readonly="readonly" style="margin-left:10px; margin-right:10px; height:35px; width:40px; border:1px solid #666; border-radius:7px; text-align:center" id="qtde<?php echo $row_list_cart->id;?>" name="qtde" value="<?php echo (int)$row_list_cart->qtde;?>" class='qtde<?php echo $row_list_cart->id;?>'/>
                                                <input type="button" class="btnCart"  data-botao='+' data-id='<?php echo $row_list_cart->id;?>' data-qtdeMinimo='<?php echo $row_list_cart->minimo_produto_venda;?>' data-valor='<?php echo $row_list_cart->valor_unitario;?>' value="+" style="width:35px; height:35px; border:0px; border-radius:7px; background:#39F; text-align:center; line-height:30px">
                                              </div>
        </div><!-- End .product -->
      <?php } ?>
    </div><!-- End .cart-product -->
    <div class="dropdown-cart-total">
      <span>Total</span>

      <span class="cart-total-price"><?php echo 'R$ '.number_format($valor_total,2,',','.'); ?>

    </span>
  </div><!-- End .dropdown-cart-total -->
  <div class="dropdown-cart-action">
    <a href="<?php echo $http;?>/view/?pg=carrinho" class="btn">Ver Carrinho</a> 
  </div><!-- End .dropdown-cart-total -->
</div><!-- End .dropdownmenu-wrapper -->
</div><!-- End .dropdown-menu -->
</div>
<script src="js/product-quick-view.js"></script>