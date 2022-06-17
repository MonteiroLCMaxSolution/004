<?php 
include '../../model/fornecedores/fornecedores-model.php';
$idCliente = '';

if(!empty($_SESSION['id_do_cliente'])){
	echo $idCliente = $_SESSION['id_do_cliente'];
}
if (!empty($achou)){
	echo $achou;
}else{
	
while ($row_item_fornec = $SQL_list_item_fornec->fetch()){ ?>
    <div class="product" style="height:390px">
     <?php if ($row_item_fornec->valor_promocao > 0 ){?>
     <div class="tarja">Promoção</div>
     <?php } ?>
      <figure style="height:230px" class="product-image-container"> <a href="../view/dados-produto?codProduto=<?php echo $row_item_fornec->cod_produto;?>" class="product-image"> <img src="https://lcmaxsolution.com.br/Leal-Dutra/Painel/imagens/produtos/<?php echo $row_item_fornec->imagem;?>" alt="<?php echo 'Visualizado: '.$row_item_fornec->visualizado;?>" title="<?php echo 'Visualizado: '.$row_item_fornec->visualizado;?>"> </a> <a href="../ajax/product-quick-view.php?codProduto=<?php echo $row_item_fornec->cod_produto;?>" class="btn-quickview">Olhada Rápida</a> </figure>
      <div class="product-details">
        <div class="ratings-container">
          
        </div>
        <h2 class="product-title" style="height:53px"> <a href="../view/dados-produto?codProduto=<?php echo $row_item_fornec->cod_produto;?>&amp;name=<?php echo $row_item_fornec->nome_produto;?>"><?php echo $row_item_fornec->cod_produto.' - '.$row_item_fornec->nome_produto;?></a> </h2>
        <div class="price-box"> <span class="product-price"><?php if(!empty($idCliente)){
			  if ($row_item_fornec->valor_promocao > 0 ){?>
                  <span class="old-price">De:
                  <?php  echo 'R$ '.number_format($row_item_fornec->valorProduto,2,',','.');?>
                  </span> <span class="product-price">Por:
                  <?php  echo 'R$ ';?>
                  <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px;color:#F00" value="<?php  echo number_format($row_item_fornec->valor_promocao,2,',','.');?>" />
                  </span>
                  <?php }else{?>
                  <span class="product-price">
                  <?php  echo 'R$ ';?>
                  <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px;" value="<?php  echo number_format($row_item_fornec->valorProduto,2,',','.');?>" />
                  </span>
                  <?php }
			  }?>?></span> </div>
        <?php 
		//if (!empty($idCliente)){ ?>
        <div class="product-action"> <a href="javascript: insertFavorito(<?php echo $row_item_fornec->cod_produto; ?>)" class="paction add-wishlist" title="Adicionar a lista de desejos"> <span>Lista de Desejos</span> </a>  <?php if(!empty($_SESSION['id_do_cliente'])){ ?>
           <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_item_fornec->cod_produto;?>" class="paction add-cart" title="Adicionar ao Carrinho"> <span>Comprar</span> </a></div>
           <?php }else { ?>
           <div class="product-action"><a href="#" class="login-link paction add-cart" title="Clique aqui para logar"> <span>Ver Preço</span> </a> </div></div>
           <?php } ?>
        <?php // }else{ ?>
        <!-- <div class="product-action"><a href="view/dados-produto?codProduto=<?php echo $row_item_fornec->cod_produto;?>" class="login-link paction add-cart" title="Clique aqui para logar"> <span>Logar</span> </a> </div> -->
        <?php // } ?>
      </div>
    </div>
    <?php
	
    /* Atualizar o campo Visualizado */
        $codProduto = $row_item_fornec->cod_produto;
        $visualizado = intval($row_item_fornec->visualizado);
		$visualizado = intval($visualizado) + 1;
		
        $SQL_edt_visualizado = "UPDATE produtos_empresa SET visualizado = :visualizado, data_visualizado = :datavisualizado WHERE cod_produto = :codProduto;";
		$SQL_edt_visualizado = $pdo->prepare($SQL_edt_visualizado);
		$SQL_edt_visualizado->bindValue('visualizado',$visualizado);
		$SQL_edt_visualizado->bindValue('datavisualizado',$dataLocal);
		$SQL_edt_visualizado->bindValue('codProduto',$codProduto);
		$SQL_edt_visualizado->execute();
    /* FIM - Atualizar o campo Visualizado */
}} ?>
