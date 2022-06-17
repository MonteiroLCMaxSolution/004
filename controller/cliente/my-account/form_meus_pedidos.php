<?php 
//session_start();


$idCliente = $_SESSION['id_do_cliente'];

/*ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);*/


require_once '../../../conexao-pdo/config.php';
require_once '../../../conexao-pdo/conexao-mysql-pdo.php';


$SQL_listar_pedidos = "SELECT a.cod_cond_pgto,a.cod_forma_pgto,a.SHA1, a.status,a.id, date_format(a.data_pedido, '%d/%m/%Y as %H:%i:%s') as datapedido,a.valor_produtos, a.valor_frete, a.itens, a.valor_total, a.desconto, a.valor_extra,date_format(a.data_entrega, '%d/%m/%Y as %H:%i:%s') as dataentrega, b.CEP, b.COD_UF, b.COD_CIDADE, b.BAIRRO, b.ENDERECO, b.ENDERECO_NUMERO, b.ENDERECO_COMP, c.NOME_COND_PGTO, d.NOME_FORMA_PGTO FROM pedidos a 
LEFT JOIN cliente b on
a.id_cliente = b.cod_cliente
LEFT JOIN condicaopagamento c on
a.cod_cond_pgto = c.COD_COND_PGTO and
b.COD_EMPRESA = c.COD_EMPRESA
LEFT JOIN formapagamento d on
a.cod_forma_pgto = d.COD_FORMA_PGTO and
b.COD_EMPRESA = d.COD_EMPRESA
WHERE a.id_cliente = :idCliente;";
$SQL_listar_pedidos = $pdo->prepare($SQL_listar_pedidos);
$SQL_listar_pedidos->bindValue('idCliente',$idCliente);
$SQL_listar_pedidos->execute();

/*$SQL_listar_pedido = "SELECT date_format(a.data_pedido, '%d/%m/%Y as %H:%i:%s') as datapedido,a.valor_produtos, a.valor_frete, a.itens, a.valor_total, date_format(a.data_entrega, '%d/%m/%Y as %H:%i:%s') as dataentrega FROM pedidos a WHERE a.id_cliente = :idCliente;";
$SQL_listar_pedido = $pdo->prepare($SQL_listar_pedido);
$SQL_listar_pedido->bindValue('idCliente',$idCliente);
$SQL_listar_pedido->execute(); */

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
      <h2>Meus Pedidos</h2>
      
    <? 
 //include_once('../../../model/cliente/cliente.php');
 while($row_pedido_cliente = $SQL_listar_pedidos->fetch()){ ?>
 <div class="cart-inner-box" style="background: #f5f5f5;">
 	<div class="cart-inner-box box-2 text-center">
                	<div class="order-summary ci-title">
                         <h4>
                                <a data-toggle="collapse" href="#pedido-order-cart-section<?php echo $row_pedido_cliente->id; ?>" class="collapsed" role="button" aria-expanded="false" aria-controls="order-cart-section"><span> Pedido: <strong><?php echo $row_pedido_cliente->id; ?></strong></span> ---- <span>Valor total: <strong>R$ <?php echo number_format($row_pedido_cliente->valor_total,2,',','.'); ?> </strong></span></a>
                         </h4>
                    </div>
                     <div class="collapse" id="pedido-order-cart-section<?php echo $row_pedido_cliente->id; ?>">
                        <ul>
                        <?php
					$SQL_PEDIDO_ITEM = "SELECT T1.id_produto,T2.nome_produto, T1.SHA1, T1.valor_unitario, T1.qtde, 		T1.valor_total, ifnull(T3.imagem,'no-photo.png') as imagem from pedido_item T1
					LEFT JOIN produtos T2 on
					T1.id_produto = T2.cod_produto
					LEFT JOIN imagens T3 on
					T1.id_produto = T3.cod_produto
					where  T1.SHA1 = :SHA
					ORDER BY T1.id DESC";
					$SQL_PEDIDO_ITEM = $pdo->prepare($SQL_PEDIDO_ITEM);
					$SQL_PEDIDO_ITEM->bindValue('SHA',$row_pedido_cliente->SHA1);
					$SQL_PEDIDO_ITEM->execute();
						?>
                         <div class="order-summary">
                           <!-- <h3>RESUMO</h3> -->
                            	 <h4>
                                <a data-toggle="collapse" href="#order-cart-section<?php echo $row_pedido_cliente->id; ?>" class="collapsed" role="button" aria-expanded="false" aria-controls="order-cart-section">PRODUTOS COMPRADOS</a>
                            </h4>
                        <?php while($row_pedido_item = $SQL_PEDIDO_ITEM->fetch()){ ?>
                          <div class="collapse" id="order-cart-section<?php echo $row_pedido_cliente->id; ?>">
                        	<li>  
                            <table width="100%" border="0">
  <tr>
    <th scope="col">   
    <a target="_blank" href=""><figure><img class="acc-order-product-image" src="<?php echo $http; ?>/Painel/imagens/produtos/<?php echo $row_pedido_item->imagem;?>" width="50px" alt="<?php echo $row_pedido_item->nome_produto;?>"></figure></a>
    </th>
    <th scope="col"><?php echo $row_pedido_item->nome_produto; ?>
    </th>
    <th scope="col"><span><strong><?php echo 'Quant.: '.$row_pedido_item->qtde.' - Val. Total: R$'.$row_pedido_item->valor_total; ?></strong></span>
    </th>
  </tr>
</table>

    					   </li>
                           </div>
                           <?php } ?>
                            </div>
                             <li>
                             <table width="100%" border="0">
  <tr>
    <td width="40%">    
                	<div class="">
                    	<div style="padding-bottom:15px;" class="">
                           <p class="title" align="center"> <strong>Pagamento <br /> </strong> </p>
                        </div>
                        <div>
                        Condição de Pagamento: <strong><?php echo $row_pedido_cliente->NOME_COND_PGTO; ?></strong><br />
                        Forma Pagamento: <strong><?php echo $row_pedido_cliente->NOME_FORMA_PGTO; ?></strong><br />
                        Status: <strong><?php echo $row_pedido_cliente->status; ?></strong><br /> 
	                    </div>
    			   </div>
   </td>
    <td width="40%">  
 <div class="">
            		<div style="padding-bottom:15px;" class="">
                    	 <p class="title" align="center"> <strong>Endereço Entrega <br /> </strong> </p>
             	    </div>
                    <div>
                    <p>
                     <?php echo $row_pedido_cliente->ENDERECO; ?>, <?php echo $row_pedido_cliente->ENDERECO_NUMERO; ?><br>
                     <?php echo $row_pedido_cliente->BAIRRO; ?> - <?php echo $row_pedido_cliente->COD_CIDADE.', '.$row_pedido_cliente->COD_UF; ?><br>
                     CEP: <?php echo $row_pedido_cliente->CEP; ?>
                     <?php echo $row_pedido_cliente->ENDERECO_COMP; ?> <br>
                    </p>
                    </div>
  </div>
    </td>
    <td width="20%"> 
  <div class="">
               		<div style="padding-bottom:15px;" class="">
                        <p class="title" align="center"> <strong>Valor Total <br /> </strong> </p>
                    </div>
                    <div class="">
                    	<p></p>
                    	<p class="">
                        Subtotal
                        <span>R$ <?php echo $row_pedido_cliente->valor_produtos; ?></span><br />
                        <?php if (!empty($row_pedido_cliente->desconto)){ ?>
                        Desconto
                        <span>R$ <?php echo $row_pedido_cliente->desconto; ?></span><br />
                        <?php }else {} ?>
                         <?php if (!empty($row_pedido_cliente->valor_extra)){ ?>
                        Taxa
                        <span>R$ <?php echo $row_pedido_cliente->valor_extra; ?></span><br />
                         <?php }else {} ?>
                        Total
                        <span>R$ <?php echo $row_pedido_cliente->valor_total; ?></span><br />
                        </p>
                    </div>
 </div>
  </td>
  </tr>
</table>
                             </li>
                            <li><span></span></li>
                        </ul>
                    </div>
                   <!-- <div class="ci-btn">
                        <a href="checkout.html" class="btn btn-primary btn-block rounded-0">Proceed to Checkout</a>
                    </div> -->
                </div>
                </div>
                <br />
           
 <?php } ?>

    </div><!-- End .col-lg-3 --> 
  </div>
  <!-- End .row --> 
</div>
<!-- End .container --> 
