<form action="registrazione.php" method="POST" name="formRegistrazione">
    <?php if(isset($templateParams["erroreregistrazione"])): ?>
    <p><?php echo $templateParams["erroreregistrazione"]; ?></p>
    <?php endif; ?>
    <ul>
        <li>
            <label for="nome">Nome*</label>
            <input type="text" id="nome" name="nome" placeholder="Scrivi il tuo nome"  required/>
        </li>
        <li>
            <label for="cognome">Cognome*</label>
            <input type="text" id="cognome" name="cognome" placeholder="Scrivi il tuo cognome"  required/>
        </li>
        <li>
            <label for="dataDiNascita">Data di nascita*</label>
            <input type="date" id="dataDiNascita" name="dataDiNascita"  required/>
            <div id="dataNascitaError">Devi essere maggiorenne per registrarti.
                <em aria-hidden="true" class="fa-solid fa-circle-exclamation"></em>
            </div>
        </li>
        <li>
            <label for="cellulare">Cellulare</label>
            <input type="tel" id="cellulare" name="cellulare" placeholder="Scrivi il tuo numero di cellulare" />
        </li>
        <li>
            <label for="email">E-mail*</label>
            <input type="email" id="email" name="email" placeholder="Scrivi la tua email" required />
        </li>
        <li>
            <label for="password">Password*</label>
            <input type="password" id="password" name="password" placeholder="Scrivi la tua password" required />
            <div id="passwordError">La password deve contenere almeno 8 caratteri, una lettera maiuscola, una minuscola, un numero e un carattere speciale.
                <em aria-hidden="true" class="fa-solid fa-circle-exclamation"></em>
            </div>
        </li>
        <li>
            <label for="confermaPassword">Conferma password*</label>
            <input type="password" id="confermaPassword" name="confermaPassword" placeholder="Conferma la tua password" required />
            <div id="confermaPasswordError">Le password non corrispondono
                <em aria-hidden="true" class="fa-solid fa-circle-exclamation"></em>
            </div>
        </li>
        <li>
            <input type="button" name="registrati" value="Registrati" onclick="effettuaRegistrazione(this.form, event);"/>
        </li>
    </ul>

    <p>* Indicano i campi obbligatori</p>
    <a href="login.php" aria-label="Vai alla pagina di login">Hai già un account? Accedi</a>
</form>
