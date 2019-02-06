<?php
class Database
{
    private $server;
    private $database;
    private $username;
    private $password;
    private $charset;
    protected $connection;

    public function __construct(){
      $this->server = "localhost";
      $this->database = "crud_db";
      $this->username = "joey";
      $this->password = "root";
      $this->charset = "UTF-8";

      try {

        $dsn = "mysql:host=".$this->server.";dbname".$this->database.";charset=".$this->charset;
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection = $pdo;

      } catch (PDOException $e) {
        die($e->getMessage());
      }
    }

    public function __destruct(){
      $this->connection = NULL;
    }
}

class Functions extends Database
{
  public function add($title, $description)
  {
    $stmt= $this->connection->prepare("INSERT INTO crud_db.crud_tasks (id, title, description) VALUES (?,?,?)");
    $stmt->execute([NULL, $title, $description]);
  }
  public function edit($id, $title, $description)
  {
    $stmt= $this->connection->prepare("UPDATE crud_db.crud_tasks SET id=?, title=?, description=? WHERE id=$id");
    $stmt->execute([$id, $title, $description]);
  }
  public function remove($id)
  {
    $stmt= $this->connection->prepare("DELETE FROM crud_db.crud_tasks WHERE id=$id");
    $stmt->execute();
  }
  public function fetch()
  {
      $stmt = $this->connection->prepare("SELECT * FROM crud_db.crud_tasks");
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      foreach ($result as $key=> $value) {
        echo $value['id'] . ') ' . $value['title'] . ' // ' . $value['description'] . '<br/>';
      }
  }
}
?>
