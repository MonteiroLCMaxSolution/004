<?php
$total_reg  = '20';
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//$codEmpresa = (isset($_SESSION['COD_EMPRESA_cliente']))? $_SESSION['COD_EMPRESA_cliente'] : 1;
$codEmpresa = $_SESSION['COD_EMPRESA_cliente'];
if(!empty($codEmpresa)){
$and_CodEmpresa = 'AND a.cod_empresa = '.$codEmpresa.'';
}else{
$and_CodEmpresa = '';
}
$categoria = $_GET['buscar'];
 $pc = $pagina;
$inicio = $pc - 1;
$inicio = $inicio * $total_reg;

$limite = "SELECT a.id as idProduto, a.cod_produto, b.nome_produto,a.valor_prazo AS valorProduto, c.nome_marca, e.valor_promocao, a.visualizado, ifnull(d.imagem,'no-photo.png') AS imagem FROM produtos_empresa a
INNER JOIN produtos b ON a.cod_produto = b.cod_produto
LEFT JOIN marca c ON b.cod_marca = c.cod_marca
LEFT JOIN imagens d ON b.cod_produto = d.cod_produto
LEFT JOIN promocao e ON b.cod_produto = e.cod_produto AND e.situacao = 'ATIVO' AND e.data_inicio <= NOW() AND e.data_fim >= NOW() AND e.cod_empresa = '$codEmpresa'
WHERE a.cod_produto = '$categoria' $and_CodEmpresa AND a.status_produto like 'ATIVO' or  b.nome_produto LIKE '%$categoria%' $and_CodEmpresa AND a.status_produto like 'ATIVO' OR c.nome_marca = '$categoria' $and_CodEmpresa AND a.status_produto like 'ATIVO'
GROUP BY b.cod_produto LIMIT $inicio,$total_reg";
$limite = $pdo->prepare($limite);
$limite->execute();

$total = "SELECT a.id as idProduto, a.cod_produto, b.nome_produto,a.valor_prazo AS valorProduto, c.nome_marca, a.visualizado, ifnull(d.imagem,'no-photo.png') AS imagem FROM produtos_empresa a 
INNER JOIN produtos b ON a.cod_produto = b.cod_produto
LEFT JOIN marca c ON b.cod_marca = c.cod_marca
LEFT JOIN imagens d ON b.cod_produto = d.cod_produto
WHERE a.cod_produto = '$categoria' $and_CodEmpresa AND a.status_produto like 'ATIVO' or  b.nome_produto LIKE '%$categoria%'  $and_CodEmpresa AND a.status_produto like 'ATIVO' OR c.nome_marca = '$categoria' 
$and_CodEmpresa AND a.status_produto like 'ATIVO' GROUP BY b.cod_produto";
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
 $idCliente = $_SESSION['id_do_cliente'];
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
        <figure style="width:189px; height:179px" class="product-image-container"> <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_categorias->cod_produto;?>" class="product-image"> <img src="<?php echo $http;?>/Painel/imagens/produtos/<?php echo $row_categorias->imagem;?>" alt="<?php echo 'Visualizado: '.$row_categorias->visualizado;?>" title="<?php echo 'Visualizado: '.$row_categorias->visualizado;?>"> </a> <a href="<?php echo $http;?>/ajax/product-quick-view.php?codProduto=<?php echo $row_categorias->cod_produto;?>" class="btn-quickview">Olhada Rápida</a> </figure>
        <div class="product-details">
          
          <h2 class="product-title" style="height:53px"> <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_categorias->cod_produto;?>&amp;name=<?php echo $row_categorias->nome_produto;?>"><?php echo $row_categorias->cod_produto.' - '.$row_categorias->nome_produto;?></a> </h2>
          <div class="price-box"> <span class="product-price">
		  <?php if(!empty($idCliente)){ ?>
			 <?php if($_SESSION['COD_EMPRESA_cliente'] == 1) { ?>
			    <?php if ($row_categorias->valor_promocao > 0 ){ ?>
                  <div class="col-sm-12 col-md-12 col-lg-12" align="center">
                  <span class="old-price">De:
                  <?php  echo 'R$ '.number_format($row_categorias->valorProduto,2,',','.');?>
                  </span>
                </div>
                 <span class="product-price" style="color:#F00">Por:
                  <?php  echo 'R$ '.number_format($row_categorias->valor_promocao,2,',','.');?>
                  </span> 
                <?php }else{ ?>
                <span class="product-price">Por:
                  <?php  echo 'R$ '.number_format($row_categorias->valorProduto,2,',','.');?>
                  </span> 
                <?php } ?>
			<?php }else{ ?>
				<?php if ($row_categorias->valor_promocao > 0 ){
				$Valor_venda = $row_categorias->valor_promocao;
				
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
                  <span class="old-price">De:
                  <?php  echo 'R$ '.number_format($row_categorias->valorProduto,2,',','.');?>
                  </span>
                </div>
                 <span class="product-price" style="color:#F00">Por:
                  <?php  echo 'R$ '.number_format($Valor_venda,2,',','.').' + ST '.number_format($st,2,',','.');?>
                  </span> 
                  
                  <?php }else{
				$Valor_venda = $row_categorias->valorProduto;
				
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
                 
                 	 <div align="center">
                   <?php  echo 'R$ '.number_format($Valor_venda,2,',','.').' + ST '.number_format($st,2,',','.');?>
                  	</div>
                  </span>
                  
                  <?php } ?>
                  <?php }
			  }?></span> </div>
           <div class="product-action"> <a href="javascript: insertFavorito(<?php echo $row_categorias->cod_produto;?>)" class="paction add-wishlist" title="Lista de Desejos"> <span>Lista de Desejos</span> </a> 
          <?php if(!empty($_SESSION['id_do_cliente'])){ ?>
           <a href="<?php echo $http;?>/view/dados-produto?codProduto=<?php echo $row_categorias->cod_produto;?>" class="paction add-cart" title="Adicionar ao Carrinho"> <span>Comprar</span> </a></div>
           <?php }else { ?>
           <div class="product-action"><a href="#" class="login-link paction add-cart" title="Clique aqui para logar"> <span>Ver Preço</span> </a> </div></div>
           <?php } ?>
           
        </div>
      </div>
    </div>
    <?php }
	} ?>
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
      <li class="page-item"><a class="page-link" href="?pagina=1&buscar=<?php echo $_GET['buscar'];?>">1</a></li>
      <?php } ?>
	  <?php if($pc > 1){?>
      <li class="page-item"> <a class="page-link page-link-btn" href="?pagina=<?php echo $pc - 1;?>&buscar=<?php echo $_GET['buscar'];?>"><i class="icon-angle-left"></i></a> </li>
    <?php } ?>
      <li class="page-item active"> <a class="page-link" href="?pagina=<?php echo $pc;?>&buscar=<?php echo $_GET['buscar'];?>"><?php echo $pc;?> <span class="sr-only">(current)</span></a> </li>
      <?php if($pc < $tp){?>
      <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pc + 1;?>&buscar=<?php echo $_GET['buscar'];?>"><?php echo $pc + 1;?></a></li>
      <?php } ?>
      <?php if(($pc + 1) < $tp){?>
      <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pc + 2;?>&buscar=<?php echo $_GET['buscar'];?>"><?php echo $pc + 2;?></a></li>
      <?php } ?>
      <?php if(($pc + 2) < $tp){?>
      <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pc + 3;?>&buscar=<?php echo $_GET['buscar'];?>"><?php echo $pc + 3;?></a></li>
      <?php } ?>
      
      <?php if($pc != $tp){?>
      <li class="page-item"> <a class="page-link page-link-btn" href="?pagina=<?php echo $pc + 1;?>&buscar=<?php echo $_GET['buscar'];?>"><i class="icon-angle-right"></i></a> </li>
      <?php } ?>
      
      <li class="page-item"><a class="page-link" href="?pagina=<?php echo $tp;?>&buscar=<?php echo $_GET['buscar'];?>"><?php echo $tp;?></a></li>
      
    </ul>
