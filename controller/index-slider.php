 <div class="row">
    <div class="col-lg-9 offset-lg-3">
        <div class="home-slider owl-carousel owl-carousel-lazy owl-theme">
            <div class="home-slide">
                <div class="owl-lazy slide-bg" src="assets/images/slider/slider-30092020-1.png" data-src="assets/images/slider/slider-30092020-1.png"></div>
                <a href="">
                </a>
            </div><!-- End .home-slide -->

            <div class="home-slide">
                <div class="owl-lazy slide-bg" src="assets/images/slider/slider-30092020-2.png" data-src="assets/images/slider/slider-30092020-2.png"></div>
                <a href="">
                </a>
            </div><!-- End .home-slide -->

            <div class="home-slide">
                <div class="owl-lazy slide-bg" src="assets/images/slider/slider-30092020-3.png" data-src="assets/images/slider/slider-30092020-3.png"></div>
                <a href="">
                </a>
            </div><!-- End .home-slide -->
        </div><!-- End .home-slider -->
    </div><!-- End .col-lg-9 -->
</div><!-- End .row -->
<input type="hidden" name="nomeCliente" class="form-control" id="nomeCliente">

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
            <figure style="height:220px" class="product-image-container">
                <img src="<?php echo $http; ?>/Painel/imagens/produtos/<?php echo $row_listar_produtos->imagem;?>" alt="<?php echo 'Visualizado: '.$row_listar_produtos->visualizado;?>" style="height:220px" title="<?php echo 'Visualizado: '.$row_listar_produtos->visualizado;?>"> 
                 
                <?php if(isset($_SESSION['id_do_cliente'])){?><a href="<?php echo $http;?>/ajax/product-quick-view.php?codProduto=<?php echo $row_listar_produtos->cod_produto;?>" class="btn-quickview">Olhada Rápida</a><?php }?> 
            </figure>
            <div class="product-details" style="height:300px">
                <div class="ratings-container">
                    <div class="product-ratings">
                        <span class="ratings"></span><!-- End .ratings -->
                    </div><!-- End .product-ratings -->
                </div><!-- End .product-container -->
                <h2 class="product-title">
                    
                    <?php echo $row_listar_produtos->cod_produto.' | '.$row_listar_produtos->nome_produto;?>
                </h2>
                <div class="price-box" style="height:70px">
                    <span class="product-price">
                       <?php if(!empty($idCliente)){
                        if ($row_listar_produtos->promocao > 0 ){?>
                           <span class="old-price">De:
                               <?php  echo 'R$ '.number_format($row_listar_produtos->valor_prazo,2,',','.');?>
                           </span> <BR/>
                           <span class="product-price">Por:
                               <?php  echo 'R$ ';?>
                               <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px;color:#F00" value="<?php  echo number_format($row_listar_produtos->promocao,2,',','.');?>" />
                           </span>
                       <?php }else{?>
                           <span class="product-price">
                               <?php  echo 'R$ ';?>
                               <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px;" value="<?php  echo number_format($row_listar_produtos->valor_prazo,2,',','.');?>" />
                           </span>
                       <?php }
                   }?>
               </span>
           </div><!-- End .price-box -->

           <div class="product-action">
               <?php if(!empty($_SESSION['id_do_cliente'])){ ?>
                 <a href="<?php echo $http;?>/ajax/product-quick-view.php?codProduto=<?php echo $row_listar_produtos->cod_produto;?>" class="btn btn-primary btn-quickview" title="Adicionar ao Carrinho"> <span>Comprar</span> </a>
             <?php }else { ?>
                 <a href="?pg=login_cliente&codProduto=<?php echo $row_listar_produtos->cod_produto;?>" class=" paction add-cart" title="Clique aqui para logar"> <span>Ver Preço</span> </a>
             <?php } ?>   
         </div><!-- End .product-action -->
         
     </div><!-- End .product-details -->
 </div><!-- End .product -->
</div>
<?php } ?>
</div><!-- End .col-lg-3 -->