<header>
	<h2>Tipologie prodotto</h2>
</header>

<form>
	<button type="button">
		<span aria-hidden="true" class="fa-solid fa-circle-plus"></span>
		<span class="fa-sr-only">Crea una nuova tipologia di prodotto</span>
		Crea una nuova tipologia di prodotto
	</button>
	
	<input type="search" placeholder="Cerca per nome"/>
	<button type="submit">
		<span aria-hidden="true" class="fa-solid fa-magnifying-glass"></span>
		<span class="fa-sr-only">Cerca</span>
		Cerca
	</button>
</form>

<?php if(count($templateParams["tipologie_prodotto"]) == 0): ?>
    <p>Non ci sono tipologie di prodotto</p>
<?php else: 
    $tipologie_prodotto = $templateParams["tipologie_prodotto"]; 
?>
    <?php foreach($tipologie_prodotto as $tipologia_prodotto): ?>
        <article data-id="<?php echo htmlspecialchars($tipologia_prodotto["id"]); ?>">
            <header>
                <h2><?php echo htmlspecialchars($tipologia_prodotto["nome"]); ?></h2>
            </header>
            
            <section>
                <h3>Descrizione:</h3>
                <p class="descrizione"><?php echo htmlspecialchars($tipologia_prodotto["descrizione"]); ?></p>
            </section>
            
            <section>
                <h3>Caratteristiche:</h3>
                <ul class="caratteristiche">
                    <?php foreach($tipologia_prodotto["caratteristiche"] as $caratteristica): ?>
                        <li>
                            <span><?php echo htmlspecialchars($caratteristica["nome"]); ?></span>
                            <button type="button">Elimina</button>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" hidden>+</button>
            </section>
            
            <footer>
                <button type="button">Modifica</button>
                <button type="button" hidden>Salva</button>
            </footer>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
