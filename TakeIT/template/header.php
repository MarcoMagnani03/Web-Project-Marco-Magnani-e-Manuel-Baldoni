<header>
	<nav>
		<a href="index.php" aria-label="Vai alla home">TakeIT</a>
		<ul>
			<li>
				<a href="profilo.php" aria-label="Vai alla home">
					Area personale
				</a>
			</li>
			<?php if($dbh->login_check_admin()): ?>
				<li>
					<a href="ordiniAmministratore.php" aria-label="Ordini amministratore">
						Ordini
					</a>
				</li>
			<?php else: ?>
			<li>
				<a href="ordiniUtente.php" aria-label="Ordini cliente">
					I miei ordini
				</a>
			</li>
			<?php endif ?>
			<li>
				<a href="notifiche.php" aria-label="Notifiche">
					Centro notifiche
				</a>
			</li>
			<?php if($dbh->login_check_admin()): ?>
				<li>
					<a href="tipologie-prodotto.php" aria-label="Tipologie prodotto">
						Tipologie prodotto
					</a>
				</li>
			<?php endif; ?>
			<?php if($dbh->login_check_admin()): ?>
				<li>
					<a href="marche.php" aria-label="Marche">
						Marche
					</a>
				</li>
			<?php endif; ?>
		</ul>

		<ul>
			<li>
				<a href="index.php" aria-label="Vai alla home">
					<span aria-hidden="true" class="fa-solid fa-house"></span>
					<span class="fa-sr-only">Vai alla home</span>
				</a>
			</li>
			<?php if(!$dbh->login_check_admin() && !($templateParams["nome"] == "checkout.php")): ?>
				<li>
					<button id="btn-mobile-cart-opener" type="button" aria-label="Apri il carrello">
						<span aria-hidden="true" class="fa-solid fa-cart-shopping"></span>
						<span class="fa-sr-only">Apri il carrello</span>
					</button>
				</li>
			<?php endif;  ?>
			<li>
				<button type="button" class="btn btn-secondary" aria-label="Disconnetti utente" onclick="eseguiDisconnessione()">
					<span class="fa-solid fa-right-from-bracket"></span>
					<span class="fa-sr-only">Disconnetti utente</span>
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

<aside id="mobile-menu-aside" data-menu>
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
			<?php if($dbh->login_check_admin()): ?>
				<li>
					<a href="ordiniAmministratore.php" aria-label="Ordini amministratore">
						<span aria-hidden="true" class="fa-solid fa-box"></span>
						Ordini
					</a>
				</li>
			<?php else: ?>
			<li>
				<a href="ordiniUtente.php" aria-label="Ordini cliente">
					<span aria-hidden="true" class="fa-solid fa-box"></span>
					I miei ordini
				</a>
			</li>
			<?php endif ?>
			<li>
				<a href="notifiche.php" aria-label="Notifiche">
					<span aria-hidden="true" class="fa-solid fa-bell"></span>
					Centro notifiche
				</a>
			</li>
			<?php if($dbh->login_check_admin()): ?>
				<li>
					<a href="tipologie-prodotto.php" aria-label="Tipologie prodotto">
						<span aria-hidden="true" class="fa-solid fa-list"></span>
						Tipologie prodotto
					</a>
				</li>
			<?php endif; ?>
			<?php if($dbh->login_check_admin()): ?>
				<li>
					<a href="marche.php" aria-label="Marche">
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

<aside id="mobile-cart" data-cart>
	<nav>
		<header>
			<h2>Riepilogo carrello (0)</h2>
			<button id="btn-mobile-cart-closer" type="button" aria-label="Chiudi il carrello">
				<span aria-hidden="true" class="fa-solid fa-xmark"></span>
				<span class="fa-sr-only">Chiudi il carrello</span>
			</button>
		</header>
		<section>
			<h2 id="carrello">Prodotti carrello</h2> 
		</section>
		<footer>
			<h2>Totale: 0,00€</h2>
			<a href="riepilogo-ordine.php">
				Procedi all'ordine
			</a>
		</footer>
	</nav>
</aside>