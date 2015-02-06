<script type="text/javascript">

	//Populate the data
	document.getElementById("modo").textContent = "consulta";
	document.getElementById("idNum").textContent = "<?php echo $empresa->id; ?>";
	document.getElementById("nombreEmpresa").textContent = "<?php echo $empresa->empresa; ?>";

	var form1 = document.forms[0];
	form1["id"].value = "<?php echo $empresa->id; ?>";
	form1["empresa"].value = "<?php echo $empresa->empresa; ?>";
	form1["responsable"].value = "<?php echo $empresa->responsable; ?>";
	form1["direccion"].value = "<?php echo $empresa->direccion; ?>";
	form1["cp"].value = "<?php echo $empresa->cp; ?>";
	form1["ciutat"].value = "<?php echo $empresa->ciutat; ?>";
	form1["provincia"].value = "<?php echo $empresa->provincia; ?>";
	form1["telf"].value = "<?php echo $empresa->telf; ?>";
	form1["fax"].value = "<?php echo $empresa->fax; ?>";
	form1["cif"].value = "<?php echo $empresa->cif; ?>";
	form1["curs"].value = "<?php echo $empresa->curs; ?>";
	form1["familia"].value = "<?php echo $empresa->familia; ?>";
	form1["evaluacio"].value = "<?php echo $empresa->evaluacio; ?>";
	form1["concert"].value = "<?php echo $empresa->concert; ?>";
	form1["evalua_anterior"].value = "<?php echo $empresa->evalua_anterior; ?>";
	form1["nom_comercial"].value = "<?php echo $empresa->nom_comercial; ?>";
	form1["activitat"].value = "<?php echo $empresa->activitat; ?>";
	form1["nif_gerent"].value = "<?php echo $empresa->nif_gerent; ?>";
	form1["instructor"].value = "<?php echo $empresa->instructor; ?>";
	form1["nif_instructor"].value = "<?php echo $empresa->nif_instructor; ?>";
	form1["carrec_instructor"].value = "<?php echo $empresa->carrec_instructor; ?>";
	form1["horari_laboral"].value = "<?php echo $empresa->horari_laboral; ?>";
	form1["observacions"].value = "<?php echo $empresa->observacions; ?>";
	
	//Set focus
	form1["cif"].focus();
	
</script>