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
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>