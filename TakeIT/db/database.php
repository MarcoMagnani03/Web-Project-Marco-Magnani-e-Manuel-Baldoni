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

	public function getProdotti($filters){
		$query = isset($filters["q"]) || isset($filters["tipologie_prodotto"]) || isset($filters["marche"]) || isset($filters["prezzo_min"]) || isset($filters["prezzo_max"]) ? " WHERE " : "";

		$sql_filters = [];
		if(isset($filters["q"])){
			array_push($sql_filters, "(nome LIKE '%".$filters["q"]."%' OR codice LIKE '%".$filters["q"]."%')");
		}

		if(isset($filters["tipologie_prodotto"])){
			// Adding quotes
			$filters["tipologie_prodotto"] = array_map(function($tipologia) {
				$tipologia = "'".$tipologia."'";
				return $tipologia;
			}, $filters["tipologie_prodotto"]);

			array_push($sql_filters, "(tipologia = " . implode(" OR tipologia = ", $filters["tipologie_prodotto"]) . ")");
		}

		if(isset($filters["marche"])){
			array_push($sql_filters, "(marca = " . implode(" OR marca = ", $filters["marche"]) . ")");
		}

		if(isset($filters["prezzo_min"]) || isset($filters["prezzo_max"])){
			array_push($sql_filters, "prezzo BETWEEN " . (empty($filters["prezzo_min"]) ? "0" : $filters["prezzo_min"]) . " AND " . (empty($filters["prezzo_max"]) ? $this->getMaxPriceOfProducts()["prezzo"] : $filters["prezzo_max"]));
		}

		$query .= implode(" AND ", $sql_filters);

		$having = "";
		if(isset($filters["recensioni"])){
			$having = " HAVING media_recensioni = " . implode( " OR media_recensioni = ", $filters["recensioni"]);
		}

		$order = "";
		if(isset($filters["ordine"])){
			$order .= " ORDER BY ".$filters["ordine"];
		}

		$stmt = $this->db->prepare("
			SELECT prodotto.*, CAST(AVG(recensione.valutazione) AS SIGNED) AS media_recensioni
			FROM prodotto LEFT JOIN recensione ON prodotto.codice = recensione.prodotto" . $query .
			" GROUP BY prodotto.codice" . $having . $order
		);
		
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_all(MYSQLI_ASSOC);
	}

	public function getMaxPriceOfProducts(){
		$stmt = $this->db->prepare("SELECT MAX(prezzo) AS prezzo FROM prodotto");
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_assoc();
	}

	public function getProdottiCorrelati($prodotto_id, $tipologia_prodotto_id){
		$stmt = $this->db->prepare("SELECT prodotto.*, CAST(AVG(recensione.valutazione) AS SIGNED) AS media_recensioni
			FROM prodotto LEFT JOIN recensione ON prodotto.codice = recensione.prodotto WHERE tipologia = ? AND codice != ? GROUP BY prodotto.codice");
		$stmt->bind_param('is', $tipologia_prodotto_id, $prodotto_id);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	public function getTipologieProdotto($q){
		$query = isset($q) ? " WHERE tipologia_prodotto.nome LIKE '%".$q."%'" : "";
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
		" . $query);
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

    public function getPasswordData($email) {
        $stmt = $this->db->prepare("SELECT password, salt FROM utente WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result_password = $stmt->get_result();
        return $result_password->fetch_assoc();
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
        $stmt = $this->db->prepare("SELECT * FROM notifica WHERE utenteEmail = ? ORDER BY dataOraCreazione DESC");
        $stmt->bind_param('s',$email_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminaNotifica($codiceNotifica){
        $stmt = $this->db->prepare("DELETE FROM notifica WHERE codice = ?");
        $stmt->bind_param('s',$codiceNotifica);
        $stmt->execute();
    }

    public function eliminaOrdine($codiceOrdine){
        $stmt = $this->db->prepare("DELETE FROM ordine WHERE codice = ?");
        $stmt->bind_param('s',$codiceOrdine);
        $stmt->execute();
    }
    
    public function getInformazioni($email_utente){
        $stmt = $this->db->prepare("SELECT * FROM utente WHERE email = ?");
        $stmt->bind_param('s',$email_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getTuttiOrdini() {
        $stmt = $this->db->prepare("
            SELECT 
                o.codice AS ordine_codice, 
                o.dataPartenza AS dataPartenza, 
                o.dataOraArrivo AS dataOraArrivo, 
                o.stato AS stato,
                o.utente AS utente,
                p.nome AS nome, 
                p.prezzo AS prezzo, 
                p.codice AS prodotto_codice,
                po.quantita AS quantita,
                (SELECT imm.percorso 
                FROM immagine_prodotto imm 
                WHERE imm.prodotto = p.codice 
                LIMIT 1) AS percorso_immagine
            FROM 
                ordine o
            JOIN 
                prodotti_ordine po ON o.codice = po.ordine
            JOIN 
                prodotto p ON po.prodotto = p.codice
        ");

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
                    'utente' => $row['utente'],
                    'prodotti' => []
                ];
            }

            $ordini[$ordine_codice]['prodotti'][] = [
                'codice' => $row['prodotto_codice'],
                'nome' => $row['nome'],
                'prezzo' => $row['prezzo'],
                'quantita' => $row['quantita'],
                'percorso_immagine' => UPLOAD_DIR.$row['percorso_immagine'] 
            ];
        }

        $stmt->close();
        return $ordini;

    }

	public function getProdottiOfOrdine($codice_ordine){
		$stmt = $this->db->prepare("
			SELECT
				prodotto.codice,
				prodotto.nome,
				prodotto.descrizione,
				prodotto.prezzo,
				prodotto.dataCreazione,
				prodotto.stato,
				prodotto.tipologia,
				prodotto.marca,
				prodotti_ordine.quantita,
				CONCAT(?,(SELECT imm.percorso
				FROM immagine_prodotto imm
				WHERE imm.prodotto = prodotto.codice
				LIMIT 1)) AS immagine
			FROM prodotto JOIN prodotti_ordine ON prodotto.codice = prodotti_ordine.prodotto
			WHERE prodotti_ordine.ordine = ?
		");
        $upload = UPLOAD_DIR;
		$stmt->bind_param('ss', $upload, $codice_ordine);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_all(MYSQLI_ASSOC);
	}

    public function getOrdini($email_utente, $filters) {
		$query = isset($filters["q"]) || isset($filters["prezzo_min"]) || isset($filters["prezzo_max"]) || isset($filters["data_arrivo_min"]) || isset($filters["data_arrivo_max"]) || isset($filters["data_ordine_min"]) || isset($filters["data_ordine_max"]) ? " HAVING " : "";

		$sql_filters = [];

		if(isset($filters["q"])){
			array_push($sql_filters, "(codice = ".$filters["q"].")");
		}

		if(isset($filters["prezzo_min"]) || isset($filters["prezzo_max"])){
			array_push($sql_filters, "totale_ordine BETWEEN " . (empty($filters["prezzo_min"]) ? "0" : $filters["prezzo_min"]) . " AND " . (empty($filters["prezzo_max"]) ? $this->getMaxPriceOfProducts()["prezzo"] : $filters["prezzo_max"]));
		}

		if(isset($filters["data_arrivo_min"]) || isset($filters["data_arrivo_max"])){
			array_push($sql_filters, "dataOraArrivo BETWEEN '" . (empty($filters["data_arrivo_min"]) ? "2000-01-01" : $filters["data_arrivo_min"]) . "' AND '" . (empty($filters["data_arrivo_max"]) ? "9999-12-31" : $filters["data_arrivo_max"])  ."'");
		}

		if(isset($filters["data_ordine_min"]) || isset($filters["data_ordine_max"])){
			array_push($sql_filters, "dataPartenza BETWEEN '" . (empty($filters["data_ordine_min"]) ? "2000-01-01" : $filters["data_ordine_min"]) . "' AND '" . (empty($filters["data_ordine_max"]) ? "9999-12-31" : $filters["data_ordine_max"])  ."'");
		}

		$query .= implode(" AND ", $sql_filters);

		$order = "";
		if(isset($filters["ordine"])){
			$order .= " ORDER BY ".$filters["ordine"];
		}

		$user = "";
		if(!empty($email_utente)){
			$user = "WHERE ordine.utente = ?";
		}

        $stmt = $this->db->prepare("
			SELECT ordine.*, SUM(prodotto.prezzo * prodotti_ordine.quantita) AS totale_ordine
			FROM ordine INNER JOIN prodotti_ordine ON ordine.codice = prodotti_ordine.ordine INNER JOIN prodotto ON prodotti_ordine.prodotto = prodotto.codice
			" . $user . "
			GROUP BY ordine.codice
			" . $query . $order
		);

		if(!empty($email_utente)){
			$stmt->bind_param('s', $email_utente);
		}
        $stmt->execute();
        $result = $stmt->get_result();
        $ordini = $result->fetch_all(MYSQLI_ASSOC) ?? [];
        $stmt->close();

		foreach($ordini as &$ordine) {
			$ordine['prodotti'] = $this->getProdottiOfOrdine($ordine['codice']);
		}

        return $ordini;
	}

	public function getMaxPriceOfOrders(){
		$stmt = $this->db->prepare("
			SELECT SUM(prodotto.prezzo * prodotti_ordine.quantita) as totale_ordine
			FROM ordine INNER JOIN prodotti_ordine ON ordine.codice = prodotti_ordine.ordine INNER JOIN prodotto ON prodotti_ordine.prodotto = prodotto.codice
			WHERE ordine.utente = ?
			GROUP BY ordine.codice
            ORDER BY totale_ordine DESC
            LIMIT 1
		");

		$stmt->bind_param('s', $_SESSION["email"]);
        $stmt->execute();
        $result = $stmt->get_result();
		return $result->fetch_assoc();
	}
    
    public function aggiornaNotificheLette($codiceNotifiche) {
        if (empty($codiceNotifiche)) {
            return false; 
        } 
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
    
        $user = $result->fetch_assoc();
        $salt = $user['salt'];
    
        if (!empty($password)) {
            $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true)); 
            $password = hash('sha512', $password.$salt); 
        } else {
            $password = null; 
        }
    
        // Aggiorna i dati dell'utente
        if ($password) {
            $stmt = $this->db->prepare("UPDATE utente SET nome = ?, cognome = ?, dataDiNascita = ?, password = ?, salt = ? WHERE email = ?");
            $stmt->bind_param('ssssss', $nome, $cognome, $dataNascita, $password, $salt, $email);
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
            return false;
        }
    }

    public function getImmaginePrincipaleProdotto($codiceProdotto) {
        $query = "SELECT percorso FROM immagine_prodotto WHERE prodotto = ? LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $codiceProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return UPLOAD_DIR.$row['percorso'];
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
            $immagini[] = UPLOAD_DIR.$row['percorso'];
        }
        return $immagini; 
    }
    
    public function eliminaImmaginiProdotto($immagini) {
        $percorsi = array_map(function($percorso) {
            return str_replace(UPLOAD_DIR, '', $percorso);
        }, $immagini);
        
        $placeholders = implode(',', array_fill(0, count($percorsi), '?'));
        $query = "DELETE FROM immagine_prodotto WHERE percorso IN ($placeholders)";
        $stmt = $this->db->prepare($query);
        $types = str_repeat('s', count($percorsi));
        $stmt->bind_param($types, ...$percorsi);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }
    
    public function modificaSpecificheProdotto($codiceProdotto, $specifiche) {
        $this->db->begin_transaction();
    
        try {
            $stmtDelete = $this->db->prepare("DELETE FROM specifica_prodotto WHERE prodotto = ?");
            $stmtDelete->bind_param('s', $codiceProdotto);
            $stmtDelete->execute();
            $stmtDelete->close();
    
            $stmtInsert = $this->db->prepare("INSERT INTO specifica_prodotto (prodotto, caratteristica, contenuto) VALUES (?, ?, ?)");
            foreach ($specifiche as $specifica) {
                $caratteristica = $specifica['codice'];
                $valore = $specifica['valore'];
    
                $stmtInsert->bind_param('sis', $codiceProdotto, $caratteristica, $valore);
                $stmtInsert->execute();
    
                if ($stmtInsert->affected_rows <= 0) {
                    throw new Exception("Inserimento fallito per caratteristica: $caratteristica");
                }
            }
            $stmtInsert->close();
    
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            error_log($e->getMessage());
            return false;
        }
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


    public function eliminaProdotto($codiceProdotto) {
        $stmt = $this->db->prepare("DELETE FROM prodotto WHERE codice = ?");
        $stmt->bind_param(
            's', $codiceProdotto);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }

    public function modificaProdotto($codiceProdotto, $nome, $descrizione, $prezzo, $quantita, $tipologia, $stato, $marca) {
        // Prepara la query SQL
        $stmt = $this->db->prepare( "UPDATE prodotto SET nome = ?, descrizione = ?, prezzo = ?, quantita = ?, tipologia = ?, stato = ?, marca = ? WHERE codice = ?");

        $stmt->bind_param('ssdissis', $nome, $descrizione, $prezzo, $quantita, $tipologia, $stato, $marca, $codiceProdotto);
        $stmt->execute();

        return true;
    }
    
	public function aggiornaQuantitaProdotto($codiceProdotto, $quantita) {
		$stmt = $this->db->prepare( "UPDATE prodotto SET quantita = ? WHERE codice = ?");

        $stmt->bind_param('is', $quantita, $codiceProdotto);
        $stmt->execute();

        return true;
	}

    function creaNuovaTipologia($nome, $descrizione) {
        $stmt = $this->db->prepare("INSERT INTO tipologia_prodotto (nome, descrizione) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $descrizione);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }

	function creaNuovaRecensione($valutazione_recensione, $titolo_recensione, $descrizione_recensione, $codice_prodotto, $email_utente){
		$stmt = $this->db->prepare("INSERT INTO recensione (valutazione, titolo, descrizione, dataCreazione, utente, prodotto) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $valutazione_recensione, $titolo_recensione, $descrizione_recensione, date('Y-m-d H:i:s'), $email_utente, $codice_prodotto);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
	}
    

    function aggiungiCaratteristiche($nome, $caratteristiche) {
        $stmt = $this->db->prepare("
            INSERT INTO caratteristica_prodotto (nome, tipologia) 
            VALUES (?, ?)
        ");
    
        foreach ($caratteristiche as $caratteristica) {
            $stmt->bind_param("ss", $caratteristica, $nome);
            $stmt->execute();
        }
    
        return $stmt->affected_rows > 0;
    }
    

    function updateTipologia($nome, $descrizione, $caratteristiche) {
        // Aggiorna la descrizione della tipologia
        $stmt = $this->db->prepare("UPDATE tipologia_prodotto SET descrizione = ? WHERE nome = ?");
        $stmt->bind_param("ss", $descrizione, $nome);
        $stmt->execute();
    
        // Elimina le caratteristiche esistenti
        $stmtDelete = $this->db->prepare("DELETE FROM caratteristica_prodotto WHERE tipologia = ?");
        $stmtDelete->bind_param("s", $nome);
        $stmtDelete->execute();
    
        // Aggiungi le nuove caratteristiche
        $stmtInsert = $this->db->prepare("
            INSERT INTO caratteristica_prodotto (nome, tipologia) 
            VALUES (?, ?)
        ");
        foreach ($caratteristiche as $caratteristica) {
            $stmtInsert->bind_param("ss", $caratteristica, $nome);
            $stmtInsert->execute();
        }
    
        return $stmt->affected_rows > 0 || $stmtInsert->affected_rows > 0;
    }
    

    function deleteTipologia($nome) {
        // Elimina la tipologia
        $stmtTipologia = $this->db->prepare("DELETE FROM tipologia_prodotto WHERE nome = ?");
        $stmtTipologia->bind_param("s", $nome);
        $stmtTipologia->execute();
    
        return $stmtTipologia->affected_rows > 0;
    }
    
    function aggiungiNotifica($titolo, $contenuto, $email) {
        $stmt = $this->db->prepare("
            INSERT INTO notifica (titolo, contenuto, utenteEmail, letta, dataOraCreazione, tipologia) 
            VALUES (?, ?, ?, 0, NOW(), 'informazione')
        ");
        $stmt->bind_param("sss", $titolo, $contenuto, $email);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }

    function mandaNotificaAVenditore($titolo, $contenuto) {
        $stmtVenditori = $this->db->prepare("
            SELECT email FROM utente WHERE ruolo = 'venditore'
        ");
        $stmtVenditori->execute();
        $resultVenditori = $stmtVenditori->get_result();
    
        $stmtNotifica = $this->db->prepare("
            INSERT INTO notifica (titolo, contenuto, utenteEmail, letta, dataOraCreazione, tipologia) 
            VALUES (?, ?, ?, 0, NOW(), 'informazione')
        ");
    
        while ($row = $resultVenditori->fetch_assoc()) {
            $email = $row['email'];
            $stmtNotifica->bind_param("sss", $titolo, $contenuto, $email);
            $stmtNotifica->execute();
        }
    }
    
    

    function getTipologieOrdini() {
        $stmt = $this->db->prepare("SELECT titolo FROM stato_ordine");
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tipologie = [];
        while ($row = $result->fetch_assoc()) {
            $tipologie[] = $row['titolo'];
        }
    
        return $tipologie;
    }
    
    function getTipologiaByNome($nome) {
        $stmt = $this->db->prepare("
            SELECT
                tipologia_prodotto.nome,
                tipologia_prodotto.descrizione,
                caratteristica_prodotto.codice,
                caratteristica_prodotto.nome as caratteristica_prodotto_nome,
                caratteristica_prodotto.descrizione as caratteristica_prodotto_descrizione
            FROM tipologia_prodotto
            LEFT JOIN caratteristica_prodotto
            ON tipologia_prodotto.nome = caratteristica_prodotto.tipologia
            WHERE tipologia_prodotto.nome = ?
        ");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $tipologia = null;
    
        while ($row = $result->fetch_assoc()) {
            if ($tipologia === null) {
                // Inizializza la tipologia con le informazioni principali
                $tipologia = [
                    'nome' => $row['nome'],
                    'descrizione' => $row['descrizione'],
                    'caratteristiche' => []
                ];
            }
    
            // Aggiungi la caratteristica solo se esiste
            if ($row['codice'] !== null) {
                $tipologia['caratteristiche'][] = [
                    'codice' => $row['codice'],
                    'nome' => $row['caratteristica_prodotto_nome'],
                    'descrizione' => $row['caratteristica_prodotto_descrizione'],
                ];
            }
        }
    
        return $tipologia;
    }

    function modificaOrdine($codiceOrdine, $dataOraArrivo, $statoOrdine){
        $stmt = $this->db->prepare("UPDATE ordine SET dataOraArrivo=?, stato=? WHERE codice= ?");
        $stmt->bind_param("sss", $dataOraArrivo,$statoOrdine, $codiceOrdine);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true; // Modifica riuscita
        } else {
            return "Nessuna modifica effettuata.";
        }
    }


    public function eliminaMarca($codice) {
        $query = "DELETE FROM marca WHERE codice = ?";
        $stmt = $this->db->prepare($query);

        $stmt->bind_param("i", $codice);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }

    public function modificaMarca($codice, $titolo) {
        $query = "UPDATE marca SET titolo = ? WHERE codice = ?";
        $stmt = $this->db->prepare($query);

        $stmt->bind_param("si", $titolo, $codice);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }

    public function creaNuovaMarca($titolo) {
        $stmt = $this->db->prepare("INSERT INTO marca (titolo) VALUES (?)");
        if ($stmt) {
            $stmt->bind_param("s", $titolo);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new Exception("Preparazione della query fallita: " . $this->db->error);
        }
    }


    /*Carrello*/
    public function getProdottiCarrello($emailUtente){
        $stmt = $this->db->prepare("
            SELECT 
                p.codice AS codice,
                p.nome AS nome, 
                p.prezzo AS prezzo, 
                CONCAT(?, MIN(i.percorso)) AS immagine, 
                c.quantita AS quantita 
            FROM carrello AS c
            JOIN prodotto AS p ON c.prodotto = p.codice
            LEFT JOIN immagine_prodotto AS i ON p.codice = i.prodotto
            WHERE c.utente = ?
            GROUP BY p.codice
        ");
        $uploadDir= UPLOAD_DIR;
        $stmt->bind_param("ss", $uploadDir, $emailUtente);
    
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }    

    public function aggiungiProdottoCarrello($codice_prodotto, $email_utente) {
        $query = "
            INSERT INTO carrello (utente, prodotto, quantita) 
            VALUES (?, ?, 1)
            ON DUPLICATE KEY UPDATE quantita = quantita + 1
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ss", $email_utente, $codice_prodotto);
        $stmt->execute();
    }

    public function eliminaProdottoCarrello($codice, $email){
        $queryDelete = "DELETE FROM carrello WHERE utente = ? AND prodotto = ?";
        $stmtDelete = $this->db->prepare($queryDelete);
        $stmtDelete->bind_param("ss", $email,$codice);
        $stmtDelete->execute();
    }

    public function aggiornaQuantitaProdottoCarrello($codice, $quantita, $email) {
        $query = "UPDATE carrello 
            SET quantita = ? 
            WHERE utente = ? AND prodotto = ?
        ";
    
        $stmt = $this->db->prepare($query);
    
        $stmt->bind_param("iss", $quantita, $email, $codice);
    
        $stmt->execute();
    }

    public function svuotaCarrello($email){
        $queryDelete = "DELETE FROM carrello WHERE utente = ?";
        $stmtDelete = $this->db->prepare($queryDelete);
        $stmtDelete->bind_param("s", $email,);
        $stmtDelete->execute();
    }

    public function aggiungiOrdine($prodotti) {
        $emailUtente = $_SESSION["email"];
        $dataOraAttuale = date('Y-m-d H:i:s');
        $dataArrivo = date('Y-m-d H:i:s', strtotime('+5 days'));
    
        try {
            $this->db->begin_transaction();
    
            $queryOrdine = "INSERT INTO ordine (dataPartenza, dataOraArrivo, utente, stato) 
                            VALUES (?, ?, ?, ?)";
            $stmtOrdine = $this->db->prepare($queryOrdine);
            $stato = "In elaborazione";
            $stmtOrdine->bind_param("ssss", $dataOraAttuale, $dataArrivo, $emailUtente, $stato);
            $stmtOrdine->execute();
    
            $idOrdine = $this->db->insert_id;
    
            $queryProdottiOrdine = "INSERT INTO prodotti_ordine (ordine, prodotto, quantita) 
                                    VALUES (?, ?, ?)";
            $stmtProdottiOrdine = $this->db->prepare($queryProdottiOrdine);
    
            foreach ($prodotti as $codiceProdotto => $datiProdotto) {
                $quantita = intval($datiProdotto['quantita']);
                $stmtProdottiOrdine->bind_param("isi", $idOrdine, $codiceProdotto, $quantita);
                $stmtProdottiOrdine->execute();
            }
    
            $this->db->commit();
    
            $stmtOrdine->close();
            $stmtProdottiOrdine->close();
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }
    
    
}
?>
