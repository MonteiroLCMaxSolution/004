<?php 
/*$row_promocao = $consulta_promocao->fetch();
if(empty($row_promocao)){
}else{*/

?>
 <h2 class="title text-center">Promoções</h2>

                <div class="products-carousel owl-carousel owl-theme owl-nav-top">
                

				<?php 
				while($row_promocao = $consulta_promocao->fetch()){
					
				$filename = $http.'/Painel/imagens/produtos/'.$row_promocao->imagem;

				if (file_exists($filename)) {
					$imagem = $row_promocao->imagem;
				} else {
					$imagem = 'no-photo.png';
				}
					
					 ?>
                    <div class="product">
                    <figure style="height:100%" class="product-image-container"> <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_promocao->codProduto;?>" class="product-image"> <img src="<?php echo $http; ?>/Painel/imagens/produtos/<?php echo $row_promocao->imagem;?>" alt="<?php echo 'Visualizado: '.$row_promocao->visualizado;?>" title="<?php echo 'Visualizado: '.$row_promocao->visualizado;?>"> </a> <a href="<?php echo $http;?>/ajax/product-quick-view.php?codProduto=<?php echo $row_promocao->codProduto;?>" class="btn-quickview">Olhada Rápida</a> </figure>
                        <div class="product-details">
                                <div class="ratings-container">
                                    <div class="product-ratings">
                                        <span class="ratings" style="width:80%"></span><!-- End .ratings -->
                                    </div><!-- End .product-ratings -->
                                </div><!-- End .product-container -->
                                <h2 class="product-title">
                                    <a href="<?php echo $http; ?>view/dados-produto?codProduto=<?php echo $row_promocao->codProduto;?>"><?php echo $row_promocao->codProduto.' - '.$row_promocao->nome_produto;?></a>
                                </h2>
                                <div class="price-box">
                                    <span class="product-price">
									<?php if(!empty($idCliente)){
										  if ($row_promocao->valor_promocao > 0 ){?>
											  <span class="old-price">De:
											  <?php  echo 'R$ '.number_format($row_promocao->valorProduto,2,',','.');?>
											  </span> <span class="product-price">Por:
											  <?php  echo 'R$ ';?>
											  <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px;color:#F00" value="<?php  echo number_format($row_promocao->valor_promocao,2,',','.');?>" />
											  </span>
											  <?php }else{?>
											  <span class="product-price">
											  <?php  echo 'R$ ';?>
											  <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px;" value="<?php  echo number_format($row_promocao->valorProduto,2,',','.');?>" />
											  </span>
											  <?php }
										  }?>
                                    </span>
                                </div><!-- End .price-box -->

                                <div class="product-action">
                                    <!--<a href="#" class="paction add-wishlist" title="Add to Wishlist">
                                        <span>Add to Wishlist</span>
                                    </a>-->
									<?php if(!empty($_SESSION['id_do_cliente'])){ ?>
                                       <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_promocao->codProduto;?>" class="paction add-cart" title="Adicionar ao Carrinho"> <span>Comprar</span> </a></div>
                                       <?php }else { ?>
                                       <div class="product-action"><a href="#" class="login-link paction add-cart" title="Clique aqui para logar"> <span>Ver Preço</span> </a> </div>
                                       <?php } ?>
                                    
                                </div><!-- End .product-action -->
                            </div><!-- End .product-details -->
                    </div><!-- End .product --> 
                    <br />
                    <?php } ?>
                </div><!-- End .featured-proucts -->
                
                <?php //} ?>