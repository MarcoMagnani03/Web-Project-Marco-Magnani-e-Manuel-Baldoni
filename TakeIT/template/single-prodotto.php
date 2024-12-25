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
		<h3>
			<?php echo $prodotto["nome"]; ?>
		</h3>

		<section>
			<h3><?php echo number_format($templateParams["valutazione_prodotto"], 1); ?></h3>
			<ul>
				<?php for($i = 0; $i < number_format($templateParams["valutazione_prodotto"], 0); $i++): ?>
					<li><span aria-hidden="true" class="fa-solid fa-star"></span></li>
				<?php endfor; ?>
				<?php for($i = number_format($templateParams["valutazione_prodotto"], 0); $i < 5; $i++): ?>
					<li><span aria-hidden="true" class="fa-regular fa-star"></span></li>
				<?php endfor; ?>
			</ul>
			<h3>(<?php echo count($templateParams["recensioni_prodotto"]); ?>)</h3>
			<a href="#recensioni">vedi recensioni</a>
		</section>

		<section>
			<?php foreach($templateParams["immagini_prodotto"] as $immagine): ?>
				
				<img src="<?php echo htmlspecialchars($immagine); ?>" 
					alt="<?php echo htmlspecialchars($prodotto["nome"]); ?>">
			<?php endforeach; ?>
			<h3>
				<?php echo $prodotto["prezzo"]; ?>€
			</h3>
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
		<h3>Specifiche prodotto non presenti</h3>
	</section>
	<?php
	else:
		$specificheProdotto = $templateParams["specifiche_prodotto"];
	?>
	<section>
		<h3>Caratteristiche</h3>

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
		<h3>Non sono presenti recensioni per questo prodotto</h3>
	</section>
	<?php
	else:
		$recensioni_prodotto = $templateParams["recensioni_prodotto"];
	?>
	<section id="recensioni">
		<h3>Recensioni</h3>

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
					<h4>
						<?php echo $recensione["titolo"]; ?>
					</h4>
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
		<h3>Prodotti correlati non presenti</h3>
	</section>
	<?php
	else:
		$prodottiCorrelati = $templateParams["prodotti_correlati"];
	?>
	<section>
		<h3>Prodotti correlati</h3>

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
