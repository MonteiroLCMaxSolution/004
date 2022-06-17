<?php 
	include '../../model/cidade-estado/cidade.php';

	/*
	if($lista_cidade->rowCount() > 0){
		$row = $lista_estado->fetch();
		echo $row->id;
		$iii = 18;
	}else{
		echo 'não achou';
		$iii = 'não achou'.idestado;
	}
	*/	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body><label>Cidade</label>
      <select name="cidade" id="cidade" class="form-control" required="required">
        <option value=""></option>
        <?php
		while ($row = $lista_cidade->fetch()){?>
        <option value="<?php echo $row->id;?>"><?php echo $row->nome;?></option>
        <?php } ?>
      </select>
</body>
</html>