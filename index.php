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
				case SERVER_ERROR:
	                $application->setMessage("Błąd serwera!");
	                break;
				default:
					$application->setMessage('Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!');
					break;
			endswitch;
			header ('Location: index.php?action=showRegistrationForm');
			break;
			case 'addExpense':
				switch ($application->addExpense()):
			    case ACTION_OK:
				    $application->setMessage('Zapisano wydatek w bazie danych.');
				    header ('Location:index.php?action=successExpense');
					return;
				case SERVER_ERROR:
	                $application->setMessage("Błąd serwera!");
	                break;
				case FORM_DATA_MISSING:
                    $application->setMessage("Wypełnij wszystkie pola formularza.");
                    break;	
				case AMOUNT_NOT_NUMBER:
	                $application->setMessage("Kwota musi być liczbą. Format:1234.45");
	                break;	
				case AMOUNT_TOO_HIGH:
	                $application->setMessage("Kwota musi być liczbą mniejszą od 1 000 000 000.");
	                break;
				case NO_DATE:
	                $application->setMessage("Wybierz datę dla wydatku.");
	                break;
                case WRONG_DATE:
	                $application->setMessage("Data musi być aktualna lub wcześniejsza.");
	                break;
				case NO_PAYMENT_METHOD:
	                $application->setMessage("Wybierz metodę dla płatności.");
	                break;	
				case NO_CATEGORY:
	                $application->setMessage("Wybierz kategorię dla wydatku.");
	                break;
				case COMMENT_TOO_LONG:
	                $application->setMessage("Komentarz może mieć maksymalnie 100 znaków.");
	                break;
				case TEST:
					$application->setMessage('TEST');
					break;
				default:
					$application->setMessage('Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!');
					break;
				endswitch;
				header ('Location: index.php?action=showExpenseForm');
				break;	
		case 'addIncome':
				switch ($application->addIncome()):
			    case ACTION_OK:
				    header ('Location:index.php?action=successIncome');
					return;
				case SERVER_ERROR:
	                $application->setMessage("Błąd serwera!");
	                break;
				case FORM_DATA_MISSING:
                    $application->setMessage("Wypełnij wszystkie pola formularza.");
                    break;	
				case AMOUNT_NOT_NUMBER:
	                $application->setMessage("Kwota musi być liczbą. Format:1234.45");
	                break;	
				case AMOUNT_TOO_HIGH:
	                $application->setMessage("Kwota musi być liczbą mniejszą od 1 000 000 000.");
	                break;
				case NO_DATE:
	                $application->setMessage("Wybierz datę dla wydatku.");
	                break;
                case WRONG_DATE:
	                $application->setMessage("Data musi być aktualna lub wcześniejsza.");
	                break;
				case NO_CATEGORY:
	                $application->setMessage("Wybierz kategorię dla wydatku.");
	                break;
				case COMMENT_TOO_LONG:
	                $application->setMessage("Komentarz może mieć maksymalnie 100 znaków.");
	                break;
				default:
					$application->setMessage('Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!');
					break;
				endswitch;
				header ('Location: index.php?action=showIncomeForm');
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
			switch ($application->saveDate()):
			    case ACTION_OK:
					header ('Location:index.php?action=viewBalance');
					return;
					break;
				case ACTION_FAILED:
				    $application->setMessage('action_field');
				    break;
				case NO_DATE:
	                $application->setMessage("Wypełnij wszystkie pola formularza.");
	                break;
                case WRONG_DATE:
	                $application->setMessage("Data musi być aktualna lub wcześniejsza.");
	                break;
				case END_DATE_TOO_SMALL:
				    $application->setMessage("Data końca okresu nie może być mniejsza od daty początku okresu.");
	                break;
				case TEST:
					$application->setMessage('TEST');
					break;
				default:
					$application->setMessage('Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!');
					break;
			endswitch;
			header ('Location: index.php?action=showDateForm');
			break;
        case 'saveNewPassword':
		    switch ($application->saveNewPassword()):
			    case ACTION_OK:
					header ('Location:index.php?action=successPassword');
					return;
					break;
				case BAD_PASSWORD_LENGTH:
					$application->setMessage('Hasło musi posiadać od 8 do 20 znaków!');
					break;
				case DIFFERENT_PASSWORDS:
					$application->setMessage('Hasła muszą być identyczne');
					break;	
				case SERVER_ERROR:
	                $application->setMessage("Błąd serwera!");
	                break;
				default:
					$application->setMessage('Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!');
					break;
			endswitch;
			header ('Location: index.php?action=showChangePasswordForm');
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
