<?php 

    session_start();

    include "setup.php";
    include "funcoes/funcoes.php";

    $statusSistema = mysql_query("SELECT STATUS,MENSAGEM FROM STATUS_SISTEMA");
    if(!$statusSistema) print mysql_error();
    $status = mysql_result($statusSistema,0);
    $mensagem = mysql_result($statusSistema,0,1);

    
    if ($status == "N") {
        print "<div style='border:2px solid red;padding:20px;text-align: center'>Status do Sistema: <b>Inoperante.</b> <br /> Mensagem: <b><i>$mensagem.</i></b><br /><br /> clique <a href='index.php'> AQUI </a> para tentar novamente.</div>";
        exit();
    }


?>