<?php 
include '../../model/fornecedores/fornecedores-model.php';
$idCliente = '';

if(!empty($_SESSION['id_do_cliente'])){
 $idCliente = $_SESSION['id_do_cliente'];
}
if (!empty($achou)){
	echo $achou;
}else{
	?>

<div class="container">
   <div class="row" style="background:#ececec; padding-top:20px">
   
   
           <?php	while ($row_fornecedores = $SQL_list_fornecedores->fetch()){ 
			  if(!empty($row_fornecedores->logo)){ ?>
              
              <div class="col-md-2">
              <div class="product">
              <a href="index-item.php?marca=<?php echo $row_fornecedores->cod_marca; ?>" target="_self" class="link-marca"> <img src="../../Painel/imagens/marca/<?php echo $row_fornecedores->logo; ?>" alt="<?php echo $row_fornecedores->nome_marca; ?>" class="image-marca"  />
                <center>
                  <h5> <?php //echo $row_fornecedores->nome_marca; ?></h5>
                </center>
                </a>
               </div>
                 </div>
              <?php }else{ ?>
              
              <div class="col-md-2" >
              <div class="product">
               <a href="index-item.php?marca=<?php echo $row_fornecedores->cod_marca; ?>" target="_self" class="link-marca"> <img src="../../Painel/imagens/marca/sem_foto.jpg" alt="<?php echo $row_fornecedores->nome_marca; ?>" class="image-marca"/>
                <center>
                  <h5> <?php echo $row_fornecedores->nome_marca; ?></h5>
                </center>
                </a>
                </div>
                </div>
              <?php }
		  } ?>
        
        </div>
      </div>
    <?php } ?> 