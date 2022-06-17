<?php 
session_start();

include '../../../config.php';
include '../../../conexao-pdo/conexao-mysql-pdo.php';

if (empty($_SESSION['id_do_cliente'])){
	?>
    	<script type="application/javascript">
			alert("É necessário estar logado!");
		</script>
    <?php
	header ('location: '.$http);
}
			
		$sha1 = 1;
		$codCliente = $_SESSION['id_do_cliente'];
		
		$SQL_dados_pedido = "SELECT a.id, date_format(a.data_pedido, '%d/%m/%Y as %H:%i:%s') as data_pedido, a.valor_produtos, a.valor_frete, a.valor_total, date_format(a.data_entrega, '%d/%d/%Y as %H:%i:%s') as data_entrega FROM pedidos a WHERE a.SHA1 = :sha;";
		$SQL_dados_pedido = $pdo->prepare($SQL_dados_pedido);
		$SQL_dados_pedido->bindValue('sha',$sha1);
		$SQL_dados_pedido->execute();
		if ($SQL_dados_pedido->rowCount() > 0 ){
			$row_dados_pedido = $SQL_dados_pedido->fetch();
			echo 'tem registros';	
		}else{
			?>
            <script>
				alert('Número de pedido não encontrado em nossa base de dados!');
				var links = '<?php echo $http;?>/view/cliente/my-account/';
				window.location.href = links;
				</script>            
            <?php 
		}
/*
		
	$SQL_lista_produtos = "SELECT a.id_produto, b.nome_produto, a.valor_unitario, a.qtde, a.valor_total FROM carrinho a INNER JOIN produtos b ON a.id_produto = b.id WHERE a.SHA1=:sha1;";
		$SQL_lista_produtos = $pdo->prepare($SQL_lista_produtos);
		$SQL_lista_produtos->bindValue('sha1',$sha1);
		$SQL_lista_produtos->execute();		
		
		
		
		$row_dados = $SQL_lista_produtos->fetch();*/
	/* FIM - LISTAR DADOS DO CLIENTE LOGADO */
?>
<div class="container">
  <div class="row">
    
    <!-- End .col-lg-9 -->
    
    <aside class="col-lg-3">
      <div class="widget widget-dashboard">
        <?php
			require_once "menu.php";
		?>
      </div>
      <!-- End .widget --> 
    </aside>
    <div class="col-lg-9">
      <h2>Meus Dados</h2>
      <form name="form1" action="/Leal-Dutra/model/cliente/cliente.php?edt='1'" method="post">
        <div class="container">
          <div class="row">
            <div class="col-lg-3">
              <label>Número do Pedido</label>
              </div>
            <div class="col-lg-9">
              <strong><?php echo $row_dados_pedido->id;?></strong>
            </div>
            <div class="col-lg-3">
              <label>Data da Compa</label>
              </div>
            <div class="col-lg-9">
              <strong>numero</strong>
            </div>
            <div class="col-lg-3">
              <label>Valor Produto</label>
              </div>
            <div class="col-lg-9">
              <strong>numero</strong>
            </div>
            <div class="col-lg-3">
              <label>Valor Frete</label>
              </div>
            <div class="col-lg-9">
              <strong>numero</strong>
            </div>
            <div class="col-lg-3">
              <label>Valor Total</label>
              </div>
            <div class="col-lg-9">
              <strong>numero</strong>
            </div>
            <div class="col-lg-3">
              <label>Data Entrega</label>
              </div>
            <div class="col-lg-9">
              <strong>numero</strong>
            </div>
           <h4>Lista dos Produtos</h4>
           
           <table class="table table-bordered table-striped">
 <thead>
  <tr style="font-size:11px; line-height:17px; color:#999999; background:#33346E">
    <td>Nº</td>
    <td>CÓD. PRODUTO</td>
    <td>PRODUTO</td>
    <td>VALOR UNITÁRIO</td>
    <td>QTDE</td>
    <td>VALOR TOTAL</td>
  </tr>
  </thead>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td> 
  </tr>
</table>

          </div>
        </div>
      </form>
    </div><!-- End .col-lg-3 --> 
  </div>
  <!-- End .row --> 
</div>
<!-- End .container --> 
