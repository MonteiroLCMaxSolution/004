<?php
include_once ('../../../conexao-pdo/conexao-mysql-pdo.php');
include_once ('../../../conexao-pdo/config.php');
session_start();
date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s');

/* ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);   */

/* Gravar fale Conosco na tabela sma_contato  */
if (!empty($_GET['grv'])){
  
	$nome = anti_injection($_POST['nome']);
	$nome = filter_var($nome, FILTER_SANITIZE_STRING);	
	
	$email = anti_injection($_POST['email']);
	$email = filter_var($email, FILTER_SANITIZE_STRING);	

	$fone = anti_injection($_POST['fone']);
	$fone = filter_var($fone, FILTER_SANITIZE_STRING);	
	
	$mensagem = anti_injection($_POST['mensagem']);
    $mensagem = filter_var($mensagem, FILTER_SANITIZE_STRING);	
  
  	$unidade = anti_injection($_POST['unidade']);
	$unidade = filter_var($unidade, FILTER_SANITIZE_STRING);	

		$sql_gravar_contato = "insert into contato(nome,email,fone,mensagem,unidade,data)values(
			:nome,
			:email,
			:fone,
      :mensagem,
      :unidade,
			:data
			)";
		$gravar_contato = $pdo->prepare($sql_gravar_contato);
		$gravar_contato->bindValue('nome',$nome);
		$gravar_contato->bindValue('email',$email);
		$gravar_contato->bindValue('fone',$fone);
    $gravar_contato->bindValue('mensagem',$mensagem);
    $gravar_contato->bindValue('unidade',$unidade);
		$gravar_contato->bindValue('data',$dataLocal);
		$gravar_contato->execute();
		if ($gravar_contato){
			
			require_once("../../../PHPMailer/PHPMailerAutoload.php");
			
		$sql_parametros_email = "SELECT * FROM parametros_email where descricao like 'FALE_CONOSCO' and status = 'ATIVO'";
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
     $mail->AddReplyTo('compras@3ecomercial.com.br', $NomeEmpresa); //Seu e-mail
     $mail->Subject = utf8_decode(htmlspecialchars_decode("Fale Conosco"));//Assunto do e-mail
 
 
     //Define os destinatário(s)
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     //$mail->AddAddress('huma@humatransportes.com.br', utf8_decode(htmlspecialchars_decode("Orçamento")));
	 $mail->AddAddress($row_parametros_email->email, utf8_decode(htmlspecialchars_decode($NomeEmpresa)));

	 //Campos abaixo são opcionais 
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	   $mail->AddCC('foxs.sbc11@gmail.com'); // Copia
      // $mail->AddBCC('');
	 //  $mail->AddBCC('');
	   //$mail->AddBCC('leonardo@lcmaxsolution.com.br'); // Cópia Oculta
     //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo

$HTML = $HTML.'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//PT">
<HTML>
<HEAD>
<TITLE>.::'.$NomeEmpresa.'::.</TITLE>
<META http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
</HEAD>
<body>
<table width="100%" border="0" align="center" bordercolor="#000000">
  <tr>
    <td><table width="80%" border="0" align="center" bordercolor="#000000" bgcolor="#E6E6E6">
        <tr>
          
          <td width="151" align="center" bgcolor="#FFFFFF"><img src="'.$http.'/Painel/imagens/logo/'.$LogoEmpresa.'" width="100" ></td>
          <td width="852" align="center" bgcolor="#FFFFFF"><strong><font color="#000000" size="15" face="Verdana, Arial, Helvetica, sans-serif">Fale Conosco</font></strong></td>
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
                  <td height="33"><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Nome: </font></strong><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">' .utf8_decode(htmlspecialchars_decode($nome)).'</font></strong></td>
                </tr>
                <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Email:  </font></strong><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.$email.'</font></strong></td>
                </tr>
                <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Telefone: </font><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.$fone.'</font></strong></td>
                </tr>
				 <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Unidade: </font><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.$unidade.'</font></strong></td>
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
				
			
	// fim Email Contato	
			
			
			$query_contato = 'insert into sma_contato(nome,email,fone,mensagem,data)values(
			:nome,
			:email,
			:fone,
			:mensagem,
			:data
			)';
			
		//	$IP = 'nulo por enquanto';
			
			$descricao = 'Gravar Contato';
			
			$usuario = '';
			
			$SQL_gravar_log_contato = "insert into logs(datahora,acao,IP,descricao,usuario)values(
				:datahora,
				:acao,
				:IP,
				:descricao,
				:usuario)";
		$gravar_log_contato = $pdo->prepare($SQL_gravar_log_contato);
		$gravar_log_contato->bindValue('datahora',$dataLocal);
		$gravar_log_contato->bindValue('acao',$query_contato);
		$gravar_log_contato->bindValue('IP',$IP);
		$gravar_log_contato->bindValue('descricao',$descricao);
		$gravar_log_contato->bindValue('usuario',$usuario);
		$gravar_log_contato->execute();	
			
			 ?>
<script language="javascript">
						var alerta = '<?php echo 'Contato enviado com sucesso!';?>';
						alert (alerta);		
						window.location.href='<?php echo $http;?>'; 
					</script>
<?php
		}else{
			?>
<script language="javascript">
						var alerta = '<?php echo 'Erro ao enviar contato';?>';
						alert (alerta);
						 history.go(-1);
					</script>
<?php
		
		}
}

/* Fim Gravar Contato */


?>