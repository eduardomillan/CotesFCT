<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title></title>
</head>
<body>
<style type=text/css>

th#num, td#num {width: 4%; text-align: center;}
th#ciclo, td#ciclo {width: 10%}
th#curso, td#curso {width: 10%}
th#eval_ini, td#eval_ini {width: 3%}
th#eval_fin, td#eval_fin {width: 3%}
th#empresa, td#empresa {width: 22%}
th#gerente, td#gerente {width: 15%}
th#poblacion, td#poblacion {width: 12%}
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
    <h2>Listado de empresas con evaluaciones</h2>
    <h4>Total: <?php echo count($empresaslist); ?></h4>
    <table>
        <thead>
            <tr>
                <th id="num">Nº</th>
				<th id="ciclo">Ciclo</th>
				<th id="curso">Curso</th>
				<th id="eval_ini">EF</th>
				<th id="eval_fin">EI</th>
                <th id="empresa">Empresa</th>
                <th id="gerente">Gerente</th>
                <th id="poblacion">Población</th>
                <th id="telf">Telf.</th>
                <th id="conc">Conc.</th>
            </tr>
        </thead>
        <tbody>
            <?php
            	$num = 0; 
            	foreach($empresaslist as $item) { 
            		$num++;
            ?>
            <tr>
                <td id="num"><?php echo $num ?></td>
				<td id="ciclo"><?php echo $item->ciclo ?></td>
				<td id="curso"><?php echo $item->curso ?></td>
				<td id="eval_ini"><?php echo $item->eval_fin ?></td>
				<td id="eval_fin"><?php echo $item->eval_ini ?></td>
                <td id="empresa"><?php echo $item->empresa ?></td>
                <td id="gerente"><?php echo $item->responsable ?></td>
                <td id="poblacion"><?php echo $item->ciutat ?></td>
                <td id="telf"><?php echo $item->telf ?></td>
                <td id="conc"><?php echo $item->concert ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html> 