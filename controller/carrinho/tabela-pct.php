
<?php 
include_once ('../../model/carrinho/carrinho.php');
//echo 'teste';
//echo '<br /> '.$_SESSION['cond_pgto'];
	?>
<?php
$desconto = 0; 
$acrescimo = 0;
if ($_SESSION['cond_pgto'] == 1){ 
	$desconto = '0.03';
	$desconto = $valorTotalCarrinho * $desconto; 
}
if ($_SESSION['cond_pgto'] == 19){
	$acrescimo = '0.04';
	$acrescimo = $valorTotalCarrinho * $acrescimo;	
}
?>    
    
<!--<main class="main">
  
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div style="padding-top:20px; padding-bottom:20px">
        <table width="100%" border="1">
  <tr>
    <th scope="col">Nº Parc.</th>
    <th scope="col">Data Pag.</th>
    <th scope="col">R$ Parc.</th>
  </tr>
   <?php while ($row_parcelas = $sql_parcelas->fetch()){ ?>
  <tr>
    <td><?php echo $row_parcelas->Num_parcela; ?></td>
    <td><?php echo date('d/m/Y', strtotime($row_parcelas->qtd_dias_parcela.' days'));?></td>
     <?php 		
				
	$valor_parcela = $valorTotalFinanceiro * ($row_parcelas->pct_mercadoria / 100);
	$valor_parcela = ($totais - $desconto + $acrescimo) * ($row_parcelas->pct_mercadoria / 100);
				?>
    <td><?php echo number_format($valor_parcela,2,',','.'); ?></td>
  </tr>
  <?php } ?>
</table>
</div>

      </div>
    </div>
  </div>
</main>-->


 <table class="table table-totals">
            <tbody>
            <tr>
                <td>Forma de Pagamento</td>
                <td><div id="forma_pagamento"><?php echo $_SESSION['nome_forma_pgto'];?></div></td>
              </tr>
              <tr>
                <td>Subtotal</td>
                <td><div id="subtotal"><?php echo 'R$ '.number_format($valorTotalCarrinho,2,',','.');?></div></td>
              </tr>
              <tr>
                <tr>
                <td>ST Total</td>
                <td><div id="st_total"><?php echo 'R$ '.number_format($stTotalCarrinho,2,',','.');?></div></td>
              </tr>
              <tr>
              <!--  <td>Desconto</td> -->
                <div id="descontoValor" style="max-height:500px;">    
           <?php
		    if ($_SESSION['cond_pgto'] == 1){ ?>
                  <div>
                  <td>Desconto</td>
                  <td><?php echo '3%';?></td>
                  </div>
                  <?php }else{ ?>
                  <div></div>
                  <?php	  } ?>
           <?php if ($_SESSION['cond_pgto'] == 19){ ?>
                  <div>
                  <td>Acréscimo</td>
                  <td><?php echo '4%'; ?></td>
                  </div>
                  <?php }else{ ?>
                  <div></div>
                  <?php	  } ?>
         	    </div>   
              <!--  <td>$0.00</td> -->
              </tr>
              
            </tbody>

            <tfoot>
              <tr>
                <td>Total do Pedido</td>
                <td><div id="vlrttalcarrinho"><?php echo 'R$ '.number_format($totais - $desconto + $acrescimo,2,',','.');?></div></td>
                <input type="text" id="valor_total" name="valor_total" value="<?php echo $totais;?>" hidden="hidden" />
              </tr>
             <tr>
			    <td>&nbsp;</td>
               <!-- <td><div id="maiorpedminimo">PASSOU 400,00</div></td> -->
               <td>
               <div id="finalizar">
               <?php include 'finalizar.php'; ?>
               </div>
              </td>
             </tr>
             <tr>
                <td>&nbsp;</td>
                <td></td>
             </tr>
            </tfoot>
          </table>

  