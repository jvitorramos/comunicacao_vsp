﻿<?php

$buscaVeiculos = "
SELECT


  F.PREFIXOVEIC

FROM

FRT_CADVEICULOS F

WHERE

F.CODIGOEMPRESA = 2 AND
F.CODIGOFL = 1 AND
F.CONDICAOVEIC = 'A' AND
F.CODIGOTPFROTA IN (8,2) 

ORDER BY F.PREFIXOVEIC
";

?>