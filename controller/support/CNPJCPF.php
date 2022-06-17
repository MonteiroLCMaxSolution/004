<?PHP
session_start();

// Função para validar CPF
function valida_cpf( $cpf = false ) {
    if ( ! function_exists('calc_digitos_posicoes') ) {
        function calc_digitos_posicoes( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
            for ( $i = 0; $i < strlen( $digitos ); $i++  ) {
                $soma_digitos = $soma_digitos + ( $digitos[$i] * $posicoes );
                $posicoes--;
            }
            $soma_digitos = $soma_digitos % 11;
            if ( $soma_digitos < 2 ) {
                $soma_digitos = 0;
            } else {
                $soma_digitos = 11 - $soma_digitos;
            }
            $cpf = $digitos . $soma_digitos;
            return $cpf;
        }
    }
    if ( ! $cpf ) {
        return false;
    }
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
    if ( strlen( $cpf ) != 11 ) {
        return false;
    }   
    $digitos = substr($cpf, 0, 9);
    $novo_cpf = calc_digitos_posicoes( $digitos );
    $novo_cpf = calc_digitos_posicoes( $novo_cpf, 11 );
    if ( $novo_cpf === $cpf ) {
        return true;
    } else {
        return false;
    }
}
function validar_cnpj($cnpj)
{
	$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
	// Valida tamanho
	if (strlen($cnpj) != 14)
		return false;
	// Valida primeiro dígito verificador
	for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
		return false;
	// Valida segundo dígito verificador
	for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
}

if (!empty($_GET['CPF'])){
	
	if ( valida_cpf( $_GET['validarCPFCliente'] ) ) {
		echo '<span style="color:#060">CPF Válido</span>';
		$resultCPF = '<span style="color:#060">CPF Válido</span>';
	}else{
		echo '<span style="color:#F00">CPF inválido</span>';
		$resultCPF = '<span style="color:#F00">CPF inválido</span>';
	}
}

if (!empty($_GET['CNPJ'])){
	
	if ( validar_cnpj( $_GET['CNPJ'] ) ) {
		echo '<span style="color:#060">CNPJ Válido</span>';
		$resultCPF = '<span style="color:#060">CNPJ Válido</span>';
	}else{
		echo '<span style="color:#F00">CNPJ Inválido</span>';
		$resultCPF = '<span style="color:#F00">CNPJ Inválido</span>';
	}
}

?>