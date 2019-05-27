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
	
	function datesForQuery($dateExpense)
	{
		$now = date('Y-m-d');
		
		if ($dateExpense == $now) {
			
			$date[0] = date('Y-m-d',mktime(0,0,0,date('m'), 1, date('Y')));
			$date[1] = date('Y-m-d',strtotime("now"));
			
		} else if ($dateExpense < $now) {
			
			$month = date("n",strtotime($dateExpense));
			$year = date("Y",strtotime($dateExpense));
			$lastDayMonth = date("t",strtotime($dateExpense));
			$date[0] = date('Y-m-d',mktime(0,0,0,$month, 1, $year));
			$date[1] = date('Y-m-d',mktime(0,0,0,$month, $lastDayMonth, $year));; 
		}
		
		return $date;
	}
	
	
	function strLimitTable($userId, $nameCategory, $amount, $dateExpense)
	{
		
		$date = $this->datesForQuery($dateExpense);
		$startDate = $date[0];
		$endDate = $date[1];
		
		$sql ="SELECT SUM(amount) FROM `expenses` WHERE `user_id`=$userId AND `expense_category_assigned_to_user_id`=(SELECT id FROM expenses_category_assigned_to_users WHERE user_id ='$userId' AND name ='$nameCategory') AND date_of_expense >= '$startDate' 
		AND  date_of_expense <= '$endDate'";
		
		
		$resultOfQuery=$this->connection->query($sql);
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$str = '';	
	
		$row = $resultOfQuery->fetch_assoc();
		if ($row['SUM(amount)'] == NULL) {
			$sumExpenses = 0.00;
		} else {
			$sumExpenses = $row['SUM(amount)'];
		}
			
		$sqlLimits ="SELECT limits FROM `expenses_category_assigned_to_users` WHERE `user_id`=$userId AND `name`='$nameCategory'";
		
		$result=$this->connection->query($sqlLimits);
			
		if(!$result) return SERVER_ERROR;
		$rowLimits = $result->fetch_assoc();	
			
		if ($rowLimits['limits'] == NULL) {
			$limits = 0.00;
		} else {
			$limits = $rowLimits['limits'];
		}
			
		$difference = $limits - $sumExpenses;
		$result = $sumExpenses + $amount;
			
		$str .= 'Możesz wydać jeszcze '.$difference.' zł w kategorii '.$nameCategory.'<br/>';
		$str .= '<div id="limitTable"';
		if ($limits >= $result) {
			$str .= 'class="success">';
		} else {
			$str .= 'class="fail">';	
		}
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
	
        return $str;
	}
	
}
