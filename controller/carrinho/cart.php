<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<?php
$arquivo = 'model/carrinho/carrinho.php';
if($SQL_resultadoCart->rowCount() > 0){
	$row_resultadoCart = $SQL_resultadoCart->fetch();
	$valorTotalCart = $row_resultadoCart->valortotal;	
}

$parametro = 's';
$tag = '../';
while ($parametro != 'n'){
    if (file_exists($arquivo)) {
        $parametro = 'n';
    } else {
        $arquivo = $tag.$arquivo;
    }
}
if ($SQL_list_cart->rowCount() > 0){
?>

<div class="row">
    <div class="col-lg-9 offset-lg-3">
        <h2 class="title text-center">Seu Carrinho</h2>
        <div class="row">
          <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Carrinho de Compras</li>
                    </ol>
                </div><!-- End .container -->
            </nav>

            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart-table-container">
                            <table class="table table-cart">
                                <thead>
                                    <tr>
                                        <th class="product-col">Produto</th>
                                        <th class="price-col">Preço</th>
                                        <th class="qty-col">Qtde</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    while ($row_list_cart = $SQL_list_cart->fetch()){?>
                                        <tr class="product-row">
                                            <td class="product-col">
                                                <img src="Painel/imagens/produtos/<?php echo $row_list_cart->imagem;?>" alt="product" style="width: 60px">
                                                <h2 class="product-title">
                                                    <a href="product.html"><?php echo $row_list_cart->id_produto.'/'.$row_list_cart->nome_produto;?></a>
                                                </h2>
                                            </td>
                                            <td><?php echo number_format($row_list_cart->valor_unitario,2,',','.');?></td>
                                            <td width="130px">
                                               <div class="row">
                                            	<input type="button" class="btnCart" data-estoque='<?php echo $row_list_cart->estoque_disponivel;?>'  data-botao='-' data-id='<?php echo $row_list_cart->id;?>' data-ids='<?php echo $row_list_cart->id;?>' data-qtdeMinimo='<?php echo $row_list_cart->minimo_produto_venda;?>'  data-valor='<?php echo $row_list_cart->valor_unitario;?>' value="-" style="width:35px; height:35px; border:0px; border-radius:7px; background:#39F; text-align:center; line-height:30px">
                                                
                                                <input readonly="readonly" style="margin-left:10px; margin-right:10px; height:35px; width:40px; border:1px solid #666; border-radius:7px; text-align:center" id="qtde<?php echo $row_list_cart->id;?>" name="qtde" value="<?php echo (int)$row_list_cart->qtde;?>" class='qtde<?php echo $row_list_cart->id;?>'/>
                                                <input type="button" class="btnCart" ata-estoque='<?php echo $row_list_cart->estoque_disponivel;?>' data-botao='+' data-ids='<?php echo $row_list_cart->id;?>'  data-id='<?php echo $row_list_cart->id;?>'data-estoque="<?php echo $row_list_cart->estoque_disponivel;?>" data-qtdeMinimo='<?php echo $row_list_cart->minimo_produto_venda;?>;1111' data-valor='<?php echo $row_list_cart->valor_unitario;?>' value="+" style="width:35px; height:35px; border:0px; border-radius:7px; background:#39F; text-align:center; line-height:30px">
                                            	</div>
                                            </td>
                                            <td><div id="valorTotal<?php echo $row_list_cart->id;?>"><?php echo number_format($row_list_cart->valor_total,2,',','.');?></div></td>
                                        </tr>
                                        <tr class="product-action-row">
                                            <td colspan="4" class="clearfix">


                                                <div class="float-right">
                                                    <a href="../model/carrinho/carrinho.php/?DelCart=<?php echo $row_list_cart->id;?>" title="Excluir produto" class="btn-remove"><span class="sr-only">Excluir</span></a>
                                                </div><!-- End .float-right -->
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="clearfix">
                                            <div class="float-left">
                                                <a href="?pg=home" class="btn btn-outline-secondary">Continue Comprando</a>
                                            </div><!-- End .float-left -->
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- End .cart-table-container -->


                    </div><!-- End .col-lg-8 -->

                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h3>Sumário</h3>                             
							
                            <table class="table table-totals">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <input id="valorSumario" value="<?php echo $valorTotalCart;?>" type="hidden" />
                                        <td><div class="valorSumario" ><?php echo number_format($valorTotalCart,2,',','.');?></div></td>
                                    </tr>

                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Total</td>
                                        <td><div class="valorSumario" ><?php echo number_format($valorTotalCart,2,',','.');?></div></td>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="checkout-methods">
                                <a href="?pg=finalizar-carrinho" class="btn btn-block btn-sm btn-primary">Finalizar</a>
                            </div><!-- End .checkout-methods -->
                        </div><!-- End .cart-summary -->
                    </div><!-- End .col-lg-4 -->
                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="mb-6"></div><!-- margin -->
        </main><!-- End .main -->
    </div>
</div>
</div>
<?php
}else{?>
    <div class="row">
    <div class="col-lg-9 offset-lg-3">
        <h2 class="title text-center">Seu carrinho esta vázio</h2>
        <div class="row">
            <div class="float-left" style="height: 200px">
                                                <a href="?pg=home" class="btn btn-outline-secondary">Aproveita, economize dinheiro agora</a>
                                            </div>
        </div>
    </div>
</div>
<?php
}
?> 
<script src="../js/carrinho/carrinho.js">