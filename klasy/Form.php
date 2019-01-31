<?php 
class Form
{
	private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
	function displayInputForPaymentMethod($userId)
	{
		$resultOfQuery = $this->connection->query("SELECT name FROM payment_methods_assigned_to_users WHERE user_id ='$userId'");
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$howNames = $resultOfQuery->num_rows;
		$str = '';	
		if ($howNames>0) {
			while ($row = $resultOfQuery->fetch_assoc()) {
				$str .= '<div class="row ">';
				$str .= '<div class="col-sm-4 col-sm-offset-1">';
				$str .= '<label class="radio-inline">';
				$str .= '<input type="radio" name="paymentMethod" value="'.$row['name'];
					
					if(isset($_SESSION['formPaymentMethod']))
					{
						if($row['name'] == $_SESSION['formPaymentMethod']) 
						{
							$str .= '"checked ="checked"';
						}
					}
					
					$str .= '">'.$row['name'].'</label>';
					$str .= '</div>';
					$str .= '<div class="col-sm-5"></div>';
					$str .= '</div>';	
			}
				
			$resultOfQuery->free_result();
			
	    } else {
			$str .= '<div class="row ">';
			$str .= '<div class="col-sm-4 col-sm-offset-1">';
			$str .= 'Brak metod płatności.';
			$str .= '</div>';
			$str .= '<div class="col-sm-5"></div>';
			$str .= '</div>';			
		}
	
	    return $str;
	}
	
	function displayInputForExpensesCategory($userId)
	{
		$resultOfQuery=$this->connection->query("SELECT name FROM expenses_category_assigned_to_users WHERE user_id ='$userId'");
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$howNames = $resultOfQuery->num_rows;
		$str = '';	
		if ($howNames>0) {
			while ($row = $resultOfQuery->fetch_assoc()) {
				$str .= '<div class="row ">';
				$str .= '<div class="col-sm-4 col-sm-offset-1">';
				$str .= '<label class="radio-inline">';
				$str .= '<input type="radio" name="categoryOfExpense" value="'.$row['name'];
					
					if(isset($_SESSION['formCategoryExpense']))
					{
						if($row['name'] == $_SESSION['formCategoryExpense']) 
						{
							$str .= '"checked ="checked"';
						}
					}
					
					$str .= '">'.$row['name'].'</label>';
					$str .= '</div>';
					$str .= '<div class="col-sm-5"></div>';
					$str .= '</div>';	
			}
				
			$resultOfQuery->free_result();
			
	    } else {
			$str .= '<div class="row ">';
			$str .= '<div class="col-sm-4 col-sm-offset-1">';
			$str .= 'Brak kategorii wydatków.';
			$str .= '</div>';
			$str .= '<div class="col-sm-5"></div>';
			$str .= '</div>';			
		}
	
	    return $str;
	}
}
