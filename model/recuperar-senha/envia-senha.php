<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());

include_once ('../../conexao-pdo/config.php');
include_once ('../../conexao-pdo/conexao-mysql-pdo.php');

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); 

if (!empty($_GET['rc'])){
    $vat_no = $_POST['CNPJ'];
    $CNPJ = preg_replace('/[^0-9]/', '', $vat_no);
    $SQLrecupera = "SELECT * FROM cliente WHERE REPLACE(REPLACE(REPLACE(CNPJ_CPF,'.',''),'-',''),'/','') = :CNPJ";
	$SQLrecupera = $pdo->prepare($SQLrecupera);	
	$SQLrecupera->bindValue('CNPJ',$CNPJ);	
    $SQLrecupera->execute();
    $rowRecupera = $SQLrecupera->fetch();
	
	if (!empty($rowRecupera)){
		$chave = $rowRecupera->SHA1;
		$email = $rowRecupera->MAIL_CONTATO;
		$nome = $rowRecupera->RAZ_SOCIAL;

		require_once("../../PHPMailer/PHPMailerAutoload.php");	
				
		$sql_parametros_email = "SELECT * FROM parametros_email where descricao like 'RECUPERAR_SENHA' and status = 'ATIVO'";
		$sql_parametros_email = $pdo->prepare($sql_parametros_email);
		$sql_parametros_email->execute();
		$row_parametros_email = $sql_parametros_email->fetch();
		
		$sql_parametros_email_envio = "SELECT * FROM parametros_envio_email where status = 'ATIVO'";
		$sql_parametros_email_envio = $pdo->prepare($sql_parametros_email_envio);
		$sql_parametros_email_envio->execute();
		$row_parametros_email_envio = $sql_parametros_email_envio->fetch();
		$sql_parametros_email_copia = "SELECT * FROM parametros_email where status = 'ATIVO' AND descricao like 'RECUPERAR_SENHA_COPIA'";
		$sql_parametros_email_copia = $pdo->prepare($sql_parametros_email_copia);
		$sql_parametros_email_copia->execute();
			
			
		// Inicia a classe PHPMailer
		$mail = new PHPMailer(true);

		// Define os dados do servidor e tipo de conexão
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
			$mail->AddReplyTo('leonidas@lcmaxsolution.com.br', $NomeEmpresa); //Seu e-mail
			$mail->Subject = utf8_decode(htmlspecialchars_decode("Recuperar Senha"));//Assunto do e-mail
			$mail->AddAddress($email, utf8_decode(htmlspecialchars_decode($NomeEmpresa)));
			while ($row_parametros_email_copia = $sql_parametros_email_copia->fetch()){
				$mail->AddCC($row_parametros_email_copia->email);
			}
$HTML = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//PT">
<HTML>
<HEAD>
<TITLE'.$NomeEmpresa.'</TITLE>
<META http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
</HEAD>
<body>
<table width="100%" border="0" align="center" bordercolor="#000000">
  <tr>
    <td><table width="80%" border="0" align="center" bordercolor="#000000" bgcolor="#fff">
        <tr>
          
          <td width="151" align="center" bgcolor="#FFFFFF"><img src="'.$http.'/Painel/imagens/logo/'.$IconEmpresa.'" width="120" height="60"></td>
          <td width="852" align="center" bgcolor="#FFFFFF"><strong><font color="#000000" size="15" face="Verdana, Arial, Helvetica, sans-serif"> Recuperar Senha</font></strong></td>
        </tr>
       
        
        <tr>
         
        </tr>
        <tr>
          <td colspan="3"><table width="90%" align="center">
              <tr>
                <td width="77"><strong><font color="#111111" size="2" face="Verdana, Arial, Helvetica, sans-serif">Data:</font></strong></td>
                <td width="220"><strong><font color="#111111" size="2" face="Verdana, Arial, Helvetica, sans-serif">' . date('d/m/y') . '</font></strong></td>
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
                  <td height="33"><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Nome: </font></strong><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">' .$nome.'</font></strong></td>
                </tr>
                <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.utf8_decode(htmlspecialchars_decode("
                  Olá $nome <br />
Você recebeu este e-mail porque alguém tentou fazer o login na conta associada a este endereço e pediu um lembrete de senha.
<br />
Se esse alguém foi você e se você quiser restaurar sua senha, clique na URL abaixo. Se não conseguir clicar nela, copie e cole a URL na barra de endereços do seu navegador:
<br />
")).'
  </font></strong>
                  <strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.'<a href="'.$http.'?pg=alterar-senha&chave='.$chave.'">'.$http.'?pg=alterar-senha&chave='.$chave.'</a>'.'</font></strong>
<br />
<strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.utf8_decode(htmlspecialchars_decode("

<br />

Se tiver dúvidas ou se precisar de ajuda com sua conta, acesse nosso centro de suporte em '.'<a href=".$http."/view/contato/contato/' >".$http."/view/contato/contato/</a>'.'
	 <br />
Atenciosamente,
<br />
Equipe ".$NomeEmpresa."
                  
                  ")).'
                  </font></strong>      
              </table>
          </div></td>
        </tr>
       
        <tr>
          <td colspan="3"><strong><font color="#001E5B" size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
            </font></strong></td>
        </tr>
        <tr>
          <td colspan="3" align="center"><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.$http.' - vendas@3ecomercial.com.br </font></strong></td>
        </tr>
      </table></td>
  </tr>
</table>
<p>
</body>
</html>';
     $mail->MsgHTML($HTML); 
     $mail->Send();
	 ?>
<script language="javascript">
	var alerta = '<?php echo 'Enviado Email de Confirmação no endereco: '.$email;?>';
		alert (alerta);		
		window.location.href='<?php echo $http;?>';;
	</script>
<?php
	 
	 
    //caso apresente algum erro é apresentado abaixo com essa exceção.
    }catch (phpmailerException $e) {
      echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
}
?>
<?php }else{ ?>
<script language="javascript">
	var alerta = '<?php echo 'CNPJ não encontrado.';?>';
	alert (alerta);		
	history.go(-1);
</script>
<?php 
				}
}
				
			
	// fim Email Contato					
				
// FIM GERAÇÃO DA CHAVE

// Alterar a senha por recuperação de email

 if (!empty($_GET['sn'])){
	 
		$chave = anti_injection($_POST['chave']);
		$chave = filter_var($chave, FILTER_SANITIZE_STRING);
		
		$NovaSenha = anti_injection($_POST['NovaSenha']);
		$NovaSenha = filter_var($NovaSenha, FILTER_SANITIZE_STRING);
				
		$NovaSenha2 = anti_injection($_POST['NovaSenha2']);
		$NovaSenha2 = filter_var($NovaSenha2, FILTER_SANITIZE_STRING);
		
		$SQLcheckchave = "SELECT * FROM cliente WHERE SHA1 = :SHA1";
		$SQLcheckchave = $pdo->prepare($SQLcheckchave);	
		$SQLcheckchave->bindValue('SHA1',$chave);	
		$SQLcheckchave->execute();	
		if ($SQLcheckchave->rowCount() == 0){
			?>
			<script language="javascript">
				var alerta = '<?php echo 'CNPJ Incorreto para recuperação';?>';
				alert (alerta);		
				history.go(-1);
			</script>
			<?php
		}else{
			$Senha_ok = password_hash($NovaSenha, PASSWORD_DEFAULT);
			$upd_senha = "UPDATE cliente set PASSWORD = :senha where SHA1 = :SHA1";
			$upd_senha = $pdo->prepare($upd_senha);	
			$upd_senha->bindValue('senha',$Senha_ok);	
			$upd_senha->bindValue('SHA1',$chave);	
			$upd_senha->execute();
				if($upd_senha){
					/* GRAVAR LOG */
					$query_LOG = 'PDATE cliente SET 
					senha = '.$Senha_ok.'';
				
					$IP = $_SERVER["REMOTE_ADDR"];
					$descricao = 'RECUPERAÇÃO DE SENHA VIA EMAIL';
					$usuario = $COD_CLIENTE;
					$SQL_GRV_LOG = "insert into logs(datahora,acao,IP,descricao,usuario)values(
					:datahora,
					:acao,
					:IP,
					:descricao,
					:usuario)";
					$SQL_GRV_LOG = $pdo->prepare($SQL_GRV_LOG);
					$SQL_GRV_LOG->bindValue('datahora',$dataLocal);
					$SQL_GRV_LOG->bindValue('acao',$query_LOG);
					$SQL_GRV_LOG->bindValue('IP',$IP);
					$SQL_GRV_LOG->bindValue('descricao',$descricao);
					$SQL_GRV_LOG->bindValue('usuario',$usuario);
					$SQL_GRV_LOG->execute();	
					?>
					<script type="application/javascript">
                    	alert ("Dados atualizado com sucesso!");
                        window.location.href='<?php echo $http;?>';
                    </script>
					<?php
					/* FIM - GRAVAR LOG */
				}else{
					?>
					<script type="application/javascript">
                    	alert ("Error ao atualizar os dados!");
                        history.go(-1);
                    </script>
					<?php
				}
		
		}
 }/* GET['SN']*/

	?>

