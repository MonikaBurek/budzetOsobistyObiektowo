<?php
class IncomeManagement
{
    private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
	function checkEditRights($id, $userId)
	{
		if (!$this->connection) return SERVER_ERROR;
		
		$sql = "SELECT `user_id` FROM `incomes` WHERE `id`= $id AND `user_id`= $userId";
		
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
			
			$sql = "SELECT * FROM `incomes` WHERE `id`=$id";
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
					if (!isset($_SESSION['formAmountIncome'])) {
						$_SESSION['formAmountIncome'] = $row['amount'];
						$_SESSION['formDateIncome'] = $row['date_of_income'];
						$_SESSION['formCommentIncome'] = $row['income_comment'];
					}
					$incomeCategoryId = $row['income_category_assigned_to_user_id'];
				}
		    }
			if (!isset($_SESSION['formCategoryIncome'])) {
			$sql2 = "SELECT `name` FROM `incomes_category_assigned_to_users` WHERE id=$incomeCategoryId";
			if ($resultOfQuerySql2=$this->connection->query($sql2)) {
			$how=$resultOfQuerySql2->num_rows;
				if ($how>0) {
					
					$row = $resultOfQuerySql2->fetch_assoc();
					
					   $_SESSION['formCategoryIncome'] =  $row['name'];
					}					   
				}
			}
		    $parametr = 'modifyIncome';
		
		} elseif ($case =='add') { //New Income
		
			if (!isset($_SESSION['formAmountIncome'])) {
			$_SESSION['formAmountIncome'] = '';
			$_SESSION['formDateIncome'] = date('Y-m-d');
			$_SESSION['formCommentIncome'] = '';
			$_SESSION['formCategoryIncome'] =  '';
            $_SESSION['formPaymentMethod'] =  '';
			}			
			$parametr = 'addIncome';
		}
		
		$elementFormIncome = new Form($this->connection);
		$strCategoryIncome = $elementFormIncome->displayInputForIncomesCategory($userId);
		
		include 'templates/incomeForm.php';
	}
	
	
	function editIncome($case, $id, $userId)
	{
		if (!$this->connection) return SERVER_ERROR;
		
		if (!isset($_POST['amount'])) return FORM_DATA_MISSING;
		
		if(($case == 'edit' && $id < 1) || ($case == 'add' && $id < 0)) {
			return INCORRECT_ID;
		}
		
		$comment = $_POST['comment'];
		$comment = htmlentities($comment,ENT_QUOTES, "UTF-8");
		$_SESSION['formCommentIncome'] = $comment;
		
		$amount = $_POST['amount'];
		$amount = htmlentities($amount,ENT_QUOTES, "UTF-8");
		$_SESSION['formAmountIncome'] = $amount;
		
		$date = $_POST['date'];
		$date = htmlentities($date,ENT_QUOTES, "UTF-8");
		$_SESSION['formDateIncome'] = $date;
		
		
		if (isset($_POST['categoryOfIncome'])) {
			$category = $_POST['categoryOfIncome'];
			$_SESSION['formCategoryIncome'] = $category;
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
		
		if (!isset($_POST['categoryOfIncome'])) {
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
			
			$query = "UPDATE incomes SET income_category_assigned_to_user_id = (SELECT id FROM incomes_category_assigned_to_users WHERE user_id ='$userId' AND name ='$category'),amount ='$amount', date_of_income ='$date', income_comment='$comment' WHERE id=$id";
			
		} else {
			$query = "INSERT INTO incomes VALUES (NULL, '$userId',(SELECT id FROM incomes_category_assigned_to_users WHERE user_id ='$userId' AND name ='$category'),'$amount','$date','$comment')";
		}

		if ($this->connection->query($query)) {
			return ACTION_OK;
		} else {
			return SERVER_ERROR;
		}
	}
	
}