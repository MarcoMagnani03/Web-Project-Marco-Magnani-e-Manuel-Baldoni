<form method="POST" action="gestisci-tipologia.php?action=<?php echo htmlspecialchars($templateParams['action']); ?>&nome=<?php echo htmlspecialchars($templateParams['tipologia']['nome'] ?? ''); ?>" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?php echo htmlspecialchars($templateParams['action']); ?>">

    <fieldset>
        <legend>
            <?php echo $templateParams['action'] == 2 ? "Modifica Tipologia" : "Crea Nuova Tipologia"; ?>
        </legend>

        <section>
            <h3 class="sr-only">Nome della tipologia</h3>
            <label for="nome">Nome Tipologia:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($templateParams['tipologia']['nome'] ?? ''); ?>" required>
        </section>

        <section>
            <h3 class="sr-only">Descrizione della tipologia</h3>
            <label for="descrizione">Descrizione:</label>
            <textarea id="descrizione" name="descrizione" required><?php echo htmlspecialchars($templateParams['tipologia']['descrizione'] ?? ''); ?></textarea>
        </section>

        <section>
            <h3>Caratteristiche:</h3>
            <ul id="lista-caratteristiche">
                <?php if (!empty($templateParams['tipologia']['caratteristiche'])): ?>
                    <?php foreach ($templateParams['tipologia']['caratteristiche'] as $index => $caratteristica): ?>
                        <li>
                            <label for="caratteristica-<?php echo $index; ?>" class="sr-only">
                                Nome Caratteristica:
                            </label>
                            <input type="text" 
                                   id="caratteristica-<?php echo $index; ?>" 
                                   name="caratteristiche[]" 
								   title="caratteristica-<?php echo $index; ?>"
                                   value="<?php echo htmlspecialchars($caratteristica['nome']); ?>" 
                                   required>

                            <button type="button" onclick="rimuoviCaratteristica(this)" 
                                    aria-label="Rimuovi <?php echo htmlspecialchars($caratteristica['nome']); ?>">
                                <span aria-hidden="true" class="fa-solid fa-trash"></span>
                            </button>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>
						<label for="caratteristica-0" class="sr-only">aggiungi prima caratteristica</label>
                        <input type="text" 
                               id="caratteristica-0" 
                               name="caratteristiche[]" 
                               placeholder="Aggiungi una caratteristica" 
                               required>
                    </li>
                <?php endif; ?>
            </ul>

            <button type="button" onclick="aggiungiCaratteristica()">
                <span aria-hidden="true" class="fa-solid fa-circle-plus"></span>
                <span class="sr-only">Aggiungi Caratteristica</span>
            </button>
        </section>
    </fieldset>

    <footer>
        <button type="submit">Salva</button>
        <a href="tipologie-prodotto.php">Annulla</a>
    </footer>
</form>