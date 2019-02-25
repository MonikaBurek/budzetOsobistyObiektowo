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
			
			while ($row = $resultOfQuery->fetch_assoc()) {
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
		
		$resultOfQuery=$this->connection->query($sql);
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		if ($row = $resultOfQuery->fetch_row()) {
            return $row[0];
        } else {
        return false;
        }		
    }
	
    function getSumExpenses($dates, $userId)
	{
		$startDate = $dates[0];
		$endDate = $dates[1];
		
		$sql ="SELECT SUM(e.amount) FROM users u INNER JOIN expenses e ON u.id = e.user_id WHERE u.id = $userId AND e.date_of_expense >= '$startDate' AND  e.date_of_expense <= '$endDate'";
		
		$resultOfQuery=$this->connection->query($sql);
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		if ($row = $resultOfQuery->fetch_row()) {
            return $row[0];
        } else {
        return false;
        }		
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
	function showTableWithExpenses($dates, $userId)
	{
		$startDate = $dates[0];
		$endDate = $dates[1];
		
		$sql ="SELECT e.id, e.amount, e.date_of_expense, p.name AS payment, c.name AS category, e.expense_comment FROM users u 
		INNER JOIN expenses e ON u.id = e.user_id 
		INNER JOIN expenses_category_assigned_to_users c ON e.expense_category_assigned_to_user_id = c.id
		INNER JOIN payment_methods_assigned_to_users p ON e.payment_method_assigned_to_user_id = p.id
		WHERE u.id = $userId AND e.date_of_expense >= '$startDate' 
		AND  e.date_of_expense <= '$endDate'";
			
		$resultOfQuery=$this->connection->query($sql);
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$how=$resultOfQuery->num_rows;
		$str = '';	
		if($how>0)
		{
			$str .= '<article>';
			$str .= '<h4>Zestawienie wydatków w okresie od '.$startDate.' do '.$endDate.'</h4>';
			$str .= '<div class="table-responsive text-left">';          
			$str .= '<div class="table-responsive">';         
			$str .= '<table class="table table-striped table-bordered table-condensed">'; 
			$str .= '<thead>'; 
			$str .= '<tr>'; 
			$str .= '<th>Id</th>'; 
			$str .= '<th>Kwota [zł]</th>'; 
			$str .= '<th>Data</th>'; 
			$str .= '<th>Sposób płatności</th>'; 
			$str .= '<th>Kategoria</th>';
			$str .= '<th>Komentarz</th>';
			$str .= '<th>Edytuj</th>';
			$str .= '<th>Usuń</th>';
			$str .= '</tr>'; 
			$str .= '</thead>'; 
			$str .= '<tbody>';			
			while ($row = $resultOfQuery->fetch_assoc()) {
				$str .= '<tr>'; 
				$str .= '<td>'.$row['id'].'</td>';
				$str .= '<td>'.$row['amount'].'</td>';
				$str .= '<td>'.$row['date_of_expense'].'</td>';
				$str .= '<td>'.$row['payment'].'</td>';
				$str .= '<td>'.$row['category'].'</td>';
				$str .= '<td>'.$row['expense_comment'].'</td>';
				$str .= '<td style="text-align:center;"><a href="index.php?action=editEntery&amp;wtd=expense;&ampid='.$row['id'].'"><span class="colorIcon"><i class="icon-pencil"></i></span></a></td>';
				$str .= '<td style="text-align:center;"><a href="index.php?action=deleteEntery&amp;wtd=expense&amp;id='.$row['id'].'"><span class="colorIcon"><i class="icon-trash"></i></span></a></td>';
				$str .= '</tr>'; 				
			} 
			$resultOfQuery->free_result();
			$str .= '</tbody>'; 
			$str .= '</table>'; 
			$str .= '</div>'; 
		    $str .= '</div>'; 							
			$str .= '</article>'; 	
		} else {
			$str .= '<h4 class="bilansHeader">Brak wydatków w okresie od '.$startDate.' do '.$endDate.'</h4>';
			
		}
        return $str;
	}
	
	function showTableWithIncomes($dates, $userId)
	{
		$startDate = $dates[0];
		$endDate = $dates[1];
		
		$sql ="SELECT i.id, i.amount, i.date_of_income, c.name AS category, i.income_comment FROM users u 
		INNER JOIN incomes i ON u.id = i.user_id 
		INNER JOIN incomes_category_assigned_to_users c ON i.income_category_assigned_to_user_id = c.id
		WHERE u.id = $userId AND i.date_of_income >= '$startDate' 
		AND  i.date_of_income <= '$endDate'";
			
		$resultOfQuery=$this->connection->query($sql);
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$how=$resultOfQuery->num_rows;
		$str = '';	
		if($how>0)
		{
			$str .= '<article>';
			$str .= '<h4>Zestawienie przychodów w okresie od '.$startDate.' do '.$endDate.'</h4>';
			$str .= '<div class="table-responsive text-left">';          
			$str .= '<div class="table-responsive">';         
			$str .= '<table class="table table-striped table-bordered table-condensed">'; 
			$str .= '<thead>'; 
			$str .= '<tr>'; 
			$str .= '<th>Id</th>'; 
			$str .= '<th>Kwota [zł]</th>'; 
			$str .= '<th>Data</th>'; 
			$str .= '<th>Kategoria</th>';
			$str .= '<th>Komentarz</th>';
			$str .= '<th>Edytuj</th>';
			$str .= '<th>Usuń</th>';
			$str .= '</tr>'; 
			$str .= '</thead>'; 
			$str .= '<tbody>';			
			while ($row = $resultOfQuery->fetch_assoc()) {
				$str .= '<tr>'; 
				$str .= '<td>'.$row['id'].'</td>';
				$str .= '<td>'.$row['amount'].'</td>';
				$str .= '<td>'.$row['date_of_income'].'</td>';
				$str .= '<td>'.$row['category'].'</td>';
				$str .= '<td>'.$row['income_comment'].'</td>';
				$str .= '<td style="text-align:center;"><a href="index.php?action=editEntery&amp;wtd=income&amp;id='.$row['id'].'"><span class="colorIcon"><i class="icon-pencil"></i></span></a></td>';
				$str .= '<td style="text-align:center;"><a href="index.php?action=deleteEntery&amp;wtd=income&amp;id='.$row['id'].'"><span class="colorIcon"><i class="icon-trash"></i></span></a></td>';
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
}