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
        if ($connection->connect_errno) {
            $msg = "Brak po³¹czenia z baz¹ danych: ";
            $msg .= $connection->connect_error;
            throw new Exception($msg);
        }
        return $connection;
    }
}