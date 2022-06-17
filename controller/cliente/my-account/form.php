<?php 
session_start();

include_once ("../../../conexao-pdo/config.php");
include_once ("../../../conexao-pdo/conexao-mysql-pdo.php");

if (empty($_SESSION['id_do_cliente'])){
	?>
    	<script type="application/javascript">
			var links = '<?php echo $http;?>';
			alert("É necessário estar logado!");
			window.location.href = links;
		</script>
    <?php
}

 /*      LISTAR DADOS DO CLIENTE LOGADO */
		$codCliente = $_SESSION['id_do_cliente'];
		$SQL_dados_cliente = "SELECT * FROM cliente WHERE COD_CLIENTE = :COD_CLIENTE;";
		$SQL_dados_cliente = $pdo->prepare($SQL_dados_cliente);
		$SQL_dados_cliente->bindValue('COD_CLIENTE',$codCliente);
		$SQL_dados_cliente->execute();		
		if ($SQL_dados_cliente->rowCount() > 0){
			$row_dados = $SQL_dados_cliente->fetch();
		}
	/* FIM - LISTAR DADOS DO CLIENTE LOGADO */
?>
<div class="container">
  <div class="row">
    
    <!-- End .col-lg-9 -->
    
    <aside class="col-lg-12">
      <div class="widget widget-dashboard">
        <?php
			require_once "menu.php";
		?>
      </div>
      <!-- End .widget --> 
    </aside>
    <div class="col-lg-12">
      <h2>Meus Dados</h2>
      <form name="form1" action="<?php echo $http; ?>/model/cliente/cliente.php?edt='1'" method="post">
        <div class="container">
          <div class="row">
            <div class="col-lg-2">
              <label>Código</label>
              <input name="codigo" class="form-control" readonly="readonly" value="<?php echo $row_dados->COD_CLIENTE;?>">
            </div>
            <div class="col-lg-10">
              <label>Empresa</label>
              <input name="empresa" class="form-control" required="required" value="<?php echo $row_dados->RAZ_SOCIAL;?>">
            </div>
            <div class="col-lg-5">
              <label>Contato</label>
              <input name="contato" class="form-control" required="required" value="<?php echo $row_dados->CONTATO;?>">
            </div>
            <div class="col-lg-4">
              <label>E-mail</label>
              <input name="email" class="form-control" required="required" value="<?php echo $row_dados->MAIL_CONTATO;?>">
            </div>
            <div class="col-lg-3">
              <label>Fone</label>
              <input name="fone" class="form-control" required="required" onkeypress="return mask(event, this, '(##) ####-####')" maxlength="14" placeholder=" (DDD) 0000-0000" value="<?php echo $row_dados->NUM_TEL_1;?>">
            </div>
            <div class="col-lg-5">
              <label>Nome Fantasia</label>
              <input name="nome_fantasia" class="form-control" required="required"  value="<?php echo $row_dados->FANTASIA;?>">
            </div>
            <div class="col-lg-4">
              <label>E-mail de Cobrança</label>
              <input name="email_cobranca" class="form-control" required="required"  value="<?php echo $row_dados->EMAIL_NFE;?>">
            </div>
            <div class="col-lg-3">
              <label>Celular</label>
              <input name="celular" class="form-control" required="required" onkeypress="return mask(event, this, '(##) #####-####')" maxlength="15" placeholder=" (DDD) 0000-0000" value="<?php echo $row_dados->NUM_TEL_2;?>">
            </div>
            <div class="col-lg-6">
              <label>
              <div id="validouCNPJ">CNPJ (*)</div>
              </label>
              <input name="CNPJ" id="CNPJ" class="form-control CNPJ" required="required" onkeyup="validaCNPJ(this.value)" onkeypress="return mask(event, this, '##.###.###/####-##')" maxlength="18" placeholder="" value="<?php echo $row_dados->CNPJ_CPF;?>">
            </div>
            <div class="col-lg-3">
              <label>Inscrição Estadual</label>
              <input name="IE" class="form-control" required="required"  value="<?php echo $row_dados->INSC_EST;?>">
            </div>
            <div class="col-lg-3">
              <label>Inscrição Municipal</label>
              <input name="IM" class="form-control" required="required"  value="<?php echo $row_dados->INSC_MUNICIP;?>">
            </div>
            <div class="col-lg-2">
              <label>CEP</label>
              <input name="CEP" class="form-control" onkeypress="return mask(event, this, '#####-###')" maxlength="9" placeholder="" id="cep" onkeyup="pesquisacep(this.value);" required  value="<?php echo $row_dados->CEP;?>">
            </div>
            <div class="col-lg-2">
              <label>UF</label>
              <input name="uf" id="uf"	class="form-control" required="required" readonly="readonly"  value="<?php echo $row_dados->COD_UF;?>" />
              <!-- <select name="uf" id="uf" class="form-control" required="required" onblur="listarCidades(this.value)">
        <option value=""></option>
        <?php
		//while ($row = $lista_estado->fetch()){?>
        <option value="<?php  // echo $row->id;?>"><?php // echo $row->nome;?></option>
        <?php //} ?>
      </select> --> 
            </div>
            <div class="col-lg-4">
              <div id="cidadelistar">
                <label>Cidade</label>
                <input name="cidade" id="cidade" class="form-control" required="required" readonly="readonly"  value="<?php echo $row_dados->COD_CIDADE;?>" />
                <!-- <select name="cidade" id="cidade" class="form-control" required="required">
        <option value=""></option>
      </select> --></div>
            </div>
            <div class="col-lg-4">
              <label>Bairro</label>
              <input name="bairro" id="bairro" class="form-control" required="required"  value="<?php echo $row_dados->BAIRRO;?>">
            </div>
            <div class="col-lg-10">
              <label>Endereço</label>
              <input type="text" class="form-control" id="endereco" name="endereco" required  value="<?php echo $row_dados->ENDERECO;?>">
            </div>
            <div class="col-lg-2">
              <label>Número</label>
              <input name="numero" id="numero" class="form-control" required="required"  value="<?php echo $row_dados->ENDERECO_NUMERO;?>">
            </div>
            <div class="col-lg-8">
              <label>Complemento</label>
              <textarea class="form-control" rows="3" id="complemento" name="complemento"> <?php echo $row_dados->ENDERECO_COMP;?></textarea>
            </div>
            <div class="col-lg-4">
              <div class="col-lg-12">
                <label>Login</label>
                <input name="login" class="form-control" value="<?php echo $row_dados->LOGIN;?>">
              </div>
              <div class="col-lg-12">
                <label>Senha</label>
                <input name="senha" class="form-control" value="">
              </div>
              <div class="col-lg-12">
                <input type="submit" class="btn btn-primary">
              </div>
            </div>
          </div>
        </div>
      </form>
    </div><!-- End .col-lg-3 --> 
  </div>
  <!-- End .row --> 
</div>
<!-- End .container --> 
