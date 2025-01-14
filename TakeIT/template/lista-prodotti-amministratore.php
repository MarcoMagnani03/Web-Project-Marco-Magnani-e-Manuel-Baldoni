<header>
	<h2>Deposito prodotti</h2>

	<a href="nuovo-prodotto.php">
		<span aria-hidden="true" class="fa-solid fa-circle-plus"></span>
		<span class="fa-sr-only">Crea un nuovo prodotto</span>
		Crea un nuovo prodotto
	</a>

	<form method="GET">
		<label>
			<span aria-hidden="true" class="fa-solid fa-magnifying-glass"></span>
			<span class="fa-sr-only">Cerca per codice o nome</span>
			<input name="q" type="search" placeholder="Cerca per codice o nome" title="cerca" value="<?php echo $_GET["q"] ?? ""; ?>">
		</label>
		<label for="ordine" class="sr-only">Ordina per:</label>
		<select aria-label="Ordina per" id="ordine" name="ordine">
			<option value="" disabled <?php if(!isset($_GET["ordine"])): echo "selected"; endif; ?>>Ordina per:</option>
			<option value="prezzo ASC" <?php if(($_GET["ordine"] ?? "") == "prezzo ASC"): echo "selected"; endif; ?>>Prezzo crescente</option>
			<option value="prezzo DESC" <?php if(($_GET["ordine"] ?? "") == "prezzo DESC"): echo "selected"; endif; ?>>Prezzo decrescente</option>
			<option value="dataCreazione ASC" <?php if(($_GET["ordine"] ?? "") == "dataCreazione ASC"): echo "selected"; endif; ?>>Data creazione crescente</option>
			<option value="dataCreazione DESC" <?php if(($_GET["ordine"] ?? "") == "dataCreazione DESC"): echo "selected"; endif; ?>>Data creazione decrescente</option>
			<option value="quantita ASC" <?php if(($_GET["ordine"] ?? "") == "quantita ASC"): echo "selected"; endif; ?>>Quantità crescente</option>
			<option value="quantita DESC" <?php if(($_GET["ordine"] ?? "") == "quantita DESC"): echo "selected"; endif; ?>>Quantità decrescente</option>
			<option value="media_recensioni ASC" <?php if(($_GET["ordine"] ?? "") == "media_recensioni ASC"): echo "selected"; endif; ?>>Media recensioni crescente</option>
			<option value="media_recensioni DESC" <?php if(($_GET["ordine"] ?? "") == "media_recensioni DESC"): echo "selected"; endif; ?>>Media recensioni decrescente</option>
		</select>
		<label>
			<input type="submit" value=""/>
			Cerca
		</label>

		<label>
			<input id="btn-mobile-filters-opener" type="button" value="mobile-opener" />
			<span aria-hidden="true" class="fa-solid fa-filter"></span>
			<span class="fa-sr-only">Filtra prodotti</span>
			Filtra prodotti
		</label>
		<!-- FILTRI -->
		<section id="mobile-filters">
			<h3>
				<button id="btn-mobile-filters-closer" type="button" aria-label="Chiudi i filtri">
					<span aria-hidden="true" class="fa-solid fa-xmark"></span>
					<span class="fa-sr-only">Chiudi i filtri</span>
				</button>
			</h3>

			<section>
				<h3>Tipologia</h3>
				<ul>
					<?php foreach($templateParams["tipologie_prodotto"] as $tipologia_prodotto): ?>
						<li>
							<label>
								<?php echo $tipologia_prodotto["nome"]; ?>
								<input name="tipologie_prodotto[]" type="checkbox" value="<?php echo $tipologia_prodotto["nome"]; ?>" <?php if(in_array($tipologia_prodotto["nome"], $_GET["tipologie_prodotto"] ?? [])): echo "checked"; endif; ?>>
							</label>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>

			<section>
				<h3>Marca</h3>
				<ul>
					<?php foreach($templateParams["marche"] as $marca): ?>
						<li>
							<label>
								<?php echo $marca["titolo"]; ?>
								<input name="marche[]" type="checkbox" value="<?php echo $marca["codice"]; ?>" <?php if(in_array($marca["codice"], $_GET["marche"] ?? [])): echo "checked"; endif; ?>>
							</label>
						</li>
					<?php endforeach; ?>
				</ul>
			</section>

			<section>
				<h3>Recensioni</h3>

				<ul>
					<li>
						<label>
							<span class="fa-sr-only">5 stelle</span>
							<input name="recensioni[]" type="checkbox" value="5" title="5 setlle" <?php if(in_array("5", $_GET["recensioni"] ?? [])): echo "checked"; endif; ?> />
						</label>
						<ul>
							<li><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span></li>
						</ul>
					</li>
					<li>
						<label>
							<span class="fa-sr-only">4 stelle</span>
							<input name="recensioni[]" type="checkbox" value="4" title="4 setlle" <?php if(in_array("4", $_GET["recensioni"] ?? [])): echo "checked"; endif; ?> />
						</label>
						<ul>
							<li><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-regular fa-star"></span></li>
						</ul>
					</li>
					<li>
						<label>
							<span class="fa-sr-only">3 stelle</span>
							<input name="recensioni[]" type="checkbox" value="3" title="3 setlle" <?php if(in_array("3", $_GET["recensioni"] ?? [])): echo "checked"; endif; ?> />
						</label>
						<ul>
							<li><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span></li>
						</ul>
					</li>
					<li>
						<label>
							<span class="fa-sr-only">2 stelle</span>
							<input name="recensioni[]" type="checkbox" value="2" title="2 setlle" <?php if(in_array("2", $_GET["recensioni"] ?? [])): echo "checked"; endif; ?> />
						</label>
						<ul>
							<li><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span></li>
						</ul>
					</li>
					<li>
						<label>
							<span class="fa-sr-only">1 stella</span>
							<input name="recensioni[]" type="checkbox" value="1" title="1 setlla" <?php if(in_array("1", $_GET["recensioni"] ?? [])): echo "checked"; endif; ?> />
						</label>
						<ul>
							<li><span class="fa-solid fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span></li>
						</ul>
					</li>
					<li>
						<label>
							<span class="fa-sr-only">0 stelle</span>
							<input name="recensioni[]" type="checkbox" value="0" title="0 setlle" <?php if(in_array("0", $_GET["recensioni"] ?? [])): echo "checked"; endif; ?> />
						</label>
						<ul>
							<li><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span></li>
						</ul>
					</li>
				</ul>
			</section>

			<section>
				<h3>Prezzo</h3>

				<ul>
					<li>
						<label>
							minimo<input type="number" min="0" step="0.01" name="prezzo_min" value="<?php echo $_GET["prezzo_min"] ?? ""; ?>" placeholder="0.00"/>
						</label>
					</li>
					<li>
						<label>
							massimo<input type="number" max="<?php echo $templateParams["prodotti_max_price"]["prezzo"]; ?>" step="0.01" name="prezzo_max" value="<?php echo $_GET["prezzo_max"] ?? ""; ?>" placeholder="<?php echo $templateParams["prodotti_max_price"]["prezzo"]; ?>"/>
						</label>
					</li>
				</ul>
			</section>

			<label>
				<span aria-hidden="true" class="fa-sr-only">Applica filtri</span>
				<input type="submit" value="Applica filtri">
			</label>
		</section>
	</form>
</header>
<section>
	<h2 class="sr-only">Deposito prodotti</h2>
	<?php if(count($templateParams["prodotti"]) > 0): ?>
        <?php foreach($templateParams["prodotti"] as $prodotto): ?>
        <?php 
        $valutazione_prodotto = $dbh->getValutazioneForProdotto($prodotto["codice"]);
        $numero_recensioni_prodotto = count($dbh->getRecensioniForProdotto($prodotto["codice"])); 
        ?>
        <article id="<?php echo $prodotto["codice"]; ?>">
			<h3 class="sr-only"><?php echo htmlspecialchars($prodotto["nome"]); ?></h3>
            <header>
                <img src="<?php echo htmlspecialchars($prodotto['immagine'] ?? 'default.jpg'); ?>" 
                alt="<?php echo htmlspecialchars($prodotto["nome"]); ?>">
				<a href="prodotto.php?codice=<?php echo urlencode($prodotto["codice"]); ?>"><?php echo $prodotto["nome"]; ?></a>
				<section>
					<h4><?php echo $valutazione_prodotto; ?></h4>
					<ul>
						<?php for($i = 0; $i < number_format($valutazione_prodotto, 0); $i++): ?>
							<li><span aria-hidden="true" class="fa-solid fa-star"></span></li>
						<?php endfor; ?>
						<?php for($i = number_format($valutazione_prodotto, 0); $i < 5; $i++): ?>
							<li><span aria-hidden="true" class="fa-regular fa-star"></span></li>
						<?php endfor; ?>
					</ul>
					<h4>(<?php echo $numero_recensioni_prodotto; ?>)</h4>
				</section>

				<p class="card-price"><?php echo $prodotto["prezzo"]; ?>€</p>
			</header>

            <section>
                <h3>
                    Prodotti in deposito
                </h3>
                <ul>
					<li>
						<button data-diminuisci-quantita data-codice-prodotto="<?php echo $prodotto["codice"]; ?>" type="button" value="diminuisci" aria-label="Diminuisci la quantità del prodotto">
							<span aria-hidden="true" class="fa-solid fa-minus"></span>
						</button>
					</li>
					<li>
						<label>
							<span class="fa-sr-only">Quantità del prodotto</span>
							<input data-quantita-prodotto data-codice-prodotto="<?php echo $prodotto["codice"]; ?>" type="number" name="quantita" title="quantità prodotto" value="<?php echo $prodotto["quantita"]; ?>" aria-label="Quantità del prodotto" readonly/>
						</label>
					</li>
					<li>
						<button data-aggiungi-quantita data-codice-prodotto="<?php echo $prodotto["codice"]; ?>" type="button" value="aumenta" aria-label="Aumenta la quantità del prodotto">
							<span aria-hidden="true" class="fa-solid fa-plus"></span>
						</button>
					</li>
				</ul>
            </section>
			<footer>
				<a href="gestisci-prodotto.php?action=1&codiceProdotto=<?php echo urlencode($prodotto['codice']); ?>">Modifica</a>
				<a href="gestisci-prodotto.php?action=2&codiceProdotto=<?php echo urlencode($prodotto['codice']); ?>">Elimina</a>
			</footer>
		</article>
    <?php endforeach; ?>
    <?php else: ?>
        <p>Nessun prodotto trovato</p>
    <?php endif; ?>
</section>
