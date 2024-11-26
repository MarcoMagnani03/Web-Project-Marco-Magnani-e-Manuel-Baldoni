<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname){
        $this->db = new mysqli($servername, $username, $password, $dbname);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }        
    }

    public function registrazione($email, $password,$nome,$cognome,$dataNascita,$role='cliente') {
        
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
    
            $stmt = $this->db->prepare("INSERT INTO utente (email, password, nome, cognome, dataDiNascita, ruolo, salt) VALUES (?, ?, ?, ?, ?, ?,?)");
        
            $stmt->bind_param('sssssss', $email, $password, $nome, $cognome, $dataNascita, $role,$random_salt);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                return false;
            }
        }
    }        

    // public function login($email,$password){
    //     $stmt = $this->db->prepare("SELECT * FROM utente WHERE email = ?");
    //     $stmt->bind_param('s', $email);
    //     $stmt->execute();
    //     $result = $stmt->get_result();

    //     if ($result->num_rows > 0) {
    //         $utente = $result->fetch_assoc();

    //         if (password_verify($password, $utente['password'])) {
    //             return $utente; 
    //         } else {
    //             return null;  
    //         }
    //     } else {
    //         return null; 
    //     }
    // }

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
        // Verifica che tutte le variabili di sessione siano impostate correttamente
        if(isset($_SESSION['email'], $_SESSION['login_string'])) {
          $login_string = $_SESSION['login_string'];
          $email = $_SESSION['email'];     
          $user_browser = $_SERVER['HTTP_USER_AGENT']; // reperisce la stringa 'user-agent' dell'utente.
          if ($stmt = $this->db->prepare("SELECT password FROM utente WHERE email = ? LIMIT 1")) { 
             $stmt->bind_param('i', $email); // esegue il bind del parametro '$user_id'.
             $stmt->execute(); // Esegue la query creata.
             $stmt->store_result();
      
             if($stmt->num_rows == 1) { // se l'utente esiste
                $stmt->bind_result($password); // recupera le variabili dal risultato ottenuto.
                $stmt->fetch();
                $login_check = hash('sha512', $password.$user_browser);
                if($login_check == $login_string) {
                   // Login eseguito!!!!
                   return true;
                } else {
                   //  Login non eseguito
                   return false;
                }
             } else {
                 // Login non eseguito
                 return false;
             }
          } else {
             // Login non eseguito
             return false;
          }
        } else {
          // Login non eseguito
          return false;
        }
     }

	public function getProdotti(){
		$stmt = $this->db->prepare("SELECT * FROM prodotto");
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	public function getTipologieProdotti(){
		$stmt = $this->db->prepare("SELECT * FROM tipologia_prodotto");
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->fetch_all(MYSQLI_ASSOC);
	}

    public function getProdotto($codice_prodotto){
		$stmt = $this->db->prepare("SELECT * FROM prodotto WHERE codice = ?");
		$stmt->bind_param('i', $codice_prodotto);
		$stmt->execute();
		$result_prodotto = $stmt->get_result();
		return $result_prodotto->fetch_all(MYSQLI_ASSOC);
	}

    public function getSpecificheProdotto($codice_prodotto){
        $stmt = $this->db->prepare("SELECT * FROM specifica_prodotto INNER JOIN caratteristica_prodotto ON specifica_prodotto.caratteristica = caratteristica_prodotto.codice WHERE prodotto = ?");
		$stmt->bind_param('i', $codice_prodotto);
		$stmt->execute();
		$result_specifiche = $stmt->get_result();
		return $result_specifiche->fetch_all(MYSQLI_ASSOC);
    }

	public function getRecensioniForProdotto($codice_prodotto){
        $stmt = $this->db->prepare("SELECT * FROM recensione LEFT JOIN utente ON recensione.utente = utente.email  WHERE prodotto = ?");
		$stmt->bind_param('i', $codice_prodotto);
		$stmt->execute();
		$result_recensioni = $stmt->get_result();
		return $result_recensioni->fetch_all(MYSQLI_ASSOC);
    }

    public function getNotificheUtente($email_utente){
        $stmt = $this->db->prepare("SELECT * FROM notifica WHERE utenteEmail = ?");
        $stmt->bind_param('s',$email_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
