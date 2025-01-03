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
		<h2>
			<?php echo $prodotto["nome"]; ?>
		</h2>

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

		<?php if(!$dbh->login_check_admin()): ?>
			<button data-add-to-cart data-codice-prodotto="<?php echo $prodotto["codice"]; ?>">
				Aggiungi al carrello
			</button>
		<?php endif;  ?>
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

	<!-- RECENSIONI -->
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

	<section>
		<h2>
			Scrivi una recensione
		</h2>
		
		<form data-crea-recensione method="POST" action="gestisci-recensione.php?action=1">
			<label for="valutazione">
				Valutazione
			</label>
			<ul>
				<li>
					<button type="button" data-valutazione-star data-value="1">
						<span aria-hidden="true" data-value="1" class="fa-solid fa-star"></span>
					</button>
				</li>
				<li>
					<button type="button" data-valutazione-star data-value="2">
						<span aria-hidden="true" data-value="2" class="fa-regular fa-star"></span>
					</button>
				</li>
				<li>
					<button type="button" data-valutazione-star data-value="3">
						<span aria-hidden="true" data-value="3" class="fa-regular fa-star"></span>
					</button>
				</li>
				<li>
					<button type="button" data-valutazione-star data-value="4">
						<span aria-hidden="true" data-value="4" class="fa-regular fa-star"></span>
					</button>
				</li>
				<li>
					<button type="button" data-valutazione-star data-value="5">
						<span aria-hidden="true" data-value="5" class="fa-regular fa-star"></span>
					</button>
				</li>
			</ul>

			<label for="titolo">
				Titolo
			</label>
			<input name="titolo" type="text" placeholder="Titolo recensione" required />
			
			<label for="descrizione">
				Descrizione
			</label>
			<textarea name="descrizione" placeholder="Descrizione recensione" required></textarea>

			<input type="hidden" name="valutazione" required data-valutazione value="1">
			<input type="hidden" name="codice_prodotto" value=<?php echo $prodotto["codice"]?> >
			<input type="submit" value="Invia">
		</form>
	</section>

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
				<li>
					<img src="<?php echo htmlspecialchars($prodottoCorrelato['immagine'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($prodottoCorrelato["nome"]); ?>">
					<a href="prodotto.php?codice=<?php echo $prodottoCorrelato["codice"]; ?>">
						<?php echo $prodottoCorrelato["nome"]; ?>
					</a>

					<!-- STELLE RECENSIONE -->
					<ul>
						<?php for($i = 0; $i < number_format($prodottoCorrelato["media_recensioni"], 0); $i++): ?>
							<li><span aria-hidden="true" class="fa-solid fa-star"></span></li>
						<?php endfor; ?>
						<?php for($i = number_format($prodottoCorrelato["media_recensioni"], 0); $i < 5; $i++): ?>
							<li><span aria-hidden="true" class="fa-regular fa-star"></span></li>
						<?php endfor; ?>
						<li>
							<p><?php echo $prodottoCorrelato["media_recensioni"] ?? 0; ?>/5</p>
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
