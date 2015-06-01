<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Listado de empresas en pdf</title>
    <style type="text/css">
        body {
         background-color: #fff;
         margin: 1px;
         font-family: Lucida Grande, Verdana, Sans-serif;
         font-size: 11px;
         color: #4F5155;
        }
 
        a {
         color: #003399;
         background-color: transparent;
         font-weight: normal;
        }
 
 		  
        h1 {
         color: #444;
         background-color: transparent;
         border-bottom: 1px solid #D0D0D0;
         font-size: 16px;
         font-weight: bold;
         margin: 24px 0 2px 0;
         padding: 5px 0 6px 0;
        }
 
        h2 {
         color: #444;
         background-color: transparent;
         border-bottom: 1px solid #D0D0D0;
         font-size: 16px;
         font-weight: bold;
         margin: 24px 0 2px 0;
         padding: 5px 0 6px 0;
         text-align: center;
        }
        
 
        table{
            text-align: left;
        }
        
        table thead {
        		border-bottom: 1px solid #C00;
        }
        
        table th {
        		text-align: left;
        }
 
        /* estilos para el footer y el numero de pagina */
        @page { 
        	margin: 60px 20px;  
        }
        #header {
            position: fixed;
            left: 0px; 
            top: -150px;
            right: 0px;
            height: 150px;
            background-color: #ffffff;
            color: #000000;
            text-align: center;
        }
        #footer {
            position: fixed;
            left: 0px;
            bottom: -150px;
            right: 0px;
            height: 150px;
            background-color: #ffffff;
            color: #000000;
            text-align: center;
        }
        #footer .page:after {
            content: counter(page);
        }
    </style>
</head>
<body>
    <!--header para cada pagina-->
    <div id="header">
        Listado de Empresas
    </div>
    
    <!--footer para cada pagina-->
    <div id="footer">
        <!--aqui se muestra el numero de la pagina en numeros romanos-->
        <p class="page"></p>
    </div>
    
    <h2>Empresas</h2>
    <table>
        <thead>
            <tr>
                <th>Nº</th>
                <th>Empresa</th>
                <th>Gerente</th>
                <th>Población</th>
                <th>Telf.</th>
                <th>CIF</th>
                <th>Conc.</th>
            </tr>
        </thead>
        <tbody>
            <?php
            	$num = 0; 
            	foreach($empresaslist as $item) { 
            		$num++;
            ?>
            <tr>
                <td><?php echo $num ?></td>
                <td><?php echo $item->empresa ?></td>
                <td><?php echo $item->responsable ?></td>
                <td><?php echo $item->ciutat ?></td>
                <td><?php echo $item->telf ?></td>
                <td><?php echo $item->cif ?></td>
                <td><?php echo $item->concert ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>