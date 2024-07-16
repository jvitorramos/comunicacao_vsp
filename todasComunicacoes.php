<?php

// CORRECAO PARA REGISTER_GLOBALS NO PHP 5.5.x
  include "src/setup.php";
  include ('src/register_globals.php');
  register_globals();
//
  
session_start();
	
    $login = $_SESSION['login'];
	$getUserDept           =  mysql_query("SELECT USER_DEPT FROM USUARIOS WHERE USER_NAME = '$login'");
	$getUserTp	           =  mysql_query("SELECT USER_TP FROM USUARIOS  WHERE USER_NAME = '$login'");
	$getUserC	           =  mysql_query("SELECT USER_NAMEC FROM USUARIOS WHERE USER_NAME = '$login'");
    $getUserId             =  mysql_query("SELECT USER_ID FROM USUARIOS WHERE USER_NAME = '$login'");
    $getUserPermDept       =  mysql_query("SELECT USER_PERM_DEPT FROM USUARIOS WHERE USER_NAME= '$login'");
    $getUserPermDept      =  mysql_result($getUserPermDept,0);
    
    
    
    if ($getUserPermDept == "MAN") {
        
        $permDept = "=3 AND STATUS='A' ";
        
    } 

    if ($getUserPermDept == NULL) {
        
        $permDept = "IN (1,2,3,4,5,8,999) OR CODAREA IS NULL and STATUS='A' ";
    }


    
	
		if (!$login) {
			header('location:index.php?ai=s');
		}

		if (mysql_result($getUserTp,0) == "REL") {
			header('Location: relacaoComunicacoes.php');
		} 

$totalOcorrenciasDoUsuario = mysql_query("SELECT COUNT(*) FROM COMUNICACAO WHERE STATUS='A' AND USER_ID = " . mysql_result($getUserId,0));
$totalOcorrenciasDoUsuario = mysql_result($totalOcorrenciasDoUsuario,0);

$totalOcorrencias = mysql_query("SELECT COUNT(*) FROM COMUNICACAO WHERE STATUS='A' AND CODAREA $permDept");
$totalOcorrencias = mysql_result($totalOcorrencias,0);
    

               



    

?>

<!doctype html>
    <html lang="pt-br">
    <head>
        
    <style>
        
        div.bg { 
        
            border: 1px solid white;
        }
        
        .table-condensed {
            
            font-size: 12px;
        }
        
        a.linkTable {
            
            color: black
            
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
        
    <title>Comunicação Interna - Todas as comunicações.</title>
        
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
              <div class="col bg text-left pt-4" >
                <h4>Todas as comunicações <span class="badge badge-warning"><?php print strtolower($login) . " | " . mysql_result($getUserDept,0); ?></span></h4>
                   
              </div>
            </div>
        
    
        </div>
        <br />
        
        
        <div class="container">
            <div class="row">
                <div class="col">
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                      <th>#ID</th>                       
                      <th>DATA</th>
                      <th>HORA</th>
                      <th>LINHA</th>
                      <th>CHAPA</th>
                      <th>NOME</th>
                      <th>USUÁRIO</th>
                      <th>VISUALIZADA POR</th>
                    </tr>
                    </thead>
                    
                    <tbody>
 <?php                       
        $minhasOcorrencias = mysql_query("
        SELECT ID ,
               DATE(DATA) DATA,
               TIME(DATA) HORA ,
               LINHA ,
               FUNC_CHAPA,
               FUNC_NOME ,
               USER_ID
        FROM
               COMUNICACAO
        WHERE
               STATUS='A' AND
               CODAREA $permDept
        ORDER BY DATA DESC
        LIMIT 0,100
        ");
                                 

                        
while ($linha = mysql_fetch_array($minhasOcorrencias)) {
    
    $data   =   $linha['DATA'];
    $hora   =   $linha['HORA'];
    $lin    =   $linha['LINHA'];
    if ($lin == "") $lin = "-----";    

    $func   =   $linha['FUNC_NOME'];
    $chapa  =   $linha['FUNC_CHAPA'];
    $com_id =   $linha['ID'];
    $user_id=   $linha['USER_ID'];
    
    $datac = explode("-",$data);
    $datac = $datac[2] . "/" . $datac[1] ."/". $datac[0];
    
    $userC = mysql_query("SELECT USER_NAMEC FROM USUARIOS WHERE USER_ID=$user_id");
    $userC = mysql_result($userC,0);

    
    
    
        print "<tr>";
        print "<td><a href='detalheComunicacao.php?id=$com_id' class='linkTable'>#" . $com_id . "</a></td>";
        print "<td><a href='detalheComunicacao.php?id=$com_id' class='linkTable'>" . $datac . "</a></td>";
        print "<td><a href='detalheComunicacao.php?id=$com_id' class='linkTable'>" . $hora . "</td>";
        print "<td><a href='detalheComunicacao.php?id=$com_id' class='linkTable'>" . $lin . "</td>";
        print "<td><a href='detalheComunicacao.php?id=$com_id' class='linkTable'>" . $chapa . "</td>";
        print "<td><a href='detalheComunicacao.php?id=$com_id' class='linkTable'>" . $func . "</td>";
        print "<td><a href='detalheComunicacao.php?id=$com_id' class='linkTable'>" . $userC . "</td>";
        
        $usuarios_que_visualizaram_comunicacao = mysql_query("SELECT COUNT(*) FROM COMUNICACOES_VISUALIZADAS WHERE ID=$com_id AND USER_ID <> 1");
        $n_usuarios_que_visualizaram_comunicacao = mysql_result($usuarios_que_visualizaram_comunicacao,0);
        

        if ($n_usuarios_que_visualizaram_comunicacao > 0 ) {

        $usuarios = mysql_query("SELECT USER_ID,DATA_VISUALIZACAO FROM COMUNICACOES_VISUALIZADAS WHERE ID=$com_id AND USER_ID <> 1");
        if (!$usuarios) print mysql_error();
          print "<td>";
            
            while ($linhaUsuarios = mysql_fetch_array($usuarios)) {

                $usuario_id = $linhaUsuarios['USER_ID'];
                $usuario_nome = mysql_query("SELECT USER_NAMEC FROM USUARIOS WHERE USER_ID=$usuario_id");
                $usuario_nome = mysql_result($usuario_nome,0);
                print $usuario_nome . ", ";
                

          }
          print "</td>";
        

        } else {

            print "<td>Não visualizada</td>";

        }
        

        
        
    
        print "</tr>";
        
    
}             
                                 
                                 
?>                                 
                        
                    
                    </tbody>
                    
                    </table>
                
                    
                </div>
            
                
            </div>
        
            
            
      
            
        </div>
                
        
            
            


    
        
        
        
        
 </body>
 </html>
