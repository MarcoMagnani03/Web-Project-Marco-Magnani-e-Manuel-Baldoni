<header>
	<nav>
		<a href="index.php" aria-label="Vai alla home">TakeIT</a>
		<ul>
			<li>
				<a href="index.php" aria-label="Vai alla home">
					<em aria-hidden="true" class="fa-solid fa-house"></em>
					<span class="fa-sr-only">Vai alla home</span>
				</a>
			</li>
			<li>
				<button type="button" aria-label="Apri il carrello">
					<em aria-hidden="true" class="fa-solid fa-cart-shopping"></em>
					<span class="fa-sr-only">Apri il carrello</span>
				</button>
			</li>
			<li>
				<button id="btn-mobile-menu-opener" type="button" aria-label="Apri il menu">
					<em aria-hidden="true" class="fa-solid fa-bars"></em>
					<span class="fa-sr-only">Apri il menu</span>
				</button>
			</li>
		</ul>
	</nav>
</header>

<aside id="mobile-menu-aside">
	<nav>
		<button id="btn-mobile-menu-closer" type="button" aria-label="Chiudi il menu">
			<em aria-hidden="true" class="fa-solid fa-xmark"></em>
			<span class="fa-sr-only">Chiudi il menu</span>
		</button>
		<ul>
			<li>
				<a href="/profilo" aria-label="Vai alla home">
					<em aria-hidden="true" class="fa-solid fa-user"></em>
					Area personale
				</a>
			</li>
			<li>
				<a href="/ordini" aria-label="Vai alla home">
					<em aria-hidden="true" class="fa-solid fa-box"></em>
					I miei ordini
				</a>
			</li>
			<li>
				<a href="notifiche.php" aria-label="Vai alla home">
					<em aria-hidden="true" class="fa-regular fa-bell"></em>
					Centro notifiche
				</a>
			</li>
			<li>
				<a href="/ordini" aria-label="Vai alla home">
					<em aria-hidden="true" class="fa-regular fa-star"></em>
					Recensioni
				</a>
			</li>
		</ul>
		<button type="button" class="btn btn-secondary" aria-label="Disconnetti utente">
			<em class="fa-solid fa-right-from-bracket"></em>
			<span class="fa-sr-only">Disconnetti utente</span>
			Disconnetti
		</button>
	</nav>
</aside>
