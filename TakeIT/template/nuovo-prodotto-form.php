<form method="POST" action="nuovo-prodotto.php" enctype="multipart/form-data">
	<?php if(isset($templateParams["errorenuovoprodotto"])): ?>
    	<p><?php echo $templateParams["errorenuovoprodotto"]; ?></p>
    <?php endif; ?>

	<h2>Nuovo prodotto</h2>

	<label for="tipologia">
		Tipo prodotto:
		<select name="tipologia" id="tipologia" required>
			<option value="" disabled selected>Tipo</option>
			<?php foreach($templateParams["tipologie_prodotti"] as $tipologia): ?>
				<option value="<?php echo $tipologia["nome"]; ?>"><?php echo $tipologia["nome"]; ?></option>
			<?php endforeach; ?>
		</select>
	</label>

	<label for="nome">
		Nome
		<input type="text" id="nome" name="nome" required placeholder="inserisci il nome del prodotto"/>
	</label>

	<label for="descrizione">
		Descrizione
		<textarea name="descrizione" id="descrizione" placeholder="inserisci la descrizione" ></textarea>
	</label>

	<label for="prezzo">
		Prezzo
		<input type="number" id="prezzo" step=".01" required name="prezzo" max="999999999" placeholder="10.99"/>
	</label>
	
	<label for="quantita">
		Quantità in deposito
		<input type="number" id="quantita" name="quantita" required placeholder="1"/>
	</label>

	<label for="marche">
		Marche:
		<select id="marche" name="marche">
			<option value="" disabled selected>Marca</option>
			<?php foreach($templateParams["marche"] as $marca): ?>
				<option value="<?php echo $marca["codice"]; ?>"><?php echo $marca["titolo"]; ?></option>
			<?php endforeach; ?>
		</select>
	</label>

	<label for="disponibile">
		Disponibile
		<input type="checkbox" id="disponibile" name="disponibile"/>
	</label>

	<label for="foto">
		Aggiungi le foto
		<input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,.gif" multiple />
	</label>

	<button type="submit">
		<span aria-hidden="true" class="fa-solid fa-circle-plus"></span>
		<span class="fa-sr-only">Crea prodotto</span>
		Crea prodotto
	</button>
	<a href="index.php">
		<span aria-hidden="true" class="fa-solid fa-circle-xmark"></span>
		<span class="fa-sr-only">Annulla</span>
		Annulla
	</a>
</form>