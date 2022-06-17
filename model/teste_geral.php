<?php
if(!isset($_SESSION)){
	session_start();
}
$arquivo = 'conexao-pdo/conexao-mysql-pdo.php';

$parametro = 's';
$tag = '';
while ($parametro != 'n'){
	if (file_exists($tag.$arquivo)) {
		$parametro = 'n';
	} else {
		$tag = '../'.$tag;
	}
}
$arquivo = $tag.$arquivo;

include_once($arquivo);

$config = 'conexao-pdo/config.php';

$parametro = 's';
$tag = '';
while ($parametro != 'n'){
	if (file_exists($tag.$config)) {
		$parametro = 'n';
	} else {
		$tag = '../'.$tag;
	}
}
$config = $tag.$config;

include_once($arquivo);
include_once($config);

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());
$sha1 = $_SESSION['sha_carrinho'];

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); 



/* VERIFICAR SE EXISTE ALGUM PEDIDO QUE NÃO FOI FINALIZADO - LEÔNIDAS MONTEIRO - 15/04/2021*/
	$SQL_verificar_registros_anteriores = "SELECT a.id, a.id_produto, a.cod_empresa, a.valor_unitario, a.valor_total, a.qtde, 
(SELECT ifnull(f.valor_promocao,i.valor_prazo)  FROM produtos_empresa i
LEFT JOIN promocao f ON i.cod_produto = f.cod_produto AND i.cod_empresa = f.cod_empresa AND CAST(NOW() AS DATE) BETWEEN CAST(f.data_inicio AS DATE) AND CAST(f.data_fim AS DATE)
 WHERE i.cod_produto = a.id_produto AND i.cod_empresa = '1') AS valorAtual,
 (SELECT i.estoque_disponivel FROM produtos_empresa i
LEFT JOIN promocao f ON i.cod_produto = f.cod_produto AND i.cod_empresa = f.cod_empresa AND CAST(NOW() AS DATE) BETWEEN CAST(f.data_inicio AS DATE) AND CAST(f.data_fim AS DATE)
 WHERE i.cod_produto = a.id_produto AND i.cod_empresa = '1') AS estoqueDisponivel
 
  fROM pedido_item a WHERE a.id_cliente = :id_cliente AND a.finalizou = 'N';;";
	$SQL_verificar_registros_anteriores = $pdo->prepare($SQL_verificar_registros_anteriores);
	$SQL_verificar_registros_anteriores->bindValue(':id_cliente','1562');
	$SQL_verificar_registros_anteriores->execute();
	if($SQL_verificar_registros_anteriores->rowCount() > 0){
		while($row_listar_registros_anteriores = $SQL_verificar_registros_anteriores->fetch()){
			$idPedido = $row_listar_registros_anteriores->id;
			$valorAtual = $row_listar_registros_anteriores->valorAtual;
			if($row_listar_registros_anteriores->qtde >= $row_listar_registros_anteriores->estoqueDisponivel){
				$qtde = $row_listar_registros_anteriores->estoqueDisponivel;
			}else{
				$qtde = $row_listar_registros_anteriores->qtde;
			}
			$valorTotal = (float)$valorAtual * (float)$qtde;
			echo 'ID Pedido: '.$idPedido;
			echo '<BR/>Valor Atual: '.$valorAtual;
			echo '<BR/>Qtde: '.$qtde;
			echo '<BR/>Valor Total: '.$valorTotal;
			echo '<BR/>--------<BR/>';

			/* ALTERA OS DADOS DO REGISTRO, CASO ENCONTRE - LEÔNIDAS MONTEIRO - 15/04/2021 */ 
				$SQL_atualiza_item_pedido = "UPDATE pedido_item SET SHA1 = 1, valor_unitario = :valor_unitario, valor_original = :valor_original, qtde = :qtde, valor_total = :valor_total WHERE id = :id;";
				$SQL_atualiza_item_pedido = $pdo->prepare($SQL_atualiza_item_pedido);
				$SQL_atualiza_item_pedido->bindValue('valor_unitario',$valorAtual);
				$SQL_atualiza_item_pedido->bindValue('valor_original',$valorAtual);
				$SQL_atualiza_item_pedido->bindValue('qtde',$qtde);
				$SQL_atualiza_item_pedido->bindValue('valor_total',$valorTotal);
				$SQL_atualiza_item_pedido->bindValue('id',$idPedido);
				$SQL_atualiza_item_pedido->execute();

			/* FIM ALTERA OS DADOS DO REGISTRO, CASO ENCONTRE */




		}
	}
/* FIM - VERIFICAR SE EXISTE ALGUM PEDIDO QUENÃO FOI FINALIZADO */

		?>