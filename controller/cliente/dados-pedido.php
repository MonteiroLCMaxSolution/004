<?php
/* Criado por Leônidas Monteiro - dados do pedido - 07/03/2020 */
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
$exibirDados = $SQL_exibir_dados->fetch();
?>

<h3 class="widget-title">Minha Conta</h3>
<div class="row">
  <div class="col-lg-3">
    <ul class="list">
      <li class="active"><a href="?pg=dados_cliente">Dados Cliente</a></li>
      <?php
            if (!empty($_SESSION['nome_do_cliente'])){?>
      <li><a href="?pg=meus-pedidos">Pedido</a></li>
      <?php } ?>
    </ul>
  </div>
  <div class="col-lg-9">
    <div class="container">
      <h2>Dados do Pedido</h2>
      <div class="row">
        <div class="col-lg-12">
        	<div style="border:1px solid #666; border-radius:7px; padding:3px; margin-bottom:5px">
            	<div class="row">
                	<div class="col-lg-3">
                    	<span>Cód. Produto</span>
                    </div>
                    <div class="col-lg-9">
                    	<strong><?php echo $exibirDados->id;?></strong>
                    </div>
                    <div class="col-lg-3">
                    	<span>Data da Compra</span>
                    </div>
                    <div class="col-lg-9">
                    	<strong><?php echo $exibirDados->data_pedido;?></strong>
                    </div>
                    <div class="col-lg-3">
                    	<span>Itens</span>
                    </div>
                    <div class="col-lg-9">
                    	<strong><?php echo (int)$exibirDados->itens;?></strong>
                    </div>
                    <div class="col-lg-3">
                    	<span>Valor da Compra</span>
                    </div>
                    <div class="col-lg-9">
                    	<strong><?php echo 'R$ '.number_format($exibirDados->valor_produtos,2,',','.');?></strong>
                    </div>
                    <div class="col-lg-3">
                    	<span>Desconto</span>
                    </div>
                    <div class="col-lg-9">
                    	<strong><?php echo 'R$ '.number_format($exibirDados->desconto,2,',','.');?></strong>
                    </div>
                    <div class="col-lg-3">
                    	<span>Valor a Pagar</span>
                    </div>
                    <div class="col-lg-9">
                    	<strong><?php echo 'R$ '.number_format($exibirDados->valor_total,2,',','.');?></strong>
                    </div>
                    <div class="col-lg-3">
                    	<span>Dias</span>
                    </div>
                    <div class="col-lg-9">
                    	<strong><?php echo $exibirDados->condicao;?></strong>
                    </div>
                    <div class="col-lg-3">
                    	<span>Forma de Pagamento</span>
                    </div>
                    <div class="col-lg-9">
                    	<strong><?php echo $exibirDados->cod_forma_pgto;?></strong>
                    </div>
                    <div class="col-lg-3">
                    	<span>Condições de Pagamento</span>
                    </div>
                    <div class="col-lg-9">
                    	<strong><?php echo $exibirDados->cod_cond_pgto;?></strong>
                    </div>
                    <div class="col-lg-3">
                    	<span>Status do Pedido</span>
                    </div>
                    <div class="col-lg-9">
                    	<strong><?php echo $exibirDados->status;?></strong>
                    </div>
                    <div class="col-lg-3">
                    	<span>Data da Entrega</span>
                    </div>
                    <div class="col-lg-9">
                    	<strong><?php echo $exibirDados->data_entrega;?></strong>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped">
          <tr>
            <th scope="col">Nº</th>
            <th scope="col">Imagem</th>
            <th scope="col">Cód. Produto</th>
            <th scope="col">Nome Produto</th>
            <th scope="col">R$ Unit.</th>
            <th scope="col">Itens</th>
            <th scope="col">R$ Total</th>
          </tr>
          <?php
		  $count = 1;
		  while ($listaProdutos = $SQL_list_prod->fetch()){?>
          <tr>
            <td><?php echo $count++;?></td>
            <td><img src="../3E_Comercial/Painel/imagens/produtos/<?php echo $listaProdutos->imagem;?>" width="50px" /></td>
            <td><?php echo $listaProdutos->id_produto;?></td>
            <td><?php echo $listaProdutos->nome_produto;?></td>
            <td><?php echo 'R$ '.number_format($listaProdutos->valor_unitario,2,',','.');?></td>
            <td><?php echo (int)$listaProdutos->qtde;?></td>
            <td><?php echo 'R$ '.number_format($listaProdutos->valor_total,2,',','.');?></td>
          </tr>
          <?php } ?>
        </table>

      </div>
    </div>
  </div>
</div>
