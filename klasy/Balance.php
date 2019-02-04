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
		if (!isset($_POST['startDate'])) return ACTION_FAILED;
		
		
		if (isset($_POST['startDate'])) {
		    $startDate = $_POST['startDate'];
		    $endDate = $_POST['endDate'];
		    $startDate = htmlentities($startDate,ENT_QUOTES, "UTF-8");
		    $endDate = htmlentities($endDate,ENT_QUOTES, "UTF-8");
			
			$va = new Validation();
			switch ($va->validationDate($startDate)) {
		    case NO_DATE:
		        return NO_DATE;
			case WRONG_DATE:
			    return WRONG_DATE;
		    }
			$_SESSION['formStartDate'] = $startDate;
			
			switch ($va->validationDate($endDate)) {
		    case NO_DATE:
		        return NO_DATE;
			case WRONG_DATE:
			    return WRONG_DATE;
		    }
			$_SESSION['formEndDate'] = $endDate;
			
			if ($endDate < $startDate) {
				return END_DATE_TOO_SMALL;
			}
			
			$_SESSION['periodStartDate'] = $startDate  ;
		    $_SESSION['periodEndDate'] = $endDate;
			
			return ACTION_OK;
	    } else {
		return TEST;
		}
	}
	
	function getDatesOfPeriodOfTime() 
	{
		if (isset($_SESSION['formPeriodOfTime'])) {
		
		    $periodOfTime = $_SESSION['formPeriodOfTime'];
		    $now = date('Y-m-d');
			
		switch ($periodOfTime) {
			case "currentMonth":
				$datesPeriod[0] = date('Y-m-d',strtotime("first day of this month"));
			    $datesPeriod[1] = date('Y-m-d',strtotime("now"));
			    break;
			case "previousMonth":
				$datesPeriod[0] = date('Y-m-d',strtotime("first day of previous month"));
			    $datesPeriod[1] = date('Y-m-d',strtotime("last day of previous month")); 
			    break;
			case "currentYear":
				$datesPeriod[0] = date('Y-m-d',strtotime("1 January this year"));
			    $datesPeriod[1] = date('Y-m-d',strtotime("now")); 
				break;
			case "selectedPeriod":
				$datesPeriod[0] = $_SESSION['periodStartDate'];
			    $datesPeriod[1] = $_SESSION['periodEndDate'];
                break;
			}

		return $datesPeriod;
		}		
    }	
}