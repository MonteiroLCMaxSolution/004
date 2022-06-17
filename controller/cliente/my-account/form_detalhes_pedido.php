<?php 
//session_start();

require_once '../../../config.php';
require_once '../../../conexao-pdo/conexao-mysql-pdo.php';
$idCliente = $_GET['idProduto'];
$SQL_listar_pedidos = "SELECT a.id, ifnull(d.imagem,'no-photo.png') AS imagem, b.id_produto, c.nome_produto, a.`status`, a.valor_produtos, ifnull(a.valor_frete,0) AS valor_frete, a.itens, a.valor_total  FROM pedidos a
INNER JOIN carrinho b ON a.SHA1 = b.SHA1
INNER JOIN produtos c ON b.id_produto = c.cod_produto
LEFT JOIN imagens d ON c.cod_produto = d.cod_produto
 WHERE a.SHA1 = :sha GROUP BY a.SHA1;";
$SQL_listar_pedidos = $pdo->prepare($SQL_listar_pedidos);
$SQL_listar_pedidos->bindValue('sha',$idCliente);
$SQL_listar_pedidos->execute();

$SQL_dados = "SELECT a.id,date_format(a.data_pedido, '%d/%m/%Y as %H:%i:%s') AS datapedido, ifnull(d.imagem,'no-photo.png') AS imagem, b.id_produto, c.nome_produto, a.`status`, a.valor_produtos, ifnull(a.valor_frete,0) AS valor_frete, a.itens, a.valor_total  FROM pedidos a
INNER JOIN carrinho b ON a.SHA1 = b.SHA1
INNER JOIN produtos c ON b.id_produto = c.cod_produto
LEFT JOIN imagens d ON c.cod_produto = d.cod_produto
 WHERE a.SHA1 = :sha GROUP BY a.SHA1;";
$SQL_dados = $pdo->prepare($SQL_dados);
$SQL_dados->bindValue('sha',$idCliente);
$SQL_dados->execute();
if ($SQL_dados->rowCount() > 0){
	$row_dados = $SQL_dados->fetch();
}


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
    
    <aside class="col-lg-3">
      <div class="widget widget-dashboard">
        <span>Cód. Pedido: </span> <strong><?php echo $row_dados->id;?></strong><BR/>
        <span>Data do Pedido: </span> <strong><?php echo $row_dados->datapedido;?></strong><BR/>
        <span>Valor Pedido: </span> <strong><?php echo 'R$ '.number_format($row_dados->valor_produtos,2,',','.');?></strong><BR/>
        <span>Frete: </span> <strong><?php echo 'R$ '.number_format($row_dados->valor_frete,2,',','.');?></strong><BR/>
        <span>Valor Total: </span> <strong><?php echo 'R$ '.number_format($row_dados->valor_total,2,',','.');?></strong><BR/>
      </div>
      <!-- End .widget --> 
    </aside>
    <div class="col-lg-9">
      <h2>Produtos do Pedido</h2>
      
      <table class="table table-bordered table-striped">
  		<thead>
          <tr style="font-size:11px; line-height:17px; color:#999999; background:#33346E">
            <td style="text-align:center">Nº</td>
            <td style="text-align:center">IMAGEM</td>
            <td style="text-align:center">CÓD. PRODUTO</td>
            <td>PRODUTO</td>
            <td style="text-align:center">VALOR PRODUTOS</td>
            <td style="text-align:center">QTDE</td>
            <td style="text-align:center">VALOR TOTAL</td>
          </tr>
  		</thead>
  <?php
  	$count = 1;
  	while ($row_listar_pedido = $SQL_listar_pedidos->fetch()){?>
  <tr>
    <td style="text-align:center"><?php echo $count++;?></td>
    <td style="text-align:center"><img src="../../../Painel/imagens/produtos/<?php  echo $row_listar_pedido->imagem;?>" width="40" height="32" /></td>
    <td style="text-align:center"><?php echo $row_listar_pedido->id_produto;?></td>
    <td><?php echo $row_listar_pedido->nome_produto;?></td>
    <td style="text-align:center"><?php echo 'R$ '.number_format($row_listar_pedido->valor_produtos,2,',','.');?></td>
    <td style="text-align:center"><?php echo intVal($row_listar_pedido->itens);?></td>
    <td style="text-align:center"><?php echo 'R$ '.number_format($row_listar_pedido->valor_total,2,',','.');?></td>
    
  </tr>
  <?php } ?>
  
</table>
<?php
if ($SQL_listar_pedidos->rowCount() == 0){?>
<div class="col-lg-12 bg-danger" style="text-align:center; color:#FFF">Poxa, você ainda não comprou conosco?<BR/> Não deixe de aproveitar nossos preços...</div>
<?php } ?>

    </div><!-- End .col-lg-3 --> 
  </div>
  <!-- End .row --> 
</div>
<!-- End .container --> 

