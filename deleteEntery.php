<?php
    if (!isset($application)) die();
	
	switch ($application->deleteEntry($wtd,$id)):
		case ACTION_OK:
			header ('Location:index.php?action=viewBalance');
			return;
			break;
		case SERVER_ERROR:
	        $application->setMessage("Błąd serwera!");
			break;
	    case INCORRECT_ID :
	        $application->setMessage("Błędny numer id");
			break;
        case NOT_ENOUGH_RIGHTS:
	        $application->setMessage("Brak uprawnień do edycji wpisu.");
	        break;					
		default:
			$application->setMessage('Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!');
			break;
	endswitch;
	header ('Location: index.php?action=showStatement');