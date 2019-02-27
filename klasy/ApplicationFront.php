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

	
	function showEditExpenseForm($action, $id, $statement)
	{
		$userId = $this->userLoggedIn->id;
		$expense = new ExpenseManagement($this->connection);
		return $expense->showEditForm($action, $id, $userId, $statement);
	}
	
	function editExpense($action,$id)
	{
		$userId = $this->userLoggedIn->id;
		$expense = new ExpenseManagement($this->connection);
		return $expense->editExpense($action,$id, $userId);
		
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
		$tableAllExpenses = $balanceFront->showTableWithExpenses($dates, $userId);
		$tableAllIncomes = $balanceFront->showTableWithIncomes($dates, $userId);
		$tableIncomes = $balanceFront->viewIncomesStatement($dates, $userId);
		$tableExpenses = $balanceFront->viewExpensesStatement($dates, $userId);
		$noExpenses	= $balanceFront->getNoExpenses($dates, $userId);
		if ($noExpenses == false) {
			$dataPoints = $balanceFront->getDataPoints($dates, $userId);
		}
		$sumIncomes = $balanceFront->getSumIncomes($dates, $userId);
        $sumExpenses = $balanceFront->getSumExpenses($dates, $userId); 
        
		include 'templates/viewBalance.php';
	}
  
    function saveNewPassword()
	{
		$userId = $this->userLoggedIn->id;
	   	$newPassword = new Settings($this->connection);
		return $newPassword->saveNewPassword($userId);
	}
	
	function showCategoryPersonalization($statement)
	{
		$userId = $this->userLoggedIn->id;
		$tableCategory = new Settings($this->connection);
		$strCategoryExpenses = $tableCategory->showTableCategoryExpenses($userId);
		$strCategoryIncomes = $tableCategory->showTableCategoryIncomes($userId);
		
		include 'templates/categoryPersonalization.php';
    }
	
	function addCategoryForm($statement,$wtd)
	{
		$userId = $this->userLoggedIn->id;
		$tableCategory = new Settings($this->connection);
		$strCategoryExpenses = $tableCategory->showTableCategoryExpenses($userId);
		$strCategoryIncomes = $tableCategory->showTableCategoryIncomes($userId);
		
		include 'templates/addCategoryForm.php';
    }
	
	function addNewCategory($wtd)
	{
		$userId = $this->userLoggedIn->id;
		$newCategory = new Settings($this->connection);
		return $newCategory->addNewCategory($userId,$wtd);
	}
	
	function editCategoryForm($statement,$wtd)
	{
		$userId = $this->userLoggedIn->id;
		$elementForm = new Form($this->connection);
		$strCategoryIncome = $elementForm->displayInputForIncomesCategory($userId);
		$strCategoryExpense = $elementForm->displayInputForExpensesCategory($userId);
		
		include 'templates/editCategoryForm.php';
	}
	
	function editCategory($wtd)
	{
		$userId = $this->userLoggedIn->id;
		$editCategory = new Settings($this->connection);
		return $editCategory->editCategory($userId,$wtd);
	}
	
	function deleteCategoryForm($statement,$wtd)
	{
		$userId = $this->userLoggedIn->id;
		$elementForm = new Form($this->connection);
		$strCategoryIncome = $elementForm->displayInputForIncomesCategory($userId);
		$strCategoryExpense = $elementForm->displayInputForExpensesCategory($userId);
		
		include 'templates/deleteCategoryForm.php';
	}
	
	function deleteCategory($wtd)
	{
		$userId = $this->userLoggedIn->id;
		$deleteCategory = new Settings($this->connection);
		return $deleteCategory->deleteCategory($userId, $wtd);
	}
	
	function deleteEntry($wtd,$id)
	{
		$deleteEntry = new Entery($this->connection);
		return $deleteEntry->deleteEntery($wtd,$id);
		
	}
	
	function editEntery($wtd, $id)
	{
		$editEntry = new Entery($this->connection);
		return $editEntry->editEntery($wtd,$id);
	}
	
	
	function showStatement($statement)
	{
		include 'templates/showStatement.php';
	}
    function logout()
    {
		session_start();
	
	    session_unset();
	}
  
}
?>