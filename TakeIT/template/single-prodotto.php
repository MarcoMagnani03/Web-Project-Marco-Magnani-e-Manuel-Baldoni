<?php if(count($templateParams["prodotto"])==0): ?>
<article>
	<p>Prodotto non presente</p>
</article>
<?php
else:
	$prodotto = $templateParams["prodotto"][0];
?>
<article>
	<section>
		<h1>
			<?php echo $prodotto["nome"]; ?>
		</h1>

		<section>
			<h6>4.6</h6>
			<ul>
				<li><em aria-hidden="true" class="fa-solid fa-star"></em></li>
				<li><em aria-hidden="true" class="fa-solid fa-star"></em></li>
				<li><em aria-hidden="true" class="fa-solid fa-star"></em></li>
				<li><em aria-hidden="true" class="fa-solid fa-star"></em></li>
				<li><em aria-hidden="true" class="fa-regular fa-star"></em></li>
			</ul>
			<h6>(550)</h6>
			<a href="#recensioni">vedi recensioni</a>
		</section>

		<section>
			<p>
				<img width="150" height="150" src="https://m.media-amazon.com/images/I/714J6o2Ug7L._AC_SL1500_.jpg" alt="<?php echo $prodotto["nome"]; ?>">
				
				<h2>
					<?php echo $prodotto["prezzo"]; ?>€
				</h2>
			</p>
			<p>
				<?php echo $prodotto["descrizione"]; ?>
			</p>
		</section>

		<button class="btn btn-primary">
			Aggiungi al carrello
		</button>
	</section>
	<?php if(count($templateParams["specifiche_prodotto"])==0): ?>
	<section>
		<p>Specifiche prodotto non presenti</p>
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

	<section>
		<h2>Recensioni</h2>

		<!-- FILTRI RECENSIONI -->

		<ul>
			<?php foreach(array_splice($templateParams["recensioni_prodotto"], 0, 5) as $recensione): ?>
				<li>
					<!-- STELLE RECENSIONE -->
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
</article>
<?php endif; ?>
