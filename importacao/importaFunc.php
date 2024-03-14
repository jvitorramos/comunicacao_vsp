<?php

include "../src/setup.php";

$arquivo = file("funcionarios.csv");

foreach($arquivo as $linha) {

    $separaCampos = explode(";",$linha);

	
	
	$codintfunc      = 	( int ) $separaCampos[0];
    $chapa     		 = 	( int ) $separaCampos[2];
    $nome       	 = 	$separaCampos[1];
    $funcao     	 = 	$separaCampos[3];
    $codarea    	 = 	( int ) $separaCampos[4];
	
		
	
    
        $v = mysql_query("
        SELECT CHAPAFUNC FROM FUNCIONARIOS WHERE CHAPAFUNC = $chapa
        ");
        $n_v = mysql_num_rows($v);

            if ($n_v < 1) { 

                    print $chapa . "-" . $nome . " nao existe na base <br />";
                    $a = mysql_query("
                    INSERT INTO FUNCIONARIOS(CODINTFUNC,CHAPAFUNC,NOMEFUNC,CODAREA,FUNCAO) VALUES ($codintfunc,$chapa,'$nome',$codarea,'$funcao')
                    ");
                    if (!$a) { 
						print mysql_error();
						exit();
					} else {
						print "Inserido com sucesso! <br/>";
					}
					

            } else {

                //atualiza CODAREA

                    $a = mysql_query("
                    UPDATE FUNCIONARIOS SET CODAREA=$codarea, FUNCAO='$funcao' WHERE CHAPAFUNC=$chapa
                    ");
                    if (!$a) { 

                        print "Erro ao atualizar" . mysql_error();

                    } else {

                        print $chapa . " - " . $nome . " atualizados com sucesso <br>";

                    }

            }

    
}


?>