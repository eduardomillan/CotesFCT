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

		<div id="actions">
			<div id="buttonNew">
			    <a class="button" href="<?php echo site_url('evaluaciones/arise/'.$empresaId); ?>" title="Nueva">
					  <i class="fa fa-plus-square fa-1x"></i> Nueva
			    </a>	
			</div>	
		
			<div id="buttonEmp">
				<a class="button" href="<?php echo site_url('empresas/info/'.$empresaId); ?>">Empresa ></a>
			</div>

			<div id="buttonSearch">
				<a class="button" href="<?php echo site_url('empresas'); ?>">Búsqueda ></a>
			</div>
		</div>		
	
	<?php echo form_open("");?>
	<div id="form">
   	<?php $this->load->view('empresa_title');?>
		
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
					$link_edit = anchor("evaluaciones/edit/$empresaId/$dato->id", "<i class=\"fa fa-pencil-square-o fa-1x\"></i>", "title='Editar'");
					$link_del = "";
					$js_del = "return confirm('Borrar registro, ¿Está seguro?')";
					
					if ($nivel == 1) {
						$link_del = anchor("evaluaciones/delete/$empresaId/$dato->id", 
										"<i class=\"fa fa-trash-o fa-1x\"></i>",
										array(
											'title' => 'Borrar',
											'onclick' => $js_del
										)); 
					}
					
					$this->table->add_row($dato->curso,
						$dato->ciclo,
						$dato->eval_ini,
						$dato->eval_fin,
						$dato->observaciones,
						$link_edit." ".$link_del
						);
				endforeach;
			
			
				echo $this->table->generate(); 
			echo "</div>";	
		} ?>	
		
		
		
			
		<?php echo form_close(); ?>
   </div>

<?php $this->load->view('footer'); ?>
