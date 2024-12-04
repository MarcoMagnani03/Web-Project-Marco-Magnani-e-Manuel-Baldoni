<header>
    <h2>Lista ordini</h2>

    <!-- Barra di ricerca e filtri -->
    <nav aria-label="Barra di ricerca e filtri">
        <form action="cerca.php" method="GET">
            <label for="search-orders">
                <span aria-hidden="true" class="fa-solid fa-magnifying-glass"></span>
                <span class="sr-only">Cerca per numero ordine</span>
            </label>
            <input id="search-orders" name="cerca" type="search" placeholder="Cerca per numero ordine" aria-label="Cerca per numero ordine">
            <button type="submit">Cerca</button>
        </form>

        <button id="btn-mobile-filters-opener" aria-controls="mobile-filters" aria-expanded="false">
            <span aria-hidden="true" class="fa-solid fa-filter"></span>
            <span class="sr-only">Filtra prodotti</span>
        </button>
    </nav>

    <!-- Sezione filtri -->
    <aside id="mobile-filters" hidden>
        <form>
            <button id="btn-mobile-filters-closer" type="button" aria-label="Chiudi i filtri">
                <span aria-hidden="true" class="fa-solid fa-xmark"></span>
                <span class="sr-only">Chiudi i filtri</span>
            </button>

            <section>
                <h3>Tipologia</h3>
                <ul>
                    <!-- Opzioni dei filtri -->
                </ul>
            </section>

            <section>
                <button id="btn-mobile-filters-applier" type="submit">
                    Applica filtri
                </button>
            </section>
        </form>
    </aside>
</header>

<main>
    <section>
        <?php foreach ($templateParams["ordini"] as $ordine): 
            $total =100 ?>
        <article>
            <!-- Informazioni ordine -->
            <header>
                <h3>Ordine n. <strong>#<?php echo htmlspecialchars($ordine['codice_ordine']); ?></strong></h3>
                <p>Data ordine: <time datetime="<?php echo date('Y-m-d', strtotime($ordine['dataPartenza'])); ?>">
                    <?php echo htmlspecialchars($ordine['dataPartenza']); ?>
                </time></p>
                <p>Data prevista arrivo: <time datetime="<?php echo date('Y-m-d', strtotime($ordine['dataOraArrivo'])); ?>">
                    <?php echo htmlspecialchars($ordine['dataOraArrivo']); ?>
                </time></p>
                <p>Stato dell'ordine: <strong><?php echo htmlspecialchars($ordine['stato']); ?></strong></p>
            </header>

            <!-- Lista prodotti -->
            <section>
                <h4>Prodotti acquistati:</h4>
                <ul>
                    <?php foreach ($ordine['prodotti'] as $product): ?>
                    <?php $valutazione_prodotto = $dbh->getValutazioneForProdotto($product["codice"]); ?>
		            <?php $numero_recensioni_prodotto = count($dbh->getRecensioniForProdotto($product["codice"])); ?>
                    <li>
                        <figure>
                            <img width="150" height="150" src="https://m.media-amazon.com/images/I/714J6o2Ug7L._AC_SL1500_.jpg" alt="<?php echo htmlspecialchars($product["nome"]); ?>">
                            <figcaption>
                                <h5><?php echo htmlspecialchars($product["nome"]); ?></h5>
                            </figcaption>
                        </figure>
                        <footer>
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
                                <p><?php echo $numero_recensioni_prodotto; ?></p>
                            </section>

                            <p><strong>Prezzo:</strong> <?php echo number_format($product["prezzo"], 2, ',', ''); ?>€</p>

                            <button type="button">Acquista di nuovo</button>
                        </footer>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <!-- Totale e pulsante -->
            <footer>
                <p><strong>Totale:</strong> <?php echo number_format($total, 2, ',', ''); ?> €</p>
                <button type="button">Acquista di nuovo</button>
            </footer>
        </article>
        <?php endforeach; ?>
    </section>
</main>
