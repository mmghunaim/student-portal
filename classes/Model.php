<?php
abstract class Model{
  private $dbh;//database host // database handlle
  private $statement;

  public function __construct(){
    try {
      $this->dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
      $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
  }
  public function getStatement(){
    return $this->statement;
  }
  public function query($query){
		$this->statement = $this->dbh->prepare($query);
	}
	public function bind($placeholder, $value, $type = null){
 		if (is_null($type)) {
  			switch (true) {
    			case is_int($value):
      				$type = PDO::PARAM_INT;
      				break;
    			case is_bool($value):
      				$type = PDO::PARAM_BOOL;
      				break;
    			case is_null($value):
      				$type = PDO::PARAM_NULL;
      				break;
    				default:
      				$type = PDO::PARAM_STR;
  			}
		}
		$this->statement->bindValue($placeholder, $value, $type);
	}
  public function execute(){
    $this->statement->execute();
  }
  public function resultSet(){
    $this->execute();
    return $this->statement->fetchAll(PDO::FETCH_ASSOC);
  }
  public function lastInsertId(){
    return $this->dbh->lastInsertId();
  }
  public function single(){
    $this->execute();
		return $this->statement->fetch(PDO::FETCH_ASSOC);
  }
}
?>
