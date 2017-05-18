<?php 

class Database{
    public $isConn;
    protected $DB;
    
    // connect to db
    public function __construct($username = "root", $password = "root", $host = "localhost", $dbname = "rc20", $options = []){
        $this->isConn = TRUE;
        try {
            $this->DB = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);
            $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->DB->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
        
    }
    
    // disconnect from db
    public function Disconnect(){
        $this->DB = NULL;
        $this->isConn = FALSE;
    }
    // get row
    public function getRow($query, $params = []){
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    // get rows
    public function getRows($query, $params = []){
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    // insert row
    public function insert($query, $params = []){
        try {
            $stmt = $this->DB->prepare($query);
            $stmt->execute($params);
            return TRUE;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function getNewID()
    {
        return $this->DB->lastInsertId();
    }
    // update row
    public function update($query, $params = []){
        $this->insert($query, $params);
    }
    // delete row
    public function delete($query, $params = []){
        $this->insert($query, $params);
    }
}

?>