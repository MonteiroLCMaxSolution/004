<?php 
if(!isset($_SESSION))
{
   session_start();
}

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s');
$dataLo = date('Y-m-d');
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
    $arquivo = $tag.$BD;
}
}
require_once $arquivo;
require_once $BD;

/*-------------------- MOSTRAR ITENS NA INDEX -------------- */
$consulta_promocao = $pdo->prepare("SELECT a.cod_produto, b.nome_produto,d.valor_prazo AS valor_atual, a.valor_promocao, ifnull(c.imagem,'ImagemNaoDisponivel.png') as imagem FROM promocao a
INNER JOIN produtos b ON a.cod_produto = b.cod_produto
LEFT JOIN imagens c ON a.cod_produto = c.cod_produto
INNER JOIN produtos_empresa d ON a.cod_produto = d.cod_produto
WHERE a.situacao = 'ATIVO' AND a.data_fim >= :dataLocal");





/*$consulta_promocao = $pdo->prepare("SELECT a.cod_produto as cod_produto, b.imagem as imagem, c.nome_produto, a.valor_prazo, 
d.valor_promocao
	FROM promocao d
	LEFT JOIN imagens b ON d.cod_produto = b.cod_produto
	INNER JOIN produtos c ON d.cod_produto = c.cod_produto
	LEFT JOIN produtos_empresa a ON 
	a.cod_produto = d.cod_produto 
	AND d.situacao = 'ATIVO' 
	AND d.data_inicio <= NOW() 
	AND d.data_fim >= NOW() 
	AND d.cod_empresa = '1'
	 WHERE b.imagem is not null AND d.situacao = 'Ativo' and d.data_fim >= :dataLocal
	 AND a.cod_empresa = '1' 
	 GROUP BY c.nome_produto 
	 ORDER BY a.visualizado LIMIT 20");*/





$consulta_promocao->bindValue('dataLocal',$dataLo);
$consulta_promocao->execute();

?>