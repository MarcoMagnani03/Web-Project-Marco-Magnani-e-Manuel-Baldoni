document.addEventListener("DOMContentLoaded", function () {
	const mobileFilters = document.getElementById("mobile-filters");
	const mobileFiltersOpener = document.getElementById(
		"btn-mobile-filters-opener",
	);
	const mobileFiltersCloser = document.getElementById(
		"btn-mobile-filters-closer",
	);

	mobileFiltersOpener?.addEventListener("click", function () {
		mobileFilters?.classList.add("open");
	});

	mobileFiltersCloser?.addEventListener("click", function () {
		mobileFilters?.classList.remove("open");
	});

	const menuAside = document.querySelector("[data-menu]");
	const menuOpener = document.querySelector(
		"header > nav > ul > li > button[aria-label='Apri il menu']",
	);
	const menuCloser = document.querySelector(
		"[data-menu] > nav > button[aria-label='Chiudi il menu']",
	);

	menuOpener?.addEventListener("click", function () {
		menuAside?.classList.add("open");
	});

	menuCloser?.addEventListener("click", function () {
		menuAside?.classList.remove("open");
	});

	const cart = document.querySelector("[data-cart]");
	const proceedOrder = document.querySelector(
		"[data-cart] > nav > footer > a",
	);

	let cartProducts = [];
	let deleteProducts = [];

	// Definizione della funzione loadCartProducts
	const loadCartProducts = async () => {
		try {
			const response = await fetch("carrello.php", {
				method: "GET",
				headers: {
					"Content-Type": "application/json",
				},
			});

			if (!response.ok) {
				throw new Error("Errore durante il caricamento del carrello.");
			}

			cartProducts = await response.json(); // Salva i prodotti nel carrello a livello locale

			const cartContentSection = document.querySelector(
				"[data-cart] section",
			);
			const cartSummaryHeader = document.querySelector(
				"[data-cart] header h2",
			);
			const cartTotalFooter = document.querySelector(
				"[data-cart] footer h2",
			);

			cartContentSection.innerHTML = "<h2 class='sr-only'>Prodotti carrello</h2>";

			if (cartProducts.length === 0) {
				cartContentSection.innerHTML += "<h2>Il carrello è vuoto.</h2>";
				cartSummaryHeader.textContent = "Riepilogo carrello (0)";
				cartTotalFooter.textContent = "Totale: 0,00€";
				return;
			}

			let totalItems = 0;
			let totalPrice = 0;

			const updateCartSummary = () => {
				totalItems = cartProducts.reduce(
					(sum, p) => sum + parseInt(p.quantita, 10),
					0,
				);
				totalPrice = cartProducts.reduce(
					(sum, p) => sum + p.prezzo * p.quantita,
					0,
				);
				cartSummaryHeader.textContent = `Riepilogo carrello (${totalItems})`;
				cartTotalFooter.textContent = `Totale: ${totalPrice.toFixed(
					2,
				)}€`;
			};

			cartProducts.forEach((product) => {
				const productElement = document.createElement("article");
				productElement.classList.add("cart-item");

				productElement.innerHTML = `
					<h3 class="sr-only">Informazioni prodotto</h3>
                    <header>
                        <img src="${product.immagine}" alt="${product.nome}" />
                    </header>
                    <section>
                        <h3>${product.nome}</h3>
                        <p>${product.prezzo}€</p>
                    </section>
                    <footer>
                        <ul>
                            <li>
                                <button aria-label="Riduci quantità" data-action="decrease" data-id="${product.codice}">
                                    <span aria-hidden="true" class="fa-solid fa-minus"></span>
                                </button>
                            </li>
                            <li>
                                <label>
                                    <span class="fa-sr-only">Quantità</span>
                                    <input type="number" value="${product.quantita}" title="quantità" aria-label="Quantità" data-id="${product.codice}" />
                                </label>
                            </li>
                            <li>
                                <button aria-label="Aumenta quantità" data-action="increase" data-id="${product.codice}">
                                    <span aria-hidden="true" class="fa-solid fa-plus"></span>
                                </button>
                            </li>
                        </ul>
                        <button aria-label="Rimuovi prodotto" data-action="remove" data-id="${product.codice}">
                            <span aria-hidden="true" class="fa-solid fa-trash"></span>
                        </button>
                    </footer>
                `;

				productElement
					.querySelector('button[data-action="remove"]')
					.addEventListener("click", () => {
						if (
							confirm(
								"Sei sicuro di voler eliminare questo prodotto dal carrello?",
							)
						) {
							deleteProducts = cartProducts.filter(
								(p) => p.codice === product.codice,
							);
							cartProducts = cartProducts.filter(
								(p) => p.codice !== product.codice,
							);
							productElement.remove();
							updateCartSummary();
						}
					});

				productElement
					.querySelector('button[data-action="increase"]')
					.addEventListener("click", () => {
						product.quantita++;
						productElement.querySelector(
							'input[type="number"]',
						).value = product.quantita;
						updateCartSummary();
					});

				productElement
					.querySelector('button[data-action="decrease"]')
					.addEventListener("click", () => {
						if (product.quantita > 1) {
							product.quantita--;
							productElement.querySelector(
								'input[type="number"]',
							).value = product.quantita;
							updateCartSummary();
						} else {
							if (
								confirm(
									"Sei sicuro di voler eliminare questo prodotto dal carrello?",
								)
							) {
								deleteProducts = cartProducts.filter(
									(p) => p.codice === product.codice,
								);
								cartProducts = cartProducts.filter(
									(p) => p.codice !== product.codice,
								);
								productElement.remove();
								updateCartSummary();
							}
						}
					});

				cartContentSection.appendChild(productElement);
			});

			updateCartSummary();
		} catch (error) {
			console.error(error);
			const cartContentSection = document.querySelector(
				"#mobile-cart section",
			);
			cartContentSection.innerHTML =
				"<p>Errore nel caricamento del carrello.</p>";
		}
	};

	window.addEventListener("beforeunload", () => {
		aggiornaCartDatabase();
		aggiornaProdottiAmministratoreDatabase();
	});

	const aggiornaCartDatabase = async () => {
		try {
			const formData = new FormData();
			formData.append("action", 3);

			deleteProducts.forEach((product, index) => {
				formData.append(
					`prodotti[${index}][codiceProdotto]`,
					product.codice,
				);
				formData.append(
					`prodotti[${index}][quantita]`,
					product.quantita,
				);
			});

			const responseDelete = await fetch("carrello.php", {
				method: "POST",
				body: formData,
			});

			if (!responseDelete.ok) {
				throw new Error("Errore durante l'eliminazione nel carrello.");
			}

			const updateFormData = new FormData();
			updateFormData.append("action", 2);

			cartProducts.forEach((product, index) => {
				updateFormData.append(
					`products[${index}][codiceProdotto]`,
					product.codice,
				);
				updateFormData.append(
					`products[${index}][quantita]`,
					product.quantita,
				);
			});

			const responseUpdate = await fetch("carrello.php", {
				method: "POST",
				body: updateFormData,
			});

			if (!responseUpdate.ok) {
				throw new Error("Errore durante l'inserimento nel carrello.");
			}
		} catch (error) {
			if (error.message.includes("eliminazione")) {
				console.error(
					"Errore durante l'eliminazione dei prodotti:",
					error,
				);
			} else if (error.message.includes("inserimento")) {
				console.error(
					"Errore durante l'aggiornamento del carrello:",
					error,
				);
			}
		}
	};

	const aggiornaProdottiAmministratoreDatabase = async () => {
		try {
			const updateFormData = new FormData();
			updateFormData.append("action", 2);

			modifiedProducts.forEach((product, index) => {
				updateFormData.append(
					`products[${index}][codiceProdotto]`,
					product.codice,
				);
				updateFormData.append(
					`products[${index}][quantita]`,
					product.quantita,
				);
			});

			const responseUpdate = await fetch("gestisci-prodotto.php", {
				method: "POST",
				body: updateFormData,
			});

			if (!responseUpdate.ok) {
				throw new Error("Errore durante l'inserimento nel carrello.");
			}
		} catch (error) {
			if (error.message.includes("eliminazione")) {
				console.error(
					"Errore durante l'eliminazione dei prodotti:",
					error,
				);
			} else if (error.message.includes("inserimento")) {
				console.error(
					"Errore durante l'aggiornamento del carrello:",
					error,
				);
			}
		}
	};

	const modifiedProducts = [];

	const addQuantityButtons =
		document.querySelectorAll("[data-aggiungi-quantita]") ?? [];
	const decreaseQuantityButtons =
		document.querySelectorAll("[data-diminuisci-quantita]") ?? [];
	const quantityInputs = document.querySelectorAll(
		"[data-quantita-prodotto]",
	);
	addQuantityButtons.forEach((quantityButton) => {
		quantityButton.addEventListener("click", () => {
			const codiceProdotto = quantityButton.getAttribute(
				"data-codice-prodotto",
			);

			quantityInputs.forEach((quantityInput) => {
				if (
					quantityInput.getAttribute("data-codice-prodotto") ===
					codiceProdotto
				) {
					const oldQuantity = parseInt(quantityInput.value);
					quantityInput.value = oldQuantity + 1;

					if (
						modifiedProducts.some(
							(product) => product.codice === codiceProdotto,
						)
					) {
						modifiedProducts.find(
							(product) => product.codice === codiceProdotto,
						).quantita = oldQuantity + 1;
					} else {
						modifiedProducts.push({
							codice: codiceProdotto,
							quantita: oldQuantity + 1,
						});
					}
					pushNotifica("success", "Quantità del prodotto aggiornata");
				}
			});
		});
	});

	decreaseQuantityButtons.forEach((quantityButton) => {
		quantityButton.addEventListener("click", () => {
			const codiceProdotto = quantityButton.getAttribute(
				"data-codice-prodotto",
			);

			quantityInputs.forEach((quantityInput) => {
				if (
					quantityInput.getAttribute("data-codice-prodotto") ===
					codiceProdotto
				) {
					const oldQuantity = parseInt(quantityInput.value);
					if (oldQuantity > 1) {
						quantityInput.value = oldQuantity - 1;
						if (
							modifiedProducts.some(
								(product) => product.codice === codiceProdotto,
							)
						) {
							modifiedProducts.find(
								(product) => product.codice === codiceProdotto,
							).quantita = oldQuantity - 1;
						} else {
							modifiedProducts.push({
								codice: codiceProdotto,
								quantita: oldQuantity - 1,
							});
						}
						pushNotifica(
							"success",
							"Quantità del prodotto aggiornata",
						);
					}
				}
			});
		});
	});

	const cartOpener =
		document.querySelector(
			"header > nav > ul > li:nth-child(2) > button[aria-label='Apri il carrello']",
		) ?? null;
	cartOpener?.addEventListener("click", function () {
		cart?.classList.add("open");
		loadCartProducts();
	});
	const cartCloser = document.querySelector(
		"[data-cart] > nav > header > button[aria-label='Chiudi il carrello']",
	);
	cartCloser?.addEventListener("click", async () => {
		await aggiornaCartDatabase();
		cart?.classList.remove("open");
	});

	proceedOrder?.addEventListener("click", async (event) => {
		event.preventDefault();

		try {
			await aggiornaCartDatabase();
			window.location.href = proceedOrder.getAttribute("href");
		} catch (error) {
			console.error(
				"Errore durante l'aggiornamento del carrello:",
				error,
			);
			alert("Non è stato possibile procedere. Riprova più tardi.");
		}
	});

	const cartButtons = document.querySelectorAll("[data-add-to-cart]");
	cartButtons.forEach((button) => {
		button.addEventListener("click", (event) => {
			event.preventDefault();

			const codiceProdotto = button.getAttribute("data-codice-prodotto");
			const formData = new FormData();

			formData.append("action", "1");
			formData.append("codice", codiceProdotto);
			fetch("carrello.php", {
				method: "POST",
				body: formData,
			})
				.then((response) => response.json())
				.then((data) => {
					if (data.success) {
						pushNotifica(
							"success",
							"Prodotto aggiunto al carrello",
						);
					} else {
						alert("Errore: " + data.message);
					}
				})
				.catch((error) => {
					console.error("Errore:", error);
					alert(
						"Si è verificato un errore durante l'aggiunta al carrello.",
					);
				});
		});
	});

	const queryParams = new URLSearchParams(window.location.search);

	const notificaType = queryParams.get("notifica_type");
	const notificaMessage = queryParams.get("notifica_message");

	if (notificaType && notificaMessage) {
		pushNotifica(notificaType, decodeURIComponent(notificaMessage));
		const newUrl = window.location.origin + window.location.pathname;
		window.history.replaceState({}, document.title, newUrl);
	}

	const buttonsValutazione = document.querySelectorAll(
		"[data-valutazione-star]",
	);
	const buttonsValutazioneStar = document.querySelectorAll(
		"[data-valutazione-star] > span",
	);
	const inputValutazione = document.querySelectorAll("[data-valutazione]")[0];

	buttonsValutazione.forEach((buttonValutazione) => {
		buttonValutazione.addEventListener("click", () => {
			inputValutazione.value =
				buttonValutazione.getAttribute("data-value");
			buttonsValutazioneStar.forEach((star) => {
				if (star.getAttribute("data-value") <= inputValutazione.value) {
					star.classList.remove("fa-regular");
					star.classList.add("fa-solid");
				} else {
					star.classList.remove("fa-solid");
					star.classList.add("fa-regular");
				}
			});
		});
	});

	let recensioniFilterSingle = [];

	const inputRecensioniFilter =
		document.querySelectorAll("[data-filter-recensioni-single]") ?? [];

	inputRecensioniFilter.forEach((input) => {
		input.addEventListener("change", () => {
			if (input.checked) {
				recensioniFilterSingle.push(input.value);
			} else {
				recensioniFilterSingle = recensioniFilterSingle.filter(
					(value) => value != input.value,
				);
			}
			filterRecensioniSingle(
				recensioniFilterSingle?.length <= 0
					? ["1", "2", "3", "4", "5"]
					: recensioniFilterSingle,
			);
		});
	});

	const carouselPreviousButton =
		document.querySelectorAll("[data-previous-carousel]")[0] ?? null;
	const carouselNextButton =
		document.querySelectorAll("[data-next-carousel]")[0] ?? null;
	const carouselSingleProduct =
		document.querySelectorAll("[data-carousel]") ?? [];
	let currentSlide = 0;

	carouselPreviousButton?.addEventListener("click", () => {
		currentSlide--;
		updateCarouselImages();
	});
	carouselNextButton?.addEventListener("click", () => {
		currentSlide++;
		updateCarouselImages();
	});

	function updateCarouselImages() {
		let found = false;
		carouselSingleProduct.forEach((img) => {
			img.style.zIndex = 0;

			if (img.getAttribute("data-index") == currentSlide) {
				found = true;
				img.style.zIndex = 1;
			}
		});

		if (!found) {
			currentSlide = 0;
			updateCarouselImages();
		}

		const carouselCounter =
			document.querySelectorAll("[data-carousel-current-slide]")[0] ?? [];
		carouselCounter.innerHTML = `${currentSlide + 1}`;
	}
});

function pushNotifica(type, text) {
	const notifichePushContainer = document.querySelectorAll(
		"[data-notifica-container]",
	)[0];

	const notifica = document.createElement("button");
	notifica.setAttribute("data-type", type);
	notifica.innerHTML = `
		${
			type === "success"
				? '<span aria-hidden="true" class="fa-solid fa-check"></span>'
				: ""
		}
		${
			type === "error"
				? '<span aria-hidden="true" class="fa-solid fa-x"></span>'
				: ""
		}
		<span class="fa-sr-only">Notifica: ${text}</span>
		${text}
	`;

	notifichePushContainer.innerHTML = "<h2 class='sr-only'>Notifica</h2>";
	notifichePushContainer.appendChild(notifica);

	setInterval(() => {
		notifica.remove();
	}, 5000);
}

function filterRecensioniSingle(filter) {
	const recensioni = document.querySelectorAll("[data-recensione]") ?? [];

	recensioni.forEach((recensione) => {
		if (filter.some((f) => f === recensione.getAttribute("data-value"))) {
			recensione.style.display = "block";
		} else {
			recensione.style.display = "none";
		}
	});
}

function eseguiDisconnessione() {
	window.location.href = "disconnetti.php";
}

function formhash(form, password) {
	// Crea un elemento di input che verrà usato come campo di output per la password criptata.
	let p = document.createElement("input");
	// Aggiungi un nuovo elemento al tuo form.
	form.appendChild(p);
	p.name = "p";
	p.type = "hidden";
	p.value = CryptoJS.SHA512(password.value).toString(CryptoJS.enc.Hex);

	// Assicurati che la password non venga inviata in chiaro.
	password.value = "";
	// Come ultimo passaggio, esegui il 'submit' del form.
	form.submit();
}

/* PARTE LISTA ORDINI AMMINISTRATORE */
function salvaOrdine(event) {
	event.preventDefault();

	const ordineElement = event.target.closest("article");

	const utente = ordineElement.querySelector(
		'input[type="email"]',
	)?.value || "";

	const codiceOrdine = ordineElement
		.querySelector("header h3 strong")
		.textContent.replace("#", "")
		.trim();
	const dataOraArrivo = ordineElement.querySelector(
		'input[name="dataOraArrivo"]',
	).value;
	const statoOrdine = ordineElement.querySelector(
		'select[name="statoOrdine"]',
	).value;

	// Verifica che i dati non siano vuoti
	if (!codiceOrdine || !dataOraArrivo || !statoOrdine) {
		pushNotifica("Tutti i campi sono obbligatori!", "error");
		return;
	}

	// Crea un oggetto FormData per inviare i dati
	const formData = new FormData();
	formData.append("salvaOrdine", true);
	formData.append("codiceOrdine", codiceOrdine);
	formData.append("dataOraArrivo", dataOraArrivo);
	formData.append("statoOrdine", statoOrdine);
	formData.append("utenteOrdine", utente)

	// Invia i dati al server tramite AJAX
	fetch("ordiniAmministratore.php", {
		method: "POST",
		body: formData,
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error("Errore nella risposta del server.");
			}
			return response.text();
		})
		.then((data) => {
			pushNotifica("success", "Ordine aggiornato con successo");
		})
		.catch((error) => {
			pushNotifica("error", "Ordine aggiornato con successo");
		});
}

function eliminaOrdine(event, codiceOrdine) {
	event.preventDefault();

	const formData = new FormData();
	formData.append("action", 1);
	formData.append("codiceOrdine", codiceOrdine);

	fetch("ordiniAmministratore.php", {
		method: "POST",
		body: formData,
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error("Errore nella risposta del server.");
			}
			return response.text();
		})
		.then((data) => {
			pushNotifica("success", "Ordine eliminato con successo");

			const ordineElement = event.target.closest("article");
			ordineElement.remove();
		})
		.catch((error) => {
			console.error("Errore durante l'eliminazione:", error);
			pushNotifica(
				"error",
				"Si è verificato un errore durante l'eliminazione dell'ordine.",
			);
		});
}

async function controllaInfoPersonali(event) {
	const vecchiaPassword = document.getElementById("vecchiaPassword");
	const vecchiaPasswordError = document.getElementById(
		"vecchiaPasswordError",
	);
	const emailUtente = document.getElementById("email");
	const nome = document.getElementById("nome");
	const cognome = document.getElementById("cognome");
	const dataDiNascita = document.getElementById("dataDiNascita");
	const errorDataNascita = document.getElementById("dataNascitaError");
	const password = document.getElementById("password");
	const errorPassword = document.getElementById("passwordError");
	const confermaPassword = document.getElementById("confermaPassword");
	const errorConfermaPassword = document.getElementById(
		"confermaPasswordError",
	);

	let valid = true;

	const formData = new FormData();
	formData.append("action", "ottieniVecchiaPassword");
	formData.append("email", emailUtente.value);

	const url = "modifica-informazioni.php";

	try {
		const response = await fetch(url, {
			method: "POST",
			body: formData,
		});
		if (!response.ok) {
			throw new Error(`Response status: ${response.status}`);
		}
		const data = await response.json();

		const passwordHashata = CryptoJS.SHA512(vecchiaPassword.value).toString(
			CryptoJS.enc.Hex,
		);
		const vecchia = passwordHashata + data.salt;
		const passwordVecchiaHashata = CryptoJS.SHA512(vecchia).toString(
			CryptoJS.enc.Hex,
		);

		if (
			password.value.trim() != "" &&
			vecchiaPassword.value.trim() != "" &&
			confermaPassword.value.trim() != ""
		) {
			if (data.password === passwordVecchiaHashata) {
				nascondiErrore(vecchiaPasswordError, vecchiaPassword);
			} else {
				event.preventDefault();
				mostraErrore(vecchiaPasswordError, vecchiaPassword);
				valid = false;
			}

			if (password.value !== confermaPassword.value) {
				event.preventDefault();
				mostraErrore(errorConfermaPassword, confermaPassword);
				valid = false;
			} else {
				nascondiErrore(errorConfermaPassword, confermaPassword);
			}

			if (passwordValida(password.value)) {
				nascondiErrore(errorPassword, password);
			} else {
				event.preventDefault();
				mostraErrore(errorPassword, password);
				valid = false;
			}
		}

		if (isMaggiorenne(dataDiNascita.value)) {
			nascondiErrore(errorDataNascita, dataDiNascita);
		} else {
			event.preventDefault();
			mostraErrore(errorDataNascita, dataDiNascita);
			valid = false;
		}

		if (valid) {
			const modificaFormData = new FormData();
			modificaFormData.append("action", "modificaInformazioni");
			modificaFormData.append("email", emailUtente.value);
			if (password != null) {
				modificaFormData.append(
					"password",
					CryptoJS.SHA512(password.value).toString(CryptoJS.enc.Hex),
				);
			}
			modificaFormData.append("nome", nome.value);
			modificaFormData.append("cognome", cognome.value);
			modificaFormData.append("dataDiNascita", dataDiNascita.value);

			// Esegui la seconda richiesta
			const modificaResponse = await fetch(url, {
				method: "POST",
				body: modificaFormData,
			});

			if (!modificaResponse.ok) {
				throw new Error(`Response status: ${modificaResponse.status}`);
			}

			const modificaResult = await modificaResponse.json();

			if (modificaResult.success) {
				pushNotifica("success","Informazioni aggiornate con successo!");
				window.location.href = "profilo.php";
			} else {
				pushNotifica("error",
					"Errore durante l'aggiornamento delle informazioni: " +
						modificaResult.message,
				);
			}
		}
	} catch (error) {
		console.error(error.message);
	}
}

function mostraErrore(labelErrore, input) {
	input.style.border = "2px solid var(--color-error)";
	input.style.marginBottom = "0px";
	labelErrore.style.marginBottom = "20px";
	labelErrore.style.display = "inline";
}

function nascondiErrore(labelErrore, input) {
	input.style.border = "1px solid #000000";
	input.style.marginBottom = "20px";
	labelErrore.style.marginBottom = "0px";
	labelErrore.style.display = "none";
}

function controllaDatiESubmit(form, event) {
	const password = document.getElementById("password");
	const errorPassword = document.getElementById("passwordError");
	const confermaPassword = document.getElementById("confermaPassword");
	const errorConfermaPassword = document.getElementById(
		"confermaPasswordError",
	);
	const dataDiNascita = document.getElementById("dataDiNascita");
	const errorDataNascita = document.getElementById("dataNascitaError");

	let valid = true;

	if (password.value !== confermaPassword.value) {
		event.preventDefault();
		mostraErrore(errorConfermaPassword, confermaPassword);
		valid = false;
	} else {
		nascondiErrore(errorConfermaPassword, confermaPassword);
	}

	if (passwordValida(password.value)) {
		nascondiErrore(errorPassword, password);
	} else {
		event.preventDefault();
		mostraErrore(errorPassword, password);
		valid = false;
	}

	if (isMaggiorenne(dataDiNascita.value)) {
		nascondiErrore(errorDataNascita, dataDiNascita);
	} else {
		event.preventDefault();
		mostraErrore(errorDataNascita, dataDiNascita);
		valid = false;
	}

	if (valid) {
		document.getElementById("password").style.display = "none";
		document.getElementById("password").value = CryptoJS.SHA512(
			password.value,
		).toString(CryptoJS.enc.Hex);

		form.submit();
	}
}

function passwordValida(password) {
	const passwordRegex =
		/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&]{8,}$/;
	return passwordRegex.test(password);
}

function isMaggiorenne(dataDiNascita) {
	const oggi = new Date();
	const dataNascita = new Date(dataDiNascita);
	let eta = oggi.getFullYear() - dataNascita.getFullYear();
	const meseDifferenza = oggi.getMonth() - dataNascita.getMonth();

	if (
		meseDifferenza < 0 ||
		(meseDifferenza === 0 && oggi.getDate() < dataNascita.getDate())
	) {
		eta--;
	}

	return eta >= 18;
}

/*Nuovo prodotto*/
document.addEventListener("DOMContentLoaded", function () {
	const tipoProdottoSelect = document.getElementById("tipologia");

	if (!tipoProdottoSelect) {
		return;
	}

	const form = tipoProdottoSelect.closest("form");

	tipoProdottoSelect.addEventListener("change", function () {
		const tipoSelezionato = tipoProdottoSelect.value;

		if (!tipoSelezionato) return;

		fetch("nuovo-prodotto.php?tipo=" + encodeURIComponent(tipoSelezionato))
			.then((response) => {
				if (!response.ok) {
					throw new Error("Errore nella richiesta AJAX");
				}
				return response.json();
			})
			.then((data) => {
				// Rimuovi campi dinamici precedenti
				const dinamici = form.querySelectorAll(".campi-dinamici");
				dinamici.forEach((el) => el.remove());

				// Genera nuovi campi dinamici
				data.forEach((caratteristica) => {
					const wrapper = document.createElement("div");
					wrapper.className = "campi-dinamici";

					const label = document.createElement("label");
					label.setAttribute(
						"for",
						"caratteristiche_" + caratteristica.codice,
					);
					label.textContent = caratteristica.nome;

					const input = document.createElement("input");
					input.type = "text";
					input.id = "caratteristiche_" + caratteristica.codice;
					input.name = `caratteristiche[${caratteristica.codice}]`;
					input.placeholder = caratteristica.descrizione;
					input.setAttribute("required", "");

					label.appendChild(input);
					console.log(label);
					wrapper.appendChild(label);
					form.insertBefore(wrapper, form.querySelector("button"));
				});
			})
			.catch((error) => console.error("Errore:", error));
	});
});

const fotoInput = document.getElementById("foto");
if (fotoInput) {
	fotoInput.addEventListener("change", function (event) {
		const fotoLabel = document.querySelector('label[for="foto"]');
		const files = event.target.files;

		const existingImages = fotoLabel.querySelectorAll("img");
		existingImages.forEach((img) => img.remove());

		if (files.length > 0) {
			rimuoviFotoButton.style.display = "inline";
			Array.from(files).forEach((file) => {
				const reader = new FileReader();

				reader.onload = function (e) {
					const img = document.createElement("img");
					img.src = e.target.result;
					img.alt = "Anteprima immagine";

					fotoLabel.appendChild(img);
				};

				reader.readAsDataURL(file);
			});
		} else {
			rimuoviFotoButton.style.display = "none";
		}
	});
}

const rimuoviFotoButton = document.getElementById("rimuovi-foto");
if (rimuoviFotoButton) {
	rimuoviFotoButton.addEventListener("click", function () {
		const fotoLabel = document.querySelector('label[for="foto"]');
		const existingImages = fotoLabel.querySelectorAll("img");
		existingImages.forEach((img) => img.remove());

		if (fotoInput) fotoInput.value = "";
		rimuoviFotoButton.style.display = "none";
	});
}

document.querySelectorAll(".rimuovi-immagine").forEach((button) => {
	button.addEventListener("click", function () {
		const immagineDaRimuovere = this.getAttribute("data-immagine");

		const immaginiInput = document.getElementById("immagini_da_rimuovere");
		let immaginiDaRimuovere = immaginiInput.value
			? immaginiInput.value.split(",")
			: [];

		if (!immaginiDaRimuovere.includes(immagineDaRimuovere)) {
			immaginiDaRimuovere.push(immagineDaRimuovere);
		}

		const immagineContainer = this.closest(".immagine-container");
		if (immagineContainer) {
			immagineContainer.remove();
		}

		immaginiInput.value = immaginiDaRimuovere.join(",");
	});
});

function eliminaProdotto(codiceProdotto) {
	if (confirm("Sei sicuro di voler eliminare questo prodotto?")) {
		fetch("gestisci-prodotto.php", {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({
				action: "elimina",
				codice: codiceProdotto,
			}),
		})
			.then((response) => {
				if (response.ok) {
					alert("Prodotto eliminato con successo!");
					location.reload();
				} else {
					alert("Errore durante l'eliminazione del prodotto.");
				}
			})
			.catch((error) => {
				console.error("Errore:", error);
				alert("Errore durante l'eliminazione del prodotto.");
			});
	}
}

/*MODIFICA TIPOLOGIA*/
function aggiungiCaratteristica() {
	const ul = document.getElementById("lista-caratteristiche");
	const li = document.createElement("li");
	li.innerHTML = `
        <label class="sr-only" for="caratteristica-${ul.children.length}">
			<span>Nuova caratteristica</span>
		</label>
		<input type="text" name="caratteristiche[]" id="caratteristica-${ul.children.length}" required>
		<button type="button" onclick="rimuoviCaratteristica(this)">
			<span aria-hidden="true" class="fa-solid fa-trash"></span>
			<span class="sr-only">Rimuovi Caratteristica</span>
		</button>
    `;
	ul.appendChild(li);
}

function rimuoviCaratteristica(button) {
	button.parentElement.remove();
}

/* PARTE DELLE MARCHE */

// Abilita la modalità di modifica
function toggleEditMode(button) {
	const article = button.closest("article");
	const h3 = article.querySelector("header > h3");
	const input = article.querySelector('input[type="text"]');
	const saveButton = article.querySelector('[name="salvaMarca"]');

	// Mostra il campo di input e nasconde l'h3
	h3.style.display = "none";
	input.style.display = "inline-block";

	// Nasconde il bottone di modifica e mostra il bottone di salvataggio
	button.style.display = "none";
	saveButton.style.display = "inline";

	// Imposta il focus sull'input
	input.focus();
}

function saveMarca(button, codiceMarca) {
	const article = button.closest("article");
	const input = article.querySelector('input[type="text"]');
	const titolo = input.value.trim();

	if (!titolo) {
		alert("Il titolo della marca non può essere vuoto.");
		return;
	}

	const formData = new FormData();
	formData.append("action", 2);
	formData.append("codice", codiceMarca);
	formData.append("titolo", titolo);

	fetch("gestisci-marca.php", {
		method: "POST",
		body: formData,
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error(`Response status: ${response.status}`);
			}
			return response.json();
		})
		.then((data) => {
			if (data.success) {
				const titoloElement = article.querySelector(
					"h3[data-editable='false']",
				);
				titoloElement.textContent = titolo;
				titoloElement.setAttribute("style", "display: block;");
				input.setAttribute("style", "display: none;");

				const salvaButton = article.querySelector(
					"button[name='salvaMarca']",
				);
				salvaButton.setAttribute("style", "display: none;");

				const modificaButton = article.querySelector(
					"button[name='modificaMarca']",
				);
				modificaButton.setAttribute("style", "display:inline;");

				pushNotifica("success", "Modifica salvata con successo");
			} else {
				pushNotifica("error", "Errore durante il salvataggio");
			}
		})
		.catch((error) => console.error("Errore:", error));
}

function deleteMarca(id) {
	if (!confirm("Sei sicuro di voler eliminare questa marca?")) return;

	const formData = new FormData();
	formData.append("action", 3);
	formData.append("codice", id);

	fetch("gestisci-marca.php", {
		method: "POST",
		body: formData,
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error(`Response status: ${response.status}`);
			}
			return response.json();
		})
		.then((data) => {
			console.log(data);
			if (data.success) {
				const article = document.querySelector(
					`article[data-id="${id}"]`,
				);
				if (article) {
					article.remove();
					pushNotifica("success", "Marca eliminata con successo");
				}
			} else {
				pushNotifica("error", "Errore durante l'eliminazione");
			}
		})
		.catch((error) => console.error("Errore:", error));
}

function aggiungiNuovaMarca() {
	const primaMarca = document.querySelectorAll(
		"section > article:first-of-type",
	);

	const nuovaMarca = document.createElement("article");

	nuovaMarca.innerHTML = `
        <header>
            <input type="text" title="nuova marca" style="display:inline" placeholder="Inserisci il titolo della marca" />
        </header>
        <footer>
            <form action="#">
                <button type="button" name="salvaMarca" aria-label="Salva modifica" 
                        style="display: inline;"
                        onclick="saveNuovaMarca(this)">
                    <span aria-hidden="true" class="fa-solid fa-floppy-disk"></span>
                    <span class="fa-sr-only">Salva modifica</span>
                </button>
                
                <button type="button" name="eliminaMarca" aria-label="Elimina marca" 
                        style="display: inline;"
                        onclick="deleteNuovaMarca(this)">
                    <span aria-hidden="true" class="fa-solid fa-trash"></span>
                    <span class="fa-sr-only">Elimina marca</span>
                </button>
            </form>
        </footer>
    `;

	primaMarca[0].before(nuovaMarca);
}

function saveNuovaMarca(button) {
	const articolo = button.closest("article");
	const titoloInput = articolo.querySelector("input[type='text']");
	const titolo = titoloInput.value.trim();

	if (!titolo) {
		alert("Il titolo della marca non può essere vuoto.");
		return;
	}

	// Creazione dell'oggetto FormData
	const formData = new FormData();
	formData.append("action", 1);
	formData.append("titolo", titolo);

	// Richiesta AJAX per salvare la nuova marca
	fetch("gestisci-marca.php", {
		// Sostituisci con il percorso reale al tuo endpoint PHP
		method: "POST",
		body: formData,
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error(`Response status: ${response.status}`);
			}

			return response.text().then((text) => {
				console.log(text);
				return JSON.parse(text);
			});
		})
		.then((data) => {
			pushNotifica("success", "Modificata la marca");
			window.location.reload();
		})
		.catch((error) => {
			// Gestisce eventuali errori
			console.error("Errore durante la creazione:", error);
			pushNotifica(
				"error",
				"Si è verificato un errore durante la creazione della marca",
			);
		});
}

function deleteNuovaMarca(button) {
	const articolo = button.closest("article");
	articolo.remove();
}

function eliminaNotifica(codiceNotifica) {
	const formData = new FormData();
	formData.append("action", 1);
	formData.append("codiceNotifica", codiceNotifica);

	fetch("notifiche.php", {
		method: "POST",
		body: formData,
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error("Errore nella risposta del server.");
			}
			return response.text();
		})
		.then((data) => {
			pushNotifica("success", "Notifica eliminata con successo");

			const articoloNotifica = document.querySelector(
				`article[data-codice-notifica="${codiceNotifica}"]`,
			);

			if (articoloNotifica) {
				articoloNotifica.remove();
			}
		})
		.catch((error) => {
			console.error("Errore durante l'eliminazione:", error);
			pushNotifica(
				"error",
				"Si è verificato un errore durante l'eliminazione della notifica.",
			);
		});
}
