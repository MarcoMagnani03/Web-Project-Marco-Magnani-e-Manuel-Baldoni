<header>
	<h2>Tipologie prodotto</h2>

	<a href="gestisci-tipologia.php?action=1">
		<span aria-hidden="true" class="fa-solid fa-circle-plus"></span>
		<span class="fa-sr-only">Crea una nuova tipologia</span>
		Crea una nuova tipologia
	</a>

	<form method="GET">
		<label>
			<span aria-hidden="true" class="fa-solid fa-magnifying-glass"></span>
			<span class="fa-sr-only">Cerca per codice o nome</span>
			<input name="q" type="search" placeholder="Cerca per codice o nome" value="<?php echo $_GET["q"] ?? ""; ?>">
		</label>
		<label>
			<input type="submit" value=""/>
			Cerca
		</label>
	</form>
</header>

<section>
	<h3 class="sr-only">Lista tipologie</h3>
	<?php if(count($templateParams["tipologie_prodotto"]) == 0): ?>
		<p>Non ci sono tipologie di prodotto</p>
	<?php else: 
		$tipologie_prodotto = $templateParams["tipologie_prodotto"]; 
	?>
		<?php foreach($tipologie_prodotto as $tipologia_prodotto): ?>
			<article>
				<header>
					<h2><?php echo htmlspecialchars($tipologia_prodotto["nome"]); ?></h2>
				</header>
				
				<section>
					<h3>Descrizione:</h3>
					<p class="descrizione"><?php echo htmlspecialchars($tipologia_prodotto["descrizione"]); ?></p>
				</section>
				
				<section>
					<h3>Caratteristiche:</h3>
					<ul class="caratteristiche">
						<?php foreach($tipologia_prodotto["caratteristiche"] as $caratteristica): ?>
							<li>
								<span><?php echo htmlspecialchars($caratteristica["nome"]); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>
				
				<footer>
					<a href="gestisci-tipologia.php?action=2&nome=<?php echo $tipologia_prodotto["nome"]; ?>">Modifica</a>
					<a href="gestisci-tipologia.php?action=3&nome=<?php echo $tipologia_prodotto["nome"]; ?>">Elimina</a>
				</footer>
			</article>
		<?php endforeach; ?>
	<?php endif; ?>
</section>