<?php 
session_start();
//include_once ('../../conexao-pdo/config.php');
include_once ('../../conexao-pdo/conexao-mysql-pdo.php');
//session_start();
date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());


//*************************** GRAVAR NEWSLETTER *******************************************

if($_GET['gravar'] == 1){
	
		
	$nome = anti_injection($_POST['nome']);
    $nome = filter_var($nome, FILTER_SANITIZE_STRING);
	if (empty($nome)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Por favor, preencha o seu nome!');
	echo json_encode($retorno);
	exit();
	endif;

    
	$cep = anti_injection($_POST['cep']);
    $cep = filter_var($cep, FILTER_SANITIZE_STRING);
	if (empty($cep)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Por favor, preencha o seu CEP!');
	echo json_encode($retorno);
	exit();
	endif;
    
    
	
	$email = anti_injection($_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_STRING);
	if (empty($email)):
	$retorno = array('codigo' => 0, 'mensagem' => 'Por favor, preencha seu email!');
	echo json_encode($retorno);
	exit();
	else:
		//Verifica se o formato do e-mail é válido
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)):
    	$retorno = array('codigo' => 0, 'mensagem' => 'Formato de e-mail inválido!');
		echo json_encode($retorno);
		exit();
		endif;
	endif;	
	
	
	
	
  	//******************verifica se a empresa esta cadastrada *********************************
    $sql_verif_email = "select * from newsletter where email = :email;";
    $verif_newsletter = $pdo->prepare($sql_verif_email);
    $verif_newsletter->bindValue('email',$email);
    $verif_newsletter->execute();	
    
        if(!empty($verif_newsletter->fetch())){
           //-********************************ATUALIZA A EMPRESA ***************************************
		  
		   		$retorno = array('codigo' => 0, 'mensagem' => 'Seu e-mail já está cadastrado para receber nossas ofertas!');
				echo json_encode($retorno);
				exit();
		   
				
		}else{
            //************************GRAVA A EMPRESA ***********************************
			$sql_gravar_newsletter = "insert into newsletter(nome,email,cep,data_cadastro)values(
				:nome,
				:email,
				:cep,				
				:data_cadastro)";				
			$gravar_newsletter = $pdo->prepare($sql_gravar_newsletter);
			$gravar_newsletter->bindValue('nome',$nome);
			$gravar_newsletter->bindValue('email',$email);
			$gravar_newsletter->bindValue('cep',$cep);
			$gravar_newsletter->bindValue('data_cadastro',$dataLocal);
			$gravar_newsletter->execute();
             
			 if ($gravar_newsletter){
				$retorno = array('codigo' => 1, 'mensagem' => 'E-mail cadastrado com sucesso!');
				echo json_encode($retorno);
				exit();			 
			}else{
				$retorno = array('codigo' => 0, 'mensagem' => 'Erro ao cadastrar, verifique suas informações!');
				echo json_encode($retorno);
				exit();
	
		}
	}
}