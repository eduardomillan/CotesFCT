<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>FCT Cotes Baixes - Empresas</title>
<link rel="stylsheet" type="text/css" href="<?php echo base_url('styles/search.css');?>" media="screen" />
</head>
<body>
	
	<?php $this->load->view('top');?>

	<br />

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
					'value'       => $this->session->userdata('searchtext'),
					'size'        => '25',
			);
			echo form_input($datos);
			
			echo form_submit('submit', 'Buscar');
			
			echo form_close(); 
			?>
			</p>
			<p id="results">
			<?php
			if (!empty($searchtext)) {
				echo "<div id='summary'>";
				echo "Resultado: ";
				echo $total;
				echo "</div>";
			}
				
			if (!empty($empresaslist)) {
				echo "<div id='dataTable'>";
				$this->table->set_heading('Familia','Empresa','Gerente','Población','Telf.','CIF',''); //crea la primera fila de la tabla con el encabezado
				$tmp = array ( 'table_open'  => '<table border="0" cellpadding="2" cellspacing="1">' ); //modifica el espaciado
				$this->table->set_template($tmp); //aplico los cambios de modificacion anterior
				
				foreach($empresaslist as $dato):
				
					$link_info = anchor("empresas/info/".$dato->id, img("images/ico_m_info.png"));
					$link_edit = anchor("empresas/edit/".$dato->id, img("images/ico_m_editar.png"));
				
					$this->table->add_row($dato->familia,$dato->empresa,
							$dato->responsable,$dato->ciutat,$dato->telf,$dato->cif,
							$link_info.$link_edit);
				endforeach;
				
				echo $this->table->generate(); //cuando termina generamos la tabla a partir del vector
				
				echo $this->pagination->create_links(); //creamos los links para las paginas
				echo "</div>";
			}
			?>
			<?php
			/*
			<div id="results">
				<table>
					<thead>
						<tr>
							<th>Familia</th>
							<th>Empresa</th>
							<th>Gerente</th>
							<th>Población</th>
							<th>Teléfono</th>
							<th>CIF</th>
							<th>&nbsp;</th>
							</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			 */ 
			?>
			</p>
		</div>
	</div>
</body>
</html>
