<header>
	<h2>Deposito prodotti</h2>

	<a href="nuovo-prodotto.php">
		<span aria-hidden="true" class="fa-solid fa-circle-plus"></span>
		<span class="fa-sr-only">Crea un nuovo prodotto</span>
		Crea un nuovo prodotto
	</a>

	<form>
		<label>
			<span aria-hidden="true" class="fa-solid fa-magnifying-glass"></span>
			<span class="fa-sr-only">Cerca per codice o nome</span>
			<input name="search" type="search" placeholder="Cerca per codice o nome">
		</label>
		<select aria-label="Ordina per" name="order">
			<option value="" disabled selected>Ordina per:</option>
			<option value="price-asc">Prezzo crescente</option>
			<option value="price-desc">Prezzo decrescente</option>
			<option value="reviews">Numero di recensioni</option>
		</select>
	</form>

	<button id="btn-mobile-filters-opener">
		<span aria-hidden="true" class="fa-solid fa-filter"></span>
		<span class="fa-sr-only">Filtra prodotti</span>
		Filtra prodotti
	</button>
	<!-- FILTRI -->
	<form id="mobile-filters">
		<button id="btn-mobile-filters-closer" type="button" aria-label="Chiudi i filtri">
			<span aria-hidden="true" class="fa-solid fa-xmark"></span>
			<span class="fa-sr-only">Chiudi i filtri</span>
		</button>

		<section>
			<h3>Tipologia</h3>
			<ul>
				<?php foreach($templateParams["tipologie_prodotti"] as $tipologia_prodotto): ?>
					<li>
						<label>
							<input type="checkbox" value="">
							<?php echo $tipologia_prodotto["nome"]; ?>
						</label>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>

		<section>
			<button id="btn-mobile-filters-applier" type="submit">
				Applica filtri
			</button>
		</section>
	</form>
</header>
<section>
    <?php foreach($templateParams["prodotti"] as $prodotto): ?>
        <?php 
        $valutazione_prodotto = $dbh->getValutazioneForProdotto($prodotto["codice"]);
        $numero_recensioni_prodotto = count($dbh->getRecensioniForProdotto($prodotto["codice"])); 
        ?>
        <article>
            <header>
                <img src="<?php echo htmlspecialchars($prodotto['immagine'] ?? 'default.jpg'); ?>" 
                alt="<?php echo htmlspecialchars($prodotto["nome"]); ?>">
				<h4>
					<a href="prodotto.php?codice=<?php echo $prodotto["codice"]; ?>"><?php echo $prodotto["nome"]; ?></a>
				</h4>
				<section>
					<h5><?php echo $valutazione_prodotto; ?></h5>
					<ul>
						<?php for($i = 0; $i < number_format($valutazione_prodotto, 0); $i++): ?>
							<li><span aria-hidden="true" class="fa-solid fa-star"></span></li>
						<?php endfor; ?>
						<?php for($i = number_format($valutazione_prodotto, 0); $i < 5; $i++): ?>
							<li><span aria-hidden="true" class="fa-regular fa-star"></span></li>
						<?php endfor; ?>
					</ul>
					<h5>(<?php echo $numero_recensioni_prodotto; ?>)</h5>
				</section>

				<p class="card-price"><?php echo $prodotto["prezzo"]; ?>€</p>
			</header>

            <section>
                <h3>
                    Prodotti in deposito
                </h3>
                <form action="gestisci_quantita.php" method="post">
                    <ul>
                        <li>
                            <button type="submit" name="azione" value="diminuisci" aria-label="Diminuisci la quantità del prodotto">
                                <span aria-hidden="true" class="fa-solid fa-minus"></span>
                            </button>
                        </li>
                        <li>
                            <label>
                                <span class="fa-sr-only">Quantità del prodotto</span>
                                <input type="number" name="quantita" value="1" aria-label="Quantità del prodotto" readonly/>
                            </label>
                        </li>
                        <li>
                            <button type="submit" name="azione" value="aumenta" aria-label="Aumenta la quantità del prodotto">
                                <span aria-hidden="true" class="fa-solid fa-plus"></span>
                            </button>
                        </li>
                    </ul>
                    <input type="hidden" name="codice_prodotto" value="<?php echo $prodotto["codice"]; ?>" />
                </form>
            </section>
			<footer>
				<a href="gestisci-prodotto.php?action=1&codiceProdotto=<?php echo $prodotto['codice']; ?>">Modifica</a>
			    <a href="gestisci-prodotto.php?action=2&codiceProdotto=<?php echo $prodotto['codice']; ?>">Elimina</a>
			</footer>
		</article>
    <?php endforeach; ?>
</section>
