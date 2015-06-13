<script type="text/javascript">

	//Populate the data
	document.getElementById("idNum").textContent = "<?php echo $empresa['id']; ?>";
	document.getElementById("nombreEmpresa").textContent = "<?php echo addslashes($empresa['empresa']); ?>";

	var form1 = document.forms[0];
	<?php	foreach ($empresa as $clave=>$valor) { ?>
		if (form1['<?php echo $clave ?>'])
			form1['<?php echo $clave ?>'].value = "<?php echo preg_replace('[\n|\r|\n\r]', '\n', addslashes($valor)) ?>";
	<?php	} ?>
	
</script>