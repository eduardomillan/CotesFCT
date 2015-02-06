<?php $this->load->view('header'); ?>
<?php $this->load->view('styles/common.css.php');?>
<?php $this->load->view('styles/sheet.css.php');?>
</head>
<body>
<div id="container">
   <?php $this->load->view('top');?>
   <h1>Ficha de empresa (<span id="modo">modo</span>)</h1>
   <div id="form">
      <?php echo form_open("empresas/$modo"); ?>
   	<h2><span id="idNum">55</span> - <span id="nombreEmpresa">Nombre de la empresa</span></h2>
		<input type="hidden" name="id" value="" />
		
      <fieldset id="basic">
      <legend>Datos básicos</legend>
      <div>
            <label for="cif">CIF/NIF</label>
         <input type="text" id="cif" name="cif" value="" />
      </div>
	    
      <div>
            <label for="empresa">Empresa</label>
         <input type="text" id="empresa" name="empresa" value="" />
      </div>

     	<div>
          <label for="horari_laboral">Horario</label>
        	<input type="text" id="horari_laboral" name="horari_laboral" value="" />
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
            <label for="responsable">Gerente</label>
         <input type="text" id="responsable" name="responsable" value="" />
      </div>    

      <div>
            <label for="nif_gerent">NIF Gerente</label>
         <input type="text" id="nif_gerent" name="nif_gerent" value="" />
      </div>  	   
      
      </fieldset>
	    
      <fieldset id="address">
      <legend>Domicilio</legend>
      <div>
            <label for="direccion">Dirección</label>
         <input type="text" id="direccion" name="direccion" value="" />
      </div>    
	    
      <div>
            <label for="cp">C.P.</label>
         <input type="text" id="cp" name="cp" value="" />
      </div>    
	    
      <div>
            <label for="ciutat">Población</label>
         <input type="text" id="ciutat" name="ciutat" value="" />
      </div>   
	    
      <div>
            <label for="provincia">Provincia</label>
         <input type="text" id="provincia" name="provincia" value="" />
      </div>     
	    
      <div>
            <label for="telf">Teléfono</label>
         <input type="text" id="telf" name="telf" value="" />
      </div>

      <div>
            <label for="fax">Fax</label>
         <input type="text" id="fax" name="fax" value="" />
      </div>
      </fieldset>	  

	   
      <fieldset id="fct">
      <legend>FCT</legend>
      <div>
            <label for="curs">Curso</label>
         <input type="text" id="curs" name="curs" value="" />
      </div>	    
	    
      <div>
         <label for="familia">Familia</label>
         <?php
			$options = array();
			$options[''] = '';
			foreach($familiaslist as $fam):
				$options[$fam->nombre] = $fam->nombre;
			endforeach;
			echo form_dropdown('familia', $options);
			?>
      </div>

      <div>
            <label for="concert">Concierto</label>
         <input type="text" id="concert" name="concert" value="" />
      </div>	

      <div>
            <label for="evaluacio">Evaluación</label>
         <input type="text" id="evaluacio" name="evaluacio" value="" />
      </div>       
      
      <div>
            <label for="evalua_anterior">Eval. anterior</label>
         <input type="text" id="evalua_anterior" name="evalua_anterior" value="" />
      </div>       
      </fieldset>
      
      <fieldset id="theInstructor">
      	<legend>Instructor</legend>
      <div>
            <label for="instructor">Nombre</label>
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
      </fieldset>
	    
	    
      <fieldset id="other">
      	<legend>Otra información</legend>
	    
      	<div>
            <label for="observacions">Observaciones</label>
         	<textarea id="observacions" name="observacions" rows="3" cols="60"></textarea>
      	</div>	 
      </fieldset>   

   	<div id="buttons">
   	<input id="buttonSave" class="button" type="submit" value="Guardar" />
   	<a id="buttonBack" class="button" href="<?php echo site_url('empresas/search')?>">Volver ></a>
   	</div>

      <?php echo form_close(); ?>
   </div>
</div>
<?php if($modo == 'read') { 
		$this->load->view('js/empresa_sheet_show.js.php'); 
		$this->load->view('js/empresa_sheet_read.js.php'); 
	} else if ($modo == 'update') {
		$this->load->view('js/empresa_sheet_show.js.php'); 
	}
?>
<?php $this->load->view('footer'); ?>
 