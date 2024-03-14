<style>

label {
  font-weight: bold;        
  font-size: 11pt;
  width: 50px;
}

i {

    color: blue;
}

.relatorio {


    
    

}

</style>

<?php

// CORRECAO PARA REGISTER_GLOBALS NO PHP 5.5.x
  include "src/setup.php";
  include ('src/register_globals.php');
  register_globals();
//
  

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
              <h4>Relatórios <span class="badge badge-warning"><?php print strtolower($login) . " | " . mysql_result($getUserDept,0); ?></span></h4>
            </div>
          </div>
        </div>


            <br />
        

             <div class="container">
             <div class="row">


            <div class="col-12 col-md-6 relatorio" id="div_frm_chapa" style="padding: 25px">

                <h6>Relatório de comunicações por chapa</h6> <br />
                <form name="frm_chapa" method="post" action="relatorioPorChapa.php">

                  <label for="lbl_chapa">Chapa:</label>
                  <input type="text" size="6" name="txt_chapa" />
                  <input type="submit" name="processa_chapa" value="Gerar Relatório" />

                </form>


            </div>



            <div class="col-12 col-md-6 relatorio" id="div_frm_periodo" style="padding: 25px">

                <h6>Relatório de comunicações por periodo</h6> <br />

                  <form name="frm_chapa" method="post" action="relatorioPorPeriodo.php">
                    <label for="lbl_chapa">Chapa:</label>
                    <input type="text" size="6" name="txt_chapa" /> <br />
                    <label for="lbl_inicio">Inicio:</label>
                    <input type="date" name="txt_data_inicio" />  <br />
                    <label for="lbl_fim">Fim:</label> 
                    <input type="date" name="txt_data_fim" />
                    <input type="submit" name="processa_periodo" value="Gerar Relatório" />
                  </form>


            </div>

        </div>
        
            

    
        
        <hr />
        
        
        <div class="container">
          <div class="row">
            
            <div class="col-6 col-md-6">
              <h6>Listagem por tipo de ocorrência. <i>Comportamento/Normas.</i> </h6>
              <form name="frm_cn" method="post" action="relatorioPorTipo.php">
              <input type="date" name="txt_data_ini" /> até <input type="date" name="txt_data_fim" /><br /> <br />
              <input type="hidden" name="txt_tipo" value="cn" />
              <select name="slc_cn[]" class="custom-select" multiple>
                
                <?php 
                $buscaCN = mysql_query("SELECT CN_ID,CN_DESC FROM COMPORTAMENTO_NORMAS");
                  if (!$buscaCN) print mysql_error();
                
                  while ($linhaCN = mysql_fetch_array($buscaCN)) {
                    $linhaCN_cn_id   = $linhaCN["CN_ID"];
                    $linhaCN_cn_desc = $linhaCN["CN_DESC"];
                      
                      print "<option value=$linhaCN_cn_id>" . $linhaCN_cn_desc . "</option>";

                  }

                ?>
                
                
              </select>
              <br />
              <br />
              <input type="submit" name="proc_cn" value="Processar">
              </form>
            </div>
         
        
            <div class="col-6 col-md-6">
              <h6>Listagem por tipo. <i>Cuidados com o veiculo.</i></h6>
              <form name="frm_cv" method="post" action="relatorioPorTipo.php">
              <input type="date" name="txt_data_ini" /> até <input type="date" name="txt_data_fim" /><br /> <br />
              <input type="hidden" name="txt_tipo" value="cv" />
              <select class="custom-select" multiple>
              
              <?php
              $buscaCV = mysql_query("SELECT CUIDVEIC_ID,CUIDVEIC_DESC FROM CUIDADO_VEICULO");
                  if (!$buscaCV) print mysql_error();
                
                  while ($linhaCV = mysql_fetch_array($buscaCV)) {
                    $linhaCV_cv_id   = $linhaCV["CUIDVEIC_ID"];
                    $linhaCV_cv_desc = $linhaCV["CUIDVEIC_DESC"];
                      
                      print "<option value=$linhaCV_cv_id>" . $linhaCV_cv_desc . "</option>";

                  }

                ?>
              </select>
              <br />
              <br />
              <input type="submit" name="proc_cv" value="Processar">
              </form>
            </div>
            </div>
        </div>
           
        <hr />

        <div class="container">
          <div class="row">

            <div class="col-6 col-md-6">
              <h6>Listagem por tipo. <i>Relativos à operação.</i></h6>
              <form name="frm_ro" method="post" action="relatorioPorTipo.php">
              <input type="date" name="txt_data_ini" /> até <input type="date" name="txt_data_fim" /><br /> <br />
              <input type="hidden" name="txt_tipo" value="ro" />
              <select name="slc_ro[]" class="custom-select" multiple>


              <?php
              $buscaRO = mysql_query("SELECT REL_OPERACAO_ID,REL_OPERACAO_DESC FROM RELATIVO_OPERACAO");
                  if (!$buscaRO) print mysql_error();
                
                  while ($linhaRO = mysql_fetch_array($buscaRO)) {
                    $linhaRO_ro_id   = $linhaRO["REL_OPERACAO_ID"];
                    $linhaRO_ro_desc = $linhaRO["REL_OPERACAO_DESC"];
                      
                      print "<option value=$linhaRO_ro_id>" . $linhaRO_ro_desc . "</option>";

                  }

                ?>

              </select>
              <br />
              <br />
              <input type="submit" name="proc_ro" value="Processar">
              </form>

            </div>

</div>
</div>

   

            



            </div>
                
        </div>
            
        
        
                <hr />

    
        
        
        
        
 </body>
 </html>
