<?php
class Entery
{
    private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
	function checkEditRights($wtd, $id, $userId)
	{
		if (!$this->connection) return SERVER_ERROR;
		
		if ($wtd == 'expense') {
		    $sql = "SELECT `user_id` FROM `expenses` WHERE `id`= $id AND `user_id`= $userId";
		} elseif ($wtd == 'income') {
		    $sql = "SELECT `user_id` FROM `incomes` WHERE `id`= $id AND `user_id`= $userId";	
		} 
		
		$resultOfQuery = $this->connection->query($sql);
				
		if (!$resultOfQuery) return SERVER_ERROR;
					
		$how = $resultOfQuery->num_rows;
		if ($how > 0) {
			return USER_HAVE_RIGHTS;
		}
		return NOT_ENOUGH_RIGHTS;
	}
	
    function deleteEntery($wtd, $id, $userId)
	{
		if ($id < 1 ) { 
		return INCORRECT_ID;
		}
		
		if ($this->checkEditRights($wtd, $id,$userId) == NOT_ENOUGH_RIGHTS) {
				echo 'Brak uprawnień';
				return NOT_ENOUGH_RIGHTS;			
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
	
	function showTableOneEnteryExpense($id, $userId)
	{
		
		$sql ="SELECT e.amount, e.date_of_expense, p.name AS payment, c.name AS category, e.expense_comment FROM users u 
		INNER JOIN expenses e ON u.id = e.user_id 
		INNER JOIN expenses_category_assigned_to_users c ON e.expense_category_assigned_to_user_id = c.id
		INNER JOIN payment_methods_assigned_to_users p ON e.payment_method_assigned_to_user_id = p.id
		WHERE u.id = $userId and e.id = $id";
		
		
		$resultOfQuery=$this->connection->query($sql);
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$how=$resultOfQuery->num_rows;
		$str = '';	
		if($how>0)
		{
			$str .= '<article>';
			$str .= '<div class="table-responsive text-left">';          
			$str .= '<div class="table-responsive">';         
			$str .= '<table class="table table-striped table-bordered table-condensed">'; 
			$str .= '<thead>'; 
			$str .= '<tr>';  
			$str .= '<th>Kwota [zł]</th>'; 
			$str .= '<th>Data</th>'; 
			$str .= '<th>Sposób płatności</th>'; 
			$str .= '<th>Kategoria</th>';
			$str .= '<th>Komentarz</th>';
			$str .= '</tr>'; 
			$str .= '</thead>'; 
			$str .= '<tbody>';	
		
				$row = $resultOfQuery->fetch_assoc();
				$str .= '<tr>'; 
				$str .= '<td>'.$row['amount'].'</td>';
				$str .= '<td>'.$row['date_of_expense'].'</td>';
				$str .= '<td>'.$row['payment'].'</td>';
				$str .= '<td>'.$row['category'].'</td>';
				$str .= '<td>'.$row['expense_comment'].'</td>';
				$str .= '</tr>'; 

			$resultOfQuery->free_result();
			$str .= '</tbody>'; 
			$str .= '</table>'; 
			$str .= '</div>'; 
		    $str .= '</div>'; 							
			$str .= '</article>'; 	
		} 
        return $str;
	}
	
	function showTableOneEnteryIncome($id, $userId)
	{
		
		$sql ="SELECT i.amount, i.date_of_income, c.name AS category, i.income_comment FROM users u 
		INNER JOIN incomes i ON u.id = i.user_id 
		INNER JOIN incomes_category_assigned_to_users c ON i.income_category_assigned_to_user_id = c.id
		WHERE u.id = $userId AND i.id = $id";	
		
		$resultOfQuery=$this->connection->query($sql);
			
		if(!$resultOfQuery) return SERVER_ERROR;
				
		$how=$resultOfQuery->num_rows;
		$str = '';	
		if($how>0)
		{
			$str .= '<article>';
			$str .= '<div class="table-responsive text-left">';          
			$str .= '<div class="table-responsive">';         
			$str .= '<table class="table table-striped table-bordered table-condensed">'; 
			$str .= '<thead>'; 
			$str .= '<tr>';  
			$str .= '<th>Kwota [zł]</th>'; 
			$str .= '<th>Data</th>';  
			$str .= '<th>Kategoria</th>';
			$str .= '<th>Komentarz</th>';
			$str .= '</tr>'; 
			$str .= '</thead>'; 
			$str .= '<tbody>';	
		
				$row = $resultOfQuery->fetch_assoc(); 
				$str .= '<tr>'; 
				$str .= '<td>'.$row['amount'].'</td>';
				$str .= '<td>'.$row['date_of_income'].'</td>';
				$str .= '<td>'.$row['category'].'</td>';
				$str .= '<td>'.$row['income_comment'].'</td>';
				$str .= '</tr>'; 

			$resultOfQuery->free_result();
			$str .= '</tbody>'; 
			$str .= '</table>'; 
			$str .= '</div>'; 
		    $str .= '</div>'; 							
			$str .= '</article>'; 	
		} 
        return $str;
	}
	
	
}