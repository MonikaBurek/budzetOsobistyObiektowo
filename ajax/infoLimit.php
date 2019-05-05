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
    
	$category = $_POST['category'];
	$amount = $_POST['amount'];
	
	if (is_numeric($amount)) { 
		if ($amount > 99999999)
		{
			$data["description"] = "Podaj kwotę mniejszą od 99 999 999.";
			$data["code"] = 3;
		} else {
			if ($application->ifCategoryHasLimit($category) == LIMIT_OK) {
				$strTable = $application->informationAboutLimitTable($category,$amount);
				
				$data["description"] = $strTable;
				$data["code"] = 1;
			} else if ($application->ifCategoryHasLimit($category) == NO_LIMIT) {
				$data["description"] = "Nie jest ustwiony limit dla danej kategorii";
				$data["code"] = 4;	
			} else if ($application->ifCategoryHasLimit($nameCategory) == SERVER_ERROR) {
				$data["description"] = "Błąd serwera! Proszę spróbować później!";
				$data["code"] = 0;
			}
		}
	} else {
		$data["description"] = "Podaj kwotę.";
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