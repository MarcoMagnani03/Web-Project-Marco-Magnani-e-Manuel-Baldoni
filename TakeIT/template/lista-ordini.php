<header>
    <h2>Lista ordini</h2>

    <form>
        <span aria-hidden="true" class="fa-solid fa-magnifying-glass"></span>
        <span class="fa-sr-only">Cerca per numero</span>
        <label for="search" class="fa-sr-only">Cerca per numero:</label>
        <input name="search" type="search" id="search" placeholder="Cerca per numero">
	</form>
    <button id="btn-mobile-filters-opener">
		<span aria-hidden="true" class="fa-solid fa-filter"></span>
		<span class="fa-sr-only">Filtra ordini</span>
		Filtra ordini
	</button>

    <!-- Sezione filtri -->
    <form id="mobile-filters">
		<button id="btn-mobile-filters-closer" type="button" aria-label="Chiudi i filtri">
			<span aria-hidden="true" class="fa-solid fa-xmark"></span>
			<span class="fa-sr-only">Chiudi i filtri</span>
		</button>

		<section>
			<h3>Tipologia</h3>
			<ul>
				<!-- <?php foreach($templateParams["tipologie_prodotti"] as $tipologia_prodotto): ?>
					<li>
						<label>
							<input type="checkbox" value="">
							<?php echo $tipologia_prodotto["nome"]; ?>
						</label>
					</li>
				<?php endforeach; ?> -->
			</ul>
		</section>

        <button id="btn-mobile-filters-applier" type="submit">
            Applica filtri
        </button>
	</form>
</header>

<?php foreach ($templateParams["ordini"] as $ordine): 
    $total =$ordine['prezzoTotale']?>
<article>
    <!-- Informazioni ordine -->
    <header>
        <h3>Ordine n. <strong>#<?php echo htmlspecialchars($ordine['codice_ordine']); ?></strong></h3>
        <?php if($dbh->login_check_admin()):?>
            <p>Utente: <strong><?php echo htmlspecialchars($ordine['utente'])?></strong></p>
        <?php endif?>
        <p>Data ordine: <time datetime="<?php echo date('Y-m-d', strtotime($ordine['dataPartenza'])); ?>">
            <?php echo htmlspecialchars($ordine['dataPartenza']); ?>
        </time></p>
        <?php if($dbh->login_check_admin()): ?>
            <p>Data prevista arrivo: 
                <input type="datetime-local" name="dataOraArrivo" value="<?php echo date('Y-m-d\TH:i', strtotime($ordine['dataOraArrivo'])); ?>">
            </p>
            <p>Stato dell'ordine: 
                <select name="statoOrdine">
                    <?php foreach ($templateParams["tipologie_ordini"] as $tipologia):?> 
                        <option value="<?php echo htmlspecialchars($tipologia); ?>" 
                            <?php echo $ordine['stato'] === $tipologia ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($tipologia); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
        <?php else: ?>
            <p>Data prevista arrivo: 
                <time datetime="<?php echo date('Y-m-d\TH:i', strtotime($ordine['dataOraArrivo'])); ?>">
                    <?php echo htmlspecialchars(date('H:i', strtotime($ordine['dataOraArrivo']))); ?>
                </time>
            </p>
            <p>Stato dell'ordine: <strong><?php echo htmlspecialchars($ordine['stato']); ?></strong></p>
        <?php endif; ?>

    </header>

    <!-- Lista prodotti -->
    <section>
        <h4>Prodotti acquistati:</h4>
        <ul>
            <?php foreach ($ordine['prodotti'] as $product): ?>
            <?php $valutazione_prodotto = $dbh->getValutazioneForProdotto($product["codice"]); ?>
            <?php $numero_recensioni_prodotto = count($dbh->getRecensioniForProdotto($product["codice"]));?>
            <li>
                <img src="<?php echo htmlspecialchars($prodotto["percorso_immagine"]);?>" 
                alt="<?php echo htmlspecialchars($prodotto["nome"]); ?>">
                <footer>
                    <!-- RECENSIONI -->
                    <section>
                        <h6><?php echo $valutazione_prodotto; ?></h6>
                        <ul>
                            <?php for($i = 0; $i < number_format($valutazione_prodotto, 0); $i++): ?>
                                <li><span aria-hidden="true" class="fa-solid fa-star"></span></li>
                            <?php endfor; ?>
                            <?php for($i = number_format($valutazione_prodotto, 0); $i < 5; $i++): ?>
                                <li><span aria-hidden="true" class="fa-regular fa-star"></span></li>
                            <?php endfor; ?>
                        </ul>
                        <p>(<?php echo $numero_recensioni_prodotto; ?>)</p>
                    </section>

                    <p>Quantità: <?php echo $product["quantita"]; ?></p>
                    <p><?php echo number_format($product["prezzo"], 2, ',', ''); ?>€</p>
                </footer>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>

    <!-- Totale e pulsante -->
    <footer>
        <p><strong>Totale:</strong> <?php echo number_format($total, 2, ',', ''); ?> €</p>
        
        <?php if($dbh->login_check_admin()): ?>
            <input type="button" name="salva" value="Salva" onclick="salvaOrdine(event)"/>
            <input type="button" name="elimina" value="Elimina" onclick="eliminaOrdine(event)"/>
        <?php else: ?>
            <form method="POST" action="riepilogo-ordine.php">
                <?php foreach ($ordine['prodotti'] as $product): ?>
                    <input type="hidden" name="prodotti[]" value="<?php echo htmlspecialchars(json_encode($product)); ?>">
                <?php endforeach; ?>
                <button type="submit">Acquista di nuovo</button>
            </form>
        <?php endif; ?>
    </footer>

</article>
<?php endforeach; ?>
