var http = $('#http').val();

$(".btnCart").click(function(){
	
	var botao = $(this).attr("data-botao");
	var valorUnitario = $(this).attr("data-valor");
	var qtdeMinimo = $(this).attr("data-qtdeMinimo");
	var estoque = $(this).attr("data-estoque");
	
	var idPedidoItem = $(this).attr("data-id");
	var qtde = $('.qtde'+idPedidoItem).val();
	var itensHeader = $("#qtdeheader").text();
	var valorSumario = $("#valorSumario").val();
	if(botao == '-'){
		qtde = parseInt(qtde) - parseInt(qtdeMinimo);
		itensHeader = parseFloat(itensHeader) - parseFloat(qtdeMinimo);
		var valorTotal = parseFloat(qtdeMinimo) * parseFloat(valorUnitario);
		var valorSumario = parseFloat(valorSumario) - parseFloat(valorTotal);
	}else{
		qtde = parseInt(qtde) + parseInt(qtdeMinimo);
		itensHeader = parseFloat(itensHeader) + parseFloat(qtdeMinimo);
		var valorTotal = parseFloat(qtdeMinimo) * parseFloat(valorUnitario);
		var valorSumario = parseFloat(valorSumario) + parseFloat(valorTotal);
	}
	if(qtde <= estoque){
		if (qtde > 0){
		$(".qtde"+idPedidoItem).val(qtde);
		var valorTotal = parseFloat(qtde) * parseFloat(valorUnitario);
		
		/* Exibe os resultados em tela */
			$("#valorTotal"+idPedidoItem).html(valorTotal.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
			$("#qtdeheader").html(itensHeader);
			$("#valorSumario").val(valorSumario);
			$(".valorSumario").html(valorSumario.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
		/* .Exibe os resultados em tela */
		/* atualizar a quantidade na tabela produtos-itens */
			$.ajax({
				url: http+'/model/carrinho/carrinho.php/?atualizaQtde='+idPedidoItem+'&qtde='+qtde+'&valor='+valorTotal,
				type:'GET',
				dataType:"html",
				success: function(data){
					atualizarprodutosheader();
				}
			});		
		/* .atualizar a quantidade na tabela produtos-itens */
	} 
	}
	
});

function atualizarprodutosheader(){
	$.ajax({
		url: http+"/controller/carrinho/listar_produtos_header.php",
		type:'GET',
		dataType:"html",
		success: function(data){
			$("#listarProdutosHeader").html(data);

		}
	});
};
 
function checkRadio(str){
	if ($("#radioDesconto").prop("checked")) {
		var desconto = (parseFloat($("#valorSumario").val()) * 0.03);
		var valor = parseFloat($("#valorSumario").val()) - (parseFloat($("#valorSumario").val()) * 0.03);
		$(".desconto").html(desconto.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
		$(".valorTotal").html(valor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
		$('#prazos').hide();
		$("#chamaPrimeiro").prop("checked", true);
	}else{
		/*var desconto = 0;*/
		
		var valor = parseFloat($("#valorSumario").val());
		/*valor = valor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
		$(".desconto").html(desconto.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
		$(".valorTotal").html(valor);*/
		$('#prazos').show();
		var valorMinimo = '300';
		var coeficiente = parseFloat(valor) / parseFloat(valorMinimo);
		$("#diasPagamento").val(str);
		if(str <= 2){
			alert('com desconto');
			var desconto = (parseFloat($("#valorSumario").val()) * 0.03);
			var valor = parseFloat($("#valorSumario").val()) - (parseFloat($("#valorSumario").val()) * 0.03);
			$(".desconto").html(desconto.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
			$(".valorTotal").html(valor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));	
		}else{
			alert('sem desconto!');
			var desconto = 0
			var valor = parseFloat($("#valorSumario").val());
			valor = valor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"});
			$(".desconto").html(desconto.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
			$(".valorTotal").html(valor);	
		}
	}
	
};
function confirmarPedido(){
	var formPgto = '';
	var condPgto = '';
	var observ = $("#observacaoPedido").val();
	/* Verificar se o pagamento é boleto ou Cheque */
	if($("#radioPagamento").prop("checked")){
		formPgto = 'Cheque';	
	}else{
		formPgto = 'Boleto';	
	}
	/* .Verificar se o pagamento é boleto ou Cheque 	
	if ($("#radioDesconto").prop("checked")) {
		condPgto = "A Vista";
		var itens = $("#qtdeheader").text();
		var valorDaCompra = $("#valorSumario").val();
		var desconto = (parseFloat($("#valorSumario").val()) * 0.03);
		var valorAPagar = parseFloat($("#valorSumario").val()) - (parseFloat($("#valorSumario").val()) * 0.03);
		
	}else{
		condPgto = "Parcelado";
		var itens = $("#qtdeheader").text();
		var valorDaCompra = $("#valorSumario").val();
		var desconto = 0;
		var valorAPagar = $("#valorSumario").val();
	}*/
	str = $("#diasPagamento").val();
	var condicao = '';
		if(str == 1){
			condicao = '7 dias';	
		}
		if(str == 2){
			condicao = '7/14 dias';	
		}
		if(str == 3){
			condicao = '28 dias';	
		}
		if(str == 4){
			condicao = '21/28 dias';	
		}
		if(str == 5){
			condicao = '21/28/35 dias';	
		}
		if(str == 6){
			condicao = '21/28/35/42 dias';	
		}
		if(str == 7){
			condicao = '21/28/35/42/49 dias';	
		}
		if(str == 8){
			condicao = '21/28/35/42/49/56 dias';	
		}
	if ($("#radioDesconto").prop("checked")) {
		condPgto = "A Vista";
		var itens = $("#qtdeheader").text();
		var valorDaCompra = $("#valorSumario").val();
		var desconto = (parseFloat($("#valorSumario").val()) * 0.03);
		var valorAPagar = parseFloat($("#valorSumario").val()) - (parseFloat($("#valorSumario").val()) * 0.03);
	}else{
		condPgto = "Parcelado";
		if(str <= 2){	
			var itens = $("#qtdeheader").text();
			var valorDaCompra = $("#valorSumario").val();
			var desconto = (parseFloat($("#valorSumario").val()) * 0.03);
			var valorAPagar = parseFloat($("#valorSumario").val()) - (parseFloat($("#valorSumario").val()) * 0.03);
		}else{
			var itens = $("#qtdeheader").text();
			var valorDaCompra = $("#valorSumario").val();
			var desconto = 0;
			var valorAPagar = parseFloat($("#valorSumario").val());
		}
	}
	$.ajax({
		url: http+"/model/carrinho/carrinho.php/?confirmarPedido=1&valorDaCompra="+valorDaCompra+"&desconto="+desconto+"&valorAPagar="+valorAPagar+"&itens="+itens+"&formPgto="+formPgto+"&condPgto="+condPgto+"&observ="+observ+"&condicao="+condicao,
		type:'GET',
		dataType:"html",
		success: function(data){
			window.location.href = '?pg=home';

		}
	});
}