//var http = $("#http").val();
var http = 'https://3ecomercial.com.br';
var pasta = '';
var pach = http + pasta;
/*--------- verificar o cookie - LEÔNIDAS MONTERO - 28/08/2020 */
// função para validar se o campo permite multiplos - Leônidas Monteiro - 30/03/2022
function valid_qtd(str){
	var qtde = $("#qtde").val();
	var x = parseFloat(qtde) / parseFloat(str);
	var qtdeEstoque = $("#qtdeEstoque").val();
	if(x % 1 === 0) {
    //alert("É inteiro");
} else {
    $("#qtde").val(str);
}
	qtde = $("#qtde").val();
	if(parseFloat(qtde) > parseFloat(str) ){
		$("#qtde").val(qtdeEstoque);
	}
}


// .funcção para validar se o campo permite multiplos - Leônidas Monteiro 
function aceitouCookie(){
	$.ajax({
		url: pach + "/assets/js/cokies.php",
			type: "GET",
			dataType: "html",
			success: function (data) {
					$("#posiciona").hide();
			}

		});
}
$( "#gravarCarrinho" ).click(function() {
	var qtde = $("#qtde").val();
	var codProduto = $("#codProduto").val();
	var codPro = $("#codProduto").val();
	var clienteID = $("#clienteID").val();
	var valorReal = $("#valorReal").val();
  	var codSubCategoria = $("#cod_subcategoria").val();
	console.log(codProduto);
	//alert('codigo do cliente: '+clienteID+'\nCódigo do produto: '+codPro+'\nQuantidade: '+qtde+'\nValor: '+valorReal);
	$.ajax({
		url: http + "/model/carrinho/carrinho.php/?carrinhoModal="+codPro+"&qtde="+qtde+"&clienteID"+clienteID+"&valorReal="+valorReal,
		type:'GET',
		dataType:"html",
		success: function(data){
			var resultado = data;
			qtde = parseInt(data.split('/')[0]);
			$("#qtdeheader").html(qtde);
			atualizarprodutosheader();
			window.location.href = http + "?pg=categoria&subCategoria="+codSubCategoria;
		}
	});
});
/* atualizar os produtos do header - Leônidas Monteiro - 28/01/2020 */
function atualizarprodutosheader(){
	$.ajax({
		url: http + "controller/carrinho/listar_produtos_header.php",
		type:'GET',
		dataType:"html",
		success: function(data){
			$("#listarProdutosHeader").html(data);

		}
	});
}
/* FIM - atualizar os produtos do header - Leônidas Monteiro - 28/01/2020 */
/*========= verificar o cookie - LEÔNIDAS MONTERO - 28/08/2020 */

function insertFavorito(str) /* 23/02/2019 por Leônidas Monteiro */
{
		$.ajax({
			url: http + "/model/favoritos/favoritos.php?favoritos="+str,
			type: "GET",
			dataType: "html",
			success: function (data) {
				alert('Produto salvo com sucesso!');
				//$('#favoritos').html(data);
			}
		});
}
/* dados-produtos */
$( "input[name='botao+']" ).click(function() {
	var qtdeEstoque = $("#qtdeEstoque").val();
	var qtde = document.getElementById('qtde').value;
	var coef = document.getElementById('qtde').className;
	var resultado = parseInt(qtde) + parseInt(coef);
	var qtdeEstoque = $("#qtdeEstoque").val();
	if(resultado <= qtdeEstoque){
		$('#qtde').val(resultado);
	}
	
});
$( "input[name='botao-']" ).click(function() {
	
	var qtde = document.getElementById('qtde').value;
	var coef = document.getElementById('qtde').className;
	if (parseFloat(qtde) > parseInt(coef)){
		var resultado = parseInt(qtde) - parseInt(coef);
		$('#qtde').val(resultado);
	}
});
	
/* FIM - dados-produtos */
$( "button[name*='btn+']" ).click(function() {
	var produto =$(this).attr('rel');
	produto = produto.split("-");
	var produtoMinimo = produto[0];
	var codProduto = produto[1];
	produto = produtoMinimo;
	var qtdes = $(this).val();
	var qtde = document.getElementById(qtdes).value;
	var coef = document.getElementById(qtdes).id;
	var coef = coef.replace(/[^0-9]/g,''); // ok
	var clas = document.getElementById(qtdes).className;
	var vlrUnit = "valorunit" + coef + " ";
	var vlrttal = " valortotal" + coef;
	var vlrttal = clas.replace(vlrUnit,'');
	var vlrUnit = clas.replace(vlrttal,'');
	var vlrUnitario = $("#"+vlrUnit).val();
	vlrUnitario = vlrUnitario.replace('R$ ','');
	vlrUnitario = vlrUnitario.replace('R$','');
	vlrUnitario = vlrUnitario.replace('.','');
	vlrUnitario = vlrUnitario.replace(',','.');
	
	vlrttal = vlrttal.replace('R$ ','');
	vlrttal = vlrttal.replace('R$','');
	vlrttal = vlrttal.replace('.','');
	vlrttal = vlrttal.replace(',','.');
	//alert (vlrttal);

	var vlrttalcarrinho = $("#vlrttalcarrinho").text();
	vlrttalcarrinho = vlrttalcarrinho.replace('R$ ','');
	vlrttalcarrinho = vlrttalcarrinho.replace('R$','');
	vlrttalcarrinho = vlrttalcarrinho.replace('.','');
	vlrttalcarrinho = vlrttalcarrinho.replace(',','.');
	//alert (vlrttalcarrinho);
	
	var sttotalcarrinho = $("#st_total").text();
	sttotalcarrinho = sttotalcarrinho.replace('R$ ','');
	sttotalcarrinho = sttotalcarrinho.replace('R$','');
	sttotalcarrinho = sttotalcarrinho.replace('.','');
	sttotalcarrinho = sttotalcarrinho.replace(',','.');
	//alert (vlrttalcarrinho);
	
	var qtdeAtual = $("#format"+coef).val();
	qtdeAtual = parseFloat(vlrUnitario) * parseFloat(qtdeAtual);
	
	var itemAtual = $("#itemCarrinho").text();
	//alert (itemAtual);
	var multiplos = parseFloat(produto) * parseInt(qtde);
	//alert ("cod do produto: "+codProduto+" valor minimo: "+produto);
	if (qtde == multiplos){
		qtde = parseInt(qtde) + 1;
		itemAtual = parseInt(itemAtual) + 1;
		var valorAtual = parseFloat(vlrttalcarrinho) + parseFloat(vlrUnitario);
		var STTotal = sttotalcarrinho * parseInt(qtde);
	}else{
		qtde = parseInt(qtde) + parseFloat(produto);
		itemAtual = parseInt(itemAtual) + parseFloat(produto);
		var valorAtual = parseFloat(vlrttalcarrinho) +( parseFloat(vlrUnitario) * parseFloat(produto));
		var STTotal = sttotalcarrinho * parseInt(qtde);
	}
	console.log('STTotal: '+STTotal);
	$("#itemCarrinho").html(itemAtual);
	vlrUnitario = parseFloat(vlrUnitario) * parseInt(qtde);
	//$("input[name='"+vlrttal+"']").val(vlrUnitario);
	$("#vlrttalcarrinho").html(valorAtual.toLocaleString('pt-BR', { style: 'currency', currency:'BRL'}));
	$("#st_total").html(STTotal.toLocaleString('pt-BR', { style: 'currency', currency:'BRL'}));
	$("#subtotal").html(valorAtual.toLocaleString('pt-BR', { style: 'currency', currency:'BRL'}));
	$("input[name='"+vlrttal+"']").val(vlrUnitario.toLocaleString('pt-BR', { style: 'currency', currency:'BRL'}));
  	//alert (vlrUnit);
	$("input[name='"+qtdes+"']").val(qtde);
	$.ajax({
			
			url: pach + "/model/carrinho/carrinho.php?codCarrinho="+codProduto+"&qtde="+qtde+"&valor="+vlrUnitario+"&STTotal="+STTotal,
			type: "GET",
			dataType: "html",
			success: function (data) {
				
			/*	if(valorAtual >= 400){
				$('#maiorpedminimo').show();
				$('#menorpedminimo').hide();
				}else{
				$('#maiorpedminimo').hide();
				$('#menorpedminimo').show();	
				}*/
				
					$.ajax({
					type : 'GET',
					url  : http+'/controller/carrinho/tabela-pct.php',
					//data : data,
					dataType: 'html',
					success :  function(data){	
					msg('sucesso', "Produto atualizado!");
						//if(data.error === 0) {
							$('#atualizaParcelas').html(data);
							
								$.ajax({
								type : 'GET',
								url  : http+'/controller/carrinho/finalizar.php',
								//data : data,
								dataType: 'html',
								success :  function(data){	
								msg('sucesso', "Produto atualizado!");
								//if(data.error === 0) {
									$('#finalizar').html(data);
											
								}
								});
								
						}
					});
			}
		});
})
$( "button[name*='btn-']" ).click(function() {
	var produto =$(this).attr('rel');
	produto = produto.split("-");
	var produtoMinimo = produto[0];
	var codProduto = produto[1];
	//alert (codProduto);
	produto = produtoMinimo;
	var qtdes = $(this).val();
	var qtde = document.getElementById(qtdes).value;
	var coef = document.getElementById(qtdes).id;
	var coef = coef.replace(/[^0-9]/g,''); // ok
	var clas = document.getElementById(qtdes).className;
	var vlrUnit = "valorunit" + coef + " ";
	var vlrttal = " valortotal" + coef;
	var vlrttal = clas.replace(vlrUnit,'');
	var vlrUnit = clas.replace(vlrttal,'');
	var vlrUnitario = $("#"+vlrUnit).val();
	vlrUnitario = vlrUnitario.replace('R$ ','');
	vlrUnitario = vlrUnitario.replace('R$','');
	vlrUnitario = vlrUnitario.replace('.','');
	vlrUnitario = vlrUnitario.replace(',','.');
	
	vlrttal = vlrttal.replace('R$ ','');
	vlrttal = vlrttal.replace('R$','');
	vlrttal = vlrttal.replace('.','');
	vlrttal = vlrttal.replace(',','.');
	//alert (vlrttal);

	var vlrttalcarrinho = $("#vlrttalcarrinho").text();
	vlrttalcarrinho = vlrttalcarrinho.replace('R$ ','');
	vlrttalcarrinho = vlrttalcarrinho.replace('R$','');
	vlrttalcarrinho = vlrttalcarrinho.replace('.','');
	vlrttalcarrinho = vlrttalcarrinho.replace(',','.');
	//alert (vlrttalcarrinho);
	
	var qtdeAtual = $("#format"+coef).val();
	qtdeAtual = parseFloat(vlrUnitario) * parseFloat(qtdeAtual);
	var valorAtual = parseFloat(vlrttalcarrinho) - parseFloat(vlrUnitario);
	var itemAtual = $("#itemCarrinho").text();
	
	var multiplos = parseFloat(produto) * parseInt(qtde);
	//alert ("cod do produto: "+codProduto+" valor minimo: "+produto);
	
	if (qtde == multiplos){
		qtde = parseInt(qtde) - 1;
		itemAtual = parseInt(itemAtual) - 1;
		var valorAtual = parseFloat(vlrttalcarrinho) - parseFloat(vlrUnitario);
	}else{
		qtde = parseInt(qtde) - parseFloat(produto);
		itemAtual = parseInt(itemAtual) - parseFloat(produto);
		var valorAtual = parseFloat(vlrttalcarrinho) -( parseFloat(vlrUnitario) * parseFloat(produto));
	}
	if (qtde >= produto){
	$("#itemCarrinho").html(itemAtual);
	vlrUnitario = parseFloat(vlrUnitario) * parseInt(qtde);
	//$("input[name='"+vlrttal+"']").val(vlrUnitario);
	$("#vlrttalcarrinho").html(valorAtual.toLocaleString('pt-BR', { style: 'currency', currency:'BRL'}));
	$("#subtotal").html(valorAtual.toLocaleString('pt-BR', { style: 'currency', currency:'BRL'}));
	$("input[name='"+vlrttal+"']").val(vlrUnitario.toLocaleString('pt-BR', { style: 'currency', currency:'BRL'}));
  	//alert (vlrUnit);
	$("input[name='"+qtdes+"']").val(qtde);
	$.ajax({
			url: http + "model/carrinho/carrinho.php?codCarrinho="+codProduto+"&qtde="+qtde+"&valor="+vlrUnitario,
			type: "GET",
			dataType: "html",
			success: function (data) {
				/*if(valorAtual >= 400){
				$('#maiorpedminimo').show();
				$('#menorpedminimo').hide();
				}else{
				$('#maiorpedminimo').hide();
				$('#menorpedminimo').show();	
				}*/
					$.ajax({
					type : 'GET',
					url  : http+'/controller/carrinho/tabela-pct.php',
					//data : data,
					dataType: 'html',
					success :  function(data){	
					msg('sucesso', "Produto atualizado!");
						//if(data.error === 0) {
							$('#atualizaParcelas').html(data);
							
								$.ajax({
								type : 'GET',
								url  : http+'/controller/carrinho/finalizar.php',
								//data : data,
								dataType: 'html',
								success :  function(data){	
								msg('sucesso', "Produto atualizado!");
								//if(data.error === 0) {
									$('#finalizar').html(data);
											
								}
								});
						
						}
					});		
							
				//alert('Produto salvo com sucesso!');
				//$('#favoritos').html(data);
			}
		});
	}
})

var msg = function(alerta, texto) {
	var resposta = '';
	$(".resposta").empty();
				
	switch (alerta) {
	case 'sucesso':
		resposta = "<div class='alert msg btn-success text-center' role='alert'>" +
		"   <a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" + texto + "</div>";
	break;
	case 'atencao':
		resposta = "<center><img src='"+http+"/Painel/imagens/gif/barra1-loading.gif' width='75' height='59' /></center> "+
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
		//alert(data);
		$.ajax({
			type : 'POST',
			url  : http + '/model/newsletter/newsletter.php?gravar='+grv,
			data : data,
			dataType: 'json',
			beforeSend: function()
			{	
			msg('atencao', "Por favor aguarde, estamos validando o cadastro!");
				$("#botao-form-newsletter-gravar").html('Cadastrando ...');
			},
			success :  function(response){						
				if(response.codigo == 1){	
					$("#botao-form-newsletter-gravar").html('Cadastrar');
					document.getElementById('nome').value="";
					document.getElementById('email').value="";
					document.getElementById('cep').value="";
					alert("Gratidão por se cadastrar!");
					msg('sucesso', response.mensagem);
					
					setTimeout( function() {						
					$(".resposta").empty();
					}, 10000 );
				}
				else{			
					$("#botao-form-newsletter-gravar").html('Cadastrar');
					msg('erro', response.mensagem);
					
				}
		    }
		});
	});
	
// ************************************* ALTERAR SESSION COND_PGTO_PADRAO PDV(CARRINHO) ********************************************************
function cond_pgto(cod_cond_pgto){
	var msg = function(alerta, texto) {
	var resposta = '';
	$(".resposta").empty();
				
	switch (alerta) {
	case 'sucesso':
		resposta = "<div class='alert msg btn-success text-center' role='alert'>" +
		"   <a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" + texto + "</div>";
	break;
	case 'atencao':
		resposta = "<center><img src='"+http+"/Painel/imagens/gif/barra1-loading.gif' width='75' height='59' /></center> "+
		"<div class='alert msg btn-warning text-center' role='alert'>" +
		"   <a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" + texto + "</div>";

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
		var cod_cond_pgto = cod_cond_pgto;
		//alert(cod_cond_pgto);
		//alert(cod_cond_pgto);
		//var cod_cond_pgto = document.getElementById("session_cond_pgto").value;
		var pgto = 1;
		
		$.ajax({
			type : 'GET',
			url  : http + "/model/carrinho/carrinho.php?atualizarCondPgto="+pgto+"&cod_cond_pgto="+cod_cond_pgto,
			dataType: 'json',
			beforeSend: function() {
				msg('atencao', "Por favor aguarde, estamos validando os dados!");
			},		
			success :  function(response){	
				if(response.codigo == 1){
						msg('sucesso', "Condição de pagamento atualizada!");
						
			 	//atualiza lista de produtos no carrinho
				$.ajax({
				type : 'GET',
				url  : http+'/controller/carrinho/tabela-pct.php',
				//data : data,
				dataType: 'html',
				success :  function(data){	
				msg('sucesso', "Produto atualizado!");
					//if(data.error === 0) {
						$('#atualizaParcelas').html(data);
						// atualiza totais do pedido
							$.ajax({
							type : 'GET',
							url  : http+'/controller/carrinho/finalizar.php',
							//data : data,
							dataType: 'html',
							success :  function(data){	
							msg('sucesso', "Produto atualizado!");
							//if(data.error === 0) {
								$('#finalizar').html(data);
										
							}
						});
					}
				});
					
				}else{
					msg('erro',response.mensagem);
				}

		    },
			error: function(){
   			msg('erro', "Não foi possivel completar a requisição!");
			}
		});
}

// ************************************* ALTERAR SESSION COND_PGTO_PADRAO PDV(CARRINHO) ********************************************************
function forma_pgto(cod_forma_pgto){
	var msg = function(alerta, texto) {
	var resposta = '';
	$(".resposta").empty();
				
	switch (alerta) {
	case 'sucesso':
		resposta = "<div class='alert msg btn-success text-center' role='alert'>" +
		"   <a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" + texto + "</div>";
	break;
	case 'atencao':
		resposta = "<center><img src='"+http+"/Painel/imagens/gif/barra1-loading.gif' width='75' height='59' /></center> "+
		"<div class='alert msg btn-warning text-center' role='alert'>" +
		"   <a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" + texto + "</div>";

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
		var cod_forma_pgto = cod_forma_pgto;
		//alert(cod_cond_pgto);
		//alert(cod_cond_pgto);
		//var cod_cond_pgto = document.getElementById("session_cond_pgto").value;
		var pgto = 1;
		
		$.ajax({
			type : 'GET',
			url  : http + "/model/carrinho/carrinho.php?atualizarFormaPgto="+pgto+"&cod_forma_pgto="+cod_forma_pgto,
			dataType: 'json',
			beforeSend: function() {
				msg('atencao', "Por favor aguarde, estamos validando os dados!");
			},		
			success :  function(response){	
				if(response.codigo == 1){
						msg('sucesso', "Forma de pagamento atualizada!");
						
			 	//atualiza lista de produtos no carrinho
				$.ajax({
				type : 'GET',
				url  : http+'/controller/carrinho/tabela-pct.php',
				//data : data,
				dataType: 'html',
				success :  function(data){	
				msg('sucesso', "Forma de Pagamento Atualizada!");
					//if(data.error === 0) {
						$('#atualizaParcelas').html(data);
						// atualiza totais do pedido
							$.ajax({
							type : 'GET',
							url  : http+'/controller/carrinho/finalizar.php',
							//data : data,
							dataType: 'html',
							success :  function(data){	
							msg('sucesso', "Produto atualizado!");
							//if(data.error === 0) {
								$('#finalizar').html(data);
										
							}
						});
					}
				});
					
				}else{
					msg('erro',response.mensagem);
				}

		    },
			error: function(){
   			msg('erro', "Não foi possivel completar a requisição!");
			}
		});
}