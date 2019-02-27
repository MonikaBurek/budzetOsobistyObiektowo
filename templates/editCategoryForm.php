<?php if(!isset($this)) die(); ?>
<div class="addCategoryForm">
    <div class="row">
		<div class="col-md-6 col-md-offset-4 bg1">
			<form action = "index.php?action=editCategory&amp;wtd=<?=$wtd?>" method = "post">
				<div class="row rowExpense">
				<?php if($wtd == 'expenseCategory'):?>
					<h3 class="articleHeader">Edytuj kategorię wydatku</h3>
				<?php endif;?>	
				<?php if($wtd == 'incomeCategory'):?>
					<h3 class="articleHeader">Edytuj kategorię przychodu</h3>
				<?php endif;?>
				</div>
				
				<div class="row rowExpense">
		            <?php if($wtd == 'expenseCategory'):?>
			            <?php echo $strCategoryExpense ?>
		            <?php endif;?>	
		            <?php if($wtd == 'incomeCategory'):?>
			        <?php echo $strCategoryIncome ?>
                    <?php endif;?>			
	            </div>
				
				<div class="row rowExpense">
				<div class="col-md-10 col-md-offset-1 bg1">
					<div class="form-group">
						<label class="control-label col-sm-5" for="category">Nowa nazwa kategorii:</label>
						<div class="col-sm-7">
						    <input type="text" class="form-control" name="nameCategory" placeholder="Podaj nazwę kategorii">
						</div>
					</div>
					</div>
				</div>
						
				<div class="form-group"> 
					<div class="col-sm-offset-4 col-sm-4">
						<button type="submit" class="btnSetting">Zapisz</button>
					</div>
				</div>	
			</form>	
		</div> 
    </div>
	<div class="row text-center ">
		<div class="col-md-6 col-md-offset-4 bg1">
	        <div class="statement">
            <?php
                if($statement):
                    echo $statement;
			     endif ?>
            </div>  
	    </div>
	</div>	
</div>