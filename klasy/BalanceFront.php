<?php
class BalanceFront
{
	private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
	function viewIncomesStatement($dates,$userId)
	{
		$startDate = $dates[0];
		$endDate = $dates[1];
		$sql = "SELECT c.name, SUM(i.amount) FROM users u 
		INNER JOIN incomes i ON u.id = i.user_id 
		INNER JOIN incomes_category_assigned_to_users c ON i.income_category_assigned_to_user_id = c.id 
		WHERE u.id = $userId AND i.date_of_income >= '$startDate' 
		AND  i.date_of_income <= '$endDate' GROUP BY c.id";
		
		$resultOfQuery=$this->connection->query($sql);
		
		if (!$resultOfQuery) return SERVER_ERROR;
		
		$howCategory=$resultOfQuery->num_rows;
		$str = '';	
		if($howCategory>0) {
			$str .= '<article>';
			$str .= '<h4>Zestawienie przychodów dla poszczególnych kategorii w okresie od '.$startDate.' do '.$endDate.'</h4>';
										
			$str .= '<div class="table-responsive text-left">';          
			$str .= '<div class="table-responsive">';         
			$str .= '<table class="table table-striped table-bordered table-condensed">'; 
			$str .= '<thead>'; 
			$str .= '<tr>'; 
			$str .= '<th>Nazwa kategorii</th>'; 
			$str .= '<th>Suma przychodów [zł]</th>'; 
			$str .= '</tr>'; 
			$str .= '</thead>'; 
			$str .= '<tbody>'; 
			
			while ($row = $resultOfQuery->fetch_assoc())
				{
					$str .= '<tr>'; 
					$str .= '<td>'.$row['name'].'</td>'; 
					$str .= '<td>'.$row['SUM(i.amount)'].'</td>'; 
					$str .= '</tr>'; 
				} 
			
			$resultOfQuery->free_result();
			$str .= '</tbody>'; 
			$str .= '</table>'; 
			$str .= '</div>'; 
			$str .= '</div>'; 							
			$str .= '</article>'; 	
		} else {
		    $str .= '<h4 class="bilansHeader">Brak przychodów w okresie od '.$startDate.' do '.$endDate.'</h4>';
		}
        return $str;		
	}
	
	function viewExpensesStatement($dates, $userId)
	{
		$startDate = $dates[0];
		$endDate = $dates[1];
		
		$sql ="SELECT c.name, SUM(e.amount) FROM users u 
		INNER JOIN expenses e ON u.id = e.user_id 
		INNER JOIN expenses_category_assigned_to_users c ON e.expense_category_assigned_to_user_id = c.id 
		WHERE u.id = $userId AND e.date_of_expense >= '$startDate' 
		AND  e.date_of_expense <= '$endDate' GROUP BY c.id";
			
		$resultOfQuery=$this->connection->query($sql);
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$howCategory=$resultOfQuery->num_rows;
		$str = '';	
		if($howCategory>0)
		{
			$noExpenses = false;
			
			$str .= '<article>';
			$str .= '<h4>Zestawienie wydatków dla poszczególnych kategorii w okresie od '.$startDate.' do '.$endDate.'</h4>';
			$str .= '<div class="table-responsive text-left">';          
			$str .= '<div class="table-responsive">';         
			$str .= '<table class="table table-striped table-bordered table-condensed">'; 
			$str .= '<thead>'; 
			$str .= '<tr>'; 
			$str .= '<th>Nazwa kategorii</th>'; 
			$str .= '<th>Suma przychodów [zł]</th>'; 
			$str .= '</tr>'; 
			$str .= '</thead>'; 
			$str .= '<tbody>';
			$i = 0;								
			while ($row = $resultOfQuery->fetch_assoc()) {
				$str .= '<tr>'; 
				$str .= '<td>'.$row['name'].'</td>';
				$str .= '<td>'.$row['SUM(e.amount)'].'</td>';
				$str .= '</tr>'; 
				$i=$i+1;
			} 
			$resultOfQuery->free_result();
			$str .= '</tbody>'; 
			$str .= '</table>'; 
			$str .= '</div>'; 
		    $str .= '</div>'; 							
			$str .= '</article>'; 	
		} else {
			$str .= '<h4 class="bilansHeader">Brak wydatków w okresie od '.$startDate.' do '.$endDate.'</h4>';
			$noExpenses = true;
			
		}
        return $str;
	}
	
	function getDataPoints($dates, $userId)
	{
		$startDate = $dates[0];
		$endDate = $dates[1];
		
		$sql ="SELECT c.name, SUM(e.amount) FROM users u 
		INNER JOIN expenses e ON u.id = e.user_id 
		INNER JOIN expenses_category_assigned_to_users c ON e.expense_category_assigned_to_user_id = c.id 
		WHERE u.id = $userId AND e.date_of_expense >= '$startDate' 
		AND  e.date_of_expense <= '$endDate' GROUP BY c.id";
			
		$resultOfQuery=$this->connection->query($sql);
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$howCategory=$resultOfQuery->num_rows;	
		if($howCategory>0)
		{
			$noExpenses = false;
			$i = 0;								
			while ($row = $resultOfQuery->fetch_assoc()) {
				$dataPoints[$i]["label"]= $row['name'];
				$dataPoints[$i]["y"]= $row['SUM(e.amount)'];
				$i=$i+1;
			} 
		}
		return $dataPoints;
		
	}
	
	function getSumIncomes($dates, $userId)
	{
		$startDate = $dates[0];
		$endDate = $dates[1];
		
		$sql ="SELECT SUM(i.amount) FROM users u INNER JOIN incomes i ON u.id = i.user_id WHERE u.id = $userId AND i.date_of_income >= '$startDate' AND  i.date_of_income <= '$endDate'";
		
		$MyDB = new MyDB;
		
		$sumIncomes = $this->connection->getQuerySingleResult($sql);
		
		return $sumIncomes;		
    }
	
    function getSumExpenses($dates, $userId)
	{
		$startDate = $dates[0];
		$endDate = $dates[1];
		
		$sql ="SELECT SUM(e.amount) FROM users u INNER JOIN expenses e ON u.id = e.user_id WHERE u.id = $userId AND e.date_of_expense >= '$startDate' AND  e.date_of_expense <= '$endDate'";
		
		$MyDB = new MyDB;
		
		$sumExpenses = $this->connection->getQuerySingleResult($sql);
		
		return $sumExpenses;		
    }

	function getNoExpenses($dates, $userId)
	{
		$startDate = $dates[0];
		$endDate = $dates[1];
		
		$sql ="SELECT c.name, SUM(e.amount) FROM users u 
		INNER JOIN expenses e ON u.id = e.user_id 
		INNER JOIN expenses_category_assigned_to_users c ON e.expense_category_assigned_to_user_id = c.id 
		WHERE u.id = $userId AND e.date_of_expense >= '$startDate' 
		AND  e.date_of_expense <= '$endDate' GROUP BY c.id";
			
		$resultOfQuery=$this->connection->query($sql);
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$howCategory=$resultOfQuery->num_rows;
		if ($howCategory>0) {
			$noExpenses = false;
		} else {
			$noExpenses = true;
		}
		return $noExpenses;
		
	}
	
}