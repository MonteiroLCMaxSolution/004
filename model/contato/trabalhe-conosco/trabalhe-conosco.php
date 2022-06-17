<?php

session_start();
include_once ('../../../conexao-pdo/conexao-mysql-pdo.php');
include_once ('../../../conexao-pdo/config.php');

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s');

/*ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);  */

/* Gravar Curriculo na tabela trabalhe-conosco  */
if (!empty($_GET['grv'])){
  
	$nomeUsuario = anti_injection($_POST['nome']);
	$nomeUsuario = filter_var($nomeUsuario, FILTER_SANITIZE_STRING);	
	
	$data_nasc = anti_injection($_POST['data_nasc']);
	$data_nasc = filter_var($data_nasc, FILTER_SANITIZE_STRING);	
	
	$nascionalidade = anti_injection($_POST['nascionalidade']);
	$nascionalidade = filter_var($nascionalidade, FILTER_SANITIZE_STRING);	
	
	$est_civil = anti_injection($_POST['est_civil']);
	$est_civil = filter_var($est_civil, FILTER_SANITIZE_STRING);	
	
	$dependentes = anti_injection($_POST['dependentes']);
	$dependentes = filter_var($dependentes, FILTER_SANITIZE_STRING);	
	
	$num_depend = anti_injection($_POST['num_depend']);
	$num_depend = filter_var($num_depend, FILTER_SANITIZE_STRING);	
	/* Tratar CNH ABCDE */
	$A = anti_injection($_POST['A']);
	$A = filter_var($A, FILTER_SANITIZE_STRING);
	$B = anti_injection($_POST['B']);
	$B = filter_var($B, FILTER_SANITIZE_STRING);
	$C = anti_injection($_POST['C']);
	$C = filter_var($C, FILTER_SANITIZE_STRING);
	$D = anti_injection($_POST['D']);
	$D = filter_var($D, FILTER_SANITIZE_STRING);
	$E = anti_injection($_POST['E']);
	$E = filter_var($E, FILTER_SANITIZE_STRING);
	$N = anti_injection($_POST['N']);
	$N = filter_var($N, FILTER_SANITIZE_STRING);
	
	$cnh = $A.'/'.$B.'/'.$C.'/'.$D.'/'.$E;
	if(empty($cnh)){
		$N = 'Não Possuo';
		$cnh = $N;
	}else{
		$cnh = $cnh;
	}
	
	//$cnh = replace($cnh,"/","");
	
	/* --------------------- */
	$fone = anti_injection($_POST['fone']);
	$fone = filter_var($fone, FILTER_SANITIZE_STRING);	
	
	$fone_cel = anti_injection($_POST['fone_cel']);
	$fone_cel = filter_var($fone_cel, FILTER_SANITIZE_STRING);	
	
	$email = anti_injection($_POST['email']);
	$email = filter_var($email, FILTER_SANITIZE_STRING);	
	
	$cep = anti_injection($_POST['CEP']);
	$cep = filter_var($cep, FILTER_SANITIZE_STRING);	
	
	$endereco = anti_injection($_POST['endereco']);
	$endereco = filter_var($endereco, FILTER_SANITIZE_STRING);
	
	$numero = anti_injection($_POST['numero']);
	$numero = filter_var($numero, FILTER_SANITIZE_STRING);	
	
	$bairro = anti_injection($_POST['bairro']);
	$bairro = filter_var($bairro, FILTER_SANITIZE_STRING);	
	
	$cidade = anti_injection($_POST['cidade']);
	$cidade = filter_var($cidade, FILTER_SANITIZE_STRING);	
	
	$uf = anti_injection($_POST['uf']);
	$uf = filter_var($uf, FILTER_SANITIZE_STRING);	
	
	$objetivo = anti_injection($_POST['objetivo']);
	$objetivo = filter_var($objetivo, FILTER_SANITIZE_STRING);	
	
	$adm = anti_injection($_POST['adm']);
	$adm = filter_var($adm, FILTER_SANITIZE_STRING);	
	
	$expedi_logi = anti_injection($_POST['expedi_logi']);
	$expedi_logi = filter_var($expedi_logi, FILTER_SANITIZE_STRING);	
	
	//$logistica = anti_injection($_POST['logistica']);
	//$logistica = filter_var($logistica, FILTER_SANITIZE_STRING);	
	
	$motorista = anti_injection($_POST['motorista']);
	$motorista = filter_var($motorista, FILTER_SANITIZE_STRING);	
	
	$telemarketing = anti_injection($_POST['telemarketing']);
	$telemarketing = filter_var($telemarketing, FILTER_SANITIZE_STRING);	
	
	$ti = anti_injection($_POST['ti']);
	$ti = filter_var($ti, FILTER_SANITIZE_STRING);	

	$desc_area = anti_injection($_POST['desc_area']);
	$desc_area = filter_var($desc_area, FILTER_SANITIZE_STRING);
	
	$representante = anti_injection($_POST['representante']);
	$representante = filter_var($representante, FILTER_SANITIZE_STRING);	
	
	$escolaridade = anti_injection($_POST['grau_esc']);
	$escolaridade = filter_var($escolaridade, FILTER_SANITIZE_STRING);
	
	$inic_esc = anti_injection($_POST['inic_esc']);
	$inic_esc = filter_var($inic_esc, FILTER_SANITIZE_STRING);

	$fim_esc = anti_injection($_POST['fim_esc']);
	$fim_esc = filter_var($fim_esc, FILTER_SANITIZE_STRING);

	$nome_curso = anti_injection($_POST['nome_curso']);
	$nome_curso = filter_var($nome_curso, FILTER_SANITIZE_STRING);

	$nome_escola = anti_injection($_POST['nome_escola']);
	$nome_escola = filter_var($nome_escola, FILTER_SANITIZE_STRING);

	$idioma = anti_injection($_POST['idioma']);
	$idioma = filter_var($idioma, FILTER_SANITIZE_STRING);

	$nivel = anti_injection($_POST['nivel']);
	$nivel = filter_var($nivel, FILTER_SANITIZE_STRING);

	
	
		
	
	$nomeEmpresaContador = 0;
	foreach($_POST['nome_emp'] as $nomeEmpresa){
		$nomeEmpresaContador++;
		if ($nomeEmpresaContador == 1){
			$nome_emp_1 = anti_injection($nomeEmpresa);
			$nome_emp_1 = filter_var($nome_emp_1, FILTER_SANITIZE_STRING);	
		}else if ($nomeEmpresaContador == 2){
			$nome_emp_2 = anti_injection($nomeEmpresa);
			$nome_emp_2 = filter_var($nome_emp_2, FILTER_SANITIZE_STRING);
		}else if ($nomeEmpresaContador == 3){
			$nome_emp_3 = anti_injection($nomeEmpresa);
			$nome_emp_3 = filter_var($nome_emp_3, FILTER_SANITIZE_STRING);
		}
	}
	$CidEmpresaContador = 0;
	foreach($_POST['cid_emp'] as $cidEmpresa){
		$CidEmpresaContador++;
		if ($CidEmpresaContador == 1){
			$cid_emp_1 = anti_injection($cidEmpresa);
			$cid_emp_1 = filter_var($cid_emp_1, FILTER_SANITIZE_STRING);	
		}else if ($CidEmpresaContador == 2){
			$cid_emp_2 = anti_injection($cidEmpresa);
			$cid_emp_2 = filter_var($cid_emp_2, FILTER_SANITIZE_STRING);
		}else if ($CidEmpresaContador == 3){
			$cid_emp_3 = anti_injection($cidEmpresa);
			$cid_emp_3 = filter_var($cid_emp_3, FILTER_SANITIZE_STRING);
		}
		
	}
	
	$InicioEmpresaContador = 0;
	foreach($_POST['inicio_emp'] as $InicioEmpresa){
		$InicioEmpresaContador++;
		if ($InicioEmpresaContador == 1){
			$inicio_emp_1 = anti_injection($InicioEmpresa);
			$inicio_emp_1 = filter_var($inicio_emp_1, FILTER_SANITIZE_STRING);	
		}else if ($InicioEmpresaContador == 2){
			$inicio_emp_2 = anti_injection($InicioEmpresa);
			$inicio_emp_2 = filter_var($inicio_emp_2, FILTER_SANITIZE_STRING);
		}else if ($InicioEmpresaContador == 3){
			$inicio_emp_3 = anti_injection($InicioEmpresa);
			$inicio_emp_3 = filter_var($inicio_emp_3, FILTER_SANITIZE_STRING);
		}
		
	}

	$FimEmpresaContador = 0;
	foreach($_POST['fim_emp'] as $FimEmpresa){
		$FimEmpresaContador++;
		if ($FimEmpresaContador == 1){
			$fim_emp_1 = anti_injection($FimEmpresa);
			$fim_emp_1 = filter_var($fim_emp_1, FILTER_SANITIZE_STRING);	
		}else if ($FimEmpresaContador == 2){
			$fim_emp_2 = anti_injection($FimEmpresa);
			$fim_emp_2 = filter_var($fim_emp_2, FILTER_SANITIZE_STRING);
		}else if ($FimEmpresaContador == 3){
			$fim_emp_3 = anti_injection($fim_emp_3);
			$fim_emp_3 = filter_var($fim_emp_3, FILTER_SANITIZE_STRING);
		}
		
	}
	
	$CargoEmpresaContador = 0;
	foreach($_POST['cargo_emp'] as $CargoEmpresa){
		$CargoEmpresaContador++;
		if ($CargoEmpresaContador == 1){
			$cargo_emp_1 = anti_injection($CargoEmpresa);
			$cargo_emp_1 = filter_var($cargo_emp_1, FILTER_SANITIZE_STRING);	
		}else if ($CargoEmpresaContador == 2){
			$cargo_emp_2 = anti_injection($CargoEmpresa);
			$cargo_emp_2 = filter_var($cargo_emp_2, FILTER_SANITIZE_STRING);
		}else if ($CargoEmpresaContador == 3){
			$cargo_emp_3 = anti_injection($CargoEmpresa);
			$cargo_emp_3 = filter_var($cargo_emp_3, FILTER_SANITIZE_STRING);
		}
		
	}
	
	$status='1';

/* ---------------------- ESSE TA FUNCIONANDO CERTINHO ------------------*/	
	 $msg = false;
  if(isset($_FILES['arquivo'])){
   	$extensao = strtolower( end( explode( ".", $_FILES['arquivo'] ["name"] ) ) );
   //pega a extensao do arquivo
    $novo_nome = md5(time()). "." . $extensao;
    $diretorio = "../../../imagens/trabalhe-conosco/"; //define o diretorio para onde enviaremos o arquivo
    move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome); //efetua o upload
  
 

}else{
	$novo_nome='sem imagem';
}
/* ------------------------------------------ */

  	$novo_nome = anti_injection($novo_nome);
	$novo_nome = filter_var($novo_nome, FILTER_SANITIZE_STRING);

		$sql_verif_email = "select * from trabalhe_conosco where email = :email;";
		$verif_email = $pdo->prepare($sql_verif_email);
		$verif_email->bindValue('email',$email);
		$verif_email->execute();	
		//echo 'antes IF';
		//echo $email;
			if(!empty ($verif_email->fetch()) ){
				
				//echo 'DEPOIS IF';
				//echo $email;
				$sql_update_curriculo = "update trabalhe_conosco set 
			nome = :nome,
			data_nasc = :data_nasc,
			nascionalidade = :nascionalidade,
			est_civil = :est_civil,
			dependentes = :dependentes,
			num_dependentes = :num_depend,
			cnh = :cnh,
			fone = :fone,
			fone_cel = :fone_cel,
			cep = :cep,
			endereco = :endereco,
			numero = :numero,
			bairro = :bairro,
			cidade = :cidade,
			uf = :uf,
			objetivo = :objetivo,
			administracao = :administracao,
			expedi_logi = :expedi_logi,
			motorista = :motorista,
			telemarketing = :telemarketing,
			ti = :ti,
			representante = :representante,
			desc_area = :desc_area,
			escolaridade = :escolaridade,
			inic_esc = :inic_esc,
			fim_esc = :fim_esc,
			nome_curso = :nome_curso,
			nome_escola = :nome_escola,
			idioma = :idioma,
			nivel = :nivel,
			imagem = :imagem,
			nome_emp1 = :nome_emp_1,
			cidade_emp1 = :cid_emp_1,
			inicio_emp1 = :inicio_emp_1,
			fim_emp1 = :fim_emp_1,
			cargo_emp1 = :cargo_emp_1,
			nome_emp2 = :nome_emp_2,
			cidade_emp2 = :cid_emp_2,
			inicio_emp2 = :inicio_emp_2,
			fim_emp2 = :fim_emp_2,
			cargo_emp2 = :cargo_emp_2,
			nome_emp3 = :nome_emp_3,
			cidade_emp3 = :cid_emp_3,
			inicio_emp3 = :inicio_emp_3,
			fim_emp3 = :fim_emp_3,
			cargo_emp3 = :cargo_emp_3,
			data_alteracao = :dataLocal,
			status = :status
			where email = :email";
		$update_curriculo = $pdo->prepare($sql_update_curriculo);
		$update_curriculo->bindValue('nome',$nomeUsuario);
		$update_curriculo->bindValue('data_nasc',$data_nasc);
		$update_curriculo->bindValue('nascionalidade',$nascionalidade);
		$update_curriculo->bindValue('est_civil',$est_civil);
		$update_curriculo->bindValue('dependentes',$dependentes);
		$update_curriculo->bindValue('num_depend',$num_depend);
		$update_curriculo->bindValue('cnh',$cnh);
		$update_curriculo->bindValue('fone',$fone);
		$update_curriculo->bindValue('fone_cel',$fone_cel);
		$update_curriculo->bindValue('cep',$cep);
		$update_curriculo->bindValue('endereco',$endereco);
		$update_curriculo->bindValue('numero',$numero);
		$update_curriculo->bindValue('bairro',$bairro);
		$update_curriculo->bindValue('cidade',$cidade);
		$update_curriculo->bindValue('uf',$uf);
		$update_curriculo->bindValue('objetivo',$objetivo);
		$update_curriculo->bindValue('administracao',$adm);
		$update_curriculo->bindValue('expedi_logi',$expedi_logi);
		$update_curriculo->bindValue('motorista',$motorista);
		$update_curriculo->bindValue('telemarketing',$telemarketing);
		$update_curriculo->bindValue('ti',$ti);
		$update_curriculo->bindValue('representante',$representante);
		$update_curriculo->bindValue('desc_area',$desc_area);
		$update_curriculo->bindValue('escolaridade',$escolaridade);
		$update_curriculo->bindValue('inic_esc',$inic_esc);
		$update_curriculo->bindValue('fim_esc',$fim_esc);
		$update_curriculo->bindValue('nome_curso',$nome_curso);
		$update_curriculo->bindValue('nome_escola',$nome_escola);
		$update_curriculo->bindValue('idioma',$idioma);
		$update_curriculo->bindValue('nivel',$nivel);
		$update_curriculo->bindValue('imagem',$novo_nome);
		$update_curriculo->bindValue('nome_emp_1',$nome_emp_1);
		$update_curriculo->bindValue('cid_emp_1',$cid_emp_1);
		$update_curriculo->bindValue('inicio_emp_1',$inicio_emp_1);
		$update_curriculo->bindValue('fim_emp_1',$fim_emp_1);
		$update_curriculo->bindValue('cargo_emp_1',$cargo_emp_1);
		$update_curriculo->bindValue('nome_emp_2',$nome_emp_2);
		$update_curriculo->bindValue('cid_emp_2',$cid_emp_2);
		$update_curriculo->bindValue('inicio_emp_2',$inicio_emp_2);
		$update_curriculo->bindValue('fim_emp_2',$fim_emp_2);
		$update_curriculo->bindValue('cargo_emp_2',$cargo_emp_2);
		$update_curriculo->bindValue('nome_emp_3',$nome_emp_3);
		$update_curriculo->bindValue('cid_emp_3',$cid_emp_3);
		$update_curriculo->bindValue('inicio_emp_3',$inicio_emp_3);
		$update_curriculo->bindValue('fim_emp_3',$fim_emp_3);
		$update_curriculo->bindValue('cargo_emp_3',$cargo_emp_3); 
		$update_curriculo->bindValue('dataLocal',$dataLocal);
		$update_curriculo->bindValue('status',$status);
		$update_curriculo->bindValue('email',$email);
		$update_curriculo->execute();
				
				if ($update_curriculo){
			
			$query_curric = 'update trabalhe_conosco set';
			
		//	$IP = 'nulo por enquanto';
			
			$descricao = 'atualizar Curriculum';
			
			$usuario = 'teste cliente';
			
			$SQL_gravar_log_curric = "insert into logs(datahora,acao,IP,descricao,usuario)values(
				:datahora,
				:acao,
				:IP,
				:descricao,
				:usuario)";
		$gravar_log_curric = $pdo->prepare($SQL_gravar_log_curric);
		$gravar_log_curric->bindValue('datahora',$dataLocal);
		$gravar_log_curric->bindValue('acao',$query_curric);
		$gravar_log_curric->bindValue('IP',$IP);
		$gravar_log_curric->bindValue('descricao',$descricao);
		$gravar_log_curric->bindValue('usuario',$usuario);
		$gravar_log_curric->execute();	
			
			 ?>
<script language="javascript">
						var alerta = '<?php echo 'Curriculo atualizado com sucesso!';?>';
						alert (alerta);		
						window.location.href='<?php echo $httpLeal;?>/view/contato/trabalhe-conosco/';
					</script>
<?php
		 	
		}else{
			?>
<script language="javascript">
						var alerta = '<?php echo 'erro na atualização do Curriculo';?>';
						alert (alerta);
						history.go(-1);
					</script>
<?php
		}
				
				
			}else{
			
				
		$sql_gravar_curriculo = "insert into trabalhe_conosco(nome,data_nasc,nascionalidade,est_civil,dependentes,num_dependentes,cnh,fone,fone_cel,email,cep,endereco,numero,bairro,cidade,uf,objetivo,administracao,expedi_logi,motorista,telemarketing,ti,representante,desc_area,escolaridade,inic_esc,fim_esc,nome_curso,nome_escola,idioma,nivel,imagem,nome_emp1,cidade_emp1,inicio_emp1,fim_emp1,cargo_emp1,nome_emp2,cidade_emp2,inicio_emp2,fim_emp2,cargo_emp2,nome_emp3,cidade_emp3,inicio_emp3,fim_emp3,cargo_emp3,data_cadastro,status)values(
			:nome,
			:data_nasc,
			:nascionalidade,
			:est_civil,
			:dependentes,
			:num_depend,
			:cnh,
			:fone,
			:fone_cel,
			:email,
			:cep,
			:endereco,
			:numero,
			:bairro,
			:cidade,
			:uf,
			:objetivo,
			:administracao,
			:expedi_logi,
			:motorista,
			:telemarketing,
			:ti,
			:representante,
			:desc_area,
			:escolaridade,
			:inic_esc,
			:fim_esc,
			:nome_curso,
			:nome_escola,
			:idioma,
			:nivel,
			:imagem,
			:nome_emp_1,
			:cid_emp_1,
			:inicio_emp_1,
			:fim_emp_1,
			:cargo_emp_1,
			:nome_emp_2,
			:cid_emp_2,
			:inicio_emp_2,
			:fim_emp_2,
			:cargo_emp_2,
			:nome_emp_3,
			:cid_emp_3,
			:inicio_emp_3,
			:fim_emp_3,
			:cargo_emp_3,
			:dataLocal,
			:status)";
		$gravar_curriculo = $pdo->prepare($sql_gravar_curriculo);
		$gravar_curriculo->bindValue('nome',$nomeUsuario);
		$gravar_curriculo->bindValue('data_nasc',$data_nasc);
		$gravar_curriculo->bindValue('nascionalidade',$nascionalidade);
		$gravar_curriculo->bindValue('est_civil',$est_civil);
		$gravar_curriculo->bindValue('dependentes',$dependentes);
		$gravar_curriculo->bindValue('num_depend',$num_depend);
		$gravar_curriculo->bindValue('cnh',$cnh);
		$gravar_curriculo->bindValue('fone',$fone);
		$gravar_curriculo->bindValue('fone_cel',$fone_cel);
		$gravar_curriculo->bindValue('email',$email);
		$gravar_curriculo->bindValue('cep',$cep);
		$gravar_curriculo->bindValue('endereco',$endereco);
		$gravar_curriculo->bindValue('numero',$numero);
		$gravar_curriculo->bindValue('bairro',$bairro);
		$gravar_curriculo->bindValue('cidade',$cidade);
		$gravar_curriculo->bindValue('uf',$uf);
		$gravar_curriculo->bindValue('objetivo',$objetivo);
		$gravar_curriculo->bindValue('administracao',$adm);
		$gravar_curriculo->bindValue('expedi_logi',$expedi_logi);
		$gravar_curriculo->bindValue('motorista',$motorista);
		$gravar_curriculo->bindValue('telemarketing',$telemarketing);
		$gravar_curriculo->bindValue('ti',$ti);
		$gravar_curriculo->bindValue('representante',$representante);
		$gravar_curriculo->bindValue('desc_area',$desc_area);
		$gravar_curriculo->bindValue('escolaridade',$escolaridade);
		$gravar_curriculo->bindValue('inic_esc',$inic_esc);
		$gravar_curriculo->bindValue('fim_esc',$fim_esc);
		$gravar_curriculo->bindValue('nome_curso',$nome_curso);
		$gravar_curriculo->bindValue('nome_escola',$nome_escola);
		$gravar_curriculo->bindValue('idioma',$idioma);
		$gravar_curriculo->bindValue('nivel',$nivel);
		$gravar_curriculo->bindValue('imagem',$novo_nome);
		$gravar_curriculo->bindValue('nome_emp_1',$nome_emp_1);
		$gravar_curriculo->bindValue('cid_emp_1',$cid_emp_1);
		$gravar_curriculo->bindValue('inicio_emp_1',$inicio_emp_1);
		$gravar_curriculo->bindValue('fim_emp_1',$fim_emp_1);
		$gravar_curriculo->bindValue('cargo_emp_1',$cargo_emp_1);
		$gravar_curriculo->bindValue('nome_emp_2',$nome_emp_2);
		$gravar_curriculo->bindValue('cid_emp_2',$cid_emp_2);
		$gravar_curriculo->bindValue('inicio_emp_2',$inicio_emp_2);
		$gravar_curriculo->bindValue('fim_emp_2',$fim_emp_2);
		$gravar_curriculo->bindValue('cargo_emp_2',$cargo_emp_2);
		$gravar_curriculo->bindValue('nome_emp_3',$nome_emp_3);
		$gravar_curriculo->bindValue('cid_emp_3',$cid_emp_3);
		$gravar_curriculo->bindValue('inicio_emp_3',$inicio_emp_3);
		$gravar_curriculo->bindValue('fim_emp_3',$fim_emp_3);
		$gravar_curriculo->bindValue('cargo_emp_3',$cargo_emp_3);
		$gravar_curriculo->bindValue('dataLocal',$dataLocal);
		$gravar_curriculo->bindValue('status',$status);
		$gravar_curriculo->execute();
		if ($gravar_curriculo){
			
			$query_curric = 'nsert into trabalhe_conosco(nome,data_nasc,nascionalidade,est_civil,dependentes,num_dependentes,cnh,fone,fone_cel,email,cep,endereco,numero,bairro,cidade,uf,objetivo,administracao,expedicao,logistica,motorista,telemarketing,ti,escolaridade,imagem,nome_emp1,cidade_emp1,periodo_emp1,cargo_emp1,nome_emp2,cidade_emp2,periodo_emp2,cargo_emp2,nome_emp3,cidade_emp3,periodo_emp3,cargo_emp3,data_cadastro,status)';
			
		//	$IP = 'nulo por enquanto';
			
			$descricao = 'Gravar Curriculum';
			
			$usuario = 'teste cliente';
			
			$SQL_gravar_log_curric = "insert into logs(datahora,acao,IP,descricao,usuario)values(
				:datahora,
				:acao,
				:IP,
				:descricao,
				:usuario)";
		$gravar_log_curric = $pdo->prepare($SQL_gravar_log_curric);
		$gravar_log_curric->bindValue('datahora',$dataLocal);
		$gravar_log_curric->bindValue('acao',$query_curric);
		$gravar_log_curric->bindValue('IP',$IP);
		$gravar_log_curric->bindValue('descricao',$descricao);
		$gravar_log_curric->bindValue('usuario',$usuario);
		$gravar_log_curric->execute();	
			
			 ?>
<script language="javascript">
						var alerta = '<?php echo 'Curriculo cadastrado com sucesso!';?>';
						alert (alerta);		
						window.location.href='<?php echo $http;?>/view/contato/trabalhe-conosco/'; 
					</script>
<?php
		 	
		}else{
			?>
<script language="javascript">
						var alerta = '<?php echo 'erro no cadastro do Curriculo';?>';
						alert (alerta);
						history.go(-1);
					</script>
<?php
		}
		
}
}
/* Fim Gravar Curriculum */

?>