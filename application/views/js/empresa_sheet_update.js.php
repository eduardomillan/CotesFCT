<script type="text/javascript">
	
	var form1 = document.forms[0];
	document.getElementById("modo").textContent = "edición";
	
	//Disable key fields
	document.getElementById("cif").disabled = true;
	//document.getElementById("concert").disabled = true;	
	
	//Set focus
	form1['empresa'].focus();
	
</script>