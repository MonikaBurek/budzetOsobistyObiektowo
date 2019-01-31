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
       $newLogin = new Login($this->connection);
	   return $newLogin->login();
    }
	
	function registerUser()
	{
		$register = new Registration($this->connection);
		return $register->register();
	}
  
	function addExpense()
	{
		
	}
	
	function showExpenseForm()
	{
		$userId = $this->userLoggedIn->id;
		$elementFormExpense = new Form($this->connection);
		$strPayment = $elementFormExpense->displayInputForPaymentMethod($userId);
		$strCategoryExpense = $elementFormExpense->displayInputForExpensesCategory($userId);
		include 'templates/expenseForm.php';
	}
  
    function logout()
    {
		session_start();
	
	    session_unset();
	}
  
}
?>