<?php
class Registration
{
	private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
    function checkIfUserExists($name)
	{
		$resultOfQuery = $this->connection->query("SELECT id FROM users WHERE username='$name'");
				
		if (!$resultOfQuery) return SERVER_ERROR;
				
		$howLogins = $resultOfQuery->num_rows;
		if ($howLogins > 0) {
			return USER_NAME_ALREADY_EXISTS;
		}
		return ACTION_OK;
	}

	
	function addUserToDatabase($name,$passwordHash)
	{
        //disabling automatic transaction approval
		$this->connection->autocommit(false);
		
		//Adding a user to the database
		$query1 = "INSERT INTO users VALUES (NULL, '$name','$passwordHash')";
		$query2 = "INSERT INTO expenses_category_assigned_to_users(user_id, name) 
		SELECT u.id AS user_id, d.name FROM users AS u CROSS JOIN expenses_category_default AS d WHERE u.username='$name'";
		$query3 = "INSERT INTO incomes_category_assigned_to_users(user_id, name) 
		SELECT u.id AS user_id, d.name FROM users AS u CROSS JOIN incomes_category_default AS d WHERE u.username='$name'";
		$query4 = "INSERT INTO payment_methods_assigned_to_users(user_id, name) 
		SELECT u.id AS user_id, d.name FROM users AS u CROSS JOIN payment_methods_default AS d WHERE u.username='$name'";
		if ($this->connection->query($query1) && 
			$this->connection->query($query2) &&
			$this->connection->query($query3) && 
			$this->connection->query($query4)) {
				$this->connection->commit();
				return ACTION_OK;
		}
		return SERVER_ERROR;
	}	
		
		
	function register()
	{
		if (!$this->connection) return SERVER_ERROR;
	
	    if(!isset($_POST['name'])) return FORM_DATA_MISSING;
			
		$name = $_POST['name'];
		$password = $_POST['password'];
		
		$va = new Validation();
		switch ($va->validationLogin($name)) {
		    case BAD_LOGIN_LENGTH:
		        return BAD_LOGIN_LENGTH;
			case NON_ALPHANUMERIC_LOGIN:
			    return NON_ALPHANUMERIC_LOGIN;
	    }
		
		$name = strtolower($name);  // Format: name
		$_SESSION['formName'] = $name;
		
		if ($va->validationPassword($password) == BAD_PASSWORD_LENGTH) {
			return BAD_PASSWORD_LENGTH;
		}
		
		$passwordHash = password_hash($password, PASSWORD_DEFAULT);
		
		if ($va->validationRecatcha() == false) {
			return RECATCHA_FALIED;
		}
		
		if ($this->checkIfUserExists($name) == USER_NAME_ALREADY_EXISTS) {
			return USER_NAME_ALREADY_EXISTS;
		} 
		
		if ($this->addUserToDatabase($name,$passwordHash) == ACTION_OK) {
			return ACTION_OK;
		} else {
			return SERVER_ERROR;
		}
	}
}
