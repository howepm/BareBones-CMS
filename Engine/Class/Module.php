<?php
  class Module
  {
    private $Name;
    private $Path;
    private $Info;
    private $Database;

    public function __construct($name, $database)
    {
      $this->Name = $name;
      $this->GetPath();
      include($this->Path . 'Info.php');
      $this->Info = $Info;
      $this->Database = $database;
    }
    public function GetPath()
    {
      if(is_dir(GLOBAL_CWD . 'Engine/Modules/' . $this->Name . '/'))
      {
        $this->Path = GLOBAL_CWD . 'Engine/Modules/' . $this->Name . '/';
      }
      else 
      {
        $this->Path = GLOBAL_CWD . 'Engine/Modules/ModuleNotFound/';
      }
      return $this->Path;
    }

    public function GetOutput()
    {
      include($this->Path . 'Output.php');
      return $Output;
    }
  }
?>