<?php

include "../src/conecta.php";
include "../src/setup.php";



$buscaDadosFunc = "
SELECT
  VEIC.PREFIXOVEIC
FROM
  FRT_CADVEICULOS VEIC 
WHERE
  VEIC.CODIGOEMPRESA = 1 AND
  VEIC.CONDICAOVEIC = 'A'

";	
	
	$buscaDadosFunc = ociparse($ora_conecta,$buscaDadosFunc) or die("Erro");
	ociexecute($buscaDadosFunc,OCI_DEFAULT);
	
	
	while (ocifetch($buscaDadosFunc)) {

        $prefixoveic =       ociresult($buscaDadosFunc,"PREFIXOVEIC");
        
   
            $pesquisa_mysql = mysql_query("
            SELECT COUNT(*) FROM VEICULOS WHERE PREFIXOVEIC = '$prefixoveic'            
            ");
            if (!$pesquisa_mysql) print mysql_error();
            $pesquisa_mysql = mysql_result($pesquisa_mysql,0);
            
            if ($pesquisa_mysql == 0 ) {

                  $insere_mysql = mysql_query("
                  INSERT INTO VEICULOS(PREFIXOVEIC) 
                  VALUES
                  ('$prefixoveic')
                  ");
                  if (!$insere_mysql) {
                    print "Erro ao inserir no Mysql: " . mysql_error();
                  } else {
                    print "Prefixo: " . $prefixoveic . " inserido com sucesso! \n";
		    
		    
            } } else {

		print "Prefixo $prefixoveic ja esta cadastrado. \n";

		$atualizaFunc = mysql_query("UPDATE VEICULOS SET PREFIXOVEIC='$prefixoveic'");
		print "PREFIXO: " . $prefixoveic . " atualizado com sucesso! \n";

		
		if (!$atualizaFunc) {
		  print "Erro ao atualizar." . mysql_error() . "\n";
		  
		}
              



            }

            

        
    }


    // registra no log.
    $dataLOG = date("Y-m-d H:i:s");
    $registraLOG = mysql_query("
    INSERT INTO LOG(USUARIO,IP,ACAO,DATA) VALUES ('SISTEMA','0.0.0.0','IMPORTACAO GLOBUS - VEICULOS','$dataLOG')
   ");

    $registraLOG_importacao = mysql_query("INSERT INTO LOG_IMPORTACAO(DATALOG) VALUES ('$dataLOG')");

    if (!$registraLOG) { 
      print mysql_error(); 
      exit();
    }

    // log


?>         
