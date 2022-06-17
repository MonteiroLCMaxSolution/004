http = $("#http").val();
pasta = '/';
http = http + pasta;
/* deletar produto do dropdawmenu - Leônidas Monteiro - 28/01/2020 */
function del_product(str){
	$.ajax({
		url: http + "model/carrinho/carrinho.php/?del_product="+str,
		type:'GET',
		dataType:"html",
		success: function(data){
			var resultado = data;
			qtde = parseInt(data.split('/')[0]);
			if(qtde == ""){
				qtde = 0;
			}
			
			$("#qtdeheader").html(qtde);
			atualizarprodutosheader();
			window.location.href = http + "?pg=carrinho";
		}
	});
}
/* fim deletar produto do dropdawmenu - Leônidas Monteiro - 28/01/2020 */

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

$( "#btn0" ).click(function() {
  var qtdemin = $("#qtdemin").val();
  var qtde = $("#qtde").val();
  var valor = parseFloat(qtde) - parseFloat(qtdemin);
  if(valor > 0 ){
  $("#qtde").val(valor);
};
  //alert ('quantidade: '+$qtde);//+$qtdeReal);
});
$( "#btn1" ).click(function() {
  var qtdemin = $("#qtdemin").val();
  var qtde = $("#qtde").val();
  var valor = parseFloat(qtde) + parseFloat(qtdemin);
 // $("#qtde").val(valor);
});


