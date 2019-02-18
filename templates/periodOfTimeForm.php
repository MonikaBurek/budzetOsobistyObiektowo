<?php if(!isset($application)) die();?> 
<?php 

if(isset($_SESSION['formPeriodOfTime']))
	unset($_SESSION['formPeriodOfTime']);

if(isset($_SESSION['periodStartDate']))
	unset($_SESSION['periodStartDate']);
    
if(isset($_SESSION['periodEndDate']))
	unset($_SESSION['periodEndDate']);
?>
<div class="row text-justify">
	<div class="row rowWithMarginBottom">
		<div class="col-md-5 col-md-offset-2 bg1">
			<form class="form-inline bg3" action="index.php?action=savePeriod" method="post">
				<div class="form-group" >
					<label for="periodOfTime">Wybierz okres czasu:</label>
					<select class="form-control" id="periodOfTime" name="periodOfTime">
						<option  value="currentMonth">Bieżący miesiąc</option>
						<option  value="previousMonth">Poprzedni miesiąc</option>
						<option  value="currentYear">Bieżący rok</option>
						<option  value="selectedPeriod">Wybrany okres</option>
					</select>
				</div>
					<button type="submit" class="btn btnSave">Zapisz</button>
			</form>
		</div>
	</div>			
</div>			