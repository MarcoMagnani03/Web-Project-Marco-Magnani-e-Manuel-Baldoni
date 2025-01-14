<header>
	<h2>Lista ordini</h2>

	<form method="GET">
		<label>
			<span aria-hidden="true" class="fa-solid fa-magnifying-glass"></span>
			<span class="fa-sr-only">Cerca per codice</span>
			<input name="q" type="search" placeholder="Cerca per codice" title="cerca" value="<?php echo $_GET["q"] ?? ""; ?>">
		</label>
		<label for="ordine" class="sr-only">Ordina per:</label>
		<select aria-label="Ordina per" id="ordine" name="ordine">
			<option value="" disabled <?php if(!isset($_GET["ordine"])): echo "selected"; endif; ?>>Ordina per:</option>
			<option value="totale_ordine ASC" <?php if(($_GET["ordine"] ?? "") == "totale_ordine ASC"): echo "selected"; endif; ?>>Prezzo crescente</option>
			<option value="totale_ordine DESC" <?php if(($_GET["ordine"] ?? "") == "totale_ordine DESC"): echo "selected"; endif; ?>>Prezzo decrescente</option>
			<option value="dataOraArrivo ASC" <?php if(($_GET["ordine"] ?? "") == "dataOraArrivo ASC"): echo "selected"; endif; ?>>Data di arrivo crescente</option>
			<option value="dataOraArrivo DESC" <?php if(($_GET["ordine"] ?? "") == "dataOraArrivo DESC"): echo "selected"; endif; ?>>Data di arrivo decrescente</option>
			<option value="dataPartenza ASC" <?php if(($_GET["ordine"] ?? "") == "dataPartenza ASC"): echo "selected"; endif; ?>>Data di creazione crescente</option>
			<option value="dataPartenza DESC" <?php if(($_GET["ordine"] ?? "") == "dataPartenza DESC"): echo "selected"; endif; ?>>Data di creazione decrescente</option>
		</select>
		<label>
			<input type="submit" value=""/>
			Cerca
		</label>

		<label>
			<input id="btn-mobile-filters-opener" type="button" title="mobile opener" value="mobile-opener"/>
			<span aria-hidden="true" class="fa-solid fa-filter"></span>
			<span class="fa-sr-only">Filtra ordini</span>
			Filtra ordini
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
				<h3>Stato dell'ordine</h3>

				<label for="stato" class="sr-only">Stato</label>
				<select id="stato" name="stato">
					<option value="" selected>Tutti</option>
					<?php foreach ($templateParams["tipologie_ordini"] as $tipologia):?> 
						<option value="<?php echo htmlspecialchars($tipologia); ?>" 
							<?php echo ($_GET["stato"] ?? "") === $tipologia ? 'selected' : ''; ?>>
							<?php echo htmlspecialchars($tipologia); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</section>

			<section>
				<h3>Data ordine</h3>

				<ul>
					<li>
						<label>
							Minima:
							<input name="data_ordine_min" type="date" title="data ordine minima" value="<?php echo $_GET["data_ordine_min"] ?? ""; ?>"/>
						</label>
					</li>
					<li>
						<label>
							Massima:
							<input name="data_ordine_max" type="date" title="data ordine massima" value="<?php echo $_GET["data_ordine_max"] ?? ""; ?>"/>
						</label>
					</li>
				</ul>
			</section>

			<section>
				<h3>Data arrivo</h3>

				<ul>
					<li>
						<label>
							Minima:
							<input name="data_arrivo_min" type="date" title="data arrivo minima" value="<?php echo $_GET["data_arrivo_min"] ?? ""; ?>"/>
						</label>
					</li>
					<li>
						<label>
							Massima:
							<input name="data_arrivo_max" type="date" title="data arrivo massima" value="<?php echo $_GET["data_arrivo_max"] ?? ""; ?>"/>
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
							<input type="number" min="0" step="0.01" name="prezzo_min" title="prezzo minimo" value="<?php echo $_GET["prezzo_min"] ?? ""; ?>" placeholder="0.00"/>
						</label>
					</li>
					<li>
						<label>
							Massimo:
							<input type="number" max="<?php echo $templateParams["ordini_max_price"]["totale_ordine"]; ?>" step="0.01" name="prezzo_max" title="prezzo massimo" value="<?php echo $_GET["prezzo_max"] ?? ""; ?>" placeholder="<?php echo $templateParams["ordini_max_price"]["totale_ordine"]; ?>"/>
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
	<h2 id="ordini" class="sr-only">Lista Ordini</h2>
	<?php if(count($templateParams["ordini"]) == 0): ?>
		<p>Non ci sono ordini</p>
	<?php endif?>

	<?php foreach ($templateParams["ordini"] as $ordine): ?>
	<?php $codiceOrdine = $ordine['codice'] ?>
	<article>
		<header>
			<h3>Ordine n. <strong>#<?php echo htmlspecialchars($ordine['codice']); ?></strong></h3>
			<?php if($dbh->login_check_admin()):?>
				<label>
					<span>Utente:</span>
					<input type="email" readonly title="mail utente" value="<?php echo htmlspecialchars($ordine['utente'])?>" />
				</label>
			<?php endif?>
			<label>
				<span>Data ordine:</span>
				<input type="date" readonly title="data ordine" value="<?php echo date('Y-m-d', strtotime(htmlspecialchars($ordine['dataPartenza']))); ?>"/>
			</label>
			<?php if($dbh->login_check_admin()): ?>
				<label>
					Data arrivo:
					<input type="datetime-local" id="dataOraArrivo<?php echo htmlspecialchars($ordine['codice']); ?>" name="dataOraArrivo" title="data arrivo" value="<?php echo date('Y-m-d\TH:i', strtotime($ordine['dataOraArrivo'])); ?>">
				</label>
				<label for="statoOrdine<?php echo htmlspecialchars($ordine['codice']); ?>">
					Stato dell'ordine:
					<select name="statoOrdine" title="stato ordine" id="statoOrdine<?php echo htmlspecialchars($ordine['codice']); ?>">
						<?php foreach ($templateParams["tipologie_ordini"] as $tipologia):?> 
							<option value="<?php echo htmlspecialchars($tipologia); ?>" 
								<?php echo $ordine['stato'] === $tipologia ? 'selected' : ''; ?>>
								<?php echo htmlspecialchars($tipologia); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</label>
			<?php else: ?>
				<label>
					Data prevista arrivo:
					<input type="datetime-local" name="dataOraArrivoCliente" id="dataOraArrivoCliente<?php echo htmlspecialchars($ordine['codice']); ?>" readonly title="data prevista arrivo" value="<?php echo date('Y-m-d\TH:i', strtotime($ordine['dataOraArrivo'])); ?>">
				</label>
				<label>
					Stato dell'ordine:
					<input type="text" name="statoOrdineCliente" id="statoOrdineCliente<?php echo htmlspecialchars($ordine['codice']); ?>" readonly title="stato ordine" value="<?php echo htmlspecialchars($ordine['stato']); ?>"/>
				</label>
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
					<img src="<?php echo htmlspecialchars($product["immagine"]);?>"
					alt="<?php echo htmlspecialchars($product["nome"]); ?>">
					<footer>
						<h5><?php echo htmlspecialchars($product["nome"]); ?></h5>
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
			<p><strong>Totale:</strong> <?php echo number_format($ordine["totale_ordine"], 2, ',', ''); ?> €</p>
			
			<?php if($dbh->login_check_admin()): ?>
				<input type="button" name="salva" value="Salva" onclick="salvaOrdine(event)"/>
				<input type="button" name="elimina" value="Elimina" onclick="eliminaOrdine(event, <?php echo $codiceOrdine?>)"/>
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

</section>