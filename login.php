<?php
  if(!isset($application)) die();

  if(!$application->userLoggedIn){
    switch ($application->loginUser()){
      case LOGIN_OK:
        header("Location:index.php?action=showMain");
        exit();
      case LOGIN_FAILED:
        $application->setMessage("Nieprawidłowy login lub hasło!");
        break;
	 case FORM_DATA_MISSING:
        $application->setMessage("Podaj login i hasło!");
        break;
      case SERVER_ERROR:
	  $application->setMessage("Błąd serwera!");
	  break;
      default:
        $application->setMessage("Wyjątek.");
    }
  }
  else{
    $application->setMessage("Najpierw musisz się wylogować!");
  }
  header("Location:index.php?action=showLoginForm");
?>