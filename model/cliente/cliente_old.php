<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


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

/* função para validar o CNPJ */
function validar_cnpj($cnpj)
{
	$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
		// Valida tamanho
	if (strlen($cnpj) != 14)
		return false;
		// Valida primeiro dígito verificador
	for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
		return false;
		// Valida segundo dígito verificador
	for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
}
/*       LISTAR DADOS DO CLIENTE LOGADO */
if(!empty($_SESSION['id_do_cliente'])){
	$codCliente = $_SESSION['id_do_cliente'];
	$SQL_dados_cliente = "SELECT * FROM cliente WHERE COD_CLIENTE = :COD_CLIENTE;";
	$SQL_dados_cliente = $pdo->prepare($SQL_dados_cliente);
	$SQL_dados_cliente->bindValue('COD_CLIENTE',$codCliente);
	$SQL_dados_cliente->execute();		
}
/* FIM - LISTAR DADOS DO CLIENTE LOGADO */
/* EDITAR DADOS DO CLIENTE */
/*	if (!empty($_GET['edt'])){
		$company = anti_injection($_POST['empresa']);
		$company = filter_var($company, FILTER_SANITIZE_STRING);
	
		$contact = anti_injection($_POST['contato']);
		$contact = filter_var($contact, FILTER_SANITIZE_STRING);
		
		$email = anti_injection($_POST['email']);
		$email = filter_var($email, FILTER_SANITIZE_STRING);
		
		$phone = anti_injection($_POST['fone']);
		$phone = filter_var($phone, FILTER_SANITIZE_STRING);
		
		$name = anti_injection($_POST['nome_fantasia']);
		$name = filter_var($name, FILTER_SANITIZE_STRING);
		
		$email_collection = anti_injection($_POST['email_cobranca']);
		$email_collection = filter_var($email_collection, FILTER_SANITIZE_STRING);
		
		$cell = anti_injection($_POST['celular']);
		$cell = filter_var($cell, FILTER_SANITIZE_STRING);
		
		$vat_no = anti_injection($_POST['CNPJ']);
		$vat_no = filter_var($vat_no, FILTER_SANITIZE_STRING);
		
		$IE = anti_injection($_POST['IE']);
		$IE = filter_var($IE, FILTER_SANITIZE_STRING);
		
		$IM = anti_injection($_POST['IM']);
		$IM = filter_var($IM, FILTER_SANITIZE_STRING);
		
		$postal_code = anti_injection($_POST['CEP']);
		$postal_code = filter_var($postal_code, FILTER_SANITIZE_STRING);
		
		$state = anti_injection($_POST['uf']);
		$state = filter_var($state, FILTER_SANITIZE_STRING);
		
		$city = anti_injection($_POST['cidade']);
		$city = filter_var($city, FILTER_SANITIZE_STRING);
		
		$neighbourhood = anti_injection($_POST['bairro']);
		$neighbourhood = filter_var($neighbourhood, FILTER_SANITIZE_STRING);
		
		$address = anti_injection($_POST['endereco']);
		$address = filter_var($address, FILTER_SANITIZE_STRING);
		
		$number = anti_injection($_POST['numero']);
		$number = filter_var($number, FILTER_SANITIZE_STRING);
		
		$complement = anti_injection($_POST['complemento']);
		$complement = filter_var($complement, FILTER_SANITIZE_STRING);
		
		$login = anti_injection($_POST['login']);
		$login = filter_var($login, FILTER_SANITIZE_STRING);
		
		$password = anti_injection($_POST['senha']);
		$password = filter_var($password, FILTER_SANITIZE_STRING);
		
		$password = password_hash($password, PASSWORD_DEFAULT);
		//$password = sha1($password);
		
		$codCliente = $_POST['codigo'];
		if (!empty($_POST['senha'])){
			$SQL_edt_customer = "UPDATE cliente SET 
				RAZ_SOCIAL = :company,
				CONTATO = :contact,
				MAIL_CONTATO = :email,
				NUM_TEL_1 = :phone,
				FANTASIA = :name,
				EMAIL_NFE = :email_collection,
				NUM_TEL_2 = :cell,
				INSC_EST = :IE,
				INSC_MUNICIP = :IM,
				CEP = :postal_code,
				COD_UF = :state,
				COD_CIDADE = :city,
				BAIRRO = :neighbourhood,
				ENDERECO = :address,
				ENDERECO_NUMERO = :number,
				ENDERECO_COMP = :complement,
				LOGIN = :login,
				PASSWORD = :password,
				DATA_ATUALIZACAO = :update_date
				WHERE COD_CLIENTE = :vat_no";
				$SQL_edt_customer = $pdo->prepare($SQL_edt_customer);
				$SQL_edt_customer->bindValue('company',$company);
				$SQL_edt_customer->bindValue('contact',$contact);
				$SQL_edt_customer->bindValue('email',$email);
				$SQL_edt_customer->bindValue('phone',$phone);
				$SQL_edt_customer->bindValue('name',$name);
				$SQL_edt_customer->bindValue('email_collection',$email_collection);
				$SQL_edt_customer->bindValue('cell',$cell);
				$SQL_edt_customer->bindValue('IE',$IE);
				$SQL_edt_customer->bindValue('IM',$IM);
				$SQL_edt_customer->bindValue('postal_code',$postal_code);
				$SQL_edt_customer->bindValue('state',$state);
				$SQL_edt_customer->bindValue('city',$city);
				$SQL_edt_customer->bindValue('neighbourhood',$neighbourhood);
				$SQL_edt_customer->bindValue('address',$address);
				$SQL_edt_customer->bindValue('number',$number);
				$SQL_edt_customer->bindValue('complement',$complement);
				$SQL_edt_customer->bindValue('login',$login);
				$SQL_edt_customer->bindValue('password',$password);
				$SQL_edt_customer->bindValue('update_date',$dataLocal);
				$SQL_edt_customer->bindValue('vat_no',$codCliente);
				$SQL_edt_customer->execute();
				
		}else{
			$SQL_edt_customer = "UPDATE cliente SET 
				RAZ_SOCIAL = :company,
				CONTATO = :contact,
				MAIL_CONTATO = :email,
				NUM_TEL_1 = :phone,
				FANTASIA = :name,
				EMAIL_NFE = :email_collection,
				NUM_TEL_2 = :cell,
				INSC_EST = :IE,
				INSC_MUNICIP = :IM,
				CEP = :postal_code,
				COD_UF = :state,
				COD_CIDADE = :city,
				BAIRRO = :neighbourhood,
				ENDERECO = :address,
				ENDERECO_NUMERO = :number,
				ENDERECO_COMP = :complement,
				LOGIN = :login,
				DATA_ATUALIZACAO = :update_date
				WHERE COD_CLIENTE = :vat_no";
				$SQL_edt_customer = $pdo->prepare($SQL_edt_customer);
				$SQL_edt_customer->bindValue('company',$company);
				$SQL_edt_customer->bindValue('contact',$contact);
				$SQL_edt_customer->bindValue('email',$email);
				$SQL_edt_customer->bindValue('phone',$phone);
				$SQL_edt_customer->bindValue('name',$name);
				$SQL_edt_customer->bindValue('email_collection',$email_collection);
				$SQL_edt_customer->bindValue('cell',$cell);
				$SQL_edt_customer->bindValue('IE',$IE);
				$SQL_edt_customer->bindValue('IM',$IM);
				$SQL_edt_customer->bindValue('postal_code',$postal_code);
				$SQL_edt_customer->bindValue('state',$state);
				$SQL_edt_customer->bindValue('city',$city);
				$SQL_edt_customer->bindValue('neighbourhood',$neighbourhood);
				$SQL_edt_customer->bindValue('address',$address);
				$SQL_edt_customer->bindValue('number',$number);
				$SQL_edt_customer->bindValue('complement',$complement);
				$SQL_edt_customer->bindValue('login',$login);
				$SQL_edt_customer->bindValue('update_date',$dataLocal);
				$SQL_edt_customer->bindValue('vat_no',$codCliente);
				$SQL_edt_customer->execute();
				
		}
		if ($SQL_edt_customer){
					/* GRAVAR LOG 
					$query_LOG = 'PDATE cliente SET 
					company = '.$company.',
					contact = '.$contact.',
					email = '.$email.',
					phone = '.$phone.',
					name = '.$name.',
					email_collection = '.$email_collection.',
					cell = '.$cell.',
					IE = '.$IE.',
					IM = '.$IM.',
					postal_code = '.$postal_code.',
					state = '.$state.',
					city = '.$city.',
					neighbourhood = '.$neighbourhood.',
					address = '.$address.',
					number = '.$number.',
					complement = '.$complement.',
					login = '.$login.',
					password = '.$password.',
					update_date = '.$dataLocal.'
					WHERE vat_no = '.$CNPJ;
				
					$IP = $_SERVER["REMOTE_ADDR"];
					$descricao = 'CLIENTE ATUALIZOU SEUS DADOS';
					$usuario = $company;
					$SQL_GRV_LOG = "insert into logs(datahora,acao,IP,descricao,usuario)values(
					:datahora,
					:acao,
					:IP,
					:descricao,
					:usuario)";
					$SQL_GRV_LOG = $pdo->prepare($SQL_GRV_LOG);
					$SQL_GRV_LOG->bindValue('datahora',$dataLocal);
					$SQL_GRV_LOG->bindValue('acao',$query_LOG);
					$SQL_GRV_LOG->bindValue('IP',$IP);
					$SQL_GRV_LOG->bindValue('descricao',$descricao);
					$SQL_GRV_LOG->bindValue('usuario',$usuario);
					$SQL_GRV_LOG->execute();	
					?>
						<script type="application/javascript">
                            alert ("Dados atualizado com sucesso!");
                            window.location.href='<?php echo $http;?>';
                        </script>
                	<?php
				/* FIM - GRAVAR LOG 
				}else{
					?>
						<script type="application/javascript">
                            alert ("Error ao atualizar os dados!");
                            history.go(-1);
                        </script>
                	<?php
				}
		
		
		
		
			}*/
			/* FIM - EDITAR DADOS DO CLIENTE */


			if (!empty($_GET['login'])){
				if($_POST['codProduto'] != $_POST['login']){
					$codProduto = $_POST['codProduto'];
				}else{
					$codProduto = '';
				}

				$login = anti_injection($_POST['login']);
				$login = filter_var($login, FILTER_SANITIZE_STRING);
				$password = anti_injection($_POST['password']);
				$password = filter_var($password, FILTER_SANITIZE_STRING);

				//$SQL_login = "select * from cliente where LOGIN = :login AND status_cliente = 'ATIVO' or MAIL_CONTATO = :login AND status_cliente = 'ATIVO' or CNPJ_CPF = :login AND status_cliente = 'ATIVO'";
				$SQL_login = "SELECT * FROM cliente a WHERE a.MAIL_CONTATO = :login AND a.status_cliente = 'ATIVO' OR  a.LOGIN = :login AND a.status_cliente = 'ATIVO';";
				//$SQL_login = "select * from cliente where MAIL_CONTATO = :login AND status_cliente = 'ATIVO' or CNPJ_CPF = :login AND status_cliente = 'ATIVO'";
				
				$SQL_login = $pdo->prepare($SQL_login);
		//$SQL_login->bindValue('email',$login);
				$SQL_login->bindValue('login',$login);
				$SQL_login->execute();
				$row_login = $SQL_login->fetch();
				if (!empty($row_login) && $row_login->status_cliente == 'ATIVO'){
					if(!empty($row_login) && password_verify($password, $row_login->PASSWORD)){
						$_SESSION['id_do_cliente'] = $row_login->COD_CLIENTE;
						$_SESSION['nome_do_cliente'] = $row_login->RAZ_SOCIAL;
						$_SESSION['last_access'] = $row_login->ULTIMO_ACESSO;
						$_SESSION['access_customer'] = $row_login->ACESSOS;
						$_SESSION['email_do_cliente'] = $row_login->MAIL_CONTATO;
						$_SESSION['COD_EMPRESA_cliente'] = $row_login->COD_EMPRESA;
						$_SESSION['sha1_cliente'] = $row_login->SHA1;
						$_SESSION['COD_UF'] = $row_login->COD_UF;
						$_SESSION['COD_CIDADE'] = $row_login->COD_CIDADE;
						/* Verificar cidade */
						$SQL_consultar_cidade = "SELECT * FROM cidade_atendida WHERE cod_empresa = :codEmpresa";
						$SQL_consultar_cidade = $pdo->prepare($SQL_consultar_cidade);
						$CodEmpresa = $_SESSION['COD_EMPRESA_cliente'];
						$SQL_consultar_cidade->bindValue('codEmpresa',$CodEmpresa);
				//$SQL_consultar_cidade->bindValue('nomeCidade',$_SESSION['COD_CIDADE']);
				//$SQL_consultar_cidade->bindValue('nomeUF',$_SESSION['COD_UF']);
						$SQL_consultar_cidade->execute();
						if ($SQL_consultar_cidade->rowCount() > 0){
							$_SESSION['permissaoCidades'] = 's';
						}else{

							$_SESSION['permissaoCidades'] = 'n';
						}
						/* FIM - Verificar cidade */
						/* VERIFICAR SE EXISTE ALGUM PEDIDO QUE NÃO FOI FINALIZADO - LEÔNIDAS MONTEIRO - 15/04/2021*/

						// 1º passo) VERIFICA NA TABELA pedido_item SE O CAMPO FINALIZOU ESTÁ COM "N"
						$SQL_finalizou = "SELECT a.id AS id_pedido_item,e.id AS id_produto_click, a.id_produto,e.id_produto, b.nome_produto, ifnull(a.qtde,c.minimo_produto_venda) AS qtde, c.estoque_disponivel,c.minimo_produto_venda,a.valor_unitario, c.valor_prazo,a.valor_total,
IFNULL(d.valor_promocao,0) AS promocao, if(IFNULL(d.valor_promocao,0) > 0,d.valor_promocao,c.valor_prazo) AS valor_prazo_atual,(if(IFNULL(d.valor_promocao,0) > 0,d.valor_promocao,c.valor_prazo) * ifnull(a.qtde,c.minimo_produto_venda)) AS valor_total_atual

 FROM pedido_item a
INNER JOIN produtos b ON a.id_produto = b.cod_produto
INNER JOIN produtos_empresa c ON b.cod_produto = c.cod_produto AND a.cod_empresa = c.cod_empresa
left JOIN promocao d ON c.cod_produto = d.cod_produto AND c.cod_empresa = d.cod_empresa AND CAST(NOW() AS DATE) BETWEEN CAST(d.data_inicio AS DATE) AND CAST(d.data_fim AS DATE)
LEFT JOIN produto_click e ON a.SHA1 = e.sha1 AND a.id_produto = e.id_produto
WHERE a.id_cliente = :id_cliente AND a.finalizou = 'N' AND ifnull(a.qtde,c.minimo_produto_venda) <= c.estoque_disponivel;";
$SQL_finalizou = $pdo->prepare($SQL_finalizou);
$SQL_finalizou->bindValue('id_cliente',$_SESSION['id_do_cliente']);
$SQL_finalizou->execute();
 // FIM DO 1º PASSO
 // 2º PASSO) EDITA AS TABELAS pedido_item e produto_click
while ($row_finalizou = $SQL_finalizou->fetch()){
	$valor_unitario = $row_finalizou->valor_prazo_atual;
	$qtde = $row_finalizou->qtde;
	$id_pedido_item = $row_finalizou->id_pedido_item;
	$id_produto_click = $row_finalizou->id_produto_click;
	$valor_total = $row_finalizou->valor_total_atual;
	// atualizar a tabela pedido_item
	$SQL_update_pedido_item = "UPDATE pedido_item SET valor_unitario = :valor_unitario, qtde = :qtde,SHA1 = :SHA1, valor_total = :valor_total, data_atualizacao = :data_atualizacao WHERE id = :id;";
	$SQL_update_pedido_item = $pdo->prepare($SQL_update_pedido_item);
	$SQL_update_pedido_item->bindValue('valor_unitario',$valor_unitario);
	$SQL_update_pedido_item->bindValue('qtde',$qtde);
	$SQL_update_pedido_item->bindValue('SHA1',$_SESSION['sha_carrinho']);
	$SQL_update_pedido_item->bindValue('valor_total',$valor_total);
	$SQL_update_pedido_item->bindValue('data_atualizacao',$dataLocal);
	$SQL_update_pedido_item->bindValue('id',$id_pedido_item);
	$SQL_update_pedido_item->execute();
	// atualizar a tabela produto_click
	$SQL_update_produto_click = "UPDATE produto_click SET sha1 = :sha1 WHERE id = :id;";
	$SQL_update_produto_click = $pdo->prepare($SQL_update_produto_click);
	$SQL_update_produto_click->bindValue('sha1',$_SESSION['sha_carrinho']);
	$SQL_update_produto_click->bindValue('id',$id_produto_click);
	$SQL_update_produto_click->execute();

}
 // FIM DO 2º PASSO
/* .VERIFICAR SE EXISTE ALGUM PEDIDO QUE NÃO FOI FINALIZADO*/

						/*$SQL_altera_SHA1 = "UPDATE produto_click SET sha1 = :sha1 WHERE id_cliente = :id_cliente and status = 'CARRINHO';";
						$SQL_altera_SHA1 = $pdo->prepare($SQL_altera_SHA1);
						$SQL_altera_SHA1->bindValue('sha1',$_SESSION['sha_carrinho']);
						$SQL_altera_SHA1->bindValue('id_cliente',$_SESSION['id_do_cliente']);
						$SQL_altera_SHA1->execute();











						$SQL_verificar_registros_anteriores = "SELECT a.id, a.id_produto, a.cod_empresa, a.valor_unitario, a.valor_total, a.qtde, 
						(SELECT ifnull(f.valor_promocao,i.valor_prazo)  FROM produtos_empresa i
						LEFT JOIN promocao f ON i.cod_produto = f.cod_produto AND i.cod_empresa = f.cod_empresa AND CAST(NOW() AS DATE) BETWEEN CAST(f.data_inicio AS DATE) AND CAST(f.data_fim AS DATE)
						WHERE i.cod_produto = a.id_produto AND i.cod_empresa = '1') AS valorAtual,
						(SELECT i.estoque_disponivel FROM produtos_empresa i
						LEFT JOIN promocao f ON i.cod_produto = f.cod_produto AND i.cod_empresa = f.cod_empresa AND CAST(NOW() AS DATE) BETWEEN CAST(f.data_inicio AS DATE) AND CAST(f.data_fim AS DATE)
						WHERE i.cod_produto = a.id_produto AND i.cod_empresa = '1') AS estoqueDisponivel

						fROM pedido_item a WHERE a.id_cliente = :id_cliente AND a.finalizou = 'N';";
						$SQL_verificar_registros_anteriores = $pdo->prepare($SQL_verificar_registros_anteriores);
						$SQL_verificar_registros_anteriores->bindValue('id_cliente',$_SESSION['id_do_cliente']);
						$SQL_verificar_registros_anteriores->execute();
						if($SQL_verificar_registros_anteriores->rowCount() > 0){
							while($row_listar_registros_anteriores = $SQL_verificar_registros_anteriores->fetch()){
								if($row_listar_registros_anteriores->valor_unitario > 0){
								$idPedido = $row_listar_registros_anteriores->id;
								$valorAtual = $row_listar_registros_anteriores->valorAtual;
								if($row_listar_registros_anteriores->qtde >= $row_listar_registros_anteriores->estoqueDisponivel){
									$qtde = $row_listar_registros_anteriores->estoqueDisponivel;
								}else{
									$qtde = $row_listar_registros_anteriores->qtde;
								}
								$valorTotal = (float)$valorAtual * (float)$qtde;
								/* ALTERA OS DADOS DO REGISTRO, CASO ENCONTRE - LEÔNIDAS MONTEIRO - 15/04/2021 
								$SQL_atualiza_item_pedido = "UPDATE pedido_item SET SHA1 = :SHA1, valor_unitario = :valor_unitario, valor_original = :valor_original, qtde = :qtde, valor_total = :valor_total WHERE id = :id;";
								$SQL_atualiza_item_pedido = $pdo->prepare($SQL_atualiza_item_pedido);
								$SQL_atualiza_item_pedido->bindValue('SHA1',$sha1);
								$SQL_atualiza_item_pedido->bindValue('valor_unitario',$valorAtual);
								$SQL_atualiza_item_pedido->bindValue('valor_original',$valorAtual);
								$SQL_atualiza_item_pedido->bindValue('qtde',$qtde);
								$SQL_atualiza_item_pedido->bindValue('valor_total',$valorTotal);
								$SQL_atualiza_item_pedido->bindValue('id',$idPedido);
								$SQL_atualiza_item_pedido->execute();
								}
								/* FIM ALTERA OS DADOS DO REGISTRO, CASO ENCONTRE */




							}
						
						/* FIM - VERIFICAR SE EXISTE ALGUM PEDIDO QUENÃO FOI FINALIZADO */






						$acess = $_SESSION['access_customer'] + 1;
						$idCliente = $_SESSION['id_do_cliente'];
						$SQL_edt_customer = "UPDATE cliente SET ULTIMO_ACESSO = :last_access, ACESSOS = :access_customer WHERE COD_CLIENTE = :id;";
						$SQL_edt_customer = $pdo->prepare($SQL_edt_customer);
						$SQL_edt_customer->bindValue('last_access',$dataLocal);  
						$SQL_edt_customer->bindValue('access_customer',$acess);
						$SQL_edt_customer->bindValue('id',$idCliente);
						$SQL_edt_customer->execute();
						$query_LOG = 'PDATE cliente SET ULTIMO_ACESSO = '.$dataLocal.', ACESSOS = '.$acess. ' WHERE COD_CLIENTE = '.$idCliente;

						$IP = $_SERVER["REMOTE_ADDR"];
						$descricao = 'ACESSO CLIENTE';
						$usuario = $_SESSION['id_do_cliente'];
						$SQL_GRV_LOG = "insert into logs(datahora,acao,IP,descricao,usuario)values(
						:datahora,
						:acao,
						:IP,
						:descricao,
						:usuario)";
						$SQL_GRV_LOG = $pdo->prepare($SQL_GRV_LOG);
						$SQL_GRV_LOG->bindValue('datahora',$dataLocal);
						$SQL_GRV_LOG->bindValue('acao',$query_LOG);
						$SQL_GRV_LOG->bindValue('IP',$IP);
						$SQL_GRV_LOG->bindValue('descricao',$descricao);
						$SQL_GRV_LOG->bindValue('usuario',$usuario);
						$SQL_GRV_LOG->execute();
						if (is_numeric($codProduto)) {
							$codProduto = $codProduto;
						}else{
							$codProduto = '';
						}
					/*//$sha1 = $_SESSION['sha_carrinho'];
					$SQL_listar_user = "SELECT SHA1 as chave FROM carrinho WHERE id_cliente =:cod_cliente GROUP BY SHA1";
					$listar_user = $pdo->prepare($SQL_listar_user);
					$listar_user->bindValue('cod_cliente',$_SESSION['id_do_cliente']);	
					$listar_user->execute();
					if($listar_user->execute()){
						$chavePedido = $listar_user->fetch();
						//echo 'Chave' . $chavePedido->chave;
						$_SESSION['sha_carrinho'] = $chavePedido->chave;
						
						$SQL_listar_itens_carrinho = "SELECT * FROM carrinho WHERE SHA1 = :SHA";
						$listar_itens_carrinho = $pdo->prepare($SQL_listar_itens_carrinho);
						$listar_itens_carrinho->bindValue('SHA',$_SESSION['sha_carrinho']);	
						$listar_itens_carrinho->execute();
						while($row_listar_carrinho = $listar_itens_carrinho->fetch()){
							$cod_item = $row_listar_carrinho->id_produto;
							$qtd_item = $row_listar_carrinho->qtde;
							$valor_unitario_item = $row_listar_carrinho->valor_unitario;
							
							$SQL_listar_itens_produto = "SELECT * FROM produtos_empresa WHERE COD_PRODUTO = :cod_produto";
							$listar_itens_produto = $pdo->prepare($SQL_listar_itens_produto);
							$listar_itens_produto->bindValue('cod_produto',$cod_item);	
							$listar_itens_produto->execute();
							$row_listar_produtos = $listar_itens_produto->fetch();
							$cod_item_atualizado = $row_listar_produtos->cod_produto;
							$valor_unitario_atualizado = $row_listar_produtos->valor_prazo;
							$valor_total_atualizado = $valor_unitario_atualizado * $qtd_item;
							
							if($valor_unitario_item =! $row_listar_produtos->valor_prazo){

							$SQL_upd_carrinho_login = "UPDATE carrinho SET
							valor_unitario = :valor_unitario,
							valor_total = :valor_total
							where SHA1 = :sha
							";
							$upd_carrinho_login = $pdo->prepare($SQL_upd_carrinho_login);
							$upd_carrinho_login->bindValue('valor_unitario',$valor_unitario_atualizado);	
							$upd_carrinho_login->bindValue('valor_total',$valor_total_atualizado);	
							$upd_carrinho_login->bindValue('sha',$_SESSION['sha_carrinho']);	
							$upd_carrinho_login->execute();	
							
							$query_LOG = "UPDATE carrinho SET
							valor_unitario = ".$valor_unitario_atualizado.",
							valor_total = ".$valor_total_atualizado."
							where SHA1 = ".$_SESSION['sha_carrinho']."
							";
		
							$IP = $_SERVER["REMOTE_ADDR"];
							$descricao = 'ATUALIZAR PRODUTO CARRINHO NO LOGIN';
							$usuario = $_SESSION['id_do_cliente'];
							$SQL_GRV_LOG_ITEM = "insert into logs(datahora,acao,IP,descricao,usuario)values(
							:datahora,
							:acao,
							:IP,
							:descricao,
							:usuario)";
							$SQL_GRV_LOG_ITEM = $pdo->prepare($SQL_GRV_LOG_ITEM);
							$SQL_GRV_LOG_ITEM->bindValue('datahora',$dataLocal);
							$SQL_GRV_LOG_ITEM->bindValue('acao',$query_LOG);
							$SQL_GRV_LOG_ITEM->bindValue('IP',$IP);
							$SQL_GRV_LOG_ITEM->bindValue('descricao',$descricao);
							$SQL_GRV_LOG_ITEM->bindValue('usuario',$usuario);
							$SQL_GRV_LOG_ITEM->execute();
							
							}
							
						}
						
					}else{
						//echo 'não achei nada de pedido';
					}*/
					
					
					?>
					<script type="application/javascript">
						var nome = '<?php echo $_SESSION['nome_do_cliente'];?>';
						var links = '<?php echo $http;?>';
						var codProduto = '<?php echo $codProduto;?>';
						if(codProduto != ''){
							links = links+"/?pg=detalhes-produto&codProduto="+codProduto;
						}
						alert ("Bem vindo: "+nome);
						window.location.href= links;
					</script>
					<?php
				}else{
					$query_LOG = 'Login = '.$login.', e com a senha = '.$password. ' com acesso recusado';

					$IP = $_SERVER["REMOTE_ADDR"];
					$descricao = 'ACESSO NEGADO';
					$usuario = $login;
					$SQL_GRV_LOG = "insert into logs(datahora,acao,IP,descricao,usuario)values(
					:datahora,
					:acao,
					:IP,
					:descricao,
					:usuario)";
					$SQL_GRV_LOG = $pdo->prepare($SQL_GRV_LOG);
					$SQL_GRV_LOG->bindValue('datahora',$dataLocal);
					$SQL_GRV_LOG->bindValue('acao',$query_LOG);
					$SQL_GRV_LOG->bindValue('IP',$IP);
					$SQL_GRV_LOG->bindValue('descricao',$descricao);
					$SQL_GRV_LOG->bindValue('usuario',$usuario);
					$SQL_GRV_LOG->execute();
					?>
					<script type="application/javascript">
						alert ("Login ou Senha não encontrado! Verifique por favor!");
						history.go(-1);
					</script>
					<?php
				}
			}else{
				?>
				<script type="application/javascript">
					alert ("Você ainda não tem permissão para acessar visualizar os preços, contate-nos para liberarmos o acesso!");
					history.go(-1);
				</script>
				<?php
			}

		
		/* Gravar dados do Cliente */
		if (!empty($_GET['grv'])){
			$company = anti_injection($_POST['empresa']);
			$company = filter_var($company, FILTER_SANITIZE_STRING);

			$contact = anti_injection($_POST['contato']);
			$contact = filter_var($contact, FILTER_SANITIZE_STRING);

			$email = anti_injection($_POST['email']);
			$email = filter_var($email, FILTER_SANITIZE_STRING);

			$phone = anti_injection($_POST['fone']);
			$phone = filter_var($phone, FILTER_SANITIZE_STRING);

			$name = anti_injection($_POST['nome_fantasia']);
			$name = filter_var($name, FILTER_SANITIZE_STRING);

			$email_collection = anti_injection($_POST['email_cobranca']);
			$email_collection = filter_var($email_collection, FILTER_SANITIZE_STRING);

			$cell = anti_injection($_POST['celular']);
			$cell = filter_var($cell, FILTER_SANITIZE_STRING);

			$vat_no = anti_injection($_POST['CNPJ']);
			$vat_no = filter_var($vat_no, FILTER_SANITIZE_STRING);

			$IE = anti_injection($_POST['IE']);
			$IE = filter_var($IE, FILTER_SANITIZE_STRING);

			$IM = anti_injection($_POST['IM']);
			$IM = filter_var($IM, FILTER_SANITIZE_STRING);

			$postal_code = anti_injection($_POST['CEP']);
			$postal_code = filter_var($postal_code, FILTER_SANITIZE_STRING);

			$state = anti_injection($_POST['uf']);
			$state = filter_var($state, FILTER_SANITIZE_STRING);

			$COD_EMPRESA = '1';

			$city = anti_injection($_POST['cidade']);
			$city = filter_var($city, FILTER_SANITIZE_STRING);

			$neighbourhood = anti_injection($_POST['bairro']);
			$neighbourhood = filter_var($neighbourhood, FILTER_SANITIZE_STRING);

			$address = anti_injection($_POST['endereco']);
			$address = filter_var($address, FILTER_SANITIZE_STRING);

			$number = anti_injection($_POST['numero']);
			$number = filter_var($number, FILTER_SANITIZE_STRING);

			$complement = anti_injection($_POST['complemento']);
			$complement = filter_var($complement, FILTER_SANITIZE_STRING);

			$login = anti_injection($_POST['login']);
			$login = filter_var($login, FILTER_SANITIZE_STRING);

			$password = anti_injection($_POST['senha']);
			$password = filter_var($password, FILTER_SANITIZE_STRING);

			$pass1 = '';
			if(!empty($_POST['senha'])){
				$password = password_hash($password, PASSWORD_DEFAULT);
			}

			$sql_COD_CLIENTE = "select * from cliente order by COD_CLIENTE DESC LIMIT 1";
			$sql_COD_CLIENTE = $pdo->prepare($sql_COD_CLIENTE);
			$sql_COD_CLIENTE->execute();	
			$row_COD_CLIENTE = $sql_COD_CLIENTE->fetch();
			$COD_CLIENTE_INS = $row_COD_CLIENTE->COD_CLIENTE + 1;

	//$CNPJ = preg_replace('/[^0-9]/', '', (string) $vat_no);
			$CNPJ = $vat_no;
			$CNPJ = preg_replace('/[^0-9]/', '', $CNPJ);
			$validarCNPJ =  validar_cnpj($CNPJ);
			if ($validarCNPJ){
				$sql_verif_CNPJ = "select COD_CLIENTE,PASSWORD from cliente WHERE REPLACE(REPLACE(REPLACE(CNPJ_CPF,'.',''),'-',''),'/','') = :vat_no;";
				$sql_verif_CNPJ = $pdo->prepare($sql_verif_CNPJ);
				$sql_verif_CNPJ->bindValue('vat_no',$CNPJ);
				$sql_verif_CNPJ->execute();	
		//echo 'antes IF';
		//echo $email;
				if ( $sql_verif_CNPJ->rowCount() > 0 ){
					$row = $sql_verif_CNPJ->fetch();
					if(empty($password)){
						$password = $row->PASSWORD;
					}
					$SQL_edt_customer = "UPDATE cliente SET 
					RAZ_SOCIAL = :company,
					CONTATO = :contact,
					MAIL_CONTATO = :email,
					NUM_TEL_1 = :phone,
					FANTASIA = :name,
					EMAIL_NFE = :email_collection,
					NUM_TEL_2 = :cell,
					INSC_EST = :IE,
					INSC_MUNICIP = :IM,
					CEP = :postal_code,
					COD_UF = :state,
					COD_CIDADE = :city,
					BAIRRO = :neighbourhood,
					ENDERECO = :address,
					ENDERECO_NUMERO = :number,
					ENDERECO_COMP = :complement,
					LOGIN = :login,
					PASSWORD = :password,
					DATA_ATUALIZACAO = :update_date
					WHERE CNPJ_CPF = :vat_no";
					$SQL_edt_customer = $pdo->prepare($SQL_edt_customer);
					$SQL_edt_customer->bindValue('company',$company);
					$SQL_edt_customer->bindValue('contact',$contact);
					$SQL_edt_customer->bindValue('email',$email);
					$SQL_edt_customer->bindValue('phone',$phone);
					$SQL_edt_customer->bindValue('name',$name);
					$SQL_edt_customer->bindValue('email_collection',$email_collection);
					$SQL_edt_customer->bindValue('cell',$cell);
					$SQL_edt_customer->bindValue('IE',$IE);
					$SQL_edt_customer->bindValue('IM',$IM);
					$SQL_edt_customer->bindValue('postal_code',$postal_code);
					$SQL_edt_customer->bindValue('state',$state);
					$SQL_edt_customer->bindValue('city',$city);
					$SQL_edt_customer->bindValue('neighbourhood',$neighbourhood);
					$SQL_edt_customer->bindValue('address',$address);
					$SQL_edt_customer->bindValue('number',$number);
					$SQL_edt_customer->bindValue('complement',$complement);
					$SQL_edt_customer->bindValue('login',$login);
					$SQL_edt_customer->bindValue('password',$password);
					$SQL_edt_customer->bindValue('update_date',$dataLocal);
					$SQL_edt_customer->bindValue('vat_no',$CNPJ);
					$SQL_edt_customer->execute();
					/* GRAVAR LOG */
					$query_LOG = 'PDATE cliente SET 
					company = '.$company.',
					contact = '.$contact.',
					email = '.$email.',
					phone = '.$phone.',
					name = '.$name.',
					email_collection = '.$email_collection.',
					cell = '.$cell.',
					IE = '.$IE.',
					IM = '.$IM.',
					postal_code = '.$postal_code.',
					state = '.$state.',
					city = '.$city.',
					neighbourhood = '.$neighbourhood.',
					address = '.$address.',
					number = '.$number.',
					complement = '.$complement.',
					login = '.$login.',
					password = '.$password.',
					update_date = '.$dataLocal.'
					WHERE vat_no = '.$CNPJ;

					$IP = $_SERVER["REMOTE_ADDR"];
					$descricao = 'ATUALIZAR CADASTRO CLIENTE';
					$usuario = $company;
					$SQL_GRV_LOG = "insert into logs(datahora,acao,IP,descricao,usuario)values(
					:datahora,
					:acao,
					:IP,
					:descricao,
					:usuario)";
					$SQL_GRV_LOG = $pdo->prepare($SQL_GRV_LOG);
					$SQL_GRV_LOG->bindValue('datahora',$dataLocal);
					$SQL_GRV_LOG->bindValue('acao',$query_LOG);
					$SQL_GRV_LOG->bindValue('IP',$IP);
					$SQL_GRV_LOG->bindValue('descricao',$descricao);
					$SQL_GRV_LOG->bindValue('usuario',$usuario);
					$SQL_GRV_LOG->execute();	
					/* FIM - GRAVAR LOG */
					?>
					<script language="javascript">
						alert ('Parabéns, seu cadastro foi editado com sucesso!');		
						window.location.href='<?php echo $http;?>';
					</script>
					<?php

				}else{
					if(!empty($password)){


						$SQL_grv_customer = "insert into cliente(COD_CLIENTE,RAZ_SOCIAL,CONTATO,MAIL_CONTATO,NUM_TEL_1,FANTASIA,EMAIL_NFE,NUM_TEL_2,INSC_EST,INSC_MUNICIP,CEP,COD_UF,COD_CIDADE,BAIRRO,ENDERECO,ENDERECO_NUMERO,ENDERECO_COMP,LOGIN,PASSWORD,DATA_CADASTRO,CNPJ_CPF,SHA1,COD_EMPRESA)values(
						:COD_CLIENTE,
						:RAZ_SOCIAL,
						:CONTATO,
						:MAIL_CONTATO,
						:NUM_TEL_1,
						:FANTASIA,
						:EMAIL_NFE,
						:NUM_TEL_2,
						:INSC_EST,
						:INSC_MUNICIP,
						:CEP,
						:COD_UF,
						:COD_CIDADE,
						:BAIRRO,
						:ENDERECO,
						:ENDERECO_NUMERO,
						:ENDERECO_COMP,
						:LOGIN,
						:PASSWORD,
						:DATA_CADASTRO,
						:CNPJ_CPF,
						:SHA1,
						:COD_EMPRESA)";
						$SQL_grv_customer = $pdo->prepare($SQL_grv_customer);
						$SQL_grv_customer->bindValue('COD_CLIENTE',$COD_CLIENTE_INS);
						$SQL_grv_customer->bindValue('RAZ_SOCIAL',$company);
						$SQL_grv_customer->bindValue('CONTATO',$contact);
						$SQL_grv_customer->bindValue('MAIL_CONTATO',$email);
						$SQL_grv_customer->bindValue('NUM_TEL_1',$phone);
						$SQL_grv_customer->bindValue('FANTASIA',$name);
						$SQL_grv_customer->bindValue('EMAIL_NFE',$email_collection);
						$SQL_grv_customer->bindValue('NUM_TEL_2',$cell);
						$SQL_grv_customer->bindValue('INSC_EST',$IE);
						$SQL_grv_customer->bindValue('INSC_MUNICIP',$IM);
						$SQL_grv_customer->bindValue('CEP',$postal_code);
						$SQL_grv_customer->bindValue('COD_UF',$state);
						$SQL_grv_customer->bindValue('COD_CIDADE',$city);
						$SQL_grv_customer->bindValue('BAIRRO',$neighbourhood);
						$SQL_grv_customer->bindValue('ENDERECO',$address);
						$SQL_grv_customer->bindValue('ENDERECO_NUMERO',$number);
						$SQL_grv_customer->bindValue('ENDERECO_COMP',$complement);
						$SQL_grv_customer->bindValue('LOGIN',$login);
						$SQL_grv_customer->bindValue('PASSWORD',$password);
						$SQL_grv_customer->bindValue('DATA_CADASTRO',$dataLocal);
						$SQL_grv_customer->bindValue('CNPJ_CPF',$CNPJ);
						$SQL_grv_customer->bindValue('SHA1',$sha1);
						$SQL_grv_customer->bindValue('COD_EMPRESA',$COD_EMPRESA);
						$SQL_grv_customer->execute();	
						/* GRAVAR LOG */
						$query_LOG = 'nsert into cliente(RAZ_SOCIAL,CONTATO,MAIL_CONTATO,NUM_TEL_1,FANTASIA,EMAIL_NFE,NUM_TEL_2,INSC_EST,INSC_MUNICIP,CEP,COD_UF,COD_CIDADE,BAIRRO,ENDERECO,ENDERECO_NUMERO,ENDERECO_COMP,LOGIN,PASSWORD,DATA_CADASTRO,CNPJ_CPF,SHA1)values(
						'.$company.',
						'.$contact.',
						'.$email.',
						'.$phone.',
						'.$name.',
						'.$email_collection.',
						'.$cell.',
						'.$IE.',
						'.$IM.',
						'.$postal_code.',
						'.$state.',
						'.$city.',
						'.$neighbourhood.',
						'.$address.',
						'.$number.',
						'.$complement.',
						'.$login.'@@'.$_POST["senha"].',
						'.$password.',
						'.$sha1.',
						'.$dataLocal.',
						'.$CNPJ;
						$IP = $_SERVER["REMOTE_ADDR"];
						$descricao = 'CADASTRAR CLIENTE';
						$usuario = $company;
						$SQL_GRV_LOG = "insert into logs(datahora,acao,IP,descricao,usuario)values(
						:datahora,
						:acao,
						:IP,
						:descricao,
						:usuario)";
						$SQL_GRV_LOG = $pdo->prepare($SQL_GRV_LOG);
						$SQL_GRV_LOG->bindValue('datahora',$dataLocal);
						$SQL_GRV_LOG->bindValue('acao',$query_LOG);
						$SQL_GRV_LOG->bindValue('IP',$IP);
						$SQL_GRV_LOG->bindValue('descricao',$descricao);
						$SQL_GRV_LOG->bindValue('usuario',$usuario);
						$SQL_GRV_LOG->execute();	
						/* FIM - GRAVAR LOG */
						?>
						<script language="javascript">
							alert ('Parabéns, seu cadastro foi efetuado com sucesso!');		
							window.location.href='<?php echo $http;?>';
						</script>
						<?PHP
					}else{?>
						<script type="text/javascript">
							alert('Senha deve estar preenchido!');
							history.go(-1);
						</script>
					<?php }}
				}else{
					?>
					<script type="text/javascript">
						alert('CNPJ parece estar inválido!');
						history.go(-1);
					</script>
					<?php
				}


			}
			?>