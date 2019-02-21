<?php
class Application
{
    private $connection = null;
  
    function __construct($host, $user, $pass, $db)
    {
        $this->connection = $this->initDB($host, $user, $pass, $db);
    }
  
    function initDB($host, $user, $pass, $db)
    {
        $connection = new MyDB($host, $user, $pass, $db);
		$connection->set_charset('utf8');
		$connection->query("SET NAMES 'utf8'");
        $connection->query("SET CHARACTER_SET_CLIENT=utf8");
        $connection->query("SET CHARACTER_SET_RESULTS=utf8"); 
		
		if ($connection->connect_errno) {
            $msg = "Brak polączenia z baza danych: ";
            $msg .= $connection->connect_error;
            throw new Exception($msg);
        }
        return $connection;
    }
}