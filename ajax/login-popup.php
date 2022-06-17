<?php include_once ("../conexao-pdo/config.php"); ?>
<div class="modal-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="title mb-2">Faça seu Login <?php session_start(); //echo $_SESSION['codprodutodados']; ?></h2>

                <form action="<?php echo $http; ?>/model/cliente/cliente.php?login='1'" class="mb-1" method="post">
                    <label for="login-email">Login, Email ou CNPJ <span class="required">*</span></label>
                    <input name="login" class="form-input form-wide mb-2" id="login-email" required />

                    <label for="login-password">Senha <span class="required">*</span></label>
                    <input type="password" class="form-input form-wide mb-2" id="login-password" required name="password" />

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-md">Entrar</button>

                        
                    </div><!-- End .form-footer -->
                    <a href="<?php echo $http; ?>/?pg=recuperar_senha" class="forget-password"> Esqueceu sua senha?</a><br />
                    <a href="<?php echo $http; ?>/?pg=dados_cliente" class="forget-password"> Não tem cadastro? Clique aqui.</a> 
                </form>
            </div><!-- End .col-md-6 -->

            <div class="col-md-6">
                <h2 class="title mb-2">Cadastrar</h2><span> Se ainda não é cadastrado em nosso sistema e quer aproveitar das facilidades de comprar e consultar os nossos preços e até mesmo receber nossas promoções é só clicar  no botão abaixo para preencher o formulário e em segundos já poder efetuar sua compra com total segurança!</span>
                    <div class="form-footer">
                        <div ><a href="<?php echo $http; ?>/?pg=dados_cliente" class="btn btn-primary btn-md">Registrar</a></div>
                    </div><!-- End .form-footer -->
        </div><!-- End .row -->
    </div><!-- End .container -->
</div>