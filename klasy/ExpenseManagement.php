<?php
class ExpenseManagement
{
    private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
    function addExpense($userId)
    {
	    if (!$this->connection) return SERVER_ERROR;
	
	    if(!isset($_POST['amount'])) return FORM_DATA_MISSING;
		
		$comment = $_POST['comment'];
		$comment = htmlentities($comment,ENT_QUOTES, "UTF-8");
		$_SESSION['formCommentExpense'] = $comment;
		
		$amount = $_POST['amount'];
		$amount = htmlentities($amount,ENT_QUOTES, "UTF-8");
		$_SESSION['formAmountExpense'] = $amount;
		
		$date = $_POST['date'];
		$date = htmlentities($date,ENT_QUOTES, "UTF-8");
		$_SESSION['formDateExpense']= $date;
		
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
	
	    $sql="INSERT INTO expenses VALUES (NULL, '$userId',(SELECT id FROM expenses_category_assigned_to_users WHERE user_id ='$userId' AND name ='$category'),(SELECT id FROM payment_methods_assigned_to_users WHERE user_id ='$userId' AND name='$paymentMethod'),'$amount','$date','$comment')";
		//Adding a expense to the database
		if ($this->connection->query($sql)) {
			return ACTION_OK;
		} else {
			return SERVER_ERROR;
		}
    }	
}