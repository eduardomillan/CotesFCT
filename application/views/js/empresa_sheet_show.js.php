<script type="text/javascript">

	//Populate the data
	document.getElementById("idNum").textContent = "<?php echo $empresa['id']; ?>";
	document.getElementById("nombreEmpresa").textContent = "<?php echo addslashes($empresa['empresa']); ?>";

	var form1 = document.forms[0];
	<?php
		foreach ($empresa as $clave=>$valor) {
			echo "form1['$clave'].value = \"".addslashes($valor)."\";\r\n";
		}
	?>
	
</script>