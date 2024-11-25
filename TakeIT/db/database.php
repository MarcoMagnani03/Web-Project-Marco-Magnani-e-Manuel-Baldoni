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
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            $stmt = $this->db->prepare("INSERT INTO utente (email, password, nome, cognome, dataDiNascita, ruolo) VALUES (?, ?, ?, ?, ?, ?)");
        
            $stmt->bind_param('ssssss', $email, $hashedPassword, $nome, $cognome, $dataNascita, $role);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                return false;
            }
        }
    }        

    public function login($email,$password){
        $stmt = $this->db->prepare("SELECT * FROM utente WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $utente = $result->fetch_assoc();

            if (password_verify($password, $utente['password'])) {
                return $utente; 
            } else {
                return null;  
            }
        } else {
            return null; 
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


    public function getNotificheUtente($email_utente){
        $stmt = $this->db->preprare("SELECT * FROM notifiche WHERE utenteEmail = ?");
        $stmt->bind_param('s',$email_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

