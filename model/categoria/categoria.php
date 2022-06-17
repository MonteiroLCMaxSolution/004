<?php
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

////CONSULTAR POR CATEGORIA 
// @Alterado em 04/04/2020
if (!empty($_GET['codCategoria'])){
	$opcaoBusca = $_GET['codCategoria'];
	$SQL_consulta = "SELECT  b.cod_produto, b.nome_produto, b.cod_marca,a.valor_prazo AS valorProduto,IFNULL(e.valor_promocao,0) as valor_promocao, a.visualizado, ifnull(d.imagem,'ImagemNaoDisponivel.png') AS imagem, ifnull(e.valor_promocao,0) AS promocao  FROM produtos b
	INNER JOIN produtos_empresa a ON a.cod_produto = b.cod_produto
	LEFT JOIN promocao e ON a.cod_produto = e.cod_produto AND  CAST(NOW() AS DATE) BETWEEN CAST(e.data_inicio AS DATE) AND CAST(e.data_fim AS DATE)
	LEFT JOIN imagens d ON d.cod_produto = a.cod_produto
	WHERE b.cod_categoria = :cod_categoria  GROUP BY a.cod_produto ORDER BY b.nome_produto asc;";
	$SQL_consulta = $pdo->prepare($SQL_consulta);
	$SQL_consulta->bindValue('cod_categoria',$opcaoBusca);
	$SQL_consulta->execute();
}
/* FIM CONSULTAR POR CATEGORIA */

////CONSULTAR POR CATEGORIA 
if (!empty($_GET['subCategoria'])){
	$opcaoBusca = $_GET['subCategoria'];
	$SQL_consulta = "SELECT  b.cod_produto, b.nome_produto, b.cod_marca,a.valor_prazo AS valorProduto,IFNULL(e.valor_promocao,0) as valor_promocao, a.visualizado, ifnull(d.imagem,'ImagemNaoDisponivel.png') AS imagem, ifnull(e.valor_promocao,0) AS promocao  FROM produtos b
	INNER JOIN produtos_empresa a ON a.cod_produto = b.cod_produto
	LEFT JOIN promocao e ON a.cod_produto = e.cod_produto AND  CAST(NOW() AS DATE) BETWEEN CAST(e.data_inicio AS DATE) AND CAST(e.data_fim AS DATE)
	LEFT JOIN imagens d ON d.cod_produto = a.cod_produto
	WHERE b.cod_subcategoria = :cod_categoria  GROUP BY a.cod_produto ORDER BY b.nome_produto asc;";
	$SQL_consulta = $pdo->prepare($SQL_consulta);
	$SQL_consulta->bindValue('cod_categoria',$opcaoBusca);
	$SQL_consulta->execute();
}
/* FIM CONSULTAR POR CATEGORIA */
/*---------- LISTAR TODAS AS CATEGORIAS - LEÔNIDAS MONTEIRO - 19/08/2020 */
$SQL_listar_categorias = "SELECT a.cod_categoria FROM produtos a 
WHERE a.cod_categoria <> '' AND a.cod_categoria <> 'OUTROS' AND a.cod_categoria <> 'ST' GROUP BY a.cod_categoria";
$SQL_listar_categorias = $pdo->prepare($SQL_listar_categorias);
$SQL_listar_categorias->execute();
/*========== LISTAR TODAS AS CATEGORIAS - LEÔNIDAS MONTEIRO - 19/08/2020 */


?>