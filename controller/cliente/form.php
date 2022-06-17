<?
include '../../config.php';
?>
<link href="../../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<form name="form1" action="<?php echo $pastaPrincipal;?>/model/cliente/cliente.php?grv='1'" method="post">
  <div class="container">
    <h2>Dados do Cliente</h2>
    <div class="row">
      <div class="col-lg-2">
        <label>Código</label>
        <input name="codigo" class="form-control" readonly="readonly">
      </div>
      <div class="col-lg-10">
        <label>Empresa</label>
        <input name="empresa" class="form-control" required="required">
      </div>
      <div class="col-lg-5">
        <label>Contato</label>
        <input name="contato" class="form-control" required="required">
      </div>
      <div class="col-lg-5">
        <label>E-mail</label>
        <input name="email" class="form-control" required="required">
      </div>
      <div class="col-lg-2">
        <label>Fone</label>
        <input name="fone" class="form-control" required="required" onkeypress="return mask(event, this, '(##) ####-####')" maxlength="14" placeholder=" (DDD) 0000-0000">
      </div>
      <div class="col-lg-5">
        <label>Nome Fantasia</label>
        <input name="nome_fantasia" class="form-control" required="required">
      </div>
      <div class="col-lg-5">
        <label>E-mail de Cobrança</label>
        <input name="email_cobranca" class="form-control" required="required">
      </div>
      <div class="col-lg-2">
        <label>Celular</label>
        <input name="celular" class="form-control" required="required" onkeypress="return mask(event, this, '(##) #####-####')" maxlength="15" placeholder=" (DDD) 0000-0000">
      </div>
      <div class="col-lg-6">
        <label>
        <div id="validouCNPJ">CNPJ (*)</div>
        </label>
        <input name="CNPJ" id="CNPJ" class="form-control CNPJ" required="required" onkeyup="validaCNPJ(this.value)" onkeypress="return mask(event, this, '##.###.###/####-##')" maxlength="18" placeholder="">
      </div>
      <div class="col-lg-3">
        <label>Inscrição Estadual</label>
        <input name="IE" class="form-control" required="required">
      </div>
      <div class="col-lg-3">
        <label>Inscrição Municipal</label>
        <input name="IM" class="form-control" required="required">
      </div>
      <div class="col-lg-2">
        <label>CEP</label>
        <input name="CEP" class="form-control" onkeypress="return mask(event, this, '#####-###')" maxlength="9" placeholder="" id="cep" value="" onkeyup="pesquisacep(this.value);" required>
      </div>
      <div class="col-lg-2">
        <label>UF</label>
        <input name="uf" id="uf"	class="form-control" required="required" readonly="readonly" />
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
          <input name="cidade" id="cidade" class="form-control" required="required" readonly="readonly" />
          <!-- <select name="cidade" id="cidade" class="form-control" required="required">
        <option value=""></option>
      </select> --></div>
      </div>
      <div class="col-lg-4">
        <label>Bairro</label>
        <input name="bairro" id="bairro" class="form-control" required="required">
      </div>
      <div class="col-lg-10">
        <label>Endereço</label>
        <input type="text" class="form-control" id="endereco" name="endereco" required>
      </div>
      <div class="col-lg-2">
        <label>Número</label>
        <input name="numero" id="numero" class="form-control" required="required">
      </div>
      <div class="col-lg-8">
        <label>Complemento</label>
        <textarea class="form-control" rows="3" id="complemento" name="complemento"></textarea>
      </div>
      <div class="col-lg-4">
        <div class="col-lg-12">
          <label>Login</label>
          <input name="login" class="form-control">
        </div>
        <div class="col-lg-12">
          <label>Senha</label>
          <input name="senha" class="form-control">
        </div>
        <div class="col-lg-12">
          <input type="submit" class="btn btn-primary">
        </div>
      </div>
    </div>
  </div>
</form>
