<?php
class MyDB extends mysqli
{
  function getQuerySingleResult($query)
  {
    //Wykonanie zapytania.
    if (!$result = $this->query($query)) {
      return false;
    }
    if ($row = $result->fetch_row()) {
      return $row[0];
    } else {
      return false;
    }
  }
  
}
?>