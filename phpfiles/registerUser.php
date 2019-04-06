<?php
	if(!isset($application)) die();

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
