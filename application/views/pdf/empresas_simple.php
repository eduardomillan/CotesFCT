<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title></title>
</head>
<body>
<style type=text/css>

th#num, td#num {width: 5%; text-align: center;}
th#empresa, td#empresa {width: 26%}
th#gerente, td#gerente {width: 19%}
th#poblacion, td#poblacion {width: 16%}
th#telf, td#telf {width: 12%}
th#cif, td#cif {width: 12%}
th#conc, td#conc {width: 10%; text-align: center;}

table {
	width: 100%;
	border-color: grey;
}
table th {
	color: #fff; 
	font-weight: bold; 
	background-color: #222;
	border-color: black;
	font-size: 10px;
}

table td {
	border-color: grey;
	font-size: 10px;
}	
</style>



    <h2>Listado de empresas</h2>
    <h4>Total: <?php echo count($empresaslist); ?></h4>
    <table>
        <thead>
            <tr>
                <th id="num">Nº</th>
                <th id="empresa">Empresa</th>
                <th id="gerente">Gerente</th>
                <th id="poblacion">Población</th>
                <th id="telf">Telf.</th>
                <th id="cif">CIF</th>
                <th id="conc">Conc.</th>
            </tr>
        </thead>
    </table>

            <?php
            	$num = 0; 
            	foreach($empresaslist as $item) { 
            		$num++;
            ?>
         	<table>
            <tr>
                <td id="num"><?php echo $num ?></td>
                <td id="empresa"><?php echo $item->empresa ?></td>
                <td id="gerente"><?php echo $item->responsable ?></td>
                <td id="poblacion"><?php echo $item->ciutat ?></td>
                <td id="telf"><?php echo $item->telf ?></td>
                <td id="cif"><?php echo $item->cif ?></td>
                <td id="conc"><?php echo $item->concert ?></td>
            </tr>
				</table>
            <?php } ?>
</body>
</html>    