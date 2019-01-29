<?php
  if(!isset($application)) die();

  if(!$application->userLoggedIn){
    switch ($application->loginUser()){
      case LOGIN_OK:
        header("Location:index.php?action=showMain");
        exit();
      case LOGIN_FAILED:
        $application->setMessage("Nieprawidłowa nazwa lub hasło!");
        break;
      case SERVER_ERROR:
	  $application->setMessage("Błąd serwera!ERROR SERVER");
      default:
        $application->setMessage("Błąd serwera!");
    }
  }
  else{
    $application->setMessage("Najpierw musisz się wylogować!");
  }
  //header("Location:index.php?action=showLoginForm");
?>