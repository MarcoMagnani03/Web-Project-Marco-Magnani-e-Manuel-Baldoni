DROP TABLE IF EXISTS RECENSIONE;
DROP TABLE IF EXISTS PRODOTTI_ORDINE;
DROP TABLE IF EXISTS ORDINE;
DROP TABLE IF EXISTS STATO_ORDINE;
DROP TABLE IF EXISTS CARRELLO;
DROP TABLE IF EXISTS SPECIFICA_PRODOTTO;
DROP TABLE IF EXISTS CARATTERISTICA_PRODOTTO;
DROP TABLE IF EXISTS IMMAGINE_PRODOTTO;
DROP TABLE IF EXISTS PRODOTTO;
DROP TABLE IF EXISTS MARCA;
DROP TABLE IF EXISTS TIPOLOGIA_PRODOTTO;
DROP TABLE IF EXISTS NOTIFICA;
DROP TABLE IF EXISTS TIPO_NOTIFICA;
DROP TABLE IF EXISTS UTENTE;


-- Creazione della tabella UTENTE
CREATE TABLE UTENTE (
    email VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    nome VARCHAR(255),
    cognome VARCHAR(255),
    dataDiNascita DATE,
    ruolo ENUM('venditore', 'cliente') NOT NULL
);

-- Creazione della tabella TIPO_NOTIFICA
CREATE TABLE TIPO_NOTIFICA (
    titolo VARCHAR(255) PRIMARY KEY
);

-- Creazione della tabella NOTIFICA
CREATE TABLE NOTIFICA (
    codice INT PRIMARY KEY AUTO_INCREMENT,
    titolo VARCHAR(255) NOT NULL,
    contenuto TEXT NOT NULL,
    letta BOOLEAN DEFAULT FALSE,
    dataCreazione DATE NOT NULL,
    utenteEmail VARCHAR(255) NOT NULL,
    tipologia VARCHAR(255) NOT NULL,
    FOREIGN KEY (utenteEmail) REFERENCES UTENTE(email) ON DELETE CASCADE,
	 FOREIGN KEY (tipologia) REFERENCES TIPO_NOTIFICA(titolo)
);

-- Creazione della tabella MARCA
CREATE TABLE MARCA (
    codice INT PRIMARY KEY AUTO_INCREMENT,
    titolo VARCHAR(255) NOT NULL
);

-- Creazione della tabella TIPOLOGIA_PRODOTTO
CREATE TABLE TIPOLOGIA_PRODOTTO (
    nome VARCHAR(255) PRIMARY KEY,
    descrizione TEXT NOT NULL
);

-- Creazione della tabella PRODOTTO
CREATE TABLE PRODOTTO (
    codice INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL UNIQUE,
    descrizione TEXT,
    prezzo DECIMAL(10, 2) NOT NULL,
    dataCreazione DATE NOT NULL,
    stato ENUM('disponibile', 'non disponibile') NOT NULL,
    quantita INT NOT NULL,
    tipologia VARCHAR(255) NOT NULL,
    marca INT,
    FOREIGN KEY (marca) REFERENCES MARCA(codice),
    FOREIGN KEY (tipologia) REFERENCES TIPOLOGIA_PRODOTTO(nome)
);

-- Creazione della tabella IMMAGINE_PRODOTTO (per gestire l'associazione 1-N con PRODOTTO)
CREATE TABLE IMMAGINE_PRODOTTO (
    id INT PRIMARY KEY AUTO_INCREMENT,
    prodotto INT NOT NULL,
    percorso VARCHAR(255) NOT NULL,
    FOREIGN KEY (prodotto) REFERENCES PRODOTTO(codice) ON DELETE CASCADE
);

-- Creazione della tabella CARATTERISTICA_PRODOTTO
CREATE TABLE CARATTERISTICA_PRODOTTO (
    codice INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    descrizione TEXT,
    tipologia VARCHAR(255) NOT NULL,
    FOREIGN KEY (tipologia) REFERENCES TIPOLOGIA_PRODOTTO(nome) ON DELETE CASCADE
);

-- Creazione della tabella SPECIFICA_PRODOTTO (contenuto della caratteristica per ogni prodotto)
CREATE TABLE SPECIFICA_PRODOTTO (
    prodotto INT,
    caratteristica INT,
    contenuto TEXT NOT NULL,
    PRIMARY KEY (prodotto, caratteristica),
    FOREIGN KEY (prodotto) REFERENCES PRODOTTO(codice) ON DELETE CASCADE,
    FOREIGN KEY (caratteristica) REFERENCES CARATTERISTICA_PRODOTTO(codice) ON DELETE CASCADE
);

-- Creazione della tabella CARRELLO
CREATE TABLE CARRELLO (
    utente VARCHAR(255),
    prodotto INT,
    quantita INT NOT NULL,
    PRIMARY KEY (utente, prodotto),
    FOREIGN KEY (utente) REFERENCES UTENTE(email) ON DELETE CASCADE,
    FOREIGN KEY (prodotto) REFERENCES PRODOTTO(codice) ON DELETE CASCADE
);

-- Creazione della tabella STATO_ORDINE
CREATE TABLE STATO_ORDINE (
    titolo VARCHAR(255) PRIMARY KEY
);

-- Creazione della tabella ORDINE
CREATE TABLE ORDINE (
    codice INT PRIMARY KEY AUTO_INCREMENT,
    dataPartenza DATE NOT NULL,
    dataArrivo DATE NOT NULL,
    utente VARCHAR(255),
    stato VARCHAR(255) NOT NULL,
    FOREIGN KEY (utente) REFERENCES UTENTE(email) ON DELETE SET NULL,
    FOREIGN KEY (stato) REFERENCES STATO_ORDINE(titolo)
);

-- Tabella per la relazione PRODOTTI_ORDINE (prodotti in ogni ordine)
CREATE TABLE PRODOTTI_ORDINE (
    ordine INT,
    prodotto INT,
    quantita INT NOT NULL,
    PRIMARY KEY (ordine, prodotto),
    FOREIGN KEY (ordine) REFERENCES ORDINE(codice) ON DELETE CASCADE,
    FOREIGN KEY (prodotto) REFERENCES PRODOTTO(codice) ON DELETE CASCADE
);

-- Creazione della tabella RECENSIONE
CREATE TABLE RECENSIONE (
    id INT PRIMARY KEY AUTO_INCREMENT,
    valutazione INT CHECK (valutazione BETWEEN 1 AND 5)ecommerce_twecommerce_tw,
    titolo VARCHAR(255) NOT NULL,
    descrizione TEXT NOT NULL,
    dataCreazione DATE NOT NULL,
    utente VARCHAR(255) NOT NULL,
    prodotto INT NOT NULL,
    FOREIGN KEY (utente) REFERENCES UTENTE(email) ON DELETE CASCADE,
    FOREIGN KEY (prodotto) REFERENCES PRODOTTO(codice) ON DELETE CASCADE
);
