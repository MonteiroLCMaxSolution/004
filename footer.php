  <div class="container">
            <footer class="footer">
                <div class="footer-top">
                   <div class="row">
                        <div class="col-lg-12">
                           <!-- <div class="widget widget-newsletter">-->
                            <div class="widget ">
                                <h4 class="widget-title">Assine nossa newsletter</h4>
                                <form id="form_newsletter" role="form" action="" method="post">
                                    <div class="row">
                                    <div class="col-lg-3">
                                           <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome" required> 
                                    </div>
                                    <div class="col-lg-3">
                                           <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="col-lg-3">
                                           <input type="text" name="cep" id="cep" class="form-control" placeholder="Cep" onkeypress="return mask(event, this, '#####-###')"  maxlength="9" required>
                                    </div>
                                    <div class="col-lg-3">
                                            <button class="btn" type="button" name="botao-form-newsletter-gravar" id="botao-form-newsletter-gravar">Cadastrar</button>
                                    </div>
                                    </div>
                                        </form>
                                        <div class="row">
                                            <div id="resposta"></div>
                                        </div>
                                <!--<form action="#">
                                    <input type="email" class="form-control" placeholder="Digite seu Email" required>

                                    <input type="submit" class="btn" value="Cadastrar">
                                </form>-->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-7 -->
                   </div><!-- End .row -->
                </div><!-- End .footer-top -->

                <div class="footer-middle">
                    <div class="row">
                        <div class="col-md-6 col-lg-6" align="center">
                            <img src="<?php echo $http; ?>/Painel/imagens/logo/<?php echo $LogoEmpresaBranco; ?>" width="200px" class="footer-logo" alt="Footer logo">
                        </div><!-- End .col-lg-3 -->
                        <div class="col-md-6 col-lg-3">
                            <div class="widget">
                                <ul class="contact-info">
                                    <li>
                                        <span class="contact-info-label">Endereço:</span>Jardim Terras de São João - CEP 12.324-020 - JACAREI SP
                                    </li>
                                    <li>
                                        <span class="contact-info-label">Fone:</span><a href="tel:">(12) 3961-6444</a>
                                    </li>
                                    <li>
                                        <span class="contact-info-label">Email:</span> <a href="vendas@3ecomercial.com.br">vendas@3ecomercial.com.br</a>
                                    </li>
                                    <li>
                                        <span class="contact-info-label">Horario de Trabalho:</span>
                                        Segunda a Sexta-Feira / 08:00h - 16:00h
                                    </li>
                                </ul>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->

                        <div class="col-md-6 col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Páginas Institucionais</h4>

                                <ul class="links">
                                    <li><a href="?pg=como-comprar">Como Comprar</a></li>
                                    <li><a href="?pg=forma-de-entrega">Forma de Entrega</a></li>
                                    <li><a href="?pg=forma-de-pagamento">Forma de Pagamento</a></li>
                                    <li><a href="?pg=politica-de-seguranca">Politica de Segurança</a></li>
                                    <li><a href="?pg=politica-de-troca">Politica de Troca</a></li>
                                </ul>
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-3 -->
                   </div><!-- End .row -->
                </div><!-- End .footer-middle -->

                <div class="footer-bottom">
                    <p class="footer-copyright">3E Comercial. Matriz CNPJ: 05.845.493/0001-84  &copy;  2014 - <?php echo date('Y'); ?>.  Todos os Direitos Reservados - desenvolvido por <a href="https://www.lcmaxsolution.com.br/" target="_blank">LCMaxSolution</a> - <a href="<?php echo $http.'/Painel/view/login/';?>">Painel de Controle</a></</p>

                    <!--<img src="assets/images/payments.png" alt="payment methods" class="footer-payments">-->

                    <div class="social-icons">
                       <!-- <a href="#" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                        <a href="#" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                        <a href="#" class="social-icon" target="_blank"><i class="icon-linkedin"></i></a> -->
                    </div><!-- End .social-icons -->
                </div><!-- End .footer-bottom -->
            </footer><!-- End .footer -->
        </div><!-- End .container -->