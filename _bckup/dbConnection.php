<?php 
namespace connection;

Class Connection {

  // singleton instance 
  private static $instance; 

  // private constructor function 
  // to prevent external instantiation 
  private __construct() { 
      if (strpos(getenv('SERVER_SOFTWARE'), 'Development') === false) {
        $conn = mysqli_connect(getenv('PRODUCTION_DB_HOST'),
                               getenv('PRODUCTION_DB_USERNAME'),
                               getenv('PRODUCTION_DB_PASSWORD'),
                               getenv('PRODUCTION_CLOUD_SQL_INSTANCE'));
        $db = getenv('PRODUCTION_DB_NAME');
        echo "******production*****<br/>";
      } else {
        $conn = mysqli_connect(getenv('DEVELOPMENT_DB_HOST'), 
                               getenv('DEVELOPMENT_DB_USERNAME'),
                               getenv('DEVELOPMENT_DB_PASSWORD'));
        $db = getenv('DEVELOPMENT_DB_NAME');
        echo "******development****** <br/>";
      }
      
      if ($this->$conn->connect_error) {
        die("Could not connect to database: $conn->connect_error " .
            "[$conn->connect_errno]");
      }

      if ($this->$conn->query("CREATE DATABASE IF NOT EXISTS $db") === FALSE) {
        die("Could not create database: $conn->error [$conn->errno]");
      }

      if ($this->$conn->select_db($db) === FALSE) {
        die("Could not select database: $conn->error [$conn->errno]");
      }
  }

  private queryDb($queryString) {
    if ($this->$conn->query($queryString) === FALSE) {
        die("Could not create tables: $conn->error [$conn->errno]");
    }

    $stmt = $this->$conn->prepare("SELECT author, content FROM greeting ORDER BY id DESC LIMIT 10");
    if ($stmt->execute() === FALSE) {
        die("Could not execute prepared statement");
    }
    return $stmt;
  }

  // getInstance method 
  public static function getInstance() { 

    if(!self::$instance) { 
      self::$instance = new self(); 
    } 

    return self::$instance; 

  } 

}

?>