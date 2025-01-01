<form action="login.php" method="POST" name="formLogin">
    <ul>
        <li>
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" placeholder="scrivi la tua email" required />
        </li>
        <li>
            <label for="password">Password</label>
            <input type="password" id="password" name="p" placeholder="scrivi la tua password" required />
        </li>
        <li>
            <input type="submit" name="accedi" value="Accedi" onclick="formhash(this.form,this.form.password);"/>
        </li>
    </ul>

    <a href="registrazione.php" aria-label="Pagina per registrarsi">Non hai ancora un account? Registrati</a>
</form>
