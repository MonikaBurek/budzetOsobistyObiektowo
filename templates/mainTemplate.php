<?php if(!isset($application)) die();?>
<!DOCTYPE HTML>
<html lang="pl">
    <head>
		<title>Aplikacja</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="budżet, osobisty, domowy" />
		<meta name="author" content="Monika Burek">
			
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">	
		<link rel="stylesheet" href="style.css" type="text/css"/>
		<link rel="stylesheet" href="css/fontello.css" type="text/css"/>
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet">
		<script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body <?php if($action =='viewBalance') echo 'onload="createPieChart()"'?>>
		<?php if($application->userLoggedIn): ?>
        <article class="articleFourElements">
		<?php else: ?>
		<article class="articleThreeElements">
		<?php endif ?>
		
			<header>
				<div class="jumbotron">
					<div class="container text-center">
						<h2><span class="colorIcon"><i class="icon-money"></i></span>
						Aplikacja do prowadzenia budżetu domowego!</h2>   				
					</div>
				</div>
			</header>
			
			<?php if($application->userLoggedIn): ?>
			<nav class="navbar navbar-default navbarProperties">
				<div class="container text-center">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>                        
						</button>
					</div>
					
					<div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav">
							<li <?php if ($action == "showMain") {echo 'class="active"';} ?>>
							<a href="index.php?action=showMain">Strona główna</a></li>
							<li <?php if ($action == "showIncomeForm") {echo 'class="active"';}?>>
							<a href="index.php?action=showIncomeForm">Dodaj przychód</a></li>
							<li <?php if ($action == "showExpenseForm") {echo 'class="active"';} ?>>
							<a href="index.php?action=showExpenseForm">Dodaj wydatek</a></li>
							<li <?php if ($action == "periodOfTimeForm" || $action =='viewBalance'|| $action == 'showDateForm' ) {echo 'class="active"';}?>><a href="index.php?action=periodOfTimeForm">Przeglądaj bilans</a></li>
							<li <?php if ($action == "showChangePasswordForm" || $action =='showCategoryPersonalization') {echo 'class="active"';}?>class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown">Ustawienia <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="index.php?action=showChangePasswordForm">Zmień dane</a></li>
										<li><a href="index.php?action=showCategoryPersonalization">Konfiguruj kategorie</a></li>
									</ul>
							</li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li><a href="index.php?action=logout"><span class="glyphicon glyphicon-log-out"></span> Wyloguj się</a></li>
						</ul>
					</div>
				</div>
			</nav>    
			<?php endif ?>
			
			<main>
				<div class="container">
						
				<?php
					switch($action):
						case 'showLoginForm':
							include 'templates/loginForm.php';
							break;
						case 'showRegistrationForm':
							include 'templates/registrationForm.php';
							break;
						case 'showExpenseForm':
						    $application->showExpenseForm($statement);
							break;
						case 'successExpense':
							include 'templates/successExpense.php';
							break;
						case 'showIncomeForm':
						    $application->showIncomeForm($statement);
							break;
						case 'successIncome':
							include 'templates/successIncome.php';
							break;
						case 'periodOfTimeForm':
							include 'templates/periodOfTimeForm.php';
							break;
						case 'showDateForm':
							include 'templates/showDateForm.php';
							break;
						case 'viewBalance':
							$application->viewBalance();
							break;
						case 'showChangePasswordForm':
						    include 'templates/changePasswordForm.php';
							break;
						case 'successPassword':
							include 'templates/successPassword.php';
							break;
						case 'showCategoryPersonalization':
							$application->showCategoryPersonalization($statement);
							break;
						case 'addCategoryForm':
							$application->addCategoryForm($statement,$wtd);
							break;
						case 'editCategoryForm':
						    $application->editCategoryForm($statement,$wtd);
							break;
						case 'deleteCategoryForm':
						    
						case 'showMain':
						include 'templates/home.php';
						break;
						default:
						echo 'Błąd';
							
					endswitch;
				?>	
				</div>
			</main>
			
			<footer class="container-fluid text-center">
				Wszystkie prawa zastrzeżone &copy; 2018  Dziękuję za wizytę!
			</footer>
			
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			<?php if($action =='viewBalance'):?> <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
			<?php endif;?>
		</article>
    </body>
</html>
