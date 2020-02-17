<?php
  class MySQLiDB
  {
    private $Host;
    private $Port;
    private $Username;
    private $Password;
    private $Database;

    private $Link;
    public function GetLink() { return $this->Link; }

    public function __construct($host, $user, $pass, $db, $port = 3306)
    {
      $this->Host = $host;
      $this->Port = $port;

      $this->Username = $user;
      $this->Password = $pass;

      $this->Database = $db;

      $this->Connect();

    }
    public function Connect()
    {
      $this->Link = new mysqli($this->Host . ':' . $this->Port, $this->Username, $this->Password, $this->Database);
      //$this->Link->select_db($this->Database);
    }
    public function CloseConnection()
    {
      $this->Link->close($this->Connection);
    }

    public function Query($query)
    {
      return $this->Link->query($query);
    }
  }
?>