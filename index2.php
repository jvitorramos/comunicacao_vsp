<?php

// CORRECAO PARA REGISTER_GLOBALS NO PHP 5.5.x
  include "src/setup.php";
  include ('src/register_globals.php');
  register_globals();
//
  
//include "src/conecta.php";
//include "src/glb_buscaFuncionarios.php";  // query que busca funcionários da base do Globus.
//include "src/glb_buscaLinha.php"; // linhas Globus
//include "src/glb_buscaVeiculos.php"; // Veiculos


session_start();
	
    $login = $_SESSION['login'];
	$getUserDept    =  mysql_query("SELECT USER_DEPT FROM USUARIOS WHERE USER_NAME = '$login'");
	$getUserTp	    =  mysql_query("SELECT USER_TP FROM USUARIOS  WHERE USER_NAME = '$login'");
	$getUserC	    =  mysql_query("SELECT USER_NAMEC FROM USUARIOS WHERE USER_NAME = '$login'");
    $getUserId      =  mysql_query("SELECT USER_ID FROM USUARIOS WHERE USER_NAME = '$login'");
    $verificaStatus =  mysql_query("SELECT STATUS FROM STATUS_SISTEMA");
    $getUserPermDept       =  mysql_query("SELECT USER_PERM_DEPT FROM USUARIOS WHERE USER_NAME= '$login'");
    $getUserPermDept      =  mysql_result($getUserPermDept,0);


    if ($getUserPermDept == "MAN") {
        
        $permDept = "=3 AND STATUS='A' ";
        
    } 

    if ($getUserPermDept == NULL) {
        
        $permDept = "IN (1,2,3,4,5,8) OR CODAREA IS NULL and STATUS='A' ";
    }



		if (!$login) {
			header('location:index.php?ai=s');
		}

		if (mysql_result($getUserTp,0) == "REL") {
			header('Location: relacaoComunicacoes.php');
		} 
    
        if (mysql_result($verificaStatus,0) == "N" and mysql_result($getUserId,0) !=1) {
            
            print "Sistema em manutenção. Aguarde...<br> Clique <a href='index.php'> AQUI </a> para voltar e conectar-se novamente ao sistema ou <a href='index.php?sair=s'> AQUI </a> para sair do sistema.";
            exit();
            
        }

        


$totalOcorrenciasDoUsuario = mysql_query("SELECT COUNT(*) FROM COMUNICACAO WHERE STATUS='A' AND USER_ID = " . mysql_result($getUserId,0));
$totalOcorrenciasDoUsuario = mysql_result($totalOcorrenciasDoUsuario,0);

$totalOcorrencias = mysql_query("SELECT COUNT(*) FROM COMUNICACAO WHERE STATUS='A' AND CODAREA $permDept");
$totalOcorrencias = mysql_result($totalOcorrencias,0);
    

    if ($exclui) {
        
        print "<div class='container'>";
        print "<div class='alert alert-danger' role='alert'>";
        print "Comunicação excluida com sucesso! $txt_id";
        print "</div>";
        print "</div>";
            
        }


?>

<!doctype html>
    <html lang="pt-br">
    <head>
        
    <style>
        
        div.bg { 
        
            border: 1px solid white;
        }
        
      
    </style>
        
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

        <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        
    <title>Comunicação Interna</title>
        
    </head>
        
        
        <div class="container">
            
            <div class="row"> 
                <div class="col-12">
                    <nav class="navbar navbar-light bg-light navbar-expand-lg"> 
						<a class="navbar-brand" href="#"><img src="assets/img/logo.jpg" width="180" height="50" alt="GTSA"></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav1" aria-controls="#nav1" aria-expanded="false" aria-label="Navegação">
							<span class="navbar-toggler-icon"></span>
						</button>
				
				<div class="collapse navbar-collapse" id="nav1">
                
				<ul class="navbar-nav">
					<li class="nav-item"> <a href="index.php" class="nav-link">Inicio</a></li>
					<li class="nav-item"> <a href="minhasComunicacoes.php" class="nav-link">Minhas Comunicações <span class="badge badge-primary"><?php print $totalOcorrenciasDoUsuario; ?></span> </a></li>
                        
                         <?php
						 
                         if (mysql_result($getUserTp,0) == "ADM" || mysql_result($getUserTp,0) == "BOSS") {
                            print "<li class='nav-item'><a href='todasComunicacoes.php' class='nav-link'>Todas comunicações <span class='badge badge-primary'>$totalOcorrencias </span></a></li>";
                            print "<li class='nav-item'><a href='relatorios.php' class='nav-link'>Relatórios <span class='badge badge-info'>NOVO! </span></a></li>";
						 }

                         if (mysql_result($getUserTp,0) == "BOSS") {
							print "<li class='nav-item'><a href='log.php' class='nav-link'>LOG´s </a></li>";
						}
                    
                        ?>
                         
                         <li class="nav-item"><a href="index.php?sair=s" class="nav-link text-danger" >Sair</a></li>

                         <li class="nav-item"><a href="#" class="nav-link text-primary" >| BD: <?php print $server; ?></a></li>
                         
                </ul>
                        
                </div>
                        
                    
                    </nav>
                </div>
                
            </div> 
            
        </div>
        
        
        <div class="container">
            
            <div class="row">
              <div class="col bg text-left pt-4" >
                <h4>Nova Comunicação Interna <span class="badge badge-warning"><?php print strtolower($login) . " | " . mysql_result($getUserDept,0); ?></span></h4>
                   
              </div>
            </div>
        
    
        </div>
        <br />
        
        
        <div class="container">
        
            <!-- <h6 class="bg bg-primary text-center"><u><i>Informações sobre a data e local da ocorrência</u></i></h6>  -->
            
            <form name="insereComunicacao" method="post" enctype="multipart/form-data" action="processaComunicacaoInterna.php" onsubmit="enviarInformacoes.value='Aguarde. Enviando e-mail...';">
            
          <div class="row">

          
              
            <div class="col-6 col-md-3">
              <div class="form-group">
                
                <?php
                $data_limite = date("Y-m-d");
                ?>

                <label for="txt_data">Data:</label>
                <input type="date" min="2019-01-01" max=<?php print $data_limite; ?> id="txt_data" name="txt_data" placeholder="Data" class="form-control border border-dark" index="1">
              </div>
            </div>
            
              <div class="col-6 col-md-3">
                <div class="form-group">
                    <label for="txt_hora">Horário:</label>
                    <input type="time" id="inputHora" name="txt_hora" placeholder="Data" class="form-control border border-dark"  index="2">
                  </div>
              </div>
            
            <div class="col-6 col-md-3">
              <div class="form-group">
              <label for="inputLinha">Informe a linha:</label>
                <select class="form-control border border-dark" name="slc_linha"  index="3">
                    <option></option>
                    <!-- Busca os funcionários direto na base do Globus. -->
                    <?php
		            
                    $buscaLinha = mysql_query("SELECT DISTINCT CODIGOLINHA FROM LINHAS");
                        while ($l_buscaLinha = mysql_fetch_array($buscaLinha)) {
                            $codigolinha = $l_buscaLinha['CODIGOLINHA'];
                            
		                  print "<option name='$codigolinha'>$codigolinha</option>";
                            
			             }
                         mysql_close;
	                 
                    ?>
                  
                  </select>
              </div>
            </div>
                
                
                <div class="col-6 col-md-3">
                <div class="form-group">
                <label for="inputSentido">Informe o sentido:</label>
                <select name="slc_sentido" class="form-control border border-dark" index="4">
                <option name="011">BC</option>
                <option name="011">CB</option>
                </select>
                </div>
                </div>
            
           
            
            
                
            <div class="col-12 col-md-6">
                <div class="form-group">
                <label for="inputLocal">Informe o local:</label>
                <input name="txt_local" type="text" class="form-control border border-dark" placeholder="Onde ocorreu o fato ?" index="5"  >
                </div>
                </div>
         
            
            
            
            <hr class="form-group">
            <!-- <h6 class="bg bg-primary text-center"><u><i>Informações sobre o funcionário.</u></i></h6>  -->
            
         
            
            <div class="col-12 col-md-6"> 
            <div class="form-group">
            <label for="inputNomeFunc">Funcionário envolvido:</label>
                <select class="form-control border border-dark" name="slc_funcionario" index="6">
                <option name='outros'>999 - OUTROS</option>
                    <!-- Busca os funcionários diretamente da base do Globus. -->
                    <?php
		            
                        $buscaFuncionarios = mysql_query("SELECT CONCAT(CHAPAFUNC,' - ',NOMEFUNC) AS FUNC FROM FUNCIONARIOS WHERE SITUACAOFUNC='A' ORDER BY CHAPAFUNC");
                          while ($l_buscaFuncionarios = mysql_fetch_array($buscaFuncionarios)) {
                              
                            $func = $l_buscaFuncionarios['FUNC'];
                            print "<option name='$func'>$func</option>";          
                              
                          }
                    
                    
	               ?>
                    
                    
                </select>
            </div>
            </div>
            
            <div class="col-12 col-md-6"> 
            <div class="form-group">
            <label for="slc_veiculo">Veiculo:</label>
                <select name="slc_veiculo" class="form-control border border-dark" index="7">
                    <option name='outros'>OUTROS</option>
                
                    <!-- Busca os veiculos diretamente da base do Globus -->
                    
                    <?php  

                        $buscaVeiculos = mysql_query("SELECT PREFIXOVEIC FROM VEICULOS ORDER BY PREFIXOVEIC");
		                  while ($l_buscaVeiculos = mysql_fetch_array($buscaVeiculos)) {
                    
			                    $veiculos = trim($l_buscaVeiculos['PREFIXOVEIC']);
				                    print "<option name='$veiculos'>$veiculos</option>";
                              
                          }
			                 
                            ?>

                    
                    
                </select>
            </div>
            </div>    

            
            
            
            <!-- <h6 class="bg bg-primary text-center"><u><i>Informações sobre o ocorrido.</u></i></h6>  -->
            
          
                
                <div class="col-12 col-md-6">
                <div class="form-group">
                <label for="inputComportamentoNormas">Comportamento/Normas:</label>
                <select name="slc_comp" class="form-control border border-dark"  index="8">
                <option> </option>
                <?php
                        $buscaComportamentoNormas = mysql_query("
                        SELECT CN_ID,CN_DESC FROM COMPORTAMENTO_NORMAS");
                            if (!$buscaComportamentoNormas) print "Erro . " . mysql_error();
                                while ($linha_comp = mysql_fetch_array($buscaComportamentoNormas)) {
	                               $cn_id = $linha_comp['CN_ID'];
  	                               $cn_desc = $linha_comp['CN_DESC'];
	   	                           print "<option>$cn_desc</option>";
	                       }
                    ?>
                </select>
                </div>
                </div>
            
            
            
       
                
                <div class="col-12 col-md-6">
                <div class="form-group">
                <label for="slc_cuidVeic">Cuidados com o veiculo:</label>
                <select name="slc_cuidVeic" class="form-control border border-dark"  index="9">
                <option> </option>
                
                    <?php
                       $buscaCuidadosVeic = mysql_query("
  SELECT CUIDVEIC_ID,CUIDVEIC_DESC FROM CUIDADO_VEICULO");
  if (!$buscaCuidadosVeic) print "Erro . " . mysql_error();
      while ($linha_cuidVeic = mysql_fetch_array($buscaCuidadosVeic)) {
	    $cuidveic_id = $linha_cuidVeic['CUIDVEIC_ID'];
  	    $cuidveic_desc = $linha_cuidVeic['CUIDVEIC_DESC'];
	   	  print "<option>$cuidveic_desc</option>";
	}
                    ?>

                    
                    
                </select>
                </div>
                </div>
            
          
            
              
                <div class="col-12 col-md-6">
                <div class="form-group">
                <label for="slc_operacao">Relativos a operação:</label>
                <select name="slc_operacao" class="form-control border border-dark"  index="10">
                <option> </option>
                <?php 

                    $buscaRelOperacao = mysql_query("
                    SELECT REL_OPERACAO_ID,REL_OPERACAO_DESC FROM RELATIVO_OPERACAO");
                        if (!$buscaRelOperacao) print "Erro . " . mysql_error();
                            while ($linha_rel_operacao = mysql_fetch_array($buscaRelOperacao)) {
	                           $rel_op_id = $linha_rel_operacao['REL_OPERACAO_ID'];
  	                           $rel_op_desc = $linha_rel_operacao['REL_OPERACAO_DESC'];
	   	                       print "<option>$rel_op_desc</option>";
	               }
                ?>	


                </select>
                </div>
                </div>
            
           
            
        
                
                <div class="col-12 col-md-12">
                <div class="form-group">
                <label for="inputComportamentoNormas">Observação / Outras Ocorrências:</label>
                <textarea name="txt_obs" class="form-control border border-dark" rows="5" placeholder="Detalhe" index="11"> </textarea>
                </div>
                </div>

                

                <div class="col-12 col-md-12" style="padding-left: 40px">
                <div class="form-group">
                <input type="checkbox" class="custom-control-input" id="enviarParaGestor" name="enviarParaGestor">
                <label class="custom-control-label" for="enviarParaGestor"><i><b>Encaminhar email aos gestores.</b></i></label>
                </div>
                </div>
              
                   
                <div class="col-12 col-md-12">
                <div class="form-group">
                <label for="inputComportamentoNormas">Anexar arquivo:</label>
                <input name="arquivo" id="arquivo" type="file" class="form-control border border-white" size="20" index="12">
                </div>
                </div>
              

                
              <hr />
                
                


                <div class="col-12 col-md-12">
                <div class="form-group">
                <input type="submit" name="enviarInformacoes" value="Enviar informações" class="form-control border border-dark text-muted"  index="13">
                </div>
                </div>
              
               
            
           
                
            </form>
            
                </div>
                
        </div>
            
        
        


    
        
        
        
        
 </body>
 </html>
