var http='https://lcmaxsolution.com.br/Leal-Dutra';

$('document').ready(function(){
	
// ************************************* FUNÇÂO DE EXIBIR A MENSAGEM DE ALERTA********************************************************	
var msg = function(alerta, texto) {
	var resposta = '';
	$(".resposta").empty();
				
	switch (alerta) {
	case 'sucesso':
		resposta = "<div class='alert msg btn-success text-center' role='alert'>" +
		"   <a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" + texto + "</div>";
	break;
	case 'atencao':
		resposta = "<center><img src='https://lcmaxsolution.com.br/Leal-Dutra/Painel/imagens/gif/barra1-loading.gif' width='75' height='59' /></center> "+
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


// ************************************* FUNÇÂO DE GRAVAR USUARIO********************************************************	
$("#bt-form-enqueteCartao-gravar").click(function(){
			var data = $("#enqueteCartao").serialize();
		var grv = 1;
		$.ajax({
			type : 'POST',
			url  : http+'/model/enquete/enquete-model.php?gravar='+grv,
			data : data,
			dataType: 'json',
			beforeSend: function() {
				msg('atencao', "Por favor aguarde, estamos enviando os dados!");
				$("#bt-form-enqueteCartao-gravar").html('Enviando resposta ...');
				
			},		
			success :  function(response){	
				if(response.codigo == 1){
						msg('sucesso', response.mensagem);
						$("#bt-form-enqueteCartao-gravar").html('Obrigado pela resposta.');
			 			window.location.href = http; 
				}else{
					msg('erro',response.mensagem);
									}

		    },
			error: function(){
   			msg('erro', "Não foi possivel completar a requisição!");
			}		
		});
	});



});