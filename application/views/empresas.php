<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>FCT Cotes Baixes - Empresas</title>
<link rel="stylsheet" type="text/css"
	href="<?php echo base_url();?>styles/codeigniter.css">
</head>
<body>

	<div id="container">
		<h2>Búsqueda de empresas</h2>
		<div id="body">
			<p id="search">
			<?php
			echo form_open("empresas/search");
			//Texto
			echo form_label('Búsqueda', 'searchtext');
			$datos = array(
					'name'        => 'searchtext',
					'id'          => 'searchtext',
					'value'       => $this->input->post('searchtext'),
					'size'        => '25',
			);
			echo form_input($datos);
			
			echo form_submit('submit', 'Buscar');
			
			echo form_close(); 
			?>
			</p>
			<p id="results">
			<?php
			if (!empty($empresaslist)) {
				echo "Resultado: ";
				echo count($empresaslist);
			}
			?>
			<p>
		</div>
	</div>
</body>
</html>