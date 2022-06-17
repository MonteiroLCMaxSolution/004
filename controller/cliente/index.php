<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
/* dados do cliente - Leônidas Monteiro - 05/03/2020 */
	require_once 'model/cliente/cliente.php';
	if(isset($SQL_dados_cliente)){
	if ($SQL_dados_cliente->rowCount() > 0){
		$list = $SQL_dados_cliente->fetch();
	}}
/* fim - dados do cliente - Leônidas Monteiro - 05/03/2020 */	
?>

<form action="model/cliente/cliente.php/?grv=1" method="post">
  <h3 class="widget-title">Minha Conta</h3>
  <div class="row">
    <div class="col-lg-3">
      <ul class="list">
        <li class="active"><a href="?pg=dados_cliente">Meus Dados</a></li>
        <?php
            if (!empty($_SESSION['nome_do_cliente'])){?>
        <li><a href="?pg=meus-pedidos">Meus Pedidos</a></li>
        <?php } ?>
      </ul>
    </div>
    <div class="col-lg-9">
      <div class="container">
        <h2>Dados do Cliente</h2>
        <div class="row">
          <div class="col-lg-2" style="display: none;">
            <label>Código</label>
            <input name="codigo" class="form-control" readonly="readonly" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->COD_CLIENTE;}?>">
          </div>
          <div class="col-lg-12">
            <label>Empresa</label>
            <input name="empresa" class="form-control" required="required" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->RAZ_SOCIAL;}?>">
          </div>
          <div class="col-lg-4">
            <label>Contato</label>
            <input name="contato" class="form-control" required="required" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->CONTATO;}?>">
          </div>
          <div class="col-lg-5">
            <label>E-mail</label>
            <input name="email" class="form-control" required="required" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->MAIL_CONTATO;}?>">
          </div>
          <div class="col-lg-3">
            <label>Fone</label>
            <input name="fone" class="form-control" required="required" onkeypress="return mask(event, this, '(##) ####-####')" maxlength="14" placeholder=" (DDD) 0000-0000" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->NUM_TEL_1;}?>">
          </div>
          <div class="col-lg-4">
            <label>Nome Fantasia</label>
            <input name="nome_fantasia" class="form-control" required="required" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->FANTASIA;}?>">
          </div>
          <div class="col-lg-5">
            <label>E-mail de Cobrança</label>
            <input name="email_cobranca" class="form-control" required="required" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->EMAIL_NFE;}?>">
          </div>
          <div class="col-lg-3">
            <label>Celular</label>
            <input name="celular" class="form-control" required="required" onkeypress="return mask(event, this, '(##) #####-####')" maxlength="15" placeholder=" (DDD) 0000-0000" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->NUM_TEL_2;}?>">
          </div>
          <div class="col-lg-6">
            <label>
            <div id="validouCNPJ">CNPJ (*)</div>
            </label>
            <input name="CNPJ" id="CNPJ" class="form-control CNPJ" required="required" onkeyup="validaCNPJ(this.value)" onkeypress="return mask(event, this, '##.###.###/####-##')" maxlength="18" placeholder="" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->CNPJ_CPF;}?>">
          </div>
          <div class="col-lg-3">
            <label>Inscrição Estadual</label>
            <input name="IE" class="form-control" required="required" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->INSC_EST;}?>">
          </div>
          <div class="col-lg-3">
            <label>Inscrição Municipal</label>
            <input name="IM" class="form-control" required="required" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->INSC_MUNICIP;}?>">
          </div>
          <div class="col-lg-2">
            <label>CEP</label>
            <input name="CEP" class="form-control" onkeypress="return mask(event, this, '#####-###')" maxlength="9" placeholder="" id="cep" onkeyup="pesquisacep(this.value);" required value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->CEP;}?>">
          </div>
          <div class="col-lg-2">
            <label>UF</label>
            <input name="uf" id="uf"	class="form-control" required="required" readonly="readonly" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->COD_UF;}?>" />
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
              <input name="cidade" id="cidade" class="form-control" required="required" readonly="readonly" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->COD_CIDADE;}?>"/>
              <!-- <select name="cidade" id="cidade" class="form-control" required="required">
        <option value=""></option>
    </select> --></div>
          </div>
          <div class="col-lg-4">
            <label>Bairro</label>
            <input name="bairro" id="bairro" class="form-control" required="required" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->BAIRRO;}?>">
          </div>
          <div class="col-lg-10">
            <label>Endereço</label>
            <input type="text" class="form-control" id="endereco" name="endereco" required value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->ENDERECO;}?>">
          </div>
          <div class="col-lg-2">
            <label>Número</label>
            <input name="numero" id="numero" class="form-control" required="required" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->ENDERECO_NUMERO;}?>">
          </div>
          <div class="col-lg-8">
            <label>Complemento</label>
            <textarea class="form-control" rows="3" id="complemento" name="complemento"><?php if(!empty($list->COD_CLIENTE)){ echo $list->ENDERECO_COMP;}?>
</textarea>
          </div>
          <div class="col-lg-4">
            <div class="col-lg-12">
              <label>Login</label>
              <input name="login" class="form-control" value="<?php if(!empty($list->COD_CLIENTE)){ echo $list->LOGIN;}?>">
            </div>
            <div class="col-lg-12">
              <label>Senha</label>
              <input name="senha" class="form-control">
            </div>
            <div class="col-lg-12">
              <button type="submit" class="btn btn-primary">
              <?php if(!empty($list->COD_CLIENTE)){ echo 'Editar';}else{ echo 'Gravar';}?>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
