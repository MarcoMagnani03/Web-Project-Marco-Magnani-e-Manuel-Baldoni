<!DOCTYPE html>
<html lang="it" xml:lang="it">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php echo $templateParams["titolo"]; ?></title>
		<link rel="stylesheet" type="text/css" href="./css/system.css" />
		<link rel="stylesheet" type="text/css" href="./css/style.css" />
		
		<?php if(isset($templateParams["css"])): ?>
            <link rel="stylesheet" type="text/css" href="./css/<?php echo $templateParams["css"]; ?>" />
        <?php endif; ?>

		<meta charset="UTF-8">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Mogra&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
		<script src="https://kit.fontawesome.com/c51bf555ba.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
	</head>
	<body>
		<?php include_once 'header.php'; ?>
		<!-- <nav>
			<ul>
				<li><a <?php isActive("index.php");?> href="index.php">Home</a></li><li><a <?php isActive("login.php");?> href="login.php">Login</a></li>
			</ul>
		</nav> -->
		<main>
			<?php
			if(isset($templateParams["nome"])){
				require($templateParams["nome"]);
			}
			?>
		</main>
		
		<?php include_once 'footer.php'; ?>

		<script src="./js/main.js"></script>
		<script src="./js/notifiche.js"></script>
	</body>
</html>