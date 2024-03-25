<?php
/*
 * Database Class
 * Used PHP PDO class
 * Connect, Prepare sql statement, Bind values, Return data
 */
class Database
{

  private $hostname = DB_HOST;
  private $username = DB_USER;
  private $passwd = DB_PSWD;
  private $dbname = DB_NAME;

  private $dbh;
  private $stmt;
  private $error;
  // private $constat = false;
  private $sqlquery;

  final public function __construct()
  {
    $dbsn = 'mysql:host=' . $this->hostname . ';dbname=' . $this->dbname;      // Set Database Source Name  

    try {
      $this->dbh = new PDO($dbsn, $this->username, $this->passwd);       // create Database Handler
      $this->dbh->setAttribute(PDO::ATTR_PERSISTENT, true);
      $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);   // PDO::FETCH_ASSOC , PDO::FETCH_OBJ
      // $this->constat = true;
    } catch (PDOException $e) {
      $this->error = $e->getMessage();
      // $this->constat = false;
      error_log(date('D d-M-Y H:i:s e | ') . "Database8: {$this->error}" . PHP_EOL, 3, APPROOT . '/logs/error.log');
      // echo ($this->error);
      // $this->error = "My Error Message";
      // header('location: http://localhost/Test/mySys03/app/views/error.php?msg=hi');
    }
  }

  public function __destruct()
  {
    $this->disconnect();
  }

  public function disconnect()
  {
    unset($this->dbh);
    unset($this->stmt);
    // $this->stmt = null;
    // $this->constat = false;
  }

  public function getError()
  {
    return $this->error;
  }

  public function isConnected()
  {
    if (!empty($this->dbh)) {
      return true;
    }
    return false;
    // return $this->constat;
  }

  // setQuery
  public function setQuery($query)
  {
    $this->stmt = $this->dbh->prepare($query);
    if (!$this->stmt) {
      return false;
    }
  }
  // exeQuery
  public function execute()
  {
    return $this->stmt->execute();
  }
  // runGetOne
  public function getRow()
  {
    // $this->execute();
    return $this->stmt->fetch();
  }
  // runGetAll
  public function getRows()
  {
    // $this->execute();
    return $this->stmt->fetchAll();
  }

  public function bind($param, $value, $type = null)
  {
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
    $this->stmt->bindValue($param, $value, $type);
  }

  public function rowCount()
  {
    return $this->stmt->rowCount();
  }

  public function lastId()
  {
    return $this->dbh->lastInsertId();
  }

  public function fetchMode($fmode = PDO::FETCH_ASSOC)
  {        // set fetch mode = PDO::FETCH_ASSOC , PDO::FETCH_OBJ, ect..
    $this->stmt->setFetchMode($fmode);
  }

  public function debugDumpParams()
  {
    return $this->stmt->debugDumpParams();
  }

  public function beginTransaction()
  {
    return $this->dbh->beginTransaction();
  }

  public function endTransaction()
  {
    return $this->dbh->commit();
  }

  public function cancelTransaction()
  {
    return $this->dbh->rollBack();
  }

  public function inTransaction()
  {
    return $this->dbh->inTransaction();
  }

  ///////////////////////////////////////////////////////////////
  public function bindAll($pararray, $sqlquery)
  {
    //print_r($pararray);	echo "<br>";
    if (is_array($pararray)) {
      //echo "array<br/>";
      if (array_keys($pararray) !== range(0, count($pararray) - 1)) {
        //echo " associative array<br/>";
        $pid = ':paraid';
        foreach ($pararray as $key => $val) {
          $pid = ":" . $key;
          if (strstr($sqlquery, $pid)) {
            $this->bind($pid, $val);
            // echo $pid." => ".$val."<br/>";
          }
          //  else {
          //   throw new Exception('Parameter array key not found in query');
          // }
        }
      } else {
        throw new Exception('Parameter array is not associative');
      }
    } else {
      throw new Exception('Parameter array not valied');
    }
  }

  public function getResults($option)
  {
    switch ($option) {
      case 1:
        return $this->getRow();     // user for 'select', 'show' sql commands
        break;
      case 2:
        return $this->getRows();    // user for 'select', 'show' sql commands
        break;
      case 3:
        return $this->rowCount();   // used for 'insert', 'update', 'delete' sql commands
        break;
      case 4:
        return $this->lastId();   // get last saved id
        break;
        return false;
    }
  }

  public function runQuery($query, $parameters = [])
  {
    $sqlquery = trim($query);
    $this->setQuery($sqlquery);

    try {
      $this->bindAll($parameters, $sqlquery);

      if ($this->execute()) {
        return true;
      } else {
        throw new Exception('SQL query execution failed');
      }
    } catch (Exception $er) {
      $this->error = $er->getMessage();
      error_log(date('D d-M-Y H:i:s e | ') . "Database: {$this->error}" . PHP_EOL, 3, APPROOT . '/logs/error.log');
      return false;
    }
  }
  /*
    public function getResults($option)
  {
    switch ($option) {
      case 1:
        return $this->getRow();
        break;
      case 2:
        return $this->getRows();
        break;
      case 3:
        return $this->rowCount();
        break;
      default: {
          $queryToken = explode(" ", $this->sqlquery, 2);
          $token = strtolower($queryToken[0]);
          switch ($token) {
            case "select":
            case "show":
              // echo "select or show<br/>\n";
              return $this->getRows();
              break;
            case "insert":
            case "update":
            case "delete":
              // echo "insert or update or delete<br/>\n";
              return $this->rowCount();
              break;
            default:
              return false;
          } 
        }
    }
  }
  
  public function runQuery($query, $parameters = [], $returnType)
  {
    $this->sqlquery = trim($query);
    $this->setQuery($this->sqlquery);

    try {
      if (is_array($parameters)) {
        //echo "array<br/>";
        if (array_keys($parameters) !== range(0, count($parameters) - 1)) {
          //echo " associative array<br/>";
          $th = ':tblheader';
          foreach ($parameters as $key => $val) {
            $th = ":" . $key;
            if (strstr($this->sqlquery, $th)) {
              $this->bind($th, $val);
              // echo $th." => ".$val."<br/>";
            } else {
              throw new Exception('Parameter array key not found in query');
            }
          }
        } else {
          throw new Exception('Parameter array is not associative');
        }
      } else {
        throw new Exception('Parameter array not valied');
      }

      if ($this->execute()) {
        return $this->getResults($returnType);
      } else {
        throw new Exception('SQL query execution failed');
      }
    } catch (Exception $er) {
      $this->error = $er->getMessage();
      error_log(date('D d-M-Y H:i:s e | ') . 'Database: ' . $this->error . PHP_EOL, 3, APPROOT . '/logs/error.log');
      return false;
    }
  }
  */
}
