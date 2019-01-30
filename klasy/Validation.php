<?php
class Validation
{
	function ValidationOfLogin($name)
	{
	   //Check length login
		if ((strlen($name) < 5) || (strlen($name)>20)) {
			return BAD_LOGIN_LENGTH;
		}
		
		if (ctype_alnum($name) == false) {
			return NON_ALPHANUMERIC_LOGIN;	
		}
		
		return ACTION_OK;
	}	

	function ValidationOfPassword($password)
	{
        //Check password length
		if ((strlen($password) < 8) || (strlen($password) > 20)) {
		    return BAD_PASSWORD_LENGTH;
        }
		
		return ACTION_OK;
	}
	
	function ValidationOfReCatcha()
	{
	    //validate re-catcha
		$secretKey = "6LfuoY0UAAAAAPGV0SeocHv151zy8erKGg6AEHFh";
		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);
		$answer = json_decode($check);
		
		if ($answer->success == false) {
			return false;
		}
		
	    return ACTION_OK;
	}
	
	
}
