let notificheLette=[];

/*Funzioni per pagina notifiche*/
function toggleContent(event,button) {

    event.stopPropagation();

    const hiddenContent = button.previousElementSibling;
    if (hiddenContent.style.display === "none" || hiddenContent.style.display === "") {
        hiddenContent.style.display = "inline";
        button.textContent = "Mostra meno";
    } else {
        hiddenContent.style.display = "none";
        button.textContent = "Leggi tutto";
    }
}

function segnaComeLetta(section){
    const codiceNotifica = section.getAttribute('data-codice-notifica');
    if (section.getAttribute('data-notifica-letta') === 'false') {
        section.setAttribute('data-notifica-letta', 'true');
        notificheLette.push(codiceNotifica);
    }
}

function rimuoviClasseAttiva() {
    document.querySelectorAll('header > ul > li > button').forEach(btn => {
        btn.style.backgroundColor='#FFFFFF';
		btn.style.color='var(--color-primary-300)';
		btn.style.border='2px solid var(--color-primary-300)';
    });
}

function inserisciClasseAttiva(btn){
	btn.style.backgroundColor='var(--color-primary-300)';
	btn.style.border='2px solid var(--color-primary-300)';
	btn.style.color='#FFFFFF';
	btn.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)';
}

function mostraTutte() {
    rimuoviClasseAttiva();
    inserisciClasseAttiva(document.getElementById('btnTutte'));
    document.querySelectorAll('article').forEach(article => {
        article.style.display = 'block'; 
    });
}

function mostraLette() {
    rimuoviClasseAttiva();
    inserisciClasseAttiva(document.getElementById('btnLette'));
    document.querySelectorAll('article').forEach(article => {
        if (article.getAttribute('data-notifica-letta') === 'true') {
            article.style.display = 'block'; 
        } else {
            article.style.display = 'none';
        }
    });
}

function mostraNonLette() {
    rimuoviClasseAttiva();
    inserisciClasseAttiva(document.getElementById('btnNonLette'));
    document.querySelectorAll('article').forEach(article => {
        if (article.getAttribute('data-notifica-letta') === 'false') {
            article.style.display = 'block'; 
        } else {
            article.style.display = 'none'; 
        }
    });
}

/*per inviare le notifiche lette*/
window.addEventListener('beforeunload', function () {
    if (notificheLette.length > 0) {
        navigator.sendBeacon('notifiche.php', JSON.stringify({ notificaIds: notificheLette }));
    }
});