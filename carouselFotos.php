<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title> Sistema de Ocorrências - Guarulhos Transportes S/A</title>

<style>

    .minhas-imagens {

        width: 50%;
        height: 50%;

    }

</style>

</head>

<body>


<div class="col-12 col-md-12 w-50 h-50">

<div id="carouselExampleIndicators" class="carousel slide col-md6" data-ride="carousel">
  
  
  <div class="carousel-inner">

  <?php

    
    
    $fotosOcr = mysql_query("SELECT PATH_ANEXO FROM COMUNICACAO WHERE ID = $id ");
      if(!$fotosOcr) print mysql_error();

      $i=0;      
      while ($linhaImgCarrosel = mysql_fetch_array($fotosOcr)) {
          $enderecoFoto = $linhaImgCarrosel["PATH_ANEXO"];
          
      

      if ($i ==0) {
        print "<div class='carousel-item active'>";
        print "<img src='$enderecoFoto' class='d-block w-100 minhas-imagens' alt='...'>";
        print "</div>";
      } else {
        print "<div class='carousel-item'>";
        print "<img src='$enderecoFoto' class='d-block w-100 minhas-imagens' alt='...'>";
        print "</div>";

      }
        
      $i++;
      }

    ?>

    

    </div>



  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

</body>
</html>        