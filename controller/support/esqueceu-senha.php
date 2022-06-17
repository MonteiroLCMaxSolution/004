<form action="<?php echo $http; ?>/model/recuperar-senha/envia-senha.php/?rc='1'" method="post">
  <div class="container">
    <div align="center" class="col-lg-12">
      <div> <br />
        <br />
      </div>
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12" align="center">
          <label>Para recuperar sua senha, digite seu CNPJ para enviarmos um email de recuperação.</label>
        </div>
        <br />
        <div class="col-sm-12 col-md-3 col-lg-3"></div>
        <div class="col-sm-12 col-md-6 col-lg-6" align="center">
          <input id="CNPJ" placeholder="Digite um CNPJ" name="CNPJ" type="text" class="form-control" onkeypress="return mask(event, this, '##.###.###/####-##')" maxlength="18" required>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3"></div>
        <div align="center" class="col-lg-12"> <br />
          <input type="submit" value="Recuperar Senha" class="btn btn-primary">
        </div>
      </div>
    </div>
  </div>
</form>
