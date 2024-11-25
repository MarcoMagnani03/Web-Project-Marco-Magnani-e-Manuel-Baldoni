<!DOCTYPE html>
<html lang="it">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $templateParams["titolo"]; ?></title>
    <link rel="stylesheet" type="text/css" href="./css/system.css" />
    <link rel="stylesheet" type="text/css" href="./css/auth.css" />
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Mogra&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c51bf555ba.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <a href="index.php">← Home</a>
        <h1>TakeIT</h1>
    </header>
    
    <main>
        <?php
        if(isset($templateParams["nome"])){
            require($templateParams["nome"]);
        }
        ?>
    </main>
    <?php include_once 'footer.php'; ?>
    
    <script src="./js/sha512.js"></script>
    <script src="./js/auth.js"></script>
</body>
</html>