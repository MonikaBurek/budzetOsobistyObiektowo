<?php if(!isset($this)) die(); ?>
<div id="expenseDiv">
   <div class="row text-justify ">
	    <div class="col-md-8 col-md-offset-2 bg3">

		    <div class="row text-center ">
		             <div class="col-md-10 col-md-offset-1 bg1">
	                     <div class="statement">
                         <?php
                            if($statement):
                               echo $statement;
					        endif ?>
                        </div>  
	                </div>
	        </div>
			
			
		    <form action ="index.php?action=<?= $parametr?>&id=<?=$id?>" method = "post">
				<div class="row">
					<div class="form-group">
						<label class="control-label col-sm-1"  for="amount">Kwota:</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" value="<?php 
											if (isset($_SESSION['formAmountExpense']))
											{
												echo $_SESSION['formAmountExpense'];
												unset($_SESSION['formAmountExpense']);
											}
										?>" name="amount">	
						</div>
						<div class="col-sm-5"></div>
					</div>
				</div>
	  
				<div class="row">
					<div class="form-group">
						<label class="control-label col-sm-1" for="dateExpense">Data:</label>
						<div class="col-sm-6">
							<input type="date" name="date" value="<?php 
											if (isset($_SESSION['formDateExpense']))
											{
												echo $_SESSION['formDateExpense'];
												unset($_SESSION['formDateExpense']);
											}
											else
											{
												echo date('Y-m-d'); 
											}
										?>" class="form-control">
						</div>
						<div class="col-sm-5"></div>	  
					</div>
				</div>
	 
				<div class="row ">
					<span class="titleForm">Sposób płatności:</span>
				</div>
				
				<?php echo $strPayment?>
				<div class="row rowExpense">
					<span class="titleForm">Kategoria płatności:</span>
				</div>
				<?php echo $strCategoryExpense ?>
                
				<div class="form-group rowExpense">
					<label for="comment">Komentarz (opcjonalnie):</label>
					<textarea class="form-control" rows="1" name = "comment" ><?php 
											if (isset($_SESSION['formCommentExpense']))
											{
												echo $_SESSION['formCommentExpense'];
												unset($_SESSION['formCommentExpense']);
											}
										?></textarea>
				</div>
				
				<div class="row ">
					<div class="col-sm-5 col-sm-offset-4">
						<button type="submit" class="btnSetting" >Zapisz</button>
					</div>
				</div>	
			</form>	
				<div class="row ">	
					<div class="col-sm-5 col-sm-offset-8">
						<a href="index.php?action=showMain" class="btnSetting" role="button"> Anuluj </a>
					</div>
				</div>	
			
			
		</div>
		<div class="col-md-2"></div>
	</div>
</div>