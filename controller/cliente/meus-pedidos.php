<?php
/* Criado por Leônidas Monteiro - listar os pedidos - 06/03/2020 */
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
if(empty($_SESSION['id_do_cliente'])){
		?>
        <script>
			var links = '<?php echo $http;?>';
			window.location.href = links;
		</script>
        <?php
		
	}
require_once 'model/carrinho/carrinho.php';
?>

<h3 class="widget-title">Minha Conta</h3>
<div class="row">
  <div class="col-lg-3">
    <ul class="list">
      <li class="active"><a href="?pg=dados_cliente">Meus Dados</a></li>
      <?php
            if (!empty($_SESSION['nome_do_cliente'])){?>
      <li><a href="?pg=meus-pedidos">Meus Pedidos</a></li>
      <?php } ?>
    </ul>
  </div>
  <div class="col-lg-9">
    <div class="container">
      <h2>Meus Pedidos</h2>
      <div class="row">
        <table class="table table-bordered table-striped">
          <tr style="font-size:12px; text-align:center">
            <th >Nº</th>
            <th>Cód. Pedido</th>
            <th>Data Compra</th>
            <th>Itens</th>
            <th>Valor Compra</th>
            <th>Desconto</th>
            <th>Valor Total</th>
            <th>Data Entrega</th>
            <th>Ver</th>
          </tr>
          <?php $count = 1; while($row_listar_pedidos = $SQL_listar_pedidos->fetch()){?>
          <tr  style="font-size:10px; text-align:center">
            <td><?php echo $count++;?></td>
            <td><?php echo $row_listar_pedidos->id;?></td>
            <td><?php echo $row_listar_pedidos->data_pedido;?></td>
            <td><?php echo $row_listar_pedidos->itens;?></td>
            <td><?php echo 'R$ '.number_format($row_listar_pedidos->valor_produtos,2,',','.');?></td>
            <td><?php echo 'R$ '.number_format($row_listar_pedidos->desconto,2,',','.');?></td>
            <td><?php echo 'R$ '.number_format($row_listar_pedidos->valor_total,2,',','.');?></td>
            <td><?php echo $row_listar_pedidos->STATUS;?></td>
            <td><a href="?pg=dados-pedido&dadosPedido=<?php echo $row_listar_pedidos->SHA1;?>"><img src="../3E_Comercial/img/check.png" width="36" height="36" /></a></td>
          </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
</div>
