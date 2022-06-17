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
<body onLoad="checkRadio()">
<div class="row">
    <div class="col-lg-9 offset-lg-3">
        <h2 class="title text-center">Finalizar Carrinho</h2>
        <div class="row">
          <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detalhes da Compra</li>
                    </ol>
                </div><!-- End .container -->
            </nav>

            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart-table-container">
                            <div class="col-lg-12" style="background:#F00;height:44px; color:#FFF; text-align:center; text-height: 44px">Tipo de Pagamento</div>
                            <div class="col-lg-12">
                            	<input type="radio" id="radioDesconto" onClick="checkRadio(1)" checked="checked" value="1" name="tipoPagemento" /> A Vista (3% desconto)<BR/>
                            	<input type="radio" onClick="checkRadio(1)" name="tipoPagemento" /> Parcelado<BR/>
                            </div>
                            <div id="prazos">
                            	<label>Escolha uma opção de prazo</label><BR/>
                                <?php 
								$valorMinimo = 300;
								$coeficiente = $valorTotalCart / $valorMinimo;
								$coeficiente = intval($coeficiente);
								if ($coeficiente >= 1){
								?>
                            	<input type="radio" onClick="checkRadio(1)" id="chamaPrimeiro" name="prazoDias" checked/> 7 dias<BR/>
                            	<input type="radio" onClick="checkRadio(2)" name="prazoDias" /> 7/14 dias<BR/>
                            	<input type="radio" onClick="checkRadio(3)" name="prazoDias" /> 28 dias<BR/>
                                <?php
								}
								if ($coeficiente >= 2){
								?>
                            	<input type="radio" onClick="checkRadio(4)" name="prazoDias" /> 21/28 dias<BR/>
                            	<?php
								}
								if ($coeficiente >= 3){
								?>
                                <input type="radio" onClick="checkRadio(5)" name="prazoDias" /> 21/28/35 dias<BR/>
                            	<?php
								}
								if ($coeficiente >= 4){
								?>
                                
                                <input type="radio" onClick="checkRadio(6)" name="prazoDias" /> 21/28/35/42 dias<BR/>
                            	<?php
								}
								if ($coeficiente >= 5){
								?>
                                <input type="radio" onClick="checkRadio(7)" name="prazoDias" /> 21/28/35/42/49 dias<BR/>
                            	<?php
								}
								if ($coeficiente >= 6){
								?>
                                <input type="radio" onClick="checkRadio(8)" name="prazoDias" /> 21/28/35/42/49/56 dias<BR/>
                                <?php
								}
								?>
                            </div>
                            <div class="col-lg-12" style="background:#F00;height:44px; color:#FFF; text-align:center; text-height: 44px"> Pagamento com:</div>
                            <div class="col-lg-12">
                            	<input type="radio" name="pagamentoCom"  checked="checked"/> Boleto<BR/>
                            </div>
                            <div class="col-lg-12">
                                <label>Observações</label>
                                <input class="form-control" id="observacaoPedido">
                            </div>
                            <?php if($valorTotalCart < 250){
								$hidden = '';
							}else{
								$hidden = 'hidden';
							}?>
                            <div id="msg" <?php echo $hidden;?> style="background:#FF0; color:#000">
                            O Valor da compra é inferior a R$ 300,00<BR/>Ao finalizar a compra, nosso financeiro estará analizando seu pedido!
                            </div>
                        </div><!-- End .cart-table-container -->


                    </div><!-- End .col-lg-8 -->

                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h3>Sumário</h3>                             
							
                            <table class="table table-totals">
                                <tbody>
                                    <tr>
                                        <td>Valor total da Compra</td>
                                        <input id="valorSumario" value="<?php echo $valorTotalCart;?>" type="hidden" />
                                        <input id="diasPagamento" value="0" type="text" hidden="hidden" />
                                        <td><div class="valorSumario" ><?php echo number_format($valorTotalCart,2,',','.');?></div></td>
                                    </tr>
                                    <tr>
                                        <td>Descontos</td>
                                        <td><div class="desconto" ><?php echo number_format(0,2,',','.');?></div></td>
                                    </tr>

                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Valor a Pagar</td>
                                        <td><div class="valorTotal" ><?php echo number_format($valorTotalCart,2,',','.');?></div></td>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="checkout-methods">
                                <a href="javascript: confirmarPedido();" class="btn btn-block btn-sm btn-primary">Confirmar Pedido</a>
                            </div>
                            <div class="btn btn-success" style="text-align:center; margin-top:10px"><a href="?pg=home">Continuar Comprando</a></div><!-- End .checkout-methods -->
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
</body>
<?php
}
?> 
<script src="<?php echo $http;?>/js/carrinho/carrinho.js"></script>