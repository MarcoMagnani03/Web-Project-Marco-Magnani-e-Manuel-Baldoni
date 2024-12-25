<header>
	<h2>Tipologie prodotto</h2>
</header>

<form>
    <a href="gestisci-tipologia.php?action=1">
		<span aria-hidden="true" class="fa-solid fa-circle-plus"></span>
		<span class="fa-sr-only">Crea una nuova tipologia di prodotto</span>
		Crea una nuova tipologia di prodotto
	</a>
	
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
        <article>
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
            </section>
            
            <footer>
                <a href="gestisci-tipologia.php?action=2&nome=<?php echo $tipologia_prodotto["nome"]; ?>">Modifica</a>
                <a href="gestisci-tipologia.php?action=3&nome=<?php echo $tipologia_prodotto["nome"]; ?>">Elimina</a>
            </footer>
        </article>
    <?php endforeach; ?>
<?php endif; ?>
