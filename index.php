<?php

include "src/status_sistema.php";
//include "src/setup.php";

// CORRECAO PARA REGISTER_GLOBALS NO PHP 5.5.x
include ('src/register_globals.php');
register_globals();
 //

session_start();

if ($login || $_SESSION['login']) {
		
		header('Location:index2.php');
		
	
	}

        if ($errors) {
		
            print "<div class='alert alert-danger' role='alert'>";
            print "Logout efetuado com sucesso! $txt_id";
            print "</div>";
		
		}
	
		if ($sair=='s') {
		
			unset($login);
			session_destroy();
			print "<div class='container'>";
            print "<div class='alert alert-primary' role='alert'>";
            print "Logout efetuado com sucesso! $txt_id";
            print "</div>";
            print "</div>";
		
		}
	
		if ($ai) {
			
            
            print "<div class='alert alert-primary' role='alert'>";
            print "Logout efetuado com sucesso! $txt_id";
            print "</div>";
		
		}
		
		
		if ($nlogado) {
			
			print "<b>Perda de conexão. Favor logar novamente.</b>";
			print "<b style='color:red'> A ocorrência não foi gravada</b>";
		
		}
		
		if ($comp) {
		
			print "<b>Erro no compartilhamento. Contactar T.I</b>";
		
		}

        if ($exclui) {
            
            print "excluiu uma comunicacação";
            
        }


?>

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
    

    
    
<div class="container d-flex justify-content-center" id="container-home">
    
    
  
  <div class="mx-auto align-self-center" id="div-home">
      <img src="assets/img/logo.jpg" class="rounded mx-auto d-block" width="300" />
      
      
      

  <form method="post" action="processaLogin.php" >
    
      <div class="form-group">
        <label for="inputUsuario">Usuário</label>
        <input type="text" class="form-control" name="inputUsuario"  id="inputUsuario" aria-describedby="emailHelp" placeholder="Digite o usuário">
    </div>

    <div class="form-group">
        <label for="inputSenha">Senha</label>
        <input type="password" name="inputSenha" class="form-control" id="inputSenha" placeholder="Digite sua senha">
    </div>
      
    

    <input type="submit" class="btn btn-primary" value="Enviar">

  </form>    

</div>
</div>
        
        
      
  

        
        
        </body>
    </html>