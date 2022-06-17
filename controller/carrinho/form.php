<script type="text/javascript">

window.onload = function(){
 var valor_total = document.getElementById("valor_total").value;
 //alert (valor_total);
	//var vlrttalcarrinho = $("#vlrttalcarrinho").html();
	if( valor_total >= 400){
				$('#maiorpedminimo').show();
				$('#menorpedminimo').hide();
				}else{
				$('#maiorpedminimo').hide();
				$('#menorpedminimo').show();	
				}
  //alert('Ready disparado');
}

</script>
testes testes

<main class="main">
  <nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Carrinho de Comprass - <?php echo $_SESSION['sha_carrinho'];?></li>
      </ol>
    </div>
    <!-- End .container --> 
  </nav>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="cart-table-container">
          <table class="table table-cart">
            <thead>
              <tr>
                <th  class="product-col">Produtos</th>
                <th  class="price-col">Valor Unitário</th>
                <th width="150px" class="qty-col">Qtde</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
				$count = 0;
				while ($row_listar_carrinho = $SQL_listar_carrinho->fetch()){
					 if($_SESSION['COD_EMPRESA_cliente'] == 1) { 	
				$count++;?>
              <tr class="product-row">
                <td class="product-col"><figure class="product-image-container"><img src="../../Painel/imagens/produtos/<?php echo $row_listar_carrinho->imagem;?>" alt="<?php echo $row_listar_carrinho->nome_produto;?>">  </figure>
                  <h2 class="product-title"> <?php echo $row_listar_carrinho->id_produto.'/'.$row_listar_carrinho->nome_produto;?><?php if ($row_listar_carrinho->minimo_produto_venda != 1){ echo '<BR/><span style="font-size:9px;color:red">Vendido apenas por multiplos de '.$row_listar_carrinho->minimo_produto_venda.' unidades!</span>';}?> </h2></td>
                <td><input readonly="readonly" style="margin-left:10px; margin-right:10px; height:35px; width:85px; border:0px; text-align:center" id="valorunit<?php echo $count;?>" class="<?php echo $row_listar_carrinho->id;?>" value="<?php echo 'R$ '.number_format($row_listar_carrinho->valor_unitario,2,',','.');?>" /></td>
                <td><!-- <input class="vertical-quantity form-control" type="text" value="<?php echo $row_listar_carrinho->qtde;?>"> -->
                <button name="btn-mais" rel="<?php echo $row_listar_carrinho->minimo_produto_venda;?>-<?php echo $row_listar_carrinho->id;?>" value="format<?php echo $count;?>" style="width:30px; height:30px; border:0px; border-radius:7px; background:#39F; text-align:center; line-height:30px" >-</button>
             <input readonly="readonly" style="margin-left:1px; margin-right:1px; height:30px; width:30px; border:1px solid #666; border-radius:7px; text-align:center" data-id="result<?php echo $count;?>" rel="<?php echo $row_listar_carrinho->qtde;?>"  type="text" name="format<?php echo $count;?>" value="<?php  echo intval($row_listar_carrinho->qtde);?>" id="format<?php echo $count;?>" size="2" class="valorunit<?php echo $count;?> valortotal<?php echo $count;?>" />
            <!--<input type="button" name="1" id="mais<?php // echo $cont; ?>" value="'+'" class="botaoQTDE" />
            <input type="text" id="qtde" /><input type="submit" onclick="btnMais" value="1" />-->
            <button name="btn+mais" rel="<?php echo $row_listar_carrinho->minimo_produto_venda;?>-<?php echo $row_listar_carrinho->id;?>" value="format<?php echo $count;?>" style="width:30px; height:30px; border:0px; border-radius:7px; background:#39F; text-align:center; line-height:30px">+</button> 
			
            </td>
                <td><input readonly="readonly"  style="margin-left:10px; margin-right:10px; height:35px; width:85px; border:0px; text-align:center" name="valortotal<?php echo $count;?>" value="<?php echo 'R$ '.number_format($row_listar_carrinho->valor_total,2,',','.');?>"  /></td>
              </tr>
              <tr class="product-action-row">d
                <td colspan="4" class="clearfix"><div class="float-left"> <a href="#" class="btn-move"></a> </div>
                  
                  <!-- End .float-left -->
                  
                  <div class="float-right">
                      <a href="../carrinho/carrinho.php?DelCart=<?php echo $row_listar_carrinho->id;?>" class="btn-remove" title="Remover Produto"><i class="icon-cancel"></i></a>




                    <!-- <a href="../../model/carrinho/carrinho.php?del=<?php echo $row_listar_carrinho->id;?>" title="Remover Produto" class="btn-remove"><span class="sr-only">Remover</span></a> </div> -->
                  
                  <!-- End .float-right --></td>
              </tr>
              <?php }else{ 
              $count++; ?>
              <tr class="product-row">
                <td class="product-col"><figure class="product-image-container"><img src="../../Painel/imagens/produtos/<?php echo $row_listar_carrinho->imagem;?>" alt="<?php echo $row_listar_carrinho->nome_produto;?>">  </figure>
                  <h2 class="product-title"> <?php echo $row_listar_carrinho->nome_produto;?><?php if ($row_listar_carrinho->minimo_produto_venda != 1){ echo '<BR/><span style="font-size:9px;color:red">Vendido apenas por multiplos de '.$row_listar_carrinho->minimo_produto_venda.' unidades!</span>';}?> </h2></td>
                <td><input readonly="readonly" style="margin-left:10px; margin-right:10px; height:15px; width:85px; border:0px; text-align:center" id="valorunit<?php echo $count;?>" class="<?php echo $row_listar_carrinho->id;?>" value="<?php echo 'R$ '.number_format($row_listar_carrinho->valor_unitario,2,',','.');?>" /> <br />+<br /> 
                <input readonly="readonly" style="margin-left:10px; margin-right:10px; height:15px; width:85px; border:0px; text-align:center" id="ST<?php echo $count;?>" class="<?php echo $row_listar_carrinho->id;?>" value="<?php echo 'ST R$ '.number_format($row_listar_carrinho->st_unitario,2,',','.');?>" /></td>
                <td><!-- <input class="vertical-quantity form-control" type="text" value="<?php echo $row_listar_carrinho->qtde;?>"> -->
                <button name="btn-mais" rel="<?php echo $row_listar_carrinho->minimo_produto_venda;?>-<?php echo $row_listar_carrinho->id;?>" value="format<?php echo $count;?>" style="width:30px; height:30px; border:0px; border-radius:7px; background:#39F; text-align:center; line-height:30px" >-</button>

             <input readonly="readonly" style="margin-left:1px; margin-right:1px; height:30px; width:30px; border:1px solid #666; border-radius:7px; text-align:center" data-id="result<?php echo $count;?>" rel="<?php echo $row_listar_carrinho->qtde;?>"  type="text" name="format<?php echo $count;?>" value="<?php  echo intval($row_listar_carrinho->qtde);?>" id="format<?php echo $count;?>" size="2" class="valorunit<?php echo $count;?> valortotal<?php echo $count;?>" />

            <button name="btn+mais" rel="<?php echo $row_listar_carrinho->minimo_produto_venda;?>-<?php echo $row_listar_carrinho->id;?>" value="format<?php echo $count;?>" style="width:30px; height:30px; border:0px; border-radius:7px; background:#39F; text-align:center; line-height:30px">+</button> 
			
            </td>
                <td><input readonly="readonly"  style="margin-left:10px; margin-right:10px; height:15px; width:85px; border:0px; text-align:center" name="valortotal<?php echo $count;?>" value="<?php echo 'R$ '.number_format($row_listar_carrinho->valor_total,2,',','.');?>"  /><br />+<br />	<input readonly="readonly"  style="margin-left:10px; margin-right:10px; height:15px; width:85px; border:0px; text-align:center" name="STTotal<?php echo $count;?>" value="<?php echo 'ST R$ '.number_format($row_listar_carrinho->st_unitario * $row_listar_carrinho->qtde,2,',','.');?>"  /></td>
              </tr>
              <tr class="product-action-row">
                <td colspan="4" class="clearfix"><div class="float-left"> <a href="#" class="btn-move"></a> </div>
                  
                  <!-- End .float-left -->
                  
                  <div class="float-right"><a href="../../model/carrinho/carrinho.php?del=<?php echo $row_listar_carrinho->id;?>" title="Remover Produto" class="btn-remove"><span class="sr-only">Remover</span></a> </div>
                  
                  <!-- End .float-right --></td>
              </tr>
              <?php }} ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4" class="clearfix"><div class="float-left"><!--  <a href="" onclick='javascript:history.go(-1);' class="btn btn-outline-secondary">Continue Comprando</a> --> <input type="button" class="btn btn-outline-secondary" value="Continuar Comprando" onclick="history.go(-2)" /> </div>
                  
                  <!-- End .float-left -->
                  
                  
                  
                  <!-- End .float-right --></td>
              </tr>
            </tfoot>
          </table>
        </div>
        
      </div>
      <!-- End .col-lg-8 --> 
      
      <div class="col-lg-12">
        <div class="cart-summary">
          <h3>Resumo</h3>
          
          
          
          <div>
          <div class="row">  
          	<div class="col-lg-6">
            <div> Condição de Pagamento </div>	              
                <select onchange="cond_pgto(this.value)" id="cond_pagamento" name="cond_pagamento" class="" style="width: 100%;" >                 	
                  <?php
				 if(!empty($_SESSION['cond_pgto'])){ ?> 
				<option selected="selected" value="<?php echo $_SESSION['cond_pgto']; ?>"><?php echo $_SESSION['nome_cond_pgto']; ?></option> 
				 <?php } 
				 	while ($CondPgto = $sql_condpgto->fetch()){?>
               <option value="<?php echo $CondPgto->COD_COND_PGTO; ?>"><?php echo $CondPgto->NOME_COND_PGTO; ?></option>
                  <?php } ?>
                </select>
            </div>
            <div class="col-lg-6">	
            <div> Forma de Pagamento </div>              
                <select onchange="forma_pgto(this.value)" id="forma_pagamento" name="forma_pagamento" class="" style="width: 100%;" >                 	
                  <?php
				 if(!empty($_SESSION['forma_pgto'])){ ?> 
				<option selected="selected" value="<?php echo $_SESSION['forma_pgto']; ?>"><?php echo $_SESSION['nome_forma_pgto']; ?></option> 
				 <?php } 
				 	while ($FormadPgto = $sql_formapgto->fetch()){?>
               <option value="<?php echo $FormaPgto->COD_FORMA_PGTO; ?>"><?php echo $FormaPgto->NOME_FORMA_PGTO; ?></option>
                  <?php } ?>
                </select>
            </div>
            </div>
           <div id="atualizaParcelas" style="max-height:500px;">
           <?php include 'tabela-pct.php'; ?>     
           </div>     
          </div>
         
          <!--<div class="checkout-methods"> <a href="checkout-shipping.html" class="btn btn-block btn-sm btn-primary">Go to Checkout</a> <a href="#" class="btn btn-link btn-block">Check Out with Multiple Addresses</a> </div>
           End .checkout-methods --> 
        </div>
        <!-- End .cart-summary --> 
      </div>
      <!-- End .col-lg-4 --> 
    </div>
    <!-- End .row --> 
  </div>
  <!-- End .container -->
  
  <div class="mb-6"></div>
  <!-- margin --> 
</main>