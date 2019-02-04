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
		$userId = $this->userLoggedIn->id;
		$expenseM = new ExpenseManagement($this->connection);
		return $expenseM->addExpense($userId);
		
	}
	
	function showExpenseForm($statement)
	{
		$userId = $this->userLoggedIn->id;
		$elementFormExpense = new Form($this->connection);
		$strPayment = $elementFormExpense->displayInputForPaymentMethod($userId);
		$strCategoryExpense = $elementFormExpense->displayInputForExpensesCategory($userId);
		include 'templates/expenseForm.php';
	}
	
	function addIncome()
	{
		$userId = $this->userLoggedIn->id;
		$incomeM = new IncomeManagement($this->connection);
		return $incomeM->addIncome($userId);
		
	}
	
	function showIncomeForm($statement)
	{
		$userId = $this->userLoggedIn->id;
		$elementFormIncome = new Form($this->connection);
		$strCategoryIncome = $elementFormIncome->displayInputForIncomesCategory($userId);
		include 'templates/incomeForm.php';
	}
	
	function savePeriod()
	{
		$balance = new Balance($this->connection);
		return $balance->savePeriod();	
	}
	
	function saveDate()
	{
		$balance = new Balance($this->connection);
		return $balance->saveDate();	
	}
	
	function viewBalance()
	{
		$userId = $this->userLoggedIn->id;
		$balance = new Balance($this->connection);
		
		$dates = $balance->getDatesOfPeriodOfTime();
		$balanceFront = new BalanceFront($this->connection);
		$tableIncomes = $balanceFront->viewIncomesStatement($dates, $userId);
		
		include 'templates/viewBalance.php';
		
	}
  
    function logout()
    {
		session_start();
	
	    session_unset();
	}
  
}
?>