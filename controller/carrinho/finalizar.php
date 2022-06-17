 <?php 
 include_once ('../../model/carrinho/carrinho.php');
 
 //echo $row_num_parcelas->parcelas;
 
// $valorTotalCarrinho
$valorParcela = ($valorTotalFinanceiro/$row_num_parcelas->parcelas);
//echo $valorParcela.' - '.$valorTotalFinanceiro;
	if($valorParcela >= 300){
 ?>
 
 <div id="maiorpedminimo" class="paction add-cart"><a href="<?php echo $http; ?>/model/carrinho/carrinho.php?carrinho=<?php echo $_SESSION['sha_carrinho'];?>">Finalizar</a></div>
 
 <?php }else{ ?>
 
 <div id="menorpedminimo">Parcela Minima de 300,00</div>
 
 <?php } ?>