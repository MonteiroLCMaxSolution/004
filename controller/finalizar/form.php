 <?php
 
/*ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); */
		
		$SHA_VENDA = $_GET['SHA_VENDA'];
		$SQL_pedido = $pdo->prepare("SELECT T1.id, T1.id_cliente, T1.status, T1.valor_produtos, T1.valor_frete, T1.valor_total, T1.itens, T1.cod_cond_pgto, T1.cod_forma_pgto, T2.NOME_COND_PGTO, T3.NOME_FORMA_PGTO, T4.RAZ_SOCIAL, T4.CEP, T4.COD_CIDADE, T4.COD_UF, T4.ENDERECO, T4.ENDERECO_NUMERO, T4.BAIRRO
				FROM pedidos T1 
				left join condicaopagamento T2 on
				T1.cod_cond_pgto = T2.COD_COND_PGTO and
				T1.cod_empresa = T2.COD_EMPRESA
				left join formapagamento T3 on
				T1.cod_forma_pgto = T3.COD_FORMA_PGTO and
				T1.cod_empresa = T3.COD_EMPRESA
				left join cliente T4 on
				T1.id_cliente = T4.COD_CLIENTE
		where T1.id_cliente = :id_cliente and 
		T1.cod_empresa = :cod_empresa
		order by T1.id DESC LIMIT 1");
		$SQL_pedido->bindValue('id_cliente',$_SESSION['id_do_cliente']);
		$SQL_pedido->bindValue('cod_empresa',$_SESSION['COD_EMPRESA_cliente']);
		$SQL_pedido->execute();
		$row_pedido = $SQL_pedido->fetch();
		
		$SQL_pedido_item = $pdo->prepare("SELECT d.minimo_produto_venda, a.id, a.id_produto, b.nome_produto, a.valor_unitario, a.qtde, a.valor_total, ifnull(c.imagem,'no-photo.png') as imagem FROM pedido_item a 
        INNER JOIN produtos b ON a.id_produto = b.cod_produto 
        LEFT JOIN imagens c ON a.id_produto = c.cod_produto
        INNER JOIN produtos_empresa d ON a.id_produto = d.cod_produto  AND d.cod_empresa = :cod_empresa
        where a.SHA1 = :sha GROUP BY b.nome_produto");
        $SQL_pedido_item->bindValue('sha',$SHA_VENDA);
        $SQL_pedido_item->bindValue('cod_empresa',$_SESSION['COD_EMPRESA_cliente']);
		$SQL_pedido_item->execute();		
		
 ?>
 
 <main class="main">
           <nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Carrinho de Compras</li>
        <li class="breadcrumb-item active" aria-current="page">Pedido Finalizado</li>
      </ol>
    </div>
    <!-- End .container --> 
  </nav>

            <div class="container">
            
              <!--  <ul class="checkout-progress-bar">
                    <li>
                        <span>Shipping</span>
                    </li>
                    <li class="active">
                        <span>Review &amp; Payments</span>
                    </li>
                </ul> -->
                
                
                <div class="row">
                    <div class="col-lg-4">
                        <div class="order-summary">
                            <h3>RESUMO</h3>

                            <h4>
                                <a data-toggle="collapse" href="#order-cart-section" class="collapsed" role="button" aria-expanded="true" aria-controls="order-cart-section">PRODUTOS COMPRADOS</a>
                            </h4>
   
   						  <?php while ($row_pedido_item = $SQL_pedido_item->fetch()){ ?>
                            <div class="collapse" id="order-cart-section">
                           
                                <table class="table table-mini-cart">
                                    <tbody>
                                        <tr>
                                            <td class="product-col">
                                                <figure class="product-image-container">
                                                    <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_pedido_item->id_produto;?>" class="product-image">
                                                        <img src="<?php echo $http;?>/Painel/imagens/produtos/<?php echo $row_pedido_item->imagem;?>" alt="product">
                                                    </a>
                                                </figure>
                                                <div>
                                                    <h2 class="product-title">
                                                        <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_pedido_item->id_produto;?>"><?php echo $row_pedido_item->nome_produto; ?></a>
                                                    </h2>

                                                    <span class="product-qty">Qtd: <?php echo $row_pedido_item->qtde; ?></span>
                                                </div>
                                            </td>
                                           
                                        </tr>
                                    </tbody>    
                                </table>
                               
                            </div><!-- End #order-cart-section -->
                           <?php  } ?>
                        </div><!-- End .order-summary -->

                        <div class="checkout-info-box">
                            <h3 class="step-title">Informações
                               <!-- <a href="#" title="Edit" class="step-title-edit"><span class="sr-only">Edit</span><i class="icon-pencil"></i></a> -->
                            </h3>

                            <address>
                                Condição de Pagamento: <?php echo $row_pedido->NOME_COND_PGTO; ?>  <br>
                               Forma de Pagamento: <?php echo $row_pedido->NOME_FORMA_PGTO; ?> <br>
                                Informações de Entrega: <br>
                                <?php echo $row_pedido->CEP; ?><br>
                                <?php echo $row_pedido->COD_CIDADE.' - '.$row_pedido->COD_UF; ?><br>
                                <?php echo $row_pedido->ENDERECO.' - '.$row_pedido->ENDERECO_NUMERO; ?>
                            </address>
                        </div><!-- End .checkout-info-box -->
                    </div><!-- End .col-lg-4 -->

                    <div class="col-lg-8 order-lg-first">
                        <div class="checkout-payment">
                        <div align="center"><img src="<?php echo $http; ?>/assets/images/finalizar-pedido.png" /> </div>
                            <h2 align="center" class="step-title">PEDIDO FINALIZADO COM SUCESSO</h2>

                            <h4 align="center">Número do seu pedido: <?php echo $row_pedido->id; ?> </h4>
                            
                            <div class="form-group-custom-control">             
                                    <div align="center"><label>Obrigado por comprar no nosso site.</label></div>
                            </div><!-- End .form-group -->
                            <div class="clearfix">
                                <a href="<?php echo $http; ?>" class="btn btn-primary float-right">Voltar a Comprar</a>
                            </div><!-- End .clearfix -->
                        </div><!-- End .checkout-payment -->
                    </div><!-- End .col-lg-8 -->
                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="mb-6"></div><!-- margin -->
        </main><!-- End .main -->