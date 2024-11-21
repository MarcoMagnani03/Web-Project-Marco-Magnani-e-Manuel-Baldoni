<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname){
        $this->db = new mysqli($servername, $username, $password, $dbname);
        if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
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

            //PASSWORD ADMIN SuperSicura123!

            if (password_verify($password, $utente['password'])) {
                return $utente; 
            } else {
                return null;  
            }
        } else {
            return null; 
        }
    }
}
?>

