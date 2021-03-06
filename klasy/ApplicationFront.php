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
	
	function showEditIncomeForm($action, $id, $statement)
	{
		$userId = $this->userLoggedIn->id;
		$income = new IncomeManagement($this->connection);
		return $income->showEditForm($action, $id, $userId, $statement);
	}
	
	function editIncome($action,$id)
	{
		$userId = $this->userLoggedIn->id;
		$income = new IncomeManagement($this->connection);
		return $income->editIncome($action,$id, $userId);
		
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
		$elementFormExpense = new Form($this->connection);
		$strCategoryExpenseForm = $elementFormExpense->displayInputForExpensesCategory($userId);
		 
		
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
	
	function showDeleteEnteryForm($wtd,$id)
	{
		$userId = $this->userLoggedIn->id;
		$entry = new Entery($this->connection);
		$strOneEnteryIncome = $entry->showTableOneEnteryIncome($id, $userId);
		$strOneEnteryExpense = $entry->showTableOneEnteryExpense($id, $userId);
		include 'templates/deleteEnteryForm.php';
	}
	
	
	function deleteEntry($wtd,$id)
	{
		$userId = $this->userLoggedIn->id;
		$deleteEntry = new Entery($this->connection);
		return $deleteEntry->deleteEntery($wtd,$id, $userId);	
	}
	
	function showStatement($statement)
	{
		include 'templates/showStatement.php';
	}
	
	function checkIfUserExistsInDatabase($name)
	{
		$register = new Registration($this->connection);
		return $register->checkIfUserExists($name);	
	}
	
	function saveLimitToDatabase($nameCategory,$limit)
	{
		$userId = $this->userLoggedIn->id;
		$addLimit = new Settings($this->connection);
		return $addLimit->addLimitForCategory($userId, $nameCategory, $limit);
	}
	
	function ifCategoryHasLimit($nameCategory)
	{
		$userId = $this->userLoggedIn->id;
		$limit = new Settings($this->connection);
		return $limit->ifCategoryHasLimit($userId,$nameCategory);
	}
	
	function informationAboutLimitTable($nameCategory,$amount, $dateExpense)
	{
		$userId = $this->userLoggedIn->id;
		$expense = new Form($this->connection);
		return $expense->strLimitTable($userId, $nameCategory, $amount, $dateExpense);
	}
	
    function logout()
    {
		session_start();
	
	    session_unset();
	}
  
}
?>