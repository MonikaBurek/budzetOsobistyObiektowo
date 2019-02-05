<?php if (!isset($application)) die();?> 
<div class="container"> 
	<div class="row text-justify">			
		<div class="col-md-5 col-md-offset-2 bg3">
			<form action='index.php?action=saveDate' method = "POST" >
				<div class="row">
					<h3 class="articleHeader">Wybierz okres czasu dla bilansu.</h3>
				</div>
				<div class="row rowExpense">
					<div class="form-group">
						<label class="control-label col-sm-4 text-right" for="startDate">Początek okresu:</label>
						<div class="col-sm-6">
							<input type="date" name="startDate" value="<?php
											if (isset($_SESSION['formStartDate'])) {
												echo $_SESSION['formStartDate'];
												unset($_SESSION['formStartDate']);
											}
											?>" class="form-control" placeholder="dd-mm-rrrr">
						</div>
						<div class="col-sm-2"></div>
					</div>
				</div>
							
				<div class="row">
					<div class="form-group">
						<label class="control-label col-sm-4 text-right" for="endDate">Koniec okresu:</label>
						<div class="col-sm-6">
							<input type="date" name="endDate" value="<?php
											if (isset($_SESSION['formEndDate'])) {
												echo $_SESSION['formEndDate'];
												unset($_SESSION['formEndDate']);
											}
											?>" class="form-control" placeholder="dd-mm-rrrr">
										
						</div>
						<div class="col-sm-2"></div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-7 col-sm-offset-3">
						<button type="submit" class="btnSetting">Wyświetl bilans</button>
					</div>
					<div class="col-sm-2"></div>
				</div>
						
			</form>
		</div>
	</div>
	<div class="row text-center ">
		<div class="col-md-5 col-md-offset-2 bg1">
	        <div class="statement">
            <?php
                if($statement):
                    echo $statement;
			     endif ?>
            </div>  
	    </div>
	</div>
								
</div>