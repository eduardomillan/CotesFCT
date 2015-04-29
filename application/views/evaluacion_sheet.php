<?php
	//Nivel del usuario
	$nivel = (int) $this->session->userdata("nivel");
	
	//Comprobar las variables de la página
	if (!(isset($empresaId) && isset($empresa))) {
		redirect("empresas");
	}	
?>

<?php $this->load->view('header'); ?>
<?php $this->load->view('styles/common.css.php');?>
<?php $this->load->view('styles/sheet.css.php');?>
<?php $this->load->view('styles/evaluaciones.css.php');?>
<?php $this->load->view('header_end'); ?>


<?php $this->load->view('top');?>

<h1>Registrar evaluación</h1>

<div id="form">
      <?php echo form_open("evaluaciones/$modo");?>
      <?php $this->load->view('empresa_title');?>
      
		<div id="actions">
			<div id="buttonSave">
			    <a class="button" href="#" onclick="javascript:document.forms[0].submit()">
  				     <i class="fa fa-floppy-o fa-1x"></i> Guardar
  			    </a>
			</div>
			<div id="buttonBack">
				<a class="button" href="<?php echo site_url('evaluaciones/info/'.$empresaId); ?>">Volver ></a>
			</div>

		</div>		 
		
		<div id="fields">
		<?php echo form_hidden('id',$evaluacion['id']); ?>
		<fieldset id="basic">
      <legend>Nuevo registro</legend>
			
			<div>
				<label for="curso" class="required" title="Obligatorio">Curso</label>
				<?php
				echo form_dropdown('curso', $cursoslist, $evaluacion['curso']);
				?>
				<span><?php echo form_error('curso'); ?></span>
			</div>      
      
      	<div>
         <label for="ciclo" class="required" title="Obligatorio">Ciclo</label>
         <?php
			$options = array();
			$options[''] = '';
			foreach($cicloslist as $cic):
				$options[$cic->codi] = $cic->codi;
			endforeach;
			echo form_dropdown('ciclo', $options, $evaluacion['ciclo']);
			?>
			<span><?php echo form_error('ciclo'); ?></span>
      	</div>
      	
      	<div>
      		<label for="eval_ini	" class="required" title="Obligatorio">E.Ini.</label>
      		<?php echo form_dropdown('eval_ini', $valoreslist, $evaluacion['eval_ini']); ?>
      		<span><?php echo form_error('eval_ini'); ?></span>
      	</div>
      	
      	<div>
      		<label for="eval_fin	" title="Obligatorio">E.Fin.</label>
      		<?php echo form_dropdown('eval_fin', $valoreslist, $evaluacion['eval_fin']); ?>
      		<span><?php echo form_error('eval_fin'); ?></span>
      	</div>
      	
      	<div>
      		<label for="observaciones">Observaciones</label>
         	<textarea id="observaciones" name="observaciones" rows="1" cols="50"><?php echo $evaluacion['observaciones']?></textarea>
      	</div>
      </fieldset>   
      </div>  
      
      
      <?php echo form_close(); ?>
      <!--
      <div style="position: absolute; top 50em">
      	<?php echo var_dump($evaluacion); ?>
      </div>
      -->
</div>

<?php $this->load->view('footer'); ?>