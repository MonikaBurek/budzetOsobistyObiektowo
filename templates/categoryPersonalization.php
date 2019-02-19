<?php if(!isset($this)) die(); ?>
<div id="categoryPersonalizationDiv">
   <div class="row text-center ">
	    <div class="col-md-8 col-md-offset-2 bg1">
				<h3 class="articleHeader">Personalizacja kategorii wydatków</h3>
		</div>
		<div class="col-md-2"></div>
		
		<div class="col-md-3 col-md-offset-2 bg3 bg9">
		     <ul class="nav nav-pills nav-stacked">
				<li><a class="navPillsProperties" href="index.php?action=addCategoryForm">Dodaj nową kategorię</a></li>
				<li><a class="navPillsProperties" href="index.php?action=editCategoryForm">Edytuj kategorię</a></li>
				<li><a class="navPillsProperties" href="index.php?action=deleteCategoryForm">Usuń kategorię</a></li>
			</ul>
		</div>
		<div class="col-md-5 bg3">
			<h4>Twoje kategorie wydatków</h4>
			</br>
			<?php echo $strCategoryExpenses ?>	
		</div>
		<div class="col-md-2"></div>
		
	</div>
   
</div>