<?php
class IncomeManagement
{
    private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
    function addIncome($userId)
    {
	    if (!$this->connection) return SERVER_ERROR;
	
	    if(!isset($_POST['amount'])) return FORM_DATA_MISSING;
		
		$comment = $_POST['comment'];
		$comment = htmlentities($comment,ENT_QUOTES, "UTF-8");
		$_SESSION['formCommentIncome'] = $comment;
		
		$amount = $_POST['amount'];
		$amount = htmlentities($amount,ENT_QUOTES, "UTF-8");
		
		$va = new Validation();
		switch ($va->validationAmount($amount)) {
		    case AMOUNT_NOT_NUMBER:
		        return AMOUNT_NOT_NUMBER;
			case AMOUNT_TOO_HIGH:
			    return AMOUNT_TOO_HIGH;
	    }
		$_SESSION['formAmountIncome'] = $amount;
		
		
		$date = $_POST['date'];
		$date = htmlentities($date,ENT_QUOTES, "UTF-8");
		switch ($va->validationDate($date)) {
		    case NO_DATE:
		        return NO_DATE;
			case WRONG_DATE:
			    return WRONG_DATE;
		}
		$_SESSION['formDateIncome']= $date;
		
		//if categories Income are selected
		if (isset($_POST['categoryOfIncome'])) {
			$category = $_POST['categoryOfIncome'];
			$_SESSION['formCategoryIncome'] = $category;
		} else {
			return NO_CATEGORY;	 
		}
		if ($va->validationComment($comment) == COMMENT_TOO_LONG) {
				return COMMENT_TOO_LONG;
		}
	
	    $sql="INSERT INTO incomes VALUES (NULL, '$userId',(SELECT id FROM incomes_category_assigned_to_users WHERE user_id ='$userId' AND name='$category'),'$amount','$date','$comment')";

		//Adding a Income to the database
		if ($this->connection->query($sql)) {
			return ACTION_OK;
		} else {
			return SERVER_ERROR;
		}
    }	
}