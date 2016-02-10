<?php
class DBEngine {
  private static $_instance=null;
  public $dbName;
  public $dbHost;
  public $dbUser;
  public $dbPassword;

  private function __construct() {}
  private function __clone() {}


  public static function getInstance($dbName=null,  $dbHost=null, $dbUser=null, $dbPass=null) {

    if (is_null(self::$_instance)) { //можно не использовать синглтон, т.к. высоконагруженное приложение может терять производительность
      try {

        self::$_instance = new DBH('mysql:host='. $dbHost.';dbname='. $dbName,  $dbUser, $dbPass,array(PDO::ATTR_PERSISTENT,PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

      } catch (PDOException $e) {
               // echo "Подключение невозможно:".$e->getMessage();
               // $this->connectLink = null;
        self::$_instance = null;
        //throw new Exception('Ошибка соединения с базой данных');
      }


    }
    return self::$_instance;
  }

    // final public function __destruct() {//используем постоянное соединение
    //     self::$_instance = null;
    // }
}
class DBH extends PDO {

  public function __construct($dsn, $username = null, $password = null, $driver_options = array(), $logger_callback = NULL)
  {
    parent::__construct($dsn, $username, $password, $driver_options);
    $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }



}
?>