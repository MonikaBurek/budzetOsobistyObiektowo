<?php
include 'constants.php';
spl_autoload_register('classLoader');
session_start();

try {
  $application = new ApplicationFront("localhost", "root", "", "personal_budget");
}
catch (Exception $e) {
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
	
	if (isset($_GET['wtd'])) {
    $wtd = $_GET['wtd'];
    }

	if (isset($_GET['id'])) {
    $id = $_GET['id'];
	echo $id;
    } else {
	    $id = 0;
	}
	
	$statement = $application->getMessage();

   switch ($action) {
        case 'login':
	        include 'login.php';
			break;
		case 'logout':
	        $application->logout();
			header ('Location:index.php');
			break;
		case 'registerUser':
			include 'registerUser.php';
			break;
		case 'addExpense':
			include 'addExpense.php';	
			break;	
		case 'modifyExpense':
			include 'modifyExpense.php';	
			break;	
        case 'addIncome':
			include 'addIncome.php';
			break;	
		case 'modifyIncome':
			include 'modifyIncome.php';	
			break;					
		case 'savePeriod':
			switch ($application->savePeriod()):
			    case SELECTED_PERIOD:
				    header ('Location:index.php?action=showDateForm');
					break;
				case DEFINED_PERIOD:
					header ('Location:index.php?action=viewBalance');
				default:
					$application->setMessage('Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!');
					break;
			endswitch;
			break;	
		case 'saveDate':
			include 'saveDate.php';
			break;
        case 'saveNewPassword':
		    include 'saveNewPassword.php';
			break;
		case 'addNewCategory':
		    include 'addNewCategory.php';
			break;
		case 'editCategory':
			include 'editCategory.php';
			break;
		case 'deleteCategory':
		    include 'deleteCategory.php';
			break;
		case 'deleteEntery':
		    include 'deleteEntery.php';
			break;
		default:

		include 'templates/mainTemplate.php';		
    } 



function classLoader($nazwa)
{
    if (file_exists("klasy/$nazwa.php")) {
        require_once("klasy/$nazwa.php");
    } else {
        throw new Exception("Brak pliku z definicją klasy.");
	}
}
