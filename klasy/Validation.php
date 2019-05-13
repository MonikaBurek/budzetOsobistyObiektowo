<?php
class Validation
{
	function validationLogin($name)
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

	function validationPassword($password)
	{
        //Check password length
		if ((strlen($password) < 8) || (strlen($password) > 20)) {
		    return BAD_PASSWORD_LENGTH;
        }
		
		return ACTION_OK;
	}
	
	function validationReCatcha()
	{
	    //validate re-catcha
		$secretKey = "6Lc8028UAAAAAHLJLMyx45qS2yCNvsWhHl3ens9f";
		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);
		$answer = json_decode($check);
		
		if ($answer->success == false) {
			return false;
		}
		
	    return ACTION_OK;
	}
	
	function validationAmount($amount)
	{
		if (is_numeric($amount)) {
			$amount = round($amount,2);
		} else {
			return AMOUNT_NOT_NUMBER;
		}
		
		if ($amount >= 1000000000) {
			return AMOUNT_TOO_HIGH;
		}
		
		return ACTION_OK;
	}
	
	function validationDate($date)
	{
		if ($date == NULL) {
			return NO_DATE;
		}
		
		$currentDate = date('Y-m-d');
		
		if ($date > $currentDate) {
			return WRONG_DATE;
		}
		return ACTION_OK;
	}
	
	
	function validationComment($comment)
	{
		if (strlen($comment) > 100) {
			return COMMENT_TOO_LONG;
		}
		return ACTION_OK;
	}
	
	function validationCategory($category)
	{
		if (strlen($category) > 50) {
			return CATEGORY_TOO_LONG;
		}
		return ACTION_OK;
	}
	
}
