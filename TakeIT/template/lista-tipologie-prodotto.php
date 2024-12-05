<section>
	<header>
		<h2>Tipologie prodotto</h2>
	</header>

	<form>
		<button type="button">
			<span aria-hidden="true" class="fa-solid fa-circle-plus"></span>
			<span class="fa-sr-only">Crea una nuova tipologia di prodotto</span>
			Crea una nuova tipologia di prodotto
		</button>
		
		<input type="search" placeholder="Cerca per nome"/>
		<button type="submit">
			<span aria-hidden="true" class="fa-solid fa-magnifying-glass"></span>
			<span class="fa-sr-only">Carca</span>
			Cerca
		</button>
	</form>

	<?php if(count($templateParams["tipologie_prodotto"]) == 0): ?>
        <p>Non ci sono tipologie di prodotto</p>
    <?php else:
        $tipologie_prodotto = $templateParams["tipologie_prodotto"]; 
	?>
	<ul>
		<?php foreach($tipologie_prodotto as $tipologia_prodotto): ?>
			<li>
				<section>
					<h3>
						Titolo:
					</h3>
					<p>
						<?php echo $tipologia_prodotto["nome"]; ?>
					</p>
				</section>

				<section>
					<h3>
						Descrizione:
					</h3>
					<p>
						<?php echo $tipologia_prodotto["descrizione"]; ?>
					</p>
				</section>

				<section>
					<h3>
						Caratteristiche:
					</h3>

					<ul>
						<?php foreach($tipologia_prodotto["caratteristiche"] as $caratteristica): ?>
							<li>
								<?php echo $caratteristica["nome"]; ?>
							</li>
						<?php endforeach; ?>
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
	<?php endif; ?>
</section>