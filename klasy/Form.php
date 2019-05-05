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
		$resultOfQuery=$this->connection->query("SELECT name, limits FROM expenses_category_assigned_to_users WHERE user_id ='$userId'");
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$howNames = $resultOfQuery->num_rows;
		$str = '';	
		if ($howNames>0) {
			while ($row = $resultOfQuery->fetch_assoc()) {
				$str .= '<div class="row">';
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
					
				$str .= '">'.$row['name']. '</br>';
				
					if ($row['limits'] > 0)
					{
						$str .= '<span class="limits"> Limit: '.$row['limits'].'</span>';
					}
				
				
				$str .= '</label></div>';
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
	
	function displayInputForIncomesCategory($userId)
	{
		$resultOfQuery=$this->connection->query("SELECT name FROM incomes_category_assigned_to_users WHERE user_id ='$userId'");
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$howNames = $resultOfQuery->num_rows;
		$str = '';	
		if ($howNames>0) {
			while ($row = $resultOfQuery->fetch_assoc()) {
				$str .= '<div class="row ">';
				$str .= '<div class="col-sm-4 col-sm-offset-1">';
				$str .= '<label class="radio-inline">';
				$str .= '<input type="radio" name="categoryOfIncome" value="'.$row['name'];
					
					if(isset($_SESSION['formCategoryIncome']))
					{
						if($row['name'] == $_SESSION['formCategoryIncome']) 
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
	
	function strLimitTable($userId, $nameCategory, $amount)
	{
		$sql ="SELECT SUM(e.amount), c.limits FROM users u 
		INNER JOIN expenses e ON u.id = e.user_id 
		INNER JOIN expenses_category_assigned_to_users c ON e.expense_category_assigned_to_user_id = c.id
		WHERE u.id = $userId AND c.name = '$nameCategory'";
			
		$resultOfQuery=$this->connection->query($sql);
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$how=$resultOfQuery->num_rows;
		$str = '';	
		if($how>0)
		{
			$row = $resultOfQuery->fetch_assoc();
			$sumExpenses = $row['SUM(e.amount)'];
			$limits = $row['limits'];
			$difference = $limits - $sumExpenses;
			$result =$sumExpenses + $amount;
			
			$str .= 'Możesz wydać jeszcze '.$difference.' zł w kategorii '.$nameCategory.'<br/>';
			$str .= '<div id="limitTable">';
			$str .= '<div class="table-responsive text-center">';                
			$str .= '<table class="tableInfo table-condensed">'; 
			$str .= '<thead>'; 
			$str .= '<tr>'; 
			$str .= '<th>Limit</th>'; 
			$str .= '<th>Dotychczas wydano</th>'; 
			$str .= '<th>Różnica</th>'; 
			$str .= '<th>Wydatki + wpisana kwota</th>'; 
			$str .= '</tr>'; 
			$str .= '</thead>'; 
			$str .= '<tbody>';	
           		
			
			$str .= '<tr>'; 
			$str .= '<td>'.$limits.'</td>';
			$str .= '<td>'.$sumExpenses.'</td>';
			
			$str .= '<td>'.$difference.'</td>';
			$str .= '<td>'.$result.'</td>';
			$str .= '</tr>'; 	
			
			$resultOfQuery->free_result();
			$str .= '</tbody>'; 
			$str .= '</table>'; 
			$str .= '</div>'; 
			$str .= '</div>'; 											
		} else {
			$str .= '';
			
		}
        return $str;
	
	}
}
