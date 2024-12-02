<form action="modifica-informazioni.php" method="POST" name="formModifica">
    <ul>
        <li>
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" placeholder="Scrivi il tuo nome" value="<?php echo htmlspecialchars($templateParams["informazioni"]["nome"]); ?>" required/>
        </li>
        <li>
            <label for="cognome">Cognome</label>
            <input type="text" id="cognome" name="cognome" placeholder="Scrivi il tuo cognome" value="<?php echo htmlspecialchars($templateParams["informazioni"]["cognome"]); ?>" required/>
        </li>
        <li>
            <label for="dataDiNascita">Data di nascita</label>
            <input type="date" id="dataDiNascita" name="dataDiNascita" value="<?php echo htmlspecialchars($templateParams["informazioni"]["dataDiNascita"]); ?>" required/>
            <div id="dataNascitaError">Devi essere maggiorenne per registrarti.
                <span aria-hidden="true" class="fa-solid fa-circle-exclamation"></span>
            </div>
        </li>
        <li>
            <label for="cellulare">Cellulare</label>
            <input type="tel" id="cellulare" name="cellulare" placeholder="Scrivi il tuo numero di cellulare" value="<?php echo htmlspecialchars($templateParams["informazioni"]["cellulare"]); ?>"/>
        </li>
        <li>
            <label for="vecchiaPassword">Vecchia password</label>
            <input type="password" id="vecchiaPassword" name="vecchiaPassword" placeholder="Scrivi la tua vecchia password" required />
            <div id="vecchiaPasswordError">La password è diversa dalla tua attuale
                <span aria-hidden="true" class="fa-solid fa-circle-exclamation"></span>
            </div>
        </li>
        <li>
            <label for="password">Nuova password</label>
            <input type="password" id="password" name="password" placeholder="Scrivi la tua password" required />
            <div id="passwordError">La password deve contenere almeno 8 caratteri, una lettera maiuscola, una minuscola, un numero e un carattere speciale.
                <span aria-hidden="true" class="fa-solid fa-circle-exclamation"></span>
            </div>
        </li>
        <li>
            <label for="confermaPassword">Conferma password</label>
            <input type="password" id="confermaPassword" name="confermaPassword" placeholder="Conferma la tua password" required />
            <div id="confermaPasswordError">Le password non corrispondono
                <span aria-hidden="true" class="fa-solid fa-circle-exclamation"></span>
            </div>
        </li>
        <li>
            <input type="button" name="annulla" value="Annulla" onclick="passaAAreaPersonale()"/>
            <input type="button" name="salva" value="Salva" onclick="controllaInfoPersonali(this.form, event)"/>
        </li>
    </ul>
</form>
