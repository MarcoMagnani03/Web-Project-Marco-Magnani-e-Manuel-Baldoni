<form>
	<?php if(isset($templateParams["errorenuovoprodotto"])): ?>
    	<p><?php echo $templateParams["errorenuovoprodotto"]; ?></p>
    <?php endif; ?>

	<h2>Nuovo prodotto</h2>

	<label>
		Tipo prodotto:
		<select name="tipologia">
			<option value="" disabled selected>Tipo</option>
			<?php foreach($templateParams["tipologie_prodotti"] as $tipologia): ?>
				<option value="<?php echo $tipologia["nome"]; ?>"><?php echo $tipologia["nome"]; ?></option>
			<?php endforeach; ?>
		</select>
	</label>

	<label>
		Nome
		<input type="text" name="nome" required placeholder="inserisci il nome del prodotto"/>
	</label>

	<label>
		Descrizione
		<textarea name="descrizione" placeholder="inserisci la descrizione" /></textarea>
	</label>

	<label>
		Prezzo
		<input type="number" step=".01" name="prezzo" placeholder="10.99"/>
	</label>
	
	<label>
		Quantità in deposito
		<input type="number" name="quantita" placeholder="1"/>
	</label>

	<label>
		Marche:
		<select name="marche">
			<option value="" disabled selected>Marca</option>
			<?php foreach($templateParams["marche"] as $marca): ?>
				<option value="<?php echo $marca["codice"]; ?>"><?php echo $marca["titolo"]; ?></option>
			<?php endforeach; ?>
		</select>
	</label>

	<label>
		Aggiungi le foto
		<input type="file" name="foto" accept=".jpg,.jpeg,.png,.gif" multiple />
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