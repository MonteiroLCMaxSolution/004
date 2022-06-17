<?php
//session_start();
date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());
//$sha1 = $_SESSION['sha1_cadastro_cliente'];
 

//$status = 'ATIVO';

	$SQL_list_fornecedores = "SELECT cod_empresa, cod_marca, nome_marca, logo, visualizado from marca group by cod_marca";	
	$SQL_list_fornecedores = $pdo->prepare($SQL_list_fornecedores);
	$SQL_list_fornecedores->execute();
	if ($SQL_list_fornecedores){
	}else{
		$achou = 'Categoria não encontrada';
	}
	if (!empty($_GET['marca'])){
	$marca = $_GET['marca'];
	$SQL_list_item_fornec = "SELECT a.cod_categoria,a.cod_produto, a.nome_produto, c.valor_prazo AS valorProduto, b.nome AS nome_marca,e.valor_promocao, c.visualizado, IFNULL(d.imagem,'no-photo.png') AS imagem FROM produtos a 
INNER JOIN categoria b ON a.cod_categoria = b.cod_categoria
INNER JOIN produtos_empresa c ON a.cod_produto = c.cod_produto AND c.cod_empresa = '$codEmpresa'
LEFT JOIN imagens d ON a.cod_produto = d.cod_produto
LEFT JOIN promocao e ON a.cod_produto = e.cod_produto AND e.situacao = 'ATIVO' AND e.data_inicio <= NOW() AND e.data_fim >= NOW() AND e.cod_empresa = '$codEmpresa'
WHERE a.cod_marca = '$marca'  GROUP BY a.id";	
	$SQL_list_item_fornec = $pdo->prepare($SQL_list_item_fornec);
	$SQL_list_item_fornec->execute();
	}
?>