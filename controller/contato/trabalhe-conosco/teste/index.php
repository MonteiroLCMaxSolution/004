<html>
    <body>
    <div id="origem" align="center">
     Nome Empresa <input type="text" id="fone" name="fone[]"  maxlength="14" size="14" /> 
        
		<a style="cursor: pointer;" onclick="duplicarCampos();"> Adicionar Empresa </a> 
		<a style="cursor: pointer;" onclick="removerCampos(this);">Remover Empresa </a>  
	</div>
	
	<div id="destino">
    </div>
    
    <script type="text/javascript">
    function duplicarCampos(){
	var clone = document.getElementById('origem').cloneNode(true);
	var destino = document.getElementById('destino');
	destino.appendChild (clone);
	
	var camposClonados = clone.getElementsByTagName('input');
	
	for(i=0; i<camposClonados.length;i++){
		camposClonados[i].value = '';
	}
	
	
	
}

function removerCampos(id){
	var node1 = document.getElementById('destino');
	node1.removeChild(node1.childNodes[0]);
}
</script>
</body>
</html>