<?php
if(!isset($_SESSION)){
	session_start();
}
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); 

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());

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

// CRIADO EM 04/04/2020 - LEÔNIDAS MONTEIRO - ATUALIZAR A BASE DE DADOS DO CLIENTE  

$SQL_listar_clientesOLD = "SELECT * from clienteold a";
$SQL_listar_clientesOLD = $pdo->prepare($SQL_listar_clientesOLD);
$SQL_listar_clientesOLD->execute();

while ($row = $SQL_listar_clientesOLD->fetch()){
	$SHA1 = md5($row->CNPJ);
	$CNPJ = $row->CNPJ;
	$password = anti_injection($row->Senha);
	$password = filter_var($row->Senha, FILTER_SANITIZE_STRING);
	$password = password_hash($password, PASSWORD_DEFAULT);

	$sql_buscar = "SELECT COD_CLIENTE FROM cliente WHERE CNPJ_CPF = :CNPJ_CPF;";
	$sql_buscar = $pdo->prepare($sql_buscar);
	$sql_buscar->bindValue('CNPJ_CPF',$CNPJ);
	$sql_buscar->execute();

	if($sql_buscar->rowCount() > 0){
		$SQL_edt = "UPDATE cliente SET ";
	}else{



		$SQL_insert = "INSERT INTO cliente(COD_CLIENTE,RAZ_SOCIAL,CONTATO,MAIL_CONTATO,NUM_TEL_1,FANTASIA,EMAIL_NFE,NUM_TEL_2,INSC_EST,CEP,COD_UF,COD_CIDADE,ENDERECO,ENDERECO_NUMERO,LOGIN,PASSWORD,DATA_CADASTRO,CNPJ_CPF,SHA1,COD_EMPRESA,DATA_ATUALIZACAO)VALUES(:COD_CLIENTE,:RAZ_SOCIAL,:CONTATO,:MAIL_CONTATO,:NUM_TEL_1,:FANTASIA,:EMAIL_NFE,:NUM_TEL_2,:INSC_EST,:CEP,:COD_UF,:COD_CIDADE,:ENDERECO,:ENDERECO_NUMERO,:LOGIN,:PASSWORD,:DATA_CADASTRO,:CNPJ_CPF,:SHA1,:COD_EMPRESA,:DATA_ATUALIZACAO);";
		$SQL_insert = $pdo->prepare($SQL_insert);
		$SQL_insert->bindValue('COD_CLIENTE',$row->idCliente);
		$SQL_insert->bindValue('RAZ_SOCIAL',$row->Empresa);
		$SQL_insert->bindValue('CONTATO',$row->Contato);
		$SQL_insert->bindValue('MAIL_CONTATO',$row->Email);
		$SQL_insert->bindValue('NUM_TEL_1',$row->Telefone);
		$SQL_insert->bindValue('FANTASIA',$row->Empresa);
		$SQL_insert->bindValue('EMAIL_NFE',$row->Email);
		$SQL_insert->bindValue('NUM_TEL_2',$row->Telefone);
		$SQL_insert->bindValue('INSC_EST',$row->InsEstadual);
		$SQL_insert->bindValue('CEP',$row->CEP);
		$SQL_insert->bindValue('COD_UF',$row->UF);
		$SQL_insert->bindValue('COD_CIDADE',$row->Cidade);
		$SQL_insert->bindValue('ENDERECO',$row->endereco);
		$SQL_insert->bindValue('ENDERECO_NUMERO',$row->numero);
		$SQL_insert->bindValue('LOGIN',$row->Login);
		$SQL_insert->bindValue('PASSWORD',$password);
		$SQL_insert->bindValue('DATA_CADASTRO',$row->DataCadastro);
		$SQL_insert->bindValue('CNPJ_CPF',$row->CNPJ);
		$SQL_insert->bindValue('SHA1',$SHA1);
		$SQL_insert->bindValue('COD_EMPRESA','1');
		$SQL_insert->bindValue('DATA_ATUALIZACAO',$dataLocal);
		$SQL_insert->execute();
	}

}

// .CRIADO EM 04/04/2020 - LEÔNIDAS MONTEIRO - ATUALIZAR A BASE DE DADOS DO CLIENTE  
?>
