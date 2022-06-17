var http = $("#http").val();
var pasta = '/3E_Comercial';
var pach = http + pasta;
$("#buscarProdutos").click(function(){
 // Leônidas - 14/01/2020 - buscar produtos do campo consulta tela inicial
 var $campoBuscar = $("#campoBuscar").val();
	$.ajax({
			url: http + "/controller/buscar/resultado_busca.php?buscar="+$campoBuscar,
			type: "GET",
			dataType: "html",
			success: function (data) {
				$('#tela_principal').html(data);
			}
		});

});