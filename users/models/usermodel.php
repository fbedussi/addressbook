<?php
class InvalidId extends LogicException {}

class User
{
    protected $db;
    protected $name;
    protected $password;
    protected $userId;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllUsers() {
        return $this->db->query("SELECT * FROM userlist");
    }
    
    public function getUser($userId)
    {
        $result = $this->db->query("SELECT * FROM userlist WHERE id=$userId")->fetch(PDO::FETCH_OBJ);
        if ($result) {
            $this->userId = $userId;
            $this->name = $result->name;
            $this->password = $result->pwd;
        } else {
            throw new InvalidId("Invalid ID");
        }
    }
    
    public function getUserId() {
        return $this->userId;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function deleteUser($userId)
    {
        $this->db->query("DELETE FROM userlist WHERE id=$userId");
    }
    
    public function insertUser($name,$pwd)
    {
        
//verificare che non esista già un utente con quel nome

        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO userlist (name, pwd) VALUES (:name, :pwd)");
        $stmt->execute(array('name' => $name, 'pwd' => $pwd));
    }
    
    public function updateUser($id,$name,$pwd) {
        $this->db->query("UPDATE userlist SET name='$name',pwd='$pwd' WHERE id='$id'");
    }
    
    public function getUserPwdHash($name)
    {
        $stmt = $this->db->prepare("SELECT pwd FROM userlist WHERE (name = :name)");
        $stmt->execute(array('name' => $name));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['pwd'];
    }
    
    public function isAdministrator($name)
    {
        $stmt = $this->db->prepare("SELECT role FROM userlist WHERE (name = :name)");
        $stmt->execute(array('name' => $name));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result['role'] == "admin") ? true : false;
    }

}
?>