<?php
include '../../../conexao-pdo/conexao-mysql-pdo.php';
include '../../../conexao-pdo/config.php';
session_start();
date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s');

/* ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);   */

if (!empty($_GET['grv'])){

	$nome = anti_injection($_POST['nome']);
	$nome = filter_var($nome, FILTER_SANITIZE_STRING);	
	
	$cpf_cnpj = anti_injection($_POST['cpf_cnpj']);
	$cpf_cnpj = filter_var($cpf_cnpj, FILTER_SANITIZE_STRING);	
	
	$email = anti_injection($_POST['email']);
	$email = filter_var($email, FILTER_SANITIZE_STRING);	
	
	$fone = anti_injection($_POST['fone']);
	$fone = filter_var($fone, FILTER_SANITIZE_STRING);
	
	$fone_cel = anti_injection($_POST['fone_cel']);
	$fone_cel = filter_var($fone_cel, FILTER_SANITIZE_STRING);	
	
	$contato = anti_injection($_POST['contato']);
	$contato = filter_var($contato, FILTER_SANITIZE_STRING);	
	
	$CEP = anti_injection($_POST['CEP']);
	$CEP = filter_var($CEP, FILTER_SANITIZE_STRING);	
	
	$uf = anti_injection($_POST['uf']);
	$uf = filter_var($uf, FILTER_SANITIZE_STRING);
	
	$endereco = anti_injection($_POST['endereco']);
	$endereco = filter_var($endereco, FILTER_SANITIZE_STRING);
	
	$cidade = anti_injection($_POST['cidade']);
	$cidade = filter_var($cidade, FILTER_SANITIZE_STRING);	
	
	$bairro = anti_injection($_POST['bairro']);
	$bairro = filter_var($bairro, FILTER_SANITIZE_STRING);	
	
	$numero = anti_injection($_POST['numero']);
	$numero = filter_var($numero, FILTER_SANITIZE_STRING);	
	
	/* $assunto = anti_injection($_POST['assunto']);
	$assunto = filter_var($assunto, FILTER_SANITIZE_STRING); */
	$assunto = '0';
	
	$mensagem = anti_injection($_POST['mensagem']);
	$mensagem = filter_var($mensagem, FILTER_SANITIZE_STRING);	
	
	//$arquivo = anti_injection($_POST['arquivo']);
	//$arquivo = filter_var($arquivo, FILTER_SANITIZE_STRING);
	
	
	 $msg = false;
  if(isset($_FILES['arquivo'])){
   	$extensao = strtolower( end( explode( ".", $_FILES['arquivo'] ["name"] ) ) );
   //pega a extensao do arquivo
    $novo_nome = md5(time()). "." . $extensao;
    $diretorio = "../../../imagens/seja-um-fornecedor/"; //define o diretorio para onde enviaremos o arquivo
    move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio.$novo_nome); //efetua o upload
  
}else{
	$novo_nome='sem imagem';
}
	
	
	$novo_nome = anti_injection($novo_nome);
	$novo_nome = filter_var($novo_nome, FILTER_SANITIZE_STRING);
	echo $cpf_cnpj;
		$sql_gravar_fornec = "insert into seja_fornecedor(nome,cpf_cnpj,email,fone,fone_cel,contato,CEP,estado,cidade,bairro,endereco,numero,assunto,mensagem,arquivo,data_cadastro)values(
			:nome,
			:cpf_cnpj,
			:email,
			:fone,
			:fone_cel,
			:contato,
			:CEP,
			:estado,
			:cidade,
			:bairro,
			:endereco,
			:numero,
			:assunto,
			:mensagem,
			:arquivo,
			:data_cadastro)";
		$gravar_fornec = $pdo->prepare($sql_gravar_fornec);
		$gravar_fornec->bindValue('nome',$nome);
		$gravar_fornec->bindValue('cpf_cnpj',$cpf_cnpj);
		$gravar_fornec->bindValue('email',$email);
		$gravar_fornec->bindValue('fone',$fone);
		$gravar_fornec->bindValue('fone_cel',$fone_cel);
		$gravar_fornec->bindValue('contato',$contato);
		$gravar_fornec->bindValue('CEP',$CEP);
		$gravar_fornec->bindValue('estado',$uf);
		$gravar_fornec->bindValue('cidade',$cidade);
		$gravar_fornec->bindValue('bairro',$bairro);
		$gravar_fornec->bindValue('endereco',$endereco);
		$gravar_fornec->bindValue('numero',$numero);
		$gravar_fornec->bindValue('assunto',$assunto);
		$gravar_fornec->bindValue('mensagem',$mensagem);
		$gravar_fornec->bindValue('arquivo',$novo_nome);
		$gravar_fornec->bindValue('data_cadastro',$dataLocal);
		$gravar_fornec->execute();
		if($gravar_fornec){
			$query_fornec='nsert into seja_fornecedor(nome,cpf_cnpj,email,fone,fone_cel,contato,CEP,estado,cidade,bairro,endereco,numero,assunto,mensagem,arquivo,data_cadastro)values(
			:nome,
			:cpf_cnpj,
			:email,
			:fone,
			:fone_cel,
			:contato,
			:CEP,
			:estado,
			:cidade,
			:bairro,
			:endereco,
			:numero,
			:assunto,
			:mensagem,
			:arquivo,
			:data_cadastro)';
			$descricao = 'Gravar Seja um Fornecedor';
			$usuario = 'Fornecedor';
			$SQL_gravar_log_fornec = "insert into logs(datahora,acao,IP,descricao,usuario)values(
				:datahora,
				:acao,
				:IP,
				:descricao,
				:usuario)";
		$gravar_log_fornec = $pdo->prepare($SQL_gravar_log_fornec);
		$gravar_log_fornec->bindValue('datahora',$dataLocal);
		$gravar_log_fornec->bindValue('acao',$query_fornec);
		$gravar_log_fornec->bindValue('IP',$IP);
		$gravar_log_fornec->bindValue('descricao',$descricao);
		$gravar_log_fornec->bindValue('usuario',$usuario);
		$gravar_log_fornec->execute();	
	
		/* INICIO EMAIL PARA FORNECEDOR */
		
			require_once("../../../PHPMailer/PHPMailerAutoload.php");

			$sql_parametros_email = "SELECT * FROM parametros_email where descricao like 'FORNECEDOR' and status = 'ATIVO'";
			$sql_parametros_email = $pdo->prepare($sql_parametros_email);
			$sql_parametros_email->execute();
			$row_parametros_email = $sql_parametros_email->fetch();
			
			$sql_parametros_email_envio = "SELECT * FROM parametros_envio_email where status = 'ATIVO'";
			$sql_parametros_email_envio = $pdo->prepare($sql_parametros_email_envio);
			$sql_parametros_email_envio->execute();
			$row_parametros_email_envio = $sql_parametros_email_envio->fetch();	
			
			// Inicia a classe PHPMailer
$mail = new PHPMailer(true);

// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem será SMTP
 
try {
    $mail->Host = $row_parametros_email_envio->Host; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
     $mail->SMTPAuth   = $row_parametros_email_envio->SMTPAuth;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
     $mail->Port       = $row_parametros_email_envio->Port; //  Usar 587 porta SMTP
	   $mail->SMTPSecure = $row_parametros_email_envio->SMTPSecure;
     $mail->Username = $row_parametros_email_envio->Username; // Usuário do servidor SMTP (endereço de email)
     $mail->Password = $row_parametros_email_envio->Password; // Senha do servidor SMTP (senha do email usado)

 //Define o remetente
     // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
     $mail->SetFrom($row_parametros_email_envio->SetFrom, $NomeEmpresa.' - ' . $nome); //Seu e-mail
     $mail->AddReplyTo('leonardo@lealdutra.com.br', $NomeEmpresa); //Seu e-mail
     $mail->Subject = utf8_decode(htmlspecialchars_decode("Seja um Fornecedor"));//Assunto do e-mail
 
 
     //Define os destinatário(s)
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	 $mail->AddAddress('leonardo@lealdutra.com.br', utf8_decode(htmlspecialchars_decode($NomeEmpresa)));
	 //Campos abaixo são opcionais 
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
   //    $mail->AddCC('neibarzali@gmail.com'); // Copia
	   $mail->AddCC('foxs.sbc11@gmail.com'); // Copia
	   $mail->AddBCC('leonardo@lcmaxsolution.com.br'); // Cópia Oculta
     //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo

$HTML = $HTML.'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//PT">
<HTML>
<HEAD>
<TITLE>.::Leal Dutra Distribuidora::.</TITLE>
<META http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
</HEAD>
<body>
<table width="100%" border="0" align="center" bordercolor="#000000">
  <tr>
    <td><table width="80%" border="0" align="center" bordercolor="#000000" bgcolor="#E6E6E6">
        <tr>
          
          <td width="151" align="center" bgcolor="#FFFFFF"><img src="'.$http.'/Painel/imagens/logo/'.$LogoEmpresa.'" width="100"></td>
          <td width="852" align="center" bgcolor="#FFFFFF"><strong><font color="#000000" size="15" face="Verdana, Arial, Helvetica, sans-serif">Seja um Fornecedor</font></strong></td>
        </tr>
       
        
        <tr>
         
        </tr>
        <tr>
          <td colspan="3"><table width="90%" align="center">
              <tr>
                <td width="77"><strong><font color="#111111" size="2" face="Verdana, Arial, Helvetica, sans-serif">Data:</font></strong></td>
                <td width="220"><strong><font color="#111111" size="2" face="Verdana, Arial, Helvetica, sans-serif">' . date('d/m/Y') . '</font></strong></td>
                <td width="77"><strong><font color="#111111" size="2" face="Verdana, Arial, Helvetica, sans-serif">Hora:</font></strong></td>
                <td width="660"><strong><font color="#111111" size="2" face="Verdana, Arial, Helvetica, sans-serif">'. date('H:i:s'). '</font></strong></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td colspan="3"><div align="center">
              <table width="90%" align="center">
                <tr bgcolor="#333333">
                 
                </tr>
                <tr>
                  <td height="33"><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Nome/Empresa: </font></strong><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">' .utf8_decode(htmlspecialchars_decode($nome)).'</font></strong></td>
                </tr>
                 <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">CPF/CNPJ:  </font></strong><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.$cpf_cnpj.'</font></strong></td>
                </tr>
                <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Email:  </font></strong><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.$email.'</font></strong></td>
                </tr>
                <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Telefone: </font><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.$fone.'</font></strong></td>
                </tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Celular: </font><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.$fone_cel.'</font></strong></td>
                </tr>
				 <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Nome Contato: </font><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.utf8_decode(htmlspecialchars_decode($contato)).'</font></strong></td>
                </tr>
                 <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">UF: </font><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.utf8_decode(htmlspecialchars_decode($uf)).'</font></strong></td>
                </tr>
                 <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Cidade: </font><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.utf8_decode(htmlspecialchars_decode($cidade)).'</font></strong></td>
                </tr>
                <tr>

                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Mensagem: </font><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.utf8_decode(htmlspecialchars_decode($mensagem)).'</font></strong></td>
                </tr>
                <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Atenciosamente </font></strong><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></strong></td>
                </tr>
               
               
              </table>
          </div></td>
        </tr>
       
        <tr>
          <td colspan="3"><strong><font color="#001E5B" size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
            </font></strong></td>
        </tr>
        <tr>
          <td colspan="3" align="center"><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.$http.' - '.$row_parametros_email->email.' </font></strong></td>
        </tr>
      </table></td>
  </tr>
</table>
<p>
</body>
</html>';

 ///' .utf8_decode(htmlspecialchars_decode($assunto)). '
     //Define o corpo do email
     $mail->MsgHTML($HTML); 
 //echo  "NOME: " .$nome . "-----  E-mail: " . $email .
     ////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
     //$mail->MsgHTML(file_get_contents('arquivo.html'));
 
     $mail->Send();
    //caso apresente algum erro é apresentado abaixo com essa exceção.
    }catch (phpmailerException $e) {
      echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
}
				
		
		/* FIM EMAIL PARA FORNECEDOR */
		 ?>
<script language="javascript">
						var alerta = '<?php echo 'Cadastro de Fornecedor Enviado!';?>';
						alert (alerta);		
						window.location.href='<?php echo $http;?>/view/contato/seja-um-fornecedor/'; 
					</script>
<?php
		 	
		}else{
			?>
<script language="javascript">
						var alerta = '<?php echo 'erro no cadastro';?>';
						alert (alerta);
						history.go(-1);
					</script>
<?php
		
		}
}
?>