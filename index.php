<?php
include 'constants.php';
spl_autoload_register('classLoader');
session_start();

try{
  $application = new ApplicationFront("localhost", "root", "", "personal_budget");
}
catch(Exception $e){
  echo 'Problem z bazą danych. ' . $e->getMessage();
  exit('Panel administracyjny jest niedostępny.');
}  

	if ($application->userLoggedIn) {
		$action = 'showMain';

	} else {
		$action = 'showLoginForm';

    }
	if (isset($_GET['action'])) {
        $action = $_GET['action'];
	}
	
	$statement = $application->getMessage();

   switch ($action) {
        case 'login':
	        include 'login.php';
			break;
		
		default:

		include 'templates/mainTemplate.php';		
    } 



function classLoader($nazwa){
  if(file_exists("klasy/$nazwa.php")){
    require_once("klasy/$nazwa.php");
  } else {
    throw new Exception("Brak pliku z definicją klasy.");
  }
}