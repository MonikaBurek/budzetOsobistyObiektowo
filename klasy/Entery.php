<?php
class Entery
{
    private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
    function deleteEntery($wtd,$id)
	{
		if ($id < 1 ) { 
		return INCORRECT_ID;
		}
		
		if ($wtd == 'expense') {
		    $sql = "DELETE FROM `expenses` WHERE `id`=$id";
		} elseif ($wtd == 'income') {
		    $sql = "DELETE FROM `incomes` WHERE `id`=$id";	
		} 
		
		if ($this->connection->query($sql)) {
			return ACTION_OK;
		}
		
		return SERVER_ERROR;
		
	}
}