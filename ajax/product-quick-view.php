
<div class="product-single-container product-single-default product-quick-view container">
  <?php 
  if(!isset($_SESSION)){
  session_start();
  }
  $_SESSION['cod_subcategoria'] = '';
  ini_set('display_errors',1);
  ini_set('display_startup_erros',1);
  error_reporting(E_ALL);
  date_default_timezone_set('America/Sao_Paulo');
  $dataLocal = date('Y-m-d H:i:s', time());
  include_once ('../conexao-pdo/conexao-mysql-pdo.php');
  require_once ('../conexao-pdo/config.php');
  $codPro =   $_GET['codProduto'];
  $js = $http.'/assets/js/ajax.js';
  /*---------- GRAVAR O CLICK DO CLIENTE REFERENTE AO PRODUTO - LEÔNIDAS MONTEIRO - 17/09/2020 */
    $SQL_achar_click = "SELECT id_produto FROM produto_click WHERE id_cliente = :id_cliente AND sha1 = :sha1 AND id_produto = :id_produto;";
    $SQL_achar_click = $pdo->prepare($SQL_achar_click);
    $SQL_achar_click->bindValue('id_cliente', $_SESSION['id_do_cliente']);
    $SQL_achar_click->bindValue('sha1',$_SESSION['sha_carrinho']);
    $SQL_achar_click->bindValue('id_produto',$codPro);
    $SQL_achar_click->execute();
    if($SQL_achar_click->rowCount() == 0){
    $SQL_click = "INSERT INTO produto_click(id_produto,id_cliente,sha1,status,data_click)VALUES(:id_produto,:id_cliente,:sha1,:status,:data_click);";
    $SQL_click = $pdo->prepare($SQL_click);
    $SQL_click->bindValue('id_produto',$codPro);
    $SQL_click->bindValue('id_cliente',$_SESSION['id_do_cliente']);
    $SQL_click->bindValue('sha1',$_SESSION['sha_carrinho']);
    $SQL_click->bindValue('status','VIEW');
    $SQL_click->bindValue('data_click',$dataLocal);
    $SQL_click->execute();   
    }   
  /*========== GRAVAR O CLICK DO CLIENTE REFERENTE AO PRODUTO - LEÔNIDAS MONTEIRO - 17/09/2020 */
  if (isset($_SESSION['COD_EMPRESA_cliente'])){
    $codEmpresa = $_SESSION['COD_EMPRESA_cliente'];
  }else{
    $codEmpresa = '1';
  }
  $SQL_dadosProduto = "SELECT a.id,b.cod_subcategoria, a.cod_empresa,b.cod_marca as marca, a.id,ifnull(a.minimo_produto_venda,0) as minimo_produto_venda, a.cod_produto, a.valor_prazo as valorProduto, a.unidade, b.nome_produto, c.valor_promocao, b.descricao, d.nome_marca,ifnull(a.estoque_disponivel,0) AS estoque_disponivel
  FROM produtos_empresa a 
  INNER JOIN produtos b ON a.cod_produto = b.cod_produto AND a.cod_empresa = :codEmpresa
  LEFT JOIN promocao c ON a.cod_produto = c.cod_produto  AND c.situacao = 'ATIVO' AND c.data_fim >= cast(NOW() as date)  AND c.cod_empresa = :codEmpresa
  LEFT JOIN marca d ON b.cod_marca = d.cod_marca
  WHERE a.cod_produto = :codproduto AND a.cod_empresa = :codEmpresa group by a.cod_produto";
  $SQL_dadosProduto = $pdo->prepare($SQL_dadosProduto);
  $SQL_dadosProduto->bindValue('codEmpresa',$codEmpresa);

  $SQL_dadosProduto->bindValue('codproduto',$codPro);
  $SQL_dadosProduto->execute();
  if (!empty($SQL_dadosProduto)){
    $row_dados = $SQL_dadosProduto->fetch();
  }
  $SQL_listar_imagens = "SELECT a.id, IFNULL(b.imagem,'no-photo.png') as imagem FROM produtos_empresa a
  LEFT JOIN imagens b ON a.cod_produto = b.cod_produto
  WHERE a.cod_produto = :codproduto AND a.cod_empresa = :codEmpresa;";
  $SQL_listar_imagens = $pdo->prepare($SQL_listar_imagens);

  $SQL_listar_imagens->bindValue('codproduto',$codPro);
  $SQL_listar_imagens->bindValue('codEmpresa',$codEmpresa);
  $SQL_listar_imagens->execute();

  $SQL_listar_imagem = "SELECT a.id, IFNULL(b.imagem,'no-photo.png') as imagem FROM produtos_empresa a
  LEFT JOIN imagens b ON a.cod_produto = b.cod_produto
  WHERE a.cod_produto = :codproduto AND a.cod_empresa = :codEmpresa;";
  $SQL_listar_imagem = $pdo->prepare($SQL_listar_imagem);

  $SQL_listar_imagem->bindValue('codproduto',$codPro);
  $SQL_listar_imagem->bindValue('codEmpresa',$codEmpresa);
  $SQL_listar_imagem->execute();
  /* somar click */
  if (isset($_SESSION['id_do_cliente'])){
    $cod_cliente = $_SESSION['id_do_cliente'];
  }else{
    $cod_cliente = 0;
  }
  $cod_cliente = isset($_SESSION['id_do_cliente']);
  $SQL_insert_click = "INSERT INTO produtos_clicks(cod_produto,cod_empresa,id_cliente,dataclick)values(:codProduto,:codEmpresa,:codCliente,:datalocal)";
  $SQL_insert_click = $pdo->prepare($SQL_insert_click);
  $SQL_insert_click->bindValue('codProduto',$codPro);
  $SQL_insert_click->bindValue('codEmpresa',$codEmpresa);
  $SQL_insert_click->bindValue('codCliente',$cod_cliente);
  $SQL_insert_click->bindValue('datalocal',$dataLocal);
  $SQL_insert_click->execute();
  /* Fim - Somar click */

  $_SESSION['cod_subcategoria'] = $row_dados->cod_subcategoria;
  ?>
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
                    $imagem = 'no-photo.png';
                  }
                  $filename = $http.'/Painel/imagens/produtos/'.$imagem;
                  ?>
                  <div class="product-item"> <img class="product-single-image" src="<?php echo $filename;?>" style="width:100%" data-zoom-image="/Painel/imagens/produtos/<?php echo $imagem;?>"  /> </div>
                  <?php
                }
                ?>
              </div>
              <!-- End .product-single-carousel --> 
              <span class="prod-full-screen"> <i class="icon-plus"></i> </span> </div>
              <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
                <?php
                while ($row_listar_imagem = $SQL_listar_imagem->fetch()){
                  $filename = $http.'/Painel/imagens/produtos/'.$row_listar_imagem->imagem;
                  if (!file_exists($filename)) {
                    $imagem = $row_listar_imagem->imagem;
                  } else {
                    $imagem = 'no-photo.png';
                  }
                  ?>
                  <div class="col-3 owl-dot"> <img src="<?php echo $http; ?>/Painel/imagens/produtos/<?php echo $imagem;?>"/> </div>
                <?php } ?>
              </div>
            </div>
            <!-- End .col-lg-7 -->
            <div class="col-lg-5 col-md-6">
            <input id="cod_subcategoria" hidden="hidden" value="<?php echo $_SESSION['cod_subcategoria'];?>">
              <form >
                <div class="product-single-details">
                  <h1 class="product-title"><?php echo $row_dados->nome_produto;?></h1>
                  <div class="ratings-container"> Código:
                    <input name="codProduto" id="codProduto" readonly="readonly" style="border: 0px" value="<?php echo $row_dados->cod_produto;?>" />
                    <!-- End .product-ratings --> 

                    <a href="#" class="rating-link"></a> </div>
                    <!-- End .product-container -->

                    <div class="price-box"> <span class="product-price">
                      <?php if(!empty($_SESSION['id_do_cliente'])){ ?>
                       <?php if($_SESSION['COD_EMPRESA_cliente'] == 1) { ?>
                        <?php if ($row_dados->valor_promocao > 0 ){
                          $valorReal = $row_dados->valor_promocao;
                         ?>
                          <div class="col-sm-12 col-md-12 col-lg-12" align="center">
                            <span class="old-price">De:
                              <?php  echo 'R$ '.number_format($row_dados->valorProduto,2,',','.');?>
                            </span>
                          </div>
                          <span class="product-price" style="color:#F00">Por:
                            <?php  echo 'R$ '.number_format($row_dados->valor_promocao,2,',','.');?>
                          </span> 
                        <?php }else{ 
                          $valorReal = $row_dados->valorProduto;?>
                          <span class="product-price">Por:
                            <?php  echo 'R$ '.number_format($row_dados->valorProduto,2,',','.');?>
                          </span> 
                        <?php } ?>
                      <?php }else{ ?>
                        <?php if ($row_dados->valor_promocao > 0 ){
                          $valorFinal = $row_dados->valor_promocao;

                          $SQL_ST_med_pond = "SELECT * FROM produtos_empresa where cod_empresa = :cod_empresa and cod_produto = :cod_produto";
                          $ST_med_pond = $pdo->prepare($SQL_ST_med_pond);
                          $ST_med_pond->bindValue('cod_empresa', $_SESSION['COD_EMPRESA_cliente']);
                          $ST_med_pond->bindValue('cod_produto', $row_listar_produtos->codProduto);
                          $ST_med_pond->execute();

                          $row_st_met_pond = $ST_med_pond->fetch();

                          $custoMedioPond = $row_st_met_pond->custo_medio_pond;
                          $pctIcms = $row_st_met_pond->pct_icms * 0.01;
                          $bcIcms = $custoMedioPond * $pctIcms; 

                          $pctSubstTrib = $row_st_met_pond->pct_subst_trib * 0.01;
                          $baseSTPonderada = $custoMedioPond * $pctSubstTrib + $custoMedioPond;

                          $bcSt = $baseSTPonderada * $pctIcms;

                          $st = $bcSt - $bcIcms;

                          $somaSTProduto = $Valor_venda + $st;
                          ?>

                          <div> 
                            
                            <span class="old-price">De:
                              <?php  echo 'R$ '.number_format($row_dados->valorProduto,2,',','.');?>
                            </span>
                          </div>
                          <span class="product-price" style="color:#F00; font-size:24px">Por:
                            <?php  echo 'R$ '.number_format($Valor_venda,2,',','.').' + ST '.number_format($st,2,',','.');?>
                          </span> 

                        <?php }else{
                          $valorFinal = $row_dados->valorProduto;

                          $SQL_ST_med_pond = "SELECT * FROM produtos_empresa where cod_empresa = :cod_empresa and cod_produto = :cod_produto";
                          $ST_med_pond = $pdo->prepare($SQL_ST_med_pond);
                          $ST_med_pond->bindValue('cod_empresa', $_SESSION['COD_EMPRESA_cliente']);
                          $ST_med_pond->bindValue('cod_produto', $row_listar_produtos->codProduto);
                          $ST_med_pond->execute();

                          $row_st_met_pond = $ST_med_pond->fetch();

                          $custoMedioPond = $row_st_met_pond->custo_medio_pond;
                          $pctIcms = $row_st_met_pond->pct_icms * 0.01;
                          $bcIcms = $custoMedioPond * $pctIcms; 

                          $pctSubstTrib = $row_st_met_pond->pct_subst_trib * 0.01;
                          $baseSTPonderada = $custoMedioPond * $pctSubstTrib + $custoMedioPond;

                          $bcSt = $baseSTPonderada * $pctIcms;

                          $st = $bcSt - $bcIcms;

                          $somaSTProduto = $Valor_venda + $st;  
                          ?>

                          <div class="col-sm-12 col-md-12 col-lg-12" align="center">
                            <span class="old-price">
                            </span>
                          </div>
                          <span class="product-price">

                           <div>
                             <?php  echo 'R$ '.number_format($Valor_venda,2,',','.').' + ST '.number_format($st,2,',','.');?>
                           </div>
                         </span>

                       <?php } ?>
                     <?php }}else{?>
                       <div class="product-action"><a href="#" class="disable login-link paction add-cart" title="Clique aqui para logar"> <span>Ver Preço</span> </a> </div>
                     <?php } ?>
                   </div>
                   <input type="hidden" id="valorReal" value="<?php echo $valorReal;?>" >
                   <!-- End .price-box -->

                   <div class="product-desc">
                    <p>Marca: <strong><?php echo $row_dados->marca;?></strong></p>
                    <p>Unidade: <strong><?php echo $row_dados->unidade;?></strong></p>
                    <p>Estoque: <strong><?php echo $row_dados->estoque_disponivel;?></strong></p>
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
                          <input type="button" id='btn0' name="botao-" value="-" style="width:35px; height:35px; border:0px; border-radius:7px; background:#39F; text-align:center; line-height:30px">
                          <input type="hidden" id="qtdemin" value="<?php echo $row_dados->minimo_produto_venda;?>">
                          <input type="hidden" id="qtdeEstoque" value="<?php echo $row_dados->estoque_disponivel;?>">


                          <input  onKeyUp="valid_qtd('<?php echo $row_dados->minimo_produto_venda;?>')" style="margin-left:10px; margin-right:10px; height:35px; width:70px; border:1px solid #666; border-radius:7px; text-align:center" id="qtde" name="qtde" value="<?php echo $row_dados->minimo_produto_venda;?>" class='<?php echo $row_dados->minimo_produto_venda;?>'/>
                          <input type="button" id="btn1" name="botao+" value="+" style="width:35px; height:35px; border:0px; border-radius:7px; background:#39F; text-align:center; line-height:30px">
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
                          <!-- <div class="product-single-qty">
                                     <input class="horizontal-quantity form-control" type="text" name="qtde">
                                     </div>
                                   -->
                                   <div style="clear:both"></div>
                                   <?php
                                    //if($row_dados->estoque_disponivel > $row_dados->minimo_produto_venda){
										if($row_dados->estoque_disponivel > 0){
                                      ?>
                                      <input class="btn btn-primary disable" id="gravarCarrinho" value="Comprar" title="Adicionar no carrinho">
                                      <?php
                                    }else{
                                      echo '<div style="color: red;margin: 10px"> Produto sem Estoque! </div>';
                                    }

                                   ?>
                                    
                                   <a href="javascript: insertFavorito(<?php echo $row_dados->cod_produto;?>)" class="paction add-wishlist" title="Lista de Desejos"> <span>Lista de Desejos</span> </a>
                                   <?php  }else{ echo '<span style="color:red;">No momento não atendemos a cidade cadastrada em seu perfil e estamos trabalhando para que nossa rota de entrega atinga mais cidades para poder atender nossos clientes!</span>';}?><div class="product-action"></div>
                                   <?php

                                 }?>
                               </div>
                               <!-- End .product-action -->

                               <div class="product-single-share"> 
                                <!--<label>Share:</label>--> 
                                <!-- www.addthis.com share plugin-->
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
       <!-- <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item"> <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="true">Descrição</a> </li>
          
        </ul> -->
        <div class="tab-content">
          <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
            <div class="product-desc-content"> <?php echo $row_dados->descricao;?> </div>
            <!-- End .product-desc-content --> 
          </div>
          <!-- End .tab-pane -->
          
          <div class="tab-pane fade" id="product-tags-content" role="tabpanel" aria-labelledby="product-tab-tags">
            <div class="product-tags-content"> 
              <!-- <form action="#">
                <h4>Add Your Tags:</h4>
                <div class="form-group">
                  <input type="text" class="form-control form-control-sm" required>
                  <input type="submit" class="btn btn-primary" value="Add Tags">
                </div>
              </form> 
              <p class="note">Use spaces to separate tags. Use single quotes (') for phrases.</p>--> 
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
                <form >
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
      </div>
    </aside>
    <!-- End .col-md-3 --> 
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo $js;?>"></script>

