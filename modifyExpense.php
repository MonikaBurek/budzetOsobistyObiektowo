<?php
	if(!isset($application)) die();

	switch ($application->editExpense('edit', $id)):
		case ACTION_OK:
			$application->setMessage('Zapisano wydatek w bazie danych.');
			header ('Location:index.php?action=viewBalance');
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
		case INCORRECT_ID:
	        $application->setMessage("Nieprawidłowy identyfikator wpisu.");
	        break;
		case NO_ID_PARAMETERS:
	        $application->setMessage("Brak identyfikatora wpisu.");
	        break;	
		case NOT_ENOUGH_RIGHTS:
	        $application->setMessage("Brak uprawnień do edycji wpisu.");
	        break;
		default:
			$application->setMessage('Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!');
			break;
	endswitch;
	header ('Location: index.php?action=showEditExpenseForm&id='.$id);
?>