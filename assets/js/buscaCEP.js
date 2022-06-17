
	function listarCidades() {
      
	  
	  function CriaRequest() {
     try{
         request = new XMLHttpRequest();        
     }catch (IEAtual){
          
         try{
             request = new ActiveXObject("Msxml2.XMLHTTP");       
         }catch(IEAntigo){
          
             try{
                 request = new ActiveXObject("Microsoft.XMLHTTP");          
             }catch(falha){
                 request = false;
             }
         }
     }
      
     if (!request) 
         alert("Seu Navegador não suporta Ajax!");
     else
         return request;
 }
     // Declaração de Variáveis
     var nome   = document.getElementById("uf").value;
     var result = document.getElementById("cidadelistar");
     var xmlreq = CriaRequest();
      
     // Exibi a imagem de progresso
     result.innerHTML = '<img src="Progresso1.gif"/>';
      
     // Iniciar uma requisição
	 alert ('id do estado é: '+nome);
     xmlreq.open("GET", "../../../controller/cliente/cidadelistar.php?uf=" + nome, true);
      
     // Atribui uma função para ser executada sempre que houver uma mudança de ado
     xmlreq.onreadystatechange = function(){
          
         // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
         if (xmlreq.readyState == 4) {
              
             // Verifica se o arquivo foi encontrado com sucesso
             if (xmlreq.status == 200) {
                 result.innerHTML = xmlreq.responseText;
             }else{
                 result.innerHTML = "Erro: " + xmlreq.statusText;
             }
         }
     };
     xmlreq.send(null);
 }
	


    function limpa_formulário_cep() {
            document.getElementById('endereco').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
			 }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            document.getElementById('endereco').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
			/*var comboUF = document.getElementById("uf");
			var opt0 = document.createElement("option");
			opt0.value = document.getElementById('uf').value=(conteudo.uf);
			opt0.text = document.getElementById('uf').value=(conteudo.uf);
			comboUF.add(opt0, comboUF.options[0]);
			
			var comboCidade = document.getElementById("cidade");
			var opt1 = document.createElement("option");
			opt1.value = document.getElementById('cidade').value=(conteudo.localidade);
			opt1.text = document.getElementById('cidade').value=(conteudo.localidade);
			comboCidade.add(opt1, comboCidade.options[0]); */
        }
        else {
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
	
  function pesquisacep(valor) {
        var cep = valor.replace(/\D/g, '');
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if(validacep.test(cep)) {
                document.getElementById('endereco').value="Aguarde...";
                document.getElementById('bairro').value="Aguarde...";
                document.getElementById('cidade').value="Aguarde...";
                document.getElementById('uf').value="Aguarde...";
				document.getElementById('complemento').value="";
				document.getElementById('numero').value="";
                var script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
                document.body.appendChild(script);
            }
            else {
                limpa_formulário_cep();
            }
        } 
        else {
            limpa_formulário_cep();
        }
    }    