<?php
class ExpenseManagement
{
    private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
    function addExpense()
    {
	    if (!$this->connection) return SERVER_ERROR;
	
	    if(!isset($_POST['amount'])) return FORM_DATA_MISSING;
		
		$comment = $_POST['comment'];
		$comment = htmlentities($comment,ENT_QUOTES, "UTF-8");
		$_SESSION['formCommentExpense'] = $comment;
		
		$amount = $_POST['amount'];
		$amount = htmlentities($amount,ENT_QUOTES, "UTF-8");
		
		$va = new Validation();
		switch ($va->validationAmount($amount)) {
		    case AMOUNT_NOT_NUMBER:
		        return AMOUNT_NOT_NUMBER;
			case AMOUNT_TOO_HIGH:
			    return AMOUNT_TOO_HIGH;
	    }
		$_SESSION['formAmountExpense'] = $amount;
		
		
		$date = $_POST['date'];
		$date = htmlentities($date,ENT_QUOTES, "UTF-8");
		switch ($va->validationDate($date)) {
		    case NO_DATE:
		        return NO_DATE;
			case WRONG_DATE:
			    return WRONG_DATE;
		}
		$_SESSION['formDateExpense']= $date;
		
		//if paymentmethod  are selected
		if (isset($_POST['paymentMethod'])) {
			$paymentMethod = $_POST['paymentMethod'];
			$_SESSION['formPaymentMethod'] = $paymentMethod;
		} else {
			return NO_PAYMENT_METHOD;
		}
		
		//if categories expense are selected
		if (isset($_POST['categoryOfExpense'])) {
			$category = $_POST['categoryOfExpense'];
			$_SESSION['formCategoryExpense'] = $category;
		} else {
			return NO_CATEGORY;	 
		}
		
		if ($va->validationComment($comment) == COMMENT_TOO_LONG) {
				return COMMENT_TOO_LONG;
		}
		
		
		
		
		
		
		
		return ACTION_OK;
    }
	
	
}