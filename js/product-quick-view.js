http = $("#http").val();
pasta = '/';
http = http + pasta;
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


$( "#btn0" ).click(function() {

  var qtdemin = $("#qtdemin").val();
  var qtde = $("#qtde").val();
  var valor = parseFloat(qtde) - parseFloat(qtdemin);
  if(valor > 0 ){
  //$("#qtde").val(valor);
}
  //alert ('quantidade: '+$qtde);//+$qtdeReal);
});
$( "#btn1" ).click(function() {
  var qtdemin = $("#qtdemin").val();
  var qtde = $("#qtde").val();
  var valor = parseFloat(qtde) + parseFloat(qtdemin);
  //$("#qtde").val(valor);
});


