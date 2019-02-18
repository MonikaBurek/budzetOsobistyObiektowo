<?php if(!isset($application)) die(); ?>
<div id="changePasswordFormDiv">

    <div class="row text-center ">
	
		<div class="col-md-4 col-md-offset-4 bg3">
			
			<form class="form-horizontal" action = "index.php?action=saveNewPassword" method="post">
				<div class="row">
					<h3 class="articleHeader">Zmiana hasła</h3>
				</div>
				<div class="row rowExpense">
					<div class="form-group">
						<label class="control-label col-sm-3" for="password1">Hasło:</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password1" placeholder="Podaj nowe hasło">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<label class="control-label col-sm-3" for="password2">Hasło:</label>
						<div class="col-sm-9"> 
								<input type="password" class="form-control" name="password2" placeholder="Powtórz hasło">
						</div>
					</div>
				</div>
			
				<div class="form-group"> 
					<div class="col-sm-offset-1col-sm-11">
					    <button type="submit" class="btnSetting">Zapisz</button>
					</div>
				</div>
			</form>	
		</div>
		<div class="col-md-4"></div>
	</div>
	
	<div class="row text-center ">
		<div class="col-md-4 col-md-offset-4 bg1">
	        <div class="statement">
            <?php
                if($statement):
                    echo $statement;
			     endif ?>
            </div>  
	    </div>
	</div>
</div>