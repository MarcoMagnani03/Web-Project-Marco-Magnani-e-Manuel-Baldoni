<header>
	<h2>
		Riepilogo ordine
	</h2>
</header>
<section aria-labelledby="articoli">
    <h2 id="articoli">Articoli</h2>
    <?php 
    $totaleOrdine = 0;
    foreach($templateParams["prodotti"] as $prodotto): 
    ?> 
        <?php 
        $valutazione_prodotto = $dbh->getValutazioneForProdotto($prodotto["codice"]);
        $numero_recensioni_prodotto = count($dbh->getRecensioniForProdotto($prodotto["codice"])); 
        $prezzoProdotto = floatval($prodotto['prezzo']); 
        $quantitaProdotto = intval($prodotto['quantita']);
        $subTotaleProdotto = $prezzoProdotto * $quantitaProdotto;
        $totaleOrdine += $subTotaleProdotto;
        ?>
        <article>
            <img src="<?php echo htmlspecialchars($prodotto['immagine']); ?>" 
                alt="<?php echo htmlspecialchars($prodotto['nome']); ?>">
            <section>
                <h3><?php echo htmlspecialchars($prodotto['nome']); ?></h3>
                <section aria-labelledby="rating">
                    <h4 id="rating"><?php echo htmlspecialchars($valutazione_prodotto); ?></h4>
                    <ul aria-label="Rating" role="img">
                        <?php for($i = 0; $i < number_format($valutazione_prodotto, 0); $i++): ?>
                            <li><span aria-hidden="true" class="fa-solid fa-star"></span></li>
                        <?php endfor; ?>
                        <?php for($i = number_format($valutazione_prodotto, 0); $i < 5; $i++): ?>
                            <li><span aria-hidden="true" class="fa-regular fa-star"></span></li>
                        <?php endfor; ?>
                    </ul>
                    <p>(<?php echo htmlspecialchars($numero_recensioni_prodotto); ?>)</p>
                </section>
                <p>Quantità: <?php echo $quantitaProdotto; ?></p>
                <p class="card-price">Prezzo unitario: <?php echo number_format($prezzoProdotto, 2, ',', ''); ?> €</p>
                <p>Subtotale: <?php echo number_format($subTotaleProdotto, 2, ',', ''); ?> €</p>
            </section>
        </article>
    <?php endforeach; ?>
    <p aria-labelledby="totale">
        <strong id="totale">Prezzo totale:</strong> <?php echo number_format($totaleOrdine, 2, ',', ''); ?> €
    </p>
</section>


<section>
	<h2>
		Metodo di pagamento
	</h2>
	<form>
		<h3>
			Dettagli carta di credito
		</h3>

		<label for="nome">
			Nome e cognome sulla carta
		</label>
		<input id="nome" name="nome" type="text" placeholder="nome cognome" required/>
		
		<label for="numeroCarta">
			Numero carta
		</label>
		<input id="numeroCarta" name="numeroCarta" type="text" placeholder="0000 0000 0000 0000" pattern="^(?:4[0-9]{12}(?:[0-9]{3})?|[25][1-7][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$" required/>

		<label>
			Data di scadenza
			<ul>
				<li>
					<input id="cardExiprationMonth" name="cardExiprationMonth" type="number" pattern="\d{0,2}" placeholder="01" required/>
				</li>
				<li>
					<input id="cardExiprationYear" name="cardExiprationYear" type="number" pattern="\d{2,4}" placeholder="2024" required/>
				</li>
			</ul>
		</label>

		<label for="cardCvc">
			Codice CVC
		</label>
		<input id="cardCvc" name="cardCvc" type="number" placeholder="123" pattern="^[0-9]{3}$" required />
	</form>
</section>

<section>
	<h2>
		Dettagli spedizione
	</h2>

	
	<section>
		<h3>
			Data di consegna:
		</h3>
		<p>
			<?php echo date('d/m/y', strtotime("now +5 days")); ?>
		</p>
	</section>
	<section>
		<h3>
			Presso:
		</h3>
		<p>
			<span aria-hidden="true" class="fa-solid fa-location-dot"></span>
			<span class="fa-sr-only">spedizione presso: </span>
			Piazza Aldo Moro, 90, 47521 Cesena FC
		</p>
	</section>

	<!--TODO; Riportare alla input, svuotare il carrello e mostrare un notifica-->
	<a href="successo-ordine.php?action=1">
		acquista ora  
	</a>
</section>