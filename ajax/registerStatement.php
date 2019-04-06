<?php 

	$username = $_POST['user'];
	
	
	if ($username == "gonto111" ) {
		$data["description"] = "Login juz jest w bazie danych !";
		$data["code"] = 1;
	} else {
		$data["description"] = "Login jest wolny";
		$data["code"] = 0;
	}
	
	
	echo json_encode($data);
	
	
	


?>