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
	
	function showTableCategoryExpenses($userId)
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
	
	function showTableCategoryIncomes($userId)
	{
		$sql = "SELECT name FROM incomes_category_assigned_to_users WHERE user_id ='$userId'";
		
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
		    $str .= '<h4 class="bilansHeader">Brak kategorii przychodów.</h4>';
		}
        return $str;		
	}
	
	function checkIfCategoryExists($nameCategory,$userId, $wtd)
	{
		if ($wtd == 'expenseCategory') {
		    $sql = "SELECT e.id FROM `expenses_category_assigned_to_users` e INNER JOIN users u ON e.user_id = u.id WHERE u.id='$userId' AND e.name='$nameCategory'";
		} elseif ($wtd == 'incomeCategory') {
		    $sql = "SELECT i.id FROM `incomes_category_assigned_to_users` i INNER JOIN users u ON i.user_id = u.id WHERE u.id='$userId' AND i.name='$nameCategory'";		
		}
		
		$resultOfQuery = $this->connection->query($sql);
				
		if (!$resultOfQuery) return SERVER_ERROR;
				
		$howCategory=$resultOfQuery->num_rows;
		if ($howCategory > 0) {
			return CATEGORY_NAME_ALREADY_EXISTS;
		}
		return ACTION_OK;
	}
	
	function addCategoryToDatabase($nameCategory,$userId, $wtd)
	{
       
	   if ($wtd == 'expenseCategory') {
		    $sql = "INSERT INTO `expenses_category_assigned_to_users` VALUES (NULL, '$userId','$nameCategory')";	
		} elseif ($wtd == 'incomeCategory') {
		    $sql = "INSERT INTO `incomes_category_assigned_to_users` VALUES (NULL, '$userId','$nameCategory')";	
		}
		
		if ($this->connection->query($sql)) {
			return ACTION_OK;
		}
		
		return SERVER_ERROR;
	}	
	
	function addNewCategory($userId, $wtd)
	{
		if (!$this->connection) return SERVER_ERROR;
	
	    if(!isset($_POST['nameCategory']) || $_POST['nameCategory'] =='' ) return FORM_DATA_MISSING;
			
		$nameCategory = $_POST['nameCategory'];
		
		$nameCategory = htmlentities($nameCategory,ENT_QUOTES, "UTF-8");
		
		$nameCategory = ucfirst(mb_strtolower($nameCategory,"UTF-8"));  // Format: Name
		$va = new Validation();
		if ($va->validationCategory($nameCategory) == CATEGORY_TOO_LONG) {
				return CATEGORY_TOO_LONG;
		}
		
		if($this->checkIfCategoryExists($nameCategory, $userId, $wtd) == CATEGORY_NAME_ALREADY_EXISTS) {
			return CATEGORY_NAME_ALREADY_EXISTS;
		}
		
		if ($this->addCategoryToDatabase($nameCategory, $userId, $wtd) == ACTION_OK) {
			return ACTION_OK;
		} else {
			return SERVER_ERROR;
		}
	} 
	 
	function editCategoryToDatabase($newCategory,$wtd, $userId, $nameCategoryForm)
	{
		if ($wtd == 'expenseCategory') {
		    $sql = "UPDATE `expenses_category_assigned_to_users` SET name ='$newCategory' WHERE user_id = $userId AND name = '$nameCategoryForm'";
		} elseif ($wtd == 'incomeCategory') {
		    $sql = "UPDATE `incomes_category_assigned_to_users` SET name ='$newCategory' WHERE user_id = $userId AND name = '$nameCategoryForm'";	
		} 
		
		if ($this->connection->query($sql)) {
			return ACTION_OK;
		}
		
		return SERVER_ERROR;
	}	
	 
	 
	function editCategory($userId,$wtd)
	{
		if (!$this->connection) return SERVER_ERROR;
	
	    if(!isset($_POST['nameCategory']) || $_POST['nameCategory'] =='') return FORM_DATA_MISSING;
			
		$newCategory = $_POST['nameCategory'];
		if ($wtd == 'expenseCategory') {
			if(!isset($_POST['categoryOfExpense'])) {
				return NO_CATEGORY;
			} else {
		    $nameCategoryForm =	$_POST['categoryOfExpense'];
			}
		} elseif ($wtd == 'incomeCategory') {
			if(!isset($_POST['categoryOfIncome'])){
				return NO_CATEGORY;
			} else {
		    $nameCategoryForm =	$_POST['categoryOfIncome'];	
			}
		} 
		
		$newCategory = htmlentities($newCategory, ENT_QUOTES, "UTF-8");
		
		$newCategory = ucfirst(mb_strtolower($newCategory,"UTF-8"));  // Format: Name
		$va = new Validation();
		if ($va->validationCategory($newCategory) == CATEGORY_TOO_LONG) {
			return CATEGORY_TOO_LONG;
		}
		
		if($this->checkIfCategoryExists($newCategory,$userId,$wtd) == CATEGORY_NAME_ALREADY_EXISTS) {
			return CATEGORY_NAME_ALREADY_EXISTS;
		}
		
		if ($this->editCategoryToDatabase($newCategory,$wtd, $userId, $nameCategoryForm) == ACTION_OK) {
			return ACTION_OK;
		} else {
			return SERVER_ERROR;
		} 
	}
	
	function deleteEntriesWithDatabase($nameCategory, $userId, $wtd)
	{
		if ($wtd == 'expenseCategory') {
		    $sql = "DELETE FROM `expenses` WHERE `user_id`=$userId AND `expense_category_assigned_to_user_id`= (SELECT id FROM `expenses_category_assigned_to_users` WHERE `user_id`=$userId And `name`='$nameCategory')";	
		} elseif ($wtd == 'incomeCategory') {
		    $sql = "DELETE FROM `incomes` WHERE `user_id`=$userId AND `income_category_assigned_to_user_id`= (SELECT id FROM `expenses_category_assigned_to_users` WHERE `user_id`=$userId And `name`='$nameCategory')";	
		} 
		
		if ($this->connection->query($sql)) {
			return ACTION_OK;
		}
		
		return SERVER_ERROR;
	}
	
	function deleteCategoryWithDatabase($nameCategory, $userId, $wtd)
	{
		if ($wtd == 'expenseCategory') {
		    $sql = "DELETE FROM `expenses_category_assigned_to_users` WHERE `user_id`= $userId AND `name`='$nameCategory'";	
		} elseif ($wtd == 'incomeCategory') {
		    $sql = "DELETE FROM `incomes_category_assigned_to_users` WHERE `user_id`= $userId AND `name`='$nameCategory'";	
		} 
		
		if ($this->connection->query($sql)) {
			return ACTION_OK;
		}
		
		return SERVER_ERROR;
	}
	
	function prepareNameOfCategory($userId, $wtd)
	{
		if(!isset($_POST['nameCategory']) || $_POST['nameCategory'] =='' ) return FORM_DATA_MISSING;
		$newCategory = $_POST['nameCategory'];
		$newCategory = htmlentities($newCategory,ENT_QUOTES, "UTF-8");
		
		$newCategory = ucfirst(mb_strtolower($newCategory,"UTF-8"));  // Format: Name
		$va = new Validation();
		if ($va->validationCategory($newCategory) == CATEGORY_TOO_LONG) {
				return CATEGORY_TOO_LONG;
		}
		
		if ($this->checkIfCategoryExists($newCategory,$userId,$wtd) == CATEGORY_NAME_ALREADY_EXISTS) {
			$_SESSION['formNewCategory'] = $newCategory;
			return ACTION_OK;
		} elseif ($this->checkIfCategoryExists($newCategory,$userId,$wtd) == ACTION_OK) {
			if ($this->addCategoryToDatabase($newCategory, $userId, $wtd) == ACTION_OK) {
				$_SESSION['formNewCategory'] = $newCategory;
				return ACTION_OK;
			} else {
				return SERVER_ERROR;
			}
		}
		
	}
	
	function editEntriesWithDatabase($newCategory,$nameCategoryForm, $userId, $wtd)
	{
		if ($wtd == 'expenseCategory') {
		    $sql = "UPDATE `expenses` SET `expense_category_assigned_to_user_id`= (SELECT id FROM `expenses_category_assigned_to_users` WHERE `user_id`=$userId And `name`='$newCategory') WHERE `user_id`= $userId AND `expense_category_assigned_to_user_id`= (SELECT id FROM `expenses_category_assigned_to_users` WHERE `user_id`=$userId AND `name`='$nameCategoryForm')";
		} elseif ($wtd == 'incomeCategory') {
		      $sql = "UPDATE `incomes` SET `income_category_assigned_to_user_id`= (SELECT id FROM `incomes_category_assigned_to_users` WHERE `user_id`=$userId And `name`='$newCategory') WHERE `user_id`= $userId AND `income_category_assigned_to_user_id`= (SELECT id FROM `incomes_category_assigned_to_users` WHERE `user_id`=$userId AND `name`='$nameCategoryForm')";
		} 
		
		if ($this->connection->query($sql)) {
			return ACTION_OK;
		}
		
		return SERVER_ERROR;
	}
	
	function deleteCategory($userId,$wtd)
	{
        if (!$this->connection) return SERVER_ERROR;
	
		if ($wtd == 'expenseCategory') {
			if (!isset($_POST['categoryOfExpense'])) {
				return NO_CATEGORY;
			} 
			$nameCategoryForm =	$_POST['categoryOfExpense'];
		} elseif ($wtd == 'incomeCategory') {
		    if (!isset ($_POST['categoryOfIncome'])) {
		        return NO_CATEGORY;
			}
			$nameCategoryForm =	$_POST['categoryOfIncome'];
		} 
		
		if (!isset ($_POST['deleteMethod'])) {
			return NO_DELETE_METHOD;
		}
		
		$deleteMethod = $_POST['deleteMethod'];
		
		if ($deleteMethod == 'deleteEntries') {
			if ($this->deleteEntriesWithDatabase($nameCategoryForm, $userId, $wtd) == ACTION_OK) {
				if ($this->deleteCategoryWithDatabase($nameCategoryForm, $userId, $wtd) == ACTION_OK) {
			       return ACTION_OK;
		        } else {
			       return SERVER_ERROR;
		        } 
		    } else {
			    return SERVER_ERROR;
		    }
		} elseif ($deleteMethod == 'newCategory') {
			if ($this->prepareNameOfCategory($userId, $wtd) == ACTION_OK) {
				$newCategory = $_SESSION['formNewCategory'];
			    if ($this->editEntriesWithDatabase($newCategory,$nameCategoryForm, $userId, $wtd) == ACTION_OK) {
				    if ($this->deleteCategoryWithDatabase($nameCategoryForm, $userId, $wtd) == ACTION_OK) {
			            return ACTION_OK;
		            } else {
			            return SERVER_ERROR;
		            } 
			    } else {
				    return SERVER_ERROR;
			    }
			} elseif ($this->prepareNameOfCategory($userId, $wtd) == FORM_DATA_MISSING){
				return FORM_DATA_MISSING;
			} else {
				return SERVER_ERROR;
			} 
			
		}  	
	}
}