function validaCNPJ(str)
{
	
		$.ajax({
			url: "../../../controller/support/CNPJCPF.php?CNPJ="+str+"&sidjs="+Math.random(),
			type: "GET",
			dataType: "html",
			success: function (data) {
				$('#validouCNPJ').html(data);
			}
		});
	
}