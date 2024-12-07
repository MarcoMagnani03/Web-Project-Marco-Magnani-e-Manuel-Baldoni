<section>
    <h2>Informazioni personali</h2>
    <ul>
        <li>
            <strong>Nome:</strong> <?php echo htmlspecialchars($templateParams["informazioni"]["nome"]); ?>
        </li>
        <li>
            <strong>Cognome:</strong> <?php echo htmlspecialchars($templateParams["informazioni"]["cognome"]); ?>
        </li>
        <li>
            <strong>Data di nascita:</strong> <?php echo htmlspecialchars($templateParams["informazioni"]["dataDiNascita"]); ?>
        </li>
        <li>
            <strong>Cellulare:</strong> <?php echo htmlspecialchars($templateParams["informazioni"]["cellulare"]); ?>
        </li>
        <li>
            <strong>E-mail:</strong> <?php echo htmlspecialchars($templateParams["informazioni"]["email"]); ?>
        </li>
        <li>
            <strong>Password:</strong> ***********
        </li>
    </ul>
    <a href="modifica-informazioni.php" aria-label="Modifica le informazioni personali">Modifica informazioni</a>
</section>
