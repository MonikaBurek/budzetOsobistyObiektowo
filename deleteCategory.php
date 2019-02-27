<?php
    if (!isset($application)) die();
	
	switch ($application->deleteCategory($wtd)):
		case ACTION_OK:
			header ('Location:index.php?action=showCategoryPersonalization');
			return;
			break;
		case FORM_DATA_MISSING:
            $application->setMessage("Podaj nową nazwę kategorii.");
            break;
		case NO_CATEGORY:
	        $application->setMessage("Wybierz kategorię, którą chcesz usunąć.");
	        break;
		case NO_DELETE_METHOD:
			$application->setMessage("Wybierz parametr usunięcia kategorii.");
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
	header ('Location: index.php?action=deleteCategoryForm&wtd='.$wtd);