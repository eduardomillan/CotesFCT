<?php
	//Nivel del usuario
	$nivel = (int) $this->session->userdata("nivel");
?>
<?php $this->load->view('header'); ?>
<?php $this->load->view('styles/common.css.php');?>
<?php $this->load->view('styles/search.css.php');?>
<?php $this->load->view('header_end'); ?>

<?php $this->load->view('top');?>

	<h1>Búsqueda de empresas</h1>
	
	
	<div id="actions">
		<?php if ($nivel == 1) { ?>
		<div id="buttonNew">
				<a class="button" href="<?php echo site_url('empresas/arise'); ?>" title="Nueva">
					<i class="fa fa-plus-square fa-1x"></i> Nueva
				</a>
		</div>	
		<?php } ?>	
	</div>	
	
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
				'onkeypress'  => 'searchIfEnter(event)'
		);
		echo form_input($datos);
		
		
		//Ciclos, familias y concierto
		if (!empty($advancedsearch)) {
			
			//Familias
			echo form_label('Familia: ', 'searchfamilia');
			$options = array();
			$options[''] = '';
			foreach($familiaslist as $fam):
				$options[$fam->codi] = $fam->codi;
			endforeach;
			
			echo form_dropdown('searchfamilia', $options, $this->session->userdata('searchfamilia'));
			
			
			//Ciclos
			echo form_label('Ciclo: ', 'searchciclo');		
			$options = array();
			$options[''] = '';
			foreach($cicloslist as $cic):
				$options[$cic->codi] = $cic->codi;
			endforeach;
						
			echo form_dropdown('searchciclo', $options, $this->session->userdata('searchciclo'));
			
			
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
		?>
		
		<a id="buttonSearch" class="button" href="#" onclick="javascript:document.forms[0].submit()">
			<i class="fa fa-search fa-1x"></i> Buscar
		</a>		
		
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
		<?php } ?>				
		</div>
		<div id="searchHelp">Busca en: Empresa, gerente, población, CIF</div>
		
		<div id="searchOptions">
		<?php if (empty($advancedsearch)) {
				$js = 'onSearchAll()';
				$isChecked = (empty($searchall) ? FALSE : TRUE);
				$datos = array(
    				'name'        => 'searchall',
    				'id'          => 'searchall',
    				'value'       => 'searchall',
    				'checked'     => $isChecked,
    				'onClick'       => $js,
    			);
				echo form_checkbox($datos); 
				echo form_hidden("search", "search"); //Rellena el POST
				echo "Mostrar todas";
		} ?>
		</div>

		<?php
		echo form_close(); 
		?>
		</div> <!--Del id=search--> 
	
	
	
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
		
			$link_info = anchor("empresas/info/".$dato->id, "<i class=\"fa fa-info-circle fa-1x\"></i>", "title='Información'");
			$link_edit = "";
			$link_del = "";
			
			//Control de acceso por nivel de usuario
			if ($nivel <= 3) {
				$link_edit = anchor("empresas/edit/".$dato->id, "<i class=\"fa fa-pencil-square-o fa-1x\"></i>", "title='Editar'");
			}
			
			if ($nivel == 1) {
				//$link_del = anchor("empresas/delete/".$dato->id, img(array("src"=>"images/ico_m_del.png", "alt"=>"Borrar", "title"=>"Borrar")));
			}
		
			$this->table->add_row($cont,$dato->familia,$dato->empresa,
					$dato->responsable,$dato->ciutat,$dato->telf,
					$dato->cif,$dato->concert,
					$link_info." ".$link_edit." ".$link_del);
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

<script type="text/javascript">
	onSearchAll();

	<?php if (empty($advancedsearch)) { ?>
	viewColumn(1,false);
	<?php } ?>		
	
	function onSearchAll() {
		var stext = document.getElementById('searchtext');
		var sall = document.getElementById('searchall');
		if (sall!=null && sall.checked) {
			stext.disabled = true;
			stext.value = "";
		} else {
			stext.disabled = false;
			stext.focus();
		}
	}
	
	function viewColumn(num,ver) {
   	dis = ver ? '' : 'none';
   	
   	cab = document.getElementById('dataTable').getElementsByTagName('th');
   	cab[num].style.display=dis;
   	
  		fila = document.getElementById('dataTable').getElementsByTagName('tr');
  		for(i=1;i<fila.length;i++)
    		fila[i].getElementsByTagName('td')[num].style.display=dis;
	}
	
	function searchIfEnter(e) {
		ky = (document.all) ? e.keyCode : e.which;
		if (ky == 13) 
			document.forms[0].submit();
	}
	
</script>


<?php $this->load->view('footer'); ?>
