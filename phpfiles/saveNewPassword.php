<?php
    if(!isset($application)) die();

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
