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

function passaAModifica(){
	window.location.href='modifica-informazioni.php'
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

function controllaInfoPersonali(form,event){
	const vecchiaPassword = document.getElementById("veccchiaPassword");
	const vecchiaPasswordError = document.getElementById("vecchiaPasswordError");
	/*TODO: Implementare come prendere il vechio dato della password dal db*/

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
        errorConfermaPassword.style.display = "inline";     
        confermaPassword.style.border= "2px solid var(--color-error)";
        confermaPassword.style.marginBottom="0px"
        errorConfermaPassword.style.marginBottom="20px"
        valid=false;
    } else{
        confermaPassword.style.border= "1px solid #000000";
        confermaPassword.style.marginBottom="20px"
        errorConfermaPassword.style.marginBottom="0px"
        errorConfermaPassword.style.display = "none"; 
    }

    if (passwordValida(password.value)) {
        password.style.border= "1px solid #000000";
        password.style.marginBottom="20px"
        errorPassword.style.marginBottom="0px"
        errorPassword.style.display = "none";
    } else {
        event.preventDefault();   
        password.style.border= "2px solid var(--color-error)";
        password.style.marginBottom="0px"
        errorPassword.style.marginBottom="20px"
        errorPassword.style.display = "inline";
        valid = false;
    }

    if (isMaggiorenne(dataDiNascita.value)) {
        dataDiNascita.style.border= "1px solid #000000";
        dataDiNascita.style.marginBottom="20px"
        errorDataNascita.style.marginBottom="0px"
        errorDataNascita.style.display = "none";
    } else {
        event.preventDefault();
        dataDiNascita.style.border= "2px solid var(--color-error)";
        dataDiNascita.style.marginBottom="0px"
        errorDataNascita.style.marginBottom="20px"
        errorDataNascita.style.display = "inline";
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

