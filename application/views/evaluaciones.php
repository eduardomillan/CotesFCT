<?php
	//Nivel del usuario
	$nivel = (int) $this->session->userdata("nivel");
	
	//Comprobar las variables de la página
	if (!(isset($empresaId) && isset($empresa) && isset($modo))) {
		redirect("empresas");
	}
?>

<?php $this->load->view('header'); ?>
<?php $this->load->view('styles/common.css.php');?>
<?php $this->load->view('styles/sheet.css.php');?>
<?php $this->load->view('styles/evaluaciones.css.php');?>
<?php $this->load->view('header_end'); ?>

<?php $this->load->view('top');?>

	<h1>Evaluaciones</h1>
	<?php echo form_open("");?>
	<div id="form">
   	<?php $this->load->view('empresa_title');?>
		
		<div id="actions">
			<div id="buttonNew">
			    <a class="button" href="<?php echo site_url('evaluaciones/arise/'.$empresaId); ?>" title="Nueva">
					  <i class="fa fa-plus-square fa-1x"></i> Nueva
			    </a>	
			</div>	
		
			<div id="buttonBack">
				<a class="button" href="<?php echo site_url('empresas/info/'.$empresaId); ?>">Volver ></a>
			</div>
		</div>		
				
		
		<?php if (empty($evalualist)) { ?>
		<div id="noEvalua">
			<label>La empresa no tiene registrada ninguna evaluación.</label>
		</div>		
		<?php } else {
			echo "<div id='dataTable'>";
				$this->table->set_heading('Curso','Ciclo','Ev. Ini.','Ev. Fin.','Observaciones',''); //crea la primera fila de la tabla con el encabezado
				$tmp = array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="1">' ); //modifica el espaciado
				$this->table->set_template($tmp); //aplico los cambios de modificacion anterior			
				foreach($evalualist as $dato):
					$link_edit = anchor("evaluaciones/edit/".$empresaId, "<i class=\"fa fa-pencil-square-o fa-1x\"></i>", "title='Editar'");
					$this->table->add_row($dato->curso,
						$dato->ciclo,
						$dato->eval_ini,
						$dato->eval_fin,
						$dato->observaciones,
						$link_edit
						);
				endforeach;
			
			
				echo $this->table->generate(); 
			echo "</div>";	
		} ?>	
		
		
		
			
		<?php echo form_close(); ?>
   </div>

<?php $this->load->view('footer'); ?>
