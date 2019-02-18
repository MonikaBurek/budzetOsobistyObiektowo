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
}