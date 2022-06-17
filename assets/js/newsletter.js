  $('document').ready(function(){
	  
	  
	// ************************************* FUNÇÂO DE EXIBIR A MENSAGEM DE ALERTA *****************************************	
var msg = function(alerta, texto) {
	var resposta = '';
	$(".resposta").empty();
				
	switch (alerta) {
	case 'sucesso':
		resposta = "<div class='alert msg btn-success text-center' role='alert'>" +
		"   <a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" + texto + "</div>";
	break;
	case 'atencao':
		resposta = "<center><img src='https://lealdutra.com.br/Painel/imagens/gif/barra1-loading.gif' width='75' height='59' /></center> "+
		"<div class='alert msg btn-warning text-center' role='alert'>" +
		"   <a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" + texto + "</div>";
		//resposta = " <center><img src='https://lcmaxsolution.com.br/Leal-Dutra/Painel/imagens/gif/barra1-loading.gif' width='75' height='59' /></center>";
	break;
	case 'erro':
		resposta = "<div class='alert msg btn-danger text-center' role='alert'>" +
		"   <a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" + texto + "</div>";
	break;
	default:
	console.warn('Opção de alerta inválido.');
	}
				
	$(".resposta").append(resposta);
				
	$(".msg").click(function() {
	$(this).hide();
	});
};  

	$("#botao-form-newsletter-gravar").click(function(){
		var data = $("#form_newsletter").serialize();
		var grv = 1;	
		$.ajax({
			type : 'POST',
			url  : 'https://lealdutra.com.br/model/newsletter/newsletter.php?gravar='+grv,
			data : data,
			dataType: 'json',
			beforeSend: function()
			{	
			msg('atencao', "Por favor aguarde, estamos validando o cadastro!");
				$("#botao-form-newsletter-gravar").html('Cadastrando ...');
			},
			success :  function(response){						
				if(response.codigo == "1"){	
					$("#botao-form-newsletter-gravar").html('Cadastrado...');
					msg('sucesso', response.mensagem);
					//window.location.href = "../index.php";
				}
				else{			
					$("#botao-form-newsletter-gravar").html('Cadastrar');
					msg('erro', response.mensagem);
					
				}
		    }
		});
	});

});
  
  
