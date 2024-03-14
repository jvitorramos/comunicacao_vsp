<?php

$buscaFuncionarios = "
select
f.CHAPAFUNC || ' - ' || f.NOMEFUNC AS FUNC
from
vw_funcionarios f 
where 
f.CODIGOEMPRESA = 2 and 
f.CODIGOFL = 1 and
f.SITUACAOFUNC in ('A') AND
F.CODAREA in (1,4)
ORDER BY F.CODAREA,F.CHAPAFUNC
";

?>