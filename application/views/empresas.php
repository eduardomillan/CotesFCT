<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>FCT Cotes Baixes - Empresas</title>
<?php $this->load->view('styles/search.css.php');?>
</head>
<body>
	
	<div id="container">
		<?php $this->load->view('top');?>
		<h1>Búsqueda de empresas</h1>
		<div id="search">
		
			<?php
			//Destino del form
			if (empty($advancedsearch)) {
				echo form_open("empresas/search");
			} else {
				echo form_open("empresas/advancedSearch");
			}
			
			//Texto
			echo form_label('Búsqueda: ', 'searchtext');
			$datos = array(
					'name'        => 'searchtext',
					'id'          => 'searchtext',
					'value'       => $this->session->userdata('searchtext'),
					'size'        => '25',
			);
			echo form_input($datos);
			
			
			//Familias y concierto
			if (!empty($advancedsearch)) {
				//Familias
				echo form_label('Familia: ', 'searchfamilia');
				
				$options = array();
				$options[''] = '';
				foreach($familiaslist as $fam):
					$options[$fam->nombre] = $fam->nombre;
				endforeach;
				
				echo form_dropdown('searchfamilia', $options, $this->session->userdata('searchfamilia'));
				
				//Concierto
				echo form_label('Concierto: ', 'searchconcert');
				
				$datos = array(
						'name'        => 'searchconcert',
						'id'          => 'searchconcert',
						'value'       => $this->session->userdata('searchconcert'),
						'size'        => '15',
				);
				echo form_input($datos);
			}
			
			echo form_submit('submit', 'Buscar');
			
			echo form_close(); 
			?>
			<div id="typeOfSearch">
			<?php if (empty($advancedsearch)) {?>
			<div id="advancedSearch">
				<a href="<? echo site_url('empresas/advancedSearch')?>">Avanzada</a>
			</div>
			<?php
			} else { 
			?>
			<div id="simpleSearch">
				<a href="<? echo site_url('empresas/search')?>">Simple</a>
			</div>		
			<?php
			} 
			?>				
			</div>
			<div id="searchHelp">Busca en: Empresa, gerente, población, CIF</div>
			</div>
		
		<div id="results">
		<?php
		if (isset($total) && $total >= 0) {
			echo "<div id='summary'>";
			echo "Total: <span id='total'>";
			echo $total;
			echo "</span></div>";
		}
			
		if (!empty($empresaslist)) {
			echo "<div id='dataTable'>";
			$this->table->set_heading('Nº','Familia','Empresa','Gerente','Población','Telf.','CIF','Conc.',''); //crea la primera fila de la tabla con el encabezado
			$tmp = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1">' ); //modifica el espaciado
			$this->table->set_template($tmp); //aplico los cambios de modificacion anterior
			
			$cont = $this->uri->segment(3) + 1;
			foreach($empresaslist as $dato):
			
				$link_info = anchor("empresas/info/".$dato->id, img("images/ico_m_info.png"));
				$link_edit = anchor("empresas/edit/".$dato->id, img("images/ico_m_editar.png"));
			
				$this->table->add_row($cont,$dato->familia,$dato->empresa,
						$dato->responsable,$dato->ciutat,$dato->telf,
						$dato->cif,$dato->concert,
						$link_info.$link_edit);
				$cont++;
			endforeach;
			
			echo $this->table->generate(); //cuando termina generamos la tabla a partir del vector
			
			echo "<div id='pagination'>";
			echo $this->pagination->create_links(); //creamos los links para las paginas
			echo "</div>";
			echo "</div>";
		}
		?>
		</div>
	</div>
	<?php $this->load->view('footer'); ?>
</body>
</html>
