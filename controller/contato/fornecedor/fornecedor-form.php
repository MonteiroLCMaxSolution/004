<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Adicionando Javascript -->
<script type="text/javascript" ></script>
<script>
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('endereco').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
			 }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('endereco').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
	
  function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('endereco').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };
    </script>
</head>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2 class="light-title">Seja um Fornecedor</h2>
      <form id="formulario" action="../../../model/contato/fornecedor/fornecedor.php/?grv='1'" enctype="multipart/form-data" method="post">
        <div class="panel panel-warning">
          <div class="panel-body" style="padding: 5px;">
            <div class="row">
              <div class='col-sm-12 col-md-8 col-lg-8'>
                <div class="form-group required-field">
                  <label for="nome">Nome Empresa</label>
                  <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-4 col-lg-4'>
                <div class="form-group required-field">
                  <label for="cpf_cnpj">CNPJ</label>
                  <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" onKeyPress="return mask(event, this, '##.###.###/####-##')" maxlength="18" required>
                </div>
                <!-- End .form-group --> 
              </div>
            </div>
            <div class="row">
              <div class='col-sm-12 col-md-3 col-lg-3'>
                <div class="form-group required-field">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-3 col-lg-3'>
                <div class="form-group required-field">
                  <label for="fone">Telefone</label>
                  <input type="tel" class="form-control" id="fone" name="fone" onKeyPress="return mask(event, this, '(##) #####-####')" maxlength="15" required>
                  </select>
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-3 col-lg-3'>
                <div class="form-group">
                  <label for="fone">Celular</label>
                  <input type="tel" class="form-control" id="fone_cel" name="fone_cel" onKeyPress="return mask(event, this, '(##) #####-####')" maxlength="15" required>
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-3 col-lg-3'>
                <div class="form-group required-field">
                  <label for="contato">Nome Contato</label>
                  <input type="text" class="form-control" id="contato" name="contato"  required>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- FIM DA BORDA -->
        <div class="panel panel-warning"> 
          <!-- <div class="panel-heading">Endereço</div> -->
          <div class="panel-body" style="padding: 5px;">
            <div class="row">
              <div class='col-sm-12 col-md-2 col-lg-2'>
                <div class="form-group required-field">
                  <label for="CEP">CEP</label>
                  <input type="text" class="form-control" id="cep" name="CEP" value="" maxlength="9" onBlur="pesquisacep(this.value);" onkeypress="return mask(event, this, '#####-###')" maxlength="9" required>
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-2 col-lg-2'>
                <div class="form-group required-field">
                  <label for="uf">UF</label>
                  <input type="text" class="form-control" id="uf" name="uf" required>
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-4 col-lg-4'>
                <div class="form-group required-field">
                  <label for="cidade">Cidade</label>
                  <input type="text" class="form-control" id="cidade" name="cidade" required>
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-4 col-lg-4'>
                <div class="form-group required-field">
                  <label for="bairro">Bairro</label>
                  <input type="text" class="form-control" id="bairro" name="bairro">
                </div>
                <!-- End .form-group --> 
              </div>
            </div>
            <div class="row">
              <div class='col-sm-12 col-md-8 col-lg-8'>
                <div class="form-group required-field">
                  <label for="endereco">Endereço</label>
                  <input type="text" class="form-control" id="endereco" name="endereco" required>
                </div>
                
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-4 col-lg-4'>
                <div class="form-group required-field">
                  <label for="bairro">Numero</label>
                  <input type="text" class="form-control" id="numero" name="numero">
                </div>
                <!-- End .form-group --> 
              </div>
            </div>
          </div>
          <!-- DIV's CSS --> 
        </div>
        <div class="row">
        <div class='col-sm-12 col-md-6 col-lg-6'>
        <div class="panel panel-warning">
      <!--    <div class="panel-heading">Escolaridade</div> -->
          <div class="panel-body" style="padding: 5px;">
            <div class="row">
              <div class='col-sm-12 col-md-12 col-lg-12'>
                <div class="form-group required-field">
                   <div class="form-group required-field">
              <label for="objetivo">Mensagem</label>
              <textarea cols="30" rows="1" id="contact-message" class="form-control" name="mensagem" required></textarea>
            </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       </div>
       <div class='col-sm-12 col-md-6 col-lg-6'>
        <div class="panel panel-warning">
       <!--   <div class="panel-heading">Arquivo</div> -->
          <div class="panel-body" style="padding: 5px;">
            <div class="row"> 
              <!---------------------- ENVIA ARQUIVO --------------------->
              <div class='col-sm-12 col-md-12 col-lg-12'>
            
             
            
                <div class="form-group required-field">
                  <label for="enviar_img">Enviar Arquivo</label>
                  <br />
                  
                  <!--  <input id="arquivo" type="file" name="arquivo">
      <div id="img"></div>  --> 
                  
                  <!-- novo elemento! -->
                  <input class="file-button" type="button" value="Selecione uma Imagem">
                  
                  <!-- invisível -->
                  
                  <input id="arquivo" name="arquivo" class="file-chooser" type="file" accept="image/*" hidden>
                  <img class="preview-img" width="200px"> 
                  <script>
    const $ = document.querySelector.bind(document);

const previewImg = $('.preview-img');
const fileChooser = $('.file-chooser');
const fileButton = $('.file-button');

fileButton.onclick = () => fileChooser.click();

fileChooser.onchange = e => {
    const fileToUpload = e.target.files.item(0);
    const reader = new FileReader();
    reader.onload = e => previewImg.src = e.target.result;
    reader.readAsDataURL(fileToUpload);
};
    </script> 
                </div>
              </div>
            </div>
          </div>
        </div>
       </div>
      </div>
        <!-- fim ROw-->
        
        <div style="float:right !important">
          <div class="form-footer">
            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
          <!-- End .form-footer --> 
        </div>
      </form>
    </div>
  </div>
  <!-- End .row --> 
</div>
<!-- End .container -->