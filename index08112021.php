em manutenção<?php 
if(!isset($_SESSION)){
    session_start();
}


if($_GET['pg'] == 'reset'){
	session_destroy();
	echo $_SESSION['id_do_cliente'] = '';
	$_SESSION['nome_do_cliente'] = '';
	$_SESSION['last_access'] = '';
	$_SESSION['access_customer'] = '';
	$_SESSION['email_do_cliente'] = '';
	$_SESSION['COD_EMPRESA_cliente'] = '';
	$_SESSION['sha1_cliente'] = '';
	$_SESSION['COD_UF'] ='';
	$_SESSION['COD_CIDADE'] = '';
	$_SESSION['sha_carrinho'] = '';
}


if (empty($_SESSION['sha_carrinho'])){
  $_SESSION['sha_carrinho'] = sha1('Deus é fiel'.time());
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $config = 'config.php';
    $parametro = 's';
    $tag = '../';
    while ($parametro != 'n'){
    if (file_exists($config)) {
        $parametro = 'n';
    } else {
        $config = $tag.$config;
    }
    }
    require_once $config;
?>
