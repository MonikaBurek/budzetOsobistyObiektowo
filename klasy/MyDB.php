<?php
class MyDB extends mysqli
{
  function getQuerySingleResult($query)
  {
    //Wykonanie zapytania.
    if (!$result = $this->query($query)) {
      echo 'Wystąpił błąd (getQuerySingleResult): nieprawidłowe zapytanie...';
      return false;
    }
    if ($row = $result->fetch_row()) {
      //Zwrócenie wyniku.
      return $row[0];
    } else {
      //Brak wyników zapytania.
      return false;
    }
  }
  
}
?>