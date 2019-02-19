<?php
class Settings
{
	private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
	function saveNewPassword($userId)
	{
		if (!$this->connection) return SERVER_ERROR;
	
	    if(!isset($_POST['password1'])) return FORM_DATA_MISSING;
			
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		$va = new Validation();
		
		if ($va->validationPassword($password1) == BAD_PASSWORD_LENGTH) {
			return BAD_PASSWORD_LENGTH;
		}
		
		if ($va->validationPassword($password2) == BAD_PASSWORD_LENGTH) {
			return BAD_PASSWORD_LENGTH;
		}
		
		if ($password1 != $password2) {
			return DIFFERENT_PASSWORDS;
		}
		
		$newPasswordHash = password_hash($password1, PASSWORD_DEFAULT);
		
		$query = "UPDATE users SET password ='$newPasswordHash' WHERE id ='$userId'" ;
		if ($this->connection->query($query)) {
			return ACTION_OK;
		}
		
		return SERVER_ERROR;
	}
	
	function showTableCategory($userId)
	{
		$sql = "SELECT name FROM expenses_category_assigned_to_users WHERE user_id ='$userId'";
		
		$resultOfQuery=$this->connection->query($sql);
		
		if (!$resultOfQuery) return SERVER_ERROR;
		
		$howCategory=$resultOfQuery->num_rows;
		$str = '';	
		if($howCategory>0) {
			$str .= '<article>';							
			$str .= '<div class="table-responsive text-left">';          
			$str .= '<div class="table-responsive">';         
			$str .= '<table class="table table-striped table-bordered table-condensed">'; 
			$str .= '<thead>'; 
			$str .= '<tr>'; 
			$str .= '<th>Lp.</th>'; 
			$str .= '<th>Nazwa kategorii</th>'; 
			$str .= '</tr>'; 
			$str .= '</thead>'; 
			$str .= '<tbody>'; 
			$counter = 1;
			while ($row = $resultOfQuery->fetch_assoc())
				{
					
					$str .= '<tr>'; 
					$str .= '<td>'.$counter.'</td>'; 
					$str .= '<td>'.$row['name'].'</td>'; 
					$str .= '</tr>'; 
					$counter++;
				} 
			
			$resultOfQuery->free_result();
			$str .= '</tbody>'; 
			$str .= '</table>'; 
			$str .= '</div>'; 
			$str .= '</div>'; 							
			$str .= '</article>'; 	
		} else {
		    $str .= '<h4 class="bilansHeader">Brak kategorii wydatków.</h4>';
		}
        return $str;		
	}
	
}