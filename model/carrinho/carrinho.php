<?php 
if(!isset($_SESSION))
{
   session_start();
}

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s', time());
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');
$dataLocal = date('Y-m-d H:i:s');
$arquivo = 'config.php';

$parametro = 's';
$tag = '../';
while ($parametro != 'n'){
if (file_exists($arquivo)) {
    $parametro = 'n';
} else {
    $arquivo = $tag.$arquivo;
}
}

$BD = 'conexao-pdo/conexao-mysql-pdo.php';

$parametro = 's';
$tag = '../';
while ($parametro != 'n'){
if (file_exists($BD)) {
    $parametro = 'n';
} else {
    $BD = $tag.$BD;
}
}
require_once $arquivo;
require_once $BD;

if (empty($_SESSION['COD_EMPRESA_cliente'])){
	$_SESSION['COD_EMPRESA_cliente'] = 1;
}
if (empty($_SESSION['cond_pgto'])){
	$_SESSION['cond_pgto'] = 1;
}
/* exibir os dados do pedido no link dados-pedido.php - Leônidas Monteiro - 07/03/2020 */
if (!empty($_GET['dadosPedido'])){
	/* Pega as informações da tabela pedido */
	$SQL_exibir_dados = "SELECT a.id, date_format(a.data_pedido, '%d/%m/%Y as %H:%i:%s') AS data_pedido, a.itens,a.condicao, a.valor_produtos, a.desconto, a.valor_total, a.cod_forma_pgto, a.cod_cond_pgto, a.`status`, date_format(a.data_entrega, '%d/%m/%Y as %H:%i:%s') AS data_entrega FROM pedidos a WHERE a.SHA1 = :SHA1;";
	$SQL_exibir_dados = $pdo->prepare($SQL_exibir_dados);
	$SQL_exibir_dados->bindValue('SHA1',$_GET['dadosPedido']);
	$SQL_exibir_dados->execute();
	/* .Pega as informações da tabela pedido */
	/* Listar as informações da tabela pedido_item */
	$SQL_list_prod = "SELECT c.imagem, a.id_produto,b.nome_produto, a.valor_unitario, a.qtde, a.valor_total FROM pedido_item a 
INNER JOIN produtos b ON a.id_produto = b.cod_produto
LEFT JOIN imagens c ON a.id_produto = c.cod_produto
WHERE a.SHA1 = :SHA1;";
	$SQL_list_prod = $pdo->prepare($SQL_list_prod);
	$SQL_list_prod->bindValue('SHA1',$_GET['dadosPedido']);
	$SQL_list_prod->execute();
	
	/* .Listar as informações da tabela pedido_item */
}
/* fim - exibir os dados do pedido no link dados-pedido.php - Leônidas Monteiro - 07/03/2020 */
/* listar todos os pedidos do cliente buscando por ID - Leônidas Monteiro - 06/03/2020 */
$sha1 = $_SESSION['sha_carrinho'];
if(!empty($_SESSION['id_do_cliente'])){
	$SQL_listar_pedidos = "SELECT a.id, date_format(a.data_pedido, '%d/%m/%Y as %H:%i:%s') AS data_pedido, a.itens, a.valor_produtos, a.desconto, a.valor_total, if(a.data_entrega IS NOT NULL,date_format(a.data_entrega, '%d/%m/%Y as %H:%i:%s'),a.`status`) AS STATUS, a.SHA1 FROM pedidos a WHERE a.id_cliente = :id_cliente   ORDER BY a.id desc;";
	$SQL_listar_pedidos = $pdo->prepare($SQL_listar_pedidos);
	$SQL_listar_pedidos->bindValue('id_cliente',$_SESSION['id_do_cliente']);
	$SQL_listar_pedidos->execute();	
}
/* fim - listar todos os pedidos do cliente buscando por ID - Leônidas Monteiro - 06/03/2020 */


/* Finaliza compra 05/03/2020 - Leônidas Monteiro*/
if(!empty($_GET['confirmarPedido'])){
	
	$valorDaCompra = $_GET['valorDaCompra'];
	$desconto = $_GET['desconto'];
	$valorAPagar = $_GET['valorAPagar'];
	$itens = $_GET['itens'];
	$formPgto = $_GET['formPgto'];
	$condPgto = $_GET['condPgto'];
	$condicao = $_GET['condicao'];
	/*---------- GRAVAR O CLICK DO CLIENTE REFERENTE AO PRODUTO - LEÔNIDAS MONTEIRO - 17/09/2020 */
		$SQL_click = "UPDATE produto_click SET status = :status, data_click = :data_click WHERE sha1 = :sha1;";
		$SQL_click = $pdo->prepare($SQL_click);
		$SQL_click->bindValue('status','COMPROU');
		$SQL_click->bindValue('data_click',$dataLocal);
		$SQL_click->bindValue('sha1',$_SESSION['sha_carrinho']);
		$SQL_click->execute();  
	/*========== GRAVAR O CLICK DO CLIENTE REFERENTE AO PRODUTO - LEÔNIDAS MONTEIRO - 17/09/2020 */
	
	$origem_pedido= '1';
	$SQL_insert_pedido = "INSERT INTO pedidos(cod_empresa,id_cliente,SHA1,status,valor_produtos,valor_total,desconto,valor_extra,itens,data_pedido,origem_pedido, cod_cond_pgto, cod_forma_pgto,tipo_pedido,condicao,observ)VALUES(:cod_empresa,:idcliente,:sha,:status,:valorproduto,:valortotal,:desconto,:valorExtra,:itens,:datapedido,:origem_pedido,:cod_cond_pgto,:cod_forma_pgto,:tipo_pedido,:condicao,:observ)";
	$SQL_insert_pedido = $pdo->prepare($SQL_insert_pedido);
	$SQL_insert_pedido->bindValue('cod_empresa','1');
	$SQL_insert_pedido->bindValue('idcliente',$_SESSION['id_do_cliente']);
	$SQL_insert_pedido->bindValue('sha',$_SESSION['sha_carrinho']);
	$SQL_insert_pedido->bindValue('status','AGUARDANDO');
	$SQL_insert_pedido->bindValue('valorproduto',$valorDaCompra);
	$SQL_insert_pedido->bindValue('valortotal',$valorAPagar);
	$SQL_insert_pedido->bindValue('desconto',$desconto);
	$SQL_insert_pedido->bindValue('valorExtra',$valorDaCompra);
	$SQL_insert_pedido->bindValue('itens',$itens);
	$SQL_insert_pedido->bindValue('datapedido',$dataLocal);
	$SQL_insert_pedido->bindValue('origem_pedido',$origem_pedido);	
	$SQL_insert_pedido->bindValue('cod_cond_pgto',$condPgto);
	$SQL_insert_pedido->bindValue('cod_forma_pgto',$formPgto);
	$SQL_insert_pedido->bindValue('tipo_pedido','1');
	$SQL_insert_pedido->bindValue('condicao',$condicao);
	$SQL_insert_pedido->bindValue('observ',$_GET['observ']);
	$SQL_insert_pedido->execute();


	/* ALTERAR O STATUS NA TABELA pedido_item PARA	S - LEÔNIDAS MONTEIRO - 15/04/2021 */ 
		$SQL_atualizar_pedido_item = "UPDATE pedido_item SET finalizou = 'S' WHERE SHA1 = :SHA1;";
		$SQL_atualizar_pedido_item = $pdo->prepare($SQL_atualizar_pedido_item);
		$SQL_atualizar_pedido_item->bindValue('SHA1',$_SESSION['sha_carrinho']);
		$SQL_atualizar_pedido_item->execute();

	/* FIM ALTERAR O STATUS NA TABELA pedido_item PARA S */
	
	$SQL = "SELECT  a.id, sum(b.valor_unitario * b.qtde) as valor_total from pedidos a
	INNER JOIN pedido_item b ON b.SHA1 = a.SHA1 WHERE b.SHA1 = :SHA1";
	$SQL=$pdo->prepare($SQL);
	$SQL->bindValue('SHA1',$_SESSION['sha_carrinho']);
	$SQL->execute();
	$row = $SQL->fetch();
	$num_pedido = $row->id;
	$valor_total = $row->valor_total;
	
	/* envia um email para o cliente */
		require_once("../../PHPMailer/PHPMailerAutoload.php");
		
		
		
			
// Inicia a classe PHPMailer
$mail = new PHPMailer(true);

// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem será SMTP
 
try {
	$mail->Host = 'lcmaxsolution.com.br'; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
	$mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
	$mail->Port       = '465'; //  Usar 587 porta SMTP
	$mail->SMTPSecure = 'ssl';
	$mail->Username = 'leonardo@lcmaxsolution.com.br'; // Usuário do servidor SMTP (endereço de email)
	$mail->Password = 'Lcmax@leonardo2019'; // Senha do servidor SMTP (senha do email usado)

//Define o remetente
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
	$mail->SetFrom('leonardo@lcmaxsolution.com.br', $NomeEmpresa.' - ' . 'Pedido de Compra'); //Seu e-mail
	$mail->AddReplyTo('leonidas@lcmaxsolution.com.br', $NomeEmpresa); //Seu e-mail
	$mail->Subject = utf8_decode(htmlspecialchars_decode("Pedido de Compra"));//Assunto do e-mail
	$mail->AddAddress('foxs.sbc11@gmail.com', utf8_decode(htmlspecialchars_decode('LC Max Solution')));
	$mail->AddAddress($_SESSION['email_do_cliente'], utf8_decode(htmlspecialchars_decode('LC Max Solution')));

$HTML = $HTML.'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//PT">
<HTML>
<HEAD>
<TITLE>.::'.$_SESSION['nome_do_cliente'].'::.</TITLE>
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
          <td width="852" align="center" bgcolor="#FFFFFF"><strong><font color="#000000" size="15" face="Verdana, Arial, Helvetica, sans-serif">Pedido de Compra '.$num_pedido.'</font></strong></td>
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
                  <td height="33"><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.utf8_decode(htmlspecialchars_decode($_SESSION['nome_do_cliente'] . " - " .$_SESSION['COD_CIDADE']. "-" .$_SESSION['COD_UF']. ", você acabou de efetuar sua(as) compra(as) em nosso site. Gostariamos de agradecer a confiança depositada em nossa empresa")).' </font></strong></td>
                </tr>
                <tr>
                
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">O numero do seu pedido'.utf8_decode(htmlspecialchars_decode(" é:")).' <h1 style="color:#F00" align="center">'.$num_pedido.'</h1>  </font></strong>
                </tr>
                <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">
				 <div align="center">
				   <h2>Produtos do Pedido</h2>
      
      <table class="">
	  ';
	 	 if($uf == 'MG'){ 
	  $HTML.='
	  <thead>
          <tr style="font-size:11px; line-height:20px; color:#999999; background:#33346E">
            <td style="text-align:center">CÓD. PRODUTO</td>
            <td>PRODUTO</td>
            <td style="text-align:center">VALOR PRODUTOS</td>
			<td style="text-align:center">ST UNIT.</td>
            <td style="text-align:center">QTDE</td>
            <td style="text-align:center">TOTAL PROD.</td>
			<td style="text-align:center">TOTAL ST</td>
			<td style="text-align:center">VALOR TOTAL</td>
			
          </tr>
  		</thead>';
		 }else{
		$HTML.='
		<thead>
          <tr style="font-size:11px; line-height:20px; color:#999999; background:#33346E">
            <td style="text-align:center">CÓD. PRODUTO</td>
            <td>PRODUTO</td>
            <td style="text-align:center">VALOR PRODUTOS</td>
            <td style="text-align:center">QTDE</td>
            <td style="text-align:center">VALOR TOTAL</td>
          </tr>
  		</thead>
  		';	 
		 }
	$count = 1 ;
	
$SQL_listar_pedido_item = $pdo->prepare("select T1.id_produto,T1.cod_empresa, T2.nome_produto, T1.valor_unitario, T1.st_unitario, T1.qtde, T1.valor_total, st_total 
from pedido_item T1
left join produtos T2 on
T1.id_produto = T2.cod_produto
 WHERE T1.SHA1 = :sha group by T2.cod_produto");
$SQL_listar_pedido_item->bindValue('sha',$_SESSION['sha_carrinho']);
$SQL_listar_pedido_item->execute();

	 while ($row_listar_pedido_item = $SQL_listar_pedido_item->fetch()){ 
	 	if($uf == 'MG'){ 
		$ValorTotal = $row_listar_pedido_item->valor_total + $row_listar_pedido_item->st_total;
  $HTML.='
  <tr>
  <td style="text-align:center">'. $row_listar_pedido_item->id_produto .'</td>
    <td>'. $row_listar_pedido_item->nome_produto .'</td>
    <td style="text-align:center">'.number_format($row_listar_pedido_item->valor_unitario,2,',','.').'</td>
	<td style="text-align:center">'.number_format($row_listar_pedido_item->st_unitario,2,',','.').'</td>
    <td style="text-align:center">'.$row_listar_pedido_item->qtde.'</td>
    <td style="text-align:center">'.number_format($row_listar_pedido_item->valor_total,2,',','.').'</td>
	<td style="text-align:center">'.number_format($row_listar_pedido_item->st_total,2,',','.').'</td>
	<td style="text-align:center">'.number_format($ValorTotal,2,',','.').'</td>
  </tr>';
		}else{
			
			$HTML.='
  <tr>
    <td style="text-align:center">'. $row_listar_pedido_item->id_produto .'</td>
    <td>'. $row_listar_pedido_item->nome_produto .'</td>
    <td style="text-align:center">'.number_format($row_listar_pedido_item->valor_unitario,2,',','.').'</td>
    <td style="text-align:center">'.$row_listar_pedido_item->qtde.'</td>
    <td style="text-align:center">'.number_format($row_listar_pedido_item->valor_total,2,',','.').'</td>
  </tr>';
		}
  }
  $HTML.=' 
</table>
				</div>
				  </font></strong></td>
                </tr>
                <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">
                  <br />
				  
				   <div align="center"> Valor Total do Pedido: R$ '.$valor_total.' </div>
				  
				  <br />
                  <div align="center">'.utf8_decode(htmlspecialchars_decode("Informamos que para sua segurança, todos os pedidos estão sujeitos à análise e confirmação dos dados por telefone. <br />
A cada passo de produção, nossa loja o manterá informado através do seu e-mail. Pedimos para que verifique seus e-mails constantemente. <br />
Agradecemos a preferência.<br />
Atenciosamente ")).'</div>
 </font></strong><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></strong></td>
                </tr>
               
               
              </table>
          </div></td>
        </tr>
       
        <tr>
          <td colspan="3"><strong><font color="#001E5B" size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
            </font></strong></td>
        </tr>
        <tr>
          <td colspan="3" align="center"><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">www.3ecomercial.com.br - contato@3ecomercial.com.br </font></strong></td>
        </tr>
      </table></td>
  </tr>
</table>
<p>
</body>
</html>';

     $mail->MsgHTML($HTML); 
      $mail->Send();
    //caso apresente algum erro é apresentado abaixo com essa exceção.
    }catch (phpmailerException $e) {
      echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
}
				
			
	// fim Email Contato	
	
	/* .envia um email para o cliente */
	
	
	
	
	$_SESSION['sha_carrinho'] = '';
}
/* .Finaliza compra */





if (!empty($_GET['DelCart'])){
	$SQL_dados_pedido_item = "SELECT a.id_produto, a.SHA1 FROM pedido_item a WHERE a.id = :id;";
	$SQL_dados_pedido_item = $pdo->prepare($SQL_dados_pedido_item);
	$SQL_dados_pedido_item->bindValue('id',$_GET['DelCart']);
	$SQL_dados_pedido_item->execute();
	if($SQL_dados_pedido_item->rowCount() > 0){
		$row_dados_pedido_item = $SQL_dados_pedido_item->fetch();
		$id_produto = $row_dados_pedido_item->id_produto;
		$Sha1_pedido = $row_dados_pedido_item->SHA1;
		$SQL_update_produto_click = "UPDATE produto_click SET status = :status WHERE id_produto = :id_produto AND sha1 = :sha1;";
		$SQL_update_produto_click = $pdo->prepare($SQL_update_produto_click);
		$SQL_update_produto_click->bindValue('status','EXCLUIDO');
		$SQL_update_produto_click->bindValue('id_produto',$id_produto);
		$SQL_update_produto_click->bindValue('sha1',$Sha1_pedido);
		$SQL_update_produto_click->execute();
		
	}	
	$SQL_del_product = "DELETE FROM pedido_item WHERE id = :id;";
	$SQL_del_product = $pdo->prepare($SQL_del_product);
	$SQL_del_product->bindValue('id',$_GET['DelCart']);
	$SQL_del_product->execute();
	?>
<script>
			var links = '<?php echo $http."/?pg=carrinho"?>';
			window.location.href = links;
		</script>
<?php
}
if (!empty($_GET['atualizaQtde'])){
 	$SQL_update_qtde = "UPDATE pedido_item set qtde = :qtde,valor_total = :valor_total WHERE id = :id";
	$SQL_update_qtde = $pdo->prepare($SQL_update_qtde);
	$SQL_update_qtde->bindValue('qtde',$_GET['qtde']);
	$SQL_update_qtde->bindValue('valor_total',$_GET['valor']);
	$SQL_update_qtde->bindValue('id',$_GET['atualizaQtde']);
	$SQL_update_qtde->execute();
}
if(!empty($_GET['del_product'])){
	$SQL_del_product = "DELETE FROM pedido_item WHERE id = :id;";
	$SQL_del_product = $pdo->prepare($SQL_del_product);
	$SQL_del_product->bindValue('id',$_GET['del_product']);
	$SQL_del_product->execute();

	/* Atualizar o header - Leônidas Monteiro - 28/01/2020 */ 
	$SQL_atualizar_carrinho = "SELECT SUM(a.qtde) AS qtde, SUM(a.valor_total) AS  valor_total FROM pedido_item a WHERE a.SHA1 = :sha1;";
	$SQL_atualizar_carrinho = $pdo->prepare($SQL_atualizar_carrinho);
	$SQL_atualizar_carrinho->bindValue('sha1', $sha1);
	$SQL_atualizar_carrinho->execute();
	if($SQL_atualizar_carrinho->rowCount() > 0){
		$row_atualizar_carrinho = $SQL_atualizar_carrinho->fetch();
		$qtdeAtualizada = $row_atualizar_carrinho->qtde;
		$valorTotal = $row_atualizar_carrinho->valor_total;
		echo $qtdeAtualizada.'/'.$valorTotal;
	}else{
		echo '0.00'/'0.00';
	}
	/* FIM - Atualizar o header - Leônidas Monteiro - 28/01/2020 */ 
}
	






/* listar o header com os produtos - Leônidas Monteiro - 28/01/2020 */
$SQL_list_header = "SELECT a.id, a.id_produto, a.valor_unitario, a.valor_total, b.nome_produto, a.qtde, c.imagem FROM pedido_item a INNER JOIN produtos b ON a.id_produto = b.cod_produto LEFT JOIN imagens c ON a.id_produto = c.cod_produto WHERE a.SHA1 = :sha";
$SQL_list_header = $pdo->prepare($SQL_list_header);
$SQL_list_header->bindValue('sha',$sha1);
$SQL_list_header->execute();

$SQL_soma_header = "SELECT ifnull(SUM(a.valor_total),0) AS valor_total FROM pedido_item a WHERE a.SHA1 = :sha;";
$SQL_soma_header = $pdo->prepare($SQL_soma_header);
$SQL_soma_header->bindValue('sha',$sha1);
$SQL_soma_header->execute();


/* Atualizar o carrinho */
if (!empty($_GET['codCarrinho'])){
	$qtde = $_GET['qtde'];
	$valor = $_GET['valor'];
	$id = $_GET['codCarrinho'];
	$STTotal = $_GET['STTotal'];
	$SQL_del="UPDATE carrinho SET qtde = :qtde, valor_total = :valorTotal WHERE id = :id";
	$SQL_del=$pdo->prepare($SQL_del);
	$SQL_del->bindValue('qtde',$qtde);
	$SQL_del->bindValue('valorTotal',$valor);
	$SQL_del->bindValue('id',$id);
	$SQL_del->execute();	
}
/* FIM Atualizar o carrinho */



if (!empty($_GET['del'])){
	$SQL_del="DELETE FROM carrinho where id = :id";
	$SQL_del=$pdo->prepare($SQL_del);
	$SQL_del->bindValue('id',$_GET['del']);
	$SQL_del->execute();
	?>
<script type="application/javascript">
		var http = '<?php echo $http."/view/carrinho/";?>';
		window.location.href = http;
	</script>
<?php
}

if (!empty($_GET['del_Fav'])){
	$SQL_del="DELETE FROM favoritos where id = :id";
	$SQL_del=$pdo->prepare($SQL_del);
	$SQL_del->bindValue('id',$_GET['del_Fav']);
	$SQL_del->execute();
	?>
<script type="application/javascript">
		var http = '<?php echo $http."/view/lista-de-desejo/";?>';
		window.location.href = http;
	</script>
<?php
}
if(!empty($_GET['carrinhoModal'])){
	$id_produto = $_GET['carrinhoModal'];
	$cod_emp = "1";
	$sha1 = $_SESSION['sha_carrinho'];
	$valorReal = $_GET['valorReal'];
	$qtde = $_GET['qtde'];
	$valorTatal = $valorReal * $qtde;
	
	/*---------- GRAVAR O CLICK DO CLIENTE REFERENTE AO PRODUTO - LEÔNIDAS MONTEIRO - 17/09/2020 */
	  $SQL_achar_click = "SELECT id, id_produto FROM produto_click WHERE id_cliente = :id_cliente AND sha1 = :sha1 AND id_produto = :id_produto;";
	  $SQL_achar_click = $pdo->prepare($SQL_achar_click);
	  $SQL_achar_click->bindValue('id_cliente', $_SESSION['id_do_cliente']);
	  $SQL_achar_click->bindValue('sha1',$_SESSION['sha_carrinho']);
	  $SQL_achar_click->bindValue('id_produto',$id_produto);
	  $SQL_achar_click->execute();
	  if($SQL_achar_click->rowCount() > 0){
		  $row_achar_click = $SQL_achar_click->fetch();
		  $id = $row_achar_click->id;
		$SQL_click = "UPDATE produto_click SET status = :status, data_click = :data_click WHERE id = :id;";
		$SQL_click = $pdo->prepare($SQL_click);
		$SQL_click->bindValue('status','CARRINHO');
		$SQL_click->bindValue('data_click',$dataLocal);
		$SQL_click->bindValue('id',$id);
		$SQL_click->execute();   
	  }   
	/*========== GRAVAR O CLICK DO CLIENTE REFERENTE AO PRODUTO - LEÔNIDAS MONTEIRO - 17/09/2020 */
	/* verificar se tem o produto no carrinho - 27/01/2020 - Leônidas Monteiro*/
	$SQL_buscar_produto = "SELECT id FROM pedido_item WHERE SHA1 = :SHA1 AND id_produto = :id_produto;";
	$SQL_buscar_produto = $pdo->prepare($SQL_buscar_produto);
	$SQL_buscar_produto->bindValue('SHA1',$sha1);
	$SQL_buscar_produto->bindValue('id_produto',$id_produto);
	$SQL_buscar_produto->execute();
	if($SQL_buscar_produto->rowCount() > 0){
		/* Atualizar carrinho - Leônidas Monteiro */
		$rowBuscarProduto = $SQL_buscar_produto->fetch();
		$idCarrinho = $rowBuscarProduto->id;
		$SQL_edt_carrinho = "UPDATE  pedido_item SET qtde = :qtde WHERE id = :id;";
		$SQL_edt_carrinho = $pdo->prepare($SQL_edt_carrinho);
		$SQL_edt_carrinho->bindValue('qtde',$qtde);
		$SQL_edt_carrinho->bindValue('id',$idCarrinho);
		$SQL_edt_carrinho->execute();

		/* FIM Atualizar carrinho - Leônidas Monteiro */
	}else{
		/* Gravar carrinho - Leônidas Monteiro */
		$SQL_grv_carrinho = "INSERT INTO pedido_item(id_cliente,id_produto,cod_empresa,sha1,valor_unitario,valor_original,qtde,valor_total,data_cadastro)VALUES(:id_cliente,:id_produto,:cod_empresa,:sha1,:valor_unitario,:valor_original,:qtde,:valor_total,:data_cadastro);";
		$SQL_grv_carrinho = $pdo->prepare($SQL_grv_carrinho);
		$SQL_grv_carrinho->bindValue('id_cliente',$_SESSION['id_do_cliente']);
		$SQL_grv_carrinho->bindValue('id_produto',$id_produto);
		$SQL_grv_carrinho->bindValue('cod_empresa',$cod_emp);
		$SQL_grv_carrinho->bindValue('sha1',$sha1);
		$SQL_grv_carrinho->bindValue('valor_unitario',$valorReal);
		$SQL_grv_carrinho->bindValue('valor_original',$valorReal);
		$SQL_grv_carrinho->bindValue('qtde',$qtde);
		$SQL_grv_carrinho->bindValue('valor_total',$valorTatal);
		$SQL_grv_carrinho->bindValue('data_cadastro',$dataLocal);
		$SQL_grv_carrinho->execute();

		/* FIM Gravar carrinho - Leônidas Monteiro */
	}
	/* FIM verificar se tem o produto no carrinho */

	/* Atualizar o carrinho */
	$SQL_atualizar_carrinho = "SELECT SUM(a.qtde) AS qtde, SUM(a.valor_total) AS  valor_total FROM pedido_item a WHERE a.SHA1 = :sha1;";
	$SQL_atualizar_carrinho = $pdo->prepare($SQL_atualizar_carrinho);
	$SQL_atualizar_carrinho->bindValue('sha1', $sha1);
	$SQL_atualizar_carrinho->execute();
	if($SQL_atualizar_carrinho->rowCount() > 0){
		$row_atualizar_carrinho = $SQL_atualizar_carrinho->fetch();
		$qtdeAtualizada = $row_atualizar_carrinho->qtde;
		$valorTotal = $row_atualizar_carrinho->valor_total;
		echo $qtdeAtualizada.'/'.$valorTotal;
	}

	/* fim - Atualizar o carrinho */

}

if (!empty($_GET['grv'])){
	
	$sha1 = $_SESSION['sha_carrinho'];	

	$codProduto = $_POST['codProduto'];
	if (isset( $_SESSION['COD_EMPRESA_cliente'])){
	$codEmpresa = $_SESSION['COD_EMPRESA_cliente'];
	}
	$qtde = $_POST['qtde'];
	
	$_SESSION['cond_pgto'] = '2';
	$_SESSION['nome_cond_pgto'] = 'Parcelado';
	$_SESSION['forma_pgto'] = '2';
	$_SESSION['nome_forma_pgto'] = 'BOLETO';
	$valorProduto = str_replace('.','',$_POST['valorProduto']);
	$valorProduto = str_replace(',','.',$valorProduto);
	
	$ST = str_replace('.','',$_POST['ST']);
	$ST = str_replace(',','.',$ST);

	$TotalST = $ST * $qtde;
	$valorTotal = $valorProduto * $qtde;
	
	$SQL_verifica_item_carrinho = "SELECT * FROM carrinho where id_produto = :idProduto and SHA1 = :SHA and cod_empresa = :codEmpresa";
	$SQL_verifica_item_carrinho = $pdo->prepare($SQL_verifica_item_carrinho);
	$SQL_verifica_item_carrinho->bindValue('idProduto',$codProduto);
	$SQL_verifica_item_carrinho->bindValue('codEmpresa',$codEmpresa);
	$SQL_verifica_item_carrinho->bindValue('SHA',$sha1);
	$SQL_verifica_item_carrinho->execute();
	$row_verifica_item_carrinho = $SQL_verifica_item_carrinho->fetch();
	
	if(!empty($row_verifica_item_carrinho->id_produto)){ ?>
<script type="application/javascript">
		alert ('Item ja adicionado ao carrinho');
			var http = '<?php echo $http."/view/carrinho/";?>';
			window.location.href = http;
		</script>
<?php    
	}else{
		

	$SQL_insert_carrinho = "INSERT INTO carrinho(id_produto,id_cliente,cod_empresa,SHA1,valor_unitario,st_unitario,qtde,valor_total,st_total,data_cadastro)VALUES(:idProduto,:id_cliente,:codEmpresa,:SHA,:valorUnitario,:STUnitario,:qtde,:valorTotal,:STTotal,:dataCadastro)";
	$SQL_insert_carrinho = $pdo->prepare($SQL_insert_carrinho);
	$SQL_insert_carrinho->bindValue('idProduto',$codProduto);
	$SQL_insert_carrinho->bindValue('id_cliente',$_SESSION['id_do_cliente']);
	$SQL_insert_carrinho->bindValue('codEmpresa',$codEmpresa);
	$SQL_insert_carrinho->bindValue('SHA',$_SESSION['sha_carrinho']);
	$SQL_insert_carrinho->bindValue('valorUnitario',$valorProduto);
	$SQL_insert_carrinho->bindValue('STUnitario',$ST);
	$SQL_insert_carrinho->bindValue('qtde',$qtde);
	$SQL_insert_carrinho->bindValue('valorTotal',$valorTotal);
	$SQL_insert_carrinho->bindValue('STTotal',$TotalST);
	$SQL_insert_carrinho->bindValue('dataCadastro',$dataLocal);
	$SQL_insert_carrinho->execute();
	if ($SQL_insert_carrinho){
		$acao = "NSERT INTO carrinho(id_produto,cod_empresa,SHA1,valor_unitario,st_unitario,qtde,valor_total,st_total,data_cadastro)VALUES(".$codProduto.",".$codEmpresa.",".$sha1.",".$valorProduto.",".$ST.",".$qtde.",".$valorTotal.",".$TotalST.",".$dataLocal;
		$IP = $_SERVER['REMOTE_ADDR'];
		$descricao = "Cliente: ".$_SESSION['nome_do_cliente'].", adicionou o produto: ".$codProduto.", no carrinho!";
		$usuario = $_SESSION['id_do_cliente'];
		$origem = $_SERVER['HTTP_REFERER'];
		$SQL_insert_log = "INSERT INTO logs(cod_empresa,datahora,acao,IP,descricao,usuario,origem)VALUES(:codempresa,:datahora,:acao,:IP,:descricao,:usuario,:origem)";
		$SQL_insert_log = $pdo->prepare($SQL_insert_log);
		$SQL_insert_log->bindValue('codempresa',$codEmpresa);
		$SQL_insert_log->bindValue('datahora',$dataLocal);
		$SQL_insert_log->bindValue('acao',$acao);
		$SQL_insert_log->bindValue('IP',$IP);
		$SQL_insert_log->bindValue('descricao',$descricao);
		$SQL_insert_log->bindValue('usuario',$usuario);
		$SQL_insert_log->bindValue('origem',$origem);
		$SQL_insert_log->execute();
		
		?>
<script type="application/javascript">
			var http = '<?php echo $http."/view/carrinho/";?>';
			window.location.href = http;
		</script>
<?php
				
	}else{
		$acao = "NSERT INTO carrinho(id_produto,cod_empresa,SHA1,valor_unitario,st_unitario,qtde,valor_total,st_total,data_cadastro)VALUES(".$codProduto.",".$codEmpresa.",".$sha1.",".$valorProduto.",".$ST.",".$qtde.",".$valorTotal.",".$TotalST.",".$dataLocal;
		$IP = $_SERVER['REMOTE_ADDR'];
		$descricao = "Cliente: ".$_SESSION['nome_do_cliente'].", intencionou inserir o produto: ".$codProduto.", no carrinho!";
		$usuario = $_SESSION['id_do_cliente'];
		$origem = $_SERVER['HTTP_REFERER'];
		$SQL_insert_log = "INSERT INTO logs(cod_empresa,datahora,acao,IP,descricao,usuario,origem)VALUES(:codempresa,:datahora,:acao,:IP,:descricao,:usuario,:origem)";
		$SQL_insert_log = $pdo->prepare($SQL_insert_log);

		$SQL_insert_log->bindValue('codempresa',$codEmpresa);
		$SQL_insert_log->bindValue('datahora',$dataLocal);
		$SQL_insert_log->bindValue('acao',$acao);
		$SQL_insert_log->bindValue('IP',$IP);
		$SQL_insert_log->bindValue('descricao',$descricao);
		$SQL_insert_log->bindValue('usuario',$usuario);
		$SQL_insert_log->bindValue('origem',$origem);
		$SQL_insert_log->execute();
		
		?>
<script type="application/javascript">
			var http = '<?php echo $http."/view/carrinho/";?>';
			window.location.href = http;
		</script>
<?php
		
	}
		}//if verifica item carrinho
	
}
/* Listar os produtos no Carrinho - Leônidas Monteiro - 28/01/2020 */
	if(!empty($_SESSION['sha_carrinho'])){
		$SQL_list_cart = "SELECT a.id,d.estoque_disponivel, a.id_produto,d.minimo_produto_venda, b.nome_produto,a.qtde, a.valor_unitario, a.valor_total, IFNULL(c.imagem,'ImagemNaoDisponivel.png') AS imagem FROM pedido_item a
INNER JOIN produtos b ON a.id_produto = b.cod_produto
LEFT JOIN imagens c ON a.id_produto = c.cod_produto
LEFT JOIN produtos_empresa d ON a.id_produto = d.cod_produto AND a.cod_empresa = d.cod_empresa
	WHERE a.SHA1 = :sha;";
		$SQL_list_cart = $pdo->prepare($SQL_list_cart);
		$SQL_list_cart->bindValue('sha',$_SESSION['sha_carrinho']);
		$SQL_list_cart->execute();
		
		/* resultado do carrinho */
		$SQL_resultadoCart = "SELECT SUM(a.valor_total) as valortotal, SUM(a.qtde) AS itens, (a.valor_unitario * a.qtde) AS total FROM pedido_item a WHERE a.SHA1 = :sha1;";
		$SQL_resultadoCart = $pdo->prepare($SQL_resultadoCart);
		$SQL_resultadoCart->bindValue('sha1',$_SESSION['sha_carrinho']);
		$SQL_resultadoCart->execute();

	}
/* FIM - Listar os produtos no Carrinho - Leônidas Monteiro - 28/01/2020 */






if (!empty($_SESSION['sha_carrinho']) && empty($_GET['carrinho'])){
	$sha1 = $_SESSION['sha_carrinho'];
	if(!empty($_SESSION['COD_EMPRESA_cliente'])){
		$codEmpresa =  $_SESSION['COD_EMPRESA_cliente'];
	}else{
		$codEmpresa =  1;
	}


	
	$SQL_listar_carrinho = "SELECT d.minimo_produto_venda, a.id, a.id_produto, b.nome_produto, a.valor_unitario, a.st_unitario, a.qtde, a.valor_total,a.st_total, ifnull(c.imagem,'no-photo.png') as imagem FROM carrinho a INNER JOIN produtos b ON a.id_produto = b.cod_produto 
LEFT JOIN imagens c ON a.id_produto = c.cod_produto
INNER JOIN produtos_empresa d ON a.id_produto = d.cod_produto  AND d.cod_empresa = :cod_empresa
where a.SHA1 = :sha GROUP BY b.nome_produto";
	$SQL_listar_carrinho = $pdo->prepare($SQL_listar_carrinho);
	$SQL_listar_carrinho->bindValue('cod_empresa',$codEmpresa);
	$SQL_listar_carrinho->bindValue('sha',$sha1);	
	$SQL_listar_carrinho->execute();
	
	$SQL_listar_carrinho_header = "SELECT a.id, a.id_produto, b.nome_produto,a.qtde, a.valor_unitario, a.valor_total, IFNULL(c.imagem,'ImagemNaoDisponivel.png') AS imagem FROM pedido_item a
INNER JOIN produtos b ON a.id_produto = b.cod_produto
LEFT JOIN imagens c ON a.id_produto = c.cod_produto
 WHERE a.cod_empresa = :cod_empresa and a.SHA1 = :sha";
	$SQL_listar_carrinho_header = $pdo->prepare($SQL_listar_carrinho_header);
	$SQL_listar_carrinho_header->bindValue('cod_empresa',$codEmpresa);
	$SQL_listar_carrinho_header->bindValue('sha',$sha1);	
	$SQL_listar_carrinho_header->execute();
	/* LISTA DE DESEJOS */
	
	
		if (isset($_SESSION['COD_EMPRESA_cliente'])){
			if(!empty($_SESSION['id_do_cliente'])){
		$codEmpresa =  $_SESSION['COD_EMPRESA_cliente'];
		$idCliente = $_SESSION['id_do_cliente'];
		$SQL_lista_desejos = "SELECT b.id, a.cod_produto, a.nome_produto, c.valor_prazo, ifnull(d.imagem,'no-photo.png') AS imagem
 FROM produtos a 
INNER JOIN favoritos b ON a.cod_produto = b.cod_produto 
INNER JOIN produtos_empresa c ON a.cod_produto = c.cod_produto
LEFT JOIN imagens d ON d.cod_produto = c.cod_produto
WHERE b.cod_empresa = :codEmpresa AND b.id_cliente = :idCliente
GROUP BY a.cod_produto";
		$SQL_lista_desejos = $pdo->prepare($SQL_lista_desejos);
		$SQL_lista_desejos->bindValue('codEmpresa',$codEmpresa);
		$SQL_lista_desejos->bindValue('idCliente',$idCliente);
		$SQL_lista_desejos->execute();
		}}
	/* FIM LISTA DE DESEJOS */
	/* somar total e itens */ 
	$SQL_totalCarrinho = " SELECT SUM(a.valor_total) as valortotal, SUM(a.qtde) AS itens FROM pedido_item a WHERE a.SHA1 = :sha";
	$SQL_totalCarrinho = $pdo->prepare($SQL_totalCarrinho);
	$SQL_totalCarrinho->bindValue('sha',$sha1);
	$SQL_totalCarrinho->execute();
	if($SQL_totalCarrinho->rowCount() > 0){
		$row_totalCarrinho = $SQL_totalCarrinho->fetch();
		$valorTotalCarrinho = $row_totalCarrinho->valortotal;
		$itemTotalCarrinho = intval($row_totalCarrinho->itens);
	}else{
		$valorTotalCarrinho = 0;
		$itemTotalCarrinho = 0;
		$totais = 0;
	}
}


$mostrar = 'S';
	$sql_condpgto = $pdo->prepare("SELECT * from condicaopagamento where COD_EMPRESA = :cod_empresa and MOSTRAR_SITE = :mostrar and cod_cond_pgto not in (:cod_cond_pgto)");
	$sql_condpgto->bindValue('cod_empresa', $_SESSION['COD_EMPRESA_cliente']);
	$sql_condpgto->bindValue('mostrar', $mostrar);
	$sql_condpgto->bindValue('cod_cond_pgto', $_SESSION['cond_pgto']);
	$sql_condpgto->execute();
	
	$_SESSION['forma_pgto'] = '1';
	$sql_formapgto = $pdo->prepare("SELECT * from formapagamento where COD_EMPRESA = :cod_empresa and MOSTRAR_SITE = :mostrar and COD_FORMA_PGTO not in (:COD_FORMA_PGTO)");
	$sql_formapgto->bindValue('cod_empresa', $_SESSION['COD_EMPRESA_cliente']);
	$sql_formapgto->bindValue('mostrar', $mostrar);
	$sql_formapgto->bindValue('COD_FORMA_PGTO', $_SESSION['forma_pgto']);
	$sql_formapgto->execute();
	
	
	
	
	/* FINALIZAR CARRINHO */
		if (!empty($_GET['carrinho'])){
			
	
				//echo 'id do Cliente: '.$_SESSION['id_do_cliente'];
				//echo '<BR/>sha1: '.$_SESSION['sha_carrinho'];
				$SQL_qtde_vlr_carrinho = "SELECT SUM(a.qtde) AS itens, SUM(a.valor_total) AS valorTotal FROM carrinho a WHERE a.SHA1 = :sha";
				$SQL_qtde_vlr_carrinho = $pdo->prepare($SQL_qtde_vlr_carrinho);
				$SQL_qtde_vlr_carrinho->bindValue('sha',$_GET['carrinho']);
				$SQL_qtde_vlr_carrinho->execute();
				if ($SQL_qtde_vlr_carrinho->rowCount() > 0){
					$row_qtde_carrinho = $SQL_qtde_vlr_carrinho->fetch();
					$itens = $row_qtde_carrinho->itens;
					$valorTotalCarrinho = $row_qtde_carrinho->valorTotal;	
					
					$valorTotalFinanceiro = $valorTotalCarrinho * $pct_desp_financ;
				}
				
				$sql_forma_pagamento = $pdo->prepare("SELECT * FROM formapagamento WHERE NOME_FORMA_PGTO = :NOME_FORMA_PGTO and COD_EMPRESA = :cod_empresa");
				$sql_forma_pagamento->bindValue('NOME_FORMA_PGTO','BOLETO');
				$sql_forma_pagamento->bindValue('cod_empresa', $_SESSION['COD_EMPRESA_cliente']);
				$sql_forma_pagamento->execute();
				$forma_pagamento = $sql_forma_pagamento->fetch();
				$cod_forma_pgto = $forma_pagamento->COD_FORMA_PGTO;
				
				
				//echo '<br> '.$cod_cond_pgto; 
				//echo '<br> '.$cod_forma_pgto;
				
				
				$sha1 = $_SESSION['sha_carrinho'];
				$SQL_listar_itens = "SELECT id_produto, cod_empresa, SHA1, valor_unitario,st_unitario,qtde,valor_total,st_total,data_cadastro FROM carrinho WHERE SHA1=:sha1";
				$SQL_listar_itens = $pdo->prepare($SQL_listar_itens);
				$SQL_listar_itens->bindValue('sha1',$sha1);	
				$SQL_listar_itens->execute();
				
				//inicio while
				while($itens = $SQL_listar_itens->fetch()){
					
				if($pct_desp_financ > 1){
					$desconto = '0.00';
					$UnitarioAtualizado = $itens->valor_unitario * $pct_desp_financ;
					$valor_extra = $UnitarioAtualizado - $itens->valor_unitario;
					$ValorTotal = $itens->valor_total * $pct_desp_financ;
				}else{
					if($pct_desp_financ < 1){
						$UnitarioAtualizado = $itens->valor_unitario * $pct_desp_financ;
						$desconto = $itens->valor_unitario - $UnitarioAtualizado;
						$valor_extra = '0.00';
						$ValorTotal = $itens->valor_total * $pct_desp_financ;
					}else{
						if($pct_desp_financ == 1){
						$desconto = '0.00';
						$UnitarioAtualizado = $itens->valor_unitario ;
						$valor_extra = '0.00';
						$ValorTotal = $itens->valor_total * $pct_desp_financ;
						}
					}
				}
				$DescontoTotal = $DescontoTotal + ($desconto * $itens->qtde);
				$ValorExtraTotal = $ValorExtraTotal + ($valor_extra * $itens->qtde);
					//insere os itens na tabela pedido item 
				$SQL_insert_pedido_item = "INSERT INTO pedido_item(id_produto,cod_empresa,SHA1,valor_unitario,st_unitario,valor_original,qtde,desconto,valor_extra,valor_total,st_total,data_cadastro)VALUES(:idProduto,:codEmpresa,
				:SHA,:valorUnitario,:STUnitario,:valorOriginal,:qtde,:desconto,:valorExtra,:valorTotal,:STTotal,:dataCadastro)";
				$insert_pedido_item = $pdo->prepare($SQL_insert_pedido_item);
				$insert_pedido_item->bindValue('idProduto',$itens->id_produto);
				$insert_pedido_item->bindValue('codEmpresa',$itens->cod_empresa);
				$insert_pedido_item->bindValue('SHA',$sha1);
				$insert_pedido_item->bindValue('valorUnitario',$UnitarioAtualizado);
				$insert_pedido_item->bindValue('STUnitario',$itens->st_unitario);
				$insert_pedido_item->bindValue('valorOriginal',$itens->valor_unitario);
				$insert_pedido_item->bindValue('qtde',$itens->qtde);
				$insert_pedido_item->bindValue('desconto',$desconto);
				$insert_pedido_item->bindValue('valorExtra',$valor_extra);
				$insert_pedido_item->bindValue('valorTotal',$ValorTotal);
				$insert_pedido_item->bindValue('STTotal',$itens->st_total);
				$insert_pedido_item->bindValue('dataCadastro',$itens->data_cadastro);
				$insert_pedido_item->execute();	
				
				}
				
				//deleta os itens da tabela carrinho
				$SQL_delete_carrinho = "delete from carrinho where sha1 = :sha1";
				$delete_carrinho = $pdo->prepare($SQL_delete_carrinho);
				$delete_carrinho->bindValue('sha1',$sha1);
				$delete_carrinho->execute();	
				
				//insee o pedido
				$origem_pedido= '1';
				$SQL_insert_pedido = "INSERT INTO pedidos(cod_empresa,id_cliente,SHA1,status,valor_produtos,valor_total,desconto,valor_extra,itens,data_pedido,origem_pedido, cod_cond_pgto, cod_forma_pgto,tipo_pedido)VALUE(:cod_empresa,:idcliente,:sha,:status,:valorproduto,:valortotal,:desconto,:valorExtra,:itens,:datapedido,:origem_pedido,:cod_cond_pgto,:cod_forma_pgto,:tipo_pedido)";
				$SQL_insert_pedido = $pdo->prepare($SQL_insert_pedido);
				$SQL_insert_pedido->bindValue('cod_empresa',$_SESSION['COD_EMPRESA_cliente']);
				$SQL_insert_pedido->bindValue('idcliente',$_SESSION['id_do_cliente']);
				$SQL_insert_pedido->bindValue('sha',$_SESSION['sha_carrinho']);
				$SQL_insert_pedido->bindValue('status','AGUARDANDO');
				$SQL_insert_pedido->bindValue('valorproduto',$valorTotalCarrinho);
				$SQL_insert_pedido->bindValue('valortotal',$valorTotalFinanceiro);
				$SQL_insert_pedido->bindValue('desconto',$DescontoTotal);
				$SQL_insert_pedido->bindValue('valorExtra',$ValorExtraTotal);
				$SQL_insert_pedido->bindValue('itens',$itens);
				$SQL_insert_pedido->bindValue('datapedido',$dataLocal);
				$SQL_insert_pedido->bindValue('origem_pedido',$origem_pedido);	
				$SQL_insert_pedido->bindValue('cod_cond_pgto',$_SESSION['cond_pgto']);
				$SQL_insert_pedido->bindValue('cod_forma_pgto',$cod_forma_pgto);
				$SQL_insert_pedido->bindValue('tipo_pedido','1');
				$SQL_insert_pedido->execute();
				//echo '<br> '.$cod_cond_pgto; 
				//echo '<br> '.$cod_forma_pgto;
				if ($SQL_insert_pedido){
					
				$sql_pedido = $pdo->prepare("SELECT T1.id, T1.SHA1, T1.id_cliente, T1.status, T1.valor_produtos, T1.valor_frete, T1.valor_total, T1.itens, T1.cod_cond_pgto, T1.cod_forma_pgto, T2.NOME_COND_PGTO, T3.NOME_FORMA_PGTO, T4.RAZ_SOCIAL, T4.MAIL_CONTATO, T4.COD_EMPRESA,T4.COD_CIDADE,T4.COD_UF,T4.COD_EQUIP_VENDA, T4.EMAIL_NFE
				FROM pedidos T1 
				left join condicaopagamento T2 on
				T1.cod_cond_pgto = T2.COD_COND_PGTO and
				T1.cod_empresa = T2.COD_EMPRESA
				left join formapagamento T3 on
				T1.cod_forma_pgto = T3.COD_FORMA_PGTO and
				T1.cod_empresa = T3.COD_EMPRESA
				left join cliente T4 on
				T1.id_cliente = T4.COD_CLIENTE
				WHERE T1.SHA1  = :SHA1");
				$sql_pedido->bindValue('SHA1',$_SESSION['sha_carrinho']);
				$sql_pedido->execute();
				$row_pedido = $sql_pedido->fetch();
				$num_pedido = $row_pedido->id;
				$nome_cliente = $row_pedido->RAZ_SOCIAL;
				$email_contato = $row_pedido->MAIL_CONTATO;
				
				
				$email_nfe = $row_pedido->EMAIL_NFE;
				$valor_total = $row_pedido->valor_total;
				$empresa_cliente = $row_pedido->COD_EMPRESA;
				$cidade = $row_pedido->COD_CIDADE;
				$uf =$row_pedido->COD_UF;
				
				//$SHA1 = $row_pedido->SHA1;
			//	echo '<br> '.$SHA1;
					
						
			require_once("../../PHPMailer/PHPMailerAutoload.php");

			$sql_parametros_email = "SELECT * FROM parametros_email where descricao like 'FALE_CONOSCO' and status = 'ATIVO'";
			$sql_parametros_email = $pdo->prepare($sql_parametros_email);
			$sql_parametros_email->execute();
			$row_parametros_email = $sql_parametros_email->fetch();
			
			$sql_parametros_email_envio = "SELECT * FROM parametros_envio_email where status = 'ATIVO'";
			$sql_parametros_email_envio = $pdo->prepare($sql_parametros_email_envio);
			$sql_parametros_email_envio->execute();
			$row_parametros_email_envio = $sql_parametros_email_envio->fetch();

			$sql_parametros_email_copia = "SELECT * FROM parametros_email where status = 'ATIVO' AND descricao like 'VENDAS_COPIA'";
			$sql_parametros_email_copia = $pdo->prepare($sql_parametros_email_copia);
			$sql_parametros_email_copia->execute();
			
			
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
	$mail->AddReplyTo('leonidas@lcmaxsolution.com.br', $NomeEmpresa); //Seu e-mail
	$mail->Subject = utf8_decode(htmlspecialchars_decode("Pedido de Compra"));//Assunto do e-mail


	//Define os destinatário(s)
	//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	//$mail->AddAddress('huma@humatransportes.com.br', utf8_decode(htmlspecialchars_decode("Orçamento")));
	$mail->AddAddress($row_parametros_email->email, utf8_decode(htmlspecialchars_decode($NomeEmpresa)));

	//Campos abaixo são opcionais 
	//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
	while ($row_parametros_email_copia = $sql_parametros_email_copia->fetch()){
		$mail->AddCC($row_parametros_email_copia->email);
	}
	  /*$mail->AddCC('foxs.sbc11@gmail.com'); // Copia
	  $mail->AddBCC('leonardo@lcmaxsolution.com.br'); // Cópia Oculta*/
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
          
          <td width="151" align="center" bgcolor="#FFFFFF"><img src="'.$http.'/Painel/imagens/logo/'.$LogoEmpresa.'" width="100"></td>
          <td width="852" align="center" bgcolor="#FFFFFF"><strong><font color="#000000" size="15" face="Verdana, Arial, Helvetica, sans-serif">Pedido de Compra '.$num_pedido.'</font></strong></td>
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
                  <td height="33"><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">'.utf8_decode(htmlspecialchars_decode($nome_cliente . " - " .$cidade . "-" .$uf . ", você acabou de efetuar sua(as) compra(as) em nosso site. Gostariamos de agradecer a confiança depositada em nossa empresa")).' </font></strong></td>
                </tr>
                <tr>
                
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">O numero do seu pedido'.utf8_decode(htmlspecialchars_decode(" é:")).' <h1 style="color:#F00" align="center">'.$num_pedido.'</h1>  </font></strong>
                </tr>
                <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">
				 <div align="center">
				   <h2>Produtos do Pedido</h2>
      
      <table class="">
	  ';
	 	 if($uf == 'MG'){ 
	  $HTML.='
	  <thead>
          <tr style="font-size:11px; line-height:20px; color:#999999; background:#33346E">
            <td style="text-align:center">CÓD. PRODUTO</td>
            <td>PRODUTO</td>
            <td style="text-align:center">VALOR PRODUTOS</td>
			<td style="text-align:center">ST UNIT.</td>
            <td style="text-align:center">QTDE</td>
            <td style="text-align:center">TOTAL PROD.</td>
			<td style="text-align:center">TOTAL ST</td>
			<td style="text-align:center">VALOR TOTAL</td>
			
          </tr>
  		</thead>';
		 }else{
		$HTML.='
		<thead>
          <tr style="font-size:11px; line-height:20px; color:#999999; background:#33346E">
            <td style="text-align:center">CÓD. PRODUTO</td>
            <td>PRODUTO</td>
            <td style="text-align:center">VALOR PRODUTOS</td>
            <td style="text-align:center">QTDE</td>
            <td style="text-align:center">VALOR TOTAL</td>
          </tr>
  		</thead>
  		';	 
		 }
	$count = 1 ;
	
$SQL_listar_pedido_item = $pdo->prepare("select T1.id_produto,T1.cod_empresa, T2.nome_produto, T1.valor_unitario, T1.st_unitario, T1.qtde, (T1.valor_unitario * T1.qtde) as valor_total, st_total 
from pedido_item T1
left join produtos T2 on
T1.id_produto = T2.cod_produto
 WHERE T1.SHA1 = :sha group by T2.cod_produto");
$SQL_listar_pedido_item->bindValue('sha',$_SESSION['sha_carrinho']);
$SQL_listar_pedido_item->execute();

	 while ($row_listar_pedido_item = $SQL_listar_pedido_item->fetch()){ 
	 	if($uf == 'MG'){ 
		$ValorTotal = $row_listar_pedido_item->valor_total + $row_listar_pedido_item->st_total;
  $HTML.='
  <tr>
  <td style="text-align:center">'. $row_listar_pedido_item->id_produto .'</td>
    <td>'. $row_listar_pedido_item->nome_produto .'</td>
    <td style="text-align:center">'.number_format($row_listar_pedido_item->valor_unitario,2,',','.').'</td>
	<td style="text-align:center">'.number_format($row_listar_pedido_item->st_unitario,2,',','.').'</td>
    <td style="text-align:center">'.$row_listar_pedido_item->qtde.'</td>
    <td style="text-align:center">'.number_format($row_listar_pedido_item->valor_total,2,',','.').'</td>
	<td style="text-align:center">'.number_format($row_listar_pedido_item->st_total,2,',','.').'</td>
	<td style="text-align:center">'.number_format($ValorTotal,2,',','.').'</td>
  </tr>';
		}else{
			
			$HTML.='
  <tr>
    <td style="text-align:center">'. $row_listar_pedido_item->id_produto .'</td>
    <td>'. $row_listar_pedido_item->nome_produto .'</td>
    <td style="text-align:center">'.number_format($row_listar_pedido_item->valor_unitario,2,',','.').'</td>
    <td style="text-align:center">'.$row_listar_pedido_item->qtde.'</td>
    <td style="text-align:center">'.number_format($row_listar_pedido_item->valor_total,2,',','.').'</td>
  </tr>';
		}
  }
  $HTML.=' 
</table>
				</div>
				  </font></strong></td>
                </tr>
                <tr>
                  <td><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">
                  <br />
				  
				   <div align="center"> Valor Total do Pedido: R$ '.$valor_total.' </div>
				  
				  <br />
                  <div align="center">'.utf8_decode(htmlspecialchars_decode("Informamos que para sua segurança, todos os pedidos estão sujeitos à análise e confirmação dos dados por telefone. <br />
A cada passo de produção, nossa loja o manterá informado através do seu e-mail. Pedimos para que verifique seus e-mails constantemente. <br />
Agradecemos a preferência.<br />
Atenciosamente ")).'</div>
 </font></strong><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></strong></td>
                </tr>
               
               
              </table>
          </div></td>
        </tr>
       
        <tr>
          <td colspan="3"><strong><font color="#001E5B" size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
            </font></strong></td>
        </tr>
        <tr>
          <td colspan="3" align="center"><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">www.3ecomercial.com.br - contato@3ecomercial.com.br </font></strong></td>
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
					
					
					$SQL_gravar_log= "insert into logs(cod_empresa,datahora,acao,IP,descricao,usuario,origem)values(
						:codEmpresa,
						:datahora,
						:acao,
						:IP,
						:descricao,
						:usuario,
						:origem)";
					$descricao = "NSERT INTO pedidos(id_cliente,SHA1,status,valor_produtos,valor_total,itens,data_pedido)VALUE(".$_SESSION['id_do_cliente'].",".$_SESSION['sha_carrinho'].",AGUARDANDO".$valorTotalCarrinho.",".$valorTotalCarrinho.",".$itens.",".$dataLocal;
					$gravar_log = $pdo->prepare($SQL_gravar_log);
					$gravar_log->bindValue('codEmpresa',$_SESSION['COD_EMPRESA_cliente']);
					$gravar_log->bindValue('datahora',$dataLocal);
					$gravar_log->bindValue('acao','CLIENTE: '.$_SESSION['id_do_cliente'].' REALIZOU UM PEDIDO:');
					$gravar_log->bindValue('IP',$_SERVER['SERVER_ADDR']);
					$gravar_log->bindValue('descricao',$descricao);
					$gravar_log->bindValue('usuario',$_SESSION['id_do_cliente']);
					$gravar_log->bindValue('origem',$_SERVER['HTTP_REFERER']);
					$gravar_log->execute();
					
					$SHA_VENDA = $_SESSION['sha_carrinho'];
					?>
<script type="application/javascript">
			var http = '<?php echo $http;?>/view/finalizar?SHA_VENDA=<?php echo $SHA_VENDA; ?>';
			window.location.href = http;
		</script>
<?php
					
					
					}
				//$_SESSION['sha_carrinho'] = '';
				
		}
		
	/* FIM FINALIZAR CARRINHO */
?>