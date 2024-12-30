<header>
	<h2>Cosa cerchi?</h2>

	<form method="GET">
		<label>
			<span aria-hidden="true" class="fa-solid fa-magnifying-glass"></span>
			<span class="fa-sr-only">Cerca per codice o nome</span>
			<input name="q" type="search" placeholder="Cerca per codice o nome" value="<?php echo $_GET["q"] ?? ""; ?>">
		</label>
		<select aria-label="Ordina per" name="ordine">
			<option value="" disabled <?php if(!isset($_GET["ordine"])): echo "selected"; endif; ?>>Ordina per:</option>
			<option value="prezzo ASC" <?php if(($_GET["ordine"] ?? "") == "prezzo ASC"): echo "selected"; endif; ?>>Prezzo crescente</option>
			<option value="prezzo DESC" <?php if(($_GET["ordine"] ?? "") == "prezzo DESC"): echo "selected"; endif; ?>>Prezzo decrescente</option>
		</select>
		<label>
			<input type="submit" value=""/>
			Cerca
		</label>

		<label>
			<input id="btn-mobile-filters-opener" type="button" />
			<span aria-hidden="true" class="fa-solid fa-filter"></span>
			<span class="fa-sr-only">Filtra prodotti</span>
			Filtra prodotti
		</label>
		<!-- FILTRI -->
		<section id="mobile-filters">
			<header>
				<button id="btn-mobile-filters-closer" type="button" aria-label="Chiudi i filtri">
					<span aria-hidden="true" class="fa-solid fa-xmark"></span>
					<span class="fa-sr-only">Chiudi i filtri</span>
				</button>
			</header>

			<section>
				<h3>Tipologia</h3>
				<ul>
					<?php foreach($templateParams["tipologie_prodotto"] as $tipologia_prodotto): ?>
						<li>
							<label>
								<input name="tipologie_prodotto[]" type="checkbox" value="<?php echo $tipologia_prodotto["nome"]; ?>" <?php if(in_array($tipologia_prodotto["nome"], $_GET["tipologie_prodotto"] ?? [])): echo "checked"; endif; ?>>
								<?php echo $tipologia_prodotto["nome"]; ?>
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
								<input name="marche[]" type="checkbox" value="<?php echo $marca["codice"]; ?>" <?php if(in_array($marca["codice"], $_GET["marche"] ?? [])): echo "checked"; endif; ?>>
								<?php echo $marca["titolo"]; ?>
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
							<input name="recensioni[]" type="checkbox" value="5" <?php if(in_array("5", $_GET["recensioni"] ?? [])): echo "checked"; endif; ?> />
							<span class="fa-sr-only">5 stelle</span>
							<ul>
								<li><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span></li>
							</ul>
						</label>
					</li>
					<li>
						<label>
							<input name="recensioni[]" type="checkbox" value="4" <?php if(in_array("4", $_GET["recensioni"] ?? [])): echo "checked"; endif; ?> />
							<span class="fa-sr-only">4 stelle</span>
							<ul>
								<li><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-regular fa-star"></span></li>
							</ul>
						</label>
					</li>
					<li>
						<label>
							<input name="recensioni[]" type="checkbox" value="3" <?php if(in_array("3", $_GET["recensioni"] ?? [])): echo "checked"; endif; ?> />
							<span class="fa-sr-only">3 stelle</span>
							<ul>
								<li><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span></li>
							</ul>
						</label>
					</li>
					<li>
						<label>
							<input name="recensioni[]" type="checkbox" value="2" <?php if(in_array("2", $_GET["recensioni"] ?? [])): echo "checked"; endif; ?> />
							<span class="fa-sr-only">2 stelle</span>
							<ul>
								<li><span class="fa-solid fa-star"></span><span class="fa-solid fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span></li>
							</ul>
						</label>
					</li>
					<li>
						<label>
							<input name="recensioni[]" type="checkbox" value="1" <?php if(in_array("1", $_GET["recensioni"] ?? [])): echo "checked"; endif; ?> />
							<span class="fa-sr-only">1 stella</span>
							<ul>
								<li><span class="fa-solid fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span><span class="fa-regular fa-star"></span></li>
							</ul>
						</label>
					</li>
				</ul>
			</section>

			<section>
				<h3>Prezzo</h3>

				<ul>
					<li>
						<label>
							Minimo:
							<input type="number" min="0" step="0.01" name="prezzo_min" value="<?php echo $_GET["prezzo_min"] ?? ""; ?>" placeholder="0.00"/>
						</label>
					</li>
					<li>
						<label>
							Massimo:
							<input type="number" max="<?php echo $templateParams["prodotti_max_price"]["prezzo"]; ?>" step="0.01" name="prezzo_max" value="<?php echo $_GET["prezzo_max"] ?? ""; ?>" placeholder="<?php echo $templateParams["prodotti_max_price"]["prezzo"]; ?>"/>
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
	<?php foreach($templateParams["prodotti"] as $prodotto): ?>
		<?php 
        $valutazione_prodotto = $dbh->getValutazioneForProdotto($prodotto["codice"]);
        $numero_recensioni_prodotto = count($dbh->getRecensioniForProdotto($prodotto["codice"])); 
        ?>
		<article class="list-card-prodotto">
			<img src="<?php echo htmlspecialchars($prodotto['immagine'] ?? 'default.jpg'); ?>" 
                 alt="<?php echo htmlspecialchars($prodotto["nome"]); ?>">
			<header>
				<h4>
					<a href="prodotto.php?codice=<?php echo $prodotto["codice"]; ?>"><?php echo $prodotto["nome"]; ?></a>
				</h4>
			</header>

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
					<h6>(<?php echo $numero_recensioni_prodotto; ?>)</h6>
				</section>

				<p class="card-price"><?php echo $prodotto["prezzo"]; ?>€</p>

				<button>
					<span aria-hidden="true" class="fa-solid fa-cart-shopping"></span>
					<span class="fa-sr-only">Aggiungi al carrello</span>
				</button>
			</footer>
	</article>
	<?php endforeach; ?>
</section>
