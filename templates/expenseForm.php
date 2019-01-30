<?php if(!isset($application)) die(); ?>
<div id="expenseDiv">
   <div class="row text-justify ">
	    <div class="col-md-8 col-md-offset-2 bg3">
		    <form method = "post">
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
	
			</form>	
		</div>
	</div>
</div>