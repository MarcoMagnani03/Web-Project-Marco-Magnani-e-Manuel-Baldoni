<section>
	<header>
		<h2>Marche</h2>
	</header>

	<form>
		<button type="button">
			<span aria-hidden="true" class="fa-solid fa-circle-plus"></span>
			<span class="fa-sr-only">Crea una nuova marca</span>
			Crea una nuova marca
		</button>
		
		<input type="search" placeholder="Cerca per nome"/>
		<button type="submit">
			<span aria-hidden="true" class="fa-solid fa-magnifying-glass"></span>
			<span class="fa-sr-only">Carca</span>
			Cerca
		</button>
	</form>

	<?php if(count($templateParams["marche"]) == 0): ?>
        <p>Non ci sono marche</p>
    <?php else:
        $marche = $templateParams["marche"]; 
	?>
	<ul>
		<?php foreach($marche as $marca): ?>
			<li>
				<h3>
					<?php echo $marca["titolo"] ?>
				</h3>
				<button>
					<span aria-hidden="true" class="fa-solid fa-edit"></span>
					<span class="fa-sr-only">Modifica marca</span>
				</button>
				<button>
					<span aria-hidden="true" class="fa-solid fa-trash"></span>
					<span class="fa-sr-only">Elimina marca</span>
				</button>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
</section>