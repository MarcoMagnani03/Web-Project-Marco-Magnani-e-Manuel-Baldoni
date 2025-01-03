<form method="POST" action="">
    <input type="hidden" name="action" value="<?php echo htmlspecialchars($templateParams['action']); ?>">
    <fieldset>
        <legend><?php echo $templateParams['action'] == 2 ? "Modifica Tipologia" : "Crea Nuova Tipologia"; ?></legend>
        
        <section>
            <label for="nome">Nome Tipologia:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($templateParams['tipologia']['nome'] ?? ''); ?>" required>
        </section>

        <section>
            <label for="descrizione">Descrizione:</label>
            <textarea id="descrizione" name="descrizione" required><?php echo htmlspecialchars($templateParams['tipologia']['descrizione'] ?? ''); ?></textarea>
        </section>

        <section>
            <label for="caratteristiche">Caratteristiche:</label>
            <ul id="lista-caratteristiche">
                <?php if (!empty($templateParams['tipologia']['caratteristiche'])): ?>
                    <?php foreach ($templateParams['tipologia']['caratteristiche'] as $caratteristica): ?>
                        <li>
                            <label>
								<span class="sr-only"><?php echo htmlspecialchars($caratteristica['nome']); ?></span>
								<input type="text" name="caratteristiche[]" value="<?php echo htmlspecialchars($caratteristica['nome']); ?>" required>
								<button type="button" onclick="rimuoviCaratteristica(this)">
									<span aria-hidden="true" class="fa-solid fa-trash"></span>
									<span class="sr-only">Rimuovi Caratteristica</span>
								</button>
							</label>
                        </li>
                    <?php endforeach; ?>
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
