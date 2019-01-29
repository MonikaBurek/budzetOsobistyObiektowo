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
	    return LOGIN_OK;	
	}
}