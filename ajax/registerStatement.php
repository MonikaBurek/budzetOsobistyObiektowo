<?php
include '../constants.php';
spl_autoload_register('classLoader');
session_start();

try {
  $application = new ApplicationFront("localhost", "root", "", "personal_budget");
}
catch (Exception $e) {
  echo 'Problem z bazą danych. ' . $e->getMessage();
  exit('Panel administracyjny jest niedostępny.');
}
    
	$username = $_POST['user'];
	
	if ($application->checkIfUserExistsInDatabase($username) == USER_NAME_ALREADY_EXISTS) {
		$data["description"] = "Podaj inny login!";
		$data["code"] = 1;
	} else if ($application->checkIfUserExistsInDatabase($username) == ACTION_OK) {
		$data["description"] = "Login jest wolny!";
		$data["code"] = 0;
	}
	
	
	echo json_encode($data);

function classLoader($nazwa)
{
    if (file_exists("../klasy/$nazwa.php")) {
        require_once("../klasy/$nazwa.php");
    } else {
        throw new Exception("Brak pliku z definicją klasy.");
	}
}
   	
