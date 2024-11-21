<form action="login.php" method="POST">
    <?php if(isset($templateParams["errorelogin"])): ?>
    <p><?php echo $templateParams["errorelogin"]; ?></p>
    <?php endif; ?>

    <ul>
        <li>
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="scrivi la tua email" required />
        </li>
        <li>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="scrivi la tua password" required />
        </li>
        <li>
            <input type="submit" name="submit" value="Accedi" />
        </li>
    </ul>

    <a href="registrazione.php" aria-label="Pagina per registrarsi">Non hai ancora un account? Registrati</a>
</form>
