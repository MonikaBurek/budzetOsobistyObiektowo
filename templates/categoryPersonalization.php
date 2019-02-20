<?php if(!isset($this)) die(); ?>
<div id="categoryPersonalizationDiv">
   <div class="row text-center">
	    <div class="col-md-11 col-md-offset-1   bg1">
			<h3 class="articleHeader">Personalizacja kategorii wydatków i przychodów</h3>
		</div>
	</div>
	
    <div class="row text-center">	
		<div class="col-md-5 col-md-offset-1  bg3">
		    <h4 class="title">Twoje kategorie wydatków</h4>
			</br>
		    <ul class="nav nav-pills nav-stacked">
				<li><a class="navPillsProperties" href="index.php?action=addCategoryForm">Dodaj</a></li>
				<li><a class="navPillsProperties" href="index.php?action=editCategoryForm">Edytuj</a></li>
				<li><a class="navPillsProperties" href="index.php?action=deleteCategoryForm">Usuń</a></li>
			</ul>
		</div>
		
		<div class="col-md-5 col-md-offset-1  bg3">
		    <h4 class="title">Twoje kategorie przychodów</h4>
			</br>
		    <ul class="nav nav-pills nav-stacked">
				<li><a class="navPillsProperties" href="index.php?action=addCategoryForm">Dodaj</a></li>
				<li><a class="navPillsProperties" href="index.php?action=editCategoryForm">Edytuj</a></li>
				<li><a class="navPillsProperties" href="index.php?action=deleteCategoryForm">Usuń</a></li>
			</ul>
		</div>
	</div>
	
	<div class="row text-center">
		<div class="col-md-5 col-md-offset-1 bg3">
			<?php echo $strCategoryExpenses ?>	
		</div>
		
		<div class="col-md-5 col-md-offset-1 bg3">
			<?php echo $strCategoryIncomes ?>	
		</div>
	</div>	
		
		
		
	</div>
   
</div>