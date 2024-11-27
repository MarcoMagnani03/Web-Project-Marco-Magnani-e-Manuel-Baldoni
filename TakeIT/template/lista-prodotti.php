<header>
	<h1>Cosa cerchi?</h1>

	<form>
		<label>
			<em aria-hidden="true" class="fa-solid fa-magnifying-glass"></em>
			<span class="fa-sr-only">Cerca per codice o nome</span>
			<input name="search" type="search" placeholder="Cerca per codice o nome">
		</label>
		<select name="order">
			<option value="" disabled selected>Ordina per:</option>
			<option value="price-asc">Prezzo crescente</option>
			<option value="price-desc">Prezzo decrescente</option>
			<option value="reviews">Numero di recensioni</option>
		</select>
	</form>

	<button id="btn-mobile-filters-opener" class="btn btn-primary">
		<em aria-hidden="true" class="fa-solid fa-filter"></em>
		<span class="fa-sr-only">Filtra prodotti</span>
		Filtra prodotti
	</button>
	<!-- FILTRI -->
	<form id="mobile-filters">
		<button id="btn-mobile-filters-closer" type="button" aria-label="Chiudi i filtri">
			<em aria-hidden="true" class="fa-solid fa-xmark"></em>
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
			<button id="btn-mobile-filters-applier" type="submit" class="btn btn-primary">
				Applica filtri
			</button>
		</section>
	</form>
</header>
<section>
	<?php foreach($templateParams["prodotti"] as $prodotto): ?>
		<?php $valutazione_prodotto = $dbh->getValutazioneForProdotto($prodotto["codice"]); ?>
		<?php $rumero_recensioni_prodotto = count($dbh->getRecensioniForProdotto($prodotto["codice"])); ?>
		<article class="list-card-prodotto">
			<img width="150" height="150" src="https://m.media-amazon.com/images/I/714J6o2Ug7L._AC_SL1500_.jpg" alt="<?php echo $prodotto["nome"]; ?>">
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
							<li><em aria-hidden="true" class="fa-solid fa-star"></em></li>
						<?php endfor; ?>
						<?php for($i = number_format($valutazione_prodotto, 0); $i < 5; $i++): ?>
							<li><em aria-hidden="true" class="fa-regular fa-star"></em></li>
						<?php endfor; ?>
					</ul>
					<h6>(<?php echo $rumero_recensioni_prodotto; ?>)</h6>
				</section>

				<p class="card-price"><?php echo $prodotto["prezzo"]; ?>€</p>

				<button class="">
					<em aria-hidden="true" class="fa-solid fa-cart-shopping"></em>
					<span class="fa-sr-only">Aggiungi al carrello</span>
				</button>
			</footer>
	</article>
	<?php endforeach; ?>
</section>
