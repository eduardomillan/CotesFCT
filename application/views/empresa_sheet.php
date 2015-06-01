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
<?php $this->load->view('header_end'); ?>

<?php $this->load->view('top');?>

   <h1>Ficha de empresa (<span id="modo">modo</span>)</h1>

		<div id="actions">
			<?php if ($nivel <= 3 && $modo == "read") { ?>
			<div id="buttonEdit">
				<a class="button" href="<?php echo site_url('empresas/edit/'.$empresaId); ?>"><i class="fa fa-pencil-square-o fa-1x"></i> Editar</a>
			</div>
			<?php } ?>
			<?php if ($nivel <= 3 && $modo != "read") { ?>
			<div id="buttonSave">
			    <a class="button" href="#" onclick="javascript:document.forms[0].submit()">
  				     <i class="fa fa-floppy-o fa-1x"></i> Guardar
  			    </a>
			</div>
			<?php } ?>
			<?php if ($modo == "read") { ?>
			<div id="buttonEval">
				<a class="button" href="<?php echo site_url('evaluaciones/info/'.$empresaId)?>">
					<i class="fa fa-check-square fa-1x"></i> Evaluaciones
				</a>
			</div>
			<?php } ?>
			<div id="buttonSearch">
				<a class="button" href="<?php echo site_url('empresas')?>">Búsqueda ></a>
			</div>
		</div>		
   
   <div id="form">
      <?php echo form_open("empresas/$modo");?>
   	<?php $this->load->view('empresa_title');?>
   	<input type="hidden" name="id" value="<?php echo $empresaId ?>" />
		
      <fieldset id="basic">
      <legend>Empresa</legend>
      <div>
            <label for="empresa" class="required" title="Obligatorio">Empresa</label>
         <input type="text" id="empresa" name="empresa" value="" />
         <span><?php echo form_error('empresa'); ?></span>
      </div>

      <div>
            <label for="cif" class="required" title="Obligatorio">CIF/NIF</label>
         <input type="text" id="cif" name="cif" value="" />
         <span><?php echo form_error('cif'); ?></span>
      </div>

      <div>
            <label for="nom_comercial">Nombre Comercial</label>
         <input type="text" id="nom_comercial" name="nom_comercial" value="" />
      </div>	
         
      <div>
            <label for="activitat">Actividad</label>
         <input type="text" id="activitat" name="activitat" value="" />
      </div>	     

     	<div>
          <label for="horari_laboral">Horario</label>
        	<input type="text" id="horari_laboral" name="horari_laboral" value="" />
     	</div>	   

      <div>
            <label for="concert">Concierto</label>
         <input type="text" id="concert" name="concert" value="" />
      </div>	
		</fieldset>	   

	    
      <fieldset id="address">
      <legend>Domicilio</legend>
      <div>
            <label for="direccion">Dirección</label>
         <input type="text" id="direccion" name="direccion" value="" />
      </div>    
	    
      <div>
            <label for="cp" class="required" title="Obligatorio">C.P.</label>
         <input type="text" id="cp" name="cp" value="" />
         <span><?php echo form_error('cp'); ?></span>
      </div>    
	    
      <div>
            <label for="ciutat" class="required" title="Obligatorio">Población</label>
         <input type="text" id="ciutat" name="ciutat" value="" />
         <span><?php echo form_error('ciutat'); ?></span>
      </div>   
	    
      <div>
            <label for="provincia" class="required" title="Obligatorio">Provincia</label>
         <input type="text" id="provincia" name="provincia" value="" />
         <span><?php echo form_error('provincia'); ?></span>
      </div>     
	    
      <div>
            <label for="telf" class="required" title="Obligatorio">Teléfono</label>
         <input type="text" id="telf" name="telf" value="" />
         <span><?php echo form_error('telf'); ?></span>
      </div>

      <div>
            <label for="telf2">Teléfono 2</label>
         <input type="text" id="telf2" name="telf2" value="" />
      </div>

      <div>
            <label for="fax">Fax</label>
         <input type="text" id="fax" name="fax" value="" />
      </div>

      <div>
            <label for="email">E-mail</label>
         <input type="text" id="email" name="email" value="" />
      </div>

      <div>
            <label for="web">WWW</label>
         <input type="text" id="web" name="web" value="" />
      </div>
      </fieldset>	  


	    
	   <fieldset id="manager">
	   <legend>Gerente o representante</legend>
      <div>
            <label for="responsable">Nombre y apellidos</label>
         <input type="text" id="responsable" name="responsable" value="" />
      </div>    

      <div>
            <label for="nif_gerent">NIF</label>
         <input type="text" id="nif_gerent" name="nif_gerent" value="" />
      </div>  	   

      <div>
            <label for="telf_gerent">Teléfono</label>
         <input type="text" id="telf_gerent" name="telf_gerent" value="" />
      </div>    

      <div>
            <label for="email_gerent">E-mail</label>
         <input type="text" id="email_gerent" name="email_gerent" value="" />
      </div>    
      </fieldset>
      
      
      
      <fieldset id="theInstructor">
      	<legend>Instructor</legend>
      <div>
            <label for="instructor">Nombre y apellidos</label>
         <input type="text" id="instructor" name="instructor" value="" />
      </div>   

      <div>
            <label for="nif_instructor">NIF</label>
         <input type="text" id="nif_instructor" name="nif_instructor" value="" />
      </div>
      
      <div>
            <label for="carrec_instructor">Cargo</label>
         <input type="text" id="carrec_instructor" name="carrec_instructor" value="" />
      </div>               	
      
      <div>
            <label for="telf_instructor">Teléfono</label>
         <input type="text" id="telf_instructor" name="telf_instructor" value="" />
      </div>               	
      
      <div>
            <label for="email_instructor">E-mail</label>
         <input type="text" id="email_instructor" name="email_instructor" value="" />
      </div>               	
      </fieldset>

		<?php if ($modo == "read") { ?>
      <fieldset id="fct">
      <legend>FCT</legend>
      <div style="display: inline-flex">
         <label class=".textLabel"><?php echo $evalinfo ?></label>
      </div>	    
      </fieldset>	 
	   <?php } ?>
	   
      <fieldset id="other">
      	<legend>Otra información</legend>
	    
      	<div>
            <label for="observacions">Observaciones</label>
         	<textarea id="observacions" name="observacions" rows="3" cols="60"></textarea>
      	</div>	 
      </fieldset>   

      <?php echo form_close(); ?>
   </div>

<?php 
	$this->load->view('js/empresa_sheet_show.js.php'); 
	
	if($modo == "read") { 
		$this->load->view('js/empresa_sheet_read.js.php'); 
	} else if ($modo == "update") {
		$this->load->view('js/empresa_sheet_update.js.php'); 
	} else if ($modo == "create") {
		$this->load->view('js/empresa_sheet_new.js.php');
	}
?>
<?php $this->load->view('footer'); ?>
 