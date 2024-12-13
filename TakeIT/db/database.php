<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname){
        $this->db = new mysqli($servername, $username, $password, $dbname);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }        
    }

    public function registrazione($email, $password,$nome,$cognome,$cellulare,$dataNascita,$role='cliente') {
        
        $stmt = $this->db->prepare("SELECT * FROM utente WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return "L'email è già registrata";
        } else {
            $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            // Crea una password usando la chiave appena creata.

            $password = hash('sha512', $password.$random_salt);
    
            $stmt = $this->db->prepare("INSERT INTO utente (email, password, nome, cognome,cellulare, dataDiNascita, ruolo, salt) VALUES (?, ?, ?, ?, ?, ?, ?,?)");
        
            $stmt->bind_param('ssssssss', $email, $password, $nome, $cognome,$cellulare, $dataNascita, $role,$random_salt);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                return false;
            }
        }
    }        

    public function login($email,$password){
        // Usando statement sql 'prepared' non sarà possibile attuare un attacco di tipo SQL injection.
        $stmt = $this->db->prepare("SELECT email, password, salt FROM utente WHERE email = ? LIMIT 1");
        $stmt->bind_param('s', $email); // esegue il bind del parametro '$email'.
        $stmt->execute(); // esegue la query appena creata.
        $stmt->store_result();
        $stmt->bind_result($email, $db_password, $salt); // recupera il risultato della query e lo memorizza nelle relative variabili.
        $stmt->fetch();
        $password = hash('sha512', $password.$salt); // codifica la password usando una chiave univoca.
        if($stmt->num_rows == 1) { // se l'utente esiste
            if($db_password == $password) { // Verifica che la password memorizzata nel database corrisponda alla password fornita dall'utente.
                // Password corretta!            
                $user_browser = $_SERVER['HTTP_USER_AGENT']; // Recupero il parametro 'user-agent' relativo all'utente corrente.

                $email = preg_replace("/[^a-zA-Z0-9@._-]+/", "", $email); // ci proteggiamo da un attacco XSS
                $_SESSION['email'] = $email; 
                $_SESSION['login_string'] = hash('sha512', $password.$user_browser);
                // Login eseguito con successo.
                return true;    
            }
        } else {
            // L'utente inserito non esiste.
            return false;
        }
        
    }

    public function login_check() {
        if (isset($_SESSION['email'], $_SESSION['login_string'])) {
            $login_string = $_SESSION['login_string'];
            $email = $_SESSION['email'];     
            $user_browser = $_SERVER['HTTP_USER_AGENT'];
    
            if ($stmt = $this->db->prepare("SELECT password FROM utente WHERE email = ? LIMIT 1")) { 
                $stmt->bind_param('s', $email);
                $stmt->execute();
                $stmt->store_result();
    
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($password);
                    $stmt->fetch();
                    
                    // Crea login_check concatenando password, salt e user agent.
                    $login_check = hash('sha512', $password.$user_browser);
                    
                    if ($login_check == $login_string) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
	public function login_check_admin() {
        if (!isset($_SESSION['email'], $_SESSION['login_string'])) {
            return false;
        }

		$login_string = $_SESSION['login_string'];
		$email = $_SESSION['email'];     
		$user_browser = $_SERVER['HTTP_USER_AGENT'];
		$stmt = $this->db->prepare("SELECT password,ruolo FROM utente WHERE email = ? LIMIT 1");

		if (!$stmt){
			return false;
		}

		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows != 1) {
			return false;
		}

		$stmt->bind_result($password, $ruolo);
		$stmt->fetch();
		
		// Crea login_check concatenando password, salt e user agent.
		$login_check = hash('sha512', $password.$user_browser);

		if ($login_check != $login_string) {
			return false;
		}

		if($ruolo != "venditore"){
			return false;
		}

		return true;
    }

	public function getProdotti(){
		$stmt = $this->db->prepare("SELECT * FROM prodotto");
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_all(MYSQLI_ASSOC);
	}

	public function getProdottiCorrelati($prodotto_id, $tipologia_prodotto_id){
		$stmt = $this->db->prepare("SELECT * FROM prodotto WHERE tipologia = ? AND codice != ?");
		$stmt->bind_param('is', $tipologia_prodotto_id, $prodotto_id);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	public function getTipologieProdotto(){
		$stmt = $this->db->prepare("SELECT
			tipologia_prodotto.nome,
			tipologia_prodotto.descrizione,
			caratteristica_prodotto.codice,
			caratteristica_prodotto.nome as caratteristica_prodotto_nome,
			caratteristica_prodotto.descrizione as caratteristica_prodotto_descrizione,
			caratteristica_prodotto.tipologia
			FROM tipologia_prodotto
			JOIN caratteristica_prodotto
			ON tipologia_prodotto.nome = caratteristica_prodotto.tipologia
		");
		$stmt->execute();
		$result = $stmt->get_result();

		$tipologie = [];

		while($row = $result->fetch_assoc()){
			if(isset($tipologie[$row["nome"]])){
				array_push($tipologie[$row["nome"]]["caratteristiche"], [
					'codice' => $row['codice'],
					'nome' => $row['caratteristica_prodotto_nome'],
					'descrizione' => $row['caratteristica_prodotto_descrizione'],
				]);
			}
			else{
				$nuova_tipologia = $row;
				$nuova_tipologia["caratteristiche"][] = [
					'codice' => $row['codice'],
					'nome' => $row['caratteristica_prodotto_nome'],
					'descrizione' => $row['caratteristica_prodotto_descrizione'],
				];
				$tipologie[$row["nome"]] = $nuova_tipologia;
			}
		}

		return $tipologie;
	}

    public function getProdotto($codice_prodotto){
		$stmt = $this->db->prepare("SELECT * FROM prodotto WHERE codice = ?");
		$stmt->bind_param('s', $codice_prodotto);
		$stmt->execute();
		$result_prodotto = $stmt->get_result();
		return $result_prodotto->fetch_assoc();
	}

    public function getSpecificheProdotto($codice_prodotto){
        $stmt = $this->db->prepare("SELECT * FROM specifica_prodotto INNER JOIN caratteristica_prodotto ON specifica_prodotto.caratteristica = caratteristica_prodotto.codice WHERE prodotto = ?");
		$stmt->bind_param('s', $codice_prodotto);
		$stmt->execute();
		$result_specifiche = $stmt->get_result();
		return $result_specifiche->fetch_all(MYSQLI_ASSOC);
    }

	public function getRecensioniForProdotto($codice_prodotto){
        $stmt = $this->db->prepare("SELECT * FROM recensione LEFT JOIN utente ON recensione.utente = utente.email WHERE prodotto = ?");
		$stmt->bind_param('s', $codice_prodotto);
		$stmt->execute();
		$result_recensioni = $stmt->get_result();
		return $result_recensioni->fetch_all(MYSQLI_ASSOC);
    }

	public function getValutazioneForProdotto($codice_prodotto){
        $stmt = $this->db->prepare("SELECT * FROM recensione WHERE prodotto = ?");
		$stmt->bind_param('s', $codice_prodotto);
		$stmt->execute();
		$result_recensioni = $stmt->get_result();
		$recensioni = $result_recensioni->fetch_all(MYSQLI_ASSOC);

		if(count($recensioni) == 0){
			return 0;
		}

		$valutazione_prodotto = 0;
		foreach($recensioni as $recensione){
			$valutazione_prodotto += $recensione["valutazione"];
		}
		$valutazione_prodotto = $valutazione_prodotto / count($recensioni);
		return number_format($valutazione_prodotto, 1);
    }

    public function getNotificheUtente($email_utente){
        $stmt = $this->db->prepare("SELECT * FROM notifica WHERE utenteEmail = ?");
        $stmt->bind_param('s',$email_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getInformazioni($email_utente){
        $stmt = $this->db->prepare("SELECT * FROM utente WHERE email = ?");
        $stmt->bind_param('s',$email_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getOrdini($email_utente) {
        $stmt = $this->db->prepare("
            SELECT 
                o.codice AS ordine_codice, 
                o.dataPartenza AS dataPartenza, 
                o.dataOraArrivo AS dataOraArrivo, 
                o.stato AS stato,
                p.nome AS nome, 
                p.prezzo AS prezzo, 
                p.codice AS prodotto_codice,
                po.quantita AS quantita
            FROM 
                ordine o
            JOIN 
                prodotti_ordine po ON o.codice = po.ordine
            JOIN 
                prodotto p ON po.prodotto = p.codice
            WHERE 
                o.utente = ?
        ");
        
        $stmt->bind_param('s', $email_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $ordini = [];
    
        while ($row = $result->fetch_assoc()) {
            $ordine_codice = $row['ordine_codice'];
            
            if (!isset($ordini[$ordine_codice])) {
                $ordini[$ordine_codice] = [
                    'codice_ordine' => $ordine_codice,
                    'dataPartenza' => $row['dataPartenza'],
                    'dataOraArrivo' => $row['dataOraArrivo'],
                    'stato' => $row['stato'],
                    'prodotti' => []
                ];
            }
    
            $ordini[$ordine_codice]['prodotti'][] = [
                'codice' => $row['prodotto_codice'],
                'nome' => $row['nome'],
                'prezzo' => $row['prezzo'],
                'quantita' => $row['quantita']
            ];
        }
    
        $stmt->close();
        return $ordini;
    }
    
    public function aggiornaNotificheLette($codiceNotifiche) {
        if (empty($codiceNotifiche)) {
            return false; 
        } 
        var_dump($codiceNotifiche);
        $placeholders = implode(',', array_fill(0, count($codiceNotifiche), '?')); /* Per inserire un ? per ongi codice*/
        $stmt = $this->db->prepare("UPDATE notifica SET letta = 1 WHERE codice IN ($placeholders)");
        $types = str_repeat('i', count($codiceNotifiche));
        $stmt -> bind_param($types,...$codiceNotifiche);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function modificaInformazioni($email, $password, $nome, $cognome, $dataNascita) {
        $stmt = $this->db->prepare("SELECT salt FROM utente WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            return "L'utente con questa email non esiste.";
        }
    
        // Preleva il salt attuale dell'utente
        $user = $result->fetch_assoc();
        $salt = $user['salt'];
    
        // Aggiorna la password solo se fornita
        if (!empty($password)) {
            $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true)); 
            $password = hash('sha512', $password.$salt); 
        } else {
            $password = null; 
        }
    
        // Aggiorna i dati dell'utente
        if ($password) {
            $stmt = $this->db->prepare("UPDATE utente SET nome = ?, cognome = ?, dataDiNascita = ?, password = ?, salt = ? WHERE email = ?");
            $stmt->bind_param('sssss', $nome, $cognome, $dataNascita, $password, $salt, $email);
        } else {
            $stmt = $this->db->prepare("UPDATE utente SET nome = ?, cognome = ?, dataDiNascita = ? WHERE email = ?");
            $stmt->bind_param('ssss', $nome, $cognome, $dataNascita, $email);
        }
    
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true; // Modifica riuscita
        } else {
            return "Nessuna modifica effettuata.";
        }
    }

	public function getMarche(){
        $stmt = $this->db->prepare("SELECT * FROM marca");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
 
    public function getCaratteristichePerTipologia($tipologia) {
        $stmt = $this->db->prepare("SELECT codice, nome, descrizione FROM caratteristica_prodotto WHERE tipologia = ?");
        $stmt->bind_param('s', $tipologia);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function inserisciProdotto($nome, $descrizione, $prezzo, $quantita, $tipologia, $marca, $stato) {
        $codice = $this->generateGUID(); 
        $dataCreazione = date('Y-m-d');
        $query = "INSERT INTO prodotto (codice, nome, descrizione, prezzo, quantita, dataCreazione, tipologia, marca, stato) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssdissss', 
            $codice, 
            $nome, 
            $descrizione, 
            $prezzo, 
            $quantita, 
            $dataCreazione,
            $tipologia, 
            $marca, 
            $stato
        );
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return $codice;
        } else {
            return false;
        }
    }
    
    private function generateGUID() {
        if (function_exists('com_create_guid')) {
            return trim(com_create_guid(), '{}');
        } else {
            return sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
    }
    

    public function inserisciImmagineProdotto($codiceProdotto, $nomeImmagine) {
        $query = "INSERT INTO immagine_prodotto (prodotto, percorso) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $codiceProdotto, $nomeImmagine);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            throw new Exception("Errore durante l'inserimento dell'immagine nel database.");
        }
    }

    public function getImmaginePrincipaleProdotto($codiceProdotto) {
        $query = "SELECT percorso FROM immagine_prodotto WHERE prodotto = ? LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $codiceProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['percorso'];
        }
        return null; 
    }
    
    public function getImmaginiProdotto($codiceProdotto) {
        $query = "SELECT percorso FROM immagine_prodotto WHERE prodotto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $codiceProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
        $immagini = [];
        while ($row = $result->fetch_assoc()) {
            $immagini[] = $row['percorso'];
        }
        return $immagini; 
    }
    
    


    public function inserisciSpecificaProdotto($codiceProdotto, $caratteristica, $valore) {
        $stmt = $this->db->prepare("INSERT INTO specifica_prodotto (prodotto, caratteristica, contenuto) VALUES (?, ?, ?)");
        $stmt->bind_param(
            'sis', $codiceProdotto, $caratteristica, $valore);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }
    
}
?>
