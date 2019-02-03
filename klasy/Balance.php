<?php
class Balance
{
	private $connection = null;
	
	function __construct($connection)
	{
	    $this->connection = $connection;
	}
	
	function savePeriod()
	{
		if (!isset($_POST['periodOfTime'])) return ACTION_FAILED;
		
		if (isset($_POST['periodOfTime'])) {
			$periodOfTime = $_POST['periodOfTime'];
			$_SESSION['formPeriodOfTime'] = $periodOfTime;
			if ($_SESSION['formPeriodOfTime'] =="selectedPeriod") {
				return SELECTED_PERIOD;
			} else {
				return DEFINED_PERIOD;
			}
		}	
	}

	function saveDate()
	{
		

	}
	
}