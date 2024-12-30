document.addEventListener("DOMContentLoaded", function () { 
	const mobileFilters = document.getElementById("mobile-filters");
	const mobileFiltersOpener = document.getElementById("btn-mobile-filters-opener");
	const mobileFiltersCloser = document.getElementById("btn-mobile-filters-closer");

	mobileFiltersOpener?.addEventListener("click", function () {
		mobileFilters?.classList.add("open");
	});

	mobileFiltersCloser?.addEventListener("click", function () {
		mobileFilters?.classList.remove("open");
	});

    const mobileMenuAside = document.getElementById("mobile-menu-aside");
    const mobileMenuOpener = document.getElementById("btn-mobile-menu-opener");
    const mobileMenuCloser = document.getElementById("btn-mobile-menu-closer");

    mobileMenuOpener?.addEventListener("click", function () {
        mobileMenuAside?.classList.add("open");
    });

    mobileMenuCloser?.addEventListener("click", function () {
        mobileMenuAside?.classList.remove("open");
    });

    const mobileCart = document.getElementById("mobile-cart");
    const mobileCartOpener = document.getElementById("btn-mobile-cart-opener");
    const mobileCartCloser = document.getElementById("btn-mobile-cart-closer");
    const cartContentSection = mobileCart.querySelector("section");

    mobileCartOpener?.addEventListener("click", function () {
        mobileCart?.classList.add("open");
        loadCartProducts();
    });

    mobileCartCloser?.addEventListener("click", function () {
        mobileCart?.classList.remove("open");
    });

    const loadCartProducts = async () => {
        try {
            const response = await fetch("carrello.php", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
            });

            if (!response.ok) {
                throw new Error("Errore durante il caricamento del carrello.");
            }

            const products = await response.json();

            cartContentSection.innerHTML = "";

            if (products.length === 0) {
                cartContentSection.innerHTML = "<p>Il carrello è vuoto.</p>";
                return;
            }

            products.forEach((product) => {
                const productElement = document.createElement("article");
                productElement.classList.add("cart-item");

                productElement.innerHTML = `
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
                                <button aria-label="Riduci quantità" data-action="decrease" data-id="${product.id}">
                                    <span aria-hidden="true" class="fa-solid fa-minus"></span>
                                </button>
                            </li>
                            <li>
                                <label>
                                    <span class="fa-sr-only">Quantità</span>
                                    <input type="number" value="${product.quantita}" aria-label="Quantità" data-id="${product.id}" />
                                </label>
                            </li>
                            <li>
                                <button aria-label="Aumenta quantità" data-action="increase" data-id="${product.id}">
                                    <span aria-hidden="true" class="fa-solid fa-plus"></span>
                                </button>
                            </li>
                        </ul>
                        <button aria-label="Rimuovi prodotto" data-action="remove" data-id="${product.id}">
                            <span aria-hidden="true" class="fa-solid fa-trash"></span>
                        </button>
                    </footer>
                `;

                cartContentSection.appendChild(productElement);
            });
        } catch (error) {
            console.error(error);
            cartContentSection.innerHTML = "<p>Errore nel caricamento del carrello.</p>";
        }
    };

    const cartButtons = document.querySelectorAll(".list-card-prodotto > footer > button");
    cartButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            
            const prodottoElement = button.closest('.list-card-prodotto');
            const codiceProdotto = prodottoElement.querySelector('a').href.split('=')[1];
            const formData = new FormData();

            formData.append("action", "1");
            formData.append("codice", codiceProdotto)
            fetch('carrello.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    alert('Prodotto aggiunto al carrello!');
                } else {
                    alert('Errore: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Errore:', error);
                alert('Si è verificato un errore durante l\'aggiunta al carrello.');
            });
        });
    });
});



function eseguiDisconnessione(){
    window.location.href='disconnetti.php'
}

function formhash(form, password) {
    // Crea un elemento di input che verrà usato come campo di output per la password criptata.
    let p = document.createElement("input");
    // Aggiungi un nuovo elemento al tuo form.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden"
    p.value = CryptoJS.SHA512(password.value).toString(CryptoJS.enc.Hex);

    // Assicurati che la password non venga inviata in chiaro.
    password.value = "";
    // Come ultimo passaggio, esegui il 'submit' del form.
    form.submit();
}

/* PARTE LISTA ORDINI AMMINISTRATORE */
function salvaOrdine(event) {
    event.preventDefault(); 

    const ordineElement = event.target.closest('article');

    const codiceOrdine = ordineElement.querySelector('header h3 strong').textContent.replace('#', '').trim();
    const dataOraArrivo = ordineElement.querySelector('input[name="dataOraArrivo"]').value;
    const statoOrdine = ordineElement.querySelector('select[name="statoOrdine"]').value;

    // Verifica che i dati non siano vuoti
    if (!codiceOrdine || !dataOraArrivo || !statoOrdine) {
        showNotification('Tutti i campi sono obbligatori!', 'error');
        return;
    }

    // Crea un oggetto FormData per inviare i dati
    const formData = new FormData();
    formData.append('salvaOrdine', true);
    formData.append('codiceOrdine', codiceOrdine);
    formData.append('dataOraArrivo', dataOraArrivo);
    formData.append('statoOrdine', statoOrdine);

    // Invia i dati al server tramite AJAX
    fetch('ordiniAmministratore.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Errore nella risposta del server.');
        }
        return response.text(); // Legge la risposta come testo
    })
    .then(data => {
        // Mostra il feedback all'utente
        showNotification(data, 'success');
        console.log('Ordine aggiornato con successo:', data);
    })
    .catch(error => {
        // Gestisce eventuali errori
        console.error('Errore durante l\'aggiornamento:', error);
        showNotification('Si è verificato un errore durante l\'aggiornamento dell\'ordine.', 'error');
    });
}

function eliminaOrdine(event){
    event.preventDefault(); 

    const ordineElement = event.target.closest('article');

    const codiceOrdine = ordineElement.querySelector('header h3 strong').textContent.replace('#', '').trim();
    console.log("TODO")
    //TODO aggiungi logica per eliminazione ordine
}

/* Notifiche */
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`; // Aggiunge una classe basata sul tipo
    notification.textContent = message;

    // Aggiungi la notifica al DOM
    document.body.appendChild(notification);

    // Rimuovi la notifica dopo 3 secondi
    setTimeout(() => {
        notification.remove();
    }, 3000);
}


async function controllaInfoPersonali(event) {
    const vecchiaPassword = document.getElementById("vecchiaPassword");
    const vecchiaPasswordError = document.getElementById("vecchiaPasswordError");
    const emailUtente = document.getElementById("email");
    const nome = document.getElementById("nome");
    const cognome = document.getElementById("cognome");
    const dataDiNascita = document.getElementById("dataDiNascita");
    const errorDataNascita = document.getElementById("dataNascitaError");
    const password = document.getElementById("password");
    const errorPassword = document.getElementById("passwordError");
    const confermaPassword = document.getElementById("confermaPassword");
    const errorConfermaPassword = document.getElementById("confermaPasswordError");

    let valid = true;

    const formData = new FormData();
    formData.append('action', 'ottieniVecchiaPassword');
    formData.append('email', emailUtente.value);

    const url = "modifica-informazioni.php";

    try {
        const response = await fetch(url, {
            method: "POST",                   
            body: formData
        });
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const data = await response.json();

        const passwordHashata = CryptoJS.SHA512(vecchiaPassword.value).toString(CryptoJS.enc.Hex);
        const vecchia = passwordHashata + data.salt;
        const passwordVecchiaHashata = CryptoJS.SHA512(vecchia).toString(CryptoJS.enc.Hex);

        if(password.value.trim() != "" && vecchiaPassword.value.trim() != "" && confermaPassword.value.trim() != ""){
            if (data.password === passwordVecchiaHashata) {
                nascondiErrore(vecchiaPasswordError, vecchiaPassword);
            } else {
                event.preventDefault();
                mostraErrore(vecchiaPasswordError, vecchiaPassword);
                valid = false;
            }
            
            if (password.value !== confermaPassword.value) {
                event.preventDefault()
                mostraErrore(errorConfermaPassword, confermaPassword)
                valid=false;
            } else{
                nascondiErrore(errorConfermaPassword, confermaPassword)
            }

            if (passwordValida(password.value)) {
                nascondiErrore(errorPassword, password)
            } else {
                event.preventDefault();   
                mostraErrore(errorPassword, password)
                valid = false;
            }
        }
    
        if (isMaggiorenne(dataDiNascita.value)) {
            nascondiErrore(errorDataNascita, dataDiNascita)
        } else {
            event.preventDefault();
            mostraErrore(errorDataNascita, dataDiNascita)
            valid = false;
        }
        
        if (valid) {
            const modificaFormData = new FormData();
            modificaFormData.append('action', 'modificaInformazioni');
            modificaFormData.append('email', emailUtente.value);
            if(password != null){
                modificaFormData.append('password', CryptoJS.SHA512(password.value).toString(CryptoJS.enc.Hex));
            }
            modificaFormData.append('nome', nome.value);
            modificaFormData.append('cognome', cognome.value);
            modificaFormData.append('dataDiNascita', dataDiNascita.value);

            // Esegui la seconda richiesta
            const modificaResponse = await fetch(url, {
                method: "POST",
                body: modificaFormData
            });

            if (!modificaResponse.ok) {
                throw new Error(`Response status: ${modificaResponse.status}`);
            }

            const modificaResult = await modificaResponse.json();

            if (modificaResult.success) {
                alert("Informazioni aggiornate con successo!");
                window.location.href = "profilo.php";
            } else {
                alert("Errore durante l'aggiornamento delle informazioni: " + modificaResult.message);
            }
        }
    } catch (error) {
        console.error(error.message);
    }
}


function mostraErrore(labelErrore, input){
    input.style.border= "2px solid var(--color-error)";
    input.style.marginBottom="0px"
    labelErrore.style.marginBottom="20px"
    labelErrore.style.display = "inline";
}

function nascondiErrore(labelErrore, input){
    input.style.border= "1px solid #000000";
    input.style.marginBottom="20px"
    labelErrore.style.marginBottom="0px"
    labelErrore.style.display = "none";
}


function controllaDatiESubmit(form,event) {
    const password = document.getElementById("password");
    const errorPassword = document.getElementById("passwordError");
    const confermaPassword = document.getElementById("confermaPassword");
    const errorConfermaPassword = document.getElementById("confermaPasswordError");
    const dataDiNascita = document.getElementById("dataDiNascita");
    const errorDataNascita = document.getElementById("dataNascitaError");

    let valid = true;

    if (password.value !== confermaPassword.value) {
        event.preventDefault()
        mostraErrore(errorConfermaPassword, confermaPassword)
        valid=false;
    } else{
        nascondiErrore(errorConfermaPassword, confermaPassword)
    }

    if (passwordValida(password.value)) {
        nascondiErrore(errorPassword, password)
    } else {
        event.preventDefault();   
        mostraErrore(errorPassword, password)
        valid = false;
    }

    if (isMaggiorenne(dataDiNascita.value)) {
        nascondiErrore(errorDataNascita, dataDiNascita)
    } else {
        event.preventDefault();
        mostraErrore(errorDataNascita, dataDiNascita)
        valid = false;
    }
    
    if(valid){
        document.getElementById("password").style.display="none"
        document.getElementById("password").value = CryptoJS.SHA512(password.value).toString(CryptoJS.enc.Hex);
        
        form.submit(); 
    }

}


function passwordValida(password){
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&]{8,}$/;
    return passwordRegex.test(password)
}

function isMaggiorenne(dataDiNascita) {
    const oggi = new Date();
    const dataNascita = new Date(dataDiNascita);
    let eta = oggi.getFullYear() - dataNascita.getFullYear();
    const meseDifferenza = oggi.getMonth() - dataNascita.getMonth();
    
    if (meseDifferenza < 0 || (meseDifferenza === 0 && oggi.getDate() < dataNascita.getDate())) {
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
            .then(response => {
                if (!response.ok) {
                    throw new Error("Errore nella richiesta AJAX");
                }
                return response.json(); 
            })
            .then(data => {
                // Rimuovi campi dinamici precedenti
                const dinamici = form.querySelectorAll(".campi-dinamici");
                dinamici.forEach(el => el.remove());

                // Genera nuovi campi dinamici
                data.forEach(caratteristica => {
                    const wrapper = document.createElement("div");
                    wrapper.className = "campi-dinamici";

                    const label = document.createElement("label");
                    label.setAttribute("for", "caratteristiche_" + caratteristica.codice);
                    label.textContent = caratteristica.nome;

                    const input = document.createElement("input");
                    input.type = "text";
                    input.id = "caratteristiche_" + caratteristica.codice;
                    input.name = `caratteristiche[${caratteristica.codice}]`;
                    input.placeholder = caratteristica.descrizione;
                    input.setAttribute("required","")

                    label.appendChild(input);
                    console.log(label);
                    wrapper.appendChild(label);
                    form.insertBefore(wrapper, form.querySelector("button"));
                });
            })
            .catch(error => console.error("Errore:", error));
    });
});

const fotoInput = document.getElementById('foto');
if (fotoInput) {
    fotoInput.addEventListener('change', function(event) {
        const fotoLabel = document.querySelector('label[for="foto"]');
        const files = event.target.files;

        const existingImages = fotoLabel.querySelectorAll('img');
        existingImages.forEach(img => img.remove());
        
        if (files.length > 0) {
            rimuoviFotoButton.style.display = 'inline';
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = "Anteprima immagine";
                    
                    fotoLabel.appendChild(img);
                };
                
                reader.readAsDataURL(file);
            });
        }
        else{
            rimuoviFotoButton.style.display = 'none';
        }
    });
}

const rimuoviFotoButton = document.getElementById('rimuovi-foto');
if (rimuoviFotoButton) {
        rimuoviFotoButton.addEventListener('click', function() {
            const fotoLabel = document.querySelector('label[for="foto"]');
            const existingImages = fotoLabel.querySelectorAll('img');
            existingImages.forEach(img => img.remove());

            if (fotoInput) fotoInput.value = '';
            rimuoviFotoButton.style.display = 'none';
        });
}


document.querySelectorAll('.rimuovi-immagine').forEach(button => {
    button.addEventListener('click', function() {
        const immagineDaRimuovere = this.getAttribute('data-immagine');
        
        const immaginiInput = document.getElementById('immagini_da_rimuovere');
        let immaginiDaRimuovere = immaginiInput.value ? immaginiInput.value.split(',') : [];
        
        if (!immaginiDaRimuovere.includes(immagineDaRimuovere)) {
            immaginiDaRimuovere.push(immagineDaRimuovere);
        }

        const immagineContainer = this.closest('.immagine-container');
        if (immagineContainer) {
            immagineContainer.remove(); 
        }
        
        immaginiInput.value = immaginiDaRimuovere.join(',');
    });
});




function eliminaProdotto(codiceProdotto) {
    if (confirm("Sei sicuro di voler eliminare questo prodotto?")) {
        fetch('gestisci-prodotto.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'elimina',
                codice: codiceProdotto
            })
        })
        .then(response => {
            if (response.ok) {
                alert('Prodotto eliminato con successo!');
                location.reload();
            } else {
                alert('Errore durante l\'eliminazione del prodotto.');
            }
        })
        .catch(error => {
            console.error('Errore:', error);
            alert('Errore durante l\'eliminazione del prodotto.');
        });
    }
}



/*MODIFICA TIPOLOGIA*/
function aggiungiCaratteristica() {
    const ul = document.getElementById('lista-caratteristiche');
    const li = document.createElement('li');
    li.innerHTML = `
        <input type="text" name="caratteristiche[]" required>
        <button type="button" onclick="rimuoviCaratteristica(this)">Rimuovi</button>
    `;
    ul.appendChild(li);
}

function rimuoviCaratteristica(button) {
    button.parentElement.remove();
}


/* PARTE DELLE MARCHE */

// Abilita la modalità di modifica
function toggleEditMode(button) {
    const article = button.closest('article');
    const h3 = article.querySelector('header > h3');
    const input = article.querySelector('input[type="text"]');
    const saveButton = article.querySelector('[id="salvaMarca"]');

    // Mostra il campo di input e nasconde l'h3
    h3.style.display = 'none';
    input.style.display = 'inline-block';

    // Nasconde il bottone di modifica e mostra il bottone di salvataggio
    button.style.display = 'none';
    saveButton.style.display = 'inline-block';

    // Imposta il focus sull'input
    input.focus();
}

// Salva la modifica
function saveMarca(button,codiceMarca) {
    const article = button.closest('article');
    const input = article.querySelector('input[type="text"]');
    const id = article.getAttribute('data-id');

    const titolo = input.value.trim();

    const formData = new FormData();
    formData.append('action', 2);
    formData.append('codice', codiceMarca);
    formData.append('titolo', titolo);

    fetch('gestisci-marca.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        return response.json(); 
    })
    .then(data => {
        showNotification(data, 'success');
        window.location.reload();
    })
    .catch(error => console.error('Errore:', error));
}

function deleteMarca(id) {
    // Conferma eliminazione
    if (!confirm('Sei sicuro di voler eliminare questa marca?')) return;

    const formData = new FormData();
    formData.append('action', 3);
    formData.append('codice', id);

    fetch('gestisci-marca.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        return response.text(); 
    })
    .then(data => {
        showNotification(data, 'success');
        window.location.reload();
    })
    .catch(error => console.error('Errore:', error));
}

function aggiungiNuovaMarca() {
    const primaMarca = document.querySelectorAll("section > section > article:first-of-type");


    const nuovaMarca = document.createElement("article");

    nuovaMarca.innerHTML = `
        <header>
            <input style="display: block; width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;" 
                type="text" placeholder="Inserisci il titolo della marca" />
        </header>
        <footer>
            <form action="#">
                <button type="button" id="salvaMarca" name="salvaMarca" aria-label="Salva modifica" 
                        style="display: inline-block;"
                        onclick="saveNuovaMarca(this)">
                    <span aria-hidden="true" class="fa-solid fa-floppy-disk"></span>
                    <span class="fa-sr-only">Salva modifica</span>
                </button>
                
                <button type="button" id="eliminaMarca" name="eliminaMarca" aria-label="Elimina marca" 
                        style="display: inline-block;"
                        onclick="deleteNuovaMarca(this)">
                    <span aria-hidden="true" class="fa-solid fa-trash"></span>
                    <span class="fa-sr-only">Elimina marca</span>
                </button>
            </form>
        </footer>
    `;

    primaMarca[0].before(nuovaMarca)
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
    formData.append('action', 1);
    formData.append('titolo', titolo);

    // Richiesta AJAX per salvare la nuova marca
    fetch("gestisci-marca.php", { // Sostituisci con il percorso reale al tuo endpoint PHP
        method: "POST",
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        return response.json(); 
    })
    .then(data => {
        showNotification(data, 'success');
        window.location.reload();
    })
    .catch(error => {
        // Gestisce eventuali errori
        console.error('Errore durante la creazione:', error);
        showNotification('Si è verificato un errore durante la creazione della marca', 'error');
    });
}


function deleteNuovaMarca(button) {
    const articolo = button.closest("article");
    articolo.remove();
}
