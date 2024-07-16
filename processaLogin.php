<!doctype html>
    <html lang="pt-br">
    <head>
        
    <style>
        
        .container {
        
            width: 300px;
            height: 300px;
            border: none;
            
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
    <body>
    
<div class="container">
    
<?php

// CORRECAO PARA REGISTER_GLOBALS NO PHP 5.5.x
  include ('src/register_globals.php');
  register_globals();
//
  include "src/setup.php";
	
// inicia a sessão: 
session_start();

//verifica se usuário e senha estão corretos:
$verificaSenha = mysql_query("SELECT USER_NAME,USER_PWD FROM USUARIOS WHERE USER_NAME='$inputUsuario' AND USER_PWD='$inputSenha'");
$n_verificaSenha = mysql_num_rows($verificaSenha);
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    
    
        
    if ($n_verificaSenha < 1 ) {
        
        //usuário não existe: 
        
        unset ( $_SESSION['login']);			
        unset ( $_SESSION['senha']);
		$registraLogErro = mysql_query("INSERT INTO LOG(USUARIO,IP,DATA,ACAO) VALUES('$inputUsuario','$ip',NULL,'usuario ou senha invalido $inputUsuario/$inputSenha')");
        
        print "<div class='row'>";
         print "<div class='col-12'>";
          print "<div class='alert alert-danger  role='alert'>";
           print "<b>Usuário não encontrado.</b>";
           print "<hr />";
           print "Seu usuário não foi encontrado no sistema. Clique <a href='index.php'>AQUI</a>  para logar-se novamente.";
          print "</div>";
         print "</div>";
        print "</div>";
        
    } else {
        
        // usuário encontrado:

        // verifica se o usuário esta setado para alterar a senha
        $alterarSenha = mysql_query("SELECT ALTERASENHA FROM USUARIOS WHERE USER_NAME = '$inputUsuario'");
        $alterarSenha = mysql_result($alterarSenha,0);


            if ($alterarSenha == "S") {
                
                session_start();
                $_SESSION['usuario'] = $inputUsuario;
                $_SESSION['alteraSenha'] = "S";

                header("Location:../../alterasenha/?sistema=comunic_vsp");
                exit();
            }

        //
        
        $login = $_POST['inputUsuario'];
        $senha = $_POST['inputSenha'];
		$_SESSION['login'] = $login;
		$_SESSION['senha'] = $senha;
        $getIdUsuario = mysql_query("SELECT USER_ID FROM USUARIOS WHERE USER_NAME='$inputUsuario'");
        $getIdUsuario = mysql_result($getIdUsuario,0);
        //registra no LOG:
        $registraLOG = mysql_query("INSERT INTO LOG(USUARIO,IP,ACAO) VALUES('$login','$ip','Acessou sistema com sucesso')");
        if (!$registraLOG) {
            print mysql_error();
            exit();
        }

        $atualizaTU  = mysql_query("UPDATE USUARIOS SET LAST_LOGIN = NULL WHERE USER_NAME='$login'");
        //encaminha para página de registro de ocorrências:
        
        
        // VERIFICA SE SISTEMA ESTA LIBERADO PARA ACESSO.
         
            $statusSistema = mysql_query("SELECT STATUS FROM STATUS_SISTEMA");
              if (mysql_result($statusSistema,0) == "N" && $getIdUsuario != 1) {
                  
                print "<h1> Sistema em manutenção. <br /> Aguarde ... ";
                exit();
                  
              }
            
        
          //
        
        
        
        header("Location:index2.php?txt_usuario=" .$getIdUsuario);
        
        
        
        
    }
    
    





?>
       
        </div>    
        
</body>
</html>
