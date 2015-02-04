<?php $this->load->view('header'); ?>
<?php $this->load->view('styles/common.css.php');?>
<?php $this->load->view('styles/sheet.css.php');?>
</head>
<body>
<div id="container">
   <?php $this->load->view('top');?>
   <h1>Ficha de empresa</h1>
   <div id="form">
      <?php echo form_open("empresas/search"); ?>
   	<h2>55 - Nombre de la empresa</h2>
		
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
         <select id="familia" name="familia">
            <option></option>
            <option>AUT</option>
            <option>TEXTIL</option>
         </select>
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
      
      <fieldset id="instructor">
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
         	<textarea id="observacions" rows="3" cols="60"></textarea>
      	</div>	 
      </fieldset>   

   	<div id="buttons">
   	<input class="button" type="submit" value="Guardar" />
   	<a class="button" href="<?php echo site_url('empresas/search')?>">Volver ></a>
   	</div>

      <?php echo form_close(); ?>
   </div>
</div>
<?php $this->load->view('footer'); ?>