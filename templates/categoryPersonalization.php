<?php if(!isset($this)) die(); ?>

<div id="categoryPersonalizationDiv">
   <div class="row text-center">
	    <div class="col-md-11 col-md-offset-1   bg3">
			<h3 class="articleHeader">Personalizacja kategorii wydatków i przychodów</h3>
		</div>
	</div>
	
    <div class="row">	
		<div class="col-md-5 col-md-offset-1  bg3 text-center">
		    <h4 class="title">Twoje kategorie wydatków</h4>
			</br>
		    <ul class="nav nav-pills nav-stacked">
				<li><a class="navPillsProperties" href="index.php?action=addCategoryForm&amp;wtd=expenseCategory">Dodaj</a></li>
				<li><a class="navPillsProperties" href="index.php?action=editCategoryForm&amp;wtd=expenseCategory">Edytuj nazwę</a></li>
				<li><a class="navPillsProperties" data-toggle="modal" data-target="#limitModal">Edytuj limit</a></li>
				<li><a class="navPillsProperties" href="index.php?action=deleteCategoryForm&amp;wtd=expenseCategory">Usuń</a></li>
			</ul>
			<br/><br/>
			<?php echo $strCategoryExpenses ?>	
		</div>
		
		<div class="modal fade" id="limitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				    <div class="modal-header" id="limitModalHeader">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
						<h5 class="modal-title" id="modalLabel">Edytuj limit dla kategorii wydatku</h5> 
					</div>
					<div class="modal-body" id="limitBodyModal">
						
						Wybierz kategorię:
						<?php echo $strCategoryExpenseForm?>
						<br/>
						<div id="feedback"></div>
						<label class="control-label" for="limitInput">Ustaw miesięczny limit wydatków dla kategorii</label>
						<input type="text" class="form-control" id="limitInput" placeholder="Podaj limit dla wydatków">
						
							
					</div>
					<div class="modal-footer" id="limitModalFooter">
						<button type="button" class="btn btnClose" data-dismiss="modal">Anuluj</button>
						<button type="button" class="btn btnSetting" id="limitSaveButton">Zapisz</button>
					</div>
			    </div>
		    </div>
	    </div>
					
		<div class="col-md-5 col-md-offset-1  bg3 text-center">
		    <h4 class="title">Twoje kategorie przychodów</h4>
			</br>
		    <ul class="nav nav-pills nav-stacked">
				<li><a class="navPillsProperties" href="index.php?action=addCategoryForm&amp;wtd=incomeCategory">Dodaj</a></li>
				<li><a class="navPillsProperties" href="index.php?action=editCategoryForm&amp;wtd=incomeCategory">Edytuj</a></li>
				<li><a class="navPillsProperties" href="index.php?action=deleteCategoryForm&amp;wtd=incomeCategory">Usuń</a></li>
			</ul>
			<br/></br>
			<?php echo $strCategoryIncomes ?>		
		</div>
	</div>
</div>

