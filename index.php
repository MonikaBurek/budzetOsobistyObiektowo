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
			switch ($application->registerUser()):
			    case ACTION_OK:
				    $application->setMessage('Rejestracja przebiegła prawidłowo. Możesz się zalogować.');
				    header ('Location:index.php?action=showLoginForm');
					return;
				case FORM_DATA_MISSING:
                    $application->setMessage("Podaj login i hasło!");
                    break;
				case BAD_LOGIN_LENGTH:
					$application->setMessage('Login musi posiadać od 5 do 20 znaków!');
					break;
				case NON_ALPHANUMERIC_LOGIN:
					$application->setMessage('Login może składać się tylko z liter(bez polskich liter) i cyfr!');
					break;
				case BAD_PASSWORD_LENGTH:
					$application->setMessage('Hasło musi posiadać od 8 do 20 znaków!');
					break;
				case RECATCHA_FALIED:
					$application->setMessage('Potwierdź, że nie jesteś botem!');
					break;
				case USER_NAME_ALREADY_EXISTS:
				    $application->setMessage('Istnieje już konto dla podanego loginu.');
					break;
				case TEST:
					$application->setMessage('TEST');
					break;
				default:
					$application->setMessage('Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!');
					break;
			endswitch;
			header ('Location: index.php?action=showRegistrationForm');
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
