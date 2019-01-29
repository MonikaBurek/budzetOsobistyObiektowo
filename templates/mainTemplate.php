<?php if(!isset($application)) die();?>
<!DOCTYPE HTML>
<html lang="pl">
    <head>
		<title>Aplikacja</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="budżet, osobisty, domowy" />
		<meta name="author" content="Monika Burek">
			
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">	
		<link rel="stylesheet" href="style.css" type="text/css"/>
		<link rel="stylesheet" href="css/fontello.css" type="text/css"/>
		<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet">
    </head>
    <body>
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
							<li class="active"><a href="index.php">Strona główna</a></li>
							<li><a href="addIncome.php">Dodaj przychód</a></li>
							<li><a href="addExpense.php">Dodaj wydatek</a></li>
							<li><a href="viewBalance.php">Przeglądaj bilans</a></li>
							<li class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Ustawienia <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="#">Zmień dane</a></li>
										<li><a href="#">Zmień kategorie</a></li>
										<li><a href="#">Usuń ostatnie wpisy</a></li>
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
		</article>
    </body>
</html>