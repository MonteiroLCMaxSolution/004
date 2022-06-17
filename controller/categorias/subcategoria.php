<?php
$total_reg  = '20';
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//$codEmpresa = (isset($_SESSION['COD_EMPRESA_cliente']))? $_SESSION['COD_EMPRESA_cliente'] : 1;
$codEmpresa = $_SESSION['COD_EMPRESA_cliente'];
if(!empty($codEmpresa)){
$and_CodEmpresa = 'AND b.cod_empresa = '.$codEmpresa.'';
}else{
$and_CodEmpresa = '';
}
$categoria = $_GET['subcat'];
 $pc = $pagina;
$inicio = $pc - 1;
$inicio = $inicio * $total_reg;

$limite = "SELECT b.cod_produto, a.nome_produto, b.valor_prazo AS valorProduto, d.valor_promocao, b.visualizado, IFNULL(c.imagem,'no-photo.png') AS imagem FROM produtos a 
INNER JOIN produtos_empresa b ON a.cod_produto = b.cod_produto
LEFT JOIN imagens c ON a.cod_produto = c.cod_produto
LEFT JOIN promocao d ON a.cod_produto = d.cod_produto AND d.situacao = 'ATIVO' AND d.data_inicio <= NOW() AND d.data_fim >= NOW() AND d.cod_empresa = '$codEmpresa'
WHERE a.cod_subcategoria = '$categoria' AND b.status_produto like 'ATIVO' $and_CodEmpresa GROUP BY b.cod_produto LIMIT $inicio,$total_reg";
$limite = $pdo->prepare($limite);
$limite->execute();

 
$total = "SELECT b.cod_produto, a.nome_produto FROM produtos a 
INNER JOIN produtos_empresa b ON a.cod_produto = b.cod_produto
WHERE a.cod_subcategoria = '$categoria' AND b.status_produto like 'ATIVO' $and_CodEmpresa GROUP BY b.cod_produto";
$total = $pdo->prepare($total);
$total->execute();

$tr = intVal($total->rowCount());

$tp = $tr / $total_reg; // verifica o número total de páginas
$arred = intVal($tp);
if ($arred < $tr){
	$tp = $arred + 1;
}

// vamos criar a visualização
?>
<div class="col-lg-12">
  
  <div class="row row-sm">
  <?php
  if(!empty($_SESSION['id_do_cliente'])){
	//echo $idCliente = $_SESSION['id_do_cliente'];
}
if (!empty($achou)){
	echo $achou;
}else{
	
while ($row_categorias = $limite->fetch()){?>
    <div class="col-12 col-md-3">
      <div class="product">
      <?php if ($row_categorias->valor_promocao > 0 ){?>
     <div class="tarja">Promoção</div>
     <?php } ?>
        <figure style="height:100%" class="product-image-container"> <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_categorias->cod_produto;?>" class="product-image"> <img src="https://lcmaxsolution.com.br/Leal-Dutra/Painel/imagens/produtos/<?php echo $row_categorias->imagem;?>" alt="<?php echo 'Visualizado: '.$row_categorias->visualizado;?>" title="<?php echo 'Visualizado: '.$row_categorias->visualizado;?>"> </a> <a href="<?php echo $http;?>/ajax/product-quick-view.php?codProduto=<?php echo $row_categorias->cod_produto;?>" class="btn-quickview">Olhada Rápida</a> </figure>
        <div class="product-details">
          
          <h2 class="product-title" style="height:53px"> <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_categorias->cod_produto;?>&amp;name=<?php echo $row_categorias->nome_produto;?>"><?php echo $row_categorias->cod_produto.' - '.$row_categorias->nome_produto;?></a> </h2>
          <div class="price-box"> <span class="product-price">
		  <?php if(!empty($idCliente)){
			    if ($row_categorias->valor_promocao > 0 ){?>
                  <span class="old-price">De:
                  <?php  echo 'R$ '.number_format($row_categorias->valorProduto,2,',','.');?>
                  </span> <span class="product-price">Por:
                  <?php  echo 'R$ ';?>
                  <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px;color:#F00" value="<?php  echo number_format($row_categorias->valor_promocao,2,',','.');?>" />
                  </span>
                  <?php }else{?>
                  <span class="product-price">
                  <?php  echo 'R$ ';?>
                  <input name="valorProduto" readonly="readonly" style="border: 0px; width:60px;" value="<?php  echo number_format($row_categorias->valorProduto,2,',','.');?>" />
                  </span>
                  <?php }}?></span> </div>
          <div class="product-action"> <a href="javascript: insertFavorito(<?php echo $row_categorias->cod_produto;?>)" class="paction add-wishlist" title="Lista de Desejos"> <span>Lista de Desejos</span> </a>  <?php if(!empty($_SESSION['id_do_cliente'])){ ?>
           <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_categorias->cod_produto;?>" class="paction add-cart" title="Adicionar ao Carrinho"> <span>Comprar</span> </a></div>
           <?php }else { ?>
           <div class="product-action"><a href="#" class="login-link paction add-cart" title="Clique aqui para logar"> <span>Ver Preço</span> </a> </div></div>
           <?php } ?>
        </div>
      </div>
    </div>
    <?php }} ?>
  </div>
</div>


<?php
 
/* agora vamos criar os botões "Anterior e próximo"
$anterior = $pc -1;
$proximo = $pc +1;
if ($pc>1) {
echo " <a href='?pagina=$anterior'><- Anterior</a> ";
}
echo "|";
if ($pc<$tp) {
echo " <a href='?pagina=$proximo'>Próxima -></a>";
}*/
?><ul class="pagination" style="float:right">
	
	 <?php if(($pc <= 1) < $tp){?>
      <li class="page-item"><a class="page-link" href="?pagina=1&categoria=<?php echo $_GET['categoria'];?>">1</a></li>
      <?php } ?>
	  <?php if($pc > 1){?>
      <li class="page-item"> <a class="page-link page-link-btn" href="?pagina=<?php echo $pc - 1;?>&categoria=<?php echo $_GET['categoria'];?>"><i class="icon-angle-left"></i></a> </li>
    <?php } ?>
      <li class="page-item active"> <a class="page-link" href="?pagina=<?php echo $pc;?>&categoria=<?php echo $_GET['categoria'];?>"><?php echo $pc;?> <span class="sr-only">(current)</span></a> </li>
      <?php if($pc < $tp){?>
      <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pc + 1;?>&categoria=<?php echo $_GET['categoria'];?>"><?php echo $pc + 1;?></a></li>
      <?php } ?>
      <?php if(($pc + 1) < $tp){?>
      <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pc + 2;?>&categoria=<?php echo $_GET['categoria'];?>"><?php echo $pc + 2;?></a></li>
      <?php } ?>
      <?php if(($pc + 2) < $tp){?>
      <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pc + 3;?>&categoria=<?php echo $_GET['categoria'];?>"><?php echo $pc + 3;?></a></li>
      <?php } ?>
      
      <?php if($pc != $tp){?>
      <li class="page-item"> <a class="page-link page-link-btn" href="?pagina=<?php echo $pc + 1;?>&categoria=<?php echo $_GET['categoria'];?>"><i class="icon-angle-right"></i></a> </li>
      <?php } ?>
      
      <li class="page-item"><a class="page-link" href="?pagina=<?php echo $tp;?>&categoria=<?php echo $_GET['categoria'];?>"><?php echo $tp;?></a></li>
      
    </ul>
