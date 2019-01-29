<?php
class Login
{
    private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
	function login()
	{
		if (!$this->connection) return SERVER_ERROR;
		
		if ((!isset($_POST['name'])) || (!isset($_POST['password']))) {
			return FORM_DATA_MISSING;
		}
		
		$name = $_POST['name'];
	    $password = $_POST['password'];
        
		$name = htmlentities($name, ENT_QUOTES, "UTF-8");
		
		if ($resultOfQuery = $this->connection->query(
			sprintf("SELECT * FROM users WHERE username='%s'",
			mysqli_real_escape_string($this->connection, $name)))) {
				
				$howUsers = $resultOfQuery->num_rows;
				if ($howUsers <> 1) {
					return LOGIN_FAILED;
				} else {
					$row = $resultOfQuery->fetch_assoc();
					if (password_verify($password, $row['password'])) {
					   $_SESSION['userLoggedIn'] = new User($row['id'], $row['username']);
					   $resultOfQuery->free_result();
					    return LOGIN_OK;
					} else {
					    return LOGIN_FAILED;
					}
				}
		} else {
			return SERVER_ERROR;
		}	
	}
}