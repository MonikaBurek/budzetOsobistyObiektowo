<?php if(!isset($application)) die();?> 
<div id="loginDiv">
	
	<div class="row text-center">
		<div class="col-md-8 col-md-offset-2 info">
		    
				<h3> Chcesz zapanować nad swoimi finasami? Maszysz o mieszkaniu, wakacjach na Wyspach Karaibskich, a może o nowym samochodzie?</h3>
				<h4> Jeśli tak, zacznij zarządzać swoimi wydatkami. Skorzystaj z aplikacji, która została stworzona specjalnie dla Ciebie. 
				Zaloguj się lub zarejestuj się, jeśli nie masz konta.
				</h4> 
			
		</div>
		<div class="col-md-2"></div>
	</div>
	
	<div class="row text-center ">
		<div class="col-md-4 col-md-offset-4 bg1">
			<ul class="nav nav-pills nav-justified">
				<li class="active"><a href="index.php?action=showRegistrationForm"><h3>Rejestracja</h3>(Nie mam konta)</a></li>	
				<li class="noactive"><a href="index.php?action=showLoginForm"><h3>Logowanie</h3>(Mam konto)</a></li>		
			</ul>
		</div>
		<div class="col-md-4"></div>
	</div>
	
	<div class="row text-center ">
		<div class="col-md-4 col-md-offset-4 bg2">
			<form class="form-horizontal" action = "index.php?action=registerUser" method="post">
				<div class="form-group">
					<label class="control-label col-sm-3" for="name">Login:</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" value="<?php 
							if (isset($_SESSION['formName'])){
								echo $_SESSION['formName'];
								unset($_SESSION['formName']);
							}?>" name="name" placeholder="Podaj login">
					</div>
				</div>
                <div class="form-group">
					<label class="control-label col-sm-3" for="password">Hasło:</label>
					<div class="col-sm-9"> 
						<input type="password" class="form-control" name="password" placeholder="Podaj hasło">
					</div>
				</div>
				<div class="col-sm-offset-1 col-sm-11">
					<div class="g-recaptcha" data-sitekey="6LfuoY0UAAAAAFxcJ0GLvNWq1lr1kvh9cQLwRpEK"></div>
				</div>
				
				<div class="form-group"> 
					<div class="col-sm-offset-1col-sm-11">
					   
					    <button type="submit" class="btnSetting">Zarejestruj się!</button>
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