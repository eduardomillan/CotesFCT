<script type="text/javascript">

	//Block the inputs
	var form1 = document.forms[0];
	for(i=0; i<=form1.length-1; i++) {
		form1[i].disabled = true;
	}
	
	document.getElementById("modo").textContent = "consulta";

	//Hide save button
	document.getElementById("buttonSave").style.visibility = "hidden";
	
	//Set focus
	document.getElementById("buttonBack").focus();
	
</script>