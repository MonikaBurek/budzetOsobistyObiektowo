<?php
class ApplicationFront extends Application
{
    public $userLoggedIn = null;
  
    function __construct($host, $user, $pass, $db)
    {
        $this->connection = $this->initDB($host, $user, $pass, $db);
        $this->userLoggedIn = $this->getActualUser();
    }
  
    function getActualUser()
    {
        if (isset($_SESSION['userLoggedIn'])) {
		    return $_SESSION['userLoggedIn'];
        } else {
            return null;
        }
    }

	function setMessage($statement)
	{
        $_SESSION['statement'] = $statement;
    }
  
    function getMessage()
    {
        if (isset($_SESSION['statement'])) {
            $statement = $_SESSION['statement'];
            unset($_SESSION['statement']);
            return $statement;
        } else {
            return null;
        }
    }

    function loginUser()
    {
       return LOGIN_OK;
    }
  
    function logout()
    {
	}
  
}
?>