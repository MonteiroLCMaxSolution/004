<link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../../css/lcmaxsolution.css" rel="stylesheet" type="text/css">

<?php 
if (!isset($_SESSION)){
	session_start();
}
	include 'conexao-pdo/config.php';
	$dataLocal = date('Y-m-d H:i:s', time());
setlocale( LC_ALL, 'pt_BR.utf-8', 'pt_BR', 'Portuguese_Brazil');

$chave ="";
 if (!empty($_GET['chave'])){
	 $chave = preg_replace('/[^[:alnum:]]/','',$_GET["chave"]);

?>
 <div class="row">
<div class="container">

  <form id="alterarSenha" action="<?php echo $http; ?>/model/recuperar-senha/envia-senha.php/?sn='1'" method="post">
  <input name="chave" type="hidden" value="<?php echo $chave;?>" >
      
      <h1> Alteração de Senha </h1><BR/>
      <div class="row">
      	
	    
        <input name="chave" type="hidden" class="form-control" value="<?php echo $_GET['chave'];?>" required>
        
        <div class="col-sm-12 col-md-6 col-lg-6">
        <label> Digite sua nova senha </label>
        <input placeholder="Digite uma nova senha" name="NovaSenha" id="senha1" type="password" class="form-control checarSenha" required>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
        <label> Confirme sua senha <strong id='msg'></strong> </label> 
        <input placeholder="Confirme sua senha" name="NovaSenha2" id="senha2"  type="password" class="form-control checarSenha" required>
        </div>
        </div>
        <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12" align="right">
        <button type="submit" id="btnAlterarSenha" disabled="disabled" class="btn btn-primary">Alterar Senha</button>
    	</div>
        </div>
  </form>
  <?php
   }else {
 	echo '<h1> Página não encontrada </h1>';
 }
  ?>
  </div></div>