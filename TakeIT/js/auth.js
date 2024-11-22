function controllaRegistrazione(event) {
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
        valid = false;
    } else {
        event.preventDefault();
        dataDiNascita.style.border= "2px solid var(--color-error)";
        dataDiNascita.style.marginBottom="0px"
        errorDataNascita.style.marginBottom="20px"
        errorDataNascita.style.display = "inline";
    }

    return valid; 
}


function passwordValida(password){
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&]{8,}$/;
    return passwordRegex.test(password)
}

function isMaggiorenne(dataDiNascita) {
    const oggi = new Date();
    const dataNascita = new Date(dataDiNascita);
    const eta = oggi.getFullYear() - dataNascita.getFullYear();
    const meseDifferenza = oggi.getMonth() - dataNascita.getMonth();

    if (
        meseDifferenza < 0 || 
        (meseDifferenza === 0 && oggi.getDate() < dataNascita.getDate())
    ) {
        console.log(eta-1)
        return eta - 1 >= 18; 
    }

    return eta >= 18;
}
