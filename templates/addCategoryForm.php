<?php if(!isset($this)) die(); ?>
<div class="addCategoryForm">
    <div class="row text-center ">
		<div class="col-md-5 col-md-offset-4 bg1">
			<form action = "index.php?action=addNewCategory&amp;wtd=<?=$wtd?>" method = "post">
				<div class="row rowExpense">
				<?php if($wtd == 'expenseCategory'):?>
					<h3 class="articleHeader">Dodaj nową kategorię wydatku</h3>
				<?php endif;?>	
				<?php if($wtd == 'incomeCategory'):?>
					<h3 class="articleHeader">Dodaj nową kategorię przychodu</h3>
				<?php endif;?>
				</div>
				
				<div class="row rowExpense">
					<div class="form-group">
						<label class="control-label col-sm-4" for="category">Nazwa kategorii:</label>
						<div class="col-sm-7">
						    <input type="text" class="form-control" name="nameCategory" placeholder="Podaj nazwę kategorii">
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
		<div class="col-md-5 col-md-offset-4 bg1">
	        <div class="statement">
            <?php
                if($statement):
                    echo $statement;
			     endif ?>
            </div>  
	    </div>
	</div>
	
	<div class="row text-center ">
		<div class="col-md-5 col-md-offset-4 bg3">
		<?php if($wtd == 'expenseCategory'):?>
			<h4 class="title">Twoje kategorie wydatków</h4>
			<?php echo $strCategoryExpenses ?>
		<?php endif;?>	
		<?php if($wtd == 'incomeCategory'):?>
		    <h4 class="title">Twoje kategorie przychodów</h4>
			<?php echo $strCategoryIncomes ?>
        <?php endif;?>			
	    </div>
	</div>
	
</div>