<?php

include "../src/conecta.php";
include "../src/setup.php";



$buscaDadosFunc = "
SELECT

F.CODINTFUNC ,
F.CHAPAFUNC    ,
F.NOMEFUNC     ,
F.DESCFUNCAO ,
F.CODAREA ,
F.SITUACAOFUNC


FROM


VW_FUNCIONARIOS F
where (F.CODIGOEMPRESA = 2   AND
  F.CODIGOFL      = 1   AND
  F.SITUACAOFUNC  IN ('A','F','D'))

ORDER BY CHAPAFUNC

";	
	
	$buscaDadosFunc = ociparse($ora_conecta,$buscaDadosFunc) or die("Erro");
	ociexecute($buscaDadosFunc,OCI_DEFAULT);
	
	
	while (ocifetch($buscaDadosFunc)) {

        $codintfunc =       ociresult($buscaDadosFunc,"CODINTFUNC");
        $chapafunc  =       ociresult($buscaDadosFunc,"CHAPAFUNC");
        $nomefunc   =       ociresult($buscaDadosFunc,"NOMEFUNC");
        $funcao     =       ociresult($buscaDadosFunc,"DESCFUNCAO");
        $codarea    =       ociresult($buscaDadosFunc,"CODAREA");
	$situacao   = 	    ociresult($buscaDadosFunc,"SITUACAOFUNC");


            
            //print $codintfunc . " - " . $chapafunc . " - " . $nomefunc . " - " . $funcao . " - " . $codarea . " \n";

            $pesquisa_mysql = mysql_query("
            SELECT COUNT(*) FROM FUNCIONARIOS WHERE CODINTFUNC = $codintfunc            
            ");
            if (!$pesquisa_mysql) print mysql_error();
            $pesquisa_mysql = mysql_result($pesquisa_mysql,0);
            
            if ($pesquisa_mysql == 0 ) {

                  $insere_mysql = mysql_query("
                  INSERT INTO FUNCIONARIOS(CODINTFUNC,CHAPAFUNC,NOMEFUNC,FUNCAO,CODAREA) 
                  VALUES
                  ($codintfunc,$chapafunc,'$nomefunc','$funcao',$codarea)
                  ");
                  if (!$insere_mysql) {
                    print "Erro ao inserir no Mysql: " . mysql_error();
                  } else {
                    print "CODINTFUNC  " . $codintfunc . " Chapa: " . $chapafunc . " inserido com sucesso! <br/>";
		    
		    
            } } else {

		print "Funcionario chapa $chapafunc ja esta cadastrado. \n";

		$atualizaFunc = mysql_query("UPDATE FUNCIONARIOS SET FUNCAO='$funcao' , CHAPAFUNC='$chapafunc' , SITUACAOFUNC='$situacao', CODAREA=$codarea WHERE CODINTFUNC=$codintfunc");
		print "CODINTFUNC: " . $codintfunc . " atualizado com sucesso! \n";

		
		if (!$atualizaFunc) {
		  print "Erro ao atualizar." . mysql_error() . "\n";
		  
		}
              



            }

            

        
    }


    // registra no log.
    $dataLOG = date("Y-m-d H:i:s");
    $registraLOG = mysql_query("
    INSERT INTO LOG(USUARIO,IP,ACAO,DATA) VALUES ('SISTEMA','0.0.0.0','IMPORTACAO GLOBUS','$dataLOG')
   ");

    $registraLOG_importacao = mysql_query("INSERT INTO LOG_IMPORTACAO(DATALOG) VALUES ('$dataLOG')");

    if (!$registraLOG) { 
      print mysql_error(); 
      exit();
    }

    // log


?>         
