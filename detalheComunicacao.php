<?php

// CORRECAO PARA REGISTER_GLOBALS NO PHP 5.5.x
  include "src/setup.php";
  include ('src/register_globals.php');
  register_globals();
//
  

session_start();
	
  $login = $_SESSION['login'];
	$getUserDept =  mysql_query("SELECT USER_DEPT FROM USUARIOS WHERE USER_NAME = '$login'");
	$getUserTp	 =	mysql_query("SELECT USER_TP FROM USUARIOS  WHERE USER_NAME = '$login'");
	$getUserC	 =  mysql_query("SELECT USER_NAMEC FROM USUARIOS WHERE USER_NAME = '$login'");
  $getUserId   =  mysql_query("SELECT USER_ID FROM USUARIOS WHERE USER_NAME = '$login'");
	
		if (!$login) {
			header('location:index.php?ai=s');
		}

		if (mysql_result($getUserTp,0) == "REL") {
			header('Location: relacaoComunicacoes.php');
		} 

        if (mysql_result($verificaStatus,0) == "N" and mysql_result($getUserId,0) !=1) {
            
            print "Sistema em manutenção. Aguarde...<br> Clique <a href='index.php'> AQUI </a> para voltar e conectar-se novamente ao sistema.";
            exit();
            
        }

$totalOcorrenciasDoUsuario = mysql_query("SELECT COUNT(*) FROM COMUNICACAO WHERE STATUS='A' AND USER_ID = " . mysql_result($getUserId,0));
$totalOcorrenciasDoUsuario = mysql_result($totalOcorrenciasDoUsuario,0);

$totalOcorrencias = mysql_query("SELECT COUNT(*) FROM COMUNICACAO WHERE STATUS='A'");
$totalOcorrencias = mysql_result($totalOcorrencias,0);
    
// log de visualização da ocorrência.
//$logVisualizacao = mysql_query("");

$user_id_log        = mysql_result($getUserId,0);
$id_comunic_log     = $id;
$data_visualizacao  = date("Y-m-d H:i:s");

$buscaDetalheLog = mysql_query("SELECT COUNT(*) FROM COMUNICACOES_VISUALIZADAS WHERE ID=$id_comunic_log and USER_ID=$user_id_log");
$buscaDetalheLog = mysql_result($buscaDetalheLog,0);
if ($buscaDetalheLog > 0 ) { 
  $atualiza_log_visualizacoes = mysql_query("UPDATE COMUNICACOES_VISUALIZADAS SET DATA_VISUALIZACAO='$data_visualizacao' WHERE ID=$id_comunic_log AND USER_ID=$user_id_log ");
  if(!$atualiza_log_visualizacoes) print mysql_error();
} else {
  $registra_log_visualizacoes = mysql_query("
  INSERT INTO COMUNICACOES_VISUALIZADAS(ID,USER_ID,DATA_VISUALIZACAO) VALUES ($id_comunic_log,$user_id_log,'$data_visualizacao')
  ");
  if(!$registra_log_visualizacoes) print mysql_error();

}

  // REGISTRA NO LOG QUE O USUARIO ACESSOU A COMUNICACAO
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    if($ip == NULL) $ip = "N/A";
    $nomeLOG = mysql_result($getUserC,0);
    $registra_log_usuario_comunic = mysql_query("INSERT INTO LOG(USUARIO,IP,ACAO) values ('$nomeLOG','$ip','ACESSOU A COMUNICACAO $id_comunic_log atraves do IP $ip')");
    if (!$registra_log_usuario_comunic) print mysql_error();
  //

// fim log


if ($exclui) {
    
    
    
    $getUserIdEx       = mysql_query("SELECT USER_ID FROM USUARIOS WHERE USER_NAME='$login'");
    $getUserIdEx       = mysql_result($getUserIdEx,0);
    
    
    $excluiComunicacao = mysql_query("UPDATE COMUNICACAO SET STATUS='I' , USER_EXCLUIU=$getUserIdEx WHERE ID=$txt_id");
    
      if($excluiComunicacao) {
    
        print "<div class='alert alert-danger' role='alert'>";
        print "Comunicação excluida com sucesso! $txt_id";
        print "</div>";
    
          
          // REGISTRA NO LOG
          $registraLOG = mysql_query("INSERT INTO LOG(USUARIO,ACAO,DATA) VALUES ('$login','EXCLUIU REGISTRO ID = $txt_id',NULL)");
                    
          //Gambiarra para voltar ao index após excluir uma ocorrência ;)
          
          $id = -1;
          
            if ($id == -1) {
                
                header('location:index2.php?exclui=s');
                
            }
          
          
          // Fim Gambi...
          
      } 
 
}


?>

<!doctype html>
    <html lang="pt-br">
    <head>
        
    <style>
        
        div.bg { 
        
            border: 1px solid white;
        }
        
        input.ocorrencia {
            
            font-size: 12px;
            background-color:white;
            
        }
        
        label.ocorrencia {
            
            font-size: 14px;
        }
        
        div.assinatura {
            
            margin-top: 100px;
            
        }
        
        img.naoexibe {
            
            visibility: hidden;
        }
        
        div.naoexibe {
            
            visibility: hidden;
        }
        
        
        
        
      
        
    </style>
        
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    
    <link rel="stylesheet" type="text/css" href="src/print.css" media="print">
            
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

        <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
        
    <title>Comunicação Interna</title>
        
    </head>
        
    <body>
        
        
        <div class="container">
            
            <div class="row"> 
                <div class="col-12">
                    <nav class="navbar navbar-light bg-light navbar-expand-lg"> 
                    
                    
                    <a class="navbar-brand" href="#"><img src="assets/img/vsp.jpg" width="180" height="50" alt="GTSA"></a>
                        
                        
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
                    
                        }
                         
                         
                         if (mysql_result($getUserTp,0) == "BOSS") {
                         
                            print "<li class='nav-item'><a href='log.php' class='nav-link'>LOG´s </a></li>";
                    
                        }
                    
                        ?>
                         
                         <li class="nav-item"><a href="index.php?sair=s" class="nav-link text-danger" >Sair</a></li>
                         
                        </ul>
                    
                       
                        
                    </div>
                        
                    
                    </nav>
                </div>
                
            </div> 
            
        </div>
        
        
        <div class="container">
            
            <div class="row">
                <div class="col-12 col-md-12">
                            
                <img class="img-fluid naoexibe" src="assets/img/vsp.jpg" >
                
            </div>
            </div>
            
            
            <div class="row">
              <div class="col bg text-left pt-4" >
                
                  <h4>Detalhe da comunicação. <span class="badge badge-warning"><?php print strtolower($login) . " | " . mysql_result($getUserDept,0); ?></span></h4>
                
                  <form class="form-inline">
                   <button type="button" class="btn btn-primary btn-sm naoimprimir my-2" onclick="window.print();">Imprimir Comunicação</button>
                  
                      <?php 
                      
                        if (mysql_result($getUserTp,0) !== "CMM") {
                          print "<input type='submit' value='Excluir Comunicação' name='exclui' class='btn btn-danger btn-sm naoimprimir'>";
                        }
                       ?>
                    
                      
                      <input type="hidden" name="txt_id" value="<?php print $id;?>">
                    </form>
                  
                  
                   
              </div>
            
                
                
                
                
                
                
            </div>
        
    
        </div>
        <br />
        
        
        <div class="container">
        
            <?php
            
            $detalheComunicacao = mysql_query("
            SELECT  
                    ID ,
                    DATE(DATA) AS DATA ,
                    TIME(DATA) AS HORA ,
                    LOCAL ,
                    CN_ID ,
                    CUID_ID,
                    OP_ID,
                    OUTROS,
                    OBS,
                    USER_ID,
                    LINHA ,
                    FUNC_NOME,
                    FUNC_CHAPA,
                    VEICULO ,
                    PATH_ANEXO
            FROM
                    COMUNICACAO
            WHERE
                    ID = $id
            ");
            
            while ($linha = mysql_fetch_array($detalheComunicacao)) {
                
                $data       =       $linha['DATA'];
                $datac = explode("-",$data);
                $datac = $datac[2] ."/". $datac[1] ."/". $datac[0];
                
                $hora       =       $linha['HORA'];
                $local      =       strtoupper($linha['LOCAL']);
                $cn_id      =       $linha['CN_ID'];
                $cuid_id    =       $linha['CUID_ID'];
                $op_id      =       $linha['OP_ID'];
                $outros     =       $linha['OUTROS'];
                $obs        =       strtoupper($linha['OBS']);
                $user_id    =       $linha['USER_ID'];
                $lin        =       $linha['LINHA'];

                  $getNomeLinha = mysql_query("
                  SELECT NOMELINHA FROM LINHAS WHERE CODIGOLINHA = '$lin'
                  ");
                  $getNomeLinha = mysql_result($getNomeLinha,0);


                $func_nome  =       $linha['FUNC_NOME'];
                $id         =       $linha['ID'];
                $veiculo    =       $linha['VEICULO'];
                $func_chapa =       $linha['FUNC_CHAPA'];
                $anexo      =       $linha['PATH_ANEXO'];
                $getUserIncluiuDesc = mysql_query("SELECT USER_NAMEC FROM USUARIOS WHERE USER_ID=$user_id");
                                    
                
            }
            
            
            ?>
            
            <div class="row">
            
            <div class="col-6 col-md-2">
                <div class="form-group">
                <label for="inputSentido" class="ocorrencia">Data:</label>
                  <input id="inputData" type="text" readonly class="ocorrencia form-control border border-dark bg bg-white" value="<?php print $datac;?>">
                </div>
                </div>
            
            <div class="col-6 col-md-2">
               <div class="form-group">
                 <label for="inputSentido" class="ocorrencia">Hora:</label>
                 <input id="inputData" type="text" readonly class="ocorrencia form-control border border-dark bg bg-white" value="<?php print $hora;?>">
               </div>
            </div>
                
                         
              <div class="col-12 col-md-3">
               <div class="form-group">
                 <label for="inputSentido" class="ocorrencia">Linha:</label>
                 <input id="inputData" type="text" readonly class="ocorrencia form-control border border-dark bg bg-white" value="<?php print $lin . "-" . $getNomeLinha;?>">
               </div>
            </div>
                
            <div class="col-12 col-md-5">
               <div class="form-group">
                 <label for="inputSentido" class="ocorrencia">Funcionário:</label>
                 <input id="inputData" type="text" readonly class="ocorrencia form-control border border-dark bg bg-white" value="<?php print $func_chapa . "-" . $func_nome;?>">
               </div>
            </div>
                
                <div class="col-12 col-md-6">
               <div class="form-group">
                 <label for="inputSentido" class="ocorrencia">Local:</label>
                 <input id="inputData" type="text" readonly class="ocorrencia form-control border border-dark bg bg-white" value="<?php print $local;?>">
               </div>
            </div>
                
            
                
            
            <div class="col-6 col-md-2">
               <div class="form-group">
                 <label for="inputSentido" class="ocorrencia">Veiculo:</label>
                 <input id="inputData" type="text" readonly class="ocorrencia form-control border border-dark bg bg-white" value="<?php print $veiculo;?>">
               </div>
            </div>    
                
                
            <?php 
            
                    if ($cn_id != 0 ) {
                        
                        $cnDesc = mysql_query("SELECT CN_DESC FROM COMPORTAMENTO_NORMAS WHERE CN_ID=$cn_id");
                        $cnDesc = mysql_result($cnDesc,0);
                        
                        print "<div class='col-12 col-md-12'>";
                        print "<div class='form-group'>";
                        print "<label for='inputSentido' class='ocorrencia'>Motivo comunicação:</label>";
                        print "<input id='inputData' type='text' readonly class='ocorrencia form-control border border-dark bg bg-white' value='$cnDesc'>";
                        print "</div>";
                        print "</div>";
                        
                    }
                
                if ($cuid_id != 0 ) {
                        
                        $cuidDesc = mysql_query("SELECT CUIDVEIC_DESC FROM CUIDADO_VEICULO WHERE CUIDVEIC_ID=$cuid_id");
                        $cuidDesc = mysql_result($cuidDesc,0);
                            
                            
                        print "<div class='col-12 col-md-12'>";
                        print "<div class='form-group'>";
                        print "<label for='inputSentido' class='ocorrencia'>Motivo comunicação:</label>";
                        print "<input id='inputData' type='text' readonly class='ocorrencia form-control border border-dark bg bg-white' value='$cuidDesc'>";
                        print "</div>";
                        print "</div>";
                        
                    }
                
                if ($op_id != 0 ) {
                        
                        $opDesc = mysql_query("SELECT REL_OPERACAO_DESC FROM RELATIVO_OPERACAO WHERE REL_OPERACAO_ID=$op_id");
                        $opDesc = mysql_result($opDesc,0);
                    
                        print "<div class='col-12 col-md-12'>";
                        print "<div class='form-group'>";
                        print "<label for='inputSentido' class='ocorrencia'>Motivo comunicação:</label>";
                        print "<input id='inputData' type='text' readonly class='ocorrencia form-control border border-dark bg bg-white' value='$opDesc'>";
                        print "</div>";
                        print "</div>";
                        
                    }
                
            ?>
                
            <div class="col-12 col-md-12">
               <div class="form-group">
                 <label for="inputSentido" class="ocorrencia">Observação:</label>
                   <textarea readonly class="ocorrencia form-control border border-dark bg bg-white" rows="8"><?php print $obs;?></textarea>
               </div>
            </div>

            <?php 

            if ($anexo) { 

            ?>

            <div class="col-12 col-md-12">
              <div class="form-group">
                <label for="lbl_anexo" class="ocorrencia">Anexo:</label> <br />
                <p style="font-weight: bold">A ocorrência possui anexo. Clique <a href="<?php print $anexo; ?>" target="_BLANK" > aqui </a> para abri-lo.</p>
              </div>
            </div>

            <?php 
            
              }; 

            ?>

              
                <?php
        
                        if(mysql_result($getUserTp,0) == "ADM") {
                            
                            print "<div class='col-6 col-md-6 assinatura text-center'>";
                            print "___________________________________________ <br /> $func_nome <br /> <b>Funcionário</b>";
                            print "</div>";
                            
                            print "<div class='col-6 col-md-6 assinatura text-center'>";
                            print "___________________________________________ <br /> VIAÇÃO SAENS PENA LTDA <br />";
                            print "</div>";
                            
                        }


                        /* INSERE INFORMAÇÕES PARA ASSINATURA DO TERMO DE JUSTIFICATIVA DE PONTO */

                        if ($cn_id == 10 || $cn_id == 11 || $cn_id == 12)  {

                          print "<div class='container'>";
                          print "<div class='row border border-dark'>";
                          
                          print "<div class='col-12 col-md-12 border border-dark text-center p-2 bg-light'>";
                          print "<b>Formulário de justificativa de ponto</b>";
                          print "</div>";


                          print "<div class='col-6 col-md-12 border border-dark'>";
                          print "<b>Assinalar o campo que não houve ponto e preencher o horário cumprido.</b>";
                          print "</div>";

                          print "<div class='col-6 col-md-6 mt-3'>";
                          print "(&nbsp;&nbsp;&nbsp;&nbsp;)  Entrada _________ : __________";
                          print "</div>";

                          print "<div class='col-6 col-md-6 mt-3'>";
                          print "(&nbsp;&nbsp;&nbsp;)  Saida _________ : __________";
                          print "</div>";

                          print "<div class='col-6 col-md-6 mt-3'>";
                          print "(&nbsp;&nbsp;&nbsp;)  Refeição ( inicio )  _________ : __________";
                          print "</div>";

                          print "<div class='col-6 col-md-6 mb-4 mt-3'>";
                          print "(&nbsp;&nbsp;&nbsp;)  Refeição ( retorno ) _________ : __________";
                          print "</div>";



                          print "<div class='col-6 col-md-12 border border-dark'>";
                          print "<b>Motivo:</b> ";
                          print "</div>";

                          print "<div class='col-6 col-md-6 mb-4 mt-2'>";
                          print "(&nbsp;&nbsp;&nbsp;)  Ausencia de marcação ";
                          print "</div>";

                          print "<div class='col-6 col-md-6 mb-4 mt-2'>";
                          print "(&nbsp;&nbsp;&nbsp;)  Problemas no relógio de ponto.";
                          print "</div>";

                          print "<div class='col-6 col-md-12 mb-4 mt-2'>";
                          print "(&nbsp;&nbsp;&nbsp;)  Outros. Justificar ______________________________________________________________________________________ ";
                          print "<br /><small>* Estou ciente que esta justificativa sera analisada, podendo ser justificada e abonada ou justificada e não abonada, conforme a legislação vigente.</small>";
                          print "</div>";


                          print "<div class='col-12 col-md-12 mb-4 mt-3'>";
                          print "Assinatura do funcionário: ________________________________________________________ ( $func_nome )";
                          print "<p class='mt-5'> São José dos Campos , ______ , de ________________ de ______ </p>";
                          print "</div>";


                          print "<div class='mx-auto mt-3 mb-5'>";
                          print "______________________________________________________________";
                          print "<br /><center>Assinatura do gestor imediato</center>";
                          print "</div>";

                          
                          print "</div>";
                          print "</div>";
                        }




                        /*- FIM JUSTIFICATIVA PONTO */


    
                ?>
                
                
            </div>
            
            
            
            
                
            </div>
            
   
                
        
        
        
 </body>
 </html>
