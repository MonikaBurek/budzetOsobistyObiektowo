<?php
class Entery
{
    private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
    function deleteEntery($wtd,$id)
	{
		if ($id < 1 ) { 
		return INCORRECT_ID;
		}
		
		if ($wtd == 'expense') {
		    $sql = "DELETE FROM `expenses` WHERE `id`=$id";
		} elseif ($wtd == 'income') {
		    $sql = "DELETE FROM `incomes` WHERE `id`=$id";	
		} 
		
		if ($this->connection->query($sql)) {
			return ACTION_OK;
		}
		
		return SERVER_ERROR;
		
	}
	
	function showEnteryForm($wtd,$id)
	{
		if ($id < 1 ) { 
		return INCORRECT_ID;
		}
		
		if ($wtd == 'expenseEdit') {
		    $sql = "SELECT * FROM `expenses` WHERE `id`=$id";
			
			
			if ($resultOfQuery=$this->connection->query($sql)) {
			$how=$resultOfQuery->num_rows;
				if ($how>0) {
					while ($row = $resultOfQuery->fetch_assoc()) {
					$_SESSION['formAmountExpense'] = $row['amount'];
					$_SESSION['formDateExpense'] = $row['date_of_expense'];
					$expenseCategoryId = $row['expense_category_assigned_to_user_id'];
					$paymentMethodId = $row['payment_method_assigned_to_user_id'];
					$_SESSION['formCommentExpense'] = $row['expense_comment'];
					}
				}
		    }
			$sql2 = "SELECT `name` FROM `expenses_category_assigned_to_users` WHERE id=$expenseCategoryId";
			$sql3 = "SELECT `name` FROM `payment_methods_assigned_to_users` WHERE id = $paymentMethodId";
			
			if ($resultOfQuerySql2=$this->connection->query($sql2)) {
			$how=$resultOfQuerySql2->num_rows;
				if ($how>0) {
					while ($row = $resultOfQuerySql2->fetch_assoc()) {
					$_SESSION['formCategoryExpense'] =  $row['name'];	
					}
				}
			}
			
			if ($resultOfQuerySql3=$this->connection->query($sql3)) {
			$how=$resultOfQuerySql3->num_rows;
				if ($how>0) {
					while ($row = $resultOfQuerySql3->fetch_assoc()) {
					$_SESSION['formPaymentMethod'] =  $row['name'];	
					}
				}
			}
			
			$_SESSION['action'] = 'expenseEdit';
			
			return SERVER_ERROR;
			
		} elseif ($wtd == 'incomeEdit') {
		    $sql = "SELECT * FROM `incomes` WHERE `id`=$id";
		} 
		
		
		
	}
	
	
	
	function editEntery ($wtd,$id)
	{
		
		return ACTION_OK;
	}
	
	
	
	
}