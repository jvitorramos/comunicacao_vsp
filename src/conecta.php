<?php

$ora_user = "globus"; //USUÁRIO 
$ora_senha = "globusxkvm9kycp7"; //SENHA
$ora_SID   = "GLOBUSSERVER";
$ora_conecta = oci_connect($ora_user,$ora_senha,$ora_SID);


if(!$ora_conecta) {
	
	echo "ERRO !! Por favor, verifique se o usuário e a senha estão digitados corretamente!";

	} else {
	
		/*print "<img src='img\conected.gif' alt='Ok' width='10px' height='20px'>";
		print "<b>SYSOK</b> <img src='/images/conected.gif' width='15px' height='15px'><br><br>";
	*/
		
	
	}
?>

	
