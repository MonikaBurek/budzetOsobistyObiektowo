<?php if (!isset($application)) die();?> 
<?php
if (isset($_SESSION['formAmountExpense'])) unset($_SESSION['formAmountExpense']);
if (isset($_SESSION['formDateExpense'])) unset($_SESSION['formDateExpense']);
if (isset($_SESSION['formPaymentMethod'])) unset($_SESSION['formPaymentMethod']);
if (isset($_SESSION['formCategoryExpense'])) unset($_SESSION['formCategoryExpense']);
if (isset($_SESSION['formCommentExpense'])) unset($_SESSION['formCommentExpense']);
?>
<div class="container"> 
	<div class="row text-center ">
		<div class="col-md-4 col-md-offset-4 bg6">
			Wydatek został zapisany!
			<br /><br />	
			<a href="index.php?action=showExpenseForm" class="btnSetting" role="button"> Dodaj kolejny wydatek!</a>
			<br />								
		</div>
		<div class="col-md-4"></div>
	</div>
</div>