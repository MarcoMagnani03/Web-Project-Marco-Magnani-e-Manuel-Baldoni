<?php if(!$templateParams["campi_utente"]): ?>
<article>
	<p>Utente non esistente</p>
</article>
<?php
else:
	$utente = $templateParams["campi_utente"];
?>
<article>
	<h1>
		Informazioni utente
	</h1>

	<section>
		<ul>
			<li>
				<h2>Nome: </h2>
				<input type="text" value="<?php echo $utente["nome"]; ?>" readonly aria-readonly="true">
			</li>
			<li>
				<h2>Cognome: </h2>
				<input type="text" value="<?php echo $utente["cognome"]; ?>" readonly aria-readonly="true">
			</li>
			<li>
				<h2>Data di nascita: </h2>
				<input type="text" value="<?php echo $utente["dataDiNascita"]; ?>" readonly aria-readonly="true">
			</li>
			<li>
				<h2>Cellulare: </h2>
				<input type="tel" value="<?php echo $utente["cellulare"]; ?>" readonly aria-readonly="true">
			</li>
			<li>
				<h2>Email: </h2>
				<input type="mail" value="<?php echo $utente["email"]; ?>" readonly aria-readonly="true">
			</li>
			<li>
				<h2>Password: </h2>
				<input type="password" value="<?php echo $utente["password"]; ?>" readonly aria-readonly="true">
			</li>
		</ul>
	</section>

	<button>
		Modifica informazioni utente
	</button>
</article>
<?php endif; ?>