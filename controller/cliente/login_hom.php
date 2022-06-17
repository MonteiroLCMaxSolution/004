
<div class="row" style="margin-top:10px">

    <div class="col-md-6">
         <h2 class="title mb-2">Cadastrar</h2><span> Se ainda não é cadastrado em nosso sistema e quer aproveitar das facilidades de comprar e consultar os nossos preços e até mesmo receber nossas promoções é só clicar  no botão abaixo para preencher o formulário e em segundos já poder efetuar sua compra com total segurança!</span>

        <div class="form-footer">
            <div ><a href="?pg=dados_cliente" class="btn btn-primary btn-md">Registrar</a></div>
        </div><!-- End .form-footer -->
    </div><!-- End .col-md-6 -->

    <div class="col-md-6">
		<div id="msg"></div>
		<h2 class="title mb-2">Faça seu Login </h2>

       
        	<input id="codProduto" name="codProduto"  value="<?php if(isset($_GET['codProduto'])){ echo  $_GET['codProduto'];}?>" />
            <label for="login-email">Login, Email ou CNPJ <span class="required">*</span> <span id="mlogin"></span></label>
            <input name="login" class="form-input form-wide mb-2" id="login-email" required />

            <label for="login-password">Senha <span class="required">*</span> <span id="mPassword"></span></label>
            <input type="password" class="form-input form-wide mb-2" id="login-password" required name="password" />

            <div class="form-footer">
                <button type="submit" class="btn btn-primary btn-md" onClick="accessUser()">Entrar</button>


            </div><!-- End .form-footer -->
            <a href="?pg=recuperar_senha" class="forget-password"> Esqueceu sua senha?</a><br />
            <a href="pg=dados_cliente" class="forget-password"> Não tem cadastro? Clique aqui.</a> 
       
		
       
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../../js/login/login.js"></script>