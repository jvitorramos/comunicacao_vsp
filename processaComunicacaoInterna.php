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
        
    <body>

            <div class="container">

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
  $getUserId =  mysql_query("SELECT USER_ID FROM USUARIOS WHERE USER_NAME = '$login'");
  $getUserId = mysql_result($getUserId,0);                
  
                

    if (!$login) {
	  header('location:index.php?ai=s');
	}

	if (mysql_result($getUserTp,0) == "REL") {
	  header('Location: relacaoComunicacoes.php');
	} 


$dataf = explode("-",$txt_data);
$dia = $dataf[2];
$mes = $dataf[1];
$ano = $dataf[0];
$datac = "$ano-$mes-$dia $txt_hora";                


if ($slc_funcionario == "999 - OUTROS" && $txt_obs == " ") {
  print "<div class='row'>";
  print "<div class='col-12'>";
   print "<div class='alert alert-danger  role='alert'>";
    print "<b>Erro ao gravar a ocorrência.</b>";
    print "<hr />";
    print "Campo chapa = 999 e campo observação em branco. <br/> <i><b>Essa combinação de dados não é permitida</b></i>.<br/>Clique <a href='javascript:history.go(-1);'> AQUI </a> para voltar e preencheer os campos devidamente.";
   print "</div>";
  print "</div>";
 print "</div>";
 exit();
}


  
                
                
if ($txt_local == "" ){
		$txt_local = "NAO INFORMOU";
	}                

if ($slc_comp == NULL) {
		$getComportamentoId = 0;
	} else {
		$getComportamentoId = mysql_query("SELECT CN_ID FROM COMPORTAMENTO_NORMAS WHERE CN_DESC = '$slc_comp'");
		$getComportamentoId = mysql_result($getComportamentoId,0);
	}

	
if ($slc_cuidVeic == NULL) {
		$getCuidadoVeiculo = 0;
	} else {
		$getCuidadoVeiculo = mysql_query("SELECT CUIDVEIC_ID FROM CUIDADO_VEICULO WHERE CUIDVEIC_DESC = '$slc_cuidVeic'");
		$getCuidadoVeiculo = mysql_result($getCuidadoVeiculo,0);
	}
	

if ($slc_operacao == NULL) {
		$getRelOperacao = 0;
	} else {
		$getRelOperacao = mysql_query("SELECT REL_OPERACAO_ID FROM RELATIVO_OPERACAO WHERE REL_OPERACAO_DESC = '$slc_operacao'");
		$getRelOperacao = mysql_result($getRelOperacao,0);
	}                

$chk_email = "SIM";                
                
                
$funcionario = explode("-" , $slc_funcionario);
$chapaFunc = intval($funcionario[0]);
$nomeFunc  = trim($funcionario[1]);
                
                
$getCodArea = mysql_query("SELECT CODAREA FROM FUNCIONARIOS WHERE CHAPAFUNC=$chapaFunc");
$getCodArea = mysql_result($getCodArea,0);
if (!$getCodArea) $getCodArea=999;

                


    if ($txt_data == "" || $txt_hora == "") {
        
        print "<div class='row'>";
         print "<div class='col-12'>";
          print "<div class='alert alert-danger  role='alert'>";
           print "<b>Erro ao gravar a ocorrência.</b>";
           print "<hr />";
           print "O campos DATA e HORA são obrigatórios. Clique <a href='javascript:history.go(-1);'> AQUI </a> para voltar e preencheer os campos devidamente.";
          print "</div>";
         print "</div>";
        print "</div>";
        exit();
        
    } 

                
// UPLOAD
	
$anexo = $_FILES["arquivo"];
$nome_imagem = md5(uniqid(time())) . "." . $ext[1];
$extensao_arquivo = $anexo["name"];
$extensao_arquivo = strtolower(pathinfo($extensao_arquivo, PATHINFO_EXTENSION));
$caminho_imagem = "anexos/" . $nome_imagem . $extensao_arquivo;
	
if ( move_uploaded_file($anexo["tmp_name"], $caminho_imagem)) {
		
  print "<b>Imagem enviada com sucesso!</b>";
    
} 
else {
  
    //print "Não possui imagem para anexar. $caminho_imagem";
  $caminho_imagem = NULL;

}
	
                
		
// FIM UPLOAD                
                
                
$insere = mysql_query("
	INSERT INTO COMUNICACAO(DATA,LINHA,FUNC_CHAPA,FUNC_NOME,VEICULO,SENTIDO,LOCAL,CN_ID,CUID_ID,OP_ID,OBS,ENVIOU_EMAIL,DATALOG,USER_ID,STATUS,PATH_ANEXO,CODAREA) VALUES
	(
	'$datac' 		, 
	'$slc_linha' 	,
	$chapaFunc 		,
	'$nomeFunc' 	,
	'$slc_veiculo' 	,
	'$slc_sentido'	,
	'$txt_local'	,
	$getComportamentoId		,
	$getCuidadoVeiculo 	,
	$getRelOperacao 	,
	'$txt_obs' 		,
	'$chk_email',
	NULL,
	$getUserId,
	'A' ,
	'$caminho_imagem' ,
    $getCodArea
	)
	");                
 
if (!$insere) { 
	  print "<br><br>Erro: ( " . mysql_errno() . " ) - " . mysql_error();
	} else {
	  
    
        print "<div class='row'>";
         print "<div class='col-12'>";
          print "<div class='alert alert-primary role='alert'>";
           print "<b>Ocorrência gravada com sucesso!.</b>";
           print "<hr />";
           print "A ocorrência foi gravada com sucesso e um e-mail foi enviado à disciplina a titulo de informação. <br /> Clique <a href='index2.php'> AQUI </a> para registrar uma nova ocorrência.";
        
          print "</div>";
         print "</div>";
        print "</div>";
        //exit();
    
    
	  
	  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	  if ($ip == "") {
	    $ip = "0.0.0.0";
	  }	  

    $dataLog = date("Y-m-d H:i:s");

	  $registraLOG = mysql_query("INSERT INTO LOG(USUARIO,IP,DATA,ACAO) VALUES ('$login','$ip','$dataLog','Registrou uma ocorrencia com sucesso Chapa: $chapaFunc , Data: $datac , Veiculo: $slc_veiculo')");
	 
		if (!$registraLOG) print "Ocorreu um erro ao registrar o LOG: $login $ip  " . mysql_error(); 
	  
	}

  // ENVIA E-MAIL
  
  if ($enviarParaGestor) { 

    include "envia-email.php";

  }
	
	//include "envia-email.php";\
    
    // registra na fila de email
      
       // $getLastId      = mysql_query("SELECT MAX(ID) FROM COMUNICACAO WHERE USER_ID = $getUserId");
       // $getLastId      = mysql_result($getLastId,0);
       // $registraEmail  = mysql_query("INSERT INTO FILA_EMAIL(ID,REGISTRADO_EM) VALUES ($getLastId,NULL)");
                
    //
                
                
		
                
                


?>
        
        </div>
                
        </body>
</html>
