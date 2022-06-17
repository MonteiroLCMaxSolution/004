<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
.panel {
	margin-bottom: 15px;
	border-radius: 0;
	box-shadow: none;
}
.panel-warning {
	border: 1px solid #999;
}
.panel-heading {
	color: #000;
	background-color: #CCC;
	border-color: #CCC;
}
.panel-body {
	border: 1px solid #999;
}
</style>
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
      <h2 class="light-title">Trabalhe Conosco</h2>
      <form id="formulario" action="../../../model/contato/trabalhe-conosco/trabalhe-conosco.php/?grv='1'" enctype="multipart/form-data" method="post">
        <div class="panel panel-warning">
          <div class="panel-heading">Perfil</div>
          <div class="panel-body" style="padding: 5px;">
            <div class="row">
              <div class='col-sm-12 col-md-8 col-lg-8'>
                <div class="form-group required-field">
                  <label for="nome">Nome Completo</label>
                  <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-4 col-lg-4'>
                <div class="form-group required-field">
                  <label for="data_nasc">Data Nascimento</label>
                  <input type="date" class="form-control" id="data_nasc" name="data_nasc" required>
                </div>
                <!-- End .form-group --> 
              </div>
            </div>
            <div class="row">
              <div class='col-sm-12 col-md-3 col-lg-3'>
                <div class="form-group required-field">
                  <label for="nascionalidade">Nascionalidade</label>
                  <select class="form-control" id="nacionalidade" name="nascionalidade">
                    <option value ="Brasileiro">Brasileiro</option>
                    <option value = "Estrangeiro">Estrangeiro</option>
                  </select>
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-3 col-lg-3'>
                <div class="form-group required-field">
                  <label for="est_civil">Estado Civil</label>
                  <select class="form-control" id="est_civil" name="est_civil" required>
                    <option value ="Solteiro(a)">Solteiro(a)</option>
                    <option value ="Casado(a)">Casado(a)</option>
                    <option value ="Viúvo(a)">Viúvo(a)</option>
                    <option value ="Divorciado(a)">Divorciado(a)</option>
                    <option value ="União Estavel">União Estável</option>
                  </select>
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-3 col-lg-3'>
                <div class="form-group required-field">
                  <label for="dependentes">Possui Filhos?</label>
                  <select class="form-control" id="dependentes" name="dependentes" required>
                    <option value = "nao">Não</option>
                    <option value = "sim">Sim</option>
                  </select>
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-3 col-lg-3'>
                <div class="form-group">
                  <label for="num_depend">Nº de Filhos</label>
                  <select class="form-control" id="num_depend" name="num_depend">
                    <option value = "0">0</option>
                    <option value = "1">1</option>
                    <option value = "2">2</option>
                    <option value = "3">3</option>
                    <option value = "4">4</option>
                    <option value = "5">5</option>
                    <option value = "6">6</option>
                    <option value = "7">7</option>
                    <option value = "8">8</option>
                    <option value = "9">9</option>
                  </select>
                </div>
                <!-- End .form-group --> 
              </div>
            </div>
            <div class="row">
              <div class='col-sm-12 col-md-3 col-lg-3'>
                <div class="form-group required-field">
                  <label for="cnh">CNH</label>
                  <br />
                  <input type="checkbox" class="" id="A" name="A" value = 'A' >
                  A
                  <input type="checkbox" class="" id="B" name="B" value = 'B' >
                  B
                  <input type="checkbox" class="" id="C" name="C" value = 'C' >
                  C
                  <input type="checkbox" class="" id="D" name="D" value = 'D' >
                  D
                  <input type="checkbox" class="" id="E" name="E" value = 'E' >
                  E <br />
                  <input type="checkbox" class="" id="N" name="N" value = 'N' >
                  Não Possuo </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-3 col-lg-3'>
                <div class="form-group required-field">
                  <label for="fone">Telefone</label>
                  <input type="tel" class="form-control" id="fone" name="fone" onKeyPress="return mask(event, this, '(##) #####-####')" maxlength="15" required>
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-3 col-lg-3'>
                <div class="form-group required-field">
                  <label for="fone_cel">Celular</label>
                  <input type="tel" class="form-control" id="fone_cel" name="fone_cel" onKeyPress="return mask(event, this, '(##) #####-####')" maxlength="15">
                </div>
                <!-- End .form-group --> 
              </div>
              <div class='col-sm-12 col-md-3 col-lg-3'>
                <div class="form-group required-field">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <!-- End .form-group --> 
              </div>
            </div>
          </div>
        </div>
        <div class="panel panel-warning">
          <div class="panel-heading">Endereço</div>
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
        <div class="panel panel-warning">
        <div class="panel-heading">Funções na Empresa</div>
        <div class="panel-body" style="padding: 5px;">
        <div class="row">
          <div class='col-sm-12 col-md-6 col-lg-6'>
            <div class="form-group required-field">
              <label for="objetivo">Objetivo</label>
              <textarea cols="30" rows="1" id="contact-message" class="form-control" name="objetivo" required></textarea>
            </div>
            <!-- End .form-group --> 
          </div>
          <div class='col-sm-12 col-md-6 col-lg-6'>
            <div class="form-group required-field">
              <label for="contact-name">Area de Interesse</label>
              <br />
              <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                  <input type="checkbox" class="" id="adm" name="adm" value = '1' >
                  Administrativo <br />
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                  <input type="checkbox" class="" id="expedi_logi" name="expedi_logi" value = '1' >
                  Expedição/Logistica <br />
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                  <input type="checkbox" class="" id="motorista" name="motorista" value = '1' >
                  Motorista <br />
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                  <input type="checkbox" class="" id="telemarketing" name="telemarketing" value = '1' >
                  Televendas <br />
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                  <input type="checkbox" class="" id="ti" name="ti" value = '1'>
                  Área de TI <br />
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                  <input type="checkbox" class="" id="representante" name="representante" value = '1'>
                  Representante Comercial <br />
                </div>
              </div>
            </div>
            <label>Qual a função de interesse?</label>
            <input type="text" name="desc_area" id="desc_area" class="form-control">
            <!-- End .form-group --> 
          </div>
        </div>
        </div>
        </div>
        
         <div class="panel panel-warning">
        <div class="panel-heading">Escolaridade</div>
        <div class="panel-body" style="padding: 5px;">
        <div class="row">
          <div class='col-sm-12 col-md-4 col-lg-4'>
            <div class="form-group required-field">
              <label for="grau_esc">Grau de Ensino</label>
              <select class="form-control" id="grau_esc" name="grau_esc">
                <option value ="Ensino Fundamental Incompleto">Ensino Fundamental Incompleto</option>
                <option value = "Ensino Fundamental Completo">Ensino Fundamental Completo</option>
                <option value ="Ensino Médio Incompleto">Ensino Médio Incompleto</option>
                <option value = "Ensino Médio Completo">Ensino Médio Completo</option>
                <option value = "Curso Técnico">Curso Técnico</option>
                <option value = "Graduação">Graduação</option>
                <option value = "Pós - Graduação">Pós - Graduação</option>
                <option value = "Mestrado">Mestrado</option>
                <option value = "Doutorado">Doutorado</option>
              </select>
            </div>
          </div>
          <div class='col-sm-12 col-md-2 col-lg-4'>
            <div class="form-group required-field">
              <label for="inic_esc">Data Inicio</label>
              <input type="date" class="form-control" id="inic_esc" name="inic_esc">
            </div>
          </div>
          <div class='col-sm-12 col-md-2 col-lg-4'>
            <div class="form-group required-field">
              <label for="fim_esc">Data Final</label>
              <input type="date" class="form-control" id="fim_esc" name="fim_esc">
            </div>
          </div>
          <div class='col-sm-12 col-md-6 col-lg-6'>
            <div class="form-group">
              <label for="nome_curso">Nome do Curso</label>
              <input type="text" class="form-control" id="nome_curso" name="nome_curso">
            </div>
          </div>
          <div class='col-sm-12 col-md-6 col-lg-6'>
            <div class="form-group">
              <label for="inic_esc">Nome Escola</label>
              <input type="text" class="form-control" id="nome_escola" name="nome_escola">
            </div>
          </div>
          <div class='col-sm-12 col-md-6 col-lg-6'>
            <div class="form-group required-field">
              <label for="idioma">Idioma</label>
              <select class="form-control" id="idioma" name="idioma">
                <option value ="Ingles">Ingles</option>
                <option value = "Frances">Frances</option>
                <option value ="Espanhol">Espanhol</option>
                <option value = "Alemão">Alemão</option>
                <option value = "Outro">Outro</option>
              </select>
            </div>
          </div>
          <div class='col-sm-12 col-md-6 col-lg-6'>
            <div class="form-group required-field">
              <label for="nivel">Nivel do Idioma</label>
              <select class="form-control" id="nivel" name="nivel">
                <option value ="Basico">Básico</option>
                <option value = "Intermediario">Intermediário</option>
                <option value ="Fluente">Fluente</option>
              </select>
            </div>
          </div>
          </div>
          </div>
        </div>
         <div class="panel panel-warning">
        <div class="panel-heading">Arquivo</div>
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
        <!-- fim ROw-->
         <div class="panel panel-warning">
        <div class="panel-heading">Experiencias Anteriores</div>
        <div class="panel-body" style="padding: 5px;">
        <div class="row">
          <div class='col-sm-12 col-md-12 col-lg-12'> 
            <!-- Inicio campo adicionar empresa --> 
            
            <!--  exemplo de camp   Nome Empresa <input type="text" id="fone" name="fone[]"  maxlength="14" size="14" /> -->
            
            <div id="origem">
              <div class='col-sm-12 col-md-12 col-lg-12'>
                <div class="row">
                  <div class='col-sm-12 col-md-6 col-lg-6'>
                    <div class="form-group required-field">
                      <label for="">Nome Empresa</label>
                      <input type="text" class="form-control" id="nome_emp[]" name="nome_emp[]" required>
                    </div>
                    <!-- End .form-group --> 
                  </div>
                  <div class='col-sm-12 col-md-6 col-lg-6'>
                    <div class="form-group required-field">
                      <label for="">Cidade Empresa</label>
                      <input type="text" class="form-control" id="cid_emp[]" name="cid_emp[]">
                    </div>
                    <!-- End .form-group --> 
                  </div>
                </div>
                <div class="row">
                  <div class='col-sm-6 col-md-3 col-lg-3'>
                    <div class="form-group required-field">
                      <label for="">Data de Inicio</label>
                      <input type="date" class="form-control" id="inicio_emp[]" name="inicio_emp[]">
                    </div>
                  </div>
                  <div class='col-sm-6 col-md-3 col-lg-3'>
                    <div class="form-group required-field">
                      <label for="">Data Final</label>
                      <input type="date" class="form-control" id="fim_emp[]" name="fim_emp[]">
                    </div>
                  </div>
                  <!-- End .form-group -->
                  <div class='col-sm-12 col-md-6 col-lg-6'>
                    <div class="form-group required-field">
                      <label for="">Cargo/Função na Empresa</label>
                      <input type="text" class="form-control" id="cargo_emp[]" name="cargo_emp[]">
                    </div>
                    <!-- End .form-group --> 
                  </div>
                </div>
              </div>
            </div>
            <div id="destino"> </div>
            <?php ?>
            <div align="right"> <a style="cursor: pointer;" id="adicionar"  onClick="duplicarCampos();"> Adicionar Empresa </a> / <a style="cursor: pointer;" id="remover" onClick="removerCampos(this);">Remover Empresa </a> </div>
            <script type="text/javascript">
			var count = 2;
			
    function duplicarCampos(){
		
	if(count<=3){
		
	var clone = document.getElementById('origem').cloneNode(true);
	var destino = document.getElementById('destino');
	destino.appendChild (clone);
	
	var camposClonados = clone.getElementsByTagName('input');
	
	<!-- if (i=0; i<=3) {-->
		<!-- for(i=0; i<camposClonados.length;i++){ -->
		for(i=0; i<camposClonados.length ;i++){
			camposClonados[i].value = '';
<!--		} -->
	}
	count++;
  }else{
	  $("#disable").click(function (){
  $("adicionar").prop("disable",true);
	  });
  }

  
	
}

function removerCampos(id){
	var node1 = document.getElementById('destino');
	node1.removeChild(node1.childNodes[1]);
	
	count--;		

	
	
}
</script> 
            <!-- FIM do campo adicionar empresa --> 
          </div>
        </div>
        </div>
        </div>
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