<?php if(!isset($application)) die();?> 
<?php
if (isset($_SESSION['formAmountIncome'])) unset($_SESSION['formAmountIncome']);
if (isset($_SESSION['formDateIncome'])) unset($_SESSION['formDateIncome']);
if (isset($_SESSION['formCategoryIncome'])) unset($_SESSION['formCategoryIncome']);
if (isset($_SESSION['formCommentIncome'])) unset($_SESSION['formCommentIncome']);
?>
<div class="container"> 
	<div class="row text-center ">
		<div class="col-md-4 col-md-offset-4 bg6">
			Przychód został zapisany!
			<br /><br />	
			<a href="index.php?action=showAddIncomeForm" class="btnSetting" role="button"> Dodaj kolejny przychód!</a>
			<br />								
		</div>
		<div class="col-md-4"></div>
	</div>
</div>