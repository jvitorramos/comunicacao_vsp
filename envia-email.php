<!doctype html>
    <html lang="pt-br">
	<meta charset="utf-8">
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


<?php

			
	
		    header("Content-Type: text/html; charset=utf-8", true);
			
			// Inclui o arquivo class.phpmailer.php localizado na pasta class
			require_once("src/class/class.phpmailer.php");
 
			// Inicia a classe PHPMailer
			$mail = new PHPMailer(true);
 
			// Define os dados do servidor e tipo de conexão
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->IsSMTP(); // Define que a mensagem será SMTP
 
		try {


			//$mail->Host = 'smtp.bra.terra.com.br'; // servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
			//$mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
			//$mail->Port       = 587; //  Usar 587 porta SMTP
			//$mail->Username = 'gt.info@terra.com.br'; // Usuário do servidor SMTP (endereço de email)
			//$mail->Password = 'Qwe0rty1'; // Senha do servidor SMTP (senha do email usado)
 
			$mail->Host = 'smtp.bra.terra.com.br'; // servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
			$mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
			$mail->Port       = 587; //  Usar 587 porta SMTP
			$mail->Username = 'comunicacao.vsp@terra.com.br'; // Usuário do servidor SMTP (endereço de email)
			$mail->Password = 'Qwe0rty1'; // Senha do servidor SMTP (senha do email usado)

 
			//Define o remetente
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
			
			$subject = "* Comunicacao Interna *  Funcionario Envolvido: $chapaFunc";
			
			$mail->SetFrom('comunicacao.vsp@terra.com.br', 'Sistema de Ocorrencias - Guarulhos Transportes'); //Seu e-mail
			$mail->AddReplyTo('comunicacao.vsp@terra.com.br', 'Sistema de Ocorrencias - Guarulhos Transportes'); //Seu e-mail
			$mail->Subject = $subject; //Assunto do e-mail
 
	
			
		
			//Define os destinatário(s)
			//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			
			$email = "joao.vitor@saenspenasjc.com.br";
			$campoPara = "TI";
			
			
			// 
			
				$idGerado = mysql_query("SELECT ID FROM COMUNICACAO WHERE USER_ID = $getUserId ORDER BY ID DESC LIMIT 0,1");
				$idGerado = mysql_result($idGerado,0);
			
			//
			
			
            
            
            
			$mail->AddAddress($email, $campoPara);
			$msgBody = "
			<b>Nova ocorrencia gerada no sistema.</b> <br> <br>
            Funcionario: $chapaFunc - $nomeFunc. <br />
            Conteudo da comunicacao: $txt_obs <br />
			<br /> 
			Para visualizar a comunicacao completa, acesse: http://comunicacao.saenspenasjc.com.br  <br />
			<b> ID da comunicacao: $idGerado </b>
			";
		  
            
            
            
			
	
			//Campos abaixo são opcionais 
			//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			
			//$mail->AddCC('ti2@onibusguarulhos.com.br', 'ti2'); // Copia
			$mail->AddCC('decio.fonseca@saenspenasjc.com.br', 'Decio Fonseca'); // Copia
			$mail->AddCC('erica.arantes@saenspenasjc.com.br', 'Erica Arantes'); // Copia
			$mail->AddCC('joao.vitor@saenspenasjc.com.br', 'Joao Vitor'); // Copia
			$mail->AddCC('celso.alda@guarulhostransportes.com.br', 'Celso Alda'); // Copia
		//$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo
 
			//}
 
			//Define o corpo do email
			$mail->MsgHTML($msgBody); 
 
			////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
			//$mail->MsgHTML(file_get_contents('arquivo.html'));
 
			$mail->Send();
			echo "<br>Mensagem enviada com sucesso</p>\n";
 
			//caso apresente algum erro é apresentado abaixo com essa exceção.
			}catch (phpmailerException $e) {
			echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
			
		}
			
			
?>			


</body>
</html>
