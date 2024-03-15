<?php

include "../src/conecta.php";
include "../src/setup.php";



$buscaDadosFunc = "
SELECT
  LIN.CODIGOLINHA, 
  LIN.NOMELINHA
FROM
  BGM_CADLINHAS LIN
WHERE
  LIN.CODIGOEMPRESA = 1
";	
	
	$buscaDadosFunc = ociparse($ora_conecta,$buscaDadosFunc) or die("Erro");
	ociexecute($buscaDadosFunc,OCI_DEFAULT);
	
	
	while (ocifetch($buscaDadosFunc)) {

        $codigolinha    =       ociresult($buscaDadosFunc,"CODIGOLINHA");
        $nomelinha      =       ociresult($buscaDadosFunc,"NOMELINHA");
        
   
            $pesquisa_mysql = mysql_query("
            SELECT COUNT(*) FROM LINHAS WHERE CODIGOLINHA = '$codigolinha'
            ");
            if (!$pesquisa_mysql) print mysql_error();
            $pesquisa_mysql = mysql_result($pesquisa_mysql,0);
            
            if ($pesquisa_mysql == 0 ) {

                  $insere_mysql = mysql_query("
                  INSERT INTO LINHAS(CODIGOLINHA,NOMELINHA) 
                  VALUES
                  ('$codigolinha','$nomelinha')
                  ");
                  if (!$insere_mysql) {
                    print "Erro ao inserir no Mysql: " . mysql_error();
                  } else {
                    print "Linha: " . $codigolinha . " inserido com sucesso! \n";
		        } }            

        
             }


    // registra no log.
    $dataLOG = date("Y-m-d H:i:s");
    $registraLOG = mysql_query("
    INSERT INTO LOG(USUARIO,IP,ACAO,DATA) VALUES ('SISTEMA','0.0.0.0','IMPORTACAO GLOBUS - LINHAS','$dataLOG')
   ");

    $registraLOG_importacao = mysql_query("INSERT INTO LOG_IMPORTACAO(DATALOG) VALUES ('$dataLOG')");

    if (!$registraLOG) { 
      print mysql_error(); 
      exit();
    }

    // log


?>         
