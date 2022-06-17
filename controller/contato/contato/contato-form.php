
<nav aria-label="breadcrumb" class="breadcrumb-nav">
  <div class="container">
    <ol class="breadcrumb mt-0">
      <li class="breadcrumb-item"><a href="index.php"><i class="icon-home"></i></a></li>
      <li class="breadcrumb-item active" aria-current="page">Fale Conosco</li>
    </ol>
  </div>
  <!-- End .container --> 
</nav>
<div class="container">
  <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
      <h3> 3E Comercial - Jacareí - SP </h3>
      <p>Endereço: Av. Wilson Nogueira Soares, nº 41<br />
        Televendas: (12) 3961-6444 - vendas@3ecomercial.com.br<br />
 
      <p>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3664.0958139007985!2d-45.99726558502698!3d-23.31228218480713!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94cdcc93e834de45%3A0xacdbfde98cca7dbd!2sAv.%20Wilsom%20Nogueira%20Soares%2C%2041%20-%20Jardim%20Sao%20Luiz%2C%20Jacare%C3%AD%20-%20SP%2C%2012324-020!5e0!3m2!1spt-BR!2sbr!4v1584734468518!5m2!1spt-BR!2sbr" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    </div>
    <br />
    <br />
  </div>
  <div class="row">
    <div class="col-md-12">
      <h2 class="light-title">Fale Conosco</h2>
    </div>
    <div class="col-md-6">
      <form action="<?php echo $http; ?>/model/contato/contato/contato.php/?grv='1'" method="post">
        <div class="form-group required-field">
          <label for="contact-name">Nome</label>
          <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="form-group required-field">
          <label for="contact-email">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group required-field">
          <label for="contact-phone">Telefone</label>
          <input type="tel" class="form-control" id="fone" name="fone" onKeyPress="return mask(event, this, '(##) #####-####')" required>
        </div>
      </div>
      
       <div class="col-md-6">
        <div class="form-group required-field">
          <label for="unidade">Unidade</label>
          <select type="text" class="form-control" id="unidade" name="unidade" r equired>
            <option value="SP">Jacareí - SP</option>
          </select>
        </div>
        <div class="form-group required-field">
          <label for="contact-message">Mensagem</label>
          <textarea cols="30" rows="1" id="mensagem" class="form-control" name="mensagem" required></textarea>
        </div>
        <div style="float:right !important">
          <div class="form-footer">
            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
