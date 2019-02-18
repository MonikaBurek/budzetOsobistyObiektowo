<?php if(!isset($this)) die(); ?>
<div id="categoryPersonalizationDiv">
   <div class="row text-justify ">
	     <div class="row">
				<h3 class="articleHeader">Personalizacja kategorii wydatków</h3>
			</div>
		<div class="col-md-5 col-md-offset-1 bg3">
		   
			<form action = "index.php?action=editDeleteCategory" method = "post">
				<div class="row rowExpense">
					<span class="titleForm">Twoje kategorie wydatków:</span>
				</div>
				
				<?php echo $strCategoryExpense ?>
		    
				<div class="row ">
					<div class="col-sm-4 col-sm-offset-2">
						<button type="submit" name="edit" class="btnSetting">Edytuj</button>
					</div>
					<div class="col-sm-6">
						<button type="submit" name="delete" class="btnSetting">Usuń</button>
					</div>
				</div>	
			</form>	
		</div>
		<div class="col-md-5 col-md-offset-1 bg3">
		    <form action = "index.php?action=addCategory" method = "post">
				<div class="row rowExpense">
					<span class="titleForm">Dodaj nową kategorię wydatku</span>
				</div>
				<div class="row rowExpense">
					<div class="form-group">
						<label class="control-label col-sm-4" for="category">Nazwa kategorii:</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="category" placeholder="Podaj nazwę kategorii">
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
   
</div>