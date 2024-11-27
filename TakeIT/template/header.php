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
				<button type="button" aria-label="Apri il carrello">
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
				<a href="/profilo" aria-label="Vai alla home">
					<span aria-hidden="true" class="fa-solid fa-user"></span>
					Area personale
				</a>
			</li>
			<li>
				<a href="/ordini" aria-label="Vai alla home">
					<span aria-hidden="true" class="fa-solid fa-box"></span>
					I miei ordini
				</a>
			</li>
			<li>
				<a href="notifiche.php" aria-label="Vai alla home">
					<span aria-hidden="true" class="fa-regular fa-bell"></span>
					Centro notifiche
				</a>
			</li>
			<li>
				<a href="/ordini" aria-label="Vai alla home">
					<span aria-hidden="true" class="fa-regular fa-star"></span>
					Recensioni
				</a>
			</li>
		</ul>
		<button type="button" class="btn btn-secondary" aria-label="Disconnetti utente">
			<span class="fa-solid fa-right-from-bracket"></span>
			<span class="fa-sr-only">Disconnetti utente</span>
			Disconnetti
		</button>
	</nav>
</aside>
