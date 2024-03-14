<?php

// CORRECAO PARA REGISTER_GLOBALS NO PHP 5.5.x
  include "src/setup.php";
  include ('src/register_globals.php');
  register_globals();
//
  
include "src/conecta.php";
include "src/glb_buscaFuncionarios.php";  // query que busca funcionários da base do Globus.
include "src/glb_buscaLinha.php"; // linhas Globus
include "src/glb_buscaVeiculos.php"; // Veiculos


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

$totalOcorrenciasDoUsuario = mysql_query("SELECT COUNT(*) FROM COMUNICACAO WHERE STATUS='A' AND USER_ID = " . mysql_result($getUserId,0));
$totalOcorrenciasDoUsuario = mysql_result($totalOcorrenciasDoUsuario,0);

$totalOcorrencias = mysql_query("SELECT COUNT(*) FROM COMUNICACAO WHERE STATUS='A'");
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

        table {

            /*border: 1px solid black;*/
            text-align: center;
        }

        th {
            width: 33%;
            
            /*border: 1px solid black;*/
            text-align: center;
        }

        td {

            font-size: 10pt;
            /*border: 1px solid black;*/
            width: 33%;
            font-family: Calibri;
            
        }
        
      
    </style>
        
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="15">
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
        
        <body>
            
        
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
                         
                        </ul>
                    
                       
                        
                    </div>
                        
                    
                    </nav>
                </div>
                
            </div> 
            
        </div>
        
        
        <div class="container">
            
            <div class="row">
            <div class="col-12 col-md-12">
              <div class="col bg text-left pt-4" >
                <h4>LOG´s</h4>
              </div>
              </div>
            </div>
            
            <div class="row">
            <div class="col12 col-md-12">
            
            <table class="table">
            <tr>
              <th>Data</th>
              <th>Usuário</th>
              <th>Ação</th>
            </tr>    
            
            <?php
                
              $buscaLog = mysql_query("SELECT DATA,USUARIO,ACAO FROM LOG ORDER BY DATA DESC LIMIT 0,100");
                
                if (!$buscalog) print mysql_error();
                
                while ($linha = mysql_fetch_array($buscaLog)) {
                    
                    $datalog    =   $linha['DATA'];
                    $usuariolog =   $linha['USUARIO'];
                    $acaolog    =   $linha['ACAO'];
                    
                    print "<tr>";
                    print "<td>" . $datalog . "</td>";
                    print "<td>" . $usuariolog . "</td>";
                    print "<td>" . $acaolog . "</td>";
                    print "</tr>";
                    
                }
                
            ?>
                
            </table>
            
            </div>
            </div>
        
    
        </div>
        <br />
        
        
        
                
        
            
        
        


    
        
        
        
        
 </body>
 </html>