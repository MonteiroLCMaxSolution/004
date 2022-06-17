
<main class="main">
  <nav aria-label="breadcrumb" class="breadcrumb-nav">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page">Lista de Desejos</li>
      </ol>
    </div>
    <!-- End .container --> 
  </nav>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="cart-table-container">
          <table class="table table-cart">
            <thead>
              <tr>
                <th  class="product-col">Produto</th>
                <th  class="price-col">Valor</th>
                <th >Inserir</th>
              </tr>
            </thead>
            <tbody>
            	<?php 
				$count = 0;
				while ($row_lista_desejos = $SQL_lista_desejos->fetch()){
					$count++;?>
              <tr class="product-row">
                <td class="product-col"><figure class="product-image-container"><img src="../../Painel/imagens/produtos/<?php echo $row_lista_desejos->imagem;?>" alt="<?php echo $row_lista_desejos->nome_produto;?>">  </figure>
                  <h2 class="product-title"> <?php echo $row_lista_desejos->nome_produto;?> </h2></td>
                <td><?php echo 'R$ '.number_format($row_lista_desejos->valor_prazo,2,',','.');?></td>
                <td><!-- <input class="vertical-quantity form-control" type="text" value="<?php echo $row_lista_desejos->qtde;?>"> --><a href="../../view/dados-produto?codProduto=<?php echo $row_lista_desejos->cod_produto;?>" class="paction add-cart" title="Detalhes do produto"> <span>Detalhes</span> </a></td>
                
              </tr>
              <tr class="product-action-row">
                <td colspan="4" class="clearfix"><div class="float-left"> <a href="#" class="btn-move"></a> </div>
                  
                  <!-- End .float-left -->
                  
                  <div class="float-right"><a href="../../model/carrinho/carrinho.php?del_Fav=<?php echo $row_lista_desejos->id;?>" title="Remover Produto" class="btn-remove"><span class="sr-only">Remover</span></a> </div>
                  
                  <!-- End .float-right --></td>
              </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4" class="clearfix"><div class="float-left"> <a href="<?php echo $http;?>" class="btn btn-outline-secondary">Continue Comprando</a> </div>
                  
                  <!-- End .float-left -->
                  
                  
                  
                  <!-- End .float-right --></td>
              </tr>
            </tfoot>
          </table>
        </div>
        
      </div>
    </div>
    <!-- End .row --> 
  </div>
  <!-- End .container -->
  
  <div class="mb-6"></div>
  <!-- margin --> 
</main>