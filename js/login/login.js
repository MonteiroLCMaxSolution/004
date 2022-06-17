function accessUser(){
	var codProduto = $("#codProduto").val();
	var login = $("#login-email").val();
	var password = $("#login-password").val();
	var lib = '';
	//******* VALIDAR O FORMULÁRIO - MONTEIRO - 11/05/2022
	if(login == ""){
		$("#mlogin").html('Informe seu E-mail, Login ou CNPJ!');
		$("#mlogin").css('color',"red");
		lib = 1;
	}else{
		$("#mlogin").html('');
	}
	if(password == ""){
		$("#mPassword").html('Informe a sua Senha!');
		$("#mPassword").css('color',"red");
		lib = 1;
	}else{
		$("#mPassword").html('');
	}
	//******* FIM VALIDAR O FORMULÁRIO 
	//******* CHAMAR O AJAX CASO A VARIÁVEL LIB FOR VAZIA - MONTEIRO - 11/05/2022
	if(lib == ''){
		$.ajax({
			url: 'https://3ecomercial.com.br/model/cliente/cliente.php/?accessUser=1&loginuser='+login+'&password='+password+'&codProduto='+codProduto,
			type: 'GET',
			dataType: 'json',
			success: function(data){
				if(data.cod == 1){
					$("#mlogin").html(data.login);
					$("#mlogin").css('color',"red");
					$("#msg").html(data.msg);
					$("#msg").css('color',"red");
					$("#mPassword").html(data.pass);
					$("#mPassword").css('color',"red");
				}else{
					$("#mlogin").html(data.login);
					$("#mlogin").css('color',"green");
					$("#msg").html(data.msg);
					$("#msg").css('color',"green");
					$("#mPassword").html(data.pass);
					$("#mPassword").css('color',"green");
					if(data.codProduto == ''){
						window.location.href = 'https://3ecomercial.com.br/';
					}else{
						
						window.location.href = 'https://3ecomercial.com.br/?pg=detalhes-produto&codProduto='+data.codProduto;
					}
				}
			},
			error: function(){
				alert('erro ao realizar sua requisição!');
			}
			
		})
	}
	
	//******* FIM CHAMAR O AJAX CASO A VARIÁVEL LIB FOR VAZIA
	
}