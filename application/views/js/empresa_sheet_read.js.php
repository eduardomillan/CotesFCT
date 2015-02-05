<script type="text/javascript">

	document.getElementById("modo").textContent = "consulta";
	document.getElementById("id").textContent = "<?php echo $empresa->id; ?>";
	document.getElementById("nombreEmpresa").textContent = "<?php echo $empresa->empresa; ?>";

	document.forms[0]["empresa"].value = "<?php echo $empresa->empresa; ?>";
	document.forms[0]["responsable"].value = "<?php echo $empresa->responsable; ?>";
	document.forms[0]["direccion"].value = "<?php echo $empresa->direccion; ?>";
	document.forms[0]["cp"].value = "<?php echo $empresa->cp; ?>";
	document.forms[0]["ciutat"].value = "<?php echo $empresa->ciutat; ?>";
	document.forms[0]["provincia"].value = "<?php echo $empresa->provincia; ?>";
	document.forms[0]["telf"].value = "<?php echo $empresa->telf; ?>";
	document.forms[0]["fax"].value = "<?php echo $empresa->fax; ?>";
	document.forms[0]["cif"].value = "<?php echo $empresa->cif; ?>";
	document.forms[0]["curs"].value = "<?php echo $empresa->curs; ?>";
	document.forms[0]["familia"].value = "<?php echo $empresa->familia; ?>";
	document.forms[0]["evaluacio"].value = "<?php echo $empresa->evaluacio; ?>";
	document.forms[0]["concert"].value = "<?php echo $empresa->concert; ?>";
	document.forms[0]["evalua_anterior"].value = "<?php echo $empresa->evalua_anterior; ?>";
	document.forms[0]["nom_comercial"].value = "<?php echo $empresa->nom_comercial; ?>";
	document.forms[0]["activitat"].value = "<?php echo $empresa->activitat; ?>";
	document.forms[0]["nif_gerent"].value = "<?php echo $empresa->nif_gerent; ?>";
	document.forms[0]["instructor"].value = "<?php echo $empresa->instructor; ?>";
	document.forms[0]["nif_instructor"].value = "<?php echo $empresa->nif_instructor; ?>";
	document.forms[0]["carrec_instructor"].value = "<?php echo $empresa->carrec_instructor; ?>";
	document.forms[0]["horari_laboral"].value = "<?php echo $empresa->horari_laboral; ?>";
	document.forms[0]["observacions"].value = "<?php echo $empresa->observacions; ?>";
	
</script>