<?php
	if(!isset($application)) die();

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
		default:
			$application->setMessage('Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!');
			break;
	endswitch;
	header ('Location: index.php?action=showDateForm');
