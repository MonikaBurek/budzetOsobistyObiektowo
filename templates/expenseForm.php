<?php if(!isset($this)) die(); ?>
<div id="expenseDiv">
   <div class="row text-justify ">
	    <div class="col-md-8 col-md-offset-2 bg3">
		    <form action = "index.php?action=addExpense" method = "post">
				<div class="row">
					<div class="form-group">
						<label class="control-label col-sm-1"  for="amount">Kwota:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="amount">	
						</div>
						<div class="col-sm-5"></div>
					</div>
				</div>
	  
				<div class="row">
					<div class="form-group">
						<label class="control-label col-sm-1" for="dateExpense">Data:</label>
						<div class="col-sm-6">
							<input type="date" name="date" value="<?php echo date('Y-m-d')?>" class="form-control">
						</div>
						<div class="col-sm-5"></div>	  
					</div>
				</div>
	 
				<div class="row ">
					<span class="titleForm">Sposób płatności:</span>
				</div>					
				<?php echo $strPayment ?>
				<div class="row rowExpense">
					<span class="titleForm">Kategoria płatności:</span>
				</div>
				<?php echo $strCategoryExpense ?>
                
				<div class="form-group rowExpense">
					<label for="comment">Komentarz (opcjonalnie):</label>
					<textarea class="form-control" rows="3" name = "comment" ></textarea>
				</div>
				
				<div class="row ">
					<div class="col-sm-5 col-sm-offset-2">
						<button type="submit" class="btnSetting">Dodaj</button>
					</div>
					<div class="col-sm-5">
						<button type="submit" class="btnSetting">Anuluj</button>
					</div>
				</div>
			</form>	
		</div>
		<div class="col-md-2"></div>
						
	</div>
</div>