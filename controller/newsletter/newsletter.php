<div class="newsletter-popup mfp-hide" id="newsletter-popup-form" style="background-image: url(assets/images/newsletter_popup_bg.jpg)">
        <div class="newsletter-popup-content">
            <img src="assets/images/logo-black.png" alt="Logo" class="logo-newsletter">
            <h2>Fique por dentro de nossas promoções</h2>
            <p>Cadastre na nossa Newsleeter e fique por dentro</p>
            <form action="" method="POST" id="form_newsletter" name="form_newsletter">
                <div class="input-group">
                    <input type="email" class="form-control" id="newsletter-email" name="newsletter-email" placeholder="Digite seu Email" required>
                    <!--<input type="submit" class="btn" value="Cadastrar">-->
                </div><!-- End .from-group -->
            </form>
            <button id="botao-form-newsletter-gravar" name="botao-form-newsletter-gravar" class="btn btn-primary">Cadastrar</button>
            <div class="resposta"></div>
        </div><!-- End .newsletter-popup-content -->
    </div><!-- End .newsletter-popup -->

    <script src="<?php echo $http; ?>/assets/js/ajax.js"></script>