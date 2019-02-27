<?php
    if (!isset($application)) die();

    switch ($application->editCategory($wtd)):
		case ACTION_OK:
			header ('Location:index.php?action=showCategoryPersonalization');
			return;
			break;
		case FORM_DATA_MISSING:
            $application->setMessage("Podaj nazwę kategorii.");
            break;
		case CATEGORY_NAME_ALREADY_EXISTS:
			$application->setMessage('Istnieje już taka kategoria.');
			break;
		case CATEGORY_TOO_LONG:
			$application->setMessage("Nazwa kategorii może mieć maksymalnie 50 znaków.");
	        break;
		case SERVER_ERROR:
	        $application->setMessage("Błąd serwera!");
	        break;
		default:
			$application->setMessage('Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!');
			break;
	endswitch;
	header ('Location: index.php?action=editCategoryForm&wtd='.$wtd);
