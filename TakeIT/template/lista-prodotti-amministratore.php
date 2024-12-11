<header>
	<h2>Cosa cerchi?</h2>

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
	<ul>
		<?php foreach($templateParams["prodotti"] as $prodotto): ?>
			<?php $valutazione_prodotto = $dbh->getValutazioneForProdotto($prodotto["codice"]); ?>
			<?php $numero_recensioni_prodotto = count($dbh->getRecensioniForProdotto($prodotto["codice"])); ?>
			
			<li>
				<section>
					<img width="150" height="150" src="https://m.media-amazon.com/images/I/714J6o2Ug7L._AC_SL1500_.jpg" alt="<?php echo $prodotto["nome"]; ?>">
					<header>
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
				</section>

				<section>
					<h3>
						Prodotti in deposito
					</h3>
					<ul>
						<li>
							<button>
								<span aria-hidden="true" class="fa-solid fa-minus"></span>
								<span class="fa-sr-only">Aumenta la quantità del prodotto</span>
							</button>
						</li>
						<li>
							<label><span class="fa-sr-only">Quantità del prodotto</span><input type="number" value="1" aria-label="Quantità del prodotto" readonly/></label>
						</li>
						<li>
							<button>
								<span aria-hidden="true" class="fa-solid fa-plus"></span>
								<span class="fa-sr-only">Aumenta la quantità del prodotto</span>
							</button>
						</li>
					</ul>
				</section>

				<button>
					Modifica
				</button>
				<button>
					Elimina
				</button>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
