document.addEventListener("DOMContentLoaded", function () { 
	const mobileMenuAside = document.getElementById("mobile-menu-aside");
	const mobileMenuOpener = document.getElementById("btn-mobile-menu-opener");
	const mobileMenuCloser = document.getElementById("btn-mobile-menu-closer");

	mobileMenuOpener?.addEventListener("click", function () {
		mobileMenuAside?.classList.add("open");
	});

	mobileMenuCloser?.addEventListener("click", function () {
		mobileMenuAside?.classList.remove("open");
	});

	const mobileFilters = document.getElementById("mobile-filters");
	const mobileFiltersOpener = document.getElementById("btn-mobile-filters-opener");
	const mobileFiltersCloser = document.getElementById("btn-mobile-filters-closer");

	mobileFiltersOpener?.addEventListener("click", function () {
		mobileFilters?.classList.add("open");
	});

	mobileFiltersCloser?.addEventListener("click", function () {
		mobileFilters?.classList.remove("open");
	});

	const mobileCart = document.getElementById("mobile-cart");
	const mobileCartOpener = document.getElementById("btn-mobile-cart-opener");
	const mobileCartCloser = document.getElementById("btn-mobile-cart-closer");

	mobileCartOpener?.addEventListener("click", function () {
		mobileCart?.classList.add("open");
	});

	mobileCartCloser?.addEventListener("click", function () {
		mobileCart?.classList.remove("open");
	});
})


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