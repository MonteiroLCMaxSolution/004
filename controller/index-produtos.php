

<h2 class="title text-center">Produtos do Dia</h2>
                <div class="row justify-content-center">
                
<?php //include_once ('../model/produtos/produtos.php');
$idCliente = '';
if(!empty($_SESSION['id_do_cliente'])){
	$idCliente = $_SESSION['id_do_cliente'];
}
	while ($row_listar_produtos = $SQL_listar_produtos->fetch()){
	$filename = $http.'/Painel/imagens/produtos/'.$row_listar_produtos->imagem;
	if (file_exists($filename)) {
		$imagem = 'no-photo.png';
	} else {
		$imagem = $row_listar_produtos->imagem;
	}
?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product">
                            <figure style="height:100%" class="product-image-container">
                                <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_listar_produtos->codProduto;?>" class="product-image"> <img src="<?php echo $http; ?>/Painel/imagens/produtos/<?php echo $row_listar_produtos->imagem;?>" alt="<?php echo 'Visualizado: '.$row_listar_produtos->visualizado;?>" title="<?php echo 'Visualizado: '.$row_listar_produtos->visualizado;?>"> 
                                </a> 
                                <a href="<?php echo $http;?>/ajax/product-quick-view.php?codProduto=<?php echo $row_listar_produtos->codProduto;?>" class="btn-quickview">Olhada Rápida</a> 
                            </figure>
                            <div class="product-details">
                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:80%"></span><!-- End .ratings -->
                                    </div><!-- End .product-ratings -->
                                </div><!-- End .product-container -->
                                <h2 class="product-title">
                                    <a href="<?php echo $http; ?>view/dados-produto?codProduto=<?php echo $row_listar_produtos->codProduto;?>"><?php echo $row_listar_produtos->codProduto.' - '.$row_listar_produtos->nome_produto;?></a>
                                </h2>
                                <div class="price-box">
                                    <span class="product-price">
									<?php if(!empty($idCliente)){
										  if ($row_listar_produtos->valor_promocao > 0 ){?>
									<span class="old-price">De:
											  <?php  echo 'R$ '.number_format($row_listar_produtos->valorProduto,2,',','.');?>
									 </span> 
                                    <span class="product-price">Por:
											  <?php  echo 'R$ ';?>
											  <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px;color:#F00" value="<?php  echo number_format($row_listar_produtos->valor_promocao,2,',','.');?>" />
									</span>
											  <?php }else{?>
									<span class="product-price">
											  <?php  echo 'R$ ';?>
											  <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px;" value="<?php  echo number_format($row_listar_produtos->valorProduto,2,',','.');?>" />
									</span>
											  <?php }
										  }?>
                                    </span>
                                </div><!-- End .price-box -->

                                <div class="product-action">
									<?php if(!empty($_SESSION['id_do_cliente'])){ ?>
                                       <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_listar_produtos->codProduto;?>" class="paction add-cart" title="Adicionar ao Carrinho"> <span>Comprar</span> </a>
                                       <?php }else { ?>
                                       <a href="?pg=login_cliente&codProduto=<?php echo $row_listar_produtos->cod_produto;?>" class="paction add-cart" title="Clique aqui para logar"> <span>Ver Preço</span> </a>
                                       <?php } ?>   
                                </div><!-- End .product-action -->
                                
                            </div><!-- End .product-details -->
                        </div><!-- End .product -->
                        </div>
                        <?php } ?>
                    </div><!-- End .col-lg-3 -->
                    

                    