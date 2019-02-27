<?php
class ExpenseManagement
{
    private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
	function checkEditRights($id, $userId)
	{
		if (!$this->connection) return SERVER_ERROR;
		
		$sql = "SELECT `user_id` FROM `expenses` WHERE `id`= $id AND `user_id`= $userId";
		
		$resultOfQuery = $this->connection->query($sql);
				
		if (!$resultOfQuery) return SERVER_ERROR;
					
		$how = $resultOfQuery->num_rows;
		if ($how > 0) {
			return USER_HAVE_RIGHTS;
		}
		return NOT_ENOUGH_RIGHTS;
	}
	
	function showEditForm($case, $id, $userId, $statement)
	{
		if (!$this->connection) return SERVER_ERROR;
		
		if ($case == 'edit') {
			
			if ($this->checkEditRights($id,$userId) == NOT_ENOUGH_RIGHTS) {
				echo 'Brak uprawnień';
				return NOT_ENOUGH_RIGHTS;			
			}
			
			$sql = "SELECT * FROM `expenses` WHERE `id`=$id";
			if (!$result = $this->connection->query($sql)) {
				echo 'Brak połaczenia z bazą';
				return SERVER_ERROR;
			}
			
			if (!$row1 = $result->fetch_assoc()) {
				echo 'brak wyniku zapytania';
				return INCORRECT_ID;
			}			
			
			if ($resultOfQuery = $this->connection->query($sql)) {
			$how = $resultOfQuery->num_rows;
				if ($how>0) {
					$row = $resultOfQuery->fetch_assoc() ;
					$_SESSION['formAmountExpense'] = $row['amount'];
					$_SESSION['formDateExpense'] = $row['date_of_expense'];
					$expenseCategoryId = $row['expense_category_assigned_to_user_id'];
					$paymentMethodId = $row['payment_method_assigned_to_user_id'];
					$_SESSION['formCommentExpense'] = $row['expense_comment'];
					
				}
		    }
			$sql2 = "SELECT `name` FROM `expenses_category_assigned_to_users` WHERE id=$expenseCategoryId";
			if ($resultOfQuerySql2=$this->connection->query($sql2)) {
			$how=$resultOfQuerySql2->num_rows;
				if ($how>0) {
					$row = $resultOfQuerySql2->fetch_assoc();
					$_SESSION['formCategoryExpense'] =  $row['name'];	
				}
			}
			
			$sql3 = "SELECT `name` FROM `payment_methods_assigned_to_users` WHERE id = $paymentMethodId";
			if ($resultOfQuerySql3 = $this->connection->query($sql3)) {
			$how = $resultOfQuerySql3->num_rows;
				if ($how>0) {
					$row = $resultOfQuerySql3->fetch_assoc();
					$_SESSION['formPaymentMethod'] =  $row['name'];	
				}
			}
		    $parametr = 'modifyExpense';
		
		} elseif ($case =='add') { //New expense
			$_SESSION['formAmountExpense'] = '';
			$_SESSION['formDateExpense'] = date('Y-m-d');
			$_SESSION['formCommentExpense'] = '';
			$_SESSION['formCategoryExpense'] =  '';
            $_SESSION['formPaymentMethod'] =  '';				
			$parametr = 'addExpense';
		}
		
		
		$elementFormExpense = new Form($this->connection);
		$strPayment = $elementFormExpense->displayInputForPaymentMethod($userId);
		$strCategoryExpense = $elementFormExpense->displayInputForExpensesCategory($userId);
		
		include 'templates/expenseForm.php';
	}
	
	
	function editExpense($case, $id, $userId)
	{
		if (!$this->connection) return SERVER_ERROR;
		
		if (!isset($_POST['amount'])) return FORM_DATA_MISSING;
		
		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			echo $id ;
		$_SESSION['formId'] = $id;
		}
		
		if(($case == 'edit' && $id < 1) || ($case == 'add' && $id < 0)) {
			return INCORRECT_ID;
		}
		
		$comment = $_POST['comment'];
		$comment = htmlentities($comment,ENT_QUOTES, "UTF-8");
		$_SESSION['formCommentExpense'] = $comment;
		
		$amount = $_POST['amount'];
		$amount = htmlentities($amount,ENT_QUOTES, "UTF-8");
		$_SESSION['formAmountExpense'] = $amount;
		
		$date = $_POST['date'];
		$date = htmlentities($date,ENT_QUOTES, "UTF-8");
		$_SESSION['formDateExpense'] = $date;
		
		if (isset($_POST['paymentMethod'])) {
			$paymentMethod = $_POST['paymentMethod'];
			$_SESSION['formPaymentMethod'] = $paymentMethod;
		}
		
		if (isset($_POST['categoryOfExpense'])) {
			$category = $_POST['categoryOfExpense'];
			$_SESSION['formCategoryExpense'] = $category;
		}
		
		$va = new Validation();
		switch ($va->validationAmount($amount)) {
		    case AMOUNT_NOT_NUMBER:
		        return AMOUNT_NOT_NUMBER;
			case AMOUNT_TOO_HIGH:
			    return AMOUNT_TOO_HIGH;
	    }
		
		switch ($va->validationDate($date)) {
		    case NO_DATE:
		        return NO_DATE;
			case WRONG_DATE:
			    return WRONG_DATE;
		}
		
		if (!isset($_POST['paymentMethod'])) {
			return NO_PAYMENT_METHOD;
		}
		
		if (!isset($_POST['categoryOfExpense'])) {
			return NO_CATEGORY;	 
		}
		if ($va->validationComment($comment) == COMMENT_TOO_LONG) {
				return COMMENT_TOO_LONG;
		}
		
		if ($case == 'edit') {
			if ($this->checkEditRights($id,$userId) == NOT_ENOUGH_RIGHTS) {
				echo 'Brak uprawnień';
				return NOT_ENOUGH_RIGHTS;			
			}
			
			$query = "UPDATE expenses SET expense_category_assigned_to_user_id = (SELECT id FROM expenses_category_assigned_to_users WHERE user_id ='$userId' AND name ='$category'),payment_method_assigned_to_user_id = (SELECT id FROM payment_methods_assigned_to_users WHERE user_id ='$userId' AND name='$paymentMethod'),amount ='$amount',date_of_expense ='$date', expense_comment='$comment') WHERE id=$id";
			
		} else {
			$query = "INSERT INTO expenses VALUES (NULL, '$userId',(SELECT id FROM expenses_category_assigned_to_users WHERE user_id ='$userId' AND name ='$category'),(SELECT id FROM payment_methods_assigned_to_users WHERE user_id ='$userId' AND name='$paymentMethod'),'$amount','$date','$comment')";
		}

		if ($this->connection->query($query)) {
			return ACTION_OK;
		} else {
			return SERVER_ERROR;
		}
		
		
	}
}