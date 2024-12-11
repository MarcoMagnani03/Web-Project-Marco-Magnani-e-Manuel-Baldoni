<header>
	<nav>
		<a href="index.php" aria-label="Vai alla home">TakeIT</a>
		<ul>
			<li>
				<a href="index.php" aria-label="Vai alla home">
					<span aria-hidden="true" class="fa-solid fa-house"></span>
					<span class="fa-sr-only">Vai alla home</span>
				</a>
			</li>
			<li>
				<button id="btn-mobile-cart-opener" type="button" aria-label="Apri il carrello">
					<span aria-hidden="true" class="fa-solid fa-cart-shopping"></span>
					<span class="fa-sr-only">Apri il carrello</span>
				</button>
			</li>
			<li>
				<button id="btn-mobile-menu-opener" type="button" aria-label="Apri il menu">
					<span aria-hidden="true" class="fa-solid fa-bars"></span>
					<span class="fa-sr-only">Apri il menu</span>
				</button>
			</li>
		</ul>
	</nav>
</header>

<aside id="mobile-menu-aside">
	<nav>
		<button id="btn-mobile-menu-closer" type="button" aria-label="Chiudi il menu">
			<span aria-hidden="true" class="fa-solid fa-xmark"></span>
			<span class="fa-sr-only">Chiudi il menu</span>
		</button>
		<ul>
			<li>
				<a href="profilo.php" aria-label="Vai alla home">
					<span aria-hidden="true" class="fa-solid fa-user"></span>
					Area personale
				</a>
			</li>
			<li>
				<a href="ordiniUtente.php" aria-label="Vai alla home">
					<span aria-hidden="true" class="fa-solid fa-box"></span>
					I miei ordini
				</a>
			</li>
			<li>
				<a href="notifiche.php" aria-label="Vai alla home">
					<span aria-hidden="true" class="fa-solid fa-bell"></span>
					Centro notifiche
				</a>
			</li>
			<?php if($dbh->login_check_admin()): ?>
				<li>
					<a href="tipologie-prodotto.php" aria-label="Vai alla home">
						<span aria-hidden="true" class="fa-solid fa-list"></span>
						Tipologie prodotto
					</a>
				</li>
			<?php endif; ?>
			<?php if($dbh->login_check_admin()): ?>
				<li>
					<a href="marche.php" aria-label="Vai alla home">
						<span aria-hidden="true" class="fa-solid fa-layer-group"></span>
						Marche
					</a>
				</li>
			<?php endif; ?>
		</ul>
		<button type="button" class="btn btn-secondary" aria-label="Disconnetti utente" onclick="eseguiDisconnessione()">
			<span class="fa-solid fa-right-from-bracket"></span>
			<span class="fa-sr-only">Disconnetti utente</span>
			Disconnetti
		</button>
	</nav>
</aside>

<aside id="mobile-cart">
	<nav>
		<header>
			<h2>Riepilogo carrello</h2><span>(6)</span>
			<button id="btn-mobile-cart-closer" type="button" aria-label="Chiudi il menu">
				<span aria-hidden="true" class="fa-solid fa-xmark"></span>
				<span class="fa-sr-only">Chiudi il menu</span>
			</button>
		</header>
		<section>
			<h2 id="carrello" class="sr-only">Prodotti carrello</h2> 
			<ul>
				<?php for($i = 0; $i < 10; $i++): ?>
					<li>
						<header>
							<img width="100" height="100" src="https://m.media-amazon.com/images/I/714J6o2Ug7L._AC_SL1500_.jpg" alt="Laptop lenovo 14 pollici"/>
						</header>
						<section>
							<h3>
								Laptop lenovo 14 pollici
							</h3>
							<h3>
								299,99€
							</h3>
						</section>
						<footer>
							<ul>
								<li>
									<button>
										<span aria-hidden="true" class="fa-solid fa-minus"></span>
										<span class="fa-sr-only">Aumenta la quantità del prodotto nel carrello</span>
									</button>
								</li>
								<li>
									<label><span class="fa-sr-only">Quantità del prodotto nel carrello</span><input type="number" value="1" aria-label="Quantità del prodotto nel carrello"/></label>
								</li>
								<li>
									<button>
										<span aria-hidden="true" class="fa-solid fa-plus"></span>
										<span class="fa-sr-only">Aumenta la quantità del prodotto nel carrello</span>
									</button>
								</li>
							</ul>

							<button>
								<span aria-hidden="true" class="fa-solid fa-trash"></span>
								<span class="fa-sr-only">Elimina prodotto dal carrello</span>
							</button>
						</footer>
					</li>
				<?php endfor; ?>
			</ul>
		</section>
		<footer>
			<h2><span>totale:</span><span>299,99€</span></h2>
			<a href="riepilogo-ordine.php">
				Procedi all'ordine
			</a>
		</footer>
	</nav>
</aside>
