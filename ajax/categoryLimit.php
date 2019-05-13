<?php
include '../constants.php';
spl_autoload_register('classLoader');
session_start();

try {
  $application = new ApplicationFront("localhost", "mburek_ubuzet","!BazaBudzet123", "mburek_budzetosobisty");
}
catch (Exception $e) {
  echo 'Problem z bazą danych. ' . $e->getMessage();
  exit('Panel administracyjny jest niedostępny.');
}
    
	$category = $_POST['category'];
	$limit = $_POST['limit'];
	

	if (is_numeric($limit)) { 
		if ($limit > 99999999)
		{
			$data["description"] = "Podaj wartość mniejszą od 99 999 999.";
			$data["code"] = 3;
		} else {
			if ($application->saveLimitToDatabase($category,$limit) == ACTION_OK) {
				$data["description"] = "Limit dla wydatku został dodany.";
				$data["code"] = 1;
			} else if ($application->saveLimitToDatabase($category,$limit) == SERVER_ERROR) {
				$data["description"] = "Błąd serwera! Proszę spróbować później!";
				$data["code"] = 0;
			}
		}
	} else {
		$data["description"] = "Podaj wartość dla limitu.";
		$data["code"] = 2;
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