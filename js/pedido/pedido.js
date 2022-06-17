var http = $("#http").val();
/* Atualizar o status do pedido - Leônidas Monteiro - 25/03/2020 */
$("#alterarStatusPedido").click(function(){
	var idPedido = $("#idDoPedido").val();
	var statusPe = $("#statusPedido").val();
	var motivoCancelar = $("#motivoCancelar").val();
	liberar = '';
	if(statusPe == "CANCELADO"){
		if(motivoCancelar == ''){
			liberar = '1';
		}
	}
	if(liberar == ''){
		$.ajax({
			url: http+'/model/dashboard/dashboard-model.php/?alterarStatusPedido='+idPedido+'&statusPe='+statusPe+'&motivoCancelar='+motivoCancelar,
			type:'GET',
			dataType:"html",
			success: function(data){
			//alert(data);
			alert('Status alterado com sucesso!');
			window.location.href = http+'/view';
		}
	});
	}else{
		alert('Foi selecionado a opção "CANCELAR" e não foi informado o motivo do cancelamento!');
	}
	
})
/* FIM - Atualizar o status do pedido - Leônidas Monteiro - 25/03/2020 */