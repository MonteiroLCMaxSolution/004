<?php
//include '../../config.php';

if(!isset($_SESSION)){
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s');
$arquivo = 'config.php';

$parametro = 's';
$tag = '../';
while ($parametro != 'n'){
if (file_exists($arquivo)) {
    $parametro = 'n';
} else {
    $arquivo = $tag.$arquivo;
}
}

$BD = 'conexao-pdo/conexao-mysql-pdo.php';

$parametro = 's';
$tag = '../';
while ($parametro != 'n'){
if (file_exists($BD)) {
    $parametro = 'n';
} else {
    $BD = $tag.$BD;
}
}
require_once $arquivo;
require_once $BD;


//$sha1 = $_SESSION['sha1_cadastro_cliente'];

/*ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);*/

/* PRODUTOS MAIS VENDIDOS */
	if(empty($_SESSION['COD_EMPRESA_cliente'])){
		$codEmpresa  = '1';
	}else{
		$codEmpresa  = $_SESSION['COD_EMPRESA_cliente'];
	}
	$SQL_produtos_mais_vendidos = "SELECT COUNT(a.id_produto) AS visualizado, a.id_produto as codProduto, b.nome_produto, c.valor_prazo AS valorProduto,e.valor_promocao, ifnull(d.imagem, 'no-photo.png') AS imagem FROM carrinho a 
INNER JOIN produtos b ON a.id_produto = b.cod_produto
INNER JOIN produtos_empresa c ON b.cod_produto = c.cod_produto
LEFT JOIN imagens d ON c.cod_produto = d.cod_produto
LEFT JOIN promocao e ON b.cod_produto = e.cod_produto AND e.situacao = 'ATIVO' AND  CAST(NOW() AS DATE) BETWEEN CAST(e.data_inicio AS DATE) AND CAST(e.data_fim AS DATE) AND e.cod_empresa = '$codEmpresa'
WHERE a.id_produto IS NOT NULL AND c.cod_empresa = '1' GROUP BY a.id_produto limit 10";
	$SQL_produtos_mais_vendidos = $pdo->prepare($SQL_produtos_mais_vendidos);
	$SQL_produtos_mais_vendidos->execute();
/* FIM PRODUTOS MAIS VENDIDOS */

////RESULTADO DO CAMPO BUSCA 
	if (!empty($_POST['buscar'])){
	$opcaoBusca = str_replace(' ','%',$_POST['buscar']);
	$SQL_consulta = "SELECT a.id as idProduto, a.cod_produto,b.cod_marca AS marca,c.nome_marca, b.nome_produto,a.valor_prazo AS valorProduto,IFNULL(e.valor_promocao,0) as valor_promocao, c.nome_marca, a.visualizado, ifnull(d.imagem,'ImagemNaoDisponivel.png') AS imagem, ifnull(e.valor_promocao,0) AS promocao FROM produtos_empresa a 
INNER JOIN produtos b ON a.cod_produto = b.cod_produto
LEFT JOIN marca c ON b.cod_marca = trim(c.nome_marca)
LEFT JOIN imagens d ON b.cod_produto = d.cod_produto
LEFT JOIN promocao e ON a.cod_produto = e.cod_produto AND  CAST(NOW() AS DATE) BETWEEN CAST(e.data_inicio AS DATE) AND CAST(e.data_fim AS DATE)
 WHERE a.valor_prazo <> 0 and a.valor_prazo <> 0 and a.valor_prazo <> 0 and a.cod_produto = '$opcaoBusca' or a.valor_prazo <> 0 and  b.nome_produto LIKE '%$opcaoBusca%' OR a.valor_prazo <> 0 and c.nome_marca = '$opcaoBusca'
GROUP BY b.cod_produto";
$SQL_consulta = $pdo->prepare($SQL_consulta);
$SQL_consulta->execute();
}
/* FIM RESULTADO DO CAMPO BUSCA */

/* status do parametro do destaque */
	if (!empty($SQL_status_destaque)){
		$row_status_destaque = $SQL_status_destaque->fetch();
		if (isset($row_status_destaque->parametro)){
		$parametro = $row_status_destaque->parametro;
		}
		$SQL_listar_destaques = "SELECT a.cod_empresa, a.cod_produto,b.nome_produto, a.valor_prazo,IFNULL(d.valor_promocao,0) as valor_promocao, IFNULL(c.imagem,'no-photo.png') as imagem FROM produtos_empresa a INNER JOIN produtos b ON a.cod_produto = b.cod_produto LEFT JOIN imagens c ON a.cod_produto = c.cod_produto LEFT JOIN promocao d ON d.cod_empresa = a.cod_empresa AND d.cod_produto = a.cod_produto WHERE a.cod_empresa = '1' GROUP BY a.cod_produto ORDER BY a.visualizado DESC LIMIT 10";
		$SQL_listar_destaques = $pdo->prepare($SQL_listar_destaques);		
		$SQL_listar_destaques->execute();
	}
/* FIM - status do parametro do destaque */

	
/* LISTAR PRODUTOS */
	$vitrine = 1;
	$cod_empresa = 1;
	$status = 'ATIVO';
	$SQL_listar_produtos = "SELECT ifnull(d.imagem,'ImagemNaoDisponivel.png') AS imagem, a.cod_produto, a.valor_prazo, b.nome_produto, b.cod_marca AS marca, a.visualizado, IFNULL(c.valor_promocao,0) AS promocao FROM produtos_empresa a 
INNER JOIN produtos b ON a.cod_produto = b.cod_produto
LEFT JOIN promocao c ON b.cod_produto = c.cod_produto and c.data_inicio <= NOW() AND c.data_fim >= NOW() AND c.cod_empresa = :empresa
INNER JOIN imagens d ON a.cod_produto = d.cod_produto 
WHERE a.vitrine = :vitrini AND 
a.cod_empresa = :codempresa  AND a.valor_prazo > 0
 GROUP BY a.cod_produto ORDER BY a.visualizado ASC LIMIT 12;";
	$SQL_listar_produtos = $pdo->prepare($SQL_listar_produtos);
	$SQL_listar_produtos->bindValue('empresa',$cod_empresa);
	$SQL_listar_produtos->bindValue('vitrini',$vitrine);
	$SQL_listar_produtos->bindValue('codempresa',$cod_empresa);
	$SQL_listar_produtos->execute();

	if(!empty($_GET['codProduto'])){
		//echo 'passou no codProduto';
		$codPro = 	$_GET['codProduto'];
		if (!empty($_SESSION['COD_EMPRESA_cliente'])){
			$codEmpresa = $_SESSION['COD_EMPRESA_cliente'];
		}else{
			$codEmpresa = '1';
		}
		$SQL_dadosProduto = "SELECT a.id,a.minimo_produto_venda, a.cod_empresa, a.cod_produto, a.valor_prazo, a.unidade, b.nome_produto, c.valor_promocao, b.descricao, d.nome_marca, a.embalagem_produto, a.emb_venda
		FROM produtos_empresa a 
		INNER JOIN produtos b ON a.cod_produto = b.cod_produto AND a.cod_empresa = :codEmpresa
		LEFT JOIN promocao c ON a.cod_produto = c.cod_produto  AND c.situacao = 'ATIVO' AND c.data_inicio <= NOW() AND c.data_fim >= NOW() AND c.cod_empresa = :codEmpresa
		LEFT JOIN marca d ON b.cod_marca = d.cod_marca
		WHERE a.cod_produto = :codproduto AND a.cod_empresa = :codEmpresa group by a.cod_produto";
		$SQL_dadosProduto = $pdo->prepare($SQL_dadosProduto);
		$SQL_dadosProduto->bindValue('codEmpresa',$codEmpresa);
		$SQL_dadosProduto->bindValue('codproduto',$codPro);
		$SQL_dadosProduto->execute();
		
		$SQL_listar_imagens = "SELECT a.id, IFNULL(b.imagem,'no-photo.png') as imagem FROM produtos_empresa a
LEFT JOIN imagens b ON a.cod_produto = b.cod_produto
WHERE a.cod_produto = :codproduto AND a.cod_empresa = :codEmpresa;";
		$SQL_listar_imagens = $pdo->prepare($SQL_listar_imagens);
		
		$SQL_listar_imagens->bindValue('codproduto',$codPro);
		$SQL_listar_imagens->bindValue('codEmpresa',$cod_empresa);
		$SQL_listar_imagens->execute();
		
		$SQL_listar_imagem = "SELECT a.id, IFNULL(b.imagem,'no-photo.png') as imagem FROM produtos_empresa a
LEFT JOIN imagens b ON a.cod_produto = b.cod_produto
WHERE a.cod_produto = :codproduto AND a.cod_empresa = :codEmpresa;";
		$SQL_listar_imagem = $pdo->prepare($SQL_listar_imagem);
		
		$SQL_listar_imagem->bindValue('codproduto',$codPro);
		$SQL_listar_imagem->bindValue('codEmpresa',$cod_empresa);
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
		
	}

/* FIM - EXIBIR DADOS DO PRODUTO */

?>