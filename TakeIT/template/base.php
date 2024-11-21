<!DOCTYPE html>
<html lang="it">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $templateParams["titolo"]; ?></title>
    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <meta charset="UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Mogra' rel='stylesheet'>
</head>
<body>
    <header>
        <h1>TakeIt</h1>
    </header>
    <nav>
        <ul>
            <li><a <?php isActive("index.php");?> href="index.php">Home</a></li><li><a <?php isActive("login.php");?> href="login.php">Login</a></li>
        </ul>
    </nav>
    <main>
    <?php
    if(isset($templateParams["nome"])){
        require($templateParams["nome"]);
    }
    ?>
    </main>
    
    <footer>
        <p>Tecnologie Web - A.A. 2022/2023</p>
    </footer>
</body>
</html>