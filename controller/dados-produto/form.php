<?php

	include '../../model/produtos/produtos.php';
	if (!empty($SQL_dadosProduto)){
		$row_dados = $SQL_dadosProduto->fetch();
	}else{
		echo 'não achou produtos';
	}

/*ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);*/

?>

<div class="container">
  <div class="row">
    <div class="col-lg-9">
      <div class="product-single-container product-single-default">
        <div class="row">
          <div class="col-lg-7 col-md-6 product-single-gallery">
            <div class="product-slider-container product-item">
              <div class="product-single-carousel owl-carousel owl-theme">
                <?php
			  	while ($row_listar_imagens = $SQL_listar_imagens->fetch()){
					if (!empty($_GET['codProduto'])){
					$_SESSION['codprodutodados'] = $_GET['codProduto'];
					}
					 $filename = $http.'/Painel/imagens/produtos/'.$row_listar_imagens->imagem;
					 
				if (!file_exists($filename)) {
					$imagem = $row_listar_imagens->imagem;
				} else {
					//$imagem = $row_listar_imagens->imagem;
					$imagem = 'no-photo.png';
				}?>
                <div class="product-item"> <img class="product-single-image" src="../../Painel/imagens/produtos/<?php echo $imagem;?>" data-zoom-image="../../Painel/imagens/produtos/<?php echo $imagem;?>"/> </div>
                <?php
				}
			  ?>
              </div>
              <!-- End .product-single-carousel --> 
              <span class="prod-full-screen"> <i class="icon-plus"></i> </span> </div>
            <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
              <?php
				while ($row_listar_imagem = $SQL_listar_imagem->fetch()){
					 $filename1 = $http.'/Painel/imagens/produtos/'.$row_listar_imagem->imagem;

				if (!file_exists($filename1)) {
					$imagem1 = $row_listar_imagem->imagem;
				} else {
					$imagem1 = 'no-photo.png';
				}
					?>
              <div class="col-3 owl-dot"> <img src="../../Painel/imagens/produtos/<?php echo $imagem1;?>"/> </div>
              <?php } ?>
            </div>
          </div>
          <!-- End .col-lg-7 -->
          <div class="col-lg-5 col-md-6">
            <form action="../../model/carrinho/carrinho.php?grv='1'" method="post">
              <div class="product-single-details">
                <h1 class="product-title"><?php echo $row_dados->nome_produto;?></h1>
                <div class="ratings-container"> Códigoss:
                  <input name="codProduto" readonly="readonly" style="border: 0px" value="<?php echo $row_dados->cod_produto;?>" />
                  <!-- End .product-ratings --> 
                  
                  <a href="#" class="rating-link"></a> </div>
                <!-- End .product-container -->
                
                <div class="price-box">
                  <?php if (!empty($_SESSION['id_do_cliente'])){?>
                  <!------------ SE COD_EMPRESA = 1 TRAZER CAMPOS SEM ST --------------->
                 	 <?php if($_SESSION['COD_EMPRESA_cliente'] == 1) { ?>
                 		 <?php if ($row_dados->valor_promocao > 0 ){

						?>
                  <span class="old-price">De:
                  <?php  echo 'R$ '.number_format($row_dados->valor_prazo,2,',','.');?>
                  </span> <span class="product-price">Por:
                  <?php  echo 'R$ ';?>
                  <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px; color:#F00" value="<?php  echo number_format($row_dados->valor_promocao,2,',','.');?>" />
                  </span>
                  <?php }else{?>
                  <span class="product-price">
                  <?php  echo 'R$ ';?>
                  <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px" value="<?php  echo number_format($row_dados->valor_prazo,2,',','.');?>" />
                  </span>
                  <?php } ?>
                  <!------------ SE COD_EMPRESA = 2 TRAZER CAMPOS COM ST --------------->
                  <?php }else{ ?>
                  <?php if ($row_dados->valor_promocao > 0 ){
					  
				$Valor_venda = $row_dados->valor_promocao;
				
				$SQL_ST_med_pond = "SELECT * FROM produtos_empresa where cod_empresa = :cod_empresa and cod_produto = :cod_produto";
				$ST_med_pond = $pdo->prepare($SQL_ST_med_pond);
				$ST_med_pond->bindValue('cod_empresa', $_SESSION['COD_EMPRESA_cliente']);
				$ST_med_pond->bindValue('cod_produto', $_GET['codProduto']);
				$ST_med_pond->execute();
				
				$row_st_met_pond = $ST_med_pond->fetch();
				
				$custoMedioPond = $row_st_met_pond->custo_medio_pond;
				$pctIcms = $row_st_met_pond->pct_icms * 0.01;
				$bcIcms = $custoMedioPond * $pctIcms; 
				
				//echo 'custoMedioPond'.$row_st_met_pond->custo_medio_pond;
				//echo 'pctIcms'.$row_st_met_pond->pct_icms;
				
				$pctSubstTrib = $row_st_met_pond->pct_subst_trib * 0.01;
			    $baseSTPonderada = $custoMedioPond * $pctSubstTrib + $custoMedioPond;
            
            	$bcSt = $baseSTPonderada * $pctIcms;
            	
				$st = $bcSt - $bcIcms;
				
           	    $somaSTProduto = $Valor_venda + $st;
				
				
				
				?>
                <div>
                  <p><span class="old-price">De:
                  <?php  echo 'R$ '.number_format($row_dados->valor_prazo,2,',','.');?>
                  </span> </p>
                  </div>
                  <span class="product-price">Por:
                  <?php  echo 'R$ ';?>
                   <input name="ValorTotal" readonly="readonly" style="border: 0px; width: 200px;font-size: 50px;" value="<?php  echo number_format($somaSTProduto,2,',','.');?>" />
                  </span>
                 <div> 
                  <p> <span class="product-price">
                    <?php  echo 'R$ ';?>
                    <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px" value="<?php  echo number_format($Valor_venda,2,',','.');?>" />
                    <?php echo ' +  ST '; ?>
                    <input name="ST" readonly="readonly" style="border: 0px; width:60px" value="<?php  echo number_format($st,2,',','.');?>" />
                  </span></p>
                  </div>
                  <?php }else{ ?>
                  <?php 
				$Valor_venda = $row_dados->valor_prazo;
				
				$SQL_ST_med_pond = "SELECT * FROM produtos_empresa where cod_empresa = :cod_empresa and cod_produto = :cod_produto";
				$ST_med_pond = $pdo->prepare($SQL_ST_med_pond);
				$ST_med_pond->bindValue('cod_empresa', $_SESSION['COD_EMPRESA_cliente']);
				$ST_med_pond->bindValue('cod_produto', $_GET['codProduto']);
				$ST_med_pond->execute();
				
				$row_st_met_pond = $ST_med_pond->fetch();
				
				$custoMedioPond = $row_st_met_pond->custo_medio_pond;
				$pctIcms = $row_st_met_pond->pct_icms * 0.01;
				$bcIcms = $custoMedioPond * $pctIcms; 
				
				//echo 'custoMedioPond'.$row_st_met_pond->custo_medio_pond;
				//echo 'pctIcms'.$row_st_met_pond->pct_icms;
				
				$pctSubstTrib = $row_st_met_pond->pct_subst_trib * 0.01;
			    $baseSTPonderada = $custoMedioPond * $pctSubstTrib + $custoMedioPond;
            
            	$bcSt = $baseSTPonderada * $pctIcms;
            	
				$st = $bcSt - $bcIcms;
				
           	    $somaSTProduto = $Valor_venda + $st;
				  
				  ?>
                  <span class="product-price">
                  <?php  echo 'R$ ';?>
                  <input name="ValorTotal" readonly="readonly" style="border: 0px; width: 200px;font-size: 50px;" value="<?php  echo number_format($somaSTProduto,2,',','.');?>" />
                  </span>
                  <div> <span class="product-price">
                    <?php  echo 'R$ ';?>
                    <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px" value="<?php  echo number_format($Valor_venda,2,',','.');?>" />
                    <?php echo ' +  ST '; ?>
                    <input name="ST" readonly="readonly" style="border: 0px; width:60px" value="<?php  echo number_format($st,2,',','.');?>" />
                    </span> </div>
                  <?php } ?>
                  <?php } ?>
                  <?php }else{?>
                  <div class="product-action"><a href="#" class="login-link paction add-cart" title="Clique aqui para logar"> <span>Ver Preço</span> </a> </div>
                  <?php } ?>
                </div>
                <!-- End .price-box -->
                
                <div class="product-desc">
                  <p>Marca: <strong><?php echo $row_dados->nome_marca;?></strong></p>
                  <p>Unidade: <strong><?php echo $row_dados->unidade;?></strong></p>
                  <p>Embalagem Fechada: <strong><?php echo $row_dados->embalagem_produto;?></strong></p>
                  <p>Embalagem Venda: <strong><?php echo $row_dados->emb_venda;?></strong></p>
                  <?php 
				  	if ($row_dados->minimo_produto_venda != 1){
						echo '<p>Observação: <strong style="font-size:9px;color:red">Vendido apenas por multiplos de '.$row_dados->minimo_produto_venda.' unidades!</strong></p>';
					}
				  ?>
                </div>
                <!-- End .product-desc -->
                
                <div class="product-filters-container">
                  <div class="product-single-filter"> 
                    <?php
				  if (isset($_SESSION['permissaoCidades']) or !empty($_SESSION['permissaoCidades'])){
					 		if($_SESSION['permissaoCidades'] == 's'){?>
                    <input type="button" name="botao-" value="-" style="width:35px; height:35px; border:0px; border-radius:7px; background:#bf1010; text-align:center; line-height:30px; font-size:20px" >
                    <input style="margin-left:10px; margin-right:10px; height:35px; width:70px; border:1px solid #666; border-radius:7px; text-align:center" name="qtde" value="<?php echo $row_dados->minimo_produto_venda;?>" id="qtde" class='<?php echo $row_dados->minimo_produto_venda;?>' readonly="readonly"/>
                    <input type="button" name="botao+" value="+" style="width:35px; height:35px; border:0px; border-radius:7px; background:#bf1010; text-align:center; line-height:30px; font-size:20px"">
                    <?php
							}
				  }
				  ?>
                  </div>
                  <!-- End .product-single-filter --> 
                </div>
                <!-- End .product-filters-container -->
                
                <div class="product-action product-all-icons"> 
                  
                  <!-- End .product-single-qty -->
                  <?php  if (isset($_SESSION['permissaoCidades']) or !empty($_SESSION['permissaoCidades'])){
					 		if($_SESSION['permissaoCidades'] == 's'){?>
                  <div style="clear:both"></div>
                  <input type="submit" class="paction add-cart" value="Comprar" title="Adicionar no carrinho">
                  <a href="javascript: insertFavorito(<?php echo $row_dados->cod_produto;?>)" class="paction add-wishlist" title="Lista de Desejos"> <span>Lista de Desejos</span> </a>
                  <?php  }else{ echo '<span style="color:red;">No momento não atendemos a cidade cadastrada em seu perfil e estamos trabalhando para que nossa rota de entrega atinga mais cidades para poder atender nossos clientes!</span>';}?>
                  <div class="product-action"></div>
                  <?php
							
							}?>
                </div>
                <!-- End .product-action -->
                
                <div class="product-single-share"> 
                  <div class="addthis_inline_share_toolbox"></div>
                </div>
                <!-- End .product single-share --> 
              </div>
            </form>
            <!-- End .product-single-details --> 
          </div>
          <!-- End .col-lg-5 --> 
        </div>
        <!-- End .row --> 
      </div>
      <!-- End .product-single-container -->
      
      <div class="product-single-tabs">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"> <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="true">Descrição</a> </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
            <div class="product-desc-content"> <?php echo $row_dados->descricao;?> </div>
            <!-- End .product-desc-content --> 
          </div>
          <!-- End .tab-pane -->
          
          <div class="tab-pane fade" id="product-tags-content" role="tabpanel" aria-labelledby="product-tab-tags">
            <div class="product-tags-content"> 
            </div>
            <!-- End .product-tags-content --> 
          </div>
          <!-- End .tab-pane -->
          
          <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
            <div class="product-reviews-content">
              <div class="collateral-box">
                <ul>
                  <!-- <li>Be the first to review this product</li> -->
                </ul>
              </div>
              <!-- End .collateral-box -->
              
              <div class="add-product-review">
                <h3 class="text-uppercase heading-text-color font-weight-semibold">WRITE YOUR OWN REVIEW</h3>
                <p>How do you rate this product? *</p>
                <form action="#">
                  <table class="ratings-table">
                    <thead>
                      <tr>
                        <th>&nbsp;</th>
                        <th>1 star</th>
                        <th>2 stars</th>
                        <th>3 stars</th>
                        <th>4 stars</th>
                        <th>5 stars</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Quality</td>
                        <td><input type="radio" name="ratings[1]" id="Quality_1" value="1" class="radio"></td>
                        <td><input type="radio" name="ratings[1]" id="Quality_2" value="2" class="radio"></td>
                        <td><input type="radio" name="ratings[1]" id="Quality_3" value="3" class="radio"></td>
                        <td><input type="radio" name="ratings[1]" id="Quality_4" value="4" class="radio"></td>
                        <td><input type="radio" name="ratings[1]" id="Quality_5" value="5" class="radio"></td>
                      </tr>
                      <tr>
                        <td>Value</td>
                        <td><input type="radio" name="value[1]" id="Value_1" value="1" class="radio"></td>
                        <td><input type="radio" name="value[1]" id="Value_2" value="2" class="radio"></td>
                        <td><input type="radio" name="value[1]" id="Value_3" value="3" class="radio"></td>
                        <td><input type="radio" name="value[1]" id="Value_4" value="4" class="radio"></td>
                        <td><input type="radio" name="value[1]" id="Value_5" value="5" class="radio"></td>
                      </tr>
                      <tr>
                        <td>Price</td>
                        <td><input type="radio" name="price[1]" id="Price_1" value="1" class="radio"></td>
                        <td><input type="radio" name="price[1]" id="Price_2" value="2" class="radio"></td>
                        <td><input type="radio" name="price[1]" id="Price_3" value="3" class="radio"></td>
                        <td><input type="radio" name="price[1]" id="Price_4" value="4" class="radio"></td>
                        <td><input type="radio" name="price[1]" id="Price_5" value="5" class="radio"></td>
                      </tr>
                    </tbody>
                  </table>
                  <div class="form-group">
                    <label>Nickname <span class="required">*</span></label>
                    <input type="text" class="form-control form-control-sm" required>
                  </div>
                  <!-- End .form-group -->
                  <div class="form-group">
                    <label>Summary of Your Review <span class="required">*</span></label>
                    <input type="text" class="form-control form-control-sm" required>
                  </div>
                  <!-- End .form-group -->
                  <div class="form-group mb-2">
                    <label>Review <span class="required">*</span></label>
                    <textarea cols="5" rows="6" class="form-control form-control-sm"></textarea>
                  </div>
                  <!-- End .form-group -->
                  
                  <input type="submit" class="btn btn-primary" value="Submit Review">
                </form>
              </div>
              <!-- End .add-product-review --> 
            </div>
            <!-- End .product-reviews-content --> 
          </div>
          <!-- End .tab-pane --> 
        </div>
        <!-- End .tab-content --> 
      </div>
      <!-- End .product-single-tabs --> 
    </div>
    <!-- End .col-lg-9 -->
    
    <div class="sidebar-overlay"></div>
    <div class="sidebar-toggle"><i class="icon-sliders"></i></div>
    <aside class="sidebar-product col-lg-3 padding-left-lg mobile-sidebar">
      <div class="sidebar-wrapper"> 
        
        <!-- End .widget -->
        
        <div class="widget widget-info">
          <ul>
            <li> <i class="icon-shipping"></i>
              <h4>FRETE<br>
                GRÁTIS</h4>
            </li>
            <li> <i class="icon-us-dollar"></i>
              <h4>PAGAMENTO<br>
                SEGURO</h4>
            </li>
            <li> <i class="icon-online-support"></i>
              <h4>SUPORTE<br>
                AO CLIENTE</h4>
            </li>
          </ul>
        </div>
        <!-- End .widget -->
        
        <div class="widget widget-banner"> 
          <!-- End .banner --> 
        </div>
        <!-- End .widget --> 
        
      </div>
    </aside>
    <!-- End .col-md-3 --> 
  </div>
  <!-- End .row --> 
</div>
