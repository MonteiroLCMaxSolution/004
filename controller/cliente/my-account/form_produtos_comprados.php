<?php 
//session_start();

require_once '../../../conexao-pdo/config.php';
require_once '../../../conexao-pdo/conexao-mysql-pdo.php';
$SQL_listar_produto = "SELECT a.id, b.id_produto, SUM(b.qtde) AS qtde, SUM(b.valor_total) AS valorTotal, MAX(date_format(a.data_pedido, '%d/%m/%Y as %H:%i:%s')) AS dataPedido,
(SELECT nome_produto FROM produtos WHERE cod_produto = b.id_produto LIMIT 1) AS nomeProduto
 FROM pedidos a 
 INNER JOIN carrinho b ON a.SHA1 = b.SHA1
WHERE a.id_cliente = :IDCliente GROUP BY b.id_produto";
$SQL_listar_produto = $pdo->prepare($SQL_listar_produto);
$SQL_listar_produto->bindValue('IDCliente',$_SESSION['id_do_cliente']);
$SQL_listar_produto->execute();
if (empty($_SESSION['id_do_cliente'])){
	?>
    	<script type="application/javascript">
			alert("É necessário estar logado!");
		</script>
    <?php
	header ('location: '.$http);
}
?>
<div class="container">
  <div class="row">
    
    <!-- End .col-lg-9 -->
    
    <aside class="col-lg-12">
      <div class="widget widget-dashboard">
        <?php
			include "menu.php";
		?>
      </div>
      <!-- End .widget --> 
    </aside>
    <div class="col-lg-12">
      <h2>Produtos Comprados</h2>
      
      <table class="table table-bordered table-striped">
  <thead>
  <tr style="font-size:11px; line-height:17px; color:#ffff; background:#3E4095">
    <td style="text-align:center">Nº</td>
    <td>COD. PROD.</td>
    <td style="text-align:center">PRODUTO</td>
    <td style="text-align:center">VALOR GASTO</td>
    <td style="text-align:center">QTDE.</td>
    <td style="text-align:center">ÚLTIMA COMPRA</td>
  </tr>
  </thead>
	<?php 
	$count = 1;
	while($row_listar_produtos = $SQL_listar_produto->fetch()){?>
  <tr>
    <td style="text-align:center"><?php echo $count++;?></td>
    <td style="text-align:center"><?php echo $row_listar_produtos->id_produto;?></td>
    <td><?php echo $row_listar_produtos->nomeProduto;?></td>
    <td style="text-align:center"><?php echo 'R$ '.number_format($row_listar_produtos->valorTotal,2,',','.');?></td>
    <td style="text-align:center"><?php echo (int)$row_listar_produtos->qtde;?></td>
    <td style="text-align:center"><?php echo $row_listar_produtos->dataPedido;?></td>
  </tr>
  <?php } ?>
</table>

    </div><!-- End .col-lg-3 --> 
  </div>
  <!-- End .row --> 
</div>
<!-- End .container --> 
