<?php if(!$templateParams["prodotto"]): ?>
<article>
	<p>Prodotto non presente</p>
</article>
<?php
else:
	$prodotto = $templateParams["prodotto"];
?>
<article>
	<section>
		<h1>
			<?php echo $prodotto["nome"]; ?>
		</h1>

		<section>
			<h2><?php echo number_format($templateParams["valutazione_prodotto"], 1); ?></h2>
			<ul>
				<?php for($i = 0; $i < number_format($templateParams["valutazione_prodotto"], 0); $i++): ?>
					<li><span aria-hidden="true" class="fa-solid fa-star"></span></li>
				<?php endfor; ?>
				<?php for($i = number_format($templateParams["valutazione_prodotto"], 0); $i < 5; $i++): ?>
					<li><span aria-hidden="true" class="fa-regular fa-star"></span></li>
				<?php endfor; ?>
			</ul>
			<h2>(<?php echo count($templateParams["recensioni_prodotto"]); ?>)</h2>
			<a href="#recensioni">vedi recensioni</a>
		</section>

		<section>
			<?php foreach($templateParams["immagini_prodotto"] as $immagine): ?>
				
				<img src="<?php echo htmlspecialchars($immagine); ?>" 
					alt="<?php echo htmlspecialchars($prodotto["nome"]); ?>">
			<?php endforeach; ?>
			<h2>
				<?php echo $prodotto["prezzo"]; ?>€
			</h2>
			<p>
				<?php echo $prodotto["descrizione"]; ?>
			</p>
		</section>

		<button class="btn btn-primary">
			Aggiungi al carrello
		</button>
	</section>

	<!-- SPECIFICHE PRODOTTO -->
	<?php if(count($templateParams["specifiche_prodotto"])==0): ?>
	<section>
		<h2>Specifiche prodotto non presenti</h2>
	</section>
	<?php
	else:
		$specificheProdotto = $templateParams["specifiche_prodotto"];
	?>
	<section>
		<h2>Caratteristiche</h2>

		<table>
			<?php foreach($specificheProdotto as $specifica): ?>
				<tr>
					<th>
						<?php echo $specifica["nome"]; ?>
					</th>
					<td>
						<?php echo $specifica["contenuto"]; ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</section>
	<?php endif; ?>

	<!-- PRODOTTI CORRELATI -->
	<?php if(count($templateParams["recensioni_prodotto"])==0): ?>
	<section>
		<h2>Non sono presenti recensioni per questo prodotto</h2>
	</section>
	<?php
	else:
		$recensioni_prodotto = $templateParams["recensioni_prodotto"];
	?>
	<section id="recensioni">
		<h2>Recensioni</h2>

		<!-- FILTRI RECENSIONI -->

		<ul>
			<?php foreach(array_splice($recensioni_prodotto, 0, 5) as $recensione): ?>
				<li>
					<!-- STELLE RECENSIONE -->
					<ul>
						<?php for($i = 0; $i < $recensione["valutazione"]; $i++): ?>
							<li><span aria-hidden="true" class="fa-solid fa-star"></span></li>
						<?php endfor; ?>
						<?php for($i = $recensione["valutazione"]; $i < 5; $i++): ?>
							<li><span aria-hidden="true" class="fa-regular fa-star"></span></li>
						<?php endfor; ?>
						<li>
							<p><?php echo $recensione["valutazione"]; ?>/5</p>
						</li>
					</ul>
					<h3>
						<?php echo $recensione["titolo"]; ?>
					</h3>
					<p>
						<?php echo $recensione["descrizione"]; ?>
					</p>
					<p>
						<?php echo $recensione["nome"]; ?> <?php echo $recensione["cognome"]; ?>
					</p>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
	<?php endif; ?>

	<!-- PRODOTTI CORRELATI -->
	<?php if(count($templateParams["prodotti_correlati"])==0): ?>
	<section>
		<h2>Prodotti correlati non presenti</h2>
	</section>
	<?php
	else:
		$prodottiCorrelati = $templateParams["prodotti_correlati"];
	?>
	<section>
		<h2>Prodotti correlati</h2>

		<ul>
			<?php foreach($prodottiCorrelati as $prodottoCorrelato): ?>
				<?php $valutazione_prodotto = $dbh->getValutazioneForProdotto($prodottoCorrelato["codice"]); ?>
				<li>
					<img width="100%" height="auto" src="https://m.media-amazon.com/images/I/714J6o2Ug7L._AC_SL1500_.jpg" alt="<?php echo $prodottoCorrelato["nome"]; ?>">
					<a href="prodotto.php?codice=<?php echo $prodottoCorrelato["codice"]; ?>">
						<?php echo $prodottoCorrelato["nome"]; ?>
					</a>

					<!-- STELLE RECENSIONE -->
					<ul>
						<?php for($i = 0; $i < number_format($valutazione_prodotto, 0); $i++): ?>
							<li><span aria-hidden="true" class="fa-solid fa-star"></span></li>
						<?php endfor; ?>
						<?php for($i = number_format($valutazione_prodotto, 0); $i < 5; $i++): ?>
							<li><span aria-hidden="true" class="fa-regular fa-star"></span></li>
						<?php endfor; ?>
						<li>
							<p><?php echo $valutazione_prodotto; ?>/5</p>
						</li>
					</ul>
					<p>
						<?php echo $prodottoCorrelato["prezzo"]; ?>€
					</p>
					<button>
						<span aria-hidden="true" class="fa-solid fa-cart-shopping"></span>
						<span class="fa-sr-only">Aggiungi il carrello</span>
					</button>
				</li>
			<?php endforeach; ?>
		</ul>
	</section>
	<?php endif; ?>
</article>
<?php endif; ?>
